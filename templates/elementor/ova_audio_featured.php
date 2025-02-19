<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$category_name  = esc_html__( 'All', 'ovau' );
$category_link  = get_post_type_archive_link( 'ova_audio' );

$link_title     = isset($args['link_title']) ? $args['link_title'] : '';
$target_link    = (isset($args['target_link']) && 'yes' === $args['target_link']) ? ' target="_blank"' : '';

$detail_label   = isset($args['detail_label']) ? $args['detail_label'] : '';
$seperate       = isset($args['seperate']) ? $args['seperate'] : '.' ;
$play_icon      = isset($args['play_icon']['value'])  ? $args['play_icon']['value'] : 'fas fa-play';
$pause_icon     = isset($args['pause_icon']['value']) ? $args['pause_icon']['value'] : 'fas fa-pause';
$redo_icon      = isset($args['redo_icon']['value'])  ? $args['redo_icon']['value'] : 'fas fa-redo-alt';
$loop           = isset($args['loop']) === 'yes' ? 'true' : 'false';
$skip_back      = isset($args['skip_back']) ? $args['skip_back'] : 15;
$jump_forward   = isset($args['jump_forward']) ? $args['jump_forward'] : 15;
$start_volume   = isset($args['start_volume']) ? $args['start_volume'] : 0.5;

$audio_date_fortmat = apply_filters('ovau_audio_featured_date_format','m/d/Y');

$filter     = isset($args['show_filter'])     ? $args['show_filter']      : 'no';
$pagination = isset($args['show_pagination']) ? $args['show_pagination']  : 'no';

$audios = ovau_get_audio_featured( $args );

$total  = $audios->max_num_pages;

?>

<?php if ( $audios->have_posts() ) : ?>
    <?php if( $pagination == 'yes' || $filter == 'yes') : ?>
    <div class="ova-audio-featured-has-ajax" style="position: relative;"
        data-featured="<?php echo esc_attr( $featured ); ?>" 
        data-per_page="<?php echo esc_attr( $total_posts ); ?>" 
        data-orderby="<?php echo esc_attr( $orderby ); ?>" 
        data-order="<?php echo esc_attr( $order ); ?>" 
        data-category="<?php echo esc_attr( $category ); ?>" 
        data-time_type="<?php echo esc_attr( $time_type ); ?>"
        data-target_link="<?php echo esc_attr( $target_link ); ?>"
        data-link_title="<?php echo esc_attr( $link_title ); ?>"
        data-show_title="<?php echo esc_attr( $show_title ); ?>"
        data-show_thumbnail="<?php echo esc_attr( $show_thumbnail ); ?>"
        data-show_host="<?php echo esc_attr( $show_host ); ?>"
        data-show_episode="<?php echo esc_attr( $show_episode ); ?>"
        data-show_category="<?php echo esc_attr( $show_category ); ?>"
        data-show_excerpt="<?php echo esc_attr( $show_excerpt ); ?>"
        data-seperate="<?php echo esc_attr( $seperate ); ?>"
        data-detail_label="<?php echo esc_attr( $detail_label ); ?>"
        data-filter="<?php echo esc_attr( $filter ); ?>" 
        data-pagination="<?php echo esc_attr( $pagination ); ?>" 
        data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
        data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
        data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
        data-loop="<?php echo esc_attr( $loop ); ?>" 
        data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
        data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
        data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
    >
    <?php endif; ?>

        <div class="wrap-audio-posts-result">
            <?php if( $filter == 'yes') : ?>
                <div class="ovau-filter">
                    <?php ovau_get_template( 'search-form-audio.php', $args ); ?>
                    <?php if (  $total > 1 && $pagination == 'yes' ):
                        echo ovau_pagination_next_prev_ajax( $audios->found_posts, $audios->query_vars['posts_per_page'], 1 );
                    endif; ?>
                </div>
            <?php endif; ?>
            <div class="ova-audio-featured">
                <?php while ( $audios->have_posts() ) : $audios->the_post();
                    $id         = get_the_id();
                    $title      = get_the_title();
                    $src        = get_post_meta( $id, 'ovau_audio_url', true );
                    $id_player  = rand(1,1000000000000000000);
                    $episode    = get_post_meta( $id, 'ovau_episode', true );
                    $audio_link = get_post_permalink( $id );
                    $img_audio  = get_the_post_thumbnail( $id, 'podover_thumbnail', apply_filters( 'ft_ovau_thumbnail_args', array('class' => 'audio-img') ) );
                    $excerpt    = get_the_excerpt( $id );

                    // get first category from audio
                    $category_id     = get_the_terms( $id, 'category_audio' );
                    if ( $category_id && is_array( $category_id ) ) {
                        $category_name  = $category_id[0]->name;
                        $category_link  = get_term_link( $category_id[0], 'category_audio' );
                    }

                    // get host
                    $host_id           = get_post_meta( $id, 'ovau_host_id', true);
                    $host_avatar       = wp_get_attachment_image_url(get_post_thumbnail_id($host_id) , 'thumbnail' );
                    if ( $host_avatar == '') {
                        $host_avatar   =  \Elementor\Utils::get_placeholder_image_src();
                    }

                    $audio_class    = '';
                    $audio_media    = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';
                    if ( 'video' === $audio_media ) {
                        $audio_class = ' ovau-media-video';
                    }
                    $audio_type     = get_post_meta( $id, 'ovau_type', true ) ? get_post_meta( $id, 'ovau_type', true ) : 'upload_file';
                    $audio_oembed   = get_post_meta( $id, 'ovau_audio_oembed', true );
                    $audio_iframe   = get_post_meta( $id, 'ovau_audio_iframe', true );

                    $audio_date = get_the_date('m/d/Y m:i',$id);
                ?>

                <div class="item-featured<?php echo esc_attr( $audio_class ); ?>"
                    data-id="<?php echo esc_attr( $id_player ); ?>" 
                    data-title="<?php echo esc_attr( $title ); ?>" 
                    data-src="<?php echo esc_url( $src ); ?>" 
                    data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
                    data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
                    data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
                    data-loop="<?php echo esc_attr( $loop ); ?>" 
                    data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
                    data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
                    data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
                >

                    <div class="image <?php if($show_thumbnail != 'yes') echo 'no-thumbnail'; ?>">
                        <?php if($show_thumbnail == 'yes') { 
                            printf( $img_audio );
                        } ?>

                        <?php if( !empty($host_id) && $show_host == 'yes' ) : ?>
                            <a href="<?php the_permalink( $host_id );?>">
                                <img src="<?php echo esc_url( $host_avatar ); ?>" class="host-img" title="<?php echo get_the_title( $host_id ); ?>" alt="<?php echo get_the_title( $host_id ); ?>">
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="item-content">
                        <div class="episode-category">
                            <?php if( $show_episode == 'yes' ) : ?>
                                <span class="episode">
                                    <?php echo esc_html( $episode ); ?>
                                </span>
                            <?php endif; ?>
                            <?php if( !empty($seperate) ) : ?>
                                <span class="seperate">
                                    <?php echo esc_html( $seperate ); ?>
                                </span>
                            <?php endif; ?>
                            <?php if( $show_category == 'yes' ) : ?>
                                <span class="category">
                                    <a href="<?php echo esc_url( $category_link ); ?>">
                                        <?php echo esc_html( $category_name ); ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ( 'yes' === $show_title ): ?>
                            <?php if ( 'yes' === $link_title ): ?>
                                <h2 class="title">
                                    <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target_link ); ?>>
                                        <?php echo esc_html( $title ); ?>
                                    </a>
                                </h2>
                            <?php else: ?>
                                <h2 class="title">
                                    <?php echo esc_html( $title ); ?>
                                </h2>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ( !empty($play_icon) ): ?>
                        <div class="item-player">
                            <?php if ( 'oembed' === $audio_type && $audio_oembed ): ?>
                                <?php if ( 'video' === $audio_media ): ?>
                                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                    </div>
                                <?php else: ?>
                                    <?php echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, apply_filters('ft_ovau_single_oembed', array())) ); ?>
                                <?php endif; ?>
                            <?php elseif ( 'iframe' === $audio_type && $audio_iframe ): ?>
                                <?php if ( 'video' === $audio_media ): ?>
                                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                    </div>
                                <?php else: ?>
                                    <?php echo ovau_filter_oembed_result( $audio_iframe ); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ( 'video' === $audio_media ): ?>
                                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="ovau-btn-play">
                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                    </div>
                                    <div class="ovau-player-featured"></div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ( !empty($excerpt) && $show_excerpt == 'yes' ): ?>
                            <p class="excerpt">
                                <?php printf( $excerpt ); ?>
                            </p>
                        <?php endif; ?>
                        
                       <div class="btn-view-detail">
                            <?php if ( !empty($detail_label) ): ?>
                            <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target_link ); ?>>
                                <?php echo esc_html( $detail_label ); ?>
                                <i aria-hidden="true" class="ovaicon ovaicon-next-4"></i>
                            </a>
                            <?php endif; ?>

                            <?php if($time_type != 'none'): ?>
                                <span class="audio-date">
                                    <?php if($time_type == 'time_ago'):
                                        echo ovau_time_elapsed_string($audio_date, false);
                                    else:
                                       the_time($audio_date_fortmat);
                                    endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <audio id="id_<?php echo esc_attr( $id_player ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>
                </div>

                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <?php if (  $total > 1 && $pagination == 'yes' ):
                echo ovau_pagination_ajax( $audios->found_posts, $audios->query_vars['posts_per_page'], 1 );
            endif; ?>
        </div>

        <?php if( $pagination == 'yes') : ?>
            <div class="wrap_loader">
                <svg class="loader" width="50" height="50">
                    <circle cx="25" cy="25" r="10" />
                    <circle cx="25" cy="25" r="20" />
                </svg>
            </div>
        <?php endif; ?>

    <?php if( $pagination == 'yes') : ?>
    </div>
    <?php endif; ?>
<?php else : ?>
    <p class="post-not-found"><?php esc_html_e( 'Not found!' ); ?></p>
<?php endif; ?>