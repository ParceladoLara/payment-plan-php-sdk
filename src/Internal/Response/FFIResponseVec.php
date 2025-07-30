<?php
/* src/internal/FFIResponseVec.php */

namespace Lara\PaymentPlan\Internal\Response;

use Lara\PaymentPlan\Response\Response;

/**
 * @internal
 * Internal representation of Vec_Response_t for FFI.
 */
class FFIResponseVec
{
  /** @var \FFI\CData|FFIResponse  Pointer to FFIResponse (Response_t*) */
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
      /** @var FFIResponse $cResponse */
      $cResponse = $this->ptr[$i];
      $response = new Response();

      $response->installment = $cResponse->installment;
      $response->due_date = new \DateTimeImmutable('@' . $cResponse->due_date_ms / 1000);
      $response->disbursement_date = new \DateTimeImmutable('@' . $cResponse->disbursement_date_ms / 1000);
      $response->accumulated_days = $cResponse->accumulated_days;
      $response->days_index = $cResponse->days_index;
      $response->accumulated_days_index = $cResponse->accumulated_days_index;
      $response->interest_rate = $cResponse->interest_rate;
      $response->installment_amount = $cResponse->installment_amount;
      $response->installment_amount_without_tac = $cResponse->installment_amount_without_tac;
      $response->total_amount = $cResponse->total_amount;
      $response->debit_service = $cResponse->debit_service;
      $response->customer_debit_service_amount = $cResponse->customer_debit_service_amount;
      $response->customer_amount = $cResponse->customer_amount;
      $response->calculation_basis_for_effective_interest_rate = $cResponse->calculation_basis_for_effective_interest_rate;
      $response->merchant_debit_service_amount = $cResponse->merchant_debit_service_amount;
      $response->merchant_total_amount = $cResponse->merchant_total_amount;
      $response->settled_to_merchant = $cResponse->settled_to_merchant;
      $response->mdr_amount = $cResponse->mdr_amount;
      $response->effective_interest_rate = $cResponse->effective_interest_rate;
      $response->total_effective_cost = $cResponse->total_effective_cost;
      $response->eir_yearly = $cResponse->eir_yearly;
      $response->tec_yearly = $cResponse->tec_yearly;
      $response->eir_monthly = $cResponse->eir_monthly;
      $response->tec_monthly = $cResponse->tec_monthly;
      $response->total_iof = $cResponse->total_iof;
      $response->contract_amount = $cResponse->contract_amount;
      $response->contract_amount_without_tac = $cResponse->contract_amount_without_tac;
      $response->tac_amount = $cResponse->tac_amount;
      $response->iof_percentage = $cResponse->iof_percentage;
      $response->overall_iof = $cResponse->overall_iof;
      $response->pre_disbursement_amount = $cResponse->pre_disbursement_amount;
      $response->paid_total_iof = $cResponse->paid_total_iof;
      $response->paid_contract_amount = $cResponse->paid_contract_amount;

      // Handle invoices
      if ($cResponse->invoices !== null) {
        $ffiInvoiceVec = new FFIInvoiceVec();
        $ffiInvoiceVec->ptr = $cResponse->invoices->ptr;
        $ffiInvoiceVec->len = $cResponse->invoices->len;
        $ffiInvoiceVec->cap = $cResponse->invoices->cap;
        $response->invoices = $ffiInvoiceVec->toArray();
      } else {
        $response->invoices = [];
      }

      $responses[] = $response;
    }
    return $responses;
  }

  public static function fromCData(\FFI\CData $cData): self
  {
    $vec = new self();
    $vec->ptr = $cData->ptr;
    $vec->len = $cData->len;
    $vec->cap = $cData->cap;
    return $vec;
  }
}
