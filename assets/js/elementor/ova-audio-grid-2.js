(function($) {
    "use strict";

    $(window).on('elementor/frontend/init', function () {

        $(".ova-audio-grid-2 .ova-media").each(function(){
            var that = $(this);
            ova_audio_play(that);
        });

        /* Audio Grid 2 */
        function playAudioGrid2() {
            $('.ova-audio-grid-has-ajax .ova-audio-grid-2 .ova-media').each( function() {
                var that = $(this);
                ova_audio_play(that);
            });
        }

        /* Audio Slider */
        elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_grid_2.default', function(){

            $('.ova-audio-grid-has-ajax').each( function() {
                var that = $(this);

                var page_numbers = that.find('.ovau_pagination_ajax .page-numbers');

                $(document).on('click', '.ovau_pagination_ajax .page-numbers', function (e) {    
                    e.preventDefault();
                    var current = that.find('.ovau_pagination_ajax .current').data('paged');
                    var paged   = $(this).data('paged');

                    if ( (current != paged) || (current == 1 && paged == 1) ) {
                        page_numbers.removeClass('current');
                        $(this).addClass('current');
                        loadAjaxAudioGrid2(that,paged);
                        $('html, body').animate({
                            scrollTop: that.offset().top - 100
                        }, 1000);
                    }
                });
            });

            function loadAjaxAudioGrid2( that = null, paged = 1 ) {
                if ( that != null ) {
                    var total_posts = that.data('per_page');
                    var orderby     = that.data('orderby');
                    var order       = that.data('order');
                    var offset      = that.data('offset');
                    var categories  = that.data('categories');
                    var column      = that.data('column');
                    var pagination  = that.data('pagination');

                    var class_icon     = that.data('class_icon');
                    var time_type      = that.data('time_type');
                    var show_thumbnail = that.data('show_thumbnail');
                    var show_host      = that.data('show_host');
                    var show_category  = that.data('show_category');
                    var show_episode   = that.data('show_episode');
                    var show_title     = that.data('show_title');
                    var show_date      = that.data('show_date');
                    var show_duration  = that.data('show_duration');
                    var show_excerpt   = that.data('show_excerpt');
                    var show_comment   = that.data('show_comment');

                    var show_link_to_detail   = that.data('show_link_to_detail');
                    var replace_date_by_cate  = that.data('replace_date_by_cate');

                    var play_icon     = that.data('play-icon');
                    var pause_icon    = that.data('pause-icon');
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
                            action: 'load_audio_grid_2',
                            total_posts: total_posts,
                            orderby: orderby,
                            order: order,
                            offset: offset,
                            categories: categories,
                            paged: paged,
                            column: column,
                            pagination: pagination,
                            class_icon: class_icon,
                            time_type: time_type,
                            show_thumbnail: show_thumbnail,
                            show_host: show_host,
                            show_category: show_category,
                            show_episode: show_episode,
                            show_title: show_title,
                            show_date: show_date,
                            show_duration: show_duration,
                            show_excerpt: show_excerpt,
                            show_comment: show_comment,
                            show_link_to_detail: show_link_to_detail,
                            replace_date_by_cate: replace_date_by_cate,
                            play_icon: play_icon,
                            pause_icon: pause_icon,
                            loop: loop,
                            skip_back: skip_back,
                            jump_forward: jump_forward,
                            start_volume: start_volume
                        }),
                        success: function(response){
                            that.find('.wrap_loader').fadeOut(200);
                            var audio_wrap = that.find('.wrap-audio-posts-result');
                            audio_wrap.html( response ).fadeIn(300);
                            playAudioGrid2();
                        },
                    });
                }
            }

        });

    });
})(jQuery);