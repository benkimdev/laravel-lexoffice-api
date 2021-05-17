<?php

namespace Bendev\LexOffice;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Bendev\LexOffice\LexOffcieClient;
use Bendev\LexOffice\LexOfficeManager;
use Bendev\LexOffice\Wrappers\LexOfficeWrapper;

/**
 * Class LexOfficeServiceProvider.
 */
class LexOfficeServiceProvider extends ServiceProvider
{
    const PACKAGE_VERSION = '2.14.0';

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/lexoffice.php');

        // Check if the application is a Laravel OR Lumen instance to properly merge the configuration file.
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('lexoffice.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('lexoffice');
        }

        $this->mergeConfigFrom($source, 'lexoffice');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();
        $this->registerAdapter();
        $this->registerManager();
    }

    /**
     * Register the LexOffice adapter class.
     *
     * @return void
     */
    protected function registerAdapter()
    {
        $this->app->singleton('lexoffice.api', function (Container $app) {
            $config = $app['config'];

            return new LexOfficeWrapper($config, $app['lexoffice.client']);
        });

        $this->app->alias('lexoffice.api', LexOfficeWrapper::class);
    }


    /**
     * Register the LexOffice Client.
     *
     * @return void
     */
    protected function registerClient()
    {
        $this->app->singleton('lexoffice.client', function () {
            return (new LexOfficeClient());
        });

        $this->app->alias('lexoffice.client', LexOffcieClient::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    public function registerManager()
    {
    
        $this->app->singleton('lexoffice', function (Container $app) {
            return new LexOfficeManager($app);
        });

        $this->app->alias('lexoffice', LexOfficeManager::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'lexoffice',
            'lexoffice.client',
            'lexoffice.api'
        ];
    }

}
