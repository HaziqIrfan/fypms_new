<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;
use App\Models\Evaluator;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\EvaluationResult;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EvaluationResultStoreRequest;
use App\Http\Requests\EvaluationResultUpdateRequest;

class EvaluationResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', EvaluationResult::class);

        $search = $request->get('search', '');

        $evaluationResults = EvaluationResult::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.evaluation_results.index',
            compact('evaluationResults', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', EvaluationResult::class);

        $evaluations = Evaluation::pluck('title', 'id');
        $students = Student::pluck('sv_name', 'id');
        $evaluators = Evaluator::pluck('id', 'id');

        return view(
            'app.evaluation_results.create',
            compact('evaluations', 'students', 'evaluators')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        EvaluationResultStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', EvaluationResult::class);

        $validated = $request->validated();

        $evaluationResult = EvaluationResult::create($validated);

        return redirect()
            ->route('evaluation-results.edit', $evaluationResult)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        EvaluationResult $evaluationResult
    ): View {
        $this->authorize('view', $evaluationResult);

        return view('app.evaluation_results.show', compact('evaluationResult'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        EvaluationResult $evaluationResult
    ): View {
        $this->authorize('update', $evaluationResult);

        $evaluations = Evaluation::pluck('title', 'id');
        $students = Student::pluck('sv_name', 'id');
        $evaluators = Evaluator::pluck('id', 'id');

        return view(
            'app.evaluation_results.edit',
            compact('evaluationResult', 'evaluations', 'students', 'evaluators')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EvaluationResultUpdateRequest $request,
        EvaluationResult $evaluationResult
    ): RedirectResponse {
        $this->authorize('update', $evaluationResult);

        $validated = $request->validated();

        $evaluationResult->update($validated);

        return redirect()
            ->route('evaluation-results.edit', $evaluationResult)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        EvaluationResult $evaluationResult
    ): RedirectResponse {
        $this->authorize('delete', $evaluationResult);

        $evaluationResult->delete();

        return redirect()
            ->route('evaluation-results.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
