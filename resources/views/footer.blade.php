<div class="loaderArea">
	<div class="loader"></div>
</div>
<script>
	$(window).on('load', function () {
		$preloader = $('.loaderArea'),
				$loader = $preloader.find('.loader');
		$loader.fadeOut();
		$preloader.delay(350).fadeOut('slow');
	});
</script>
<footer class="footer">
	<div class="footer__inner">
		<div class="footer__logo">
			<img class="footer__logo-text" src="/images/logo/logo-textWhite.svg" alt="">
		</div>

		@include('components.bottom_menu')

		<div class="footer__contacts">
			@if($contacts->email)
				<a class="footer__contact" href="mailto:{{$contacts->email}}">{{$contacts->email}}</a>
			@endif

			<a class="footer__contact" href="tel:{{ $contacts->formatPhone($contacts->phone_1) }}">{{ $contacts->phone_1_full }}
			</a>
			@if($contacts->phone_2)
				<a class="footer__contact" href="tel:{{ $contacts->formatPhone($contacts->phone_2) }}">{{$contacts->phone_2_full}}</a>
			@endif

			@if($contacts->address)
				<span class="footer__contact">{{$contacts->address}}</span>
			@endif
		</div>

		<div class="footer__feedback">
			<h3 class="footer__heading">Оставить заявку</h3>
			<span class="footer__desc">Если у вас возникли вопросы, оставьте заявку</span>
			<div class="footer__contactBtn btn">Связаться</div>
		</div>

		@if($socnets)
			<div class="footer__socials">
				@foreach($socnets as $socnet)
					<a class="footer__social-link" href="{{$socnet->link}}">
						<img class="footer__{{$socnet->type}} social-icon" src="/{{$socnet->image}}" alt="{{$socnet->name}}">
					</a>
				@endforeach
			</div>
		@endif

		<div class="footer__license">
			<span class="footer__copyright">©{{ \Carbon\Carbon::now()->format('Y') }} - Краевой центр единоборств | Все права защищены</span>
			<a class="footer__privacy" href="{{ route('simple.page', 'polzovatelskoe-soglasenie') }}">Политика конфиденциальности</a>
		</div>

		<div class="footer__webalt-wrapper">
			<a class="footer__webalt-link" href="https://web-alt.ru">
				<img class="footer__webalt-img" src="/images/logo/logowebalt.svg" alt="">
			</a>
		</div>
	</div>
</footer>

@include('forms.feedback-modal', ['page' => $page])