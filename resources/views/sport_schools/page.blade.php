@extends('layouts.main')

@section('head')
    <title>КЦЕ | {{$sportSchool->name}}</title>
@endsection

@push('styles')
    <link href="{{ asset('css/sport_single.css') }}" rel="stylesheet">
@endpush

@section('content')

    @include('header')

    <div class="wrapper">
        <main class="main">
            <section class="banner">
                <div class="container">
                    <div class="banner__inner">
                        @include('components.breadcrumbs', ['last' => $sportSchool->name])
                        <div class="banner__title head">
                            <h1 class="banner__title-text">{{ $sportSchool->name }}</h1>
                            <div class="banner__title-img head__img" id="#">
                                @include('components.svg', ['svgImage' => $sportSchool->icon])
                            </div>
                        </div>
                        <div class="banner__body">
                            <p class="banner__desc">{!! $sportSchool->banner_text !!}</p>
                            @if($sportSchool->banner_form)
                            <div class="banner__contactBtn btn">Оставить заявку</div>
                            @endif
                        </div>
                        <img class="banner__img" src="/{{$sportSchool->banner}}" alt="">
                    </div>
                </div>
            </section>

            <section class="about section">
                <div class="container">
                    <div class="about__inner">
                        <div class="about__collage">
                            <img class="about__img" src="/images/content/collage/collage-bg.png" alt="">
                            @if($sportSchool->desc_images)
                                @foreach($sportSchool->desc_images as $descImage)
                                    @if($loop->iteration == 1)
                                        <img class="about__collage-photo about__collage-photo_first" src="/{{$descImage}}" alt="">
                                    @elseif($loop->iteration == 2)
                                        <img class="about__collage-photo about__collage-photo_second" src="/{{$descImage}}" alt="">
                                    @elseif($loop->iteration == 3)
                                        <img class="about__collage-photo about__collage-photo_third about__collage-photo_animate" src="/{{$descImage}}" alt="">
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="about__text">
                            <div class="about__head head">
                                <h1 class="about__title">{{ $sportSchool->desc_title }}</h1>
                                <div class="head__img" id="circles"></div>
                            </div>
                            <div class="about__desc">{!! $sportSchool->desc_text !!}</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="treners">
                <div class="container">
                    <div class="treners__inner">
                        <div class="treners__head">
                            <div class="head">
                                <h1 class="treners__title">Тренеры</h1>
                                <div class="treners__title-img head__img" id="leaders"></div>
                            </div>
                            <div class="treners__arrows"></div>
                        </div>
                        <div class="treners__slider">
                            @if($sportSchool->employees)
                                @foreach($sportSchool->employees as $employee)
                                    @include('employees.item', ['employee' => $employee])
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <section class="photos">
                <div class="container">
                    <div class="photos__inner">
                        <div class="photos__head">
                            <div class="head">
                                <h1 class="photos__title">Галерея</h1>
                                <div class="head__img" id="gallery"></div>
                            </div>
                            <div class="photos__arrows">
                                <div class="slick-arrow slick-prev"></div>
                                <div class="slick-arrow slick-next"></div>
                            </div>
                        </div>
                        <div class="photos__slider swiper">
                            <div class="swiper-wrapper">
                                @if($sportSchool->gallery)
                                    @foreach($sportSchool->gallery as $galleryImage)
                                        <img class="swiper-slide photos__img" src="/{{$galleryImage}}" alt="">
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-scrollbar photos__scrollbar"></div>
                        </div>
                    </div>
                </div>
            </section>

            @if($sportSchool->schedule)
            <section class="schedule">
                <div class="container">
                    <a class="schedule__inner" href="/{{ $sportSchool->schedule->file }}" data-fancybox="gallery">
                        <div class="schedule__text">
                            <h1 class="schedule__title">расписание</h1>
                            @if($sportSchool->schedule->text)
                                <p class="schedule__desc">{!!$sportSchool->schedule->text!!}</p>
                            @endif
                        </div>
                        <div class="schedule__item">
                            @if($sportSchool->schedule->type == 'pdf')
                                <a href="/{{ $sportSchool->schedule->file }}"></a>
                            @else
                                <img class="schedule__img" src="/{{ $sportSchool->schedule->file }}" alt="">
                            @endif
                                <img class="schedule__btn" src="/images/icons/plus.svg">
                        </div>
                    </a>
                </div>
            </section>
            @endif

            @include('forms.feedback-inline', ['page' => 'Спортивная школа ('.$sportSchool->name.')'])
        </main>

        @include('footer', ['page' => 'Спортивная школа ('.$sportSchool->name.')'])
    </div>

    @push('scripts')
        <script src="{{ asset('js/sport_single.js') }}"></script>
    @endpush
@endsection