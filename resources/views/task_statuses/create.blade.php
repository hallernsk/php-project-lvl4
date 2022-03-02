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

    {{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    {{ Form::label('name', 'Имя') }}
    {{ Form::text('name') }}<br>
    {{ Form::submit('Создать') }}
    {{ Form::close() }}

@endsection
