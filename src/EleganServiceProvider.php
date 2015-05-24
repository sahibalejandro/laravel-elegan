<?php
/**
 * @author Sahib J. Leo <sahib@sahib.io>
 * Date: 5/19/15, 12:29 AM
 */

namespace Sahib\Elegan;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class EleganServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerViews();
        $this->registerFacades();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Collective\Html\HtmlServiceProvider');
    }

    /**
     * Setup views namespace and publishing.
     */
    protected function registerViews()
    {
        $viewsPath = __DIR__ . '/resources/views';

        $this->loadViewsFrom($viewsPath, 'elegan');

        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/elegan'),
        ]);
    }

    /**
     * Register facades.
     */
    protected function registerFacades()
    {
        AliasLoader::getInstance()->alias('Form', 'Collective\Html\FormFacade');
        AliasLoader::getInstance()->alias('Html', 'Collective\Html\HtmlFacade');
    }
}
