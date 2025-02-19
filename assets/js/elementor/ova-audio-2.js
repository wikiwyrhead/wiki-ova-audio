(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {
        /* Audio */
        $('.ovau-audio-2').each( function() {
            var that = $(this);

            if ( $(this).hasClass("ovau-media-video") ) {
                var popup_video     = $('#ovau-popup-video');
                var modal_overlay   = popup_video.find('.ovau-modal-overlay');
                var model_close     = popup_video.find('.ovau-modal-close');
                var video_content   = popup_video.find('.video-content');
                var control         = that.find('.play-pause');

                control.on( 'click', function(e) {
                    e.preventDefault();
                    var audio_id = $(this).data('id');
                    popup_video.addClass('ovau-show-video');
                    model_close.hide();

                    $.ajax({
                        url: ovau_ajax_object.ajax_url,
                        type: 'POST',
                        data: ({
                            action: 'ovau_load_media_video',
                            audio_id: audio_id,
                            security: ovau_ajax_object.ajax_nonce
                        }),
                        success: function(response){
                            video_content.empty().append(response);
                            model_close.show();

                            $(window).click(function(e) {
                                if ( e.target.className === 'ovau-modal-overlay' ) {
                                    popup_video.removeClass('ovau-show-video');
                                    video_content.empty();
                                }
                            });

                            model_close.on( 'click', function(e) {
                                e.preventDefault();
                                popup_video.removeClass('ovau-show-video');
                                video_content.empty();
                            });
                        },
                    });
                });
            } else {
                var id          = that.data('id');
                var title       = that.data('title');
                var control     = that.find('.play-pause');
                var avatar      = that.find('.avatar');
                var play_icon   = that.data('play-icon');
                var pause_icon  = that.data('pause-icon');
                var redo_icon   = that.data('redo-icon');
                var loop        = that.data('loop');
                var skip_back       = that.data('skip-back');
                var btn_skip_back   = that.find('.skip-back');
                var jump_forward    = that.data('jump-forward');
                var btn_jump_forward = that.find('.jump-forward');
                var start_volume    = that.data('start-volume');
                var duration    = that.find('.ovau-duration');
                var file_length = duration.data('length');

                if ( file_length && parseInt( file_length ) > 0 ) {
                    var ova_duration = secondsToTimeCode( file_length );
                    if ( ova_duration && ova_duration != '00:00' ) {
                        duration.html(ova_duration);
                    }
                }

                var audio       = that.find('audio').clone();
                audio.attr('id', 'ovau_' + id).attr('preload', 'auto').attr('width', '').attr('height', '');
                var ova_player  = that.find('#ovau-player-2');
                ova_player.empty();
                ova_player.append(audio);

                if ( ova_player.find('audio').length ) {
                    var player = new MediaElementPlayer('ovau_' + id, {
                        'classPrefix': 'ovamejs-',
                        'loop': loop,
                        'isVideo': false,
                        'setDimensions': false,
                        'alwaysShowControls': true,
                        'audioVolume': 'vertical',
                        'startVolume': start_volume,
                        'skipBackInterval': skip_back,
                        'jumpForwardInterval': jump_forward,
                        'timeAndDurationSeparator': '<span class="seperate">/</span>',
                        'features': ["current", "progress", "duration", "volume"],
                        success: function(mediaElement, originalNode, instance) {

                            mediaElement.addEventListener('play', function () {
                                that.find('.play-pause i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                                avatar.addClass('playing');
                                control.addClass('playing');
                            });

                            mediaElement.addEventListener('pause', function () {
                                that.find('.play-pause i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                                avatar.removeClass('playing');
                                control.removeClass('playing');
                            });

                            mediaElement.addEventListener('ended', function () {
                                that.find('.play-pause i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);
                            });

                            btn_skip_back.on('click', function () {
                                var media_duration = !isNaN(mediaElement.duration) ? mediaElement.duration : player.options.skipBackInterval;
                                if ( media_duration ) {
                                    var current = mediaElement.currentTime === Infinity ? 0 : mediaElement.currentTime;
                                    mediaElement.setCurrentTime(Math.max(current - player.options.skipBackInterval, 0));
                                }
                            });

                            btn_jump_forward.on('click', function () {
                                var media_duration = !isNaN(mediaElement.duration) ? mediaElement.duration : player.options.skipBackInterval;
                                if ( media_duration ) {
                                    var current = mediaElement.currentTime === Infinity ? 0 : mediaElement.currentTime;
                                    mediaElement.setCurrentTime(Math.max(current + player.options.skipBackInterval, 0));
                                }
                            });
                        }
                    });

                    control.on( 'click', function(e) {
                        e.preventDefault();
                        if ( player.paused ) {
                            player.play();
                        } else {
                            player.pause();
                        }

                        var ova_duration = getDuration(id);
                        if ( ova_duration && ova_duration != '00:00' ) {
                            duration.html(ova_duration);
                        }
                    });
                }
            }
        });

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_2.default', function(){
            //
        });

    });
})(jQuery);