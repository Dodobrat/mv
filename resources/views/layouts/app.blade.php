<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
                <a class="nav-link" href="{{ route('members.index') }}">{{ trans('front.team') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">{{ trans('front.contact') }}</a>
            </li>
        </ul>
    </div>
</nav>


@yield('content')

<div id="my-modal" class="custom-modal">
    @include('index::front.boxes.project')
</div>

<script src="{{ mix('/js/app.js') }}"></script>

<script>
    // if (location.protocol !== "https:"){
    //     location.replace(window.location.href.replace("http:",
    //         "https:"));
    // }
    let modal = document.querySelector('#my-modal');
    let ajaxLoader = document.querySelector('.loader-container');

    function closeModal() {
        $(modal).slideUp(300);
        window.history.pushState({}, "", '/');
        document.querySelector('body').style.overflowY = 'auto';
    }

    function openModal(id, url, slug) {
        let projectId = id;
        let projectUrl = url;
        let projectSlug = slug;

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
                ajaxLoader.style.display = 'flex';
            },

            success: function (result) {
                if (result.errors.length != 0) {
                    $('.alert-danger').html('');

                    $.each(result.errors, function (key, value) {

                    });
                } else {
                    ajaxLoader.style.display = 'none';
                    window.history.pushState({}, "", '?' + projectSlug);
                    $(modal).slideDown(300);
                    modal.innerHTML = result.project_modal;
                    document.querySelector('body').style.overflowY = 'hidden';
                }
            }
        });
    }
</script>

<script>

    $(window).scroll(fetchPosts);

    function fetchPosts() {
        let page = $('.endless-pagination').data('next-page');

        clearTimeout($.data(this, "scrollCheck"));
        $.data(this, "scrollCheck", setTimeout(function () {
            let scroll_position_for_projects_load = $(window).height() + $(window).scrollTop() + 100;
            let route = $('.endless-pagination').data('route');
            if (scroll_position_for_projects_load >= $(document).height()) {
                $.ajaxSetup({
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: route,
                    method: 'post',
                    data: {
                        count : page
                        // project_id: projectId,
                    },
                    beforeSend: function () {
                        // $('.projects-loader-container').style.display = 'flex';
                    },

                    success: function (result) {
                        // console.log(result.next_page);
                        $('.portfolio-grid').append(result.projects);
                        $('.endless-pagination').data('next-page', result.next_page);
                        $('.portfolio-grid > .portfolio-grid-item').hoverdir();
                        $('.projects-loader-container').hide();

                    }
                });
            }
        }, 100));
    }

</script>


</body>
</html>