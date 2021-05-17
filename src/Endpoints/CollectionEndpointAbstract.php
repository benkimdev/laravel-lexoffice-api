<?php

namespace Bendev\LexOffice\Endpoints;

use Bendev\LexOffice\Resources\BaseCollection;

abstract class CollectionEndpointAbstract extends EndpointAbstract
{
    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     *
     * @return BaseCollection
     */
    abstract protected function getResourceCollectionObject($count);
}
