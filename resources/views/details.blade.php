@extends('layouts.app')
@section('title', $o->title)
@section('content')
<section><div class="container"><div class="detail-hero" style="background:{{ $o->color }}" aria-hidden="true">{{ $o->icon }}<img src="{{ asset('images/'.$o->image.'.jpg') }}" alt="" onerror="this.remove()"></div>
<div class="two"><article><h2>{{ $o->title }}</h2><span class="tag">{{ $o->category }}</span>
<div class="meta" style="margin-top:.6rem"><span>📍 {{ $o->city }}</span><span>📅 {{ $o->event_date->format('Y-m-d') }}</span></div>
<p>{!! nl2br(e($o->description)) !!}</p>
<h3 class="sub">المتطلبات</h3><ul style="padding-inline-start:1.4rem"><li>العمر 16 سنة فأكثر</li><li>الالتزام بالحضور في الموعد المحدد</li><li>ارتداء ملابس رياضية مريحة</li></ul>
<h3 class="sub">المقاعد</h3><div class="progress"><i style="width:{{ $o->percent }}%"></i></div><small>{{ $o->registeredCount() }} من {{ $o->capacity }} مسجّل — المتبقي {{ $o->remaining }}</small>
<p style="margin-top:1.2rem"><a class="btn green" href="{{ route('opportunities.index') }}">← العودة للفرص</a></p></article>
@if ($o->status === 'open')
<form class="box" method="post" action="{{ route('register') }}" data-validate><h3 style="color:var(--g)">سجّل الآن</h3>@include('partials.form-alert')
@csrf
<input type="hidden" name="opportunity_id" value="{{ $o->id }}">
<label for="n">الاسم الكامل</label><input id="n" name="name" value="{{ old('name') }}" required data-label="الاسم" data-min="3">
<label for="e">البريد الإلكتروني</label><input id="e" type="email" name="email" value="{{ old('email') }}" required data-label="البريد الإلكتروني">
<label for="ph">رقم الجوال</label><input id="ph" name="phone" value="{{ old('phone') }}" required data-label="رقم الجوال" data-pattern="^05\d{8}$" data-msg="رقم الجوال يجب أن يبدأ بـ 05 ويتكون من 10 أرقام" placeholder="05XXXXXXXX" inputmode="numeric">
<label for="ag">العمر</label><input id="ag" type="number" name="age" value="{{ old('age') }}" required data-label="العمر" data-minval="16" data-maxval="70" data-msg="العمر يجب أن يكون بين 16 و70 سنة">
<label for="nt">ملاحظات (اختياري)</label><textarea id="nt" name="notes" rows="3">{{ old('notes') }}</textarea>
<p style="margin-top:1rem"><button class="btn" type="submit">تأكيد التسجيل</button></p></form>
@else
<div class="box"><h3 style="color:var(--g)">التسجيل مغلق</h3>@if (session('ok'))<div class="alert ok">{{ session('ok') }}</div>@endif<p>{{ $o->status === 'full' ? 'اكتمل عدد المقاعد لهذه الفرصة.' : 'انتهت هذه الفرصة التطوعية.' }}</p><a class="btn green" href="{{ route('opportunities.index') }}">تصفح فرص أخرى</a></div>
@endif
</div></div></section>
@endsection
