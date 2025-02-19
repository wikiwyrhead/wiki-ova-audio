(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        $('.ova-audio-podcast').each( function() {
            var that        = $(this);
            var index       = 1;
            var next        = '';
            var player      = '';
            var podcast     = that.find('.ovau-podcast-play');
            var link_title  = that.data('link-title');
            var id          = podcast.data('id');
            var title       = podcast.data('title');
            var episode     = podcast.data('episode');
            var control     = podcast.find('.control-icon');
            var auto_next   = that.data('auto-next');
            var play_icon   = that.data('play-icon');
            var pause_icon  = that.data('pause-icon');
            var redo_icon   = that.data('redo-icon');
            var volume      = that.data('start-volume');

            if ( podcast.hasClass("ovau-media-video") ) {
                var popup_video     = $('#ovau-popup-video');
                var modal_overlay   = popup_video.find('.ovau-modal-overlay');
                var model_close     = popup_video.find('.ovau-modal-close');
                var video_content   = popup_video.find('.video-content');

                control.on( 'click', function(e) {
                    e.preventDefault();

                    if ( $(this).hasClass("ovau-media-video") ) {
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
                    } else {
                        if ( player && typeof player != "undefined" ) {
                            if ( player.paused ) {
                                player.play();
                            } else {
                                player.pause();
                            }
                        }
                    }
                });

            } else {
                var audio       = that.find('audio').clone();
                audio.attr('id', 'ovau_' + id).attr('preload', 'auto').attr('width', '').attr('height', '');
                var ova_player  = that.find('.ovau-podcast-player');
                ova_player.empty();
                ova_player.append(audio);

                if ( ova_player.find('audio').length ) {
                    player = new MediaElementPlayer('ovau_' + id, {
                        'classPrefix': 'ovamejs-',
                        'loop': false,
                        'isVideo': false,
                        'setDimensions': false,
                        'alwaysShowControls': true,
                        'audioVolume': 'vertical',
                        'startVolume': volume,
                        'timeAndDurationSeparator': '<span class="seperate">/</span>',
                        'features': ["progress", "current", "duration"],
                        success: function(mediaElement, originalNode, instance) {

                            mediaElement.addEventListener('play', function () {
                                that.find('.control-icon i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                                that.find('.ovau-podcast-list .is-first i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                                control.addClass('playing');
                            });

                            mediaElement.addEventListener('pause', function () {
                                that.find('.control-icon i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                                that.find('.ovau-podcast-list .is-first i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                                control.removeClass('playing');
                            });

                            mediaElement.addEventListener('ended', function () {
                                that.find('.control-icon i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);
                                that.find('.ovau-podcast-list .is-first i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);

                                // Next podcast
                                if ( 'yes' === auto_next ) {
                                    next_podcast();
                                }
                            });
                        }
                    });

                    control.bind( 'click', function() {
                        if ( player.paused ) {
                            player.play();
                        } else {
                            player.pause();
                        }
                    });
                }
            }
            
            that.find('.ovau-podcast-list .item-podcast').each(function() {
                var item_podcast    = $(this);
                var item_play       = item_podcast.find('.play-icon');

                if ( item_podcast.hasClass("ovau-media-video") ) {
                    var popup_video     = $('#ovau-popup-video');
                    var modal_overlay   = popup_video.find('.ovau-modal-overlay');
                    var model_close     = popup_video.find('.ovau-modal-close');
                    var video_content   = popup_video.find('.video-content');

                    item_play.on( 'click', function(e) {
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
                    var duration    = item_podcast.find('.duration');
                    var length      = duration.data('lenght');
                    if ( length && parseInt( length ) > 0 ) {
                        var item_duration = secondsToTimeCode( length );
                        if ( item_duration && item_duration != '00:00' ) {
                            duration.html(item_duration);
                        }
                    }

                    item_play.on('click', function() {

                        if ( $(this).hasClass('playing') ) {
                            player.pause();
                        } else {
                            that.find('.ovau-podcast-list .item-podcast .play-icon').removeClass('playing');
                            that.find('.ovau-podcast-play').removeClass('ovau-media-video');
                            that.find('.ovau-podcast-list .item-podcast .play-icon i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                            podcast = that.find('.ovau-podcast-play');

                            if ( player && $(this).hasClass('pause') ) {
                                player.play();
                            } else {
                                that.find('.ovau-podcast-list .item-podcast .play-icon').removeClass('pause');
                                var item_id         = item_podcast.data('id');
                                var item_index      = item_podcast.data('index');
                                var item_title      = item_podcast.data('title');
                                var item_link       = item_podcast.data('link');
                                var item_episode    = item_podcast.data('episode');
                                var item_host_link  = item_podcast.data('host-link');
                                var item_host_name  = item_podcast.data('host-name');
                                var item_src        = item_podcast.data('src');
                                var thumbnail       = item_podcast.data('thumbnail');
                                var item_alt        = item_podcast.data('alt');

                                // Change index for next podcast
                                index = parseInt(item_index) + 1;
                                
                                var item_audio  = that.find('audio').attr('id', 'ovau_' + item_id).attr('src', item_src).clone();
                                item_audio.attr('id', 'ovau_' + item_id).attr('src', item_src).attr('preload', 'auto').attr('width', '').attr('height', '');
                                var item_ova_player  = that.find('.ovau-podcast-player');
                                item_ova_player.empty();
                                item_ova_player.append(item_audio);

                                if ( item_ova_player.find('audio').length ) {

                                    if ( link_title === 'yes' ) {
                                        podcast.find('.title a').html(item_title);
                                        podcast.find('.title a').attr('href', item_link);
                                    } else {
                                        podcast.find('.title').html(item_title);
                                    }

                                    podcast.find('.episode .ovau-host a').html(item_host_name);
                                    podcast.find('.episode .ovau-host a').attr('href', item_host_link);

                                    podcast.find('.img-podcast img').attr('src', thumbnail);
                                    podcast.find('.episode .label').html(item_episode);

                                    player = new MediaElementPlayer('ovau_' + item_id, {
                                        'classPrefix': 'ovamejs-',
                                        'loop': false,
                                        'isVideo': false,
                                        'setDimensions': false,
                                        'alwaysShowControls': true,
                                        'audioVolume': 'vertical',
                                        'startVolume': volume,
                                        'timeAndDurationSeparator': '<span class="seperate">/</span>',
                                        'features': ["progress", "current", "duration"],
                                        success: function(mediaElement, originalNode, instance) {

                                            mediaElement.addEventListener('play', function () {
                                                that.find('.control-icon i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                                                item_play.find('i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                                                item_play.addClass('playing').removeClass('pause');
                                                item_ova_player.show();
                                            });

                                            mediaElement.addEventListener('pause', function () {
                                                that.find('.control-icon i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                                                item_play.find('i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                                                item_play.removeClass('playing').addClass('pause');
                                            });

                                            mediaElement.addEventListener('ended', function () {
                                                that.find('.control-icon i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);
                                                item_play.find('i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);
                                                item_play.removeClass('pause');

                                                // Next podcast
                                                if ( 'yes' === auto_next ) {
                                                    next_podcast();
                                                }
                                            });
                                        }
                                    });

                                    player.play();
                                }
                            }
                        }
                    });
                }
            });

            // Next Podcast
            function next_podcast() {
                next = that.find('.ovau-podcast-list .podcast-id-'+index+' .play-icon');
                if ( next.length > 0 && typeof next != "undefined" ) {
                    next.click();
                } else {
                    index = 0;
                    next_podcast();
                }
            }
        });



        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_podcast.default', function(){
            //
        });

    });
})(jQuery);