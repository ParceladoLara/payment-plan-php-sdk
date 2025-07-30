<?php
/* src/internal/FFIDownPaymentResponse.php */

namespace Lara\PaymentPlan\Internal\Response;

use Lara\PaymentPlan\Response\DownPaymentResponse;

/**
 * @internal
 * Internal representation of DownPaymentResponse_t for FFI.
 */
class FFIDownPaymentResponseVec
{

  /** @var \FFI\CData|FFIDownPaymentResponse  Pointer to FFIDownPaymentResponse (DownPaymentResponse_t*) */
  public $ptr;
  /** @var int */
  public int $len;
  /** @var int */
  public int $cap;

  /**
   * Convert the FFIResponseVec to an array of Response objects.
   * @return Response[]
   */
  public function toArray(): array
  {
    $responses = [];

    if ($this->ptr === null || $this->len === 0) {
      return $responses;
    }

    for ($i = 0; $i < $this->len; $i++) {
      $cResponse = $this->ptr[$i];
      $response = new DownPaymentResponse();

      $response->installment_amount = $cResponse->installment_amount;
      $response->total_amount = $cResponse->total_amount;
      $response->installment_quantity = $cResponse->installment_quantity;
      $response->first_payment_date = new \DateTimeImmutable('@' . $cResponse->first_payment_date_ms / 1000);

      if ($cResponse->plans !== null) {
        $plans = $cResponse->plans;
        $respVec = FFIResponseVec::fromCData($plans);
        $response->plans = $respVec->toArray();
      } else {
        $response->plans = [];
      }

      $responses[] = $response;
    }

    return $responses;
  }
}
