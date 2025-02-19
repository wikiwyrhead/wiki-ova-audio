(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        /* Audio Category */
        $('.ovau-item-category').each( function() {
            var that = $(this);
            ova_audio_play(that);
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_category.default', function(){});

    });
})(jQuery);