<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Password extends Field {

	public function input()
	{
		return Form::password($this->handle());
	}

}