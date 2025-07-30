<?php
/* src/internal/FFIPaymentPlan.php */

namespace Lara\PaymentPlan\Internal;

use Lara\PaymentPlan\Internal\Response\FFIResponseVec;
use Lara\PaymentPlan\Internal\Params\FFIParams;
use Lara\PaymentPlan\Internal\Params\FFIDownPaymentParams;
use Lara\PaymentPlan\Internal\Response\FFIDownPaymentResponseVec;

/**
 * @internal
 * This class is part of the internal API and should not be used directly.
 */
class FFIPaymentPlan
{

  private static ?\FFI $ffi = null;

  /**
   * Returns the path to the shared library depending on the OS.
   * @throws \RuntimeException if the OS is unsupported or the library is missing.
   */
  private static function getSharedLibraryPath(): string
  {
    $nativeDir = __DIR__ . '/native';
    switch (PHP_OS_FAMILY) {
      case 'Linux':
        $lib = $nativeDir . '/libpayment_plan.so';
        break;
      case 'Windows':
        $lib = $nativeDir . '/libpayment_plan.dll';
        break;
      default:
        throw new \RuntimeException('Unsupported OS for FFI Payment Plan');
    }
    if (!file_exists($lib)) {
      throw new \RuntimeException("Shared library not found: $lib");
    }
    return $lib;
  }

  /**
   * Returns the FFI instance, initializing it if necessary.
   * @throws \RuntimeException if the header file is missing.
   * @throws \RuntimeException if the OS is unsupported or the library is missing.
   */
  public static function getFFI(): \FFI
  {
    if (self::$ffi === null) {
      $headerPath = __DIR__ . '/native/payment_plan.h';
      if (!file_exists($headerPath)) {
        throw new \RuntimeException("Header file not found: $headerPath");
      }
      $header = file_get_contents($headerPath);
      self::$ffi = \FFI::cdef($header, self::getSharedLibraryPath());
    }
    return self::$ffi;
  }

  /**
   * Calculates the payment plan using FFI.
   *
   * @param FFIParams $params
   * @return \Lara\PaymentPlan\Response\Response[]
   *
   * @throws \RuntimeException if the FFI call fails.
   * @throws \RuntimeException if the shared library or header file is missing.
   * @throws \RuntimeException if the OS is unsupported.
   */
  public static function calculatePaymentPlan(FFIParams $params): array
  {

    $ffi = self::getFFI();

    // Allocate and populate the Params_t struct
    $cParams = $ffi->new('Params_t');
    $cParams = $params->toCData($cParams);

    // Allocate Vec_Response_t for output
    $cVecResponse = $ffi->new('Vec_Response_t');

    // Call the FFI function

    $result = $ffi->calculate_payment_plan($cParams, \FFI::addr($cVecResponse));
    if ($result !== 0) {
      throw new \RuntimeException("FFI calculate_payment_plan failed with code $result");
    }

    // Wrap the result in an FFIResponseVec object
    $responseVec = new FFIResponseVec();
    $responseVec->ptr = $cVecResponse->ptr;
    $responseVec->len = $cVecResponse->len;
    $responseVec->cap = $cVecResponse->cap;

    // Convert the response to an array
    $arr = [];
    try {
      $arr = $responseVec->toArray();
    } finally {
      // Free the allocated memory for the response vector
      // This is important to avoid memory leaks in FFI
      $ffi->free_response_vec($cVecResponse);
    }

    return $arr;
  }

  /**
   * Calculates the  down payment plan using FFI with Params object.
   *
   * @param FFIDownPaymentParams $params
   * @return \Lara\PaymentPlan\Response\DownPaymentResponse[]
   *
   * @throws \RuntimeException if the FFI call fails.
   * @throws \RuntimeException if the shared library or header file is missing.
   * @throws \RuntimeException if the OS is unsupported.
   */
  public static function calculateDownPaymentPlan(FFIDownPaymentParams $params): array
  {
    $ffi = self::getFFI();

    // Allocate and populate the DownPaymentParams_t struct
    $cDParams = $ffi->new('DownPaymentParams_t');
    $cDParams = $params->toCData($cDParams);
    if ($cDParams === null) {
      throw new \RuntimeException("Failed to create DownPaymentParams_t from FFIDownPaymentParams");
    }
    // Allocate Vec_DownPaymentResponse_t for output
    $cVecResponse = $ffi->new('Vec_DownPaymentResponse_t');

    // Call the FFI function
    $result = $ffi->calculate_down_payment_plan($cDParams, \FFI::addr($cVecResponse));
    if ($result !== 0) {
      throw new \RuntimeException("FFI calculate_down_payment_plan failed with code $result");
    }

    // Wrap the result in an FFIResponseVec object
    $responseVec = new FFIDownPaymentResponseVec();
    $responseVec->ptr = $cVecResponse->ptr;
    $responseVec->len = $cVecResponse->len;
    $responseVec->cap = $cVecResponse->cap;

    // Convert the response to an array
    $arr = [];
    try {
      $arr = $responseVec->toArray();
    } finally {
      // Free the allocated memory for the response vector
      // This is important to avoid memory leaks in FFI
      $ffi->free_down_payment_response_vec($cVecResponse);
    }

    return $arr;
  }
}
