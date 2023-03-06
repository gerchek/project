@extends('layouts.main')

@section('head')
    <title>КЦЕ | События</title>
@endsection

@push('styles')
    <link href="{{ asset('css/events.css') }}" rel="stylesheet">
@endpush

@section('content')

    @include('header')

    <div class="wrapper">
        <main class="main">
            <section class="banner">
                <div class="container">
                    <div class="banner__inner">
                        @include('components.breadcrumbs')
                        <div class="banner__title head">
                            <h1 class="banner__title-text">События</h1>
                            <div class="banner__title-img head__img" id="events"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="events">
                <div class="container">
                    <div class="events__inner">
                        <div class="btn events__global-filter">Фильтр</div>
                        <div class="events__head">
                            <div class="events__controls">
                                <button class="events__control btn events__control_active" type="button" data-group="0">Все</button>
                                @foreach($newsGroups as $newsGroup)
                                    <button class="events__control btn" type="button" data-group="{{ $newsGroup->id }}">{{ $newsGroup->name }}</button>
                                @endforeach
                            </div>
                            <div class="events__filter">
                                <div class="btn">Фильтр по дате</div>
                                <div class="datepicker-wrapper"></div>
                                <input class="filter__input" type="text" name="to" autocomplete="off">
                            </div>
                        </div>
                        <ul class="events__list">
                            @foreach($newsItems as $newsItem)
                                <li class="events__item card">
                                    <a class="events__item-link item-link" href="{{ $newsItem->url }}"><span></span></a>
                                    <div class="events__img-wrapper">
                                        <a class="events__item-tag type_{{$newsItem->type}}" href="{{ $newsItem->url }}">{{ $newsItem->parent->name }}</a>
                                        <img class="events__item-img" src="/{{ $newsItem->image }}" alt="">
                                    </div>
                                    <div class="events__date">{{ $newsItem->formatDate }}</div>
                                    <div class="events__desc">{{ Str::words($newsItem->name, 15, '...') }}</div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="events__pagination pagination">
                            <div class="pagination__prev-btn slick-arrow"></div>
                            <div class="pagination__pages">
                                <div class="pagination__page">1</div>
                                <div class="pagination__page">2</div>
                                <div class="pagination__page pagination__page_active">3</div>
                                <div class="pagination__page">4</div>
                            </div>
                            <div class="pagination__next-btn slick-arrow"></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'События'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/events.js') }}"></script>
    @endpush
@endsection

