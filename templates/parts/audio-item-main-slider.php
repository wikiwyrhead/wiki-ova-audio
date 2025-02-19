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
    $text_button    = isset( $args['text_button'] ) ? $args['text_button'] : esc_html__('Start Listening', 'ovau');
    $column         = isset( $args['column'] )      ? $args['column'] : 'three_column';

	$thumbnail   = wp_get_attachment_image_url(get_post_thumbnail_id() , 'podover_thumbnail' );
    if ( $thumbnail == '') {
        $thumbnail   =  \Elementor\Utils::get_placeholder_image_src();
    }
    $player_id   = rand(1,1000000000000000000);
    $title       = get_the_title();
    $episode     = get_post_meta( $id, 'ovau_episode', true);
    $src         = get_post_meta( $id, 'ovau_audio_url', true );
    $excerpt     = get_the_excerpt( $id );

    $audio_date  = get_the_date('m/d/Y m:i',$id);
    $audio_date_fortmat = apply_filters('ovau_audio_featured_date_format','m/d/Y');

    // Get list cagegory
    $terms = get_the_terms( $id, 'category_audio' );
    $category_audio = array();

    if ( $terms && is_array( $terms ) ) {
        foreach( $terms as $term ) {
            $category_link = '<a href="'. get_term_link( $term->term_id, 'category_audio' ) .'">'. esc_html( $term->name ) .'</a>';
            array_push( $category_audio, $category_link );
        }
    }

    $html_category = join( ", ", $category_audio );

    // get first category from audio
    $first_category  = $first_category_link = '';
    $category_id     = get_the_terms( $id, 'category_audio' );
    if ( $category_id && is_array( $category_id ) ) {
        $first_category  = $category_id[0]->name;
        $first_category_link   = get_term_link( $category_id[0], 'category_audio' );
    }

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

?>

<div class="ovau-item-part-main-slider item <?php echo esc_attr($column);?>">

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
        
        <div class="audio-img-wrapper">
            <?php if( $show_link_to == 'yes' ): ?>
                <a class="not-mega-link" href="<?php the_permalink();?>">
            <?php endif; ?> 
                <img src="<?php echo esc_url( $thumbnail ); ?>" class="audio-img" alt="<?php the_title(); ?>">
            <?php if( $show_link_to == 'yes' ): ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="content">

            <?php if( !empty($first_category) && $show_category == 'yes' ) : ?>
                <div class="category">
                    <?php if( !empty($class_icon) ) : ?>
                        <i class="<?php echo esc_attr( $class_icon ); ?>"></i>
                    <?php endif; ?>
                    <a class="not-mega-link" href="<?php echo esc_url($first_category_link); ?>">
                        <?php echo esc_html($first_category); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if( $show_title == 'yes' ): ?>
                <?php if( $show_link_to == 'yes' ): ?>
                <a class="not-mega-link" href="<?php the_permalink();?>">
                <?php endif; ?> 

                    <h3 class="title">
                        <?php the_title() ?>
                    </h3>

                <?php if( $show_link_to == 'yes' ): ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <div class="epidose-time-ago">
                <?php if( !empty($episode) && $show_episode == 'yes' ) : ?>
                    <span class="episode">
                        <?php echo esc_html($episode); ?>   
                    </span>
                <?php endif; ?>

                <?php if( $show_episode == 'yes' && $time_type != 'none'  ) : ?>
                    <span class="separator"></span>
                <?php endif; ?>

                <?php if($time_type != 'none'): ?>
                    <span class="time-ago">
                        <?php if($time_type == 'time_ago'):
                            echo ovau_time_elapsed_string($audio_date, false);
                        else:
                           the_time($audio_date_fortmat);
                        endif; ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if( $show_excerpt == 'yes' ): ?>
                <p class="excerpt">
                    <?php printf( $excerpt ); ?>
                </p>
            <?php endif; ?>

            <?php if( !empty($play_icon) ): ?>
                <div class="icon ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
                    <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                    <div class="loader">
                        <span class="stroke"></span>
                        <span class="stroke"></span>
                        <span class="stroke"></span>
                        <span class="stroke"></span>
                        <span class="stroke"></span>
                    </div>
                    <span class="text_button">
                        <?php echo esc_html( $text_button ) ; ?>
                    </span>
                </div>
            <?php endif; ?>
            
        </div>
        <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>

    </div>

</div>