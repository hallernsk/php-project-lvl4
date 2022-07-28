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

    {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
    {{ Form::label('name', __('messages.name')) }}<br>
    {{ Form::text('name') }}<br><br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::textarea('description') }}<br><br>
    {{ Form::submit(__('messages.to_update')) }}
    {{ Form::close() }}
</main>
@endsection
