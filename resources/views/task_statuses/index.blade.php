@extends('layouts.app')

@section('content')

    @include('flash::message')

    <h1>Статусы</h1>
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">
        Создать статус        </a>

    <table class="table mt-2">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>

        @foreach ($taskStatuses as $taskStatus)
            <tr>
                <td>{{ $taskStatus->id }}</td>
                <td>{{ $taskStatus->name }}</td>
                <td>{{ $taskStatus->created_at }}</td>
                <td>
                    <a
                        class="text-danger text-decoration-none"
                        href="{{ route('task_statuses.destroy', $taskStatus) }}"
                        data-confirm="Вы уверены?"
                        data-method="delete"
                        rel="nofollow"
                    >
                        Удалить                        </a>

                    <a class="text-decoration-none" href="{{ route('task_statuses.edit', $taskStatus) }}">
                        Изменить                        </a>
                </td>
            </tr>

        @endforeach
    </table>

@endsection


