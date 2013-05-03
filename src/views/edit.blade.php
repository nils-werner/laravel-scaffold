@extends('scaffold::layout')

@section('main')

<h1>Edit Entry</h1>

<h1>Edit User</h1>
{{ Form::open(['route' => ['scaffold.update', $handle, $entry->id]]) }}
	<ul>
		<li>
			{{ Form::label('realname', 'Name:') }}
			{{ Form::text('realname') }}
		</li>

		<li>
			{{ Form::submit('Update', ['class' => 'btn btn-info']) }}
			{{ HTML::link_to_route('scaffold.index', ['class' => 'btn']) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop