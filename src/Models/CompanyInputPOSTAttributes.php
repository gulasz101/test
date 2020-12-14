<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Support\Input;

/**
 * Class CompanyInputAttributes
 * @package Pingen\Models
 *
 * @method \Pingen\Models\CompanyInputPOSTAttributes setName(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setPlan(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setStreet(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setStreetNumber(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setZip(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setCity(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setCountry(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setLegalForm(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setVatNumber(string $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setForeignCurrencies(bool $value)
 * @method \Pingen\Models\CompanyInputPOSTAttributes setColor(string $value)
 */
class CompanyInputPOSTAttributes extends Input
{
    protected ?string $name;

    protected ?string $plan;

    protected ?string $street;

    protected ?string $street_number;

    protected ?string $zip;

    protected ?string $city;

    protected ?string $country;

    protected ?string $legal_form;

    protected ?string $vat_number;

    protected ?bool $foreign_currencies;

    protected ?string $color;
}
