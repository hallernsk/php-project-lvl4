@extends('layouts.app')

@section('content')

    @include('flash::message')

    <h1>{{ __('labels.labels') }}</h1>
    @auth
        <a href="{{ route('labels.create') }}" class="btn btn-primary">
            {{ __('labels.to_create') }}        </a>
    @endauth
    <table class="table mt-2">
        <thead>
        <tr>
            <th>{{ __('labels.id') }}</th>
            <th>{{ __('labels.name') }}</th>
            <th>{{ __('labels.description') }}</th>
            <th>{{ __('labels.date_of_create') }}</th>
            @auth
                <th>{{ __('labels.actions') }}</th>
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
                            data-confirm="{{ __('task_statuses.are_you_sure') }}"
                            data-method="delete"
                            rel="nofollow"
                        >
                            {{ __('labels.to_delete') }}                        </a>

                        <a class="text-decoration-none" href="{{ route('labels.edit', $label) }}">
                            {{ __('labels.to_change') }}                        </a>
                    </td>
                @endauth
            </tr>

        @endforeach
    </table>

@endsection

