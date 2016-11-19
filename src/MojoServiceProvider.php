<?php

namespace Lubus\Mojo;

use Illuminate\Support\ServiceProvider;

class MojoServiceProvider extends ServiceProvider
{
	public function boot()
	{
	    $this->publishes([
		        __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
		    ], 'migrations');

	    $this->publishes([
		        __DIR__.'/config/laravelmojo.php' => config_path('laravelmojo.php'),
		    ], 'config');
	}

    public function register()
    {
        $this->app->make('Lubus\Mojo\Mojo');
    }
}

?>