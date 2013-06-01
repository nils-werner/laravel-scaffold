<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\App;

class Password extends Field {

	public function input()
	{
		return App::make('form')->password($this->handle());
	}

}