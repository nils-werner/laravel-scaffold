<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\App;

class Checkbox extends Field {

	public function input()
	{
		return App::make('form')->checkbox($this->handle());
	}

}