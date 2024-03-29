<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'project_title' => ['required', 'max:255', 'string'],
            'psm_status' => ['required', 'max:255', 'string'],
            'year' => ['required', 'max:255', 'string'],
            'program' => ['required', 'max:255', 'string'],
            'pa_name' => ['required', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
