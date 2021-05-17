<?php

namespace Bendev\LexOffice\Resources;

abstract class BaseCollection extends \ArrayObject
{
    /**
     * Total number of retrieved objects.
     *
     * @var int
     */
    public $count;

    /**
     * @param int $count
     * @param \stdClass $_links
     */
    public function __construct($count)
    {
        $this->count = $count;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    abstract public function getCollectionResourceName();
}
