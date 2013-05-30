<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Field {

	protected $handle = '';

	public function __construct($app, $handle)
	{
		$this->handle = $handle;
	}

	public function handle()
	{
		return $this->handle;
	}

	public function column()
	{
		return ucfirst($this->handle);
	}

	public function label()
	{
		return Form::label($this->handle(), ucfirst($this->handle()));
	}

	public function input()
	{
		return $this->handle . " not implemented";
	}

}