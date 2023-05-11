<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Evaluator;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvaluatorControllerTest extends TestCase
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
    public function it_displays_index_view_with_evaluators(): void
    {
        $evaluators = Evaluator::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('evaluators.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluators.index')
            ->assertViewHas('evaluators');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_evaluator(): void
    {
        $response = $this->get(route('evaluators.create'));

        $response->assertOk()->assertViewIs('app.evaluators.create');
    }

    /**
     * @test
     */
    public function it_stores_the_evaluator(): void
    {
        $data = Evaluator::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('evaluators.store'), $data);

        $this->assertDatabaseHas('evaluators', $data);

        $evaluator = Evaluator::latest('id')->first();

        $response->assertRedirect(route('evaluators.edit', $evaluator));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_evaluator(): void
    {
        $evaluator = Evaluator::factory()->create();

        $response = $this->get(route('evaluators.show', $evaluator));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluators.show')
            ->assertViewHas('evaluator');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_evaluator(): void
    {
        $evaluator = Evaluator::factory()->create();

        $response = $this->get(route('evaluators.edit', $evaluator));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluators.edit')
            ->assertViewHas('evaluator');
    }

    /**
     * @test
     */
    public function it_updates_the_evaluator(): void
    {
        $evaluator = Evaluator::factory()->create();

        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
        ];

        $response = $this->put(route('evaluators.update', $evaluator), $data);

        $data['id'] = $evaluator->id;

        $this->assertDatabaseHas('evaluators', $data);

        $response->assertRedirect(route('evaluators.edit', $evaluator));
    }

    /**
     * @test
     */
    public function it_deletes_the_evaluator(): void
    {
        $evaluator = Evaluator::factory()->create();

        $response = $this->delete(route('evaluators.destroy', $evaluator));

        $response->assertRedirect(route('evaluators.index'));

        $this->assertSoftDeleted($evaluator);
    }
}
