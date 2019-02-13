<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mirage Visualisation') }}</title>
    {{--<link rel="icon" href="{{ asset('img/img_2.jpg') }}">--}}
    <link rel="stylesheet" href="{{ mix('/css/aos.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

</head>
<body>

<div class="preloader" id="preloader">
    <div class="preloader-chasing-squares">
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
    </div>
</div>


@if (Route::currentRouteName() == 'index')

    <div class="landing-image-container">
        <img src="
        @if(!empty(Settings::getFile('index_landing_image')))
        {{ Settings::getFile('index_landing_image') }}
        @else
        {{ asset('#') }}
        @endif" alt="" class="landing-image rellax" data-rellax-speed="-5">
    </div>

@endif

<nav class="navbar sticky-top navbar-expand-lg navigation">
    <a class="navbar-brand" href="{{ route('index') }}">
        {{ config('app.name', 'Mirage Visualisation') }}
    </a>

    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#mobileMenu"
            aria-controls="mobileMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">
        <div class="hamburger" id="hamburger-1">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </button>

    <div class="collapse navbar-collapse" id="mobileMenu">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">{{ trans('front.home') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">{{ trans('front.team') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">{{ trans('front.contact') }}</a>
            </li>
        </ul>
    </div>
</nav>

    @yield('content')

    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>