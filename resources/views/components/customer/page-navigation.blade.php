@if($paginator->hasPages())
    <div class="pagination-bar justify-content-center d-flex">
        <ul class="pagination">
            @if($paginator->onFirstPage())
                <li class="page-item active">
                    <a class="page-link" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous" data-stat="{{ $stat }}">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @endif

            @foreach($paginator->getUrlRange(1,$paginator->lastPage()) as $key => $url)
                @if($paginator->currentPage() == $key)
                    <li class="page-item active"><a class="page-link" >{{ $key }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}" data-stat="{{ $stat }}">{{ $key }}</a></li>
                @endif
            @endforeach

            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next" data-stat="{{ $stat }}">
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
    </div>
@endif
