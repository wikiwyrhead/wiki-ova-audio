<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

// Additional Options
$auto_next      = $args['auto_next'];
$play_icon      = $args['play_icon'] ? $args['play_icon']['value'] : 'fas fa-play';
$pause_icon     = $args['pause_icon'] ? $args['pause_icon']['value'] : 'fas fa-pause';
$redo_icon      = $args['redo_icon'] ? $args['redo_icon']['value'] : 'fas fa-redo-alt';
$skip_back      = $args['skip_back'] ? $args['skip_back'] : 15;
$jump_forward   = $args['jump_forward'] ? $args['jump_forward'] : 15;
$start_volume   = $args['start_volume'] ? $args['start_volume'] : 0;

$link_title     = isset($args['link_title']) ? $args['link_title'] : '';
$target         = (isset($args['target']) && 'yes' === $args['target']) ? ' target="_blank"' : '';
$duration       = esc_html__( '00:00', 'ovau' );
$length         = 0;

$show_host      = $args['show_host'];
$seperate       = $args['seperate'];

$first_audios = $second_audios = array();

$audios = ovau_get_audio_podcast( $args );

# Flag
$i = 0;

if ( $audios->have_posts() ) {
    while ( $audios->have_posts() ) {
        $audios->the_post();

        $arr_audio  = array();

        $id         = get_the_id();
        $title      = get_the_title();
        $src        = get_post_meta( $id, 'ovau_audio_url', true );
        $id_player  = rand(1,1000000000000000000);
        $episode    = get_post_meta( $id, 'ovau_episode', true );
        $audio_link = get_post_permalink( $id );

        $audio_class = '';
        $audio_media = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';
        if ( 'video' === $audio_media ) {
            $audio_class = ' ovau-media-video';
        }

        // Host
        $host_id    = get_post_meta( $id, 'ovau_host_id', true );
        $host_name  = $host_link = '';
        if ( $host_id ) {
            $host_name = get_the_title( $host_id );
            $host_link = get_permalink( $host_id );
        }

        // Image
        $img_id   = get_post_thumbnail_id( $id );
        $img_url  = get_the_post_thumbnail_url( $id, 'full' );
        $img_alt  = $title;

        if ( !$img_url ) {
            $img_url = \Elementor\Utils::get_placeholder_image_src();
        }

        if ( $img_id ) {
            $img_alt = get_post_meta( $img_id , '_wp_attachment_image_alt', true );
        }

        if ( !$img_alt ) {
            $img_alt = $title;
        }

        $file_id    = get_post_meta( $id, 'ovau_audio_url_id', true );

        if ( $file_id ) {
            $attachment_metadata = get_post_meta( $file_id, '_wp_attachment_metadata', true );

            if ( $attachment_metadata && is_array( $attachment_metadata ) ) {
                $duration   = isset( $attachment_metadata['length_formatted'] ) ? $attachment_metadata['length_formatted'] : $duration;
                $length     = isset( $attachment_metadata['length'] ) ? $attachment_metadata['length'] : $length;
            }
        }

        if ( 0 === $i ) {
            $first_audios['id']         = $id;
            $first_audios['index']      = $i;
            $first_audios['title']      = $title;
            $first_audios['src']        = $src;
            $first_audios['id_player']  = $id_player;
            $first_audios['episode']    = $episode;
            $first_audios['link']       = $audio_link;
            $first_audios['img_url']    = $img_url;
            $first_audios['img_alt']    = $img_alt;
            $first_audios['duration']   = $duration;
            $first_audios['length']     = $length;
            $first_audios['type_media'] = $audio_media;
            $first_audios['class']      = $audio_class;

            $arr_audio['id']        = $id;
            $arr_audio['is_first']  = 'yes';
            $arr_audio['index']     = $i;
            $arr_audio['title']     = $title;
            $arr_audio['src']       = $src;
            $arr_audio['id_player'] = $id_player;
            $arr_audio['episode']   = $episode;
            $arr_audio['host_link'] = $host_link;
            $arr_audio['host_name'] = $host_name;
            $arr_audio['link']      = $audio_link;
            $arr_audio['img_url']   = $img_url;
            $arr_audio['img_alt']   = $img_alt;
            $arr_audio['duration']  = $duration;
            $arr_audio['length']    = $length;
            $arr_audio['type_media'] = $audio_media;
            $arr_audio['class']      = $audio_class;
            array_push( $second_audios, $arr_audio );
        } else {
            $arr_audio['id']        = $id;
            $arr_audio['is_first']  = 'no';
            $arr_audio['index']     = $i;
            $arr_audio['title']     = $title;
            $arr_audio['src']       = $src;
            $arr_audio['id_player'] = $id_player;
            $arr_audio['episode']   = $episode;
            $arr_audio['host_link'] = $host_link;
            $arr_audio['host_name'] = $host_name;
            $arr_audio['link']      = $audio_link;
            $arr_audio['img_url']   = $img_url;
            $arr_audio['img_alt']   = $img_alt;
            $arr_audio['duration']  = $duration;
            $arr_audio['length']    = $length;
            $arr_audio['type_media'] = $audio_media;
            $arr_audio['class']      = $audio_class;
            array_push( $second_audios, $arr_audio );
        }

        $i++;
    }
    wp_reset_postdata();
}

?>
<!-- Audio List -->
<?php if ( $first_audios ) : ?>
    <div class="ova-audio-podcast" 
        data-auto-next="<?php echo esc_attr( $auto_next ); ?>" 
        data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
        data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
        data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
        data-start-volume="<?php echo esc_attr( $start_volume ); ?>" 
        data-link-title="<?php echo esc_attr( $link_title ); ?>" 
    >
        <div class="ovau-podcast-play<?php echo esc_attr( $first_audios['class'] ); ?>" 
            data-id="<?php echo esc_attr( $first_audios['id_player'] ); ?>" 
            data-index="<?php echo esc_attr( $first_audios['index'] ); ?>" 
            data-title="<?php echo esc_attr( $first_audios['title'] ); ?>" 
            data-episode="<?php echo esc_attr( $first_audios['episode'] ); ?>" 
            data-src="<?php echo esc_url( $first_audios['src'] ); ?>"
        >   
            <?php if ( 'yes' === $show_thumbnail ): ?>
                <div class="img-podcast">
                    <img src="<?php echo esc_url( $first_audios['img_url'] ); ?>" alt="<?php echo esc_attr( $first_audios['img_alt'] ); ?>">
                </div>
            <?php endif; ?>

            <div class="ovau-container">
                <?php if ( 'yes' === $show_title ): ?>
                    <h2 class="title">
                        <?php if ( 'yes' === $link_title ): ?>
                            <a href="<?php echo esc_url( $first_audios['link'] ); ?>"<?php printf( $target ); ?>>
                                <?php echo esc_html( $first_audios['title'] ); ?>
                            </a>
                        <?php else: ?>
                            <?php echo esc_html( $first_audios['title'] ); ?>
                        <?php endif; ?>
                    </h2>
                 <?php endif; ?>

                <div class="episode">
                    <?php if ( 'yes' === $show_host && $host_name && $host_link ): ?>
                        <span class="ovau-host">
                            <a href="<?php echo esc_url( $host_link ); ?>"<?php printf( $target ); ?>>
                                <?php echo esc_html( $host_name ); ?>
                            </a>
                        </span>
                        <?php if ( $seperate ): ?>
                            <span class="seperate-host"><?php echo esc_html( $seperate, 'ovau' ); ?></span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( 'yes' === $show_episode ): ?>
                        <span class="label">
                            <?php echo esc_html( $first_audios['episode'] ); ?>   
                        </span>
                    <?php endif; ?>
                </div>

                <?php if( !empty($play_icon)) :?>
                    <div class="ovau-podcast">
                        <div class="control-icon" data-id="<?php echo esc_attr( $first_audios['id'] ); ?>">
                            <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                        </div>
                        <div class="ovau-podcast-player"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ( $second_audios ): ?>
            <ul class="ovau-podcast-list">
                <?php foreach( $second_audios as $k => $podcast ): 
                    $is_first = 'yes' === $podcast['is_first'] ? ' is-first' : '';
                ?>
                    <li class="item-podcast podcast-id-<?php echo esc_attr( $k ); ?><?php echo esc_attr( $podcast['class'] ); ?>" 
                        data-id="<?php echo esc_attr( $podcast['id_player'] ); ?>" 
                        data-index="<?php echo esc_attr( $podcast['index'] ); ?>" 
                        data-title="<?php echo esc_attr( $podcast['title'] ); ?>" 
                        data-link="<?php echo esc_attr( $podcast['link'] ); ?>" 
                        data-episode="<?php echo esc_attr( $podcast['episode'] ); ?>" 
                        data-host-name="<?php echo esc_attr( $podcast['host_name'] ); ?>" 
                        data-host-link="<?php echo esc_attr( $podcast['host_link'] ); ?>" 
                        data-src="<?php echo esc_url( $podcast['src'] ); ?>" 
                        data-thumbnail="<?php echo esc_url( $podcast['img_url'] ); ?>" 
                        data-alt="<?php echo esc_url( $podcast['img_alt'] ); ?>" 
                    >
                        <div class="podcast-left">
                            <?php if( !empty($play_icon)) :?>
                                <div class="play-icon<?php echo esc_attr( $is_first ); ?>" data-id="<?php echo esc_attr( $podcast['id'] ); ?>" >
                                    <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                                </div>
                            <?php endif; ?>

                            <?php if ( 'yes' === $show_title ): ?>
                                <h2 class="title">
                                    <?php if ( 'yes' === $link_title ): ?>
                                        <a href="<?php echo esc_url( $podcast['link'] ); ?>"<?php printf( $target ); ?>>
                                            <?php echo esc_html( $podcast['title'] ); ?>
                                        </a>
                                    <?php else: ?>
                                        <?php echo esc_html( $podcast['title'] ); ?>
                                    <?php endif; ?>
                                </h2>
                            <?php endif; ?>
                        </div>
                        <div class="podcast-right">
                            <?php if ( 'video' != $podcast['type_media'] && $show_duration == 'yes' ): ?>
                                <div class="duration" data-lenght="<?php echo esc_attr( $podcast['length'] ); ?>">
                                    <?php echo esc_html( $podcast['duration'] ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( $show_download == 'yes' ): ?>
                            <div class="podcast-download">
                                <a href="<?php echo esc_url( $podcast['src'] ); ?>" download>
                                    <i aria-hidden="true" class="fas fa-download"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <audio id="id_<?php echo esc_attr( $first_audios['id_player'] ); ?>" src="<?php echo esc_url( $first_audios['src'] ); ?>"></audio>
    </div>
<?php else : ?>
    <p class="post-not-found"><?php esc_html_e( 'Not found!' ); ?></p>
<?php endif; ?>