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

    <h1>{{ __('messages.to_change_task') }}</h1>

    {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
    {{ Form::label('name', __('messages.name') ) }}<br>
    {{ Form::text('name', null, ['class' => 'w-25']) }}<br><br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::textarea('description', null, ['class' => 'w-25']) }}<br><br>
    {{ Form::label('status', __('messages.status') ) }}<br>
    {{ Form::select('status_id', $taskStatuses, null, ['class' => 'w-25']) }}<br><br>
    {{ Form::label('performer', __('messages.performer') ) }}<br>
    {{ Form::select('assigned_to_id', $users, null, ['class' => 'w-25']) }}<br><br>

    {{ Form::label('labels', __('messages.labels') ) }}<br>
    {{ Form::select('labels[]', $labels, null, ['multiple' => 'multiple', 'placeholder' => '', 'class' => 'w-25']) }}<br><br>

    {{ Form::submit( __('messages.to_update'), ['class' => 'btn btn-primary ml-auto'] ) }}
    {{ Form::close() }}
</main>
@endsection
