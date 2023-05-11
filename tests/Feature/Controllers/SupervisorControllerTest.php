<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Supervisor;

use App\Models\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupervisorControllerTest extends TestCase
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
    public function it_displays_index_view_with_supervisors(): void
    {
        $supervisors = Supervisor::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('supervisors.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.supervisors.index')
            ->assertViewHas('supervisors');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_supervisor(): void
    {
        $response = $this->get(route('supervisors.create'));

        $response->assertOk()->assertViewIs('app.supervisors.create');
    }

    /**
     * @test
     */
    public function it_stores_the_supervisor(): void
    {
        $data = Supervisor::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('supervisors.store'), $data);

        $this->assertDatabaseHas('supervisors', $data);

        $supervisor = Supervisor::latest('id')->first();

        $response->assertRedirect(route('supervisors.edit', $supervisor));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_supervisor(): void
    {
        $supervisor = Supervisor::factory()->create();

        $response = $this->get(route('supervisors.show', $supervisor));

        $response
            ->assertOk()
            ->assertViewIs('app.supervisors.show')
            ->assertViewHas('supervisor');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_supervisor(): void
    {
        $supervisor = Supervisor::factory()->create();

        $response = $this->get(route('supervisors.edit', $supervisor));

        $response
            ->assertOk()
            ->assertViewIs('app.supervisors.edit')
            ->assertViewHas('supervisor');
    }

    /**
     * @test
     */
    public function it_updates_the_supervisor(): void
    {
        $supervisor = Supervisor::factory()->create();

        $user = User::factory()->create();
        $student = Student::factory()->create();

        $data = [
            'background' => $this->faker->text(255),
            'availability' => $this->faker->text(255),
            'user_id' => $user->id,
            'student_id' => $student->id,
        ];

        $response = $this->put(route('supervisors.update', $supervisor), $data);

        $data['id'] = $supervisor->id;

        $this->assertDatabaseHas('supervisors', $data);

        $response->assertRedirect(route('supervisors.edit', $supervisor));
    }

    /**
     * @test
     */
    public function it_deletes_the_supervisor(): void
    {
        $supervisor = Supervisor::factory()->create();

        $response = $this->delete(route('supervisors.destroy', $supervisor));

        $response->assertRedirect(route('supervisors.index'));

        $this->assertSoftDeleted($supervisor);
    }
}
