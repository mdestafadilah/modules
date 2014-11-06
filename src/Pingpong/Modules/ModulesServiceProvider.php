<?php namespace Pingpong\Modules;

use Illuminate\Support\Str;
use Pingpong\Generators\Stub;
use Pingpong\Modules\Commands;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Booting the package.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('pingpong/modules');

        $this->app['modules']->register();

        Stub::setPath(__DIR__ . '/Commands/stubs');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
        $this->app->register(__NAMESPACE__ . '\\Providers\\ConsoleServiceProvider');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->bindShared('modules', function ($app)
        {
            $path = $app['config']->get('modules::paths.modules');

            return new Repository($path, $app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('modules');
    }
}
