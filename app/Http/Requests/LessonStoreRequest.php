<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'unit' => 'required|integer|min:1',
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => 'نام',
            'unit' => 'واحد',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'وارد کردن نام درس الزامی است.',
            'unit.required' => 'تعداد واحد الزامی است.',
            'unit.integer'  => 'تعداد واحد باید عدد صحیح باشد.',
            'unit.min'      => 'تعداد واحد باید حداقل ۱ باشد.',
        ];
    }
}
