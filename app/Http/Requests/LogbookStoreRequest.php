<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogbookStoreRequest extends FormRequest
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
            'datetime' => ['required', 'date'],
            'week' => ['required', 'max:255', 'string'],
            'approval_date' => ['required', 'date'],
            'description' => ['required', 'date'],
            'comment' => ['required', 'max:255', 'string'],
            'student_id' => ['required', 'exists:students,id'],
        ];
    }
}
