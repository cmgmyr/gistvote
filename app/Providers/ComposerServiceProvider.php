<?php namespace Gistvote\Providers;

use Illuminate\Support\Facades\View;
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
        View::composer('layouts.app', 'Gistvote\Http\ViewComposers\AppComposer');
    }
}
