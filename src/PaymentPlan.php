<?php
/* src/PaymentPlan.php */

namespace Lara\PaymentPlan;

use Lara\PaymentPlan\Internal\FFIPaymentPlan;
use Lara\PaymentPlan\Params\Params;
use Lara\PaymentPlan\Internal\Params\FFIParams;

class PaymentPlan
{
  /**
   * Calculates the payment plan using FFI.
   *
   * @param Params $params The parameters for the payment plan calculation.
   * @return \Lara\PaymentPlan\Response\Response[]
   *
   * @throws \RuntimeException if the FFI call fails.
   * @throws \RuntimeException if the shared library or header file is missing.
   * @throws \RuntimeException if the OS is unsupported.
   */
  public static function calculate(Params $params): array
  {
    $ffiParams = FFIParams::fromParams($params);
    return FFIPaymentPlan::calculatePaymentPlan($ffiParams);
  }
}
