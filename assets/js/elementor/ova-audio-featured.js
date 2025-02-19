(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        /* Audio Featured */
        function playAudioFeatured() {
            $('.ova-audio-featured .item-featured').each( function() {
                var that = $(this);

                if ( $(this).hasClass("ovau-media-video") ) {
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
                    var id          = that.data('id');
                    var title       = that.data('title');
                    var control     = that.find('.ovau-btn-play');
                    var play_icon   = that.data('play-icon');
                    var pause_icon  = that.data('pause-icon');
                    var redo_icon   = that.data('redo-icon');
                    var loop        = that.data('loop');
                    var skip_back       = that.data('skip-back');
                    var jump_forward    = that.data('jump-forward');
                    var start_volume    = that.data('start-volume');

                    var audio       = that.find('audio').clone();
                    audio.attr('id', 'ovau_' + id).attr('preload', 'auto').attr('width', '').attr('height', '');
                    var ova_player  = that.find('.ovau-player-featured');
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
                                    that.find('.ovau-btn-play i').removeClass(play_icon).removeClass(redo_icon).addClass(pause_icon);
                                    control.addClass('playing');
                                });

                                mediaElement.addEventListener('pause', function () {
                                    that.find('.ovau-btn-play i').removeClass(pause_icon).removeClass(redo_icon).addClass(play_icon);
                                    control.removeClass('playing');
                                });

                                mediaElement.addEventListener('ended', function () {
                                    that.find('.ovau-btn-play i').removeClass(play_icon).removeClass(pause_icon).addClass(redo_icon);
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
                        });
                    }
                }
            });
        }

        playAudioFeatured();

        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_featured.default', function(){
            $('.ova-audio-featured-has-ajax').each( function() {
                var that = $(this);

                var page_numbers  = that.find('.wrap-audio-posts-result .ovau_pagination_ajax .page-numbers');

                // Click Pagination
                $(document).on('click', '.ovau_pagination_ajax .page-numbers', function (e) {    
                    e.preventDefault();
                    var current = that.find('.ovau_pagination_ajax .current').data('paged');
                    var paged   = $(this).data('paged');

                    if ( (current != paged) || (current == 1 && paged == 1) ) {
                        page_numbers.removeClass('current');
                        $(this).addClass('current');
                        loadAjaxAudioFeatured(that,paged);
                        $('html, body').animate({
                            scrollTop: that.offset().top - 100
                        }, 1000);
                    }
                });

                // Search Form Change
                $('.search_form_audio [name="ovau_cat"], .search_form_audio [name="ovau_season"], .search_form_audio [name="ovau_start_date_search"], .search_form_audio [name="ovau_end_date_search"]').on('change', function(e) {
                    loadAjaxAudioFeatured(that,1);
                });

            });

            function loadAjaxAudioFeatured( that = null, paged = 1 ) {
                if ( that != null ) {
                    var featured    = that.data('featured');
                    var total_posts = that.data('per_page');
                    var order       = that.data('order');
                    var orderby     = that.data('orderby');
                    var filter      = that.data('filter');
                    var pagination  = that.data('pagination');

                    var time_type     = that.data('time_type');
                    var target_link   = that.data('target_link');
                    var link_title    = that.data('link_title');
                    var detail_label  = that.data('detail_label');
                    var seperate      = that.data('seperate');

                    var season      = that.find('[name="ovau_season"]').val();
                    var category    = that.find('[name="ovau_cat"]').val();
                    var start_date  = that.find('[name="ovau_start_date_search"]').val();
                    var end_date    = that.find('[name="ovau_end_date_search"]').val();

                    var show_title     = that.data('show_title');
                    var show_thumbnail = that.data('show_thumbnail');
                    var show_host      = that.data('show_host');
                    var show_episode   = that.data('show_episode');
                    var show_category  = that.data('show_category');
                    var show_excerpt   = that.data('show_excerpt');

                    var play_icon     = that.data('play-icon');
                    var pause_icon    = that.data('pause-icon');
                    var redo_icon     = that.data('redo-icon');
                    var loop          = that.data('loop');
                    var skip_back     = that.data('skip-back');
                    var jump_forward  = that.data('jump-forward');
                    var start_volume  = that.data('start-volume');

                    that.find('.wrap_loader').fadeIn(100);

                    $.ajax({
                        url: ovau_ajax_object.ajax_url,
                        type: 'POST',
                        data: ({
                            security: ovau_ajax_object.ajax_nonce,
                            action: 'load_audio_featured',
                            featured: featured,
                            total_posts: total_posts,
                            orderby: orderby,
                            order: order,
                            category: category,
                            paged: paged,
                            filter: filter,
                            pagination: pagination,
                            time_type: time_type,
                            target_link: target_link,
                            link_title: link_title,
                            show_title: show_title,
                            show_thumbnail: show_thumbnail,
                            show_host: show_host,
                            show_episode: show_episode,
                            show_category: show_category,
                            show_excerpt: show_excerpt,
                            detail_label: detail_label,
                            start_date: start_date,
                            end_date: end_date,
                            seperate: seperate,
                            season: season,
                            play_icon: play_icon,
                            pause_icon: pause_icon,
                            redo_icon: redo_icon,
                            loop: loop,
                            skip_back: skip_back,
                            jump_forward: jump_forward,
                            start_volume: start_volume
                        }),
                        success: function(response){
                            that.find('.wrap_loader').fadeOut(200);
                            var audio_wrap = that.find('.wrap-audio-posts-result');
                            audio_wrap.html( response ).fadeIn(300);
                            playAudioFeatured();
                            $('.search_form_audio [name="ovau_cat"], .search_form_audio [name="ovau_season"], .search_form_audio [name="ovau_start_date_search"], .search_form_audio [name="ovau_end_date_search"]').on('change', function(e) {
                                loadAjaxAudioFeatured(that,1);
                            });
                            $(document).ready(function(){ 
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
                        },
                    });
                }
            }
        });

    });
})(jQuery);