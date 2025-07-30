<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Lara\PaymentPlan\Params\Params;
use Lara\PaymentPlan\PaymentPlan;
use \Lara\PaymentPlan\Response\Response;
use Lara\PaymentPlan\Response\Invoice;

class PaymentPlanTest extends TestCase
{
  public function testCalculateReturnsArrayOfResponses(): void
  {

    $expectedInvoice1 = new Invoice();
    $expectedInvoice1->accumulated_days = 28;
    $expectedInvoice1->factor = 0.981371965896169;
    $expectedInvoice1->accumulated_factor = 0.981371965896169;
    $expectedInvoice1->due_date = new DateTimeImmutable('2025-05-05');

    $expectedInvoice2 = new Invoice();
    $expectedInvoice2->accumulated_days = 57;
    $expectedInvoice2->factor = 0.958839243657051;
    $expectedInvoice2->accumulated_factor = 1.94021120955322;
    $expectedInvoice2->due_date = new DateTimeImmutable('2025-06-03');

    $expectedInvoice3 = new Invoice();
    $expectedInvoice3->accumulated_days = 87;
    $expectedInvoice3->factor = 0.936823882407599;
    $expectedInvoice3->accumulated_factor = 2.8770350919608187;
    $expectedInvoice3->due_date = new DateTimeImmutable('2025-07-03');

    $expectedInvoice4 = new Invoice();
    $expectedInvoice4->accumulated_days = 119;
    $expectedInvoice4->factor = 0.914302133077605;
    $expectedInvoice4->accumulated_factor = 3.791337225038424;
    $expectedInvoice4->due_date = new DateTimeImmutable('2025-08-04');

    $expected1 = new Response();
    $expected1->installment = 1;
    $expected1->due_date = new DateTimeImmutable('2025-05-05');
    $expected1->disbursement_date = new DateTimeImmutable('2025-04-07');
    $expected1->accumulated_days = 28;
    $expected1->days_index = 0.981371965896169;
    $expected1->accumulated_days_index = 0.981371965896169;
    $expected1->interest_rate = 0.0235;
    $expected1->installment_amount = 7996.8;
    $expected1->installment_amount_without_tac = 0.0;
    $expected1->total_amount = 7996.8;
    $expected1->debit_service = 148.96000000000018;
    $expected1->customer_debit_service_amount = 148.96000000000018;
    $expected1->customer_amount = 7996.8;
    $expected1->calculation_basis_for_effective_interest_rate = 7948.96;
    $expected1->merchant_debit_service_amount = 0.0;
    $expected1->merchant_total_amount = 390.0;
    $expected1->settled_to_merchant = 7410.0;
    $expected1->mdr_amount = 390.0;
    $expected1->effective_interest_rate = 0.0206;
    $expected1->total_effective_cost = 0.0274;
    $expected1->eir_yearly = 0.277782;
    $expected1->tec_yearly = 0.383782;
    $expected1->eir_monthly = 0.0206;
    $expected1->tec_monthly = 0.0274;
    $expected1->total_iof = 47.84;
    $expected1->contract_amount = 7847.84;
    $expected1->contract_amount_without_tac = 0.0;
    $expected1->tac_amount = 0.0;
    $expected1->iof_percentage = 8.2e-5;
    $expected1->overall_iof = 0.0038;
    $expected1->pre_disbursement_amount = 7800.0;
    $expected1->paid_total_iof = 47.84;
    $expected1->paid_contract_amount = 7847.84;
    $expected1->invoices = [$expectedInvoice1];

    $expected2 = new Response();
    $expected2->installment = 2;
    $expected2->due_date = new DateTimeImmutable('2025-06-03');
    $expected2->disbursement_date = new DateTimeImmutable('2025-04-07');
    $expected2->accumulated_days = 57;
    $expected2->days_index = 0.958839243657051;
    $expected2->accumulated_days_index = 1.94021120955322;
    $expected2->interest_rate = 0.0235;
    $expected2->installment_amount = 4049.72;
    $expected2->installment_amount_without_tac = 0.0;
    $expected2->total_amount = 8099.44;
    $expected2->debit_service = 242.1299999999996;
    $expected2->customer_debit_service_amount = 242.1299999999996;
    $expected2->customer_amount = 4049.72;
    $expected2->calculation_basis_for_effective_interest_rate = 4021.0649999999996;
    $expected2->merchant_debit_service_amount = 0.0;
    $expected2->merchant_total_amount = 390.0;
    $expected2->settled_to_merchant = 7410.0;
    $expected2->mdr_amount = 390.0;
    $expected2->effective_interest_rate = 0.022;
    $expected2->total_effective_cost = 0.0274;
    $expected2->eir_yearly = 0.298378;
    $expected2->tec_yearly = 0.382981;
    $expected2->eir_monthly = 0.022;
    $expected2->tec_monthly = 0.0274;
    $expected2->total_iof = 57.31;
    $expected2->contract_amount = 7857.31;
    $expected2->contract_amount_without_tac = 0.0;
    $expected2->tac_amount = 0.0;
    $expected2->iof_percentage = 8.2e-5;
    $expected2->overall_iof = 0.0038;
    $expected2->pre_disbursement_amount = 7800.0;
    $expected2->paid_total_iof = 57.31;
    $expected2->paid_contract_amount = 7857.31;
    $expected2->invoices = [$expectedInvoice1, $expectedInvoice2];

    $expected3 = new Response();
    $expected3->installment = 3;
    $expected3->due_date = new DateTimeImmutable('2025-07-03');
    $expected3->disbursement_date = new DateTimeImmutable('2025-04-07');
    $expected3->accumulated_days = 87;
    $expected3->days_index = 0.936823882407599;
    $expected3->accumulated_days_index = 2.8770350919608187;
    $expected3->interest_rate = 0.0235;
    $expected3->installment_amount = 2734.44;
    $expected3->installment_amount_without_tac = 0.0;
    $expected3->total_amount = 8203.32;
    $expected3->debit_service = 336.2299999999997;
    $expected3->customer_debit_service_amount = 336.2299999999997;
    $expected3->customer_amount = 2734.44;
    $expected3->calculation_basis_for_effective_interest_rate = 2712.0766666666664;
    $expected3->merchant_debit_service_amount = 0.0;
    $expected3->merchant_total_amount = 390.0;
    $expected3->settled_to_merchant = 7410.0;
    $expected3->mdr_amount = 390.0;
    $expected3->effective_interest_rate = 0.0225;
    $expected3->total_effective_cost = 0.0272;
    $expected3->eir_yearly = 0.306592;
    $expected3->tec_yearly = 0.380434;
    $expected3->eir_monthly = 0.0225;
    $expected3->tec_monthly = 0.0272;
    $expected3->total_iof = 67.09;
    $expected3->contract_amount = 7867.09;
    $expected3->contract_amount_without_tac = 0.0;
    $expected3->tac_amount = 0.0;
    $expected3->iof_percentage = 8.2e-5;
    $expected3->overall_iof = 0.0038;
    $expected3->pre_disbursement_amount = 7799.99;
    $expected3->paid_total_iof = 67.08;
    $expected3->paid_contract_amount = 7867.08;
    $expected3->invoices = [$expectedInvoice1, $expectedInvoice2, $expectedInvoice3];

    $expected4 = new Response();
    $expected4->installment = 4;
    $expected4->due_date = new DateTimeImmutable('2025-08-04');
    $expected4->disbursement_date = new DateTimeImmutable('2025-04-07');
    $expected4->accumulated_days = 119;
    $expected4->days_index = 0.914302133077605;
    $expected4->accumulated_days_index = 3.791337225038424;
    $expected4->interest_rate = 0.0235;
    $expected4->installment_amount = 2077.73;
    $expected4->installment_amount_without_tac = 0.0;
    $expected4->total_amount = 8310.92;
    $expected4->debit_service = 433.56000000000006;
    $expected4->customer_debit_service_amount = 433.56000000000006;
    $expected4->customer_amount = 2077.73;
    $expected4->calculation_basis_for_effective_interest_rate = 2058.39;
    $expected4->merchant_debit_service_amount = 0.0;
    $expected4->merchant_total_amount = 390.0;
    $expected4->settled_to_merchant = 7410.0;
    $expected4->mdr_amount = 390.0;
    $expected4->effective_interest_rate = 0.0228;
    $expected4->total_effective_cost = 0.0271;
    $expected4->eir_yearly = 0.310455;
    $expected4->tec_yearly = 0.377876;
    $expected4->eir_monthly = 0.0228;
    $expected4->tec_monthly = 0.0271;
    $expected4->total_iof = 77.36;
    $expected4->contract_amount = 7877.36;
    $expected4->contract_amount_without_tac = 0.0;
    $expected4->tac_amount = 0.0;
    $expected4->iof_percentage = 8.2e-5;
    $expected4->overall_iof = 0.0038;
    $expected4->pre_disbursement_amount = 7800.02;
    $expected4->paid_total_iof = 77.38;
    $expected4->paid_contract_amount = 7877.38;
    $expected4->invoices = [$expectedInvoice1, $expectedInvoice2, $expectedInvoice3, $expectedInvoice4];



    $params = new Params(
      7800.0, // requested_amount
      new DateTimeImmutable('2025-05-03 05:00:00'), // first_payment_date
      new DateTimeImmutable('2025-04-05 05:00:00'), // disbursement_date
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

    $result = PaymentPlan::calculate($params);

    $this->assertIsArray($result);
    $this->assertNotEmpty($result);
    $this->assertIsObject($result[0]);
    $this->assertEquals($expected1, $result[0]);
    $this->assertEquals($expected2, $result[1]);
    $this->assertEquals($expected3, $result[2]);
    $this->assertEquals($expected4, $result[3]);
  }

  //TODO: Test for calculate down payment
}
