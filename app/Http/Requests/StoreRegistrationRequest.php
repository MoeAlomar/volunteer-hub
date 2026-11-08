<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Accept Arabic-Indic digits (٠١٢...) typed on Arabic keyboards.
        $digits = ['٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
                   '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'];

        $this->merge([
            'name' => trim((string) $this->input('name')),
            'email' => mb_strtolower(trim((string) $this->input('email'))),
            'phone' => strtr(trim((string) $this->input('phone')), $digits),
            'age' => strtr(trim((string) $this->input('age')), $digits),
        ]);
    }

    public function rules(): array
    {
        return [
            'opportunity_id' => ['required', 'integer', 'exists:opportunities,id'],
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'phone' => ['required', 'regex:/^05\d{8}$/'],
            'age' => ['required', 'integer', 'between:16,70'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'الرجاء إدخال :attribute',
            'name.min' => 'الاسم يجب ألا يقل عن 3 أحرف',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'phone.regex' => 'رقم الجوال يجب أن يبدأ بـ 05 ويتكون من 10 أرقام',
            'age.integer' => 'العمر يجب أن يكون رقمًا',
            'age.between' => 'العمر يجب أن يكون بين 16 و70 سنة',
            'opportunity_id.exists' => 'الفرصة التطوعية غير موجودة',
            'max' => 'القيمة المدخلة في :attribute طويلة جدًا',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الجوال',
            'age' => 'العمر',
            'notes' => 'الملاحظات',
        ];
    }
}
