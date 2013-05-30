<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class String extends Field {

	public function input()
	{
		return Form::text($this->handle());
	}

}