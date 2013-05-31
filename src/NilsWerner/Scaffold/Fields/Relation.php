<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Relation extends Field {

	protected $handle;
	protected $relation;

	public function __construct($app, $model, $columns, $handle)
	{
		$this->relation = $model->$handle();
		$this->model = $model;
		$this->column = NULL;
		$this->handle = $handle;
	}

	public function input()
	{
		return "Relation";
	}

	public function handle()
	{
		return $this->handle;
	}

}