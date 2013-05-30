<?php namespace NilsWerner\Scaffold;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('nils-werner/scaffold');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		include __DIR__.'/../../routes.php';

		App::bind('Scaffold\Fields\String', function($app, $handle)
		{
			return new Fields\String($app, $handle);
		});

		App::bind('Scaffold\Fields\Upload', function($app, $handle)
		{
			return new Fields\Upload($app, $handle);
		});

		App::bind('Scaffold\Fields\Password', function($app, $handle)
		{
			return new Fields\Password($app, $handle);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}