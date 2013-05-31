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
			return "<a href=\"" . $this->linkToModel() . "/" . $row[$keys[0]] . "/edit\">" . $row[$keys[1]] . "</a>";
		}
		else if(is_a($this->relation, 'Illuminate\Database\Eloquent\Relations\HasMany'))
		{
			return "<a href=\"" . $this->linkToModel() . "\">" . $entry->{$this->handle()}->count() . "</a>";
		}
	}

	protected function linkToModel()
	{
		return strtolower(get_class($this->relation->getModel()));
	}

}