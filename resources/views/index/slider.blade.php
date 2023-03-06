<section class="banner">
	<div class="container">
		<div class="banner__inner">
			<div class="banner__info-slides" data-delay="{{$mainPageSettings->slider_info_delay}}">
				@foreach($slider as $sliderItem)
					<div class="banner__info">
						<h1 class="banner__title">{{ $sliderItem->name }}</h1>
						<div class="banner__details">
							<p class="banner__desc">{{ $sliderItem->text }}</p>
							@if(!empty($sliderItem->btn_url))
								<a href="{{ $sliderItem->btn_url }}">
									<div class="banner__more btn">Подробнее</div>
								</a>
							@endif
						</div>
					</div>
				@endforeach
				<span class="banner__arrows"></span>
			</div>
			<div class="banner__images" data-delay="{{$mainPageSettings->slider_images_delay}}">
				@foreach($slider as $sliderItem)
					<img class="banner__img" src="{{ $sliderItem->image }}" alt="{{ $sliderItem->name }}">
				@endforeach
			</div>
		</div>
	</div>
</section>
