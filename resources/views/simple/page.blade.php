@extends('layouts.main')

@section('head')
    <title>КЦЕ | {{ $page->title }}</title>
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
                        @include('components.breadcrumbs', ['default' => $page->title])
                        <div class="banner__title head">
                            <h1 class="banner__title-text">{{ $page->title }}</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="event">
                <div class="container">
                    <div class="event__inner">
                        <div class="event__body">
                            {!! $page->processedText !!}
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => $page->title])
    </div>

    @push('scripts')
        <script src="{{ asset('js/events_single.js') }}"></script>
    @endpush
@endsection