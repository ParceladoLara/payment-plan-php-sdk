<?php
/* src/Params/DownPaymentParams.php */

namespace Lara\PaymentPlan\Params;


class DownPaymentParams
{
  public float $requested_amount;
  public float $min_installment_amount;
  public \DateTimeInterface $first_payment_date;
  public int $installments;
  public Params $params;

  public function __construct(
    float $requested_amount,
    float $min_installment_amount,
    \DateTimeInterface $first_payment_date,
    int $installments,
    Params $params
  ) {
    $this->params = $params;
    $this->requested_amount = $requested_amount;
    $this->min_installment_amount = $min_installment_amount;
    $this->first_payment_date = $first_payment_date;
    $this->installments = $installments;
  }
}
