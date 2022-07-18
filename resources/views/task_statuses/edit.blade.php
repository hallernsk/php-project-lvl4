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
        {{ Form::label('name', __('messages.name')) }}
        {{ Form::text('name') }}<br>
    {{ Form::submit(__('messages.to_update')) }}
    {{ Form::close() }}

@endsection
