<?php

namespace Bendev\LexOffice\Endpoints;

use Bendev\LexOffice\Exceptions\ApiException;
use Bendev\LexOffice\Resources\Invoice;
use Bendev\LexOffice\Resources\InvoiceCollection;

class InvoiceEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "invoices";

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
