<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class DetailsItemMetaAbilities
 * @package Pingen\Models\General
 */
class DetailsItemMetaAbilities extends DataTransferObject
{
    public ?DetailsItemMetaAbilitiesSelf $self;

    public ?DetailsItemMetaAbilitiesCompany $company;
}
