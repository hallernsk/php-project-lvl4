@extends('layouts.app')

@section('content')

    @include('flash::message')

    <h1>{{ __('task_statuses.statuses') }}</h1>
    @auth
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">
        {{ __('task_statuses.to_create_status') }}        </a>
    @endauth
    <table class="table mt-2">
        <thead>
        <tr>
            <th>{{ __('task_statuses.id') }}</th>
            <th>{{ __('task_statuses.name') }}</th>
            <th>{{ __('task_statuses.date_of_create') }}</th>
            @auth
            <th>{{ __('task_statuses.actions') }}</th>
            @endauth
        </tr>
        </thead>

        @foreach ($taskStatuses as $taskStatus)
            <tr>
                <td>{{ $taskStatus->id }}</td>
                <td>{{ $taskStatus->name }}</td>
                <td>{{ $taskStatus->created_at }}</td>
                @auth
                <td>
                    <a
                        class="text-danger text-decoration-none"
                        href="{{ route('task_statuses.destroy', $taskStatus) }}"
                        data-confirm="{{ __('task_statuses.are_you_sure') }}"
                        data-method="delete"
                        rel="nofollow"
                    >
                        {{ __('task_statuses.to_delete') }}                        </a>

                    <a class="text-decoration-none" href="{{ route('task_statuses.edit', $taskStatus) }}">
                        {{ __('task_statuses.to_change') }}                        </a>
                </td>
                @endauth
            </tr>

        @endforeach
    </table>

@endsection


