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

<div id="my-modal" class="custom-modal">
    @include('index::front.boxes.project')
</div>

<div class="error-box">
    <span class="warn">&#9888;</span>
    <span class="error"></span>
</div>

<script src="{{ mix('/js/app.js') }}"></script>

<script>
    let modal = document.querySelector('#my-modal');
    function closeModal() {
        $(modal).slideUp(300);
        // window.history.pushState({}, "", '/');
        document.querySelector('body').style.overflowY = 'auto';
    }
    function openModal(id, url, slug) {
        let projectId = id;
        let projectUrl = url;
        // let projectSlug = slug;
        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: projectUrl,
            method: 'post',
            data: {
                project_id: projectId,
            },
            beforeSend: function () {
                $(".loading-container").show();
            },

            success: function (result) {
                if (result.errors.length != 0) {
                    $(".loading-container").hide();
                    $(".error-box").show();

                    $.each(result.errors, function (key, value) {
                        $('.error').html(result.errors);
                    });

                    setTimeout(function(){
                        $(".error-box").slideUp(300);
                    }, 3000);
                } else {
                    $(".loading-container").hide();
                    // window.history.pushState({}, "", '/' + projectSlug);
                    $(modal).slideDown(500);
                    document.querySelector('body').style.overflowY = 'hidden';
                    modal.innerHTML = result.project_modal;
                }
            }
        });
    }
</script>

</body>
</html>