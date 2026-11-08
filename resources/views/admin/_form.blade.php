<form class="box" method="post" action="{{ $opportunity->exists ? route('admin.opportunities.update', $opportunity) : route('admin.opportunities.store') }}" data-validate>@include('partials.form-alert')
@csrf
@if ($opportunity->exists)
@method('PUT')
@endif
<label for="a">عنوان الفرصة</label><input id="a" name="title" value="{{ old('title', $opportunity->title) }}" required data-label="العنوان" data-min="5">
<label for="b">المجال</label><select id="b" name="category" required data-label="المجال"><option value="">اختر...</option>@foreach (\App\Models\Opportunity::CATEGORIES as $c)<option value="{{ $c }}" @selected(old('category', $opportunity->category) === $c)>{{ $c }}</option>@endforeach</select>
<label for="c">المدينة</label><input id="c" name="city" value="{{ old('city', $opportunity->city) }}" required data-label="المدينة">
<label for="dt">التاريخ</label><input id="dt" type="date" name="event_date" value="{{ old('event_date', $opportunity->event_date?->format('Y-m-d')) }}" required data-label="التاريخ">
<label for="cp">عدد المقاعد</label><input id="cp" type="number" name="capacity" value="{{ old('capacity', $opportunity->capacity) }}" required data-label="عدد المقاعد" data-minval="1" data-maxval="1000" data-msg="عدد المقاعد بين 1 و1000">
<label for="d">الوصف</label><textarea id="d" name="description" rows="5" required data-label="الوصف" data-min="20">{{ old('description', $opportunity->description) }}</textarea>
<p style="margin-top:1rem"><button class="btn green" type="submit">حفظ</button> <a class="btn" href="{{ route('admin.dashboard') }}">إلغاء</a></p></form>
