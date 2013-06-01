<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\App;

class String extends Field {

	public function input()
	{
		return App::make('form')->text($this->handle());
	}

}