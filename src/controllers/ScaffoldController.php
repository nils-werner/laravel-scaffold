<?php namespace NilsWerner\Scaffold;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Controller;

class ScaffoldController extends Controller {

	public function __construct()
	{
	}


/*
|
| URL and View Handling
|
*/

	public function getIndex($handle)								# INDEX
	{
		$model = Managers\ModelManager::resolve($handle);
		$entries = $model->paginate(15);
		$inputs = Managers\FieldManager::getColumns($model);

		return App::make('view')->make('scaffold::index', compact('entries', 'handle', 'inputs'));
	}

	public function getCreate($handle)								# CREATE
	{	
		$model = Managers\ModelManager::resolve($handle);
		$inputs = Managers\FieldManager::getFields($model);
		$entry = new $model();

		return App::make('view')->make('scaffold::create', compact('entry', 'handle', 'inputs'));
	}

	public function postIndex($handle)								# STORE
	{
		$model = Managers\ModelManager::resolve($handle);
		$input = array_except(App::make('request')->all(), array('_method','_token'));
		$validation = Validator::make($input, isset($model->rules) ? $model->rules : []);

		if ($validation->passes())
		{
			$entry = new $model();
			foreach($input AS $name => $data)
			{
				$entry->$name = $data;
			}
			$entry->save();

			return Redirect::route('scaffold.index', [$handle])
				->with('message', 'Entry saved.');
		}

		return Redirect::route('scaffold.create', [$handle])
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	public function getEdit($handle, $id)							# EDIT
	{
		$model = Managers\ModelManager::resolve($handle);

		$entry = $model->find($id);
		$inputs = Managers\FieldManager::getFields($model);

		if (is_null($entry))
		{
			return Redirect::route('scaffold.index', [$handle]);
		}

		return App::make('view')->make('scaffold::edit', compact('entry', 'inputs', 'handle'));
	}

	public function postEdit($handle, $id)							# UPDATE
	{
		$model = Managers\ModelManager::resolve($handle);

		$input = array_except(App::make('request')->all(), array('_method','_token'));
		$validation = Validator::make($input, isset($model->rules) ? $model->rules : []);

		if ($validation->passes())
		{
			$entry = $model->find($id);
			foreach($input AS $name => $data)
			{
				$entry->$name = $data;
			}
			$entry->Save();

			return Redirect::route('scaffold.index', [$handle])
				->with('message', 'Entry updated.');
		}

		return Redirect::route('scaffold.edit', [$handle, $id])
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	public function postDelete($handle, $id)							# DELETE
	{
		$model = Managers\ModelManager::resolve($handle);

		$model->find($id)->delete();

		return Redirect::route('scaffold.index', [$handle])
			->with('message', 'Entry deleted.');
	}

}