<?php

declare(strict_types=1);

namespace Pingen\Endpoints\ParameterBags;

use Pingen\Support\ListParameterBag;

/**
 * Class UserAssociationCollectionParameterBag
 * @package Pingen\Endpoints\ParameterBags
 */
class UserAssociationCollectionParameterBag extends ListParameterBag
{
    /**
     * @param array $fields
     * @return UserAssociationCollectionParameterBag
     */
    public function setFieldsAssociation(array $fields): self
    {
        $this->set('fields[associations]', collect($fields)->join(','));

        return $this;
    }

    /**
     * @param array $fields
     * @return UserAssociationCollectionParameterBag
     */
    public function setFieldsCompany(array $fields): self
    {
        $this->set('fields[companies]', collect($fields)->join(','));

        return $this;
    }
}
