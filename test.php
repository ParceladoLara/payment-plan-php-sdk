<?php
require __DIR__ . '/vendor/autoload.php';

use Lara\PaymentPlan\Params\Params;
use Lara\PaymentPlan\Params\DownPaymentParams;
use  Lara\PaymentPlan\PaymentPlan;


// Create a Params object with sample data
$params = new Params(
  7800.0, // requested_amount
  new DateTimeImmutable('2025-05-03 05:00:00'), // first_payment_date
  new DateTimeImmutable('2025-04-03 05:00:00'), // disbursement_date
  4,     // installments
  0,      // debit_service_percentage
  0.05,   // mdr
  0.0,    // tac_percentage
  0.0038, // iof_overall
  0.000082, // iof_percentage
  0.0235, // interest_rate
  100.0,   // min_installment_amount
  1000000, // max_total_amount
  true    // disbursement_only_on_business_days
);

$downPaymentParams = new DownPaymentParams(
  1000.0, // requested_amount
  100.0,  // min_installment_amount
  new DateTimeImmutable('2025-05-03'), // first_payment_date
  4,       // installments
  $params
);


$dResult = PaymentPlan::calculateDownPayment($downPaymentParams);

print_r($dResult);

$result = PaymentPlan::calculate($params);

print_r($result);

/*
	baseDate := time.Date(2025, 4, 3, 0, 0, 0, 0, time.UTC)
	days := uint32(5)
  */
$disDateRange = PaymentPlan::disbursementDateRange(
  new DateTimeImmutable('2025-04-03'),
  5
);

print_r($disDateRange);

$nextDisbursementDate = PaymentPlan::nextDisbursementDate(
  new DateTimeImmutable('2025-04-03')
);

print_r($nextDisbursementDate);
