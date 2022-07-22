<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $taskStatuses = TaskStatus::paginate(15);
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
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
            'name' => 'required|max:255|unique:task_statuses',
           ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('flash.status_created'))->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TaskStatus $taskStatus
     * @return View
     */
    public function edit(TaskStatus $taskStatus): View
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TaskStatus $taskStatus
     * @return RedirectResponse
     */
    public function update(Request $request, TaskStatus $taskStatus): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:task_statuses,name,' . $taskStatus->id,
         ]);
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('flash.status_changed'))->success();
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TaskStatus $taskStatus
     * @return RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if ($taskStatus->tasks()->exists()) {
            flash(__('flash.status_cannot_deleted'))->error();
            return redirect()
                ->route('task_statuses.index');
        };
        $taskStatus->delete();
        flash(__('flash.status_deleted'))->success();
        return redirect()
            ->route('task_statuses.index');
    }
}
