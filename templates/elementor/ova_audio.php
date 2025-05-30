<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$id         = rand(1,1000000000000000000);
$audio_id   = $args['audio_id'];
$audio_type = $audio_oembed = $audio_iframe = $audio_media = $audio_class = '';
$title      = $args['title'];
$episode    = $args['episode'];
$seperate   = $args['seperate'];
$play_icon  = $args['play_icon'] ? $args['play_icon']['value'] : 'fas fa-play';
$pause_icon = $args['pause_icon'] ? $args['pause_icon']['value'] : 'fas fa-pause';
$redo_icon  = $args['redo_icon'] ? $args['redo_icon']['value'] : 'fas fa-redo-alt';
$loop       = $args['loop'] === 'yes' ? 'true' : 'false';
$skip_back      = $args['skip_back'] ? $args['skip_back'] : 15;
$jump_forward   = $args['jump_forward'] ? $args['jump_forward'] : 15;
$start_volume   = $args['start_volume'] ? $args['start_volume'] : 0;
$custom_audio   = $args['custom_audio'];
$src = $host_id = '';
$duration   = esc_html__( '00:00', 'ovau' );
$length     = 0;

$link_title = $args['link_title'];
$custom_url = $args['custom_url']['url'];
$target     = $args['custom_url']['is_external'] ? ' target="_blank"' : '';

if ( 'yes' === $custom_audio ) {
    $src = isset( $args['src']['url'] ) ? $args['src']['url'] : '';
    $file_id = isset( $args['src']['id'] ) ? $args['src']['id'] : '';

    if ( $file_id ) {
        $attachment_metadata = get_post_meta( $file_id, '_wp_attachment_metadata', true );

        if ( $attachment_metadata && is_array( $attachment_metadata ) ) {
            $duration   = isset( $attachment_metadata['length_formatted'] ) ? $attachment_metadata['length_formatted'] : $duration;
            $length     = isset( $attachment_metadata['length'] ) ? $attachment_metadata['length'] : $length;
        }
    }
} else {
    $audio_media    = get_post_meta( $audio_id, 'ovau_media', true ) ? get_post_meta( $audio_id, 'ovau_media', true ) : 'audio';
    if ( 'video' === $audio_media ) {
        $audio_class = ' ovau-media-video';
    }
    $audio_type     = get_post_meta( $audio_id, 'ovau_type', true ) ? get_post_meta( $audio_id, 'ovau_type', true ) : 'upload_file';
    $audio_oembed   = get_post_meta( $audio_id, 'ovau_audio_oembed', true );
    $audio_iframe   = get_post_meta( $audio_id, 'ovau_audio_iframe', true );

    $src        = get_post_meta( $audio_id, 'ovau_audio_url', true );
    $file_id    = get_post_meta( $audio_id, 'ovau_audio_url_id', true );
    $title      = get_the_title( $audio_id );
    $episode    = get_post_meta( $audio_id, 'ovau_episode', true );
    $seperate   = esc_html__( '.', 'ovau' );
    $host_id    = get_post_meta( $audio_id, 'ovau_host_id', true);

    if ( !$custom_url ) {
        $custom_url = get_post_permalink( $audio_id );
    }

    if ( $file_id ) {
        $attachment_metadata = get_post_meta( $file_id, '_wp_attachment_metadata', true );

        if ( $attachment_metadata && is_array( $attachment_metadata ) ) {
            $duration   = isset( $attachment_metadata['length_formatted'] ) ? $attachment_metadata['length_formatted'] : $duration;
            $length     = isset( $attachment_metadata['length'] ) ? $attachment_metadata['length'] : $length;
        }
    }
}

$show_title    = isset($args['show_title']) ? $args['show_title'] : 'yes';
$show_host     = isset($args['show_host']) ? $args['show_host'] : 'yes';
$show_episode  = isset($args['show_episode']) ? $args['show_episode'] : 'yes';
$show_duration = isset($args['show_duration']) ? $args['show_duration'] : 'yes';

?>

<?php if ( 'oembed' === $audio_type && $audio_oembed ): ?>
    <div class="ovau-audio<?php echo esc_attr( $audio_class ); ?>">
        <?php if ( 'video' === $audio_media ): ?>
            <div class="ovau-player-left">
                <?php if( !empty( $play_icon )) : ?>
                    <div class="control-icon" data-id="<?php echo esc_attr( $audio_id ); ?>">
                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                    </div>
                <?php endif; ?>
               
                <div class="title">
                    <?php if ( $show_title == 'yes' ): ?>
                        <?php if ( 'yes' === $link_title && $custom_url ): ?>
                            <h2>
                                <a href="<?php echo esc_url( $custom_url ); ?>"<?php printf( $target ); ?>>
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>
                        <?php else: ?>
                            <h2><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ( $episode || $host_id ): ?>
                        <div class="episode">
                            <?php if( $show_host == 'yes' && !empty( $host_id )) : ?>
                                <a href="<?php the_permalink( $host_id );?>">
                                    <span class="label"><?php echo get_the_title( $host_id ); ?></span>
                                </a>
                                <?php if( $show_episode == 'yes' ) { ?>
                                <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                <?php } ?>
                            <?php endif; ?>
                            
                            <?php if( $show_episode == 'yes' ) { ?>
                                <span class="label"><?php echo esc_html( $episode ); ?></span>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <?php echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, apply_filters('ft_ovau_single_oembed', array())) ); ?>
        <?php endif; ?>
    </div>
<?php elseif ( 'iframe' === $audio_type && $audio_iframe ): ?>
    <div class="ovau-audio<?php echo esc_attr( $audio_class ); ?>">
        <?php if ( 'video' === $audio_media ): ?>
            <div class="ovau-player-left">
                <?php if( !empty( $play_icon )) : ?>
                    <div class="control-icon" data-id="<?php echo esc_attr( $audio_id ); ?>">
                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                    </div>
                <?php endif; ?>

                <div class="title">
                    <?php if ( $show_title == 'yes' ): ?>
                        <?php if ( 'yes' === $link_title && $custom_url ): ?>
                            <h2>
                                <a href="<?php echo esc_url( $custom_url ); ?>"<?php printf( $target ); ?>>
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>
                        <?php else: ?>
                            <h2><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ( $episode || $host_id ): ?>
                        <div class="episode">
                            <?php if( $show_host == 'yes' && !empty( $host_id )) : ?>
                                <a href="<?php the_permalink( $host_id );?>">
                                    <span class="label"><?php echo get_the_title( $host_id ); ?></span>
                                </a>
                                <?php if( $show_episode == 'yes' ) { ?>
                                <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                <?php } ?>
                            <?php endif; ?>
                            
                            <?php if( $show_episode == 'yes' ) { ?>
                                <span class="label"><?php echo esc_html( $episode ); ?></span>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <?php echo ovau_filter_oembed_result( $audio_iframe ); ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?php if ( $src && 'video' != $audio_media ): ?>
        <div class="ovau-audio" 
            data-id="<?php echo esc_attr( $id ); ?>" 
            data-title="<?php echo esc_attr( $title ); ?>" 
            data-src="<?php echo esc_url( $src ); ?>" 
            data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
            data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
            data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
            data-loop="<?php echo esc_attr( $loop ); ?>" 
            data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
            data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
            data-start-volume="<?php echo esc_attr( $start_volume ); ?>">

            <div class="ovau-player-left">
                <?php if( !empty( $play_icon )) : ?>
                    <div class="control-icon">
                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                    </div>
                <?php endif; ?>

                <div class="title">
                    <?php if ( $show_title == 'yes' ): ?>
                        <?php if ( 'yes' === $link_title && $custom_url ): ?>
                            <h2>
                                <a href="<?php echo esc_url( $custom_url ); ?>"<?php printf( $target ); ?>>
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>
                        <?php else: ?>
                            <h2><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ( $episode || $host_id ): ?>
                        <div class="episode">
                            <?php if( $show_host == 'yes' && !empty( $host_id )) : ?>
                                <a href="<?php the_permalink( $host_id );?>">
                                    <span class="label"><?php echo get_the_title( $host_id ); ?></span>
                                </a>
                                <?php if( $show_episode == 'yes' ) { ?>
                                <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                <?php } ?>
                            <?php endif; ?>
                            
                            <?php if( $show_episode == 'yes' ) { ?>
                                <span class="label"><?php echo esc_html( $episode ); ?></span>
                                <?php if( $show_duration == 'yes' ) { ?>
                                <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                <?php } ?>
                            <?php } ?>
                            <?php if( $show_duration == 'yes' ) { ?>
                                <span class="ovau-duration" data-length="<?php echo esc_attr( $length ); ?>">
                                    <?php echo esc_html( $duration ); ?>
                                </span>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="ovau-player-right">
                <div id="ovau-player-1" class="ovau-player"></div>
            </div>

            <audio id="id_<?php echo esc_attr( $id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>
        </div>
    <?php else: ?>
        <div class="ovau-audio<?php echo esc_attr( $audio_class ); ?>">
            <div class="ovau-player-left">
                <?php if( !empty( $play_icon )) : ?>
                    <div class="control-icon" data-id="<?php echo esc_attr( $audio_id ); ?>">
                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                    </div>
                <?php endif; ?>
             
                <div class="title">
                    <?php if ( $show_title == 'yes' ): ?>
                        <?php if ( 'yes' === $link_title && $custom_url ): ?>
                            <h2>
                                <a href="<?php echo esc_url( $custom_url ); ?>"<?php printf( $target ); ?>>
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>
                        <?php else: ?>
                            <h2><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ( $episode || $host_id ): ?>
                        <div class="episode">
                            <?php if( $show_host == 'yes' && !empty( $host_id )) : ?>
                                <a href="<?php the_permalink( $host_id );?>">
                                    <span class="label"><?php echo get_the_title( $host_id ); ?></span>
                                </a>
                                <?php if( $show_episode == 'yes' ) { ?>
                                <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                                <?php } ?>
                            <?php endif; ?>
                            
                            <?php if( $show_episode == 'yes' ) { ?>
                                <span class="label"><?php echo esc_html( $episode ); ?></span>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>