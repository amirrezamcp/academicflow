<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'bail|required|string|max:100',
            'graduation' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'وارد کردن نام دانشجو الزامی است.',
            'name.string'   => 'نام باید به صورت متن باشد.',
            'name.max'      => 'نام نمی‌تواند بیش از ۱۰۰ کاراکتر باشد.',

            'graduation.string' => 'مقطع تحصیلی باید به صورت متن باشد.',
            'graduation.max'    => 'مقطع تحصیلی نمی‌تواند بیش از ۵۰ کاراکتر باشد.',
        ];
    }
}
