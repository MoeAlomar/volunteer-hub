{{-- Must stay on ONE line: the CSS hides the box with :empty, so no whitespace inside it. --}}
<div class="alert{{ $errors->any() ? ' err' : (session('ok') ? ' ok' : '') }}" role="alert">{{ $errors->any() ? implode(' • ', array_unique($errors->all())) : session('ok') }}</div>
