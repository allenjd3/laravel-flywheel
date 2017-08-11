<?php

namespace Allenjd3\Flywheel;

use FlywheelWrapper;
use Illuminate\Support\ServiceProvider;

class FlywheelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Flywheel', function(){
        	return new FlywheelWrapper();
        });
    }
}
