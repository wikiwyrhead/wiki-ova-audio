<?php 
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( !defined( 'ABSPATH' ) ) exit();
    
    $audio_id = $args['audio_id'];

    // Additional Options Audio Play 
    $loop           = ( isset( $args['loop'] ) && ( $args['loop']  === 'yes' ) ) ? 'true' : 'false';
    $skip_back      = isset( $args['skip_back'] ) ? $args['skip_back'] : 15;
    $jump_forward   = isset( $args['jump_forward'] ) ? $args['jump_forward'] : 15;
    $start_volume   = isset( $args['start_volume'] ) ? $args['start_volume'] : 0.5;
    $play_icon      = isset( $args['play_icon']['value'] ) ? $args['play_icon']['value'] : 'fas fa-play';
    $pause_icon     = isset( $args['pause_icon']['value'] ) ? $args['pause_icon']['value'] : 'fas fa-pause';

    $text_button    = isset( $args['text_button'] ) ? $args['text_button'] : esc_html__('Start Listening', 'ovau');

    $player_id   = rand(1,1000000000000000000);
    $title       = get_the_title($audio_id);
    $episode     = get_post_meta( $audio_id, 'ovau_episode', true);
    $src         = get_post_meta( $audio_id, 'ovau_audio_url', true );

    // Get list cagegory
    $terms = get_the_terms( $audio_id, 'category_audio' );
    $category_audio = array();

    if ( $terms && is_array( $terms ) ) {
        foreach( $terms as $term ) {
            $category_link = '<a href="'. get_term_link( $term->term_id, 'category_audio' ) .'">'. esc_html( $term->name ) .'</a>';
            array_push( $category_audio, $category_link );
        }
    }

    $html_category = join( ", ", $category_audio );

    // get host
    $host_id         = get_post_meta( $audio_id, 'ovau_host_id', true);
    if( !empty($host_id) ) {
        $host_name = get_the_title( $host_id );
        $host_link = '<a href="'. get_the_permalink( $host_id ) .'">'. esc_html( $host_name ) .'</a>';
    } else {
        $host_link = '';
    }

    $audio_class    = '';
    $audio_media    = get_post_meta( $audio_id, 'ovau_media', true ) ? get_post_meta( $audio_id, 'ovau_media', true ) : 'audio';

    if ( 'video' === $audio_media ) {
        $audio_class = ' ovau-media-video';
    }

    $audio_type     = get_post_meta( $audio_id, 'ovau_type', true ) ? get_post_meta( $audio_id, 'ovau_type', true ) : 'upload_file';
    $audio_oembed   = get_post_meta( $audio_id, 'ovau_audio_oembed', true );
    $audio_iframe   = get_post_meta( $audio_id, 'ovau_audio_iframe', true );

?>

<div class="ovau-play-button ova-audio-slider-3">

    <div class="ova-media<?php echo esc_attr( $audio_class ); ?>"
        data-type="<?php echo esc_attr( $audio_type ); ?>" 
        data-audio-id="<?php echo esc_attr( $audio_id ); ?>" 
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

        <div class="icon ovau-btn-play" data-id="<?php echo esc_attr( $audio_id ); ?>">
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
            

        <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>

    </div>

</div>