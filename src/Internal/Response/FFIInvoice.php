<?php
/* src/internal/FFIInvoice.php */

namespace Lara\PaymentPlan\Internal\Response;

/**
 * @internal
 * Internal representation of Invoice_t for FFI.
 */
class FFIInvoice
{
  public int $accumulated_days;
  public float $factor;
  public float $accumulated_factor;
  public int $due_date_ms;
}
