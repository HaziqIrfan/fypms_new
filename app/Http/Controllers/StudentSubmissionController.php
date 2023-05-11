<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\StudentSubmission;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StudentSubmissionStoreRequest;
use App\Http\Requests\StudentSubmissionUpdateRequest;

class StudentSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', StudentSubmission::class);

        $search = $request->get('search', '');

        $studentSubmissions = StudentSubmission::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.student_submissions.index',
            compact('studentSubmissions', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', StudentSubmission::class);

        $submissions = Submission::pluck('title', 'id');
        $students = Student::pluck('sv_name', 'id');

        return view(
            'app.student_submissions.create',
            compact('submissions', 'students')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StudentSubmissionStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', StudentSubmission::class);

        $validated = $request->validated();

        $studentSubmission = StudentSubmission::create($validated);

        return redirect()
            ->route('student-submissions.edit', $studentSubmission)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        StudentSubmission $studentSubmission
    ): View {
        $this->authorize('view', $studentSubmission);

        return view(
            'app.student_submissions.show',
            compact('studentSubmission')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        StudentSubmission $studentSubmission
    ): View {
        $this->authorize('update', $studentSubmission);

        $submissions = Submission::pluck('title', 'id');
        $students = Student::pluck('sv_name', 'id');

        return view(
            'app.student_submissions.edit',
            compact('studentSubmission', 'submissions', 'students')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StudentSubmissionUpdateRequest $request,
        StudentSubmission $studentSubmission
    ): RedirectResponse {
        $this->authorize('update', $studentSubmission);

        $validated = $request->validated();

        $studentSubmission->update($validated);

        return redirect()
            ->route('student-submissions.edit', $studentSubmission)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        StudentSubmission $studentSubmission
    ): RedirectResponse {
        $this->authorize('delete', $studentSubmission);

        $studentSubmission->delete();

        return redirect()
            ->route('student-submissions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
