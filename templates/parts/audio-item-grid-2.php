<?php 
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( !defined( 'ABSPATH' ) ) exit();

	if ( isset( $args['id'] ) && $args['id'] ) {
		$id = $args['id'];
	} else {
		$id = get_the_id();
	}

    // Additional Options Audio Play 
    $loop           = ( isset( $args['loop'] ) && ( $args['loop']  === 'yes' ) ) ? 'true' : 'false';
    $skip_back      = isset( $args['skip_back'] ) ? $args['skip_back'] : 15;
    $jump_forward   = isset( $args['jump_forward'] ) ? $args['jump_forward'] : 15;
    $start_volume   = isset( $args['start_volume'] ) ? $args['start_volume'] : 0.5;
    $play_icon      = isset( $args['play_icon']['value'] ) ? $args['play_icon']['value'] : 'fas fa-play';
    $pause_icon     = isset( $args['pause_icon']['value'] ) ? $args['pause_icon']['value'] : 'fas fa-pause';

    $show_link_to   = isset( $args['show_link_to_detail'] ) ? $args['show_link_to_detail'] : 'yes' ;
    $class_icon     = isset( $args['class_icon']['value'] ) ? $args['class_icon']['value'] : 'flaticon flaticon-headphones';

    $show_thumbnail = isset($args['show_thumbnail']) ? $args['show_thumbnail'] : 'yes';
    $show_host      = isset($args['show_host'])      ? $args['show_host']     : 'yes';
    $show_category  = isset($args['show_category'])  ? $args['show_category'] : 'yes';
    $show_episode   = isset($args['show_category'])  ? $args['show_category'] : 'yes';
    $show_title     = isset($args['show_title'])     ? $args['show_title']    : 'yes';
    $show_date      = isset($args['show_date'])      ? $args['show_date']     : 'yes';
    $show_excerpt   = isset($args['show_excerpt'])   ? $args['show_excerpt']  : '';
    $show_comment   = isset($args['show_comment'])   ? $args['show_comment']  : 'yes';
    $show_duration  = isset($args['show_duration'])  ? $args['show_duration'] : 'yes';

    $replace_date_by_cate = isset($args['replace_date_by_cate']) ? $args['replace_date_by_cate'] : '';

    $time_type = isset($args['time_type']) ? $args['time_type'] : 'default';
      
    $audio_date         = get_the_date('m/d/Y m:i',$id);
    $audio_date_fortmat = apply_filters('ovau_audio_item_grid_date_format','m/d');

	$thumbnail   = wp_get_attachment_image_url(get_post_thumbnail_id() , 'podover_thumbnail' );
    if ( $thumbnail == '') {
        $thumbnail   =  \Elementor\Utils::get_placeholder_image_src();
    }
    $player_id   = rand(1,1000000000000000000);
    $title       = get_the_title();
    $episode     = get_post_meta( $id, 'ovau_episode', true);
    $src         = get_post_meta( $id, 'ovau_audio_url', true );
    $excerpt     = get_the_excerpt( $id );

    // get first category from audio
    $first_category  = $first_category_link = '';
    $category_id     = get_the_terms( $id, 'category_audio' );
    if ( $category_id && is_array( $category_id ) ) {
        $first_category  = $category_id[0]->name;
        $first_category_link  = get_term_link( $category_id[0], 'category_audio' );
    }

    // Get list cagegory (for audio play)
    $terms = get_the_terms( $id, 'category_audio' );
    $category_audio = array();

    if ( $terms && is_array( $terms ) ) {
        foreach( $terms as $term ) {
            $category_link = '<a href="'. get_term_link( $term->term_id, 'category_audio' ) .'">'. esc_html( $term->name ) .'</a>';
            array_push( $category_audio, $category_link );
        }
    }

    $html_category = join( ", ", $category_audio );

    // get host
    $host_id         = get_post_meta( $id, 'ovau_host_id', true);
    $host_avatar     = wp_get_attachment_image_url(get_post_thumbnail_id($host_id) , 'thumbnail' );
    if ( $host_avatar == '') {
        $host_avatar   =  \Elementor\Utils::get_placeholder_image_src();
    }
    if( !empty($host_id) ) {
        $host_name = get_the_title( $host_id );
        $host_link = '<a href="'. get_the_permalink( $host_id ) .'">'. esc_html( $host_name ) .'</a>';
    } else {
        $host_link = '';
    }

    $audio_class    = '';
    $audio_media    = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';

    if ( 'video' === $audio_media ) {
        $audio_class = ' ovau-media-video';
    }

    $audio_type     = get_post_meta( $id, 'ovau_type', true ) ? get_post_meta( $id, 'ovau_type', true ) : 'upload_file';
    $audio_oembed   = get_post_meta( $id, 'ovau_audio_oembed', true );
    $audio_iframe   = get_post_meta( $id, 'ovau_audio_iframe', true );

    // audio duration times
    $file_id    = get_post_meta( $id, 'ovau_audio_url_id', true );
    $text_min   = esc_html__( ' min', 'ovau' );
    $duration   = 0 . $text_min;

      if ( $file_id ) {
        $attachment_metadata = get_post_meta( $file_id, '_wp_attachment_metadata', true );

        if ( $attachment_metadata && is_array( $attachment_metadata ) ) {
            $duration   = isset( $attachment_metadata['length_formatted'] ) ? $attachment_metadata['length_formatted'].$text_min : $duration;
        }
    }

?>

<div class="ovau-item-part-grid-2 item">

    <div class="ova-media<?php echo esc_attr( $audio_class ); ?>"
        data-type="<?php echo esc_attr( $audio_type ); ?>" 
        data-audio-id="<?php echo esc_attr( $id ); ?>" 
        data-player-id="<?php echo esc_attr( $player_id ); ?>" 
        data-title="<?php echo esc_attr( $title ); ?>" 
        data-category="<?php echo esc_attr( $html_category ); ?>" 
        data-host= "<?php echo esc_attr( $host_link ); ?>"
        data-episode= "<?php echo esc_attr( $episode ); ?>" 
        data-src="<?php echo esc_url( $src ); ?>" 
        data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
        data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
        data-loop="<?php echo esc_attr( $loop ); ?>" 
        data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
        data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
        data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
    >

        <?php if( $show_thumbnail == 'yes' ) : ?>
            <div class="audio-img-wrapper">
                <?php if( $show_link_to == 'yes' ): ?>
                    <a class="not-mega-link" href="<?php the_permalink();?>">
                <?php endif; ?> 
                    <img src="<?php echo esc_url( $thumbnail ); ?>" class="audio-img" alt="<?php the_title(); ?>">
                <?php if( $show_link_to == 'yes' ): ?>
                    </a>
                <?php endif; ?>

                <?php if( !empty($host_id) && $show_host == 'yes' ) : ?>
                    <a class="not-mega-link" href="<?php the_permalink( $host_id );?>">
                        <img src="<?php echo esc_url( $host_avatar ); ?>" class="host-img" title="<?php echo get_the_title( $host_id ); ?>" alt="<?php echo get_the_title( $host_id ); ?>">
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="content">
            <?php if( !empty($host_id) && $show_host == 'yes' && $show_thumbnail != 'yes' ) : ?>
                <a class="not-mega-link" href="<?php the_permalink( $host_id );?>">
                    <img src="<?php echo esc_url( $host_avatar ); ?>" class="host-img" title="<?php echo get_the_title( $host_id ); ?>" alt="<?php echo get_the_title( $host_id ); ?>">
                </a>
            <?php endif; ?>

            <?php if( $replace_date_by_cate != 'yes' ) : ?>
                <?php if( !empty($class_icon) ) : ?>
                    <div class="icon">
                        <i class="<?php echo esc_attr( $class_icon ); ?>"></i>
                    </div>
                <?php endif; ?>
                <?php if( !empty($first_category) && $show_category == 'yes' ) : ?>
                    <span class="category">
                        <a class="not-mega-link" href="<?php echo esc_url($first_category_link); ?>">
                            <?php echo esc_html($first_category); ?>
                        </a>
                    </span>
                <?php endif; ?>
                <?php if( !empty($episode) && $show_episode == 'yes' ) : ?>
                    <span class="episode <?php if($show_category != 'yes') echo 'no-separator'; ?>">
                        <?php echo esc_html($episode); ?>   
                    </span>
                <?php endif; ?>
            <?php endif; ?>

            <?php if( $show_title == 'yes' ): ?>

                <?php if( $show_link_to == 'yes' ): ?>
                <a class="not-mega-link" href="<?php the_permalink();?>">
                <?php endif; ?> 
                    <h3 class="title">
                        <?php the_title(); ?>
                    </h3>
                <?php if( $show_link_to == 'yes' ): ?>
                    </a>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ( 'yes' === $show_excerpt ): ?>
                <p class="excerpt">
                    <?php printf( $excerpt ); ?>
                </p>
            <?php endif; ?>

            <div class="audio-meta-wrap">
                <div class="left-meta">
                    <?php if( $replace_date_by_cate == 'yes' ) : ?>
                        <?php if( !empty($class_icon) ) : ?>
                            <div class="icon">
                                <i class="<?php echo esc_attr( $class_icon ); ?>"></i>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty($first_category) ) : ?>
                            <span class="category">
                                <a class="not-mega-link" href="<?php echo esc_url($first_category_link); ?>">
                                    <?php echo esc_html($first_category); ?>
                                </a>
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if( $show_date == 'yes' ){ ?>
                            <span class="audio-date">
                                <?php if($time_type == 'time_ago'):
                                    echo ovau_time_elapsed_string($audio_date, false);
                                else:
                                   the_time($audio_date_fortmat);
                                endif; ?>
                            </span>
                        <?php } ?>
                    <?php endif; ?>
                </div>
                <div class="right-meta">
                    <?php if( $show_comment == 'yes' ){ ?>
                        <span class="item-meta comment">
                            <i aria-hidden="true" class="ovaicon ovaicon-comment-1"></i>
                            <?php
                                comments_popup_link(
                                    esc_html__(' 0', 'ovau'), 
                                    esc_html__(' 01', 'ovau'), 
                                    ' % Comments',
                                    '',
                                    esc_html__( 'Comment off', 'ovau' ) 
                                ); 
                            ?>             
                        </span>
                    <?php } ?>
                    <?php if( $show_duration == 'yes' ){ ?>
                        <span class="item-meta duration">
                            <i aria-hidden="true" class="ovaicon ovaicon-stopwatch"></i>
                            <?php echo esc_html( $duration ); ?>    
                        </span>
                    <?php } ?>
                    
                    <?php if( !empty($play_icon) ){ ?>
                        <div class="ovau-btn-play audio-button" data-id="<?php echo esc_attr( $id ); ?>">
                            <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                            <div class="loader">
                                <span class="stroke"></span>
                                <span class="stroke"></span>
                                <span class="stroke"></span>
                                <span class="stroke"></span>
                                <span class="stroke"></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>

    </div>

</div>