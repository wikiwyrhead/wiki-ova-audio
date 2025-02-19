(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        /* Audio Slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_play_button.default', function(){
            
            $(".ovau-play-button .ova-media").each(function(){
                var that = $(this);
                ova_audio_play(that);
            });
        });

    });
})(jQuery);