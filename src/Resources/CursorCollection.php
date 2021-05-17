<?php

namespace Bendev\LexOffice\Resources;

use Bendev\LexOffice\LexOfficeClient;

abstract class CursorCollection extends BaseCollection
{
    /**
     * @var LexOfficeClient
     */
    protected $client;

    /**
     * @param LexOfficeClient $client
     * @param int $count
     */
    final public function __construct(LexOfficeClient $client, $count)
    {
        parent::__construct($count);

        $this->client = $client;
    }

    /**
     * @return BaseResource
     */
    abstract protected function createResourceObject();

}
