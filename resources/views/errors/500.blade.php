@extends('layouts.main')

@section('head')
	<title>КЦЕ | 500 - Internal Server Error</title>
@endsection

@push('styles')
	<link href="{{ asset('css/500.css') }}" rel="stylesheet">
@endpush

@section('content')

	@include('header')

	<div class="wrapper">
		<main class="main">
			<section class="banner">
				<div class="container">
					<div class="banner__inner">
						<div class="banner__img-wrapper">
							<img class="banner__error-img" src="/images/content/500.png">
							<img class="banner__error-sticker" src="/images/content/error-sticker.png">
						</div>
						<p class="banner__error-text">500 Internal Server Error (Внутренняя ошибка сервера).</p>
					</div>
				</div>
			</section>
		</main>

		@include('footer', ['page' => '500 - Internal Server Error'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/500.js') }}"></script>
	@endpush
@endsection