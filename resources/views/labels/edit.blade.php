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

    {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
    {{ Form::label('name', __('messages.name')) }}
    {{ Form::text('name') }}<br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::text('description') }}<br>
    {{ Form::submit(__('messages.to_update')) }}
    {{ Form::close() }}

@endsection
