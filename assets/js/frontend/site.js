(function ($) {
    "use strict";

    $('.ova-audio').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            id = $this.attr('data-id'),
            title = $this.attr('data-title'),
            audio_el = $this.find('audio').clone();

        ova_player_init(title, audio_el, id);
        $('.ova-player-wrapper').removeClass('ova-player-collapsed');

    });

    function ova_player_init(title, source, source_id) {
        var ova_payer_wrapper = $('.ova-player-wrapper');
        var ova_payer = $('#ova-player');
        ova_payer.empty();
        show_loading();
        ova_payer_wrapper.removeClass('ova-player-hide');
        source.attr('id', 'ova-player-source' + source_id).attr('preload', 'auto').attr('width', '').attr('height', '').removeClass();
        ova_payer.append(source);
        var player = '';

        if (ova_payer.find('audio').length) {

            ova_payer_wrapper.find('.ova-player-title').html(title);
            player = new MediaElementPlayer('ova-player-source' + source_id, {
                'classPrefix': 'ovamejs-',
                'isVideo': false,
                'setDimensions': false,
                'alwaysShowControls': true,
                'audioVolume': 'vertical',
                'startVolume': 0.5,
                'skipBackInterval': 15,
                'jumpForwardInterval': 15,
                'timeAndDurationSeparator': '<span> / </span>',
                'features': ["skipback", "playpause", "jumpforward", "progress", "current", "duration", "volume", "speed"],
                'speeds': ['2', '1.5', '1.25', '0.75'],
                'defaultSpeed': '1',
                success: function(mediaElement, originalNode, instance) {
                    mediaElement.addEventListener('ended', function(e) {
                        $(document).trigger('ova_player_ended');
                    }, false);
                    hide_loading();
                }
            });
        }

        window.ova_player_init = player;
        player.play();
        $(document).trigger('ova_player_loaded');
    };


    /* Toggle the player */
    $('body').on('click', '.ova-player-toggle', function(e) {
        e.preventDefault();
        $(this).toggleClass('ovau-toggle-icon');
        $('.ova-player-wrapper').toggle('1000', 'linear');
    });

  
    $(document).ready(function(){ 
        // Fix Give v3.2.0 form with modal 
        if( $( '.single-audio' ).length ){ 
            $('.single-audio .donation .give-form-wrap').addClass('give-display-modal');
            $('.single-audio .donation .give-form-wrap .give-btn-fullForm').addClass('give-btn-modal');
        }
        if( $( '.ova_shortcode_donation' ).length ){ 
            $('.ova_shortcode_donation .give-form-wrap').addClass('give-display-modal');
            $('.ova_shortcode_donation .give-form-wrap .give-btn-fullForm').addClass('give-btn-modal');
        }

        /* Select2 Search Part*/
        $('#ovau_cat, #ovau_season').on('change', function(){
            $(this).closest('.search_form_audio').find('.select2-selection__rendered').css('color', '#333');
        });

        if ($('.ovau_cat').length > 0) {
            $('.ovau_cat').select2();
        };
        if ($('.ovau_season').length > 0) {
            $('.ovau_season').select2();
        };

        /***** Date Time Picker *****/
        $(".ovau_start_date_search, .ovau_end_date_search").each(function(){
            if($().datetimepicker) {
                var date = $(this).data('date');
                var lang = $(this).data('lang');
                $(this).datetimepicker({
                    format: date,
                    timepicker: false,
                    scrollInput: false
                });
                $.datetimepicker.setLocale(lang);
            }
        });
    });


    function show_loading() {
        $('#ova-loading').show();
    }

    function hide_loading() {
        $('#ova-loading').hide();
    }

    // Single Audio
    $('.single-audio .ovau-single-player').each( function() {
        var that = $(this);
        var id                  = that.data('id');
        var play_icon           = that.data('play-icon');
        var pause_icon          = that.data('pause-icon');
        var redo_icon           = that.data('redo-icon');
        var loop                = that.data('loop');
        var skip_back           = that.data('skip-back');
        var jump_forward        = that.data('jump-forward');
        var start_volume        = that.data('start-volume');
        var btn_skip_back       = that.find('.skip-back');
        var btn_jump_forward    = that.find('.jump-forward');
        var btn_play            = that.find('.btn-play');
        var duration            = that.find('.ovau-duration');
        var file_length         = duration.data('length');
        var timeline            = that.closest('.single-audio').find('.timeline .items');

        if ( file_length && parseInt( file_length ) > 0 ) {
            var ova_duration = secondsToTimeCode( file_length );
            if ( ova_duration && ova_duration != '00:00' ) {
                duration.html(ova_duration);
            }
        }

        var audio = that.closest('.single-audio').find('audio').clone();
        audio.attr('id', 'ovau_' + id).attr('preload', 'auto').attr('width', '').attr('height', '');
        var audio_progress  = that.find('.audio-progress');
        audio_progress.empty();
        audio_progress.append(audio);

        var player = '';

        if ( audio_progress.find('audio').length ) {
            player = new MediaElementPlayer('ovau_' + id, {
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
                'features': ["progress", "current", "duration", "volume", "speed"],
                'speeds': ['2', '1.5', '1.25', '0.75'],
                'defaultSpeed': '1',
                success: function(mediaElement, originalNode, instance) {

                    mediaElement.addEventListener('play', function () {
                        btn_play.find('i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                        btn_play.addClass('playing');
                    });

                    mediaElement.addEventListener('pause', function () {
                        btn_play.find('i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                        btn_play.removeClass('playing');
                        timeline.find('.control i').removeClass(pause_icon).addClass(play_icon);
                        timeline.find('.control').removeClass('playing');
                    });

                    mediaElement.addEventListener('ended', function () {
                        btn_play.find('i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);
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

                    ovau_single_timeline( timeline, mediaElement, play_icon, pause_icon );
                }
            });

            btn_play.on( 'click', function(e) {
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

        function ovau_single_timeline( timeline, mediaElement, play_icon, pause_icon ) {
            if ( timeline && typeof timeline != "undefined" && mediaElement ) {
                timeline.find('.item').each( function() {
                    var timeline_control = $(this).find('.control');
                    var time = $(this).data('time');

                    timeline_control.on('click', function() {
                        if ( $(this).hasClass('playing') ) {
                            if ( player && typeof player != "undefined" ) {
                                player.pause();
                                $(this).find('i').removeClass(pause_icon).addClass(play_icon);
                                $(this).removeClass('playing');
                            }
                        } else {
                            timeline.find('.control i').removeClass(pause_icon).addClass(play_icon);
                            timeline.find('.control').removeClass('playing');
                            mediaElement.setCurrentTime(Math.max(time, 0));
                            if ( player && typeof player != "undefined" ) {
                                player.play();
                                $(this).addClass('playing');
                                $(this).find('i').removeClass(play_icon).addClass(pause_icon);
                            }
                        }
                    });
                });
            }
        }
    });

    // Timeline
    $('.single-audio .timeline .items .item').each( function() {
        var timeline_control = $(this).find('.control');
        var timeline_duration = $(this).find('.duration');
        var time = $(this).data('time');
        var convert_time = secondsToTimeCode( time );
        timeline_duration.html(convert_time);
    });

    // Single Audio Host
    $('.ova_audio_host_single .ova-media').each( function() {
        var that   = $(this);
        var player = '';

        ova_audio_play(that);
    });

})(jQuery)

// Audio Play
function ova_audio_play(that) {
    if ( that.hasClass("ovau-media-video") ) {
        var popup_video     = $('#ovau-popup-video');
        var modal_overlay   = popup_video.find('.ovau-modal-overlay');
        var model_close     = popup_video.find('.ovau-modal-close');
        var video_content   = popup_video.find('.video-content');
        var control         = that.find('.ovau-btn-play');
        
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
        var type        = that.data('type');
        var audio_id    = that.data('audio-id');
        var player_id   = that.data('player-id');
        var title       = that.data('title');
        var host        = that.data('host');
        var episode     = that.data('episode');
        var control     = that.find('.ovau-btn-play');
        var play_icon   = that.data('play-icon');
        var pause_icon  = that.data('pause-icon');
        var loop        = that.data('loop');
        var skip_back       = that.data('skip-back');
        var jump_forward    = that.data('jump-forward');
        var start_volume    = that.data('start-volume');
        var html_category   = that.data('category');
        var player = '';

        control.on( 'click', function(e) {
            e.preventDefault();

            if ( 'oembed' === type || 'iframe' === type ) {
                // Show player
                var ova_player      = $('#ova-player');
                var player_wrapper  = $('.ovau-player-container');
                ova_player.empty();
                $('#ova-loading').show();
                player_wrapper.removeClass('ova-player-hide').addClass('ovau-iframe');
                $('.ova-player-wrapper').removeClass('ova-player-collapsed');
                player_wrapper.find('.ova-player-title').html(title);
                player_wrapper.find('.ova-player-categories').html(html_category);
                if ( host != '') {
                    player_wrapper.find('.ova-player-host').html(host + ' .');
                }
                player_wrapper.find('.ova-player-episode').html(episode);

                $.ajax({
                    url: ovau_ajax_object.ajax_url,
                    type: 'POST',
                    data: ({
                        action: 'ovau_load_audio_iframe',
                        type: type,
                        audio_id: audio_id,
                        security: ovau_ajax_object.ajax_nonce
                    }),
                    success: function(response){
                        ova_player.empty();
                        ova_player.append(response);
                        $('#ova-loading').hide();
                    },
                });
            } else {
                if ( !$(this).hasClass("ovau-playing") && !$(this).hasClass("ovau-pausing") ) {
                    var ova_player      = $('#ova-player');
                    var player_wrapper  = $('.ovau-player-container');
                    ova_player.empty();
                    $('#ova-loading').show();
                    player_wrapper.removeClass('ova-player-hide').removeClass('ovau-iframe');
                    var audio = that.find('audio').clone();
                    audio.attr('id', 'ovau_list_' + player_id).attr('preload', 'auto').attr('width', '').attr('height', '');
                    ova_player.append(audio);

                    if ( ova_player.find('audio').length ) {
                        player_wrapper.find('.ova-player-title').html(title);
                        player_wrapper.find('.ova-player-categories').html(html_category);
                        if ( host != '') {
                            player_wrapper.find('.ova-player-host').html(host + ' .');
                        }
                        player_wrapper.find('.ova-player-episode').html(episode);
                        
                        player = new MediaElementPlayer('ovau_list_' + player_id, {
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
                            'features': ["skipback", "playpause", "jumpforward", "progress", "current", "duration", "volume", "speed"],
                            'speeds': ['2', '1.5', '1.25', '0.75'],
                            'defaultSpeed': '1',
                            success: function(mediaElement, originalNode, instance) {

                                mediaElement.addEventListener('play', function () {
                                    control.find('i').removeClass(play_icon).addClass(pause_icon);
                                    control.addClass('ovau-playing');
                                    $('.ova-media .ovau-btn-play').removeClass('ovau-pausing');
                                });

                                mediaElement.addEventListener('pause', function () {
                                    control.find('i').removeClass(pause_icon).addClass(play_icon);
                                    control.removeClass('ovau-playing');
                                });

                                $('#ova-loading').hide();
                            }
                        });

                        // Show player
                        $('.ova-player-wrapper').removeClass('ova-player-collapsed');

                        player.play();
                    }
                } else {
                    if ( player && typeof player != "undefined" ) {

                        if ( $(this).hasClass("ovau-pausing") ) {
                            // Show player
                            $('.ova-player-wrapper').removeClass('ova-player-collapsed');
                            control.removeClass('ovau-pausing');
                            player.play();
                        } else {
                            // Show player
                            $('.ova-player-wrapper').removeClass('ova-player-collapsed');
                            player.pause();
                            control.addClass('ovau-pausing');
                        }
                    }
                }
            }
        });
    }
}

function isDropFrame() {
    var fps = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 25;

    return !(fps % 1 === 0);
}

function secondsToTimeCode(time) {
    var forceHours = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var showFrameCount = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
    var fps = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 25;
    var secondsDecimalLength = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : 0;
    var timeFormat = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : 'mm:ss';


    time = !time || typeof time !== 'number' || time < 0 ? 0 : time;

    var dropFrames = Math.round(fps * 0.066666),
        timeBase = Math.round(fps),
        framesPer24Hours = Math.round(fps * 3600) * 24,
        framesPer10Minutes = Math.round(fps * 600),
        frameSep = isDropFrame(fps) ? ';' : ':',
        hours = void 0,
        minutes = void 0,
        seconds = void 0,
        frames = void 0,
        f = Math.round(time * fps);

    if (isDropFrame(fps)) {

        if (f < 0) {
            f = framesPer24Hours + f;
        }

        f = f % framesPer24Hours;

        var d = Math.floor(f / framesPer10Minutes);
        var m = f % framesPer10Minutes;
        f = f + dropFrames * 9 * d;
        if (m > dropFrames) {
            f = f + dropFrames * Math.floor((m - dropFrames) / Math.round(timeBase * 60 - dropFrames));
        }

        var timeBaseDivision = Math.floor(f / timeBase);

        hours = Math.floor(Math.floor(timeBaseDivision / 60) / 60);
        minutes = Math.floor(timeBaseDivision / 60) % 60;

        if (showFrameCount) {
            seconds = timeBaseDivision % 60;
        } else {
            seconds = (f / timeBase % 60).toFixed(secondsDecimalLength);
        }
    } else {
        hours = Math.floor(time / 3600) % 24;
        minutes = Math.floor(time / 60) % 60;
        if (showFrameCount) {
            seconds = Math.floor(time % 60);
        } else {
            seconds = (time % 60).toFixed(secondsDecimalLength);
        }
    }
    hours = hours <= 0 ? 0 : hours;
    minutes = minutes <= 0 ? 0 : minutes;
    seconds = seconds <= 0 ? 0 : seconds;

    var timeFormatFrags = timeFormat.split(':');
    var timeFormatSettings = {};
    for (var i = 0, total = timeFormatFrags.length; i < total; ++i) {
        var unique = '';
        for (var j = 0, t = timeFormatFrags[i].length; j < t; j++) {
            if (unique.indexOf(timeFormatFrags[i][j]) < 0) {
                unique += timeFormatFrags[i][j];
            }
        }
        if (~['f', 's', 'm', 'h'].indexOf(unique)) {
            timeFormatSettings[unique] = timeFormatFrags[i].length;
        }
    }

    var result = forceHours || hours > 0 ? (hours < 10 && timeFormatSettings.h > 1 ? '0' + hours : hours) + ':' : '';
    result += (minutes < 10 && timeFormatSettings.m > 1 ? '0' + minutes : minutes) + ':';
    result += '' + (seconds < 10 && timeFormatSettings.s > 1 ? '0' + seconds : seconds);

    if (showFrameCount) {
        frames = (f % timeBase).toFixed(0);
        frames = frames <= 0 ? 0 : frames;
        result += frames < 10 && timeFormatSettings.f ? frameSep + '0' + frames : '' + frameSep + frames;
    }

    return result;
}

function getDuration( id ) {
    var duration = 0;

    try {
        duration = document.querySelector('#id_'+id).duration;
    } catch(err) {
        duration = 0;
    }

    return secondsToTimeCode(duration);
}