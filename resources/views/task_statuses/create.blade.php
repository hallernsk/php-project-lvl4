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

    {{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    {{ Form::label('name', __('messages.name') ) }}
    {{ Form::text('name') }}<br>
    {{ Form::submit( __('messages.to_create') ) }}
    {{ Form::close() }}
</main>
@endsection
