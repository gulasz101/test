<?php

declare(strict_types=1);

namespace Pingen\Support;

/**
 * Trait HasCompanyContext
 * @package Pingen\Support
 */
trait HasCompanyContext
{
    protected string $companyId;

    /**
     * @param string $companyId
     * @return static
     */
    public function setCompanyId(string $companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        $this->checkIfCompanySet();

        return $this->companyId;
    }

    /**
     * Check whether company id is set.
     */
    protected function checkIfCompanySet(): void
    {
        if (! $this->companyId) {
            throw new \RuntimeException('Company id has to be set.');
        }
    }
}
