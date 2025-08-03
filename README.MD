# Lara Payment Plan PHP SDK

This is the Lara Payment Plan SDK, the core of the Lara Credit Proposal System.

## About

This SDK, like other Lara Payment Plan SDKs, is a wrapper around the Lara Payment Plan Rust library.
Currently, the library is available for Linux and Windows. MacOS support is planned for the future.

## Requirements

- PHP 8.1 or higher
- FFI extension enabled

## Installation
To install the Lara Payment Plan PHP SDK, you can use Composer:

```bash
composer require parcelado-lara/payment-plan-php
```

The SDK needs to download the compiled Rust library, so you may need to allow the package manager to download it.

## Usage
To use the Lara Payment Plan PHP SDK, you can import it into your project as follows:

### calculate
Calculates a number of payment plans without down payment given a set of `Params`.
Returns a `Response[]` consisting of plans from 1 installment up to the number of installments requested, so that you can choose the one that best fits your needs. If the `installmentAmount` of the plan is less than the `minInstallmentAmount` it will not be included in the response.

```php
<?php

use ParceladoLara\PaymentPlan\PaymentPlan;
use ParceladoLara\PaymentPlan\Params\Params;

$params = new Params(
    requestedAmount: 8800.0,
    firstPaymentDate: new DateTime('2022-04-18'),
    disbursementDate: new DateTime('2022-03-18'),
    installments: 24,
    debitServicePercentage: 0,
    mdr: 0.05,
    tacPercentage: 0.0,
    iofOverall: 0.0038,
    iofPercentage: 0.000082,
    interestRate: 0.0235,
    minInstallmentAmount: 0.0,
    maxTotalAmount: PHP_FLOAT_MAX,
    disbursementOnlyOnBusinessDays: false
);

$result = PaymentPlan::calculate($params);
```

Parameters:
- `requestedAmount`: The amount requested for the plan.
- `firstPaymentDate`: The date of the first payment.
- `disbursementDate`: The date of the disbursement.
- `installments`: The number of installments.
- `debitServicePercentage`: Percentage for debit service.
- `mdr`: Merchant Discount Rate.
- `tacPercentage`: Total Amount Charged percentage.
- `iofOverall`: Overall IOF (Tax on Financial Operations).
- `iofPercentage`: IOF percentage.
- `interestRate`: Interest rate for the plan.
- `minInstallmentAmount`: Minimum installment amount.
- `maxTotalAmount`: Maximum total amount for the plan.
- `disbursementOnlyOnBusinessDays`: Whether disbursement is only on business days.

Errors:
- If `requestedAmount` is less than or equal to 0, an error will be thrown.
- If `installments` is less than or equal to 0, an error will be thrown.
- If any of the dates are invalid
- If any of the tax parameters are too unreasonable for an `Excel XIRR` calculation

### calculateDownPayment
Calculates a number of payment plans with down payment given a set of `DownPaymentParams`.
Returns a `DownPaymentResponse[]` with the payment plan details. This will be a plan for 1 installment up to the number of installments requested, so that you can choose the one that best fits your needs. If the `installmentAmount` of the plan is less than the `minInstallmentAmount` it will not be included in the response.

```php
<?php

use ParceladoLara\PaymentPlan\PaymentPlan;
use ParceladoLara\PaymentPlan\Params\Params;
use ParceladoLara\PaymentPlan\Params\DownPaymentParams;

$downPayment = 200.0;
$minInstallmentAmount = 100.0;
$installments = 4;

$params = new Params(
    requestedAmount: 8800.0,
    firstPaymentDate: new DateTime('2022-04-18'),
    disbursementDate: new DateTime('2022-03-18'),
    installments: 24,
    debitServicePercentage: 0,
    mdr: 0.05,
    tacPercentage: 0.0,
    iofOverall: 0.0038,
    iofPercentage: 0.000082,
    interestRate: 0.0235,
    minInstallmentAmount: 0.0,
    maxTotalAmount: PHP_FLOAT_MAX,
    disbursementOnlyOnBusinessDays: false
);

$downPaymentParams = new DownPaymentParams(
    requestedAmount: $downPayment,
    minInstallmentAmount: $minInstallmentAmount,
    firstPaymentDate: new DateTime('2022-06-20'),
    installments: $installments,
    params: $params
);

$result = PaymentPlan::calculateDownPayment($downPaymentParams);
```
Parameters:
- `requestedAmount`: The amount requested for the down payment.
- `minInstallmentAmount`: Minimum installment for the down payment plan.
- `installments`: The number of installments for the down payment plan.
- `firstPaymentDate`: The date of the first payment for the down payment plan.
- `params`: A `Params` object containing the parameters for the payment plan (see above).

Errors:
- If `requestedAmount` is less than or equal to 0, an error will be thrown.
- If `installments` is less than or equal to 0, an error will be thrown.
- If any of the dates are invalid
- If any of the tax parameters are too unreasonable for an `Excel XIRR` calculation

### disbursementDateRange
Calculates a start and end date for a disbursement period based on a `baseDate` and a `numberOfDays`.

```php
<?php

use ParceladoLara\PaymentPlan\PaymentPlan;

$baseDate = new DateTime('2078-02-12');
$days = 5;
$result = PaymentPlan::disbursementDateRange($baseDate, $days);
var_dump($result); // Array of DateTime objects: [DateTime('2078-02-16'), DateTime('2078-02-22')]
/*
  2078-02-12 = Saturday(invalid)
  2078-02-13 = Sunday(invalid)
  2078-02-14 = Bank holiday(invalid)
  2078-02-15 = Bank holiday(invalid)
  2078-02-16 = Wednesday(valid) 1
  2078-02-17 = Thursday(valid) 2
  2078-02-18 = Friday(valid) 3
  2078-02-19 = Saturday(invalid)
  2078-02-20 = Sunday(invalid)
  2078-02-21 = Tuesday(valid) 4
  2078-02-22 = Wednesday(valid) 5


  So the disbursement period is from 2078-02-16 to 2078-02-22.
*/
```
Parameters:
- `baseDate`: The base date from which to calculate the disbursement period.
- `numberOfDays`: The number of days to calculate the disbursement period.
- Returns an array where `[0]` is the start date and `[1]` is the end date of the disbursement period.
- Errors:
  - If `baseDate` is not a valid date, an error will be thrown.

### getNonBusinessDaysBetween
Calculates the non-business (weekends and bank holidays) days between two dates, and returns an array of non-business days.

```php
<?php

use ParceladoLara\PaymentPlan\PaymentPlan;

$startDate = new DateTime('2078-11-12');
$endDate = new DateTime('2078-11-22');
$result = PaymentPlan::getNonBusinessDaysBetween($startDate, $endDate);
var_dump($result); // Array of DateTime objects for non-business days

/*
  2078-11-12 = Saturday(non-business)
  2078-11-13 = Sunday(non-business)
  2078-11-14 = Monday(business)
  2078-11-15 = Tuesday(non-business)
  2078-11-16 = Wednesday(business)
  2078-11-17 = Thursday(business)
  2078-11-18 = Friday(business)
  2078-11-19 = Saturday(non-business)
  2078-11-20 = Sunday(non-business)
  2078-11-21 = Monday(business)
  2078-11-22 = Tuesday(business)
  So the non-business days are 2078-11-12, 2078-11-13, 2078-11-15, 2078-11-19, and 2078-11-20.
*/
```
Parameters:
- `startDate`: The start date from which to calculate the non-business days.
- `endDate`: The end date until which to calculate the non-business days.
- Returns an array of non-business days between the two dates.
- Errors:
  - If `startDate` or `endDate` is not a valid date, an error will be thrown.
  - If `startDate` is after `endDate`, an error will be thrown.

### nextDisbursementDate
Calculates the next disbursement date based on a `baseDate`

```php
<?php

use ParceladoLara\PaymentPlan\PaymentPlan;

$baseDate = new DateTime('2078-02-12');
$result = PaymentPlan::nextDisbursementDate($baseDate);
var_dump($result); // DateTime object: 2078-02-16
/*
  2078-02-12 = Saturday(invalid)
  2078-02-13 = Sunday(invalid)
  2078-02-14 = Bank holiday(invalid)
  2078-02-15 = Bank holiday(invalid)
  2078-02-16 = Wednesday(valid) 1
*/
```
Parameters:
- `baseDate`: The base date from which to calculate the next disbursement date.
- Returns the next valid disbursement date after the `baseDate`.
- Errors:
  - If `baseDate` is not a valid date, an error will be thrown.

Warning:
As of now, if `baseDate=today` `baseDate` will be considered a invalid date, but this can change in the future.

## Contributing
This repository is and the code in it is a carbon copy of the code on [Parcelado Lara Payment Plan](https://github.com/ParceladoLara/payment-plan).
So to contribute, you can contribute directly to the payment plan repository and the changes will be reflected here after a release.

## License
This software is provided free of charge for personal or internal business use only.
Modification, redistribution, sublicensing, or reverse engineering is not permitted.
Copyright (c) 2025 SWEETPAY SOLUCOES FINANCEIRAS LTDA. All rights reserved.