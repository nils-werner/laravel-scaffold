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

		App::bind('Scaffold\FieldManager', function($app, $params)
		{
			return new FieldManager($app, $params);
		});

		App::bind('Scaffold\ModelManager', function($app, $params)
		{
			return new ModelManager($app, $params);
		});

		App::bind('Scaffold\Fields\String', function($app, $params)
		{
			return new Fields\String($app, $params[0], $params[1], $params[2]);
		});

		App::bind('Scaffold\Fields\Upload', function($app, $params)
		{
			return new Fields\Upload($app, $params[0], $params[1], $params[2]);
		});

		App::bind('Scaffold\Fields\Password', function($app, $params)
		{
			return new Fields\Password($app, $params[0], $params[1], $params[2]);
		});

		App::bind('Scaffold\Fields\Checkbox', function($app, $params)
		{
			return new Fields\Checkbox($app, $params[0], $params[1], $params[2]);
		});

		App::bind('Scaffold\Fields\Relation', function($app, $params)
		{
			return new Fields\Relation($app, $params[0], $params[1], $params[2]);
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