@extends('layouts.main')

@section('head')
    <title>КЦЕ | {{$newsItem->name}}</title>
@endsection

@push('styles')
    <link href="{{ asset('css/events_single.css') }}" rel="stylesheet">
@endpush

@section('content')

    @include('header')

    <div class="wrapper">
        <main class="main">
            <section class="banner">
                <div class="container">
                    <div class="banner__inner">
                        @include('components.breadcrumbs', ['last' => $newsItem->name])
                        <div class="banner__title head">
                            <h1 class="banner__title-text">{{ $newsItem->name }}</h1>
                        </div>
                        <img class="banner__img" src="/{{ $newsItem->image }}" alt="">
                    </div>
                </div>
            </section>

            <section class="event">
                <div class="container">
                    <div class="event__inner">
                        <div class="event__head">
                            <span class="event__date">{{ $newsItem->formatDate }}</span>
                            <span class="event__type">{{ $newsItem->parent->name }}</span>
                        </div>
                        <div class="event__body">
                            {!! $newsItem->processedText !!}
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'События ('.$newsItem->name.')'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/events_single.js') }}"></script>
    @endpush
@endsection