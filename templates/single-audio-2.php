<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

get_header( );

$id = get_the_ID();

$audio_type     = get_post_meta( $id, 'ovau_type', true ) ? get_post_meta( $id, 'ovau_type', true ) : 'upload_file';
$audio_media    = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';
$audio_oembed   = get_post_meta( $id, 'ovau_audio_oembed', true );
$audio_iframe   = get_post_meta( $id, 'ovau_audio_iframe', true );


$title          = get_the_title( $id );
$episode        = get_post_meta( $id, 'ovau_episode', true );
$host_id        = get_post_meta( $id, 'ovau_host_id', true );
$audio_src      = get_post_meta( $id, 'ovau_audio_url', true );
$audio_src_id   = get_post_meta( $id, 'ovau_audio_url_id', true );
$seperate       = esc_html__( '.', 'ovau' );
$duration       = esc_html__( '00:00', 'ovau' );
$length         = 0;
$mime_type      = 'audio/mpeg';
$width          = apply_filters( 'ft_ovau_video_width', 1290 );
$height         = apply_filters( 'ft_ovau_video_height', 647 );

$episode_timeline = get_post_meta( $id, 'ovau_episode_timeline', true );
$give_forms_id    = get_post_meta( $id, 'ovau_give_forms', true );

if ( $audio_src_id ) {
    $attachment_metadata = get_post_meta( $audio_src_id, '_wp_attachment_metadata', true );

    if ( $attachment_metadata && is_array( $attachment_metadata ) ) {
        $duration   = isset( $attachment_metadata['length_formatted'] ) ? $attachment_metadata['length_formatted'] : $duration;
        $length     = isset( $attachment_metadata['length'] ) ? $attachment_metadata['length'] : $length;
        $mime_type  = isset( $attachment_metadata['mime_type'] ) ? $attachment_metadata['mime_type'] : $mime_type;
    }
}

$audio_date_fortmat = apply_filters('ovau_audio_featured_date_format','m/d/Y');

// Filter
$loop           = apply_filters( 'ovau_single_loop', 'false' );
$skip_back      = apply_filters( 'ovau_single_skip_back', 10 );
$jump_forward   = apply_filters( 'ovau_single_jump_forward', 10 );
$start_volume   = apply_filters( 'ovau_single_start_volume_icon', '0.5' );
$play_icon      = apply_filters( 'ovau_single_play_icon', 'fas fa-play' );
$pause_icon     = apply_filters( 'ovau_single_pause_icon', 'fas fa-pause' );
$redo_icon      = apply_filters( 'ovau_single_redo_icon', 'fas fa-redo-alt' );
$skip_back_icon = apply_filters( 'ovau_single_skip_back_icon', 'fas fa-backward' );
$jump_forward_icon = apply_filters( 'ovau_single_jump_forward_icon', 'fas fa-forward' );

$ovau_self_hosted = '';
if ( 'upload_file' === $audio_type ) {
    $ovau_self_hosted = ' ovau-self-hosted';
}
if ( 'video' === $audio_media ) {
    $ovau_self_hosted = '';
}

// get host
$host_id         = get_post_meta( $id, 'ovau_host_id', true);
if( !empty($host_id) ) {
    $host_name = get_the_title( $host_id );
    $host_link = '<a href="'. get_the_permalink( $host_id ) .'">'. esc_html( $host_name ) .'</a>';
} else {
    $host_link = '';
}

// tag audio
$tag_audio = get_the_terms( $id, 'tag_audio' );

// get first category from audio
$first_category  = $first_category_link = '';
$category_id     = get_the_terms( $id, 'category_audio' );
if ( $category_id && is_array( $category_id ) ) {
    $first_category  = $category_id[0]->name;
    $first_category_link = get_term_link( $category_id[0], 'category_audio' );
}

?>

<div class="single-audio single-audio-2">

    <?php if ( $show_audio_section == 'yes' ): ?>

        <?php if ( 'oembed' === $audio_type ): ?>
            <?php if ( 'video' === $audio_media ): ?>
                <div class="row_site">
                    <div class="container_site">
                        <div class="ovau-iframe ovau-iframe-video">
                            <?php echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, array('width' => $width,'height' => $height) ) ); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row_site">
                    <div class="container_site">
                        <div class="ovau-iframe">
                            <?php echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, apply_filters('ft_ovau_single_oembed', array())) ); ?>
                        </div>
                  </div>
                </div>
            <?php endif; ?>
        <?php elseif ( 'iframe' === $audio_type ): ?>
            <?php if ( 'video' === $audio_media ): ?>
                <div class="row_site">
                    <div class="container_site">
                        <div class="ovau-iframe ovau-iframe-video">
                            <?php echo ovau_filter_oembed_result( $audio_iframe ); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                 <div class="row_site">
                    <div class="container_site">
                        <div class="ovau-iframe">
                            <?php echo ovau_filter_oembed_result( $audio_iframe ); ?>
                        </div>
                 </div>
                </div>
            <?php endif; ?>
        <?php elseif ( 'upload_file' === $audio_type && 'video' === $audio_media ): ?>
            <div class="row_site">
                <div class="container_site">
                    <div class="ovau-video">
                        <video id="ovau_video_<?php echo esc_attr( $id ); ?>" width="100%" height="auto" controls preload="metadata">
                            <source src="<?php echo esc_url( $audio_src ); ?>" type="<?php echo esc_attr( $mime_type ); ?>">
                        </video>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row_site">
                <div class="container_site">
                    <div class="ovau-single-player" 
                        data-id="<?php echo esc_attr( $id ); ?>" 
                        data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
                        data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
                        data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
                        data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
                        data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
                        data-loop="<?php echo esc_attr( $loop ); ?>" 
                        data-start-volume="<?php echo esc_attr( $start_volume ); ?>">
                        <div class="ovau-player-left">
                            <div class="btn-play">
                                <i aria-hidden="true" class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                <div class="loader">
                                    <span class="stroke"></span>
                                    <span class="stroke"></span>
                                    <span class="stroke"></span>
                                    <span class="stroke"></span>
                                    <span class="stroke"></span>
                                </div>
                            </div>
                            <div class="heading">
                                <?php if( $show_title == 'yes' ) : ?>
                                    <h2 class="title">
                                        <?php echo esc_html( $title ); ?>
                                    </h2>
                                <?php endif; ?>

                                <div class="episode-host">
                                    <?php if( !empty( $host_id ) && $show_host == 'yes' ) : ?>
                                        <a href="<?php the_permalink( $host_id );?>" class="host">
                                            <span class="label">
                                                <?php echo get_the_title( $host_id ); ?>
                                            </span>
                                        </a>
                                        <?php if( $show_episode == 'yes' || $show_duration == 'yes' ) : ?>
                                        <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if( $show_episode == 'yes' ) : ?>
                                        <span class="episode">
                                            <?php echo esc_html( $episode ); ?>
                                        </span>
                                        <?php if( $show_duration == 'yes' ) : ?>
                                        <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if( $show_duration == 'yes' ) : ?>
                                        <span class="ovau-duration" data-length="<?php echo esc_attr( $length ); ?>">
                                            <?php echo esc_html( $duration ); ?>  
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="ovau-progress">
                            <div class="skip-back">
                                <i aria-hidden="true" class="<?php echo esc_attr( $skip_back_icon ); ?>"></i>
                            </div>
                            <div class="jump-forward">
                                <i aria-hidden="true" class="<?php echo esc_attr( $jump_forward_icon ); ?>"></i>
                            </div>
                            <div class="audio-progress"></div>
                        </div>
                    </div>
             </div>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="row_site">
        <div class="container_site">

            <div class="featured-image-donation">
                <?php if( $show_image == 'yes' ) : ?>
                    <div class="featured-image">
                        <?php echo get_the_post_thumbnail( $id, 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="info">
                    <?php if( $show_category == 'yes' ) : ?>
                        <div class="category">
                            <i aria-hidde="true" class="flaticon flaticon-headphones"></i>
                            <?php if( !empty($first_category) ) : ?>
                                <a class="not-mega-link" href="<?php echo esc_url($first_category_link); ?>">
                                    <?php echo esc_html($first_category); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if( $show_title == 'yes' ) : ?>
                        <h1 class="audio-title">
                            <?php echo esc_html($title);?>
                        </h1>
                    <?php endif; ?>

                    <div class="meta">
                        <?php if( !empty($episode) && $show_episode == 'yes' ) : ?>
                            <span class="episode">
                                <?php echo esc_html($episode); ?>   
                            </span>
                        <?php endif; ?>

                        <?php if( $show_episode == 'yes' && $show_host == 'yes'  ) : ?>
                        <span class="separator"></span>
                        <?php endif; ?>

                        <?php if( !empty($host_id) && $show_host == 'yes' ) : ?>
                            <?php echo $host_link; ?>
                            
                            <?php if( $show_date == 'yes' ) : ?>
                            <span class="separator"></span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if( $show_date == 'yes' ) : ?>
                            <span class="audio-date">
                                <?php the_time($audio_date_fortmat);?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if ( $give_forms_id && $show_donation == 'yes' ): ?>
                        <div class="donation">
                            <?php echo do_shortcode('[give_form id="'. $give_forms_id .'"]'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="content-timeline-wrap timeline-donation">

                <div class="content-wrap">
                    <?php if( have_posts() ) : while ( have_posts() ) : the_post();
                            the_content();
                        endwhile; endif; wp_reset_postdata(); 
                    ?>

                    <?php if ( is_array($tag_audio) && !empty($tag_audio) && $show_tag == 'yes' ): ?>
                        <div class="audio-tags">
                            <h3 class="tag-heading"><?php esc_html_e( 'Tags', 'ovau' ); ?></h3>
                            <div class="tag-link-wrap">
                                <?php foreach ($tag_audio as $tag) {
                                    $tag_link = get_term_link($tag->term_id);
                                    $tag_name = $tag->name;
                                ?>
                                    <a class="audio-tag" href="<?php echo esc_url( $tag_link ) ?>">
                                        <?php echo esc_html( $tag_name ) ?>  
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $show_sharing == 'yes' ): ?>
                        <div class="sharing">
                            <h3 class="share-social-heading"><?php esc_html_e( 'Sharing:', 'ovau' ); ?></h3>
                            <?php apply_filters( 'ova_share_social', get_the_permalink(), get_the_title()  ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( $episode_timeline && is_array($episode_timeline) && $show_timeline == 'yes' ): ?>
                    <div class="timeline">
                        <h3 class="title-timeline">
                            <?php echo esc_html__('Episode timeline', 'ovau')  . esc_html__(':', 'ovau'); ?>
                        </h3>
                        <ul class="items">
                            <?php foreach( $episode_timeline as $timeline ): ?>
                                <li class="item" data-time="<?php echo esc_attr( $timeline['ovau_seconds'] ); ?>">
                                    <span class="control<?php echo esc_attr( $ovau_self_hosted ); ?>">
                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                    </span>
                                    <span class="duration">
                                        <?php esc_html_e( '00:00', 'ovau' ); ?>
                                    </span>
                                    <span class="description">
                                        <?php echo esc_html( $timeline['ovau_descriptions'] ); ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( $show_comment == 'yes' ): ?>
                <?php if ( comments_open() || get_comments_number() ): ?>
                    <?php comments_template(); ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
    <audio id="ovau_<?php echo esc_attr( $id ); ?>" src="<?php echo esc_url( $audio_src ); ?>"></audio>
</div>

<?php get_footer( );