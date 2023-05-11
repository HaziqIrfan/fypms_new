<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Evaluation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvaluationControllerTest extends TestCase
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
    public function it_displays_index_view_with_evaluations(): void
    {
        $evaluations = Evaluation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('evaluations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluations.index')
            ->assertViewHas('evaluations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_evaluation(): void
    {
        $response = $this->get(route('evaluations.create'));

        $response->assertOk()->assertViewIs('app.evaluations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_evaluation(): void
    {
        $data = Evaluation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('evaluations.store'), $data);

        $this->assertDatabaseHas('evaluations', $data);

        $evaluation = Evaluation::latest('id')->first();

        $response->assertRedirect(route('evaluations.edit', $evaluation));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_evaluation(): void
    {
        $evaluation = Evaluation::factory()->create();

        $response = $this->get(route('evaluations.show', $evaluation));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluations.show')
            ->assertViewHas('evaluation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_evaluation(): void
    {
        $evaluation = Evaluation::factory()->create();

        $response = $this->get(route('evaluations.edit', $evaluation));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluations.edit')
            ->assertViewHas('evaluation');
    }

    /**
     * @test
     */
    public function it_updates_the_evaluation(): void
    {
        $evaluation = Evaluation::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'rubric_file_path' => $this->faker->text(),
            'start_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
        ];

        $response = $this->put(route('evaluations.update', $evaluation), $data);

        $data['id'] = $evaluation->id;

        $this->assertDatabaseHas('evaluations', $data);

        $response->assertRedirect(route('evaluations.edit', $evaluation));
    }

    /**
     * @test
     */
    public function it_deletes_the_evaluation(): void
    {
        $evaluation = Evaluation::factory()->create();

        $response = $this->delete(route('evaluations.destroy', $evaluation));

        $response->assertRedirect(route('evaluations.index'));

        $this->assertSoftDeleted($evaluation);
    }
}
