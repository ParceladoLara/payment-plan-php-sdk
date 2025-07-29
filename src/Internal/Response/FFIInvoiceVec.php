<?php
/* src/internal/FFIInvoiceVec.php */

namespace Lara\PaymentPlan\Internal\Response;

use Lara\PaymentPlan\Response\Invoice;

/**
 * @internal
 * Internal representation of Vec_Invoice_t for FFI.
 */
class FFIInvoiceVec
{
  /** @var \FFI\CData|FFIInvoice Pointer to FFIInvoice (Invoice_t*) */
  public $ptr;
  /** @var int */
  public int $len;
  /** @var int */
  public int $cap;

  /**
   * Convert the FFIInvoiceVec to an array of Invoice objects.
   * @return Invoice[]
   */
  public function toArray(): array
  {
    $invoices = [];
    if ($this->ptr === null || $this->len === 0) {
      return $invoices;
    }
    for ($i = 0; $i < $this->len; $i++) {
      $cInvoice = $this->ptr[$i];
      $invoice = new Invoice();
      $invoice->accumulated_days = $cInvoice->accumulated_days;
      $invoice->factor = $cInvoice->factor;
      $invoice->accumulated_factor = $cInvoice->accumulated_factor;
      $invoice->due_date_ms = $cInvoice->due_date_ms;
      $invoices[] = $invoice;
    }
    return $invoices;
  }
}
