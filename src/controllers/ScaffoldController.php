<?php namespace NilsWerner\Scaffold;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
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
		$entries = $model->paginate(15);
		$columns = $this->getColumns($model);
		$inputs = $this->generateInputs($columns);

		return View::make('scaffold::index', compact('entries', 'handle', 'inputs'));
	}

	public function getCreate($handle)								# CREATE
	{	
		$model = $this->resolveModel($handle);
		$columns = $this->getFields($model);
		$inputs = $this->generateInputs($columns);
		$entry = new $model();

		return View::make('scaffold::create', compact('entry', 'handle', 'inputs'));
	}

	public function postIndex($handle)								# STORE
	{
		$model = $this->resolveModel($handle);

		$input = Input::all();
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
		$model = $this->resolveModel($handle);

		$entry = $model->find($id);
		$columns = $this->getFields($model);
		$inputs = $this->generateInputs($columns);

		if (is_null($entry))
		{
			return Redirect::route('scaffold.index', [$handle]);
		}

		return View::make('scaffold::edit', compact('entry', 'inputs', 'handle'));
	}

	public function postEdit($handle, $id)							# UPDATE
	{
		$model = $this->resolveModel($handle);

		$input = array_except(Input::all(), array('_method','_token'));
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
		$model = $this->resolveModel($handle);

		$model->find($id)->delete();

		return Redirect::route('scaffold.index', [$handle])
			->with('message', 'Entry deleted.');
	}


/*
|
| Utilities
|
*/

	protected function resolveModel($handle)
	{
		$model = $this->spinalCaseToCamelCase($handle);
		if(is_subclass_of($model, 'Eloquent'))
		{
			return App::make($model);
		}
		else
		{
			App::abort(404, 'Page not found');
		}
	}

	protected function getColumns($model)
	{
		return $this->getAttributesFromMember($model, 'columns');
	}

	protected function getFields($model)
	{
		return $this->getAttributesFromMember($model, 'fields');
	}

	protected function getAttributesFromMember($model, $member)
	{
		$columns = DB::getDoctrineSchemaManager()->listTableDetails($model->getTable())->getColumns();

		if(isset($model->$member))
		{
			foreach($model->$member AS $key => $val)
			{
				if(is_int($key))
				{
					$handle = $val;
					$type = "string";
				}
				else
				{
					$handle = $key;
					$type = $val;
				}
				if(isset($columns[$handle]))
				{
					$ret[$handle] = [ $columns[$handle], $type ];
				}
			}
		}
		else
		{
			foreach($columns AS $item)
			{
				$handle = $item->getName();
				$ret[$handle] = [ $columns[$handle], "string" ];
			}
		}
		return $ret;
	}

	protected function generateInputs($columns)
	{
		$inputs = [];
		foreach($columns AS $column)
		{
			if(!in_array($column[0]->getName(), ['id', 'created_at', 'updated_at']))
			{
				//if(is_a($column->getType(), "Doctrine\DBAL\Types\IntegerType"))
				$inputs[] = App::make('Scaffold\\Fields\\' . ucfirst($column[1]))->render($column[0]->getName());
			}
		}
		return $inputs;
	}

	protected function spinalCaseToCamelCase($input)
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $input)));
	}

}