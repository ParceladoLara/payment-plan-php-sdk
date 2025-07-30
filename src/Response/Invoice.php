<?php
/* src\response\Invoice.php */

namespace Lara\PaymentPlan\Response;


class Invoice
{
  public int $accumulated_days;
  public float $factor;
  public float $accumulated_factor;
  public \DateTimeImmutable $due_date;
}
