<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SubmissionStoreRequest;
use App\Http\Requests\SubmissionUpdateRequest;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Submission::class);

        $search = $request->get('search', '');

        $submissions = Submission::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.submissions.index', compact('submissions', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Submission::class);

        return view('app.submissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubmissionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Submission::class);

        $validated = $request->validated();

        $submission = Submission::create($validated);

        return redirect()
            ->route('submissions.edit', $submission)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Submission $submission): View
    {
        $this->authorize('view', $submission);

        return view('app.submissions.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Submission $submission): View
    {
        $this->authorize('update', $submission);

        return view('app.submissions.edit', compact('submission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SubmissionUpdateRequest $request,
        Submission $submission
    ): RedirectResponse {
        $this->authorize('update', $submission);

        $validated = $request->validated();

        $submission->update($validated);

        return redirect()
            ->route('submissions.edit', $submission)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Submission $submission
    ): RedirectResponse {
        $this->authorize('delete', $submission);

        $submission->delete();

        return redirect()
            ->route('submissions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
