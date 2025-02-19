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
    $text_button    = isset( $args['text_button'] ) ? $args['text_button'] : esc_html__('Listen Now!', 'ovau');
    $column         = isset( $args['column'] ) ? $args['column'] : 'three_column';

	$thumbnail   = wp_get_attachment_image_url(get_post_thumbnail_id() , 'ovau_thumbnail' );
    if ( $thumbnail == '') {
        $thumbnail   =  \Elementor\Utils::get_placeholder_image_src();
    }
    $player_id   = rand(1,1000000000000000000);
    $title       = get_the_title();
    $episode     = get_post_meta( $id, 'ovau_episode', true);
    $src         = get_post_meta( $id, 'ovau_audio_url', true );

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

    $show_thumbnail = isset($args['show_thumbnail']) ? $args['show_thumbnail'] : 'yes';
    $show_title     = isset($args['show_title']) ? $args['show_title'] : 'yes';
    $show_host      = isset($args['show_host']) ? $args['show_host'] : 'yes';

?>

<div class="ovau-item-part-grid-player item <?php echo esc_attr($column);?>">

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
                </div>
            <?php else: ?> 
                <div class="spacing"></div>
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

            <?php if( !empty($text_button) ): ?>
                <?php if( $show_link_to == 'yes' ): ?>
                    <a class="audio-button" href="<?php the_permalink();?>">
                        <?php echo esc_html( $text_button ) ; ?>
                    </a>
                <?php else: ?>
                    <span class="audio-button">
                        <?php echo esc_html( $text_button ) ; ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>

    </div>

</div>