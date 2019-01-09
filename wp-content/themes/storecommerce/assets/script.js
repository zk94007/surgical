(function (e) {
    "use strict";
    var n = window.AFTHEMES_JS || {};
    n.mobileMenu = {
            init: function () {
                this.toggleMenu(), this.menuMobile(), this.menuArrow()
            },
            toggleMenu: function () {
                e('#masthead').on('click', '.toggle-menu', function (event) {
                    var ethis = e('.main-navigation .menu .menu-mobile');
                    if (ethis.css('display') == 'block') {
                        ethis.slideUp('300');
                    } else {
                        ethis.slideDown('300');
                    }
                    e('.ham').toggleClass('exit');
                });
                e('#masthead .main-navigation ').on('click', '.menu-mobile a i', function (event) {
                    event.preventDefault();
                    var ethis = e(this),
                        eparent = ethis.closest('li'),
                        esub_menu = eparent.find('> .sub-menu');
                    if (esub_menu.css('display') == 'none') {
                        esub_menu.slideDown('300');
                        ethis.addClass('active');
                    } else {
                        esub_menu.slideUp('300');
                        ethis.removeClass('active');
                    }
                    return false;
                });
            },
            menuMobile: function () {
                if (e('.main-navigation .menu > ul').length) {
                    var ethis = e('.main-navigation .menu > ul'),
                        eparent = ethis.closest('.main-navigation'),
                        pointbreak = eparent.data('epointbreak'),
                        window_width = window.innerWidth;
                    if (typeof pointbreak == 'undefined') {
                        pointbreak = 991;
                    }
                    if (pointbreak >= window_width) {
                        ethis.addClass('menu-mobile').removeClass('menu-desktop');
                        e('.main-navigation .toggle-menu').css('display', 'block');
                    } else {
                        ethis.addClass('menu-desktop').removeClass('menu-mobile').css('display', '');
                        e('.main-navigation .toggle-menu').css('display', '');
                    }
                }
            },
            menuArrow: function () {
                if (e('#masthead .main-navigation div.menu > ul').length) {
                    e('#masthead .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="">');
                }
            }
        },


        n.DataBackground = function () {
            var pageSection = e(".data-bg");
            pageSection.each(function (indx) {
                if (e(this).attr("data-background")) {
                    e(this).css("background-image", "url(" + e(this).data("background") + ")");
                }
            });

            e('.bg-image').each(function () {
                var src = e(this).children('img').attr('src');
                e(this).css('background-image', 'url(' + src + ')').children('img').hide();
            });
        },

        n.Preloader = function () {
            e(window).load(function () {
                e('.spinner-container').fadeOut();
                e('#af-preloader').delay(1000).fadeOut('slow');
            });
        },

        n.Search = function () {
            e(window).load(function () {
                e(".af-search-click").on('click', function () {
                    e("#af-search-wrap").toggleClass("af-search-toggle");
                });
            });
        },

        n.Offcanvas = function () {
            e('.offcanvas-nav').sidr({
                side: 'right'
            });

            e('.sidr-class-sidr-button-close').click(function () {
                e.sidr('close', 'sidr');
            });
        },

        n.openCloseSearch = function () {
            e('.open-search-form').click(function(){
                e('#myOverlay').show();
            });

            e('.close-serach-form').click(function(){
                e('#myOverlay').hide();
            });


        },



        // SHOW/HIDE SCROLL UP //
        n.show_hide_scroll_top = function () {
            if (e(window).scrollTop() > e(window).height() / 2) {
                e("#scroll-up").fadeIn(300);
            } else {
                e("#scroll-up").fadeOut(300);
            }
        },

        n.scroll_up = function () {
            e("#scroll-up").on("click", function () {
                e("html, body").animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        },



        n.OwlCarouselandSlider = function () {

            jQuery('.main-banner-slider').owlCarousel({
                loop: true,
                margin: 0,
                autoplay:true,
                autoplayTimeout:6000,
                autoplayHoverPause:true,
                nav: true,
                dots: true,
                slideSpeed: 300,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            jQuery('.testimonial-slider').owlCarousel({

                items:1,
                loop:true,
                margin:0,
                nav:true,
                dots:false,
                slideSpeed: 300,

            });

            jQuery('.brand-carousel').owlCarousel({
                loop:false,
                margin:10,
                nav:false,
                dots:true,
                autoplay:false,
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:3
                    },
                    1024:{
                        items:6
                    }
                }
            });

            jQuery('#secondary .insta-carousel').owlCarousel({
                loop:false,
                margin:10,
                items:1,
                dots:false,
                nav:true
            });

            jQuery('.insta-carousel').owlCarousel({
                loop:false,
                margin:10,
                nav:true,
                dots:false,
                autoplay:false,
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:3
                    },
                    1024:{
                        items:6
                    }
                }
            });

            jQuery('#sidr .product-carousel').owlCarousel({
                loop:false,
                margin:30,
                items:1,
                dots:true,
                nav:true
            });

            jQuery('#secondary .product-carousel').owlCarousel({
                loop:false,
                margin:30,
                items:1,
                dots:true,
                nav:true
            });

            jQuery('.product-carousel').owlCarousel({
                loop:false,
                margin:30,
                nav:true,
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:2
                    },
                    1024:{
                        items:4
                    }
                }
            });

            jQuery('#secondary .tabbed-product-carousel').owlCarousel({
                loop:false,
                margin:30,
                items:1,
                dots:false,
                nav:true
            });

            jQuery('.tabbed-product-carousel').owlCarousel({
                loop:false,
                margin:30,
                nav:true,
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:2
                    },
                    1024:{
                        items:4
                    }
                }
            });



            jQuery('.product-slider').owlCarousel({
                loop: true,
                autoplay:true,
                autoplayTimeout:6000,
                autoplayHoverPause:true,
                autoHeight: true,
                margin: 0,
                nav: true,
                dots: true,
                slideSpeed: 300,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });



        },

       

        n.faqAccordion = function () {


            jQuery(".aft-accordion-section").accordion();

        },



        e(document).ready(function () {
            n.mobileMenu.init(), n.DataBackground(), n.Preloader(), n.Search(), n.Offcanvas(), n.openCloseSearch(), n.OwlCarouselandSlider(), n.faqAccordion(), n.scroll_up();
        }), e(window).scroll(function () {
         n.show_hide_scroll_top();
    }), e(window).resize(function () {
        n.mobileMenu.menuMobile();
    })
})(jQuery);