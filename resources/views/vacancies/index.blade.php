@extends('layouts.main')

@section('head')
    <title>КЦЕ | Вакансии</title>
@endsection

@push('styles')
    <link href="{{ asset('css/vacancy.css') }}" rel="stylesheet">
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
                            <h1 class="banner__title-text">Вакансии</h1>
                            <div class="banner__title-img head__img" id="vacancy"></div>
                        </div>
                        <p class="banner__desc">Краевой центр единоборств постоянно растет и развивается, поэтому мы
                            приглашаем вас присоединиться к нашему дружному коллективу!</p>
                    </div>
                </div>
            </section>

            <section class="vacancies">
                <div class="container">
                    <div class="vacancies__inner">
                        <div class="vacancies__items"></div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'Вакансии'])

        @include('modals.vacancy')
    </div>

    @push('scripts')
        <script src="{{ asset('js/vacancy.js') }}"></script>
    @endpush
@endsection