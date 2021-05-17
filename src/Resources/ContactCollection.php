<?php

namespace Bendev\LexOffice\Resources;

class ContactCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "contacts";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Contact($this->client);
    }
}
