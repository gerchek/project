@extends('layouts.main')

@section('head')
    <title>КЦЕ | 403 - Доступ запрещен</title>
@endsection

@push('styles')
    <link href="{{ asset('css/404.css') }}" rel="stylesheet">
@endpush

@section('content')

    @include('header')

    <div class="wrapper">
        <main class="main">
            <section class="banner">
                <div class="container">
                    <div class="banner__inner">
                        <div class="banner__img-wrapper">
                        </div>
                        <p class="banner__error-text">Вы не имеете прав для доступа к этой странице</p>
                        <a class="banner__back-btn btn" href="{{ route('index') }}">На главную</a>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => '403 - Доступ запрещен'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/404.js') }}"></script>
    @endpush
@endsection