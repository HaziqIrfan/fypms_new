<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EvaluatorStoreRequest;
use App\Http\Requests\EvaluatorUpdateRequest;

class EvaluatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Evaluator::class);

        $search = $request->get('search', '');

        $evaluators = Evaluator::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.evaluators.index', compact('evaluators', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Evaluator::class);

        $users = User::pluck('name', 'id');

        return view('app.evaluators.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EvaluatorStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Evaluator::class);

        $validated = $request->validated();

        $evaluator = Evaluator::create($validated);

        return redirect()
            ->route('evaluators.edit', $evaluator)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Evaluator $evaluator): View
    {
        $this->authorize('view', $evaluator);

        return view('app.evaluators.show', compact('evaluator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Evaluator $evaluator): View
    {
        $this->authorize('update', $evaluator);

        $users = User::pluck('name', 'id');

        return view('app.evaluators.edit', compact('evaluator', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EvaluatorUpdateRequest $request,
        Evaluator $evaluator
    ): RedirectResponse {
        $this->authorize('update', $evaluator);

        $validated = $request->validated();

        $evaluator->update($validated);

        return redirect()
            ->route('evaluators.edit', $evaluator)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Evaluator $evaluator
    ): RedirectResponse {
        $this->authorize('delete', $evaluator);

        $evaluator->delete();

        return redirect()
            ->route('evaluators.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
