<?php

namespace Bendev\LexOffice;

use Illuminate\Contracts\Container\Container;

/**
 * Class LexOfficeManager.
 */
class LexOfficeManager
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * LexOfficeManager constructor.
     *
     * @param Container $app
     *
     * @return void
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * @return mixed
     */
    public function api()
    {
        return $this->app['lexoffice.api'];
    }
}
