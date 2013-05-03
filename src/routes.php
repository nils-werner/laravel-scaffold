<?php

Route::group(array('prefix' => 'scaffold'), function()
{
	Route::get('{handle}', array(
		'as' => 'scaffold.index',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@getIndex'
		));

	Route::get('{handle}/create', array(
		'as' => 'scaffold.create',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@getCreate'
		));

	Route::post('{handle}', array(
		'as' => 'scaffold.store',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@postIndex'
		));

	Route::get('{handle}/{id}/edit', array(
		'as' => 'scaffold.edit',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@getEdit'
		));

	Route::post('{handle}/{id}', array(
		'as' => 'scaffold.update',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@postEdit'
		));

	Route::post('{handle}/{id}/delete', array(
		'as' => 'scaffold.delete',
		'uses' => 'NilsWerner\Scaffold\ScaffoldController@postDelete'
		));
});