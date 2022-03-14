<nav>
    @if(!is_null($firstPageUrl))
        <button>
            <a href="{{ $firstPageUrl }}">First page</a>
        </button>
    @endif
    @if(!is_null($previousPageUrl))
        <button>
            <a href="{{ $previousPageUrl }}">Previous page</a>
        </button>
    @endif
    @if(!is_null($nextPageUrl))
        <button>
            <a href="{{ $nextPageUrl }}">Next page</a>
        </button>
    @endif
</nav>
