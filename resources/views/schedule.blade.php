@extends('layouts.main')

@section('head')
	<title>КЦЕ | Расписание</title>
@endsection

@push('styles')
	<link href="{{ asset('css/schedule.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Расписание</h1>
							<div class="banner__title-img head__img" id="schedule"></div>
						</div>
						<p class="banner__desc">В здании краевого центра единоборств площадью около 5000 квадратных метров
							размещены универсальный спортивный зал с трибунами на 1200 зрителей, помещения для различных
							видов единоборств, спортивные залы с раздевалками и душевыми.</p>
					</div>
				</div>
			</section>

			<div class="schedules">
				<div class="container">
					<div class="schedules__inner">
						@if(!empty($schedules))
							@foreach($schedules as $schedule)
								@if($schedule->type == 'pdf')
									<a class="schedules__item" href="{{ $schedule->file }}">
										{{--<img class="schedules__img" src="" alt="{{ $schedule->name }}">--}}
										<div class="schedules__tag">{{ $schedule->tag }}</div>
										<img class="schedules__btn" src="/images/icons/plus.svg">
									</a>
								@else
									<a class="schedules__item" href="{{ $schedule->file }}" data-fancybox="gallery">
										<img class="schedules__img" src="{{ $schedule->file }}" alt="{{ $schedule->name }}">
										<div class="schedules__tag">{{ $schedule->tag }}</div>
										<img class="schedules__btn" src="/images/icons/plus.svg">
									</a>
								@endif
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</main>

		@include('footer', ['page' => 'Расписание'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/schedule.js') }}"></script>
	@endpush
@endsection