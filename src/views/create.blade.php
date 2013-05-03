@extends('scaffold::layout')

@section('main')

<h1>Create Entry</h1>

{{ Form::model($entry, ['route' => ['scaffold.store', $handle]]) }}
	<ul>
		@foreach ($inputs as $input)
			<li>
				{{ Form::label($input, ucfirst($input)) }}
				{{ Form::text($input) }}
			</li>
		@endforeach

		<li>
			{{ Form::submit('Submit', ['class' => 'btn']) }}
			{{ link_to_route('scaffold.index', 'Cancel', [$handle], ['class' => 'pull-right']) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


