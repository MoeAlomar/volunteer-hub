@extends('layouts.app')
@section('title', 'دخول المشرف')
@section('content')
<section><div class="container"><h2 style="text-align:center">تسجيل دخول المشرف</h2>
<form class="box" method="post" action="{{ route('admin.login.submit') }}" data-validate>@include('partials.form-alert')
@csrf
<label for="u">اسم المستخدم</label><input id="u" name="username" value="{{ old('username') }}" required data-label="اسم المستخدم" autocomplete="username">
<label for="p">كلمة المرور</label><input id="p" type="password" name="password" required data-label="كلمة المرور" data-min="6" autocomplete="current-password">
<p style="margin-top:1rem"><button class="btn green" type="submit">دخول</button></p></form></div></section>
@endsection
