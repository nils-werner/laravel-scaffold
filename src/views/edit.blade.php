@extends('scaffold::layout')

@section('main')

<h1>Edit Entry</h1>

{{ Form::model($entry, ['route' => ['scaffold.update', $handle, $entry->id]]) }}
	<ul>
		@foreach ($inputs as $input)
			<li>
				{{ $input->label() }}
				{{ $input->input() }}
			</li>
		@endforeach

		<li>
			{{ Form::submit('Update', ['class' => 'btn btn-info']) }}
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