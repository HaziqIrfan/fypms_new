<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\View\View;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SupervisorStoreRequest;
use App\Http\Requests\SupervisorUpdateRequest;

class SupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Supervisor::class);

        $search = $request->get('search', '');

        $supervisors = Supervisor::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.supervisors.index', compact('supervisors', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Supervisor::class);

        $users = User::pluck('name', 'id');
        $students = Student::pluck('sv_name', 'id');

        return view('app.supervisors.create', compact('users', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupervisorStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Supervisor::class);

        $validated = $request->validated();

        $supervisor = Supervisor::create($validated);

        return redirect()
            ->route('supervisors.edit', $supervisor)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Supervisor $supervisor): View
    {
        $this->authorize('view', $supervisor);

        return view('app.supervisors.show', compact('supervisor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Supervisor $supervisor): View
    {
        $this->authorize('update', $supervisor);

        $users = User::pluck('name', 'id');
        $students = Student::pluck('sv_name', 'id');

        return view(
            'app.supervisors.edit',
            compact('supervisor', 'users', 'students')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SupervisorUpdateRequest $request,
        Supervisor $supervisor
    ): RedirectResponse {
        $this->authorize('update', $supervisor);

        $validated = $request->validated();

        $supervisor->update($validated);

        return redirect()
            ->route('supervisors.edit', $supervisor)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Supervisor $supervisor
    ): RedirectResponse {
        $this->authorize('delete', $supervisor);

        $supervisor->delete();

        return redirect()
            ->route('supervisors.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
