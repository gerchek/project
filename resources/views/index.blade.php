@extends('layouts.main')

@section('head')
	<title>КЦЕ | Главная страница</title>
@endsection

@push('styles')
	<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@section('content')

	@include('header')

	<div class="wrapper">
		<main class="main">
			@include('index.slider')

			<section class="about section">
				<div class="container">
					<div class="about__inner">
						<div class="about__collage">
							<img class="about__img"
								 src="/images/content/collage/collage-bg.png" alt="">
							<img class="about__collage-photo about__collage-photo_first"
								 src="/{{$mainPageSettings->about_photo_1}}" alt="">
							<img class="about__collage-photo about__collage-photo_second"
								 src="/{{$mainPageSettings->about_photo_2}}" alt="">
							<img class="about__collage-photo about__collage-photo_third about__collage-photo_animate"
								 src="/images/content/collage/collage-3.png" alt="">
						</div>
						<div class="about__text">
							<div class="about__head head">
								<h1 class="about__title">о центре</h1>
								<div class="head__img" id="circles"></div>
							</div>
							<div class="about__desc">{!! $mainPageSettings->about_desc !!}</div>
						</div>
					</div>
				</div>
			</section>

			@include('index.sport-schools')

			@include('index.news')

			@include('forms.feedback-inline', ['page' => 'Главная страница'])
		</main>

		@include('footer', ['page' => 'Главная страница'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/index.js') }}"></script>
	@endpush
@endsection
