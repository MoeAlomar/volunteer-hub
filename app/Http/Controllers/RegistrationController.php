<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Opportunity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            // Lock the opportunity row so two people can't take the last seat at once.
            $opportunity = Opportunity::whereKey($data['opportunity_id'])->lockForUpdate()->firstOrFail();

            if ($opportunity->event_date->lt(today())) {
                throw ValidationException::withMessages([
                    'opportunity_id' => 'انتهت هذه الفرصة التطوعية ولا يمكن التسجيل فيها',
                ]);
            }

            if ($opportunity->registrations()->count() >= $opportunity->capacity) {
                throw ValidationException::withMessages([
                    'opportunity_id' => 'عذرًا، اكتمل عدد المقاعد لهذه الفرصة',
                ]);
            }

            if ($opportunity->registrations()->where('email', $data['email'])->exists()) {
                throw ValidationException::withMessages([
                    'email' => 'هذا البريد الإلكتروني مسجّل مسبقًا في هذه الفرصة',
                ]);
            }
              if ($opportunity->registrations()->where('phone', $data['phone'])->exists()) {
                throw ValidationException::withMessages([
                    'phone' => 'رقم الجوال هذا مسجّل مسبقًا في هذه الفرصة',
                ]);
            }

            $opportunity->registrations()->create($data);
        });

        return back()->with('ok', 'تم تسجيلك بنجاح! شكرًا لمشاركتك في العمل التطوعي.');
    }
}
