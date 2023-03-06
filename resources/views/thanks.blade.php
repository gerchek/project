@extends('layouts.main')

@section('head')
	<title>КЦЕ | Благодарности</title>
@endsection

@push('styles')
	<link href="{{ asset('css/thanks.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Благодарности</h1>
							<div class="banner__title-img head__img" id="thanks"></div>
						</div>
						<p class="banner__desc">В здании краевого центра единоборств площадью около 5000 квадратных метров
							размещены универсальный спортивный зал с трибунами на 1200 зрителей, помещения для различных
							видов единоборств, спортивные залы с раздевалками и душевыми.</p>
					</div>
				</div>
			</section>

			@if(!empty($diplomas))
			<section class="graduates">
				<div class="container">
					<div class="graduates__inner">
						<div class="graduates__head">
							<div class="head">
								<h1 class="graduates__title">Грамоты</h1>
								<div class="graduates__title-img head__img" id="graduates"></div>
							</div>
						</div>
						<div class="graduates__slider">
							@foreach($diplomas as $diploma)
								<div class="graduates__item">
									<img class="graduates__img" src="{{ $diploma->image }}" alt="{{ $diploma->name ?? '' }}">
									<p class="graduates__text">{{ $diploma->name }}</p>
								</div>
							@endforeach
						</div>
						<div class="graduates__arrows"></div>
					</div>
				</div>
			</section>
			@endif

			<section class="reviews">
				<div class="container">
					<div class="reviews__inner">
						<div class="reviews__head">
							<div class="head">
								<h1 class="reviews__title">Отзывы</h1>
								<div class="reviews__title-img head__img" id="reviews"></div>
							</div>
						</div>
						<div class="reviews__slider"></div>
						<div class="reviews__arrows"></div>
					</div>
				</div>
			</section>

			@include('forms.review-inline', ['page' => 'Благодарности'])
		</main>

		@include('footer', ['page' => 'Благодарности'])

		@include('modals.review')
	</div>

	@push('scripts')
		<script src="{{ asset('js/thanks.js') }}"></script>
	@endpush
@endsection