<?php

declare(strict_types=1);

namespace Pingen\Models\Letter;

use Carbon\CarbonImmutable;
use Pingen\Support\DataTransferObject;

/**
 * Class LetterItemAttributes
 * @package Pingen\Models\Letter
 */
class LetterItemAttributes extends DataTransferObject
{
    public string $status;

    public string $file_original_name;

    public string $address_position;

    public ?string $delivery_product;

    public ?string $print_mode;

    public ?string $print_spectrum;

    public CarbonImmutable $created_at;

    public CarbonImmutable $updated_at;
}
