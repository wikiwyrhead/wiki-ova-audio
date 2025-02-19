class OvaAudioSliderHandler extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                slider: '.slide-audio'
            },
            defaultOptions: {
                margin: 0,
                loop: false,
                autoplay: false,
                autoplay_timeout: 5000,
                items: 1,
                pause_on_hover: true,
                smartspeed: 450,
                dots: false,
                nav: false,
                center: false,
                rtl: jQuery("body").hasClass('rtl')
            }
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $slider: this.$element.find(selectors.slider)
        };
    }

    onInit() {
        super.onInit();
        this.initSlider();
    }

    initSlider() {
        const { $slider } = this.elements;
        if (!$slider.length) return;

        try {
            const userOptions = $slider.data('options') || {};
            const settings = this.getSettings();
            const options = jQuery.extend({}, settings.defaultOptions, userOptions);

            const responsive = options.items >= 3 ? {
                0: { items: 1, stagePadding: 0 },
                576: { items: 1, stagePadding: 0 },
                992: { items: 2 },
                1600: { items: options.items }
            } : {
                0: { items: 1, stagePadding: 0 },
                767: { items: 1, stagePadding: 0 },
                1024: { items: options.items }
            };

            $slider.owlCarousel({
                margin: options.margin,
                loop: options.loop,
                autoplay: options.autoplay,
                autoplayTimeout: options.autoplay_timeout,
                items: options.items,
                responsive: responsive,
                autoplayHoverPause: options.pause_on_hover,
                smartSpeed: options.smartspeed,
                dots: options.dots,
                nav: options.nav,
                navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>'],
                center: options.center,
                rtl: options.rtl,
                onInitialized: () => {
                    $slider.find(".owl-nav button.owl-prev").attr("title", "Previous");
                    $slider.find(".owl-nav button.owl-next").attr("title", "Next");
                    $slider.find(".owl-dots button").attr("title", "Dots");
                }
            });
        } catch (error) {
            console.error('OvaAudio: Error initializing slider:', error);
        }
    }

    onElementChange(propertyName) {
        if (propertyName.indexOf('slider_') === 0) {
            this.elements.$slider.trigger('destroy.owl.carousel');
            this.initSlider();
        }
    }
}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(OvaAudioSliderHandler, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_slider.default', addHandler);
});