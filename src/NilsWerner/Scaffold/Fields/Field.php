<?php namespace NilsWerner\Scaffold\Fields;

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

	public function render()
	{
		return $this->handle;
	}

}