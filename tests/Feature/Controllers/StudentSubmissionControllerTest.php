<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\StudentSubmission;

use App\Models\Student;
use App\Models\Submission;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentSubmissionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_student_submissions(): void
    {
        $studentSubmissions = StudentSubmission::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('student-submissions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.student_submissions.index')
            ->assertViewHas('studentSubmissions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_student_submission(): void
    {
        $response = $this->get(route('student-submissions.create'));

        $response->assertOk()->assertViewIs('app.student_submissions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_student_submission(): void
    {
        $data = StudentSubmission::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('student-submissions.store'), $data);

        $this->assertDatabaseHas('student_submissions', $data);

        $studentSubmission = StudentSubmission::latest('id')->first();

        $response->assertRedirect(
            route('student-submissions.edit', $studentSubmission)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_student_submission(): void
    {
        $studentSubmission = StudentSubmission::factory()->create();

        $response = $this->get(
            route('student-submissions.show', $studentSubmission)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.student_submissions.show')
            ->assertViewHas('studentSubmission');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_student_submission(): void
    {
        $studentSubmission = StudentSubmission::factory()->create();

        $response = $this->get(
            route('student-submissions.edit', $studentSubmission)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.student_submissions.edit')
            ->assertViewHas('studentSubmission');
    }

    /**
     * @test
     */
    public function it_updates_the_student_submission(): void
    {
        $studentSubmission = StudentSubmission::factory()->create();

        $submission = Submission::factory()->create();
        $student = Student::factory()->create();

        $data = [
            'file_path' => $this->faker->text(),
            'submission_id' => $submission->id,
            'student_id' => $student->id,
        ];

        $response = $this->put(
            route('student-submissions.update', $studentSubmission),
            $data
        );

        $data['id'] = $studentSubmission->id;

        $this->assertDatabaseHas('student_submissions', $data);

        $response->assertRedirect(
            route('student-submissions.edit', $studentSubmission)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_student_submission(): void
    {
        $studentSubmission = StudentSubmission::factory()->create();

        $response = $this->delete(
            route('student-submissions.destroy', $studentSubmission)
        );

        $response->assertRedirect(route('student-submissions.index'));

        $this->assertSoftDeleted($studentSubmission);
    }
}
