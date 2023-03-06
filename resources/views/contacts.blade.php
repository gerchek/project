@extends('layouts.main')

@section('head')
	<title>КЦЕ | Контакты</title>
@endsection

@push('styles')
	<link href="{{ asset('css/contacts.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Контакты</h1>
							<div class="banner__title-img head__img" id="contacts"></div>
						</div>
					</div>
				</div>
			</section>

			<div class="contacts">
				<div class="container">
					<div class="contacts__inner">
						<div class="contacts__map"></div>
						<div class="contacts__info">
							<div class="contacts__head">
								<img class="contacts__logo" src="/images/logo/logo-textWhite.svg" alt="">
								<div class="contacts__socials">
								@if($socnets)
									@foreach($socnets as $socnet)
										<a class="contacts__social-link" href="{{ $socnet->link }}">
											{{--@include('components.svg', ['svgImage' => $socnet->image])--}}
											<img class="contacts__{{$socnet->type}} social-icon" src="{{ $socnet->image }}" alt="">
										</a>
									@endforeach
								@endif
								</div>
							</div>
							<div class="contacts__body">
								@if($contacts->address)
								<p class="contacts__address">{{ $contacts->address }}</p>
								@endif
								<p class="contacts__schedule">Ежедневно с 9:00 - 21:00</p>
								<div class="contacts__contacts">
									<a class="contacts__phone" href="tel:{{ $contacts->formatPhone($contacts->phone_1) }}">{{ $contacts->phone_1 }}</a>
									@if($contacts->phone_2)
									<a class="contacts__phone" href="tel:{{ $contacts->formatPhone($contacts->phone_2) }}">{{ $contacts->phone_2 }}</a>
									@endif
									@if($contacts->email)
									<a class="contacts__email" href="mailto:{{ $contacts->email }}">{{ $contacts->email }}</a>
									@endif
								</div>
								<div class="contacts__bg"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

		@include('footer', ['page' => 'Контакты'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/contacts.js') }}"></script>
	@endpush
@endsection