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

    {{ Form::model($label, ['route' => 'labels.store']) }}
    {{ Form::label('name', __('labels.name') ) }}
    {{ Form::text('name') }}<br>
    {{ Form::label('description', __('labels.description') ) }}<br>
    {{ Form::text('description') }}<br>
    {{ Form::submit( __('labels.to_create') ) }}
    {{ Form::close() }}

@endsection
