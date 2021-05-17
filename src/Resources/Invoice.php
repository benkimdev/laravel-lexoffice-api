<?php

namespace Bendev\LexOffice\Resources;

use Bendev\LexOffice\LexOfficeClient;

class Invoice extends BaseResource
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
     * The instant of time when the invoice was created by lexoffice in format yyyy-MM-ddTHH:mm:ss.SSSXXX as described in RFC 3339/ISO
     *
     * @var string
     */
    public $createdDate;

    /**
     * The instant of time when the invoice was updated by lexoffice in format yyyy-MM-ddTHH:mm:ss.SSSXXX as described in RFC 3339/ISO
     *
     * @var string
     */
    public $updatedDate;

    /**
     * Version (revision) number which will be increased on each change to handle optimistic locking.
     *
     * @var integer
     */
    public $version;

    /**
     * Specifies the language of the invoice which affects the print document but also set translated default text modules when no values are send (e.g. for introduction). 
     * Values accepted in ISO 639-1 code. Possible values are German de (default) and English en.
     *
     * @var string
     */
    public $language;

    /**
     * Specifies the status of the invoice. Possible values are draft (is editable), open (finalized and no longer editable but yet unpaid or only partially paid), paid (has been fully paid), voided (cancelled)
     *
     * @var string
     */
    public $voucherStatus;

    /**
     * The specific number an invoice is aware of. This consecutive number is set by lexoffice on creation.
     *
     * @var string
     */
    public $voucherNumber;

    /**
     * The date of the invoice in format yyyy-MM-ddTHH:mm:ss.SSSXXX as described in RFC 3339/ISO 8601 (e.g. 2020-02-21T00:00:00.000+01:00).
     *
     * @var string
     */
    public $voucherDate;

    /**
     * Sets the date on which the invoice is payable before becoming overdue in format yyyy-MM-ddTHH:mm:ss.SSSXXX as described in RFC 3339/ISO 8601 (e.g. 2020-02-21T00:00:00.000+01:00).
     *
     * @var string
     */
    public $dueDate;

    /**
     * Specifies if the invoice is only available in the archive in lexoffice.
     * 
     * @var bool
     */
    public $archived;

    /**
     * The address of the invoice recipient.
     * 
     * @var \stdClass|mixed|null
     */
    public $address;

    /**
     * XRechnung related properties for XRechnung enabled invoices.
     * 
     * @var \stdClass|mixed|null
     */
    public $xRechnung;

    /**
     * The items of the invoice.
     * 
     * @var array
     */
    public $lineItems;

    /**
     * The total price of the invoice.
     * 
     * @var \stdClass|mixed|null
     */
    public $totalPrice;

    /**
     * The tax amounts for each tax rate. Please note: As done with every read-only element or object all submitted content (POST) will be ignored. For details see below.
     * 
     * @var array
     */
    public $taxAmounts;

    /**
     * The tax conditions of the invoice.
     * 
     * @var \stdClass|mixed|null
     */
    public $taxConditions;

    /**
     * The payment conditions of the invoice. The organization's (or contact-specific) default is used if no value was send.
     * 
     * @var \stdClass|mixed|null
     */
    public $paymentConditions;

    /**
     * The shipping conditions of the invoice.
     * 
     * @var \stdClass|mixed|null
     */
    public $shippingConditions;

    /**
     * Denotes whether this invoice is a closing invoice (https://developers.lexoffice.io/docs/#invoices-endpoint-closing-invoices)
     * 
     * @var bool
     */
    public $closingInvoice;

    /**
     * The remaining gross amount
     * 
     * @var integer
     */
    public $claimedGrossAmount;

    /**
     * The down payments connected to this closing invoice.
     * 
     * @var array
     */
    public $downPaymentDeductions;

    /**
     * The id of the recurring template, if this is a recurring invoice deduced from a template. 
     * 
     * @var string
     */
    public $recurringTemplateId;

    /**
     * A title text. The organization's default is used if no value was sent.
     * 
     * @var string
     */
    public $title;

    /**
     * An introductory text / header. The organization's default is used if no value was send.
     * 
     * @var string
     */
    public $introduction;

    /**
     * A closing text note. The organization's default is used if no value was send.
     * 
     * @var string
     */
    public $remark;

    /**
     * The document id for the PDF version of the invoice.
     * 
     * @var \stdClass|mixed|null
     */
    public $files;




}
