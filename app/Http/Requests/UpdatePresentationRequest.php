<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'master_id'   => 'required|exists:masters,id',
            'lesson_id'   => 'required|exists:lessons,id',
            'day_hold'    => 'required|string|max:50',
            'start_time'  => 'required|date_format:H:i',
            'finish_time' => 'required|date_format:H:i|after_or_equal:start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'master_id.required' => 'انتخاب استاد الزامی است.',
            'lesson_id.required' => 'انتخاب درس الزامی است.',
            'day_hold.required'  => 'روز برگزاری را وارد کنید.',
            'start_time.required' => 'ساعت شروع را وارد کنید.',
            'finish_time.required' => 'ساعت پایان را وارد کنید.',
            'finish_time.after_or_equal' => 'ساعت پایان باید بعد از ساعت شروع باشد.',
        ];
    }
}
