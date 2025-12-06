<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'graduation' => 'nullable|string|max:50',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'نام',
            'graduation' => 'مدرک',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'لطفاً نام استاد را وارد کنید.',
            'name.max' => 'نام نباید بیشتر از 100 کاراکتر باشد.',
            'graduation.max' => 'مدرک نباید بیشتر از 50 کاراکتر باشد.',
        ];
    }
}
