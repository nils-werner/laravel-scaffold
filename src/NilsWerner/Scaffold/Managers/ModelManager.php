<?php namespace NilsWerner\Scaffold\Managers;

use Illuminate\Support\Facades\App;

class ModelManager extends Manager {

	public static function resolve($handle)
	{
		$model = self::spinalCaseToCamelCase($handle);
		if(is_subclass_of($model, 'Eloquent'))
		{
			return App::make($model);
		}
		else
		{
			App::abort(404, 'Page not found');
		}
	}

	public static function spinalCaseToCamelCase($input)
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $input)));
	}


}