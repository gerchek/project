@extends('layouts.main')

@section('head')
	<title>КЦЕ | Документы</title>
@endsection

@push('styles')
	<link href="{{ asset('css/docs.css') }}" rel="stylesheet">
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
							<h1 class="banner__title-text">Документы</h1>
							<div class="banner__title-img head__img" id="docs"></div>
						</div>
					</div>
				</div>
			</section>

			<section class="docs">
				<div class="container">
					<div class="docs__inner">
						@if(!empty($groupedDocs))
							@foreach($groupedDocs as $docsGroupName => $docsGroup)
								@php $docsGroup = $docsGroup->collapse() @endphp
								<div class="docs__accordion">
									<h2 class="docs__title accordion-header">{{ $docsGroupName }}</h2>
									<div class="docs__items">
										@foreach($docsGroup as $document)
											<a class="docs__item {{$document->type}}" href="{{ $document->file }}" {{ $document->download }}>
												{{ $document->name }}
												<div class="docs__arrow"></div>
											</a>
										@endforeach
									</div>
								</div>
							@endforeach
						@endif
					</div>
				</div>
			</section>
		</main>

		@include('footer', ['page' => 'Документы'])
	</div>

	@push('scripts')
		<script src="{{ asset('js/docs.js') }}"></script>
	@endpush
@endsection