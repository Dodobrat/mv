// -----------------------------------------
//             IMPORTING JS
// -----------------------------------------
require('../../assets/js/hover.js');
window.Popper = require('popper.js');
require('bootstrap/dist/js/bootstrap.js');
global.$ = global.jQuery = require('jquery');
global.AOS = require('aos');
global.Rellax = require('rellax/rellax.js');

// -----------------------------------------
//             PRELOADER
// -----------------------------------------

// if (location.protocol !== "https:"){
//     location.replace(window.location.href.replace("http:",
//         "https:"));
// }

if (document.body.contains(document.getElementById("preloader"))){
    function preloader(){
        let preloader = document.getElementById("preloader");
        window.addEventListener('load', function(){
            setTimeout(() => {
                preloader.style.opacity = '0';
            }, 1);
        });
    }
    preloader();
}

// -----------------------------------------
//             INITS
// -----------------------------------------

AOS.init({
    duration: 400
});

// -----------------------------------------
//             HIDE NAV ON SCROLL
// -----------------------------------------

// Hide Header on on scroll down
let didScroll;
let lastScrollTop = 0;
let delta = 5;
let navbarHeight = $('nav').outerHeight();

$(window).scroll(function(event) {
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    let st = $(this).scrollTop();
    if (Math.abs(lastScrollTop - st) <= delta)
        return;
    if (st > lastScrollTop && st > navbarHeight) {
        // Scroll Down
        $('nav').addClass('nav-up').removeClass('nav-down');
    } else {
        // Scroll Up
        if (st + $(window).height() < $(document).height()) {
            $('nav').removeClass('nav-up').addClass('nav-down');
        }
    }

    lastScrollTop = st;
}

// -----------------------------------------
//             AJAX CATEGORIES
// -----------------------------------------
let companyLogo = document.querySelector('.company-logo');
let catCont = document.querySelector('.main-categories-section' );
let cat = document.querySelectorAll('.main-category-btn' );
let subCatsContainer = document.getElementById('subCatSection');
let projectsContainer = document.getElementById('portfolio');
$(".projects-heading").hide();
$(".loading-container").hide();
$(projectsContainer).hide();

cat.forEach(function (cat) {
    cat.addEventListener('click',function () {

        $(cat).addClass("active").siblings().removeClass('active');

        let catSlug = cat.dataset.slug;
        let catUrl = cat.dataset.url;
        let catRoute = cat.dataset.route;

        $.ajaxSetup({
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: catUrl,
            method: 'post',
            data: {
                category_slug: catSlug,
            },
            beforeSend: function() {
                $(".loading-container").show();
            },

            success: function(result) {
                if (result.errors.length != 0) {
                    // $('.alert-danger').html('');
                    //
                    // $.each(result.errors, function (key, value) {
                    //
                    // });
                } else {
                    $(companyLogo).hide();
                    $(".projects-heading").show();
                    catCont.style.height = '21vh';
                    $('nav').removeClass('nav-up').addClass('nav-down');
                    catCont.style.marginTop = '56px';
                    subCatsContainer.style.display = 'flex';
                    // window.history.pushState({},"", catRoute + '/' +catSlug);
                    $(".loading-container").hide();
                    subCatsContainer.innerHTML = result.new_blade;

                    let subCat = document.querySelectorAll('.sub-category-btn' );

                    $(projectsContainer).hide();

                    subCat.forEach(function (subCat) {
                        subCat.addEventListener('click',function () {

                            $(subCat).addClass("active").siblings().removeClass('active');

                            let subCatSlug = subCat.dataset.slug;
                            let subCatUrl = subCat.dataset.url;
                            let subCatRoute = subCat.dataset.route;

                            $.ajaxSetup({
                                cache: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: subCatUrl,
                                method: 'post',
                                data: {
                                    sub_category_slug: subCatSlug,
                                },
                                beforeSend: function() {
                                    $(".loading-container").show();
                                },

                                success: function(result) {
                                    if (result.errors.length != 0) {
                                        // $('.alert-danger').html('');
                                        //
                                        // $.each(result.errors, function (key, value) {
                                        //
                                        // });
                                    } else {
                                        $(projectsContainer).show();
                                        // window.history.pushState({},"", subCatRoute + '#'+ subCatSlug);
                                        $(".sub-categories-heading").slideUp(300);
                                        $(".projects-heading").slideUp(100);
                                        $(".loading-container").hide();
                                        projectsContainer.innerHTML = result.new_view;
                                        $('.portfolio-grid > .portfolio-grid-item').hoverdir();


                                    }
                                }
                            });
                        });
                    });
                }
            }
        });
    });
});

// -----------------------------------------
//             MODAL HORIZONTAL DRAG
// -----------------------------------------



// -----------------------------------------
//             DIRECTIONAL HOVER
// -----------------------------------------

$(function () {
    $('.member-card-container > .member-card').hoverdir();
    $('.portfolio-grid > .portfolio-grid-item').hoverdir();
});

// -----------------------------------------
//             PARALLAX EFFECT
// -----------------------------------------

if(document.body.contains(document.querySelector('.rellax'))){
    let rellax = new Rellax('.rellax');
}

// -----------------------------------------
//             NAVBAR
// -----------------------------------------

$(document).ready(function(){
    $(".hamburger").click(function(){
        $(this).toggleClass("is-active");
    });
});

// -----------------------------------------
//             PROJECT MODAL
// -----------------------------------------

