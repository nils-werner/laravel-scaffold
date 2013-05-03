@extends('scaffold::layout')

@section('main')

<h1>Edit Entry</h1>

{{ Form::model($entry, ['route' => ['scaffold.update', $handle, $entry->id]]) }}
	<ul>
		@foreach ($inputs as $input)
			<li>
				{{ $input[0] }}
				{{ $input[1] }}
			</li>
		@endforeach

		<li>
			{{ Form::submit('Update', ['class' => 'btn btn-info']) }}
			{{ link_to_route('scaffold.index', 'Cancel', [$handle], ['class' => 'btn']) }}</p>
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop