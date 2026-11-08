@extends('layouts.app')
@section('title', 'الفرص التطوعية')
@section('content')
<section><div class="container"><h2>الفرص التطوعية</h2>
<div class="filters"><button class="active" data-filter="all">الكل</button>@foreach (\App\Models\Opportunity::CATEGORIES as $c)<button data-filter="{{ $c }}">{{ $c }}</button>@endforeach<input id="search" type="search" placeholder="ابحث بالعنوان أو المدينة..." aria-label="بحث"></div>
<div class="grid" id="regionsGrid">@foreach ($opportunities as $o)@include('partials.card', ['o' => $o])@endforeach</div>
<p id="noResults" @if ($opportunities->isNotEmpty()) hidden @endif>لا توجد فرص مطابقة.</p></div></section>
@endsection
