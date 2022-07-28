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

    {{ Form::model($label, ['route' => 'labels.store']) }}
    {{ Form::label('name', __('messages.name') ) }}<br>
    {{ Form::text('name') }}<br><br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::textarea('description') }}<br><br>
    {{ Form::submit( __('messages.to_create') ) }}
    {{ Form::close() }}
</main>
@endsection
