<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate();
        $statuses = TaskStatus::pluck('name', 'id')->all();
 //       dd($statuses);
        $users = User::pluck('name', 'id')->all();
 //       dd($users);
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
        //      dd($task);
        return view('tasks.create', compact('task'));        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
    //        dd($request);
            $data = $this->validate($request, [
                'name' => 'required|unique:tasks',
                'description' => 'required',
                'performer' => 'nullable',
            ]);
 //           dd($data);
            $task = new Task();
            $task->fill($data);
            //       dd($task);
            $task->save();
            flash(__('task_created'));
            // Редирект на указанный маршрут (вывод статусов)
            return redirect()
                ->route('tasks.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //     dd($task);
        return view('tasks.edit', compact('task'));
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
        //       dd($request);
        //       dd($task);

        $data = $this->validate($request, [
            'name' => 'required|unique:tasks,name,' . $task->id,
        ]);

        $task->fill($data);
        $task->save();
        flash(__('flash.task_changed'));
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
        //       dd($task);
        if ($task) {
            $task->delete();
        }
        flash(__('flash.task_deleted'));
        return redirect()
            ->route('tasks.index');
    }
}
