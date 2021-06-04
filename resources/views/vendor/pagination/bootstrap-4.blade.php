@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li  class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')" >
                    <span class="page-link" aria-hidden="true"  style="color:#1A4066; padding:2px 6px; 
                    border: none; background: transparent !important; outline:none; margin-top:3px;"><i class="fa fa-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item" >
                   
                        <a style="padding:2px; margin-top:3px; color:#1A4066;border: none; background: transparent !important; outline:none;"class="page-link"  href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa fa-chevron-left"></i></a>
                    
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="padding:2px 6px;" aria-disabled="true"><span class="page-link" style="background:transparent;">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="padding:2px 6px; font-weight:300; color:#fff; background-color:#1A4066!important;  border-radius: 5px; border: solid 2px #1A4066; margin-left:1px; margin-right:1px;">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a style="padding:2px 6px; font-weight:300; color:#898989; background:transparent; border: solid 2px #898989; margin-left:1px; margin-right:1px; border-radius: 5px;" class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a style="padding:2px 6px; color:#1A4066;border: none; background: transparent !important;margin-top:3px;" class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa fa-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true" style="padding:2px 6px; color:#1A4066; 
                    border: none; background: transparent !important;margin-top:3px;"><i class="fa fa-chevron-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
