(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {
        
        /* Audio List */
        $('.ova-audio-list .item-audio').each( function() {
            var that  = $(this);
            ova_audio_play(that);
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_list.default', function(){});

    });
})(jQuery);