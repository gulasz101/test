<?php

declare(strict_types=1);

namespace Pingen\Models\Letter;

use Pingen\Models\General\CollectionLinks;
use Pingen\Models\General\CollectionMeta;
use Pingen\Support\DataTransferObject;

/**
 * Class LetterCollection
 * @package Pingen\Models\Letter
 */
class LetterCollection extends DataTransferObject
{
    /**
     * @var \Pingen\Models\Letter\LetterCollectionItem[]
     */
    public array $data;

    public CollectionLinks $links;

    public CollectionMeta $meta;
}
