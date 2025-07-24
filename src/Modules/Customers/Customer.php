<?php

namespace Vikuraa\Modules\Customers;

use Vikuraa\Modules\People\Person;
use DateTime;

class Customer extends Person
{
    protected ?string $companyName;
    protected ?string $accountNumber;
    protected ?bool $taxable;
    protected ?string $taxId;
    protected ?int $salesTaxCodeId;
    protected ?float $discount;
    protected ?string $discountType;
    protected ?int $packageId;
    protected ?int $points;
    protected ?bool $deleted;
    protected ?DateTime $date;
    protected ?int $employeeId;
    protected ?bool $consent;

    public static function fromDbArray(array $data): static
    {
        $customer = parent::fromDbArray($data);

        $customer->companyName = $data['company_name'];
        $customer->accountNumber = $data['account_number'];
        $customer->taxable = $data['taxable'];
        $customer->taxId = $data['tax_id'];
        $customer->salesTaxCodeId = $data['sales_tax_code_id'];
        $customer->discount = $data['discount'];
        $customer->discountType = $data['discount_type'];
        $customer->packageId = $data['package_id'];
        $customer->points = $data['points'];
        $customer->deleted = $data['deleted'];
        $customer->date = $data['date'] == null ? null : new DateTime($data['date']);
        $customer->employeeId = $data['employee_id'];
        $customer->consent = $data['consent'];

        return $customer;
    }
}