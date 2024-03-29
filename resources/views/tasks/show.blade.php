@extends('layouts.app')

@section('content')
<main class="container">
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
        <div>{{ __('messages.status') }}: {{$task->status->name}}</div><br>
        <div>{{ __('messages.description') }}: {{$task->description}}</div><br>
        @if($task->labels->isNotEmpty())
            <div>{{ __('messages.labels') }}:<br>
                <ul>
                    @foreach ($task->labels as $label)
                        <li>{{ $label->name }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
</main>
@endsection

