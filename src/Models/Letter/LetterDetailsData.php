<?php

declare(strict_types=1);

namespace Pingen\Models\Letter;

use Pingen\Models\General\ItemLinks;
use Pingen\Support\DataTransferObject;

/**
 * Class LetterDetailsData
 * @package Pingen\Models\Letter
 */
class LetterDetailsData extends DataTransferObject
{
    public ?string $id;

    public string $type;

    public LetterItemAttributes $attributes;

    public ?ItemLinks $links;
}
