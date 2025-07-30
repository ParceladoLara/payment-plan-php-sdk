<?php
/* src/PaymentPlan.php */

namespace Lara\PaymentPlan;

use Lara\PaymentPlan\Internal\FFIPaymentPlan;
use Lara\PaymentPlan\Internal\Params\FFIParams;
use Lara\PaymentPlan\Internal\Params\FFIDownPaymentParams;

use Lara\PaymentPlan\Params\Params;
use Lara\PaymentPlan\Params\DownPaymentParams;

use Lara\PaymentPlan\Response\Response;
use Lara\PaymentPlan\Response\DownPaymentResponse;


class PaymentPlan
{
  /**
   * Calculates the payment plan using FFI.
   *
   * @param Params $params The parameters for the payment plan calculation.
   * @return Response[]
   *
   * @throws \RuntimeException if the FFI call fails.
   * @throws \RuntimeException if the shared library or header file is missing.
   * @throws \RuntimeException if the OS is unsupported.
   */
  public static function calculate(Params $params): array
  {
    $ffiParams = FFIParams::fromParams($params);
    return FFIPaymentPlan::calculatePaymentPlan($ffiParams);
  }

  /**
   * Calculates the down payment plan using FFI with Params object.
   * @param DownPaymentParams $params
   * @return DownPaymentResponse[]
   *
   * @throws \RuntimeException if the FFI call fails.
   * @throws \RuntimeException if the shared library or header file is missing.
   * @throws \RuntimeException if the OS is unsupported.
   */
  public static function calculateDownPayment(DownPaymentParams $params): array
  {
    $ffiParams = FFIDownPaymentParams::fromParams($params);
    return FFIPaymentPlan::calculateDownPaymentPlan($ffiParams);
  }
}
