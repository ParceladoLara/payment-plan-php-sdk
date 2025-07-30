<?php
/* src/Params/Params.php */

namespace Lara\PaymentPlan\Params;

class Params
{
  public float $requested_amount;
  public \DateTimeInterface $first_payment_date;
  public \DateTimeInterface $disbursement_date;
  public int $installments;
  public int $debit_service_percentage;
  public float $mdr;
  public float $tac_percentage;
  public float $iof_overall;
  public float $iof_percentage;
  public float $interest_rate;
  public float $min_installment_amount;
  public float $max_total_amount;
  public bool $disbursement_only_on_business_days;

  public function __construct(
    float $requested_amount,
    \DateTimeInterface $first_payment_date,
    \DateTimeInterface $disbursement_date,
    int $installments,
    int $debit_service_percentage,
    float $mdr,
    float $tac_percentage,
    float $iof_overall,
    float $iof_percentage,
    float $interest_rate,
    float $min_installment_amount,
    float $max_total_amount,
    bool $disbursement_only_on_business_days
  ) {
    $this->requested_amount = $requested_amount;
    $this->first_payment_date = $first_payment_date;
    $this->disbursement_date = $disbursement_date;
    $this->installments = $installments;
    $this->debit_service_percentage = $debit_service_percentage;
    $this->mdr = $mdr;
    $this->tac_percentage = $tac_percentage;
    $this->iof_overall = $iof_overall;
    $this->iof_percentage = $iof_percentage;
    $this->interest_rate = $interest_rate;
    $this->min_installment_amount = $min_installment_amount;
    $this->max_total_amount = $max_total_amount;
    $this->disbursement_only_on_business_days = $disbursement_only_on_business_days;
  }
}
