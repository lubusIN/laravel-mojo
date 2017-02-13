<?php

namespace Lubusin\Mojo;

use Illuminate\Support\ServiceProvider;

class MojoServiceProvider extends ServiceProvider
{
	public function boot()
	{
	    $this->loadMigrationsFrom(__DIR__.'/../migrations');

	    $this->publishes([
        	__DIR__.'/config/laravelmojo.php' => config_path('laravelmojo.php'),
    	]);
	}
    public function register()
    {
        
    }
}
