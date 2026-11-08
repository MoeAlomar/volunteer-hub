<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $opportunities = Opportunity::withCount('registrations')->orderBy('id')->get();

        return view('admin.dashboard', [
            'opportunities' => $opportunities,
            'registrations' => Registration::with('opportunity:id,title')
                ->latest('id')
                ->paginate(25),
            'registrationTotal' => Registration::count(),
            'openCount' => $opportunities->filter(fn ($o) => $o->status === 'open')->count(),
        ]);
    }
}
