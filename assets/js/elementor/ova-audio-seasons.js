(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {
        /* Audio */
        $('.ovau-item-seasons').each( function() {
            var that = $(this);
            ova_audio_play(that);
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_seasons.default', function(){
            // JS
        });

    });
})(jQuery);