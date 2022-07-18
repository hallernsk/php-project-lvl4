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
        <h1>{{ __('messages.show_task') }}: {{$task->name}}</h1>
        <div>{{ __('messages.name') }}: {{$task->name}}</div><br>
        <div>{{ __('messages.status') }}: {{$status->name}}</div><br>
        <div>{{ __('messages.description') }}: {{$task->description}}</div><br>
        <div>{{ __('messages.labels') }}:<br>
            <ul>
                @foreach ($labelsNames as $labelName)
                    <li>{{ $labelName[0] }}</li>
                @endforeach
            </ul>
        </div>
@endsection

