@extends('layouts.app')

@section('content')

    @include('flash::message')

    <h1>{{ __('messages.labels') }}</h1>
    @auth
        <a href="{{ route('labels.create') }}" class="btn btn-primary">
            {{ __('messages.to_create_label') }}        </a>
    @endauth
    <table class="table mt-2">
        <thead>
        <tr>
            <th>{{ __('messages.id') }}</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.description') }}</th>
            <th>{{ __('messages.date_of_create') }}</th>
            @auth
                <th>{{ __('messages.actions') }}</th>
            @endauth
        </tr>
        </thead>

        @foreach ($labels as $label)
            <tr>
                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description }}</td>
                <td>{{ $label->created_at }}</td>
                @auth
                    <td>
                        <a
                            class="text-danger text-decoration-none"
                            href="{{ route('labels.destroy', $label) }}"
                            data-confirm="{{ __('messages.are_you_sure') }}"
                            data-method="delete"
                            rel="nofollow"
                        >
                            {{ __('messages.to_delete') }}                        </a>

                        <a class="text-decoration-none" href="{{ route('labels.edit', $label) }}">
                            {{ __('messages.to_change') }}                        </a>
                    </td>
                @endauth
            </tr>

        @endforeach
    </table>

@endsection

