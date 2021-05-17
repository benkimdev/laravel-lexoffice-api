<?php

namespace Bendev\LexOffice\Resources;

use Bendev\LexOffice\LexOfficeClient;

abstract class BaseResource
{
    /**
     * @var LexOfficeClient
     */
    protected $client;

    /**
     * @param $client
     */
    public function __construct(LexOfficeClient $client)
    {
        $this->client = $client;
    }
}
