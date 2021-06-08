@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li  class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')" >
                    <span class="page-link" aria-hidden="true"  style="color:#5D2B30; padding:2px 4px; 
                    border: none; background: transparent !important;"><i class="fa fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item" >
                   
                        <a style="padding:2px; color:#5D2B30;border: none; background: transparent !important;"class="page-link"  href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa fa-chevron-left"></i></a>
                    
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="padding:2px 4px;" aria-disabled="true"><span class="page-link" style="background:transparent;">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="padding:2px 4px; font-weight:900; color:#fff; background-color:#5D2B30 !important;  border-radius: 5px; border: solid 2px #5D2B30; margin-left:1px; margin-right:1px;">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a style="padding:2px 4px; font-weight:600; color:#898989; background:transparent; border: solid 2px #898989; margin-left:1px; margin-right:1px; border-radius: 5px;" class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a style="padding:2px 4px; color:#5D2B30;border: none; background: transparent !important;" class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true" style="padding:2px 4px; color:#5D2B30; 
                    border: none; background: transparent !important;"><i class="fa fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
