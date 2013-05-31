<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Field {

	protected $column;
	protected $model;

	public function __construct($app, $model, $columns, $handle)
	{
		$this->model = $model;
		$this->column = $columns[$handle];
	}

	public function handle()
	{
		return $this->column->getName();
	}

	public function column()
	{
		return ucfirst($this->handle());
	}

	public function label()
	{
		return Form::label($this->handle(), ucfirst($this->handle()));
	}

	public function input()
	{
		return $this->handle() . " not implemented";
	}

	public function table($entry)
	{
		return $entry->{$this->handle()};
	}

}