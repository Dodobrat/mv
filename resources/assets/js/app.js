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
//             PROJECT MODAL
// -----------------------------------------

const modal = document.querySelector('#my-modal');
const modalBtn = document.querySelector('#modal-btn');
const closeBtn = document.querySelector('.close');

modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', outsideClick);

function openModal() {
    $(modal).show(200);
}

function closeModal() {
    $(modal).hide(200);
}

function outsideClick(e) {
    if (e.target == modal) {
        $(modal).hide(200);
    }
}