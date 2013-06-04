<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\App;

class Upload extends Field {

	private $destination = public_path() . "/uploads";

	public function input()
	{
		return App::make('form')->file($this->handle());
	}

	public function process($input)
	{
		$input->move($this->destination,$input->getClientOriginalName());
		return $input;
	}

}