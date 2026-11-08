<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'latest' => Opportunity::withCount('registrations')->latest('id')->take(3)->get(),
            'opportunityCount' => Opportunity::count(),
            'registrationCount' => Registration::count(),
        ]);
    }

    public function opportunities(): View
    {
        return view('opportunities', [
            'opportunities' => Opportunity::withCount('registrations')
                ->orderBy('event_date')
                ->get(),
        ]);
    }

    public function show(Opportunity $opportunity): View
    {
        $opportunity->loadCount('registrations');

        return view('details', ['o' => $opportunity]);
    }

    /** Old link style: /details?id=1. Without an id, go to the nearest upcoming opportunity. */
    public function details(Request $request): RedirectResponse
    {
        $id = $request->integer('id');

        $target = $id
            ? Opportunity::find($id)
            : Opportunity::whereDate('event_date', '>=', today())->orderBy('event_date')->first();

        return $target
            ? redirect()->route('opportunities.show', $target)
            : redirect()->route('opportunities.index');
    }

    public function about(): View
    {
        return view('about');
    }
}
