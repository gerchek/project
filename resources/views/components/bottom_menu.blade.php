@php $displayedListTag = false; @endphp

<div class="footer__links">
    @foreach ($footerMenu as $menu1)
        @if (count($menu1->childs))
            @if($displayedListTag)
                </div>
                @php $displayedListTag = false; @endphp
            @endif
            <div class="footer__link-list">
                <h3 class="footer__heading">{{ $menu1->title }}</h3>
                <ul class="footer__list">
                    @foreach ($menu1->childs as $menu2)
                        <li class="footer__list-item">
                            <a class="footer__list-link" href="{{ $menu2->href }}">{{ $menu2->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif ($menu1->parent_id == null || $menu1->parent_id == 0)
            @if(!$displayedListTag)
            <div class="footer__link-list footer__link-list_with-headers">
            @php $displayedListTag = true; @endphp
            @endif
                <a class="footer__list-link" href="{{ $menu1->href }}">
                    <h3 class="footer__heading">{{ $menu1->title }}</h3>
                </a>
        @endif
    @endforeach
    @if($displayedListTag)
        </div>
        @php $displayedListTag = false; @endphp
    @endif
</div>