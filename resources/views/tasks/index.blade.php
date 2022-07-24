@extends('layouts.app')

@section('content')

    @include('flash::message')
    <main class="container">
    <h1>{{ __('messages.tasks') }}</h1>

    <div>
        {{--    {{ Form::model($task, ['route' => 'tasks.index']) }}    --}}
        {{ Form::open(['url' => route('tasks.index'), 'method' => 'get']) }}
        {{ Form::select('filter[status_id]', $statuses, null, ['placeholder' => __('messages.status')]) }}
        {{ Form::select('filter[created_by_id]', $users, null, ['placeholder' => __('messages.author')]) }}
        {{ Form::select('filter[assigned_to_id]', $users, null, ['placeholder' => __('messages.performer')]) }}
        {{ Form::submit( __('messages.to_apply') ) }}
        {{ Form::close() }}
    </div>

    @auth
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            {{ __('messages.to_create_task') }}        </a>
    @endauth
    <table class="table mt-2">
        <thead>
        <tr>
            <th>{{ __('messages.id') }}</th>
            <th>{{ __('messages.status') }}</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.author') }}</th>
            <th>{{ __('messages.performer') }}</th>
            <th>{{ __('messages.date_of_create') }}</th>
            @auth
                <th>{{ __('messages.actions') }}</th>
            @endauth
        </tr>
        </thead>

        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td> <!-- статус(name) -->
                <td><a href="{{ route('tasks.show', ['task' => $task]) }} ">{{ $task->name }}</td>
                <td>{{ $task->creator->name }}</td> <!--  создатель (name) -->
                <td>{{ $task->performer->name ?? null}}</td> <!-- исполнитель (name) -->
                <td>{{ $task->created_at->format('d-m-Y') }}</td>
                @auth

                    <td>
                        @if ($task->created_by_id == Auth::id())
                            <a
                                class="text-danger text-decoration-none"
                                href="{{ route('tasks.destroy', $task) }}"
                                data-confirm="{{ __('messages.are_you_sure') }}"
                                data-method="delete"
                                rel="nofollow"
                            >
                                {{ __('messages.to_delete') }}                        </a>
                        @endif
                        <a class="text-decoration-none" href="{{ route('tasks.edit', $task) }}">
                            {{ __('messages.to_change') }}                        </a>
                    </td>
                @endauth
            </tr>

        @endforeach
    </table>
    {{ $tasks->links() }}
    </main>
@endsection
