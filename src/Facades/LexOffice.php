<?php

namespace Bendev\LexOffice\Facades;

use Illuminate\Support\Facades\Facade;
use Bendev\LexOffice\Wrappers\LexOfficeWrapper;

/**
 * (Facade) Class LexOffice.
 *
 * @method static LexOfficeWrapper api()
 */
class LexOffice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lexoffice';
    }
}
