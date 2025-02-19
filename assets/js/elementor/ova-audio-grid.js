(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        $(".ova-audio-grid").each(function(){
            var that = $(this);
        });

        /* Audio Slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_grid.default', function(){
            
        });

    });
})(jQuery);