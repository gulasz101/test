<?php

declare(strict_types=1);

namespace Pingen\Models\Letter;

use Pingen\Endpoints\FileUploadsEndpoint;
use Pingen\Pingen;
use Pingen\Support\Input;

/**
 * Class LetterInputPOSTAttributes
 * @package Pingen\Models\Letter
 *
 * @method \Pingen\Models\Letter\LetterInputPOSTAttributes setFileOriginalName(string $value)
 * @method \Pingen\Models\Letter\LetterInputPOSTAttributes setAddressPosition(string $value)
 * @method \Pingen\Models\Letter\LetterInputPOSTAttributes setAutoSend(bool $value)
 * @method \Pingen\Models\Letter\LetterInputPOSTAttributes setDeliveryProduct(string $value)
 * @method \Pingen\Models\Letter\LetterInputPOSTAttributes setPrintMode(string $value)
 * @method \Pingen\Models\Letter\LetterInputPOSTAttributes setPrintSpectrum(string $value)
 */
class LetterInputPOSTAttributes extends Input
{
    protected Pingen $provider;

    /**
     * @var resource|string
     */
    protected $file;

    protected string $file_original_name;

    protected string $file_url;

    protected string $file_url_signature;

    protected string $address_position;

    protected bool $auto_send;

    protected string $delivery_product;

    protected string $print_mode;

    protected string $print_spectrum;

    /**
     * @param resource|string $file File contents or path.
     * @return $this
     */
    public function attachFile($file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @param Pingen $provider
     * @return LetterInputPOSTAttributes
     */
    public function setProvider(Pingen $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return array
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function toArray()
    {
        if (isset($this->file)) {
            $fileUploadsEndpoint = new FileUploadsEndpoint($this->provider);
            $fileUploadDetails = $fileUploadsEndpoint->getDetails();

            $fileUploadsEndpoint->uploadFile($fileUploadDetails, $this->file);

            $this
                ->setFileUrl($fileUploadDetails->data->attributes->url)
                ->setFileUrlSignature($fileUploadDetails->data->attributes->url_signature);
        }
        return parent::toArray();
    }
}
