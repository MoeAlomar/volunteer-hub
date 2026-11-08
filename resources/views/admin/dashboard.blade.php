@extends('layouts.app')
@section('title', 'لوحة التحكم')
@section('content')
<section><div class="container"><div class="admin-bar"><h2>لوحة التحكم</h2><div><a class="btn green" href="{{ route('admin.opportunities.create') }}">+ إضافة فرصة</a> <form class="inline" method="post" action="{{ route('admin.logout') }}">@csrf<button class="btn red" type="submit">تسجيل الخروج</button></form></div></div>
<div class="stats" style="margin-bottom:1.5rem"><div><b>{{ $opportunities->count() }}</b>فرص</div><div><b>{{ $registrationTotal }}</b>تسجيلات</div><div><b>{{ $openCount }}</b>فرص متاحة</div></div>
@if (session('ok'))<div class="alert ok">{{ session('ok') }}</div>@endif
<h3 class="sub">الفرص التطوعية</h3><div class="table-wrap"><table><thead><tr><th>#</th><th>العنوان</th><th>المجال</th><th>المدينة</th><th>التاريخ</th><th>المسجلون</th><th>إجراءات</th></tr></thead><tbody>
@forelse ($opportunities as $o)
<tr><td>{{ $o->id }}</td><td>{{ $o->title }}</td><td>{{ $o->category }}</td><td>{{ $o->city }}</td><td>{{ $o->event_date->format('Y-m-d') }}</td><td>{{ $o->registeredCount() }}/{{ $o->capacity }}</td><td><a class="btn green sm" href="{{ route('admin.opportunities.edit', $o) }}">تعديل</a> <form class="inline" method="post" action="{{ route('admin.opportunities.destroy', $o) }}">@csrf @method('DELETE')<button class="btn red sm" type="submit" data-confirm="هل أنت متأكد من حذف هذه الفرصة؟ سيتم حذف تسجيلاتها أيضًا.">حذف</button></form></td></tr>
@empty
<tr><td colspan="7">لا توجد فرص بعد.</td></tr>
@endforelse
</tbody></table></div>
<h3 class="sub">التسجيلات</h3><div class="table-wrap"><table><thead><tr><th>#</th><th>الاسم</th><th>البريد</th><th>الجوال</th><th>الفرصة</th><th>التاريخ</th><th>إجراءات</th></tr></thead><tbody>
@forelse ($registrations as $r)
<tr><td>{{ $r->id }}</td><td>{{ $r->name }}</td><td>{{ $r->email }}</td><td>{{ $r->phone }}</td><td>{{ $r->opportunity->title }}</td><td>{{ $r->created_at->format('Y-m-d') }}</td><td><form class="inline" method="post" action="{{ route('admin.registrations.destroy', $r) }}">@csrf @method('DELETE')<button class="btn red sm" type="submit" data-confirm="حذف هذا التسجيل؟">حذف</button></form></td></tr>
@empty
<tr><td colspan="7">لا توجد تسجيلات بعد.</td></tr>
@endforelse
</tbody></table></div>
{{ $registrations->links('partials.pagination') }}
</div></section>
@endsection
