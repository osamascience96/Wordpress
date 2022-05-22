/**
 * Custom JS - Custom js for klinikal theme
 * @version v3.0
 * @copyright 2020 Pepdev.
 */
 $(document).ready(function () {
    "use strict";
    //Color Picker
    
    //*************************************************
    //On DOM Load  ************************************
    //*************************************************
    $(window).on('load',function () {
        $('.slider-wrapper').flexslider({
            animation: "fade",
            animationLoop: true,
            pauseOnHover: true,
            keyboard: true,
            controlNav: false
        });
        //$('.slider-height').removeClass();
    });

    $('.theme-flexslider').flexslider({
        animation: "slide",
        animationLoop: true,
        pauseOnHover: true
    });


    $(".theme-owlslider").owlCarousel({
        items: 1,
        dots: true
    });

    function inputBox(ele) {
        var ele_parent = ele.parent('.input-box');
        if ($.trim(ele.val()).length > 0) {
            ele_parent.addClass('has-content');
        } else {
            ele_parent.removeClass('has-content');
        }
    }

    $(document).on('blur', '.input-box input, .input-box select, .input-box textarea', function () {
        inputBox($(this));
    });

    $(document).on('change', '.input-box select', function () {
        inputBox($(this));
    });

    $(".input-box input, .input-box select, .input-box textarea").each(function() {
        inputBox($(this));
    });
        
    //*************************************************
    //Tooltip  ****************************************
    //*************************************************
    $('[data-toggle="tooltip"]').tooltip();

    //*************************************************
    //Menu  *******************************************
    //*************************************************
    
    $('.fixed-on-scroll').scrollToFixed();

    $('.fixed-on-scroll-colored-background').scrollToFixed({
        preFixed: function () {
            $('.fixed-on-scroll-colored-background').addClass('hdr-colored-background');
        },
        postFixed: function () {
            $('.fixed-on-scroll-colored-background').removeClass('hdr-colored-background');
        }
    });


    $('#menu-bar').click(function () {
        $('body').css('overflow', 'hidden');
        $('.menu').css('left', '0');
        $('.menu').show();
    });

    $('.mobile-menu-close').click(function () {
        $('body').css('overflow', 'visible');
        $('.menu').css('left', '-100%');
        $('.menu').hide();
    });

    $(window).resize(function () {
        if ($(window).width() > 800) {
            $('body').css('overflow', 'visible');
            //$('.menu').css('left', '-100%');
            //$('.menu').hide();
        }
    });

    $('.user-wrapper').on('click', '.user-menu-icon', function () {
        var ele = $(this).find('i');
        if ($('.user-menu').css('display') === "none") {
            $('.user-menu').slideDown();
            ele.removeClass('fas fa-ellipsis-v');
            ele.addClass('far fa-times-circle');
        } else {
            $('.user-menu').slideUp();
            ele.removeClass('far fa-times-circle');
            ele.addClass('fas fa-ellipsis-v');
        }
    });

    //*************************************************
    //Accordion ***************************************
    //*************************************************
    $('.theme-accordion:nth-child(1) .theme-accordion-bdy').slideDown();
    $('.theme-accordion:nth-child(1) .theme-accordion-control .fa').addClass('fa-minus');
    $('.theme-accordion-hdr').click(function() {
        $('.theme-accordion-bdy').slideUp();
        $('.theme-accordion-control .fa').removeClass('fa-minus');
        if ($(this).parents('.theme-accordion').find('.theme-accordion-bdy').css('display') == "none") {
            $(this).find('.theme-accordion-control .fa').addClass('fa-minus');
            $(this).parents('.theme-accordion').find('.theme-accordion-bdy').slideDown();
        } else {
            $(this).find('.theme-accordion-control .fa').removeClass('fa-minus');
            $(this).parents('.theme-accordion').find('.theme-accordion-bdy').slideUp();
        }
    });

    //*************************************************
    //Home Page ***************************************
    //************************************************* 

    //Home Doctor Slider
    $("#hm-doctor-slider").owlCarousel({
        center: true,
        autoplay: true,
        items: 3,
        margin: 10,
        loop: true,
        smartSpeed: 1000,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false
            },
            992: {
                items: 3,
                nav: false
            }
        }
    });

    //Testimonial Slider
    $("#testimonial-slider").owlCarousel({
        items: 1,
        dots: true
    });

    //Animation on scroll
    $('.animated-wrapper').css('opacity', 0).waypoint(function (direction) {
        $(this.element).find('.animated-up').addClass('fadeInUp');
        $(this.element).find('.animated-right').addClass('fadeInRight');
        $(this.element).find('.animated-down').addClass('fadeInDown');
        $(this.element).animate({
            opacity: 1
        });
    }, {
        offset: '50%'
    });
    
    //Services Search
    $('input#search-services').keyup(function () {
        var filter = $('#search-services').val().toUpperCase();
        $('.theme-block .theme-block-data').each(function (index) {
            var ele = $(this), a = ele.find('h4 a').text().trim().toUpperCase();
            if (a.indexOf(filter) > -1) {
                ele.parents('.theme-block').parent('div').show();
            } else {
                ele.parents('.theme-block').parent('div').hide();
            }
        });
    });

    //Doctor Search
    $('input#search-doctors').keyup(function () {
        var filter = $('#search-doctors').val().toUpperCase();
        $('.theme-block .doctor-name').each(function (index) {
            var ele = $(this), a = ele.find('h4 a').text().trim().toUpperCase();
            if (a.indexOf(filter) > -1) {
                ele.parents('.theme-block').parent('div').show();
            } else {
                ele.parents('.theme-block').parent('div').hide();
            }
        });
    });

    //blog-1 Search 
    $('input#search-blog').keyup(function () {
        var filter = $('#search-blog').val().toUpperCase();
        $('.hm-blog-block .hm-blog-ttl').each(function (index) {
            var a = $(this).find('h4 a').text().trim().toUpperCase();
            if (a.indexOf(filter) > -1) {
                $(this).parents('.hm-blog-block').parent('div').show();
            } else {
                $(this).parents('.hm-blog-block').parent('div').hide();
            }
        });
    });

    //blog-2 Search
    $('input#search-blog').keyup(function () {
        var filter = $('#search-blog').val().toUpperCase();
        $('.theme-block .blog-card-ttl').each(function (index) {
            var ele = $(this), a = ele.find('h3 a').text().trim().toUpperCase();
            if (a.indexOf(filter) > -1) {
                ele.parents('.theme-block').parent('div').show();
            } else {
                ele.parents('.theme-block').parent('div').hide();
            }
        });
    });


    //*************************************************
    //My Profile Page popup ***************************
    //*************************************************
    $('.dob').datepicker({
        dateFormat: $('.common_date_format').val(),
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0"
    });

    //*************************************************
    //Blog Page  **************************************
    //*************************************************

    //Blog Read More Tag
    $(".blog-list-post p span").text(function (index, currentText) {
        return currentText.substr(0, 300);
    });

    //*************************************************
    //Service List Page  ******************************
    //*************************************************

    //Service Read More Tag
    $(".service-description span, .service-description span").text(function (index, currentText) {
        return currentText.substr(0, 330);
    });

    //*************************************************
    //Input Form Validation ***************************
    //************************************************* 
    //Contact Form Validation
    $('#contact-submit').click(function () {
        var clck_invld = 0,
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        mob_filter = /^[0-9]*$/;
        if ($('#contact-subject').val().trim().length < 3) {
            $('#contact-subject').parent('.contact-input').addClass('is-invalid');
            $('#contact-subject').parent('.contact-input').addClass('is-dirty');
            clck_invld = 1;
            $('#contact-subject').focus();
        }
        if ($('#contact-mobile').val().trim().length < 4) {
            $('#contact-mobile').parent('.contact-input').addClass('is-invalid');
            $('#contact-mobile').parent('.contact-input').addClass('is-dirty');
            clck_invld = 1;
            $('#contact-mobile').focus();
        }
        if (!mail_filter.test($('#contact-email').val())) {
            $('#contact-email').parent('.contact-input').addClass('is-invalid');
            $('#contact-email').parent('.contact-input').addClass('is-dirty');
            clck_invld = 1;
            $('#contact-email').focus();
        }
        if ($('#contact-name').val().trim().length < 3) {
            $('#contact-name').parent('.contact-input').addClass('is-invalid');
            $('#contact-name').parent('.contact-input').addClass('is-dirty');
            clck_invld = 1;
            $('#contact-name').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });

    //Login Form Validation
    $('#login-submit').click(function () {
        var clck_invld = 0,
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        bot_number, bot_number_array, total;
        if ($('#login-bot').val().trim().length < 1) {
            $('#login-bot').parent('.form-input').addClass('is-invalid');
            $('#login-bot').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#login-bot').focus();
        } else if ($('#login-bot').val().trim().length > 0) {
            bot_number = $('#login-bot+label').text();
            bot_number_array = bot_number.match(/[\d\.]+/g);
            total = 0;
            if (bot_number_array.length > 0) {
                $.each(bot_number_array, function (key, element) {
                    total += +element;
                });
                if ($('#login-bot').val().trim() !== total.toString()) {
                    $('#login-bot').parent('.form-input').addClass('is-invalid');
                    $('#login-bot').parent('.form-input').addClass('is-dirty');
                    clck_invld = 1;
                    $('#login-bot').focus();
                }
            } else {
                $('#login-bot').parent('.form-input').addClass('is-invalid');
                $('#login-bot').parent('.form-input').addClass('is-dirty');
                clck_invld = 1;
                $('#login-bot').focus();
            }
        }

        if ($('#login-password').val().trim().length < 4) {
            $('#login-password').parent('.form-input').addClass('is-invalid');
            $('#login-password').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#login-password').focus();
        }
        if (!mail_filter.test($('#login-email').val())) {
            $('#login-email').parent('.form-input').addClass('is-invalid');
            $('#login-email').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#login-email').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });

    //Register Form Validation
    $('#register-submit').click(function () {
        var clck_invld = 0,
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        mob_filter = /^[0-9]*$/,
        bot_number, bot_number_array, total;
        if ($('#register-bot').val().trim().length < 1) {
            $('#register-bot').parent('.form-input').addClass('is-invalid');
            $('#register-bot').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-bot').focus();
        } else if ($('#register-bot').val().trim().length > 0) {
            bot_number = $('#register-bot+label').text();
            bot_number_array = bot_number.match(/[\d\.]+/g);
            total = 0;
            if (bot_number_array.length > 0) {
                $.each(bot_number_array, function (key, element) {
                    total += +element;
                });
                if ($('#register-bot').val().trim() !== total.toString()) {
                    $('#register-bot').parent('.form-input').addClass('is-invalid');
                    $('#register-bot').parent('.form-input').addClass('is-dirty');
                    clck_invld = 1;
                    $('#register-bot').focus();
                }
            } else {
                $('#register-bot').parent('.form-input').addClass('is-invalid');
                $('#register-bot').parent('.form-input').addClass('is-dirty');
                clck_invld = 1;
                $('#register-bot').focus();
            }
        }

        if (!($('#register-confirm-password').val().trim() == $('#register-password').val().trim())) {
            $('#register-confirm-password').parent('.form-input').addClass('is-invalid');
            $('#register-confirm-password').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-confirm-password').focus();
        }
        if ($('#register-confirm-password').val().trim().length < 6) {
            $('#register-confirm-password').parent('.form-input').addClass('is-invalid');
            $('#register-confirm-password').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-confirm-password').focus();
        }
        if ($('#register-password').val().trim().length < 6) {
            $('#register-password').parent('.form-input').addClass('is-invalid');
            $('#register-password').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-password').focus();
        }
        if (!mob_filter.test($('#register-mobile').val())) {
            $('#register-mobile').parent('.form-input').addClass('is-invalid');
            $('#register-mobile').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-mobile').focus();
        }
        if ($('#register-mobile').val().trim().length < 4) {
            $('#register-mobile').parent('.form-input').addClass('is-invalid');
            $('#register-mobile').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-mobile').focus();
        }
        if (!mail_filter.test($('#register-email').val())) {
            $('#register-email').parent('.form-input').addClass('is-invalid');
            $('#register-email').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-email').focus();
        }
        if ($('#register-last-name').val().trim().length < 2) {
            $('#register-last-name').parent('.form-input').addClass('is-invalid');
            $('#register-last-name').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-last-name').focus();
        }
        if ($('#register-first-name').val().trim().length < 2) {
            $('#register-first-name').parent('.form-input').addClass('is-invalid');
            $('#register-first-name').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-first-name').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });

    //Forgot Password Form Validation
    $('#forgot-submit').click(function () {
        var clck_invld = 0,
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/,
        bot_number, bot_number_array, total;
        if ($('#forgot-bot').val().trim().length < 1) {
            $('#forgot-bot').parent('.form-input').addClass('is-invalid');
            $('#forgot-bot').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#forgot-bot').focus();
        } else if ($('#forgot-bot').val().trim().length > 0) {
            bot_number = $('#forgot-bot+label').text();
            bot_number_array = bot_number.match(/[\d\.]+/g);
            total = 0;
            if (bot_number_array.length > 0) {
                $.each(bot_number_array, function (key, element) {
                    total += +element;
                });
                if ($('#forgot-bot').val().trim() !== total.toString()) {
                    $('#forgot-bot').parent('.form-input').addClass('is-invalid');
                    $('#forgot-bot').parent('.form-input').addClass('is-dirty');
                    clck_invld = 1;
                    $('#forgot-bot').focus();
                }
            } else {
                $('#forgot-bot').parent('.form-input').addClass('is-invalid');
                $('#forgot-bot').parent('.form-input').addClass('is-dirty');
                clck_invld = 1;
                $('#forgot-bot').focus();
            }
        }

        if (!mail_filter.test($('#forgot-email').val())) {
            $('#forgot-email').parent('.form-input').addClass('is-invalid');
            $('#forgot-email').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#forgot-email').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });

    //Profile Change Password Form Validation
    $('#change-password-submit').click(function () {
        var clck_invld = 0;
        if (!($('#change-password-confirm').val().trim() == $('#change-password-new').val().trim())) {
            $('#change-password-confirm').parent('.form-input').addClass('is-invalid');
            $('#change-password-confirm').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#change-password-confirm').focus();
        }
        if ($('#change-password-confirm').val().trim().length < 6) {
            $('#change-password-confirm').parent('.form-input').addClass('is-invalid');
            $('#change-password-confirm').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#register-confirm-password').focus();
        }
        if ($('#change-password-new').val().trim().length < 6) {
            $('#change-password-new').parent('.form-input').addClass('is-invalid');
            $('#change-password-new').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#change-password-new').focus();
        }
        if ($('#change-password-old').val().trim().length < 4) {
            $('#change-password-old').parent('.form-input').addClass('is-invalid');
            $('#change-password-old').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#change-password-old').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });

    //Change Password Form Validation
    $('#changepassword-submit').click(function () {
        var clck_invld = 0;
        if ($('#login-bot').val().trim().length < 1) {
            $('#login-bot').parent('.form-input').addClass('is-invalid');
            $('#login-bot').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#login-bot').focus();
        } else if ($('#login-bot').val().trim().length > 0) {
            var bot_number = $('#login-bot+label').text(),
            bot_number_array = bot_number.match(/[\d\.]+/g),
            total = 0;
            if (bot_number_array.length > 0) {
                $.each(bot_number_array, function (key, element) {
                    total += +element;
                });
                if ($('#login-bot').val().trim() !== total.toString()) {
                    $('#login-bot').parent('.form-input').addClass('is-invalid');
                    $('#login-bot').parent('.form-input').addClass('is-dirty');
                    clck_invld = 1;
                    $('#login-bot').focus();
                }
            } else {
                $('#login-bot').parent('.form-input').addClass('is-invalid');
                $('#login-bot').parent('.form-input').addClass('is-dirty');
                clck_invld = 1;
                $('#login-bot').focus();
            }
        }
        if (!($('#changepassword-confirm').val().trim() == $('#changepassword').val().trim())) {
            $('#changepassword-confirm').parent('.form-input').addClass('is-invalid');
            $('#changepassword-confirm').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#changepassword-confirm').focus();
        }
        if ($('#changepassword-confirm').val().trim().length < 6) {
            $('#changepassword-confirm').parent('.form-input').addClass('is-invalid');
            $('#changepassword-confirm').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#changepassword-confirm').focus();
        }
        if ($('#changepassword').val().trim().length < 6) {
            $('#changepassword').parent('.form-input').addClass('is-invalid');
            $('#changepassword').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#changepassword-new').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });

    //Subscribe Form Validation
    $('#subscribe-submit').click(function () {
        var clck_invld = 0,
        mail_filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if (!mail_filter.test($('#subscribe-email').val())) {
            $('#subscribe-email').parent('.form-input').addClass('is-invalid');
            $('#subscribe-email').parent('.form-input').addClass('is-dirty');
            clck_invld = 1;
            $('#subscribe-email').focus();
        }
        if (clck_invld === 1) {
            return false;
        }
    });


});





