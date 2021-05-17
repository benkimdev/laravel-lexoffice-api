<?php

namespace Bendev\LexOffice\Wrappers;

use Illuminate\Contracts\Config\Repository;
use Bendev\LexOffice\Exceptions\ApiException;
use Bendev\LexOffice\LexOfficeClient;

/**
 * Class LexOfficeWrapper.
 */
class LexOfficeWrapper
{
    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var LexOfficeClient
     */
    protected $client;

    /**
     * LexOfficeWrapper constructor.
     *
     * @param Repository $config
     * @param LexOfficeClient $client
     *
     * @throws \Bendev\LexOffice\Exceptions\ApiException
     * @return void
     */
    public function __construct(Repository $config, LexOfficeClient $client)
    {   
        $this->config = $config;
        $this->client = $client;

        $this->setApiKey($this->config->get('lexoffice.key'));
    }

    /**
     * @param string $url
     */
    public function setApiEndpoint($url)
    {
        $this->client->setApiEndpoint($url);
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->client->getApiEndpoint();
    }

    /**
     * @param string $api_key
     * @throws ApiException
     */
    public function setApiKey($api_key)
    {
        $this->client->setApiKey($api_key);
    }

    /**
     * @return Bendev\LexOffice\Endpoints\ContactEndpoint
     */
    public function contacts()
    {
        return $this->client->contacts;
    }

    /**
     * @return \Bendev\LexOffice\Api\Endpoints\InvoiceEndpoint
     */
    public function invoices()
    {
        return $this->client->invoices;
    }

    /**
     * Handle dynamic property calls.
     *
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        $message = '%s has no property or method "%s".';

        throw new \Error(
            sprintf($message, static::class, $property)
        );
    }
}
