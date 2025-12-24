<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSelectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|numeric|exists:students,id',
            'presentation_id' => 'required|numeric|exists:presentations,id',
            'score' => 'nullable|numeric|min:0|max:20',
            'year_education' => 'required|numeric|min:1300|max:1500',
        ];
    }

    public function attributes(): array
    {
        return [
            'student_id' => 'دانشجو',
            'presentation_id' => 'ارائه',
            'score' => 'نمره',
            'year_education' => 'سال تحصیلی',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'انتخاب دانشجو الزامی است.',
            'student_id.exists' => 'دانشجو انتخاب شده معتبر نیست.',

            'presentation_id.required' => 'انتخاب ارائه الزامی است.',
            'presentation_id.exists' => 'ارائه انتخاب شده معتبر نیست.',

            'score.numeric' => 'نمره باید عددی باشد.',
            'score.min' => 'نمره نمی‌تواند منفی باشد.',
            'score.max' => 'نمره نمی‌تواند بیشتر از 20 باشد.',

            'year_education.required' => 'سال تحصیلی را وارد کنید.',
            'year_education.numeric' => 'سال تحصیلی باید عددی باشد.',
            'year_education.min' => 'سال تحصیلی باید معتبر باشد.',
            'year_education.max' => 'سال تحصیلی باید معتبر باشد.',
        ];
    }
}