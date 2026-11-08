<!DOCTYPE html>
<html lang="ar" dir="rtl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') | منصة تطوّع</title><link rel="stylesheet" href="{{ asset('css/style.css') }}"></head><body>
<header class="site"><div class="container"><a class="logo" href="{{ route('home') }}">منصة <span>تطوّع</span></a>
<button class="icon-btn menu-toggle" aria-label="القائمة">☰ القائمة</button>
<nav aria-label="التنقل الرئيسي"><ul>
<li><a href="{{ route('home') }}" @class(['active' => request()->routeIs('home')])>الرئيسية</a></li>
<li><a href="{{ route('opportunities.index') }}" @class(['active' => request()->routeIs('opportunities.index')])>الفرص التطوعية</a></li>
<li><a href="{{ route('details') }}" @class(['active' => request()->routeIs('opportunities.show', 'details')])>التفاصيل والتسجيل</a></li>
<li><a href="{{ route('about') }}" @class(['active' => request()->routeIs('about')])>عن المنصة</a></li>
@auth('admin')
<li><a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.*')])>لوحة التحكم</a></li>
@else
<li><a href="{{ route('admin.login') }}" @class(['active' => request()->routeIs('admin.login')])>دخول المشرف</a></li>
@endauth
<li><button id="darkToggle" class="icon-btn">🌙 الوضع الليلي</button></li></ul></nav></div></header>
<main>@yield('content')</main>
<footer class="site"><p>© 2026 منصة تطوّع — مشروع مقرر CSC457 | دعمًا لمستهدف رؤية 2030: مليون متطوع</p></footer>
<script src="{{ asset('js/main.js') }}"></script></body></html>
