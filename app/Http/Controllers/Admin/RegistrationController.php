<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()->route('admin.dashboard')->with('ok', 'تم حذف التسجيل');
    }
}
