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

            'presentation_ids' => ['required', 'array', 'min:1'],
            'presentation_ids.*' => [
                'required',
                'exists:presentations,id',

                // جلوگیری از انتخاب تکراری یک درس برای یک دانشجو
                Rule::unique('selections', 'presentation_id')
                    ->where(fn ($q) =>
                        $q->where('student_id', $this->student_id)
                    ),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'انتخاب دانشجو الزامی است.',
            'student_id.exists' => 'دانشجوی انتخاب‌شده معتبر نیست.',

            'presentation_ids.required' => 'حداقل یک درس باید انتخاب شود.',
            'presentation_ids.array' => 'فرمت دروس انتخابی نامعتبر است.',
            'presentation_ids.min' => 'حداقل یک درس باید انتخاب شود.',

            'presentation_ids.*.required' => 'انتخاب درس الزامی است.',
            'presentation_ids.*.exists' => 'درس انتخاب‌شده معتبر نیست.',
            'presentation_ids.*.unique' => 'این دانشجو قبلاً این درس را انتخاب کرده است.',
        ];
    }
}
