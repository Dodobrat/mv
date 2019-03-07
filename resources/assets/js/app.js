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

if (document.body.contains(document.querySelector(".load"))){
    function preloader(){
        let load = document.querySelector(".load");
        window.addEventListener('load', function(){
            setTimeout(() => {
                $(load).slideUp(200);
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

document.onkeydown = function(e) {
    if(event.keyCode == 123) {
        $(".error-email-box").show();
        $('.errors').empty();
        $('.errors').html('&#9888;');
        setTimeout(function(){
            $(".error-email-box").slideUp(300);
        }, 3000);
        return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
        $(".error-email-box").show();
        $('.errors').empty();
        $('.errors').html('&#9888;');
        setTimeout(function(){
            $(".error-email-box").slideUp(300);
        }, 3000);
        return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
        $(".error-email-box").show();
        $('.errors').empty();
        $('.errors').html('&#9888;');
        setTimeout(function(){
            $(".error-email-box").slideUp(300);
        }, 3000);
        return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
        $(".error-email-box").show();
        $('.errors').empty();
        $('.errors').html('&#9888;');
        setTimeout(function(){
            $(".error-email-box").slideUp(300);
        }, 3000);
        return false;
    }
};

let $backToTop = $(".back-to-top");

$(window).on('scroll', function() {
    if ($(this).scrollTop() > 100) {
        $backToTop.addClass('show');
    } else {
        $backToTop.removeClass('show');
    }
});

$backToTop.on('click', function(e) {
    $("html, body").animate({scrollTop: 0}, 500);
});

// -----------------------------------------
//             HIDE NAV ON SCROLL
// -----------------------------------------

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
let footer = document.querySelector('.footer');
let topProjectsContainer = document.getElementById('top-projects');
$(".projects-heading").hide();
$('.empty').hide();
$(".aspin").hide();
$(projectsContainer).hide();
$(topProjectsContainer).hide();

cat.forEach(function (cat) {
    cat.addEventListener('click',function () {

        $(cat).addClass("active").siblings().removeClass('active');
        $(cat).removeClass("inactive").siblings().addClass('inactive');

        let catSlug = cat.dataset.slug;
        let catUrl = cat.dataset.url;
        // let catRoute = cat.dataset.route;

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
                $(".aspin").show();
            },

            success: function(result) {
                if (result.errors.length != 0) {
                    $(".aspin").hide();
                    $(".error-box").show();

                    $.each(result.errors, function (key, value) {
                        $('.error').html(result.errors);
                    });

                    setTimeout(function(){
                        $(".error-box").slideUp(300);
                    }, 3000);
                } else {
                    $(companyLogo).hide();
                    catCont.style.height = '12vh';
                    catCont.style.marginTop = '57px';
                    $('nav').removeClass('nav-up').addClass('nav-down');
                    $(footer).removeClass('hidden').addClass('visible');
                    subCatsContainer.style.display = 'flex';
                    topProjectsContainer.style.display = 'block';
                    if(projectsContainer.innerHTML == "" && $('.empty').show() == true){
                        $('.empty').show();
                        topProjectsContainer.style.marginTop = "0px";
                    }else{
                        $('.empty').hide();
                    }
                    $(".aspin").hide();
                    subCatsContainer.innerHTML = result.new_blade;
                    // window.history.pushState({},"", catRoute + '/' +catSlug);

                    let subCat = document.querySelectorAll('.sub-category-btn' );

                    $(projectsContainer).hide();

                    subCat.forEach(function (subCat) {
                        subCat.addEventListener('click',function () {

                            $(subCat).addClass("active").siblings().removeClass('active');

                            let subCatSlug = subCat.dataset.slug;
                            let subCatUrl = subCat.dataset.url;
                            // let subCatRoute = subCat.dataset.route;

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
                                    $(".aspin").show();
                                },

                                success: function(result) {
                                    if (result.errors.length != 0) {
                                        $(".aspin").hide();
                                        $(".error-box").show();

                                        $.each(result.errors, function (key, value) {
                                            $('.error').html(result.errors);
                                        });

                                        setTimeout(function(){
                                            $(".error-box").slideUp(300);
                                        }, 3000);
                                    } else {
                                        $(topProjectsContainer).slideDown(300);
                                        topProjectsContainer.style.marginTop = "100px";
                                        $(projectsContainer).show();
                                        $(".sub-categories-heading").slideUp(500);
                                        $(".projects-heading").slideUp(100);
                                        projectsContainer.innerHTML = result.new_view;
                                        $('.portfolio-grid > .portfolio-grid-item').hoverdir();
                                        if(projectsContainer.innerHTML == ""){
                                            $('.empty').show();
                                            topProjectsContainer.style.marginTop = "0px";
                                        }else{
                                            $('.empty').hide();
                                        }
                                        $(".aspin").hide();
                                        // window.history.pushState({},"", subCatRoute + '#'+ subCatSlug);
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
//             MODAL
// -----------------------------------------
let modal = document.querySelector('#my-modal');

$(document).keyup(function(e) {
    if (e.keyCode === 27){
        $(modal).slideUp(300);
        document.querySelector('body').style.overflowY = 'auto';
    }
    if (e.keyCode === 37){
        $('a.carousel-control-prev').trigger('click');
    }
    if (e.keyCode === 39){
        $('a.carousel-control-next').trigger('click');
    }

});

// ---------------------------------------------------
//         CONTENT - ADDED CUSTOM TOUCH SUPPORT FOR CAROUSEL
// ---------------------------------------------------
let pageWidth = window.innerWidth || document.body.clientWidth;
let treshold = Math.max(1,Math.floor(0.01 * (pageWidth)));
let touchstartX = 0;
let touchstartY = 0;
let touchendX = 0;
let touchendY = 0;

const limit = Math.tan(45 * 1.5 / 180 * Math.PI);
const gestureZone = document.getElementsByTagName('body');

gestureZone[0].addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);

gestureZone[0].addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
    handleGesture(event);
}, false);

function handleGesture(e) {
    let x = touchendX - touchstartX;
    let y = touchendY - touchstartY;
    let yx = Math.abs(y / x);
    if (Math.abs(x) > treshold || Math.abs(y) > treshold) {
        if (yx <= limit) {
            if (x < 0) {
                $(function(){
                    $('.carousel').carousel('next');
                });
            } else {
                $(function(){
                    $('.carousel').carousel('prev');
                });
            }
        }
    }
}



// -----------------------------------------
//             DIRECTIONAL HOVER
// -----------------------------------------

$(function () {
    $('.portfolio-grid > .portfolio-grid-item').hoverdir();
    $('.top-portfolio-grid > .portfolio-grid-item').hoverdir();
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
//             AJAX EMAIL
// -----------------------------------------
let contactForm = document.querySelector('.contact-email-form');
if (document.body.contains(contactForm)) {

// -----------------------------------------
//             AJAX EMAIL VALIDATION
// -----------------------------------------

let nameField = document.querySelector('.name');
let phoneField = document.querySelector('.phone');
let emailField = document.querySelector('.email');
let commentField = document.querySelector('.comment');
let submitBtn = document.querySelector('.submit-btn');

nameField.addEventListener('keyup',validateName);
phoneField.addEventListener('keyup',validatePhone);
emailField.addEventListener('keyup',validateEmail);
commentField.addEventListener('keyup',validateComment);

function validateName(){
    const re = /^[a-zA-Z\ \  ]{2,50}$/;

    if(!re.test(nameField.value)){
        nameField.style.borderBottom = '1px solid #BF5329';
        submitBtn.style.pointerEvents = 'none';
        submitBtn.style.opacity = '0.5';
    }else{
        nameField.style.borderBottom = '1px solid #2AB27B';
        submitBtn.style.pointerEvents = 'unset';
        submitBtn.style.opacity = 'unset';
    }
}
function validatePhone(){
    const re = /^[0-9\+\-\ ]{5,14}$/;

    if(!re.test(phoneField.value)){
        phoneField.style.borderBottom = '1px solid #BF5329';
        submitBtn.style.pointerEvents = 'none';
        submitBtn.style.opacity = '0.5';
    }else{
        phoneField.style.borderBottom = '1px solid #2AB27B';
        submitBtn.style.pointerEvents = 'unset';
        submitBtn.style.opacity = 'unset';
    }
}
function validateEmail(){
    const re = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{1,6})$/;

    if(!re.test(emailField.value)){
        emailField.style.borderBottom = '1px solid #BF5329';
        submitBtn.style.pointerEvents = 'none';
        submitBtn.style.opacity = '0.5';
    }else{
        emailField.style.borderBottom = '1px solid #2AB27B';
        submitBtn.style.pointerEvents = 'unset';
        submitBtn.style.opacity = 'unset';
    }
}
function validateComment(){
    const re = /^[a-zA-Z0-9_\-\.\!\?\'\"\,\/\(\)\%\=\+\*\:\;\@\ \  ]{1,300}$/;

    if(!re.test(commentField.value)){
        commentField.style.borderBottom = '1px solid #BF5329';
        submitBtn.style.pointerEvents = 'none';
        submitBtn.style.opacity = '0.5';
    }else{
        commentField.style.borderBottom = '1px solid #2AB27B';
        submitBtn.style.pointerEvents = 'unset';
        submitBtn.style.opacity = 'unset';
    }
}
    let url = contactForm.dataset.url;

    $(document).ready(function () {
        $('.submit-btn').on('click', function (e) {
            let self = $(this);
            e.preventDefault();
            $.ajaxSetup({
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    name: self.closest(contactForm).find('input[name="name"]').val(),
                    phone: self.closest(contactForm).find('input[name="phone"]').val(),
                    email: self.closest(contactForm).find('input[name="email"]').val(),
                    comment: self.closest(contactForm).find('textarea[name="comment"]').val(),
                    contact_id: self.closest(contactForm).find('input[name="contact_id"]').val(),

                },
                beforeSend: function() {
                    $('.submit-btn').addClass('loading');
                },

                success: function(result) {
                    if (result.errors) {
                        $('.submit-btn').removeClass('loading');
                        $(".error-email-box").show();
                        $('.errors').empty();
                        $.each(result.errors, function (key, value) {
                            $('.errors').append('<li>' + value + '</li>');
                        });
                        setTimeout(function(){
                            $(".error-email-box").slideUp(300);
                        }, 5000);
                    } else {
                        $('.submit-btn').removeClass('loading');
                        $(".success-box").show();
                        $.each(result, function (key, value) {
                            $('.success').html(result.success);
                        });
                        setTimeout(function(){
                            $(".success-box").slideUp(300);
                        }, 10000);
                        contactForm.classList.add('disabled');
                    }
                }});
        });
    });

}

// -----------------------------------------
//             COPY
// -----------------------------------------
let footPhone = document.querySelector('.footer-phone');
let footEmail = document.querySelector('.footer-email');
let contactAddress = document.querySelector('.contact-address');
let contactMail = document.querySelector('.contact-mail');
let contactPhone = document.querySelector('.contact-phone');

footPhone.onclick = function() {
    document.execCommand("copy");
};

footPhone.addEventListener("copy", function(event) {
    event.preventDefault();
    if (event.clipboardData) {
        event.clipboardData.setData("text/plain", footPhone.textContent);
        // console.log(event.clipboardData.getData("text"));
        $(".info-box").slideDown(200);
        $('.info').html(event.clipboardData.getData("text"));
        setTimeout(function(){
            $(".info-box").slideUp(300);
        }, 3000);
    }
});

footEmail.onclick = function() {
    document.execCommand("copy");
};

footEmail.addEventListener("copy", function(event) {
    event.preventDefault();
    if (event.clipboardData) {
        event.clipboardData.setData("text/plain", footEmail.textContent);
        // console.log(event.clipboardData.getData("text"));
        $(".info-box").slideDown(200);
        $('.info').html(event.clipboardData.getData("text"));
        setTimeout(function(){
            $(".info-box").slideUp(300);
        }, 3000);
    }
});

if (document.body.contains(contactAddress,contactMail,contactPhone)) {
    contactAddress.onclick = function() {
        document.execCommand("copy");
    };

    contactAddress.addEventListener("copy", function(event) {
        event.preventDefault();
        if (event.clipboardData) {
            event.clipboardData.setData("text/plain", contactAddress.textContent);
            // console.log(event.clipboardData.getData("text"));
            $(".info-box").slideDown(200);
            $('.info').html(event.clipboardData.getData("text"));
            setTimeout(function(){
                $(".info-box").slideUp(300);
            }, 3000);
        }
    });

    contactMail.onclick = function() {
        document.execCommand("copy");
    };

    contactMail.addEventListener("copy", function(event) {
        event.preventDefault();
        if (event.clipboardData) {
            event.clipboardData.setData("text/plain", contactMail.textContent);
            // console.log(event.clipboardData.getData("text"));
            $(".info-box").slideDown(200);
            $('.info').html(event.clipboardData.getData("text"));
            setTimeout(function(){
                $(".info-box").slideUp(300);
            }, 3000);
        }
    });

    contactPhone.onclick = function() {
        document.execCommand("copy");
    };

    contactPhone.addEventListener("copy", function(event) {
        event.preventDefault();
        if (event.clipboardData) {
            event.clipboardData.setData("text/plain", contactPhone.textContent);
            // console.log(event.clipboardData.getData("text"));
            $(".info-box").slideDown(200);
            $('.info').html(event.clipboardData.getData("text"));
            setTimeout(function(){
                $(".info-box").slideUp(300);
            }, 3000);
        }
    });
}


// -----------------------------------------
//             WORKFLOW PASS
// -----------------------------------------
if (document.body.contains(document.querySelector('.locked-page'))){
    document.querySelector('body').style.overflowY = 'hidden';
    let login = document.querySelector('.login');
    let loginBtn = document.querySelector('.login-btn');
    login.addEventListener('keyup',function () {
        const re = /^[a-zA-Z0-9\-\_\/\!\&]{30}$/;
        if(!re.test(login.value)){
            login.style.borderBottom = '1px solid #BF5329';
            loginBtn.style.pointerEvents = 'none';
            loginBtn.style.opacity = '0.5';
        }else{
            login.style.borderBottom = '1px solid #2AB27B';
            loginBtn.style.pointerEvents = 'unset';
            loginBtn.style.opacity = 'unset';
        }
    });
    document.querySelector('.login-btn').addEventListener('click', function(){
        let lockedPage = document.querySelector('.locked-page');
        let login = document.querySelector('.login');
        let pass = login.dataset.pass;
        let loginBtn = document.querySelector('.login-btn');

        if(login.value === pass){
            $(lockedPage).slideUp(300);
            document.querySelector('body').style.overflowY = 'auto';
            loginBtn.style.pointerEvents = 'unset';
            loginBtn.style.opacity = 'unset';
        } else {
            login.style.borderBottom = '1px solid #BF5329';
            $(lockedPage).show();
            loginBtn.style.pointerEvents = 'none';
            loginBtn.style.opacity = '0.5';
            return false;
        }
    });
}