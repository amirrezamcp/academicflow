<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSelectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('selection')->id;

        return [
            'student_id' => ['required', 'exists:students,id'],
            'presentation_id' => [
                'required',
                'exists:presentations,id',
                Rule::unique('selections')
                    ->ignore($id)
                    ->where(fn ($q) =>
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
            'presentation_id.unique' => 'این دانش‌آموز قبلاً این ارائه را انتخاب کرده است.',
        ];
    }
}
