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
        $selectionId = $this->route('selection')->id;

        return [
            'student_id' => ['required', 'exists:students,id'],

            'presentation_id' => [
                'required',
                'exists:presentations,id',

                Rule::unique('selections')
                    ->ignore($selectionId)
                    ->where(fn ($q) =>
                        $q->where('student_id', $this->student_id)
                    ),
            ],

            'score' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],

            'year_education' => [
                'nullable',
                'integer',
                'min:1300',
                'max:9999',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'انتخاب دانشجو الزامی است.',
            'presentation_id.required' => 'انتخاب ارائه الزامی است.',
            'presentation_id.unique' => 'این دانشجو قبلاً این ارائه را انتخاب کرده است.',
            'score.numeric' => 'نمره باید عدد باشد.',
            'score.min' => 'نمره نمی‌تواند کمتر از 0 باشد.',
            'score.max' => 'نمره نمی‌تواند بیشتر از 100 باشد.',
        ];
    }
}
