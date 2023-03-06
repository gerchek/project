@extends('layouts.main')

@section('head')
    <title>КЦЕ | {{$gallery->name}}</title>
@endsection

@push('styles')
    <link href="{{ asset('css/gallery_single.css') }}" rel="stylesheet">
@endpush

@section('content')

    @include('header')

    <div class="wrapper">
        <main class="main">
            <section class="banner">
                <div class="container">
                    <div class="banner__inner">
                        @include('components.breadcrumbs', ['last' => $gallery->name])
                        <div class="banner__title head">
                            <h1 class="banner__title-text">{{$gallery->name}}</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="gallery">
                <div class="container">
                    <div class="gallery__inner">
                        <div class="gallery__date">{{ $gallery->formatDate }}</div>
                        <div class="gallery__items">
                            @foreach($gallery->images as $galleryImage)
                                <a class="gallery__item" href="/{{$galleryImage}}" data-fancybox="gallery">
                                    <img class="gallery__img" src="/{{$galleryImage}}" alt="">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'Галерея ('.$gallery->name.')'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/gallery_single.js') }}"></script>
    @endpush
@endsection