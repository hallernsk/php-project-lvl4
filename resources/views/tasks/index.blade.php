@extends('layouts.app')

@section('content')

    @include('flash::message')

    <h1>{{ __('tasks.tasks') }}</h1>

<div>
    {{--    {{ Form::model($task, ['route' => 'tasks.index']) }}    --}}
    {{ Form::open(['url' => route('tasks.index'), 'method' => 'get']) }}
    {{ Form::select('filter[status_id]', $statuses, null, ['placeholder' => __('tasks.status')]) }}
    {{ Form::select('filter[created_by_id]', $users, null, ['placeholder' => __('tasks.author')]) }}
    {{ Form::select('filter[assigned_to_id]', $users, null, ['placeholder' => __('tasks.performer')]) }}
    {{ Form::submit( __('tasks.to_apply') ) }}
    {{ Form::close() }}
</div>

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
            <td>{{ $task->status->name }}</td> <!-- статус(name) -->
            <td><a href="{{ route('tasks.show', ['task' => $task->id]) }} ">{{ $task->name }}</td>
            <td>{{ $task->creator->name }}</td> <!--  создатель (name) -->
            <td>{{ $task->performer->name ?? null}}</td> <!-- исполнитель (name) -->
            <td>{{ $task->created_at }}</td>
            @auth

            <td>
                @if ($task->created_by_id == Auth::id())
                <a
                    class="text-danger text-decoration-none"
                    href="{{ route('tasks.destroy', $task) }}"
                    data-confirm="{{ __('tasks.are_you_sure') }}"
                    data-method="delete"
                    rel="nofollow"
                >
                    {{ __('tasks.to_delete') }}                        </a>
                @endif
                <a class="text-decoration-none" href="{{ route('tasks.edit', $task) }}">
                    {{ __('tasks.to_change') }}                        </a>
            </td>
            @endauth
        </tr>

    @endforeach
</table>

@endsection


