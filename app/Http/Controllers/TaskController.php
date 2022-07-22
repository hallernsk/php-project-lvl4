<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ])
            ->get();
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.index', ['tasks' => $tasks, 'statuses' => $statuses, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task();
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.create', compact('task', 'taskStatuses', 'users', 'labels'));        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks',
            'status_id' => 'required',
            'description' => 'required',
            'assigned_to_id' => 'required',
        ]);
        $user = Auth::user();
        $task = $user->tasksCreated()->make($data);
        $task->save();

        $labels = $request->labels;
        $task->labels()->attach($labels);

        flash(__('flash.task_created'))->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $status = TaskStatus::findOrFail($task->status_id);
        $labels = DB::table('label_task')
                    ->where('task_id', '=', $task->id)
                    ->get();
        $labelsNames = [];
        foreach ($labels as $label) {
            $labelsNames[] = DB::table('labels')
                                ->where('id', $label->label_id)
                                ->pluck('name');
        }

        return view('tasks.show', compact('task', 'status', 'labelsNames'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:tasks,name,' . $task->id,
            'description' => 'required',
            'status_id' => 'required',
            'assigned_to_id' => 'required',
        ]);
        $task->fill($data);
        $task->save();

        DB::table('label_task')
            ->where('task_id', '=', $task->id)
            ->delete();
        $labels = $request->labels;
        $task->labels()->attach($labels);

        flash(__('flash.task_changed'))->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();
        flash(__('flash.task_deleted'))->success();
        return redirect()
            ->route('tasks.index');
    }
}
