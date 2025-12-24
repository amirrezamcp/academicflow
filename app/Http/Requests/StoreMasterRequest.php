<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;

class StoreMasterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:150',
            'graduation' => 'required|string|max:200',
        ];

        // فقط اگر ستون‌ها در دیتابیس وجود دارند، قوانین را اضافه کن
        if (Schema::hasColumn('masters', 'email')) {
            $rules['email'] = 'nullable|email|max:100|unique:masters,email';
        }

        if (Schema::hasColumn('masters', 'phone')) {
            $rules['phone'] = 'nullable|string|max:20|regex:/^[0-9۰-۹\s\-\(\)\+]+$/';
        }

        if (Schema::hasColumn('masters', 'specialties')) {
            $rules['specialties'] = 'nullable|string|max:500';
        }

        if (Schema::hasColumn('masters', 'description')) {
            $rules['description'] = 'nullable|string|max:1000';
        }

        if (Schema::hasColumn('masters', 'status')) {
            $rules['status'] = 'required|in:active,inactive,sabbatical';
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attributes = [
            'name' => 'نام و نام خانوادگی',
            'graduation' => 'مدرک تحصیلی',
        ];

        if (Schema::hasColumn('masters', 'email')) {
            $attributes['email'] = 'ایمیل';
        }

        if (Schema::hasColumn('masters', 'phone')) {
            $attributes['phone'] = 'شماره تماس';
        }

        if (Schema::hasColumn('masters', 'specialties')) {
            $attributes['specialties'] = 'تخصص‌ها';
        }

        if (Schema::hasColumn('masters', 'description')) {
            $attributes['description'] = 'توضیحات';
        }

        if (Schema::hasColumn('masters', 'status')) {
            $attributes['status'] = 'وضعیت';
        }

        return $attributes;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'لطفاً نام و نام خانوادگی استاد را وارد کنید.',
            'name.max' => 'نام نباید بیشتر از ۱۵۰ کاراکتر باشد.',
            'name.string' => 'نام باید به صورت متن وارد شود.',

            'graduation.required' => 'لطفاً مدرک تحصیلی استاد را وارد کنید.',
            'graduation.max' => 'مدرک تحصیلی نباید بیشتر از ۲۰۰ کاراکتر باشد.',
            'graduation.string' => 'مدرک تحصیلی باید به صورت متن وارد شود.',

            'email.email' => 'لطفاً یک ایمیل معتبر وارد کنید.',
            'email.max' => 'ایمیل نباید بیشتر از ۱۰۰ کاراکتر باشد.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'phone.max' => 'شماره تماس نباید بیشتر از ۲۰ کاراکتر باشد.',
            'phone.regex' => 'لطفاً یک شماره تماس معتبر وارد کنید.',

            'specialties.max' => 'تخصص‌ها نباید بیشتر از ۵۰۰ کاراکتر باشد.',
            'specialties.string' => 'تخصص‌ها باید به صورت متن وارد شوند.',

            'description.max' => 'توضیحات نباید بیشتر از ۱۰۰۰ کاراکتر باشد.',
            'description.string' => 'توضیحات باید به صورت متن وارد شوند.',

            'status.required' => 'لطفاً وضعیت استاد را انتخاب کنید.',
            'status.in' => 'وضعیت انتخاب شده معتبر نیست.',
        ];
    }

    public function prepareForValidation()
    {
        // پاکسازی و فرمت کردن داده‌ها قبل از اعتبارسنجی
        $this->merge([
            'name' => trim($this->name),
            'graduation' => trim($this->graduation),
            'email' => $this->email ? strtolower(trim($this->email)) : null,
            'phone' => $this->phone ? $this->cleanPhoneNumber($this->phone) : null,
            'specialties' => $this->specialties ? trim($this->specialties) : null,
            'description' => $this->description ? trim($this->description) : null,
            'status' => $this->status ?? 'active',
        ]);
    }

    /**
     * پاکسازی شماره تلفن
     */
    private function cleanPhoneNumber($phone): string
    {
        // حذف همه غیر از اعداد
        $phone = preg_replace('/[^0-9۰-۹]/u', '', $phone);

        // تبدیل اعداد فارسی به انگلیسی
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $phone = str_replace($persianNumbers, $englishNumbers, $phone);

        // اگر با ۹ شروع شده و ۱۰ رقم دارد، صفر به ابتدای آن اضافه کن
        if (strlen($phone) === 10 && str_starts_with($phone, '9')) {
            $phone = '0' . $phone;
        }

        return $phone;
    }

    /**
     * گرفتن داده‌های معتبر شده
     */
    public function validatedData(): array
    {
        $validated = $this->validated();

        // حذف فیلدهایی که در دیتابیس وجود ندارند
        if (!Schema::hasColumn('masters', 'email')) {
            unset($validated['email']);
        }

        if (!Schema::hasColumn('masters', 'phone')) {
            unset($validated['phone']);
        }

        if (!Schema::hasColumn('masters', 'specialties')) {
            unset($validated['specialties']);
        }

        if (!Schema::hasColumn('masters', 'description')) {
            unset($validated['description']);
        }

        if (!Schema::hasColumn('masters', 'status')) {
            unset($validated['status']);
        }

        return $validated;
    }
}
