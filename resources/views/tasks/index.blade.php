@extends('layouts.app')

@section('content')

    <main class="container">
    <h1 class=" mb-5">{{ __('messages.tasks') }}</h1>
        <div class="w-full flex">
            <div>

                {{ Form::open(['url' => route('tasks.index'), 'method' => 'get']) }}
                <div class="row g-1">

                <div class="col">
                {{ Form::select('filter[status_id]', $statuses, $filter['status_id'] ?? null, ['class' => 'form-select me-2','placeholder' => __('messages.status')]) }}
                </div>
                <div class="col">
                {{ Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? null, ['class' => 'form-select me-2','placeholder' => __('messages.author')]) }}
                </div>
                <div class="col">
                {{ Form::select('filter[assigned_to_id]', $users, $filter['assigned_to_id'] ??null, ['class' => 'form-select me-2','placeholder' => __('messages.performer')]) }}
                </div>
                <div class="col">
                {{ Form::submit( __('messages.to_apply'), ['class' => 'btn btn-outline-primary me-2'] ) }}
                </div>
                <div class="col">
                {{ Form::close() }}
                </div>

                


                <!-- <div class="ms-auto"> -->
                <div class="col text-end">
                @auth
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">
                        {{ __('messages.to_create_task') }}        </a>
                @endauth
                </div>

                </div>

            </div>

        </div>

        <br>

        <table class="table me-2">
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
            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->status->name }}</td> <!-- статус(name) -->
                    <td><a href="{{ route('tasks.show', ['task' => $task]) }} ">{{ $task->name }}</td>
                    <td>{{ $task->creator->name }}</td> <!--  создатель (name) -->
                    <td>{{ $task->performer->name ?? null}}</td> <!-- исполнитель (name) -->
                    <td>{{ $task->created_at->format('d.m.Y') }}</td>
                    <td>
                        @can('delete', $task)
                            <a
                                class="text-danger text-decoration-none"
                                href="{{ route('tasks.destroy', $task) }}"
                                data-confirm="{{ __('messages.are_you_sure') }}"
                                data-method="delete"
                                rel="nofollow"
                            >
                                {{ __('messages.to_delete') }}                        </a>
                        @endcan
                        @can('update', $task)
                            <a class="text-decoration-none" href="{{ route('tasks.edit', $task) }}">
                            {{ __('messages.to_change') }}                        </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <nav>
            {{ $tasks->links() }}
        </nav>
    </main>
@endsection
