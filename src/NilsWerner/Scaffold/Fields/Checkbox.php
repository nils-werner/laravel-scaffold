<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Checkbox extends Field {

	public function input()
	{
		return Form::checkbox($this->handle());
	}

}