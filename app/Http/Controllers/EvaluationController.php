<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EvaluationStoreRequest;
use App\Http\Requests\EvaluationUpdateRequest;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Evaluation::class);

        $search = $request->get('search', '');

        $evaluations = Evaluation::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.evaluations.index', compact('evaluations', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Evaluation::class);

        return view('app.evaluations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvaluationStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Evaluation::class);

        $validated = $request->validated();

        $evaluation = Evaluation::create($validated);

        return redirect()
            ->route('evaluations.edit', $evaluation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Evaluation $evaluation): View
    {
        $this->authorize('view', $evaluation);

        return view('app.evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Evaluation $evaluation): View
    {
        $this->authorize('update', $evaluation);

        return view('app.evaluations.edit', compact('evaluation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EvaluationUpdateRequest $request,
        Evaluation $evaluation
    ): RedirectResponse {
        $this->authorize('update', $evaluation);

        $validated = $request->validated();

        $evaluation->update($validated);

        return redirect()
            ->route('evaluations.edit', $evaluation)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Evaluation $evaluation
    ): RedirectResponse {
        $this->authorize('delete', $evaluation);

        $evaluation->delete();

        return redirect()
            ->route('evaluations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
