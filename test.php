<?php
require __DIR__ . '/vendor/autoload.php';

use Lara\PaymentPlan\Params\Params;
use  Lara\PaymentPlan\PaymentPlan;


// Create a Params object with sample data
$params = new Params(
  8800.0, // requested_amount
  new DateTimeImmutable('2022-04-18'), // first_payment_date
  new DateTimeImmutable('2022-03-18'), // disbursement_date
  24,     // installments
  0,      // debit_service_percentage
  0.05,   // mdr
  0.0,    // tac_percentage
  0.0038, // iof_overall
  0.000082, // iof_percentage
  0.0235, // interest_rate
  100.0,   // min_installment_amount
  100000000000, // max_total_amount
  false    // disbursement_only_on_business_days
);

$result = PaymentPlan::calculate($params);

print_r($result);
