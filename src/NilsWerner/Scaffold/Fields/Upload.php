<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Upload extends Field {

	public function input()
	{
		return Form::file($this->handle());
	}

}