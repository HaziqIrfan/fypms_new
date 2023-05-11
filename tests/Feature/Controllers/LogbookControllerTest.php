<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Logbook;

use App\Models\Student;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogbookControllerTest extends TestCase
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
    public function it_displays_index_view_with_logbooks(): void
    {
        $logbooks = Logbook::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('logbooks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.logbooks.index')
            ->assertViewHas('logbooks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_logbook(): void
    {
        $response = $this->get(route('logbooks.create'));

        $response->assertOk()->assertViewIs('app.logbooks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_logbook(): void
    {
        $data = Logbook::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('logbooks.store'), $data);

        $this->assertDatabaseHas('logbooks', $data);

        $logbook = Logbook::latest('id')->first();

        $response->assertRedirect(route('logbooks.edit', $logbook));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_logbook(): void
    {
        $logbook = Logbook::factory()->create();

        $response = $this->get(route('logbooks.show', $logbook));

        $response
            ->assertOk()
            ->assertViewIs('app.logbooks.show')
            ->assertViewHas('logbook');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_logbook(): void
    {
        $logbook = Logbook::factory()->create();

        $response = $this->get(route('logbooks.edit', $logbook));

        $response
            ->assertOk()
            ->assertViewIs('app.logbooks.edit')
            ->assertViewHas('logbook');
    }

    /**
     * @test
     */
    public function it_updates_the_logbook(): void
    {
        $logbook = Logbook::factory()->create();

        $student = Student::factory()->create();

        $data = [
            'datetime' => $this->faker->dateTime(),
            'week' => $this->faker->text(255),
            'approval_date' => $this->faker->dateTime(),
            'description' => $this->faker->dateTime(),
            'comment' => $this->faker->text(),
            'student_id' => $student->id,
        ];

        $response = $this->put(route('logbooks.update', $logbook), $data);

        $data['id'] = $logbook->id;

        $this->assertDatabaseHas('logbooks', $data);

        $response->assertRedirect(route('logbooks.edit', $logbook));
    }

    /**
     * @test
     */
    public function it_deletes_the_logbook(): void
    {
        $logbook = Logbook::factory()->create();

        $response = $this->delete(route('logbooks.destroy', $logbook));

        $response->assertRedirect(route('logbooks.index'));

        $this->assertSoftDeleted($logbook);
    }
}
