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

    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
        {{ Form::label('name', __('task_statuses.name')) }}
        {{ Form::text('name') }}<br>
    {{ Form::submit(__('task_statuses.to_update')) }}
    {{ Form::close() }}

@endsection
