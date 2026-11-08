@extends('layouts.app')
@section('title', 'الرئيسية')
@section('content')
<section class="hero"><h1>كن جزءًا من التغيير</h1><p>منصة تجمع المتطوعين بالفرص التطوعية في مختلف مناطق المملكة، دعمًا لرؤية 2030 ومستهدف مليون متطوع.</p><a class="btn" href="{{ route('opportunities.index') }}">تصفح الفرص التطوعية</a></section>
<section><div class="container"><h2>منصتنا بالأرقام</h2><div class="stats"><div><b data-count="{{ $opportunityCount }}">0</b>فرصة تطوعية</div><div><b data-count="{{ $registrationCount }}">0</b>متطوع مسجّل</div><div><b data-count="13">0</b>منطقة</div><div><b data-count="1000000">0</b>مستهدف 2030</div></div></div></section>
<section><div class="container"><h2>كيف تبدأ؟</h2><ol class="steps"><li>تصفح الفرص وصفّها حسب المجال أو المدينة.</li><li>اختر الفرصة المناسبة واقرأ تفاصيلها.</li><li>سجّل بياناتك وسيصلك تأكيد المشاركة.</li></ol></div></section>
<section><div class="container"><h2>أحدث الفرص</h2>
@if ($latest->isEmpty())
<p>لا توجد فرص تطوعية حاليًا.</p>
@else
<div class="grid">@foreach ($latest as $o)@include('partials.card', ['o' => $o])@endforeach</div>
@endif
</div></section>
@endsection
