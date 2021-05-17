<?php

namespace Bendev\LexOffice\Resources;

use Bendev\LexOffice\LexOfficeClient;

class Contact extends BaseResource
{

    /**
     * Unique id of the contact generated on creation by lexoffice.
     *
     * @var string
     */
    public $id;

    /**
     * Unique id of the organization the contact belongs to.
     *
     * @var string
     */
    public $organizationId;

    /**
     * Version (revision) number which will be increased on each change to handle optimistic locking.
     *
     * @var integer
     */
    public $version;

    /**
     * Defines contact roles and supports further contact information.
     *
     * @var \stdClass|mixed|null
     */
    public $roles;

    /**
     * Company related information.
     *
     * @var string
     */
    public $company;

    /**
     * Individual person related information.
     * 
     * @var string
     */
    public $person;

    /**
     * Addresses (e.g. billing and shipping address(es)) for the contact. Contains a list for each address type.
     * 
     * @var \stdClass|mixed|null
     */
    public $addresses;

    /**
     * XRechnung related properties of the contact
     * 
     * @var \stdClass|mixed|null
     */
    public $xRechnung;

    /**
     * Email addresses for the contact. Contains a list for each EMail type.
     * 
     * @var \stdClass|mixed|null
     */
    public $emailAddresses;

    /**
     * Phone numbers for the contact. Contains a list for each PhoneNumber type.
     * 
     * @var \stdClass|mixed|null
     */
    public $phoneNumbers;

    /**
     * A note to the contact. This is just an additional information.
     * 
     * @var string
     */
    public $note;

    /**
     * Archived flag of the contact. Read-only.
     * 
     * @var bool
     */
    public $archived;

}
