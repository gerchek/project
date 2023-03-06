@extends('layouts.main')

@section('head')
    <title>КЦЕ | {{ $vacancy->name }}</title>
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
                        @include('components.breadcrumbs', ['last' => $vacancy->name])
                        <div class="banner__title head">
                            <h1 class="banner__title-text">{{ $vacancy->name }}</h1>
                            <div class="banner__title-img head__img" id="vacancy"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="vacancies">
                <div class="container">
                    <div class="vacancies__inner">
                        <div class="vacancy">
                            <div class="vacancy__text">
                                <p class="vacancy__desc">{!! $vacancy->full_text !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'Вакансии ('.$vacancy->name.')'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/vacancy.js') }}"></script>
    @endpush
@endsection