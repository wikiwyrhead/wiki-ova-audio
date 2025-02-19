(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        /* Audio Slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_host_slider.default', function(){
            
            $(".slide-audio-host").each(function(){
                var owlsl = $(this) ;
                var owlsl_ops = owlsl.data('options') ? owlsl.data('options') : {};

                if( $("body").hasClass('rtl') ) {
                    owlsl_ops.rtl = true;
                }

                if( owlsl_ops.items >= 3 ) {
                    var responsive_value = {
                        0:{
                            items:1,
                            stagePadding:0,
                        },
                        767:{
                            items:owlsl_ops.items - 1
                        },
                        1024:{
                            items:owlsl_ops.items
                        }
                    };
                } else {
                    var responsive_value = {
                        0:{
                            items:1,
                            stagePadding:0,
                        },
                        767:{
                            items:1,
                            stagePadding:0,
                        },
                        1024:{
                            items:owlsl_ops.items
                        }
                    };
                }
              
                owlsl.owlCarousel({
                    margin: owlsl_ops.margin,
                    stagePadding : owlsl_ops.stagePadding,
                    items: owlsl_ops.items,
                    loop: owlsl_ops.loop,
                    autoplay: owlsl_ops.autoplay,
                    autoplayTimeout: owlsl_ops.autoplayTimeout,
                    center: owlsl_ops.center,
                    nav: false,
                    dots: owlsl_ops.dots,
                    thumbs: owlsl_ops.thumbs,
                    autoplayHoverPause: owlsl_ops.autoplayHoverPause,
                    slideBy: owlsl_ops.slideBy,
                    smartSpeed: owlsl_ops.smartSpeed,
                    responsive: responsive_value,
                    rtl: owlsl_ops.rtl
                });

                /* Fixed WCAG */
                owlsl.find(".owl-nav button.owl-prev").attr("title", "Previous");
                owlsl.find(".owl-nav button.owl-next").attr("title", "Next");
                owlsl.find(".owl-dots button").attr("title", "Dots");

            });
        });

    });
})(jQuery);