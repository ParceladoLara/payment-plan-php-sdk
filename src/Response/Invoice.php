<?php
/* src\response\Invoice.php */

namespace Lara\PaymentPlan\Response;


class Invoice
{
  public int $accumulatedDays;
  public float $factor;
  public float $accumulatedFactor;
  public \DateTimeImmutable $dueDate;
}
