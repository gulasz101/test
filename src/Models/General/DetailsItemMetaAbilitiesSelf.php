<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class DetailsItemMetaAbilitiesSelf
 * @package Pingen\Models\General
 */
class DetailsItemMetaAbilitiesSelf extends DataTransferObject
{
    public ?string $reach;

    public ?string $act;

    public ?string $resend_activation;

    public ?string $join;
}
