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
        <h1>{{ __('tasks.show_name') }}: {{$task->name}}</h1>
        <div>{{ __('tasks.name') }}: {{$task->name}}</div><br>
        <div>{{ __('tasks.status') }}: {{$status->name}}</div><br>
        <div>{{ __('tasks.description') }}: {{$task->description}}</div><br>
        <div>{{ __('tasks.labels') }}:<br>
            <ul>
                @foreach ($labelsNames as $labelName)
                    <li>{{ $labelName[0] }}</li>
                @endforeach
            </ul>
        </div>
@endsection

