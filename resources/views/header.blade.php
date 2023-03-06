<header class="header" id="top">
	<div class="container">
		<div class="header__inner">
			<div class="top-line">
				<div class="top-line__logo logo">
					<a class="logo__link" href="{{ route('index') }}">
						<img class="logo__img" src="/images/logo/logo.svg" alt="">
					</a>
					<img class="logo__text" src="/images/logo/logo-text.svg" alt="">
				</div>
				<div class="top-line__herb-wrapper">
					<div class="top-line__herb">
						<img class="top-line__herb-img" src="/images/logo/herb.svg" alt="">
					</div>
				</div>
				<div class="top-line__contacts">
					@if($contacts->email)
						<a class="top-line__email" href="mailto:{{$contacts->email}}">{{$contacts->email}}</a>
					@endif
					<a class="top-line__phone" href="tel:{{$contacts->formatPhone($contacts->phone_1)}}">{{$contacts->phone_1}}</a>
				</div>
				<div class="top-line__eye">
					<img class="top-line__eye-img" src="/images/icons/eye.svg" alt="">
				</div>
                <form class="top-line__search" action="{{ route('search') }}" method="GET">
                    <input class="top-line__search-input" type="text" placeholder="поиск" name="search_query">
                    <div class="top-line__search-btn"></div>
                </form>
				<div class="top-line__burger"><img src="/images/icons/burger.svg" alt=""></div>
				<div class="burger__menu-wrapper">
					<div class="burger__closeBtn"><img class="closeBtn__img" src="/images/icons/cross.svg" alt=""></div>
					<div class="burger__content">
						<ul class="burger__menu"></ul>
						<div class="burger__features"></div>
					</div>
				</div>
			</div>

			@include('components.top_menu')

		</div>
	</div>
</header>
