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

    {{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
    {{ Form::label('name', __('messages.name') ) }}<br>
    {{ Form::text('name') }}<br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::textarea('description') }}<br>
    {{ Form::label('status', __('messages.status') ) }}<br>
    {{ Form::select('status_id', $taskStatuses) }}<br>
    {{ Form::label('performer', __('messages.performer') ) }}<br>
    {{ Form::select('assigned_to_id', $users) }}<br>

    {{ Form::label('labels', __('messages.labels') ) }}<br>
    {{ Form::select('labels[]', $labels, null, ['multiple' => 'multiple']) }}<br>

    {{ Form::submit( __('messages.to_change') ) }}
    {{ Form::close() }}
</main>
@endsection
