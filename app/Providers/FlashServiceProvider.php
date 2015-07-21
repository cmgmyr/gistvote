<?php namespace Gistvote\Providers;

use Illuminate\Support\ServiceProvider;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('flash', function () {
            return $this->app->make('Gistvote\Services\Notifications\FlashNotifier');
        });
    }
}
