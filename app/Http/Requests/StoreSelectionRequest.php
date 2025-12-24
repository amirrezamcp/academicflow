<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSelectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|numeric|exists:students,id',
            'presentation_ids' => 'required|array|min:1',
            'presentation_ids.*' => 'numeric|exists:presentations,id',
            'score' => 'nullable|numeric|min:0|max:20',
            'year_education' => 'required|numeric|min:1300|max:1500',
        ];
    }

    public function attributes(): array
    {
        return [
            'student_id' => 'دانشجو',
            'presentation_ids' => 'ارائه‌ها',
            'presentation_ids.*' => 'ارائه',
            'score' => 'نمره',
            'year_education' => 'سال تحصیلی',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'انتخاب دانشجو الزامی است.',
            'student_id.exists' => 'دانشجو انتخاب شده معتبر نیست.',

            'presentation_ids.required' => 'حداقل یک ارائه را انتخاب کنید.',
            'presentation_ids.array' => 'فرمت ارائه‌ها معتبر نیست.',
            'presentation_ids.min' => 'حداقل یک ارائه را انتخاب کنید.',
            'presentation_ids.*.exists' => 'ارائه انتخاب شده معتبر نیست.',

            'score.numeric' => 'نمره باید عددی باشد.',
            'score.min' => 'نمره نمی‌تواند منفی باشد.',
            'score.max' => 'نمره نمی‌تواند بیشتر از 20 باشد.',

            'year_education.required' => 'سال تحصیلی را وارد کنید.',
            'year_education.numeric' => 'سال تحصیلی باید عددی باشد.',
            'year_education.min' => 'سال تحصیلی باید معتبر باشد.',
            'year_education.max' => 'سال تحصیلی باید معتبر باشد.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'year_education' => $this->year_education ?? now()->year,
        ]);
    }
}
