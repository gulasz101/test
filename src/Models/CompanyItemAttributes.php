<?php

declare(strict_types=1);

namespace Pingen\Models;

use Carbon\CarbonImmutable;
use Pingen\Support\DataTransferObject;

/**
 * Class CompanyItemAttributes
 * @package Pingen\Models
 *
 * @method \Pingen\Models\CompanyItemAttributes setName(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setStatus(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setPlan(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setStreet(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setStreetNumber(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setZip(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setCity(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setCountry(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setLegalForm(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setVatNumber(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setForeignCurrencies(bool $value)
 * @method \Pingen\Models\CompanyItemAttributes setColor(string $value)
 * @method \Pingen\Models\CompanyItemAttributes setTrialExpiresAt(\Carbon\CarbonImmutable $value)
 * @method \Pingen\Models\CompanyItemAttributes setCreatedAt(\Carbon\CarbonImmutable $value)
 * @method \Pingen\Models\CompanyItemAttributes setUpdatedAt(\Carbon\CarbonImmutable $value)
 */
class CompanyItemAttributes extends DataTransferObject
{
    public ?string $name;

    public ?string $status;

    public ?string $plan;

    public ?string $street;

    public ?string $street_number;

    public ?string $zip;

    public ?string $city;

    public ?string $country;

    public ?string $legal_form;

    public ?string $vat_number;

    public ?bool $foreign_currencies;

    public ?string $color;

    public ?CarbonImmutable $trial_expires_at;

    public ?CarbonImmutable $created_at;

    public ?CarbonImmutable $updated_at;
}
