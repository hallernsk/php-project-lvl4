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

    {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
    {{ Form::label('name', __('tasks.name') ) }}<br>
    {{ Form::text('name') }}<br>
    {{ Form::label('description', __('tasks.description') ) }}<br>
    {{ Form::text('description') }}<br>
    {{ Form::label('status', __('tasks.status') ) }}<br>
    {{ Form::select('status_id', $taskStatuses) }}<br>
    {{ Form::label('performer', __('tasks.performer') ) }}<br>
    {{ Form::select('assigned_to_id', $users) }}<br>
    {{ Form::submit( __('tasks.to_change') ) }}
    {{ Form::close() }}

@endsection
