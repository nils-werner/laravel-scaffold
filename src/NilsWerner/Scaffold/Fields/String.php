<?php namespace NilsWerner\Scaffold\Fields;

class String implements Field {
	public function render($handle)
	{
		return $handle;
	}
}