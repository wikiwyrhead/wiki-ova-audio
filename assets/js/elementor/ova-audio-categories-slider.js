(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_categories_slider.default', function(){
            
            $(".ova-audio-categories-slider .slide-audio-categories").each(function(){
                var owlsl     = $(this) ;
                var owlsl_ops = owlsl.data('options') ? owlsl.data('options') : {};

                if( $("body").hasClass('rtl') ) {
                    owlsl_ops.rtl = true;
                }

                var responsive_value = {
                    0:{
                        items:1,
                        stagePadding:0,
                        dots:true,
                        nav:false
                    },
                    767:{
                        items:2,
                        stagePadding:0,
                    },
                    1170:{
                        items:owlsl_ops.items - 1
                    },
                    1300:{
                        items:owlsl_ops.items
                    }
                };
              
                owlsl.owlCarousel({
                    margin: owlsl_ops.margin,
                    stagePadding : owlsl_ops.stagePadding,
                    items: owlsl_ops.items,
                    loop: owlsl_ops.loop,
                    autoplay: owlsl_ops.autoplay,
                    autoplayTimeout: owlsl_ops.autoplayTimeout,
                    center: false,
                    nav: owlsl_ops.nav,
                    dots: owlsl_ops.dots,
                    thumbs: owlsl_ops.thumbs,
                    autoplayHoverPause: owlsl_ops.autoplayHoverPause,
                    slideBy: owlsl_ops.slideBy,
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

    });
})(jQuery);