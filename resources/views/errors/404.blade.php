@extends('layouts.main')

@section('head')
	<title>КЦЕ | 404 - Страница не найдена</title>
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
							<img class="banner__error-img" src="/images/content/404.png">
							<img class="banner__error-sticker" src="/images/content/error-sticker.png">
						</div>
						<p class="banner__error-text">По вашему запросу ничего не найдено</p>
						<a class="banner__back-btn btn" href="{{ route('index') }}">На главную</a>
					</div>
				</div>
			</section>
		</main>

		@include('footer', ['page' => '404 - Страница не найдена'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/404.js') }}"></script>
	@endpush
@endsection