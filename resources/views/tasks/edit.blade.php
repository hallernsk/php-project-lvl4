@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::model($task, ['route' => 'tasks.store']) }}
    {{ Form::label('name', __('tasks.name') ) }}<br>
    {{ Form::text('name') }}<br>
    {{ Form::label('description', __('tasks.description') ) }}<br>
    {{ Form::text('description') }}<br>
    {{ Form::label('status', __('tasks.status') ) }}<br>
    {{ Form::text('status') }}<br>
    {{ Form::label('performer', __('tasks.performer') ) }}<br>
    {{ Form::text('performer') }}<br>
    {{ Form::submit( __('tasks.to_create') ) }}
    {{ Form::close() }}

@endsection
