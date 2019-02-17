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
//             PROJECT FILTER
// -----------------------------------------

$(document).ready(function(){
    window.addEventListener('load',function () {
        let initValue = document.querySelector('.filter-button').dataset.filter;

        $(".filter").not('.'+ initValue).hide(200);
        $('.filter').filter('.'+ initValue).show(200);
    });
    $(".filter-button").click(function(){
        let value = $(this).attr('data-filter');
        if(value == "all") {
            $('.filter').show(200);
        }
        else {
            $(".filter").not('.'+ value).hide(200);
            $('.filter').filter('.'+ value).show(200);
        }
        if ($(".filter-button").removeClass("active")) {
            $(this).removeClass("active");
        }
        $(this).addClass("active");
    });
});

// -----------------------------------------
//             PROJECT MODAL
// -----------------------------------------

