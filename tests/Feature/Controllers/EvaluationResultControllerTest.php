<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\EvaluationResult;

use App\Models\Student;
use App\Models\Evaluator;
use App\Models\Evaluation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvaluationResultControllerTest extends TestCase
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
    public function it_displays_index_view_with_evaluation_results(): void
    {
        $evaluationResults = EvaluationResult::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('evaluation-results.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.evaluation_results.index')
            ->assertViewHas('evaluationResults');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_evaluation_result(): void
    {
        $response = $this->get(route('evaluation-results.create'));

        $response->assertOk()->assertViewIs('app.evaluation_results.create');
    }

    /**
     * @test
     */
    public function it_stores_the_evaluation_result(): void
    {
        $data = EvaluationResult::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('evaluation-results.store'), $data);

        $this->assertDatabaseHas('evaluation_results', $data);

        $evaluationResult = EvaluationResult::latest('id')->first();

        $response->assertRedirect(
            route('evaluation-results.edit', $evaluationResult)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_evaluation_result(): void
    {
        $evaluationResult = EvaluationResult::factory()->create();

        $response = $this->get(
            route('evaluation-results.show', $evaluationResult)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.evaluation_results.show')
            ->assertViewHas('evaluationResult');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_evaluation_result(): void
    {
        $evaluationResult = EvaluationResult::factory()->create();

        $response = $this->get(
            route('evaluation-results.edit', $evaluationResult)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.evaluation_results.edit')
            ->assertViewHas('evaluationResult');
    }

    /**
     * @test
     */
    public function it_updates_the_evaluation_result(): void
    {
        $evaluationResult = EvaluationResult::factory()->create();

        $evaluation = Evaluation::factory()->create();
        $student = Student::factory()->create();
        $evaluator = Evaluator::factory()->create();

        $data = [
            'mark' => $this->faker->text(255),
            'evaluation_id' => $evaluation->id,
            'student_id' => $student->id,
            'evaluator_id' => $evaluator->id,
        ];

        $response = $this->put(
            route('evaluation-results.update', $evaluationResult),
            $data
        );

        $data['id'] = $evaluationResult->id;

        $this->assertDatabaseHas('evaluation_results', $data);

        $response->assertRedirect(
            route('evaluation-results.edit', $evaluationResult)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_evaluation_result(): void
    {
        $evaluationResult = EvaluationResult::factory()->create();

        $response = $this->delete(
            route('evaluation-results.destroy', $evaluationResult)
        );

        $response->assertRedirect(route('evaluation-results.index'));

        $this->assertSoftDeleted($evaluationResult);
    }
}
