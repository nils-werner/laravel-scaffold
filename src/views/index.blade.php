@extends('scaffold::layout')

@section('main')

<h1>All Entries</h1>

<p>{{ link_to_route('scaffold.create', 'Add new entry', [$handle]) }}</p>

@if ($entries->count())
	<table class="table table-striped table-bordered">
		<thead>
			@foreach ($inputs as $input)
				<th>{{ $input->label() }}</th>
			@endforeach
			<td colspan="2" />
		</thead>

		<tbody>
			@foreach ($entries as $entry)
				<tr>
					@foreach ($inputs as $input)
						<td>{{ $entry->{$input->handle()} }}</td>
					@endforeach
					<td>{{ link_to_route('scaffold.edit', 'Edit', [$handle, $entry->id], ['class' => 'btn btn-info']) }}</td>
					<td>
						{{ Form::open(['route' => ['scaffold.delete', $handle, $entry->id]]) }}
							{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no entries
@endif

{{ $entries->links() }}

@stop