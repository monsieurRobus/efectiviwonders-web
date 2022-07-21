jQuery(document).ready(function($) {
    /** Variables from Customizer for Slider settings */
    var slider_auto, slider_loop, rtl, slider_animation;
    
    if( wedding_band_data.auto == '1' ){
         slider_auto = true;
    }else{
         slider_auto = false;
    }

    if( wedding_band_data.loop == '1' ){
        slider_loop = true;
    }else{
        slider_loop = false;
    }

    if( wedding_band_data.rtl == '1' ){
        rtl = true;
    }else{
        rtl = false;
    }  

    if( wedding_band_data.animation == 'fade' ){
        slider_animation = 'fadeOut';
    }else{
        slider_animation = '';
    }

    $('.map').click(function() {
        $('.map iframe').css("pointer-events", "auto");
    });

    $(".map").mouseleave(function() {
        $('.map iframe').css("pointer-events", "none");
    });

    $("#lightSlider").lightSlider({
        item: 4,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        enableDrag: false,
        slideMargin: 0,
        keyPress: true,
        rtl: rtl,
        responsive: [{
            breakpoint: 992,
            settings: {
                item: 2,
                slideMove: 1,
                slideMargin: 0,
            }
        }, {
            breakpoint: 768,
            settings: {
                item: 1,
                slideMove: 1
            }
        }],
    });

    /* Equal Height */
    $('.blog-section .col .post').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });
  
    //nice scroll
    $(".section-4 .text-holder").niceScroll({
        cursorcolor: "#222",
        zindex: "999999",
        cursorborder: "none",
        cursoropacitymin: "1",
        cursoropacitymax: "1",
        cursorwidth: "8px",
        cursorborderradius: "0px;"
    });

    //banner slider
    $('.banner-slider').owlCarousel({
        loop: slider_loop,
        autoplay: slider_auto,
        animateOut: slider_animation,
        margin: 0,
        rtl: rtl,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            }
        }
    });


    //responsive menu toggle
    $('.mobile-menu-wrapper .mobile-menu-close-btn').on('click', function(){
        $('.mobile-menu-wrapper .mobile-menu').animate({
            height: 'toggle',
        });
    });

    $('.mobile-menu-wrapper .close').on('click', function () {
        $('.mobile-menu-wrapper .mobile-menu').animate({
            height: 'toggle',
        });
    });
    $('<button class="arrow-down"></button>').insertAfter($('.mobile-navigation ul .menu-item-has-children > a'));
    $('.mobile-navigation ul li .arrow-down').click(function() {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });

    var winWidth = $(window).width();
    if(winWidth > 991){
        $("#site-navigation ul li a").focus(function() {
            $(this).parents("li").addClass("focus");
        }).blur(function() {
            $(this).parents("li").removeClass("focus");
        });
    }

});
