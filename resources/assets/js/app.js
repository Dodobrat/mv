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
//             AJAX CATEGORIES
// -----------------------------------------
let catCont = document.querySelector('.main-categories-section' );
let cat = document.querySelectorAll('.main-category-btn' );
let subCatsContainer = document.getElementById('subCatSection');
let projectsContainer = document.getElementById('portfolio');
$(".loading-container").hide();
$(subCatsContainer).hide();
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
                    $(subCatsContainer).show();
                    window.history.pushState({},"", catRoute + '/' +catSlug);
                    $(".loading-container").hide();
                    subCatsContainer.innerHTML = result.new_blade;
                    catCont.style.height = '25vh';

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
                                        window.history.pushState({},"", subCatRoute + '#'+ subCatSlug);
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

