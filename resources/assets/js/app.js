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
//             INITS
// -----------------------------------------

AOS.init({
    duration: 400
});

$(function () {
    $('.portfolio-grid > .portfolio-grid-item').hoverdir();
});

$(document).ready(function(){
    $(".filter-button").click(function(){
        let value = $(this).attr('data-filter');
        if(value == "all") {
            $('.filter').show(200);
        }
        else {
            $(".filter").not('.'+value).hide(200);
            $('.filter').filter('.'+value).show(200);
        }
        if ($(".filter-button").removeClass("active")) {
            $(this).removeClass("active");
        }
        $(this).addClass("active");
    });
});


// -----------------------------------------
//             NAVBAR
// -----------------------------------------

$(document).ready(function(){
    $(".hamburger").click(function(){
        $(this).toggleClass("is-active");
    });
});