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

    <h1>{{ __('messages.to_create_task') }}</h1>

    {{ Form::model($task, ['route' => 'tasks.store']) }}
    {{ Form::label('name', __('messages.name') ) }}<br>
    {{ Form::text('name') }}<br><br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::text('description') }}<br><br>
    {{ Form::label('status_id', __('messages.status') ) }}<br>
    {{ Form::select('status_id', $taskStatuses, null, ['placeholder' => '----------']) }}<br><br>
    {{ Form::label('performer', __('tasks.performer') ) }}<br>
    {{ Form::select('assigned_to_id', $users, null, ['placeholder' => '----------']) }}<br><br>
    {{ Form::label('labels', __('messages.labels') ) }}<br>
    {{ Form::select('labels[]', $labels, null, ['multiple' => 'multiple', 'placeholder' => '']) }}<br><br>
    {{ Form::submit( __('messages.to_create') ) }}
    {{ Form::close() }}

@endsection
