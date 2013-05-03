<?php namespace NilsWerner\Scaffold;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\View;
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
		$model = $this->resolveModel($handle);
		$entries = $model->all();

		return View::make('scaffold::index', compact('entries', 'handle'));
	}

	public function getCreate($handle)								# CREATE
	{	
		$model = $this->resolveModel($handle);
		$columns = $this->getColumns($model);
		$inputs = $this->generateInputs($columns);

		return View::make('scaffold::create', compact('handle', 'inputs'));
	}

	public function postIndex($handle)								# STORE
	{
		$model = $this->resolveModel($handle);

		$input = Input::all();
		$validation = Validator::make($input, isset($model::$rules) ? $model::$rules : []);

		if ($validation->passes())
		{
			$model->create($input);
			return Redirect::route('scaffold.index', [$handle]);
		}

		return Redirect::route('scaffold.create', [$handle])
			->withInput()
			->withErrors($validation)
			->with('flash', 'There were validation errors.');
	}

	public function getEdit($model, $id)							# EDIT
	{
		$model = $this->resolveModel($handle);

		$entry = $model->find($id);
		$columns = $this->getColumns($model);

		$this->generateInputs($columns);

		if (is_null($entry))
		{
			return Redirect::route('scaffold.index', [$handle]);
		}

		return View::make('scaffold::edit', compact('entry'));
	}

	public function postEdit($model, $id)							# UPDATE
	{
		$model = $this->resolveModel($handle);

		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, $model::$rules);

		if ($validation->passes())
		{
			$entry = $model->find($id);
			$user->update($input);

			return Redirect::route('scaffold.edit', [$handle, $id]);
		}

		return Redirect::route('scaffold.edit', [$handle, $id])
			->withInput()
			->withErrors($validation)
			->with('flash', 'There were validation errors.');
	}

	public function postDelete($handle, $id)							# DELETE
	{
		$model = $this->resolveModel($handle);

		$model->find($id)->delete();

		return Redirect::route('scaffold.index', [$handle]);
	}


/*
|
| Utilities
|
*/

	protected function resolveModel($handle)
	{
		$model = ucfirst($handle);
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

	protected function generateInputs($columns)
	{
		$inputs = [];
		foreach($columns AS $column)
		{
			if(!in_array($column->getName(), ['id', 'created_at', 'updated_at']))
			{
				//if(is_a($column->getType(), "Doctrine\DBAL\Types\IntegerType"))
				$inputs[] = [Form::label($column->getName(), ucfirst($column->getName())), Form::text($column->getName())];
			}
		}
		return $inputs;
	}

}