<?php namespace NilsWerner\Scaffold\Managers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class FieldManager extends Manager {

	public static function getColumns($model)
	{
		return self::getAttributesFromMember($model, 'columns');
	}

	public static function getFields($model)
	{
		return self::getAttributesFromMember($model, 'fields');
	}

	public static function getAttributesFromMember($model, $member)
	{
		$columns = DB::getDoctrineSchemaManager()->listTableDetails($model->getTable())->getColumns();

		$ret = array();

		if(isset($model->$member))
		{
			foreach($model->$member AS $key => $val)
			{
				if(is_int($key))
				{
					$handle = $val;
					$type = "string";
				}
				else
				{
					$handle = $key;
					$type = $val;
				}
				$ret[] = App::make('Scaffold\\Fields\\' . ucfirst($type), array($model, $columns, $handle));
			}
		}
		else
		{
			foreach($columns AS $item)
			{
				$handle = $item->getName();
				$type = "string";

				if(!in_array($handle, ['id', 'created_at', 'updated_at']))
				{
					$ret[] = App::make('Scaffold\\Fields\\' . ucfirst($type), array($model, $columns, $handle));
				}
			}
		}
		return $ret;
	}

}