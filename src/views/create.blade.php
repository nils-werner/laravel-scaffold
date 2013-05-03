@extends('scaffold::layout')

@section('main')

<h1>Create Entry</h1>

{{ Form::open(['route' => ['scaffold.store', $handle]]) }}
    <ul>
        <li>
            {{ Form::label('realname', 'Name:') }}
            {{ Form::text('realname') }}
        </li>

        <li>
            {{ Form::submit('Submit', ['class' => 'btn']) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop


