@extends('layouts.main')

@section('head')
	<title>КЦЕ | Услуги</title>
@endsection

@push('styles')
	<link href="{{ asset('css/services.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Услуги</h1>
							<div class="banner__title-img head__img" id="services"></div>
						</div>
						<p class="banner__desc">Мы предлагаем разнообразный комплекс платных услуг, оказываемых населению,
							учреждениям и организациям.</p>
					</div>
				</div>
			</section>

			<div class="services">
				<div class="container">
					<div class="services__inner">
						@if(!empty($services))
						<aside class="services__sidebar">
							<ul class="services__menu sidemenu">
								@foreach($services as $service)
									<li class="sidemenu__item">
										<a class="sidemenu__item-link" href="#{{ Str::slug($service->name) }}">{{ $service->name }}</a>
									</li>
								@endforeach
							</ul>
							<div class="services__contact contact">
								<h2 class="contact__title">Оставить заявку</h2>
								<p class="contact__desc">Если у вас возникли вопросы, оставьте заявку</p>
								<div class="contact__btn btn btn_alt">Связаться</div>
							</div>
						</aside>
						<div class="services__items">
							@foreach($services as $service)
								<div class="services__item" id="{{ Str::slug($service->name) }}">
									<img class="services__img" src="{{ $service->image }}" alt="">
									<h2 class="services__title accordion-header">{{ $service->name }}</h2>
									<div class="services__info">
										@if($service->text)
										<div class="services__desc">{!! $service->text !!}</div>
										@endif
										@if($service->prices)
										<div class="services__price-list price-list">
											@foreach($service->prices as $price)
												<div class="price-list__item">
													<div class="price-list__title">{{ $price->name }}</div>
													@if($price->duration)
													<div class="price-list__time">{{ $price->duration }}</div>
													@endif
													<div class="price-list__price">{{ $price->price }}, ₽</div>
												</div>
											@endforeach
										</div>
										@endif
									</div>
								</div>
							@endforeach
						@endif
						</div>
					</div>
				</div>
			</div>
		</main>

		@include('footer', ['page' => 'Услуги'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/services.js') }}"></script>
	@endpush
@endsection