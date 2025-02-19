(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        /* Audio List 2 */
        $('.ova-audio-list-2 .item-audio-2').each( function() {
            var that = $(this);
            ova_audio_play(that);
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_list_2.default', function(){});

    });
})(jQuery);