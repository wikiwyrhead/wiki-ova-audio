(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        /* Audio Main Slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_main_slider.default', function(){
            
            $(".main-slide-audio").each(function(){
                var owlsl     = $(this) ;
                var owlsl_ops = owlsl.data('options') ? owlsl.data('options') : {};

                if( $("body").hasClass('rtl') ) {
                    owlsl_ops.rtl = true;
                }

                var responsive_value = {
                    0:{
                        items:1,
                        dots:true,
                        nav:false
                    },
                    1024:{
                        items:1,
                    }
                };
              
                owlsl.owlCarousel({
                    items: 1,
                    slideBy: 1,
                    loop: owlsl_ops.loop,
                    autoplay: owlsl_ops.autoplay,
                    autoplayTimeout: owlsl_ops.autoplayTimeout,
                    nav: owlsl_ops.nav,
                    dots: owlsl_ops.dots,
                    autoplayHoverPause: owlsl_ops.autoplayHoverPause,
                    smartSpeed: owlsl_ops.smartSpeed,
                    rtl: owlsl_ops.rtl,
                    navText:[
                    '<i class="' + owlsl_ops.iconPrev + '"></i>',
                    '<i class="' + owlsl_ops.iconNext + '"></i>'
                    ],
                    responsive: responsive_value,
                });

                /* Fixed WCAG */
                owlsl.find(".owl-nav button.owl-prev").attr("title", "Previous");
                owlsl.find(".owl-nav button.owl-next").attr("title", "Next");
                owlsl.find(".owl-dots button").attr("title", "Dots");

            });
        });

        $('.main-slide-audio .ova-media').each( function() {
            var that = $(this);
            ova_audio_play(that);
        });

    });
})(jQuery);