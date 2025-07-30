<?php
/* src\response\DownPaymentResponse.php */

namespace Lara\PaymentPlan\Response;

use DateTimeImmutable;

class DownPaymentResponse
{
  public float $installment_amount;
  public float $total_amount;
  public int $installment_quantity;
  public DateTimeImmutable $first_payment_date;
  /**
   * @var Response[]
   */
  public array $plans;
}
