@extends('layouts.app')

@section('content')

    @include('flash::message')
    <main class="container">

    <h1>{{ __('messages.statuses') }}</h1>
    @auth
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">
        {{ __('messages.to_create_status') }}        </a>
    @endauth
    <table class="table mt-2">
        <thead>
        <tr>
            <th>{{ __('messages.id') }}</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.date_of_create') }}</th>
            @auth
            <th>{{ __('messages.actions') }}</th>
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
                        data-confirm="{{ __('messages.are_you_sure') }}"
                        data-method="delete"
                        rel="nofollow"
                    >
                        {{ __('messages.to_delete') }}                        </a>

                    <a class="text-decoration-none" href="{{ route('task_statuses.edit', $taskStatus) }}">
                        {{ __('messages.to_change') }}                        </a>
                </td>
                @endauth
            </tr>

        @endforeach
    </table>
    {{ $taskStatuses->links() }}
    </main>
@endsection


