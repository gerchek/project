<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="icon" href="favicon.ico">
	<link rel="icon" href="/images/favicon.svg" type="image/svg+xml">
	<link rel="apple-touch-icon" href="/images/favicon.png">

	@yield('head')
	@stack('styles')

{{--	<script defer="defer" src="https://www.google.com/recaptcha/api.js?render={{env('RECAPTCHA_KEY')}}"></script>--}}
</head>

<body class="{{$specialClasses}}">
	@include('components.display-settings')

	<div class="circle"></div>

	<div class="arrow-top arrow">
		<div class="arrow__circle_not_animated arrow__circle"></div>
		<img class="arrow-top__img" src="/images/icons/arrow.svg" alt="">
	</div>

	@yield('content')

	@stack('scripts')
</body>
</html>
