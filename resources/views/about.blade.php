@extends('layouts.app')
@section('title', 'عن المنصة')
@section('content')
<section><div class="container"><h2>عن المنصة</h2>
<p>منصة تطوّع تربط المتطوعين بالجهات المنظمة للفرص التطوعية في المملكة، وتسهّل نشر الفرص وإدارة التسجيل، تماشيًا مع مستهدفات رؤية السعودية 2030 في رفع عدد المتطوعين إلى مليون متطوع.</p>
<h3 class="sub">مجالات التطوع</h3><div class="grid">@foreach (\App\Models\Opportunity::CATEGORIES as $c)<div class="card"><div class="body"><h3>{{ $c }}</h3></div></div>@endforeach</div>
<h3 class="sub">تواصل معنا</h3><p>البريد: info@tatawwa.example — الجوال: 0500000000</p></div></section>
@endsection
