@extends('layouts.main')

@section('head')
    <title>КЦЕ | Поиск</title>
@endsection

@push('styles')
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
@endpush

@section('content')

    @include('header')

    <div class="wrapper">
        <main class="main">
            <section class="banner">
                <div class="container">
                    <div class="banner__inner">
                        @include('components.breadcrumbs', ['default' => 'Результаты поиска'])
                        <div class="banner__title head">
                            <h1 class="banner__title-text">Результаты поиска по запросу: {{ request()->search_query }}</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="results">
                <div class="container">
                    <div class="results__inner">
                        <div class="results__head">
                            <form class="results__search" action="{{ route('search') }}" method="GET">
                                <input class="results__input" type="text" name="search_query" value="">
                            </form>
                            <p class="results__found">Найдено 3 результата</p>
                        </div>
                        <div class="results__items">
                            <a class="results__item" href="#">
                                <h2 class="results__item-title">Эквилибр, стрельба из арбалета, вольная борьба и самбо — в этих видах спорта у тимашевцев успех</h2>
                                <p class="results__item-desc">Спортивные новости недели ознаменованы успехом спортсменов из Тимашевского района в четырех видах</p>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'Поиск'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/search.js') }}"></script>
    @endpush
@endsection
