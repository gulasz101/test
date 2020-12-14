<?php

declare(strict_types=1);

namespace Pingen\Models\Letter;

use Pingen\Models\General\ItemLinks;
use Pingen\Support\DataTransferObject;

/**
 * Class LetterCollectionItem
 * @package Pingen\Models\Letter
 */
class LetterCollectionItem extends DataTransferObject
{
    public string $type;

    public string $id;

    public LetterItemAttributes $attributes;

    public ?ItemLinks $links;
}
