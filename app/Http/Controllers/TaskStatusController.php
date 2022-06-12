<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::paginate();
      //  dd($taskStatuses);
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
  //      dd($taskStatus);
        return view('task_statuses.create', compact('taskStatus'));
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
            'name' => 'required|unique:task_statuses',
           ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
 //       dd($taskStatus);
        // При ошибках сохранения возникнет исключение
        $taskStatus->save();
        flash(__('flash.status_created'));
        // Редирект на указанный маршрут (вывод статусов)
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
  //     dd($taskStatus);
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
 //       dd($request);
 //       dd($taskStatus);

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses,name,' . $taskStatus->id,
         ]);

        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('flash.status_changed'));
        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
 //       dd($taskStatus->tasks);
        if ($taskStatus->tasks()->exists()) {
            flash(__('flash.status_cannot_deleted'));
            return redirect()
                ->route('task_statuses.index');
        };
        if ($taskStatus) {
            $taskStatus->delete();
        }
        flash(__('flash.status_deleted'));
        return redirect()
            ->route('task_statuses.index');
    }
}
