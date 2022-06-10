@extends('layouts.app')

@section('content')

    @include('flash::message')

    <h1>{{ __('tasks.tasks') }}</h1>
    @auth
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
        {{ __('tasks.to_create') }}        </a>
    @endauth
    <table class="table mt-2">
        <thead>
        <tr>
            <th>{{ __('tasks.id') }}</th>
            <th>{{ __('tasks.status') }}</th>
            <th>{{ __('tasks.name') }}</th>
            <th>{{ __('tasks.author') }}</th>
            <th>{{ __('tasks.performer') }}</th>
            <th>{{ __('tasks.date_of_create') }}</th>
            @auth
            <th>{{ __('tasks.actions') }}</th>
            @endauth
        </tr>
        </thead>

        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td> <!-- ???????????????? статус(name) -->
                <td><a href="{{ route('tasks.show', ['task' => $task->id]) }} ">{{ $task->name }}</td>
                <td>{{ $task->creator->name }}</td> <!-- ????????????????? создатель (name) -->
                <td>{{ $task->performer->name }}</td> <!-- ????????????????? исполнитель (name) -->
                <td>{{ $task->created_at }}</td>
                @auth
                <td>

                    <a class="text-decoration-none" href="{{ route('tasks.edit', $task) }}">
                        {{ __('tasks.to_change') }}                        </a>
                </td>
                @endauth
            </tr>

        @endforeach
    </table>

@endsection


