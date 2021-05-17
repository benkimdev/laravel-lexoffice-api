<?php

namespace Bendev\LexOffice\Endpoints;

use Bendev\LexOffice\Exceptions\ApiException;
use Bendev\LexOffice\Resources\Invoice;
use Bendev\LexOffice\Resources\InvoiceCollection;

class InvoiceEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "invoices";

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Invoice
     */
    protected function getResourceObject()
    {
        return new Invoice($this->client);
    }

    /**
     * Get the collection object that is used by this API endpoint. Every API endpoint uses one type of collection object.
     *
     * @param int $count
     *
     * @return ContactCollection
     */
    protected function getResourceCollectionObject($count)
    {
        return new ContactCollection($this->client, $count);
    }

    /**
     * Creates a invoice in LexOffice.
     *
     * @param array $data An array containing details on the invoice.
     * @param array $filters
     *
     * @return Invoice
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }
}
