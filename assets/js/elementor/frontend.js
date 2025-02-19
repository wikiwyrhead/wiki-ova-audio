(function($) {
    'use strict';

    var OvaAudioFrontend = {
        initialized: false,

        init: function() {
            if (this.initialized) {
                return;
            }

            try {
                if (typeof elementorFrontend !== 'undefined') {
                    this.initElementor();
                } else {
                    $(window).on('elementor/frontend/init', this.initElementor.bind(this));
                }
            } catch (error) {
                console.error('OvaAudio: Error during initialization:', error);
            }
        },

        initElementor: function() {
            try {
                elementorFrontend.on('components:init', function() {
                    console.log('OvaAudio: Frontend initialized');
                });
                this.initialized = true;
            } catch (error) {
                console.error('OvaAudio: Error initializing Elementor frontend:', error);
            }
        }
    };

    // Initialize on document ready
    $(function() {
        OvaAudioFrontend.init();
    });

})(jQuery);
