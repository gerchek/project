@extends('layouts.main')

@section('head')
	<title>КЦЕ | Стоимость</title>
@endsection

@push('styles')
	<link href="{{ asset('css/prices.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Стоимость</h1>
							<div class="banner__title-img head__img" id="prices"></div>
						</div>
					</div>
				</div>
			</section>

			<section class="prices">
				<div class="container">
					<div class="prices__inner">
						@if(!empty($groupedPrices))
							@foreach($groupedPrices as $pricesGroupName => $pricesGroup)
								@php $pricesGroup = $pricesGroup->collapse() @endphp
								<div class="prices__section">
									<h2 class="prices__title accordion-header">{{ $pricesGroupName }}</h2>
									<div class="services__price-list price-list">
										@foreach($pricesGroup as $price)
											<div class="price-list__item">
												<div class="price-list__title">{{ $price->name }}</div>
												<div class="price-list__time">{!! $price->duration ? $price->processedDuration : "&ndash;" !!}</div>
												<div class="price-list__price">{{ $price->price }}₽</div>
											</div>
										@endforeach
									</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</section>
		</main>

		@include('footer', ['page' => 'Стоимость'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/prices.js') }}"></script>
	@endpush
@endsection