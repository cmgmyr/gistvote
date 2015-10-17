<?php

namespace Gistvote\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', 'Gistvote\Http\ViewComposers\AppComposer');
    }
}
