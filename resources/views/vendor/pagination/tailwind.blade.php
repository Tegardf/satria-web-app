@if ($paginator->hasPages())
    <div class="flex justify-center my-4">
        <div class="flex items-center space-x-2">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1 text-purple-300 border border-purple-300 rounded-md cursor-not-allowed">‹</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 text-purple-800 border border-purple-500 rounded-md hover:bg-purple-100">‹</a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- Dots --}}
                @if (is_string($element))
                    <span class="px-3 py-1 text-purple-500">{{ $element }}</span>
                @endif

                {{-- Page Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 border-2 border-purple-600 text-purple-800 font-bold rounded-md bg-white">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1 text-purple-800 border border-purple-300 rounded-md hover:bg-purple-100">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 text-purple-800 border border-purple-500 rounded-md hover:bg-purple-100">›</a>
            @else
                <span class="px-3 py-1 text-purple-300 border border-purple-300 rounded-md cursor-not-allowed">›</span>
            @endif
        </div>
    </div>
@endif
