@extends('layouts.main')

@section('head')
	<title>КЦЕ | Партнеры</title>
@endsection

@push('styles')
	<link href="{{ asset('css/partners.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Партнерам</h1>
							<div class="banner__title-img head__img" id="partners"></div>
						</div>
						<p class="banner__desc">В здании краевого центра единоборств площадью около 5000 квадратных метров
							размещены универсальный спортивный зал с трибунами на 1200 зрителей, помещения для различных
							видов единоборств, спортивные залы с раздевалками и душевыми.</p>
					</div>
				</div>
			</section>

			@if(!empty($photos))
			<section class="photos">
				<div class="container">
					<div class="photos__inner">
						<div class="photos__head">
							<div class="head"><h1 class="photos__title">Фото помещений</h1>
								<div class="head__img" id="photos"></div>
							</div>
							<div class="photos__arrows">
								<div class="slick-arrow slick-prev"></div>
								<div class="slick-arrow slick-next"></div>
							</div>
						</div>
						<div class="photos__slider swiper">
							<div class="swiper-wrapper">
								@foreach($photos as $photo)
									<img class="swiper-slide photos__img" src="{{ $photo->image }}" alt="{{ $photo->name ?? '' }}">
								@endforeach
							</div>
							<div class="swiper-scrollbar photos__scrollbar"></div>
						</div>
					</div>
				</div>
			</section>
			@endif

			@if(!empty($documents))
			<section class="offers">
				<div class="container">
					<div class="offers__inner">
						<div class="offers__head head">
							<h1 class="photos__title">Наши предложения</h1>
							<div class="head__img" id="offers"></div>
						</div>
						<div class="offers__items">
							@foreach($documents as $document)
								<a class="offers__item {{$document->type}}" href="{{ $document->file }}" {{ $document->download }}>
									{{ $document->name }}<div class="offers__arrow"></div>
								</a>
							@endforeach
						</div>
					</div>
				</div>
			</section>
			@endif
		</main>

		@include('footer', ['page' => 'Партнеры'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/partners.js') }}"></script>
	@endpush
@endsection