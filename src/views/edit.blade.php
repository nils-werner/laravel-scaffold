@extends('scaffold::layout')

@section('main')

<h1>Edit Entry</h1>

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop