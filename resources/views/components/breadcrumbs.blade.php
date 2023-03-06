<div class="banner__breadcrumbs breadcrumbs">
    <a class="breadcrumbs__item" href="{{ route('index') }}">Главная</a>

    @if (empty($last) && $currentMenuElement)
        <a class="breadcrumbs__item" href="#">{{ $currentMenuElement->title }}</a>
    @else
        @if ($currentMenuElement)
            <a class="breadcrumbs__item" href="{{ $currentMenuElement->href }}">{{ $currentMenuElement->title }}</a>
        @endif
        <a class="breadcrumbs__item" href="#">{{ $last ?? ($default ?? '') }}</a>
    @endif
</div>