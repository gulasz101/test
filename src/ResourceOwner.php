<?php

declare(strict_types=1);

namespace Pingen;

use Illuminate\Support\Arr;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

/**
 * Class ResourceOwner
 * @package Pingen
 */
class ResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    protected array $response = array();

    /**
     * ResourceOwner constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return Arr::get($this->response, 'data.id');
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
