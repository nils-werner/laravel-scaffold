<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\App;

class Upload extends Field {

	public function input()
	{
		return App::make('form')->file($this->handle());
	}

}