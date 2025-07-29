<?php
/* src\response\Invoice.php */

namespace Lara\PaymentPlan\Response;

/**
 * @internal
 * Internal representation of Invoice_t for FFI.
 */
class Invoice
{
  public int $accumulated_days;
  public float $factor;
  public float $accumulated_factor;
  public int $due_date_ms;
}
