<?php
/* src\response\DownPaymentResponse.php */

namespace Lara\PaymentPlan\Response;

use DateTimeImmutable;

class DownPaymentResponse
{
  public float $installmentAmount;
  public float $totalAmount;
  public int $installmentQuantity;
  public DateTimeImmutable $firstPaymentDate;
  /**
   * @var Response[]
   */
  public array $plans;
}
