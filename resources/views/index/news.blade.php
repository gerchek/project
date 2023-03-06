<section class="events section">
    <div class="container">
        <div class="events__inner">
            <div class="events__head">
                <div class="head"><h1 class="events__title">События</h1>
                    <div class="head__img" id="events"></div>
                </div>
                <a class="events__btn" href="{{ route('news') }}">все события
                    <div class="arrow">
                        <div class="arrow__circle"></div>
                        <img class="events__arrow" src="/images/icons/arrow.svg" alt="">
                    </div>
                </a>
            </div>
            <div class="events__list">
                @foreach($newsItems as $newsItem)
                    <div class="events__item card">
                        <a class="events__item-link item-link" href="{{ $newsItem->url }}"><span></span></a>
                        <div class="events__img-wrapper">
                            <a class="events__item-tag type_{{$newsItem->type}}" href="{{ $newsItem->url }}">{{ $newsItem->parent->name }}</a>
                            <img class="events__item-img {{ $loop->iteration == 2 ? 'events__item-img_pos_bottom' : '' }}" src="/{{ $newsItem->image }}" alt="">
                        </div>
                        <div class="events__date">{{ $newsItem->formatDate }}</div>
                        <div class="events__desc">{{ Str::words($newsItem->name, 15, '...') }}</div>
                    </div>
                @endforeach
            </div>

            <a class="events__allBtn btn" href="{{ route('news') }}">Смотреть все события</a>
        </div>
    </div>
</section>
