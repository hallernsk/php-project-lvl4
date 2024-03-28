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

    <h1>{{ __('messages.to_change_status') }}</h1>    

    {{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
        {{ Form::label('name', __('messages.name')) }}
        <br>
        {{ Form::text('name', null, ['class' => 'w-25']) }}
        <br><br>
    {{ Form::submit(__('messages.to_update'), ['class' => 'btn btn-primary ml-auto']) }}
    {{ Form::close() }}
</main>
@endsection
