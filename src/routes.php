<?php

Route::group(array('prefix' => 'scaffold'), function()
{
	Route::get('{model}', array(
		'as' => 'scaffold.index',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@getIndex'
		));

	Route::get('{model}/create', array(
		'as' => 'scaffold.create',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@getCreate'
		));

	Route::post('{model}', array(
		'as' => 'scaffold.store',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@postIndex'
		));

	Route::get('{model}/{id}/edit', array(
		'as' => 'scaffold.edit',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@getEdit'
		));

	Route::post('{model}/{id}', array(
		'as' => 'scaffold.update',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@postEdit'
		));

	Route::post('{model}/{id}/delete', array(
		'as' => 'scaffold.delete',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@postDelete'
		));
});