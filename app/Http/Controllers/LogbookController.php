<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LogbookStoreRequest;
use App\Http\Requests\LogbookUpdateRequest;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Logbook::class);

        $search = $request->get('search', '');

        $logbooks = Logbook::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.logbooks.index', compact('logbooks', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Logbook::class);

        return view('app.logbooks.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LogbookStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Logbook::class);

        $validated = $request->validated();

        $logbook = Logbook::create($validated);

        return redirect()
            ->route('logbooks.edit', $logbook)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Logbook $logbook): View
    {
        $this->authorize('view', $logbook);

        return view('app.logbooks.show', compact('logbook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Logbook $logbook): View
    {
        $this->authorize('update', $logbook);

        return view('app.logbooks.edit', compact('logbook', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        LogbookUpdateRequest $request,
        Logbook $logbook
    ): RedirectResponse {
        $this->authorize('update', $logbook);

        $validated = $request->validated();

        $logbook->update($validated);

        return redirect()
            ->route('logbooks.edit', $logbook)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Logbook $logbook
    ): RedirectResponse {
        $this->authorize('delete', $logbook);

        $logbook->delete();

        return redirect()
            ->route('logbooks.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
