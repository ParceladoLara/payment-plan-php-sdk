<?php
/* src/response/Response.php */

namespace Lara\PaymentPlan\Response;


class Response
{
  public int $installment;
  public \DateTimeInterface $due_date;
  public \DateTimeInterface $disbursement_date;
  public int $accumulated_days;
  public float $days_index;
  public float $accumulated_days_index;
  public float $interest_rate;
  public float $installment_amount;
  public float $installment_amount_without_tac;
  public float $total_amount;
  public float $debit_service;
  public float $customer_debit_service_amount;
  public float $customer_amount;
  public float $calculation_basis_for_effective_interest_rate;
  public float $merchant_debit_service_amount;
  public float $merchant_total_amount;
  public float $settled_to_merchant;
  public float $mdr_amount;
  public float $effective_interest_rate;
  public float $total_effective_cost;
  public float $eir_yearly;
  public float $tec_yearly;
  public float $eir_monthly;
  public float $tec_monthly;
  public float $total_iof;
  public float $contract_amount;
  public float $contract_amount_without_tac;
  public float $tac_amount;
  public float $iof_percentage;
  public float $overall_iof;
  public float $pre_disbursement_amount;
  public float $paid_total_iof;
  public float $paid_contract_amount;
  /**
   * @var Invoice[]
   */
  public array $invoices;
}
