<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Submission;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionControllerTest extends TestCase
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
    public function it_displays_index_view_with_submissions(): void
    {
        $submissions = Submission::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('submissions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.submissions.index')
            ->assertViewHas('submissions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_submission(): void
    {
        $response = $this->get(route('submissions.create'));

        $response->assertOk()->assertViewIs('app.submissions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_submission(): void
    {
        $data = Submission::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('submissions.store'), $data);

        $this->assertDatabaseHas('submissions', $data);

        $submission = Submission::latest('id')->first();

        $response->assertRedirect(route('submissions.edit', $submission));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_submission(): void
    {
        $submission = Submission::factory()->create();

        $response = $this->get(route('submissions.show', $submission));

        $response
            ->assertOk()
            ->assertViewIs('app.submissions.show')
            ->assertViewHas('submission');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_submission(): void
    {
        $submission = Submission::factory()->create();

        $response = $this->get(route('submissions.edit', $submission));

        $response
            ->assertOk()
            ->assertViewIs('app.submissions.edit')
            ->assertViewHas('submission');
    }

    /**
     * @test
     */
    public function it_updates_the_submission(): void
    {
        $submission = Submission::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->text(255),
            'due_date' => $this->faker->dateTime(),
            'start_date' => $this->faker->dateTime(),
        ];

        $response = $this->put(route('submissions.update', $submission), $data);

        $data['id'] = $submission->id;

        $this->assertDatabaseHas('submissions', $data);

        $response->assertRedirect(route('submissions.edit', $submission));
    }

    /**
     * @test
     */
    public function it_deletes_the_submission(): void
    {
        $submission = Submission::factory()->create();

        $response = $this->delete(route('submissions.destroy', $submission));

        $response->assertRedirect(route('submissions.index'));

        $this->assertSoftDeleted($submission);
    }
}
