(function($) {
    "use strict";

        $(window).on('elementor/frontend/init', function () {
        
            elementorFrontend.hooks.addAction('frontend/element_ready/ovau_elementor_audio_category_filter_2.default', function(){
               
                $('.ova-audio-category-filter-2 .audio-categories').each( function() {
                    var that         = $(this);
                    var audio        = that.closest('.ova-audio-category-filter');
                    var category     = audio.find('.audio-category');
                    var audio_active = that.find('.audio-active').data('slug');

                    if ( audio_active && typeof audio_active != "undefined" ) {
                        loadAjaxCategoryFilter2(audio, audio_active, 1);
                    }
                    
                    category.on('click', function(e) {
                        e.preventDefault();

                        var slug = $(this).data('slug');

                        that.find('.audio-container-mobile').remove();
                        $(this).after('<div class="audio-container-mobile"></div>');

                        that.find('i').removeClass('ovaicon ovaicon-minus').addClass('ovaicon ovaicon-plus');
                        $(this).find('i').removeClass('ovaicon ovaicon-plus').addClass('ovaicon ovaicon-minus');

                        loadAjaxCategoryFilter2(audio, slug, 1);

                        category.removeClass('audio-active');
                        $(this).addClass('audio-active');
                    });
                });

                function loadAjaxCategoryFilter2( that = null, slug = '', paged = 1 ) {
                    
                    if ( that != null ) {
                        var per_page        = that.data('per-page');
                        var order_by        = that.data('order_by');
                        var order           = that.data('order');
                        var cate_not_in     = that.data('category-not-in');
                        var show_thumbnail  = that.data('show-thumbnail');
                        var show_title      = that.data('show-title');
                        var show_host       = that.data('show-host');
                        var show_episode    = that.data('show-episode');
                        var show_category   = that.data('show-category');
                        var show_pagination = that.data('show-pagination');
                        var target_link     = that.data('target');
                        var detail_label    = that.data('detail-label');
                        var layout          = that.data('layout');

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
                                action: 'load_list_category_filter',
                                per_page: per_page,
                                order_by: order_by,
                                order: order,
                                cate_not_in: cate_not_in,
                                slug: slug,
                                paged: paged,
                                show_thumbnail: show_thumbnail,
                                show_title: show_title,
                                show_host: show_host,
                                show_episode: show_episode,
                                show_category: show_category,
                                show_pagination: show_pagination,
                                target_link: target_link,
                                detail_label: detail_label,
                                layout: layout,
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
                                var audio_container = that.find('.audio-container');
                                audio_container.html( response ).fadeIn(300);

                                var category_active = that.find('.audio-container-mobile');
                                category_active.html( response ).fadeIn(300);

                                that.find('.page-numbers').on('click', function(e) {
                                    var current = that.find('.category-filter-pagination .current').data('paged');
                                    var page    = $(this).data('paged');
                                    if ( current != page ) {
                                        loadAjaxCategoryFilter2( that, slug, page );
                                        $('html, body').animate({
                                            scrollTop: that.offset().top
                                        }, 1000);
                                    }
                                });
                            },
                        });
                    }
                    // end if
                }

                $(document).ready(function () {
                    var cate_active = $(this).find('.audio-category.audio-active');
                    cate_active.click();
                });
              

            });


       });

})(jQuery);