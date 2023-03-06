@php $i = 0; @endphp
<nav class="header__nav nav">
	<ul class="nav__menu">
		@foreach ($menu as $menu1)
			@if (count($menu1->childs))
				<li class="nav__menu-item">
					<a class="nav__menu-link" href="{{ $menu1->href }}">{{ $menu1->title }}</a>
					<ul class="nav__submenu">
						@foreach ($menu1->childs as $menu2)
							<li class="nav__submenu-item">
								<a class="nav__menu-link" href="{{ $menu2->href }}">{{ $menu2->title }}</a>
							</li>
						@endforeach
					</ul>
				</li>
			@elseif ($menu1->parent_id == null || $menu1->parent_id == 0)
				<li class="nav__menu-item">
					<a class="nav__menu-link" href="{{ $menu1->href }}">{{ $menu1->title }}</a>
				</li>
			@endif
		@endforeach
	</ul>
</nav>