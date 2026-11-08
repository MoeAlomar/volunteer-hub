@if ($paginator->hasPages())
<p class="pager">@if (! $paginator->onFirstPage())<a class="btn sm" href="{{ $paginator->previousPageUrl() }}">السابق</a>@endif <small>صفحة {{ $paginator->currentPage() }} من {{ $paginator->lastPage() }}</small> @if ($paginator->hasMorePages())<a class="btn sm" href="{{ $paginator->nextPageUrl() }}">التالي</a>@endif</p>
@endif
