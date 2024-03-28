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

    <h1>{{ __('messages.to_change_label') }}</h1>

    {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
    {{ Form::label('name', __('messages.name')) }}<br>
    {{ Form::text('name', null, ['class' => 'w-25']) }}<br><br>
    {{ Form::label('description', __('messages.description') ) }}<br>
    {{ Form::textarea('description', null, ['class' => 'w-25']) }}<br><br>
    {{ Form::submit(__('messages.to_update'), ['class' => 'btn btn-primary ml-auto']) }}
    {{ Form::close() }}
</main>
@endsection
