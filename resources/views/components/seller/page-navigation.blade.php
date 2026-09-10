@if($paginator->hasPages())
    <nav class="new-pagination mt-3">
        <ul class="pagination">
            @if($paginator->onFirstPage())
                <li class="page-item active"><a class="page-link">{{ __('Previous') }}</a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">{{ __('Previous') }}</a></li>
            @endif
            @foreach($paginator->getUrlRange(1,$paginator->lastPage()) as $key => $url)
                @if($paginator->currentPage() == $key)
                    <li class="page-item active"><a class="page-link">{{ $key }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $key }}</a></li>
                @endif
            @endforeach
            @if($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">{{ __('Next') }}</a></li>
            @else
                <li class="page-item active"><a class="page-link">{{ __('Next') }}</a></li>
            @endif
        </ul>
    </nav>
@endif
