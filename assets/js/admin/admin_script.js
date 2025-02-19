(function ($) {
    "use strict";

    if ( $('#cmb2-metabox-ovau_settings').length ) {
        var ovau_settings   = $('#cmb2-metabox-ovau_settings');
        var ovau_type       = ovau_settings.find('.cmb2-id-ovau-type select[name="ovau_type"]');
        var type            = ovau_type.val();
        var audio_url       = ovau_settings.find('.cmb2-id-ovau-audio-url').hide();
        var audio_oembed    = ovau_settings.find('.cmb2-id-ovau-audio-oembed').hide();
        var audio_iframe    = ovau_settings.find('.cmb2-id-ovau-audio-iframe').hide();

        if ( 'oembed' === type ) {
            audio_oembed.show();
        } else if ( 'iframe' === type ) {
            audio_iframe.show();
        } else {
            audio_url.show();
        }

        ovau_type.on('change', function() {
            type = $(this).val();

            if ( 'oembed' === type ) {
                audio_url.hide();
                audio_oembed.show();
                audio_iframe.hide();
            } else if ( 'iframe' === type ) {
                audio_url.hide();
                audio_oembed.hide();
                audio_iframe.show();
            } else {
                audio_url.show();
                audio_oembed.hide();
                audio_iframe.hide();
            }
        });
    }

})(jQuery)