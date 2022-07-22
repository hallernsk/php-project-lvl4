<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $labels = Label::paginate(15);
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:labels',
            'description' => 'required|max:255',
        ]);

        $label = new Label();
        $label->fill($data);
        $label->save();
        flash(__('flash.label_created'))->success();
        return redirect()
            ->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Label $label
     * @return View
     */
    public function edit(Label $label): View
    {
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Label $label
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Label $label): RedirectResponse
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255|unique:labels,name,' . $label->id,
            'description' => 'required|max:255',
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
     * @param Label $label
     * @return RedirectResponse
     */
    public function destroy(Label $label): RedirectResponse
    {
        if ($label->tasks()->exists()) {
            flash(__('flash.label_cannot_deleted'))->error();
        } else {
            $label->delete();
            flash(__('flash.label_deleted'))->success();
        }
        return redirect()
            ->route('labels.index');
    }
}
