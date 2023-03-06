@extends('layouts.main')

@section('head')
    <title>КЦЕ | Руководство</title>
@endsection

@push('styles')
    <link href="{{ asset('css/leaders.css') }}" rel="stylesheet">
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
                            <h1 class="banner__title-text">Руководство</h1>
                            <div class="banner__title-img head__img" id="leaders"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="leaders">
                <div class="container">
                    <div class="leaders__inner">

                        @if(!empty($employeesGroups))
                            <div class="leaders__select-wrapper">
                                <select id="groups" style="width:100%">
                                    <option value="all">Все </option>
                                    @foreach($employeesGroups as $employeesGroup)
                                        <option value="{{$employeesGroup->id}}">{{ $employeesGroup->name }}</option>
                                    @endforeach
                                </select>
                                <div class="leaders__arrow-wrapper">
                                    <div class="arrow__circle_no-pointer"></div>
                                    <img class="leaders__arrow" src="/images/icons/arrow.svg" alt="">
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </section>
        </main>

        @include('footer', ['page' => 'Руководство'])

        @include('modals.employee')
    </div>

    @push('scripts')
        <script src="{{ asset('js/management.js') }}"></script>
    @endpush
@endsection
