<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class CollectionMeta
 * @package Pingen\Models\General
 */
class CollectionMeta extends DataTransferObject
{
    public int $current_page;

    public int $last_page;

    public int $per_page;

    public ?int $from;

    public ?int $to;

    public int $total;
}
