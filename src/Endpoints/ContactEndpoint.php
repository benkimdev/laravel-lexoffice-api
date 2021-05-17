<?php

namespace Bendev\LexOffice\Endpoints;

use Bendev\LexOffice\Exceptions\ApiException;
use Bendev\LexOffice\Resources\Contact;
use Bendev\LexOffice\Resources\ContactCollection;

class ContactEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = "contacts";

    /**
     * Get the object that is used by this API endpoint. Every API endpoint uses one type of object.
     *
     * @return Contact
     */
    protected function getResourceObject()
    {
        return new Contact($this->client);
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
     * Creates a customer
     *
     * @param array $data An array containing details on the customer.
     * @param array $filters
     *
     * @return Contact
     * @throws ApiException
     */
    public function create(array $data = [], array $filters = [])
    {
        return $this->rest_create($data, $filters);
    }

    /**
     * Retrieve a single customer.
     *
     * Will throw a ApiException if the customer id is invalid or the resource cannot be found.
     *
     * @param string $contactId
     * @param array $parameters
     * @return Contact
     * @throws ApiException
     */
    public function get($contactId, array $parameters = [])
    {
        return $this->rest_read($contactId, $parameters);
    }

    /**
     * Deletes the given Customer.
     *
     * Will throw a ApiException if the customer id is invalid or the resource cannot be found.
     * Returns with HTTP status No Content (204) if successful.
     *
     * @param string $customerId
     *
     * @param array $data
     * @return null
     * @throws ApiException
     */
    public function delete($customerId, array $data = [])
    {
        return $this->rest_delete($customerId, $data);
    }

    /**
     * Retrieves a collection of Customers.
     *
     * @param array $parameters
     *
     * @return ContactCollection
     * @throws ApiException
     */
    public function page(array $parameters = [])
    {
        return $this->rest_list($parameters);
    }
}
