<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Field {

	protected $column = '';

	public function __construct($app, $column)
	{
		$this->column = $column;
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

}