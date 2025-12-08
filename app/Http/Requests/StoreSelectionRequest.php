<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSelectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'presentation_id' => [
                'required',
                'exists:presentations,id',
                Rule::unique('selections')->where(fn ($q) =>
                    $q->where('student_id', $this->student_id)
                )
            ],
            'score' => 'nullable|numeric|min:0|max:100',
            'year_education' => 'nullable|integer|min:1300|max:9999',
        ];
    }

    public function messages(): array
    {
        return [
            'presentation_id.unique' => 'این دانشجو قبلاً این ارائه را انتخاب کرده است.',
            'student_id.required' => 'انتخاب دانشجو الزامی است.',
            'presentation_id.required' => 'انتخاب ارائه الزامی است.',
        ];
    }
}
