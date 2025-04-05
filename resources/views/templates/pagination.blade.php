<div class="d-flex flex-column align-items-center">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm m-0 mb-1 border-clr1 rounded overflow-hidden">
            @if ($xxx->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link bg-clr1 ">&laquo;</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link bg-clr1 text-white " href="{{ $xxx->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @foreach ($xxx->links()->elements[0] as $page => $url)
                <li class="page-item {{ $page == $xxx->currentPage() ? 'bg-clrsec' : '' }}">
                    <a class="page-link bg-transparent  text-clr1" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            @if ($xxx->hasMorePages())
                <li class="page-item">
                    <a class="page-link bg-clr1 text-white " href="{{ $xxx->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link bg-clr1 ">&raquo;</a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="mt-1 text-muted text-center fsz-10">
        Showing {{ $xxx->firstItem() }} - {{ $xxx->lastItem() }} posts from {{ $xxx->total() }} posts.
    </div>
</div>