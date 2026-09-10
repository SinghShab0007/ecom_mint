@if($paginator->hasPages())
    <nav class="page-navigation justify-content-center d-flex" aria-label="page-navigation">
        <ul class="pagination">
            @if($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link active" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @endif

            @foreach($paginator->getUrlRange(1,$paginator->lastPage()) as $key => $url)
                @if($paginator->currentPage() == $key)
                    <li class="page-item"><a class="page-link active">{{ $key }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $key }}</a></li>
                @endif
            @endforeach

            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link active" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
