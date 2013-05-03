@extends('scaffold::layout')

@section('main')

<h1>All Entries</h1>

<p>{{ link_to_route('scaffold.create', 'Add new user', [$handle]) }}</p>

@if ($entries->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($entries as $entry)
				<tr>
					<td>{{ $entry->name }}</td>
					<td>{{ link_to_route('scaffold.edit', 'Edit', [$handle, $entry->id], ['class' => 'btn btn-info']) }}</td>
					<td>
						{{ Form::open(['route' => ['scaffold.delete', $handle, $entry->id]]) }}
							{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}</td>
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no entries
@endif

@stop