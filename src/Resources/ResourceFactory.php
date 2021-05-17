<?php

namespace Bendev\LexOffice\Resources;

use Bendev\LexOffice\LexOfficeClient;

class ResourceFactory
{
    /**
     * Create resource object from Api result
     *
     * @param object $apiResult
     * @param BaseResource $resource
     *
     * @return BaseResource
     */
    public static function createFromApiResult($apiResult, BaseResource $resource)
    {
        foreach ($apiResult as $property => $value) {
            $resource->{$property} = $value;
        }
        
        return $resource;
    }

    /**
     * @param LexOfficeClient $client
     * @param string $resourceClass
     * @param array $data
     * @param null $_links
     * @param null $resourceCollectionClass
     * @return mixed
     */
    public static function createBaseResourceCollection(
        LexOfficeClient $client,
        $resourceClass,
        $data,
        $resourceCollectionClass = null
    ) {
        $resourceCollectionClass = $resourceCollectionClass ?: $resourceClass . 'Collection';
        $data = $data ?: [];

        $result = new $resourceCollectionClass(count($data));
        foreach ($data as $item) {
            $result[] = static::createFromApiResult($item, new $resourceClass($client));
        }

        return $result;
    }

    /**
     * @param LexOfficeClient $client
     * @param array $input
     * @param string $resourceClass
     * @param null $resourceCollectionClass
     * @return mixed
     */
    public static function createCursorResourceCollection(
        $client,
        array $input,
        $resourceClass,
        $resourceCollectionClass = null
    ) {
        if (null === $resourceCollectionClass) {
            $resourceCollectionClass = $resourceClass.'Collection';
        }

        $data = new $resourceCollectionClass($client, count($input));
        foreach ($input as $item) {
            $data[] = static::createFromApiResult($item, new $resourceClass($client));
        }

        return $data;
    }
}
