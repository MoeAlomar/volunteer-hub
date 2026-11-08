<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpportunityRequest;
use App\Models\Opportunity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OpportunityController extends Controller
{
    public function create(): View
    {
        return view('admin.add', ['opportunity' => new Opportunity()]);
    }

    public function store(OpportunityRequest $request): RedirectResponse
    {
        Opportunity::create($request->validated());

        return redirect()->route('admin.dashboard')->with('ok', 'تمت إضافة الفرصة بنجاح');
    }

    public function edit(Opportunity $opportunity): View
    {
        return view('admin.edit', ['opportunity' => $opportunity]);
    }

    public function update(OpportunityRequest $request, Opportunity $opportunity): RedirectResponse
    {
        $opportunity->update($request->validated());

        return redirect()->route('admin.dashboard')->with('ok', 'تم حفظ التعديلات بنجاح');
    }

    public function destroy(Opportunity $opportunity): RedirectResponse
    {
        $opportunity->delete(); // registrations are removed by the FK cascade

        return redirect()->route('admin.dashboard')->with('ok', 'تم حذف الفرصة وتسجيلاتها');
    }
}
