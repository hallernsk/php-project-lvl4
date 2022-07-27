<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ])
            ->paginate(15);
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.index', ['tasks' => $tasks, 'statuses' => $statuses, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
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
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks',
            'status_id' => 'required',
            'description' => 'nullable|max:255',
            'assigned_to_id' => 'nullable',
        ], [
            'name.required' => __('validation.task.required'),
            'name.unique' => __('validation.task.name'),
            'status_id.required' => __('validation.status_id.required')
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
     * @param Task $task
     * @return View
     */
    public function show(Task $task): View
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
     * @param Task $task
     * @return View
     */
    public function edit(Task $task): View
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:tasks,name,' . $task->id,
            'description' => 'nullable|max:255',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable',
            'labels' => 'nullable'
        ], [
            'name.required' => __('validation.task.required'),
            'name.unique' => __('validation.task.name'),
            'status_id.required' => __('validation.status_id.required')
        ]);

        $task->update($data);
        $labels = $request->input('labels');

        if (is_array($labels)) {
            $task->labels()->sync(array_filter($labels));
        } else {
            $task->labels()->detach();
        }

        flash(__('flash.task_changed'))->success();
        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->labels()->detach();
        $task->delete();
        flash(__('flash.task_deleted'))->success();
        return redirect()
            ->route('tasks.index');
    }
}
