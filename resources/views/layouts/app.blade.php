<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mirage Visualisation') }}</title>
    <link rel="icon" href="{{ asset('img/dark-logo.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900&amp;subset=latin-ext" rel="stylesheet">
    <link href="{{ asset('/font/fontawesome-free-5.7.2-web/css/all.css') }}" rel="stylesheet">
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

<nav class="navbar navbar-expand-lg navigation @if(Route::currentRouteName() == 'index') nav-up @endif">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="
            @if(!empty(Settings::getFile('index_nav_logo')))
                {{ Settings::getFile('index_nav_logo') }}
            @else
                {{ asset('img/dark-logo.png') }}
            @endif" alt="" class="navbar-image">
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
                    <a class="nav-link" href="{{ route('members.index') }}">{{ trans('front.team') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contacts.index') }}">{{ trans('front.contact') }}</a>
                </li>
            </ul>
            <div class="language-switcher">
                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="lang-link">EN</a> /
                <a href="{{ LaravelLocalization::getLocalizedURL('fr') }}" class="lang-link">FR</a>
            </div>
        </div>
    </div>
</nav>

@if (Route::currentRouteName() == 'index')
    <div class="company-logo">
        <img src="
        @if(!empty(Settings::getFile('index_company_logo')))
            {{ Settings::getFile('index_company_logo') }}
        @else
            {{ asset('img/logo.png') }}
        @endif" alt="" class="company-image">
        <p class="company-name">
            {{ config('app.name', 'Mirage Visualisation') }}
        </p>
    </div>
@endif

@yield('content')

<footer class="footer @if(Route::currentRouteName() == 'index') hidden @endif">
    <div class="row justify-content-center align-items-center">
        @if( !empty(Settings::get('contacts_phone')) || !empty(Settings::get('contacts_email')) )
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                <span class="footer-label">{{ trans('index::front.phone') }} : </span>
                <span class="footer-phone" title="{{ trans('index::front.copy') }}">
                    {{ Settings::get('contacts_phone') }}
                </span>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                <span class="footer-label">{{ trans('index::front.email') }} : </span>
                <span class="footer-email" title="{{ trans('index::front.copy') }}">
                    {{ Settings::get('contacts_email') }}
                </span>
            </div>
        @endif
        <div class="col-lg-4 col-md-12 col-sm-12 col-12 py-2">
            @if(Settings::get(LaravelLocalization::getCurrentLocale().'.instagram_link'))
                <a title="Instagram" class="footer-social instagram" href="{{ Settings::get(LaravelLocalization::getCurrentLocale().'.instagram_link') }}">
                    <i class="fab fa-instagram" id="ig"></i>
                </a>
            @endif
            @if(Settings::get(LaravelLocalization::getCurrentLocale().'.facebook_link'))
                <a title="Facebook" class="footer-social facebook" href="{{ Settings::get(LaravelLocalization::getCurrentLocale().'.facebook_link') }}">
                    <i class="fab fa-facebook-square" id="fb"></i>
                </a>
            @endif
            @if(Settings::get(LaravelLocalization::getCurrentLocale().'.linkedin_link'))
                <a title="LinkedIn" class="footer-social linkedin" href="{{ Settings::get(LaravelLocalization::getCurrentLocale().'.linkedin_link') }}">
                    <i class="fab fa-linkedin" id="in"></i>
                </a>
            @endif
        </div>
        <div class="col-12">
            <p class="copyright">&copy; {{ config('app.name', 'Mirage Visualisation') }} | @php echo date("Y"); @endphp</p>
        </div>
    </div>
</footer>

<div id="my-modal" class="custom-modal">
    @include('index::front.boxes.project')
</div>

<div id="member-modal" class="member-modal">
    @include('members::front.boxes.member')
</div>

<div class="error-box">
    <span class="warn">&#9888;</span>
    <span class="error"></span>
</div>

<div class="success-box">
    <span class="success"></span>
</div>

<div class="info-box">
    <span class="info"></span> <span>{{ trans('index::front.copied') }}</span>
</div>

<script src="{{ mix('/js/app.js') }}"></script>

@yield('project')

@yield('member')

</body>
</html>