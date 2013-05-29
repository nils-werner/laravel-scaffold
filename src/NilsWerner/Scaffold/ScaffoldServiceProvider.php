<?php namespace NilsWerner\Scaffold;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use NilsWerner\Scaffold\Fields\ScaffoldFieldFile;
use NilsWerner\Scaffold\Fields\ScaffoldFieldString;
use NilsWerner\Scaffold\Fields\ScaffoldFieldPassword;

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

		App::bind('scaffoldfieldstring', function($app)
		{
			return new ScaffoldFieldString;
		});

		App::bind('scaffoldfieldfile', function($app)
		{
			return new ScaffoldFieldFile;
		});

		App::bind('scaffoldfieldpassword', function($app)
		{
			return new ScaffoldFieldPassword;
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