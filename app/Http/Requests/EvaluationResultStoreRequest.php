<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationResultStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'mark' => ['required', 'max:255', 'string'],
            'evaluation_id' => ['required', 'exists:evaluations,id'],
            'student_id' => ['required', 'exists:students,id'],
            'evaluator_id' => ['required', 'exists:evaluators,id'],
        ];
    }
}
