<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresentationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'master_id'   => 'required|numeric',
            'lesson_id'   => 'required|numeric',
            'day_hold'    => 'required|string|max:50',
            'start_time'  => 'required',
            'finish_time' => 'required',
            'location'    => 'nullable|string|max:200',
            'description' => 'nullable|string|max:1000',
            'status'      => 'nullable|string|in:active,inactive,completed',
        ];
    }

    public function attributes(): array
    {
        return [
            'master_id'   => 'استاد',
            'lesson_id'   => 'درس',
            'day_hold'    => 'روز برگزاری',
            'start_time'  => 'ساعت شروع',
            'finish_time' => 'ساعت پایان',
            'location'    => 'محل برگزاری',
            'description' => 'توضیحات',
            'status'      => 'وضعیت',
        ];
    }

    public function messages(): array
    {
        return [
            'master_id.required' => 'لطفاً استاد را انتخاب کنید.',
            'master_id.numeric'  => 'مقدار استاد نامعتبر است.',

            'lesson_id.required' => 'لطفاً درس را انتخاب کنید.',
            'lesson_id.numeric'  => 'مقدار درس نامعتبر است.',

            'day_hold.required'  => 'لطفاً روز برگزاری را وارد کنید.',
            'day_hold.string'    => 'روز برگزاری باید متن باشد.',
            'day_hold.max'       => 'روز برگزاری نباید بیشتر از ۵۰ کاراکتر باشد.',

            'start_time.required' => 'لطفاً ساعت شروع را وارد کنید.',

            'finish_time.required' => 'لطفاً ساعت پایان را وارد کنید.',

            'location.max' => 'محل برگزاری نباید بیشتر از ۲۰۰ کاراکتر باشد.',
            'location.string' => 'محل برگزاری باید متن باشد.',

            'description.max' => 'توضیحات نباید بیشتر از ۱۰۰۰ کاراکتر باشد.',
            'description.string' => 'توضیحات باید متن باشد.',

            'status.in' => 'وضعیت انتخاب شده معتبر نیست.',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? 'active',
        ]);
    }
}
