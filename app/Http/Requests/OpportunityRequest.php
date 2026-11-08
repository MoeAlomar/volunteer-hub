<?php

namespace App\Http\Requests;

use App\Models\Opportunity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // protected by the auth:admin middleware on the routes
    }

    public function rules(): array
    {
        /** @var Opportunity|null $current */
        $current = $this->route('opportunity');
        $minCapacity = $current ? max(1, $current->registrations()->count()) : 1;

        return [
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'category' => ['required', Rule::in(Opportunity::CATEGORIES)],
            'city' => ['required', 'string', 'max:80'],
            // New opportunities must be in the future; editing an old one may keep its date.
            'event_date' => $current
                ? ['required', 'date']
                : ['required', 'date', 'after_or_equal:today'],
            // Capacity can never drop below the number of people already registered.
            'capacity' => ['required', 'integer', 'min:'.$minCapacity, 'max:1000'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'الرجاء إدخال :attribute',
            'title.min' => 'العنوان يجب ألا يقل عن 5 أحرف',
            'category.in' => 'المجال المختار غير صحيح',
            'event_date.date' => 'صيغة التاريخ غير صحيحة',
            'event_date.after_or_equal' => 'تاريخ الفرصة يجب أن يكون اليوم أو بعده',
            'capacity.integer' => 'عدد المقاعد يجب أن يكون رقمًا',
            'capacity.min' => 'عدد المقاعد لا يمكن أن يقل عن :min (عدد المسجلين حاليًا)',
            'capacity.max' => 'عدد المقاعد بين 1 و1000',
            'description.min' => 'الوصف يجب ألا يقل عن 20 حرفًا',
            'max' => 'القيمة المدخلة في :attribute طويلة جدًا',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'العنوان',
            'category' => 'المجال',
            'city' => 'المدينة',
            'event_date' => 'التاريخ',
            'capacity' => 'عدد المقاعد',
            'description' => 'الوصف',
        ];
    }
}
