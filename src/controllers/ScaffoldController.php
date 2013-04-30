<?php namespace NilsWerner\Scaffold;

use Illuminate\Routing\Controllers\Controller;
use Illuminate\Support\Facades\View;

class ScaffoldController extends Controller {

	public function __construct()
	{
	}


/*
|
| URL and View Handling
|
*/

	public function getIndex($model)								# INDEX
	{
		$model = $this->resolveModel($model);
		$entries = $model->all();

		return View::make('scaffold::index', compact('entries'));
	}

	public function getCreate($model)								# CREATE
	{	
		$model = $this->resolveModel($model);

		return View::make('scaffold::create');
	}

	public function postIndex($model)								# STORE
	{
		$model = $this->resolveModel($model);

		$input = Input::all();
		$validation = Validator::make($input, $model::$rules);

		if ($validation->passes())
		{
			$model->create($input);

			return Redirect::route('scaffold.index');
		}

		return Redirect::route('scaffold.create')
			->withInput()
			->withErrors($validation)
			->with('flash', 'There were validation errors.');
	}

	public function getEdit($model, $id)							# EDIT
	{
		$model = $this->resolveModel($model);

		$entry = $model->find($id);

		if (is_null($entry))
		{
			return Redirect::route('scaffold.index');
		}

		return View::make('scaffold::edit', compact('entry'));
	}

	public function postEdit($model, $id)							# UPDATE
	{
		$model = $this->resolveModel($model);

		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, $model::$rules);

		if ($validation->passes())
		{
			$entry = $model->find($id);
			$user->update($input);

			return Redirect::route('scaffold.edit', $id);
		}

		return Redirect::route('scaffold.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('flash', 'There were validation errors.');
	}

	public function postDelete($model, $id)							# DELETE
	{
		$model = $this->resolveModel($model);

		$model->find($id)->delete();

		return Redirect::route('scaffold.index');
	}


/*
|
| Utilities
|
*/

	protected function resolveModel($model)
	{
		$model = ucfirst($model);
		if(is_subclass_of($model, 'Eloquent'))
		{
			return new $model();
		}
		else
		{
			App::abort(404, 'Page not found');
		}
	}

	protected function getColumns($model)
	{
		return DB::getDoctrineSchemaManager()->listTableDetails($model->getTable())->getColumns();
	}

}