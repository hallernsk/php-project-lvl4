<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labels = Label::paginate();
        //  dd($labels);
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $label = new Label();
        //      dd($label);
        return view('labels.create', compact('label'));
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
            'name' => 'required|unique:labels',
            'description' => 'required',
        ]);

        $label = new Label();
        $label->fill($data);
          //     dd($label);
        // При ошибках сохранения возникнет исключение
        $label->save();
        flash(__('flash.label_created'))->success();
        // Редирект на указанный маршрут (вывод статусов)
        return redirect()
            ->route('labels.index');
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
    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        //       dd($request);
        //       dd($label);

        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name,' . $label->id,
            'description' => 'required',
        ]);

        $label->fill($data);
        $label->save();
        flash(__('flash.label_changed'))->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        //     dd($label->tasks);

        if ($label->tasks()->exists()) {
            flash(__('flash.label_cannot_deleted'))->error();
            return redirect()
                ->route('labels.index');
        };

        if ($label) {
            $label->delete();
        }
        flash(__('flash.label_deleted'))->success();
        return redirect()
            ->route('labels.index');
    }
}
