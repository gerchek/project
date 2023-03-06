@extends('layouts.main')

@section('head')
    <title>КЦЕ | Галерея</title>
@endsection

@push('styles')
    <link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
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
                            <h1 class="banner__title-text">Галерея</h1>
                            <div class="banner__title-img head__img" id="gallery"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="gallery">
                <div class="container">
                    <div class="gallery__inner">
                        <div class="gallery__page">
                            <div class="gallery__filter">
                                <div class="btn">Фильтр по дате</div>
                                <div class="datepicker-wrapper"></div>
                                <input class="filter__input" type="text" name="to" autocomplete="off">
                            </div>
                            <div class="gallery__items">
                                @foreach($galleries as $gallery)
                                    <a class="gallery__item-link gallery__item" href="{{ $gallery->url }}">
                                        <div class="gallery__thumbnail">
                                            <img class="gallery__thumbnail-img" src="{{ $gallery->cover }}" alt="">
                                            <div class="gallery__date">{{ $gallery->formatDate }}</div>
                                        </div>
                                        <h2 class="gallery__title">{{ Str::words($gallery->name, 15, '...') }}</h2>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>


        @include('footer', ['page' => 'Галерея'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/gallery.js') }}"></script>
    @endpush
@endsection