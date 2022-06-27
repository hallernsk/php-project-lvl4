<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate(100);
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
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
      //  dd($taskStatuses);
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
    //    dd($users);
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
        {
 //           dd($request);
            $data = $this->validate($request, [
                'name' => 'required|unique:tasks',
                'status_id' => 'required',
                'description' => 'required',
                'assigned_to_id' => 'required',
         //       'labels' => 'required',
            ]);
     //       dd($data);
            $user = Auth::user();   //  получение аут-го юзера при помощи фасада
    //        $user = auth()->user();   // ... при помощи хелпера
    //       dd($user);
            $task = $user->tasksCreated()->make();
    //        dd($task);
            $task->fill($data);
    //        $task->created_by_id = Auth::id();    так нельзя!!!
    //        dd($task);
            $task->save();

            $labels = $request->labels;
        if ($labels) {
                //   dd($labels);
            foreach ($labels as $label) {
                    //           dd($label);
                    DB::table('label_task')->insert([
                        'label_id' => $label,
                        'task_id' => $task->id
                    ]);
            }
        }

            flash(__('flash.task_created'));
            // Редирект на указанный маршрут (вывод задач)
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
        $task = Task::findOrFail($id);
 //       dd($task);
        $status = TaskStatus::findOrFail($task->status_id);
    //    dd($status);

        $labels = DB::select('select * from label_task where task_id = ?', [$task->id]);
//        dd($labels);
      //  $labels_names = DB::select('select name from labels where id = 1',);

        $labels_names = [];
        foreach ($labels as $label) {
      //    dd($label->label_id);
            $labels_names[] = DB::table('labels')->where('id', [$label->label_id])->pluck('name');
       //     $labels_names[] = DB::select('select name from labels where id = ?', [$label->label_id]);
      //      dd($labels_names[0][0]);
        }
   //     dd(reset($labels_names));

        return view('tasks.show', compact('task', 'status', 'labels_names'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
 //       dd($task);
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
//        dd($taskStatuses);
        $users = User::pluck('name', 'id')->all();
//        dd($users);
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
        //       dd($request);
        //       dd($task);

          $data = $this->validate($request, [
            'name' => 'required|unique:tasks,name,' . $task->id,
            'description' => 'required',
            'status_id' => 'required',
            'assigned_to_id' => 'required',
    //          'labels' => 'required'
          ]);
    //      dd($data);
        $task->fill($data);
        $task->save();

        // сначала удалить в  label_task все записи для текущей задачи:
        DB::delete('delete from label_task where task_id = ?', [$task->id]);
//        DB::table(label_task)->delete()->where('task_id', $task->id);


        $labels = $request->labels;
        if ($labels) {
            foreach ($labels as $label) {
                //           dd($label);
                DB::table('label_task')->insert([
                    'label_id' => $label,
                    'task_id' => $task->id
                ]);
            }
        }

//        $task->update($request->only(['name', 'description', 'status_id', 'assigned_to_id']));
//        ...  и так тоже работает ( метод update() )
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
    //           dd($task);
        if ($task) {
            $task->delete();
        }
        flash(__('flash.task_deleted'));
        return redirect()
            ->route('tasks.index');
    }
}
