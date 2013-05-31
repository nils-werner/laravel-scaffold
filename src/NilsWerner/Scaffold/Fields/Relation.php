<?php namespace NilsWerner\Scaffold\Fields;

use Illuminate\Support\Facades\Form;

class Relation extends Field {

	protected $handle;
	protected $relation;

	public function __construct($app, $model, $columns, $handle)
	{
		$this->relation = $model->$handle();
		$this->model = $model;
		$this->column = NULL;
		$this->handle = $handle;
	}

	public function input()
	{
		return "Relation";
	}

	public function handle()
	{
		return $this->handle;
	}

	public function table($entry)
	{
		if(is_a($this->relation, 'Illuminate\Database\Eloquent\Relations\BelongsTo'))
		{
			$row = $entry->{$this->handle()}->first()->getAttributes();
			$keys = array_keys($row);
			return $row[$keys[1]];
		}
		else if(is_a($this->relation, 'Illuminate\Database\Eloquent\Relations\HasMany'))
		{
			return $entry->{$this->handle()}->count();
		}
	}

}