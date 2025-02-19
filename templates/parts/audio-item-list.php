<?php 
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

    $list_audio     = ovau_get_list_category_filter( $args );
    $pagination     = $args['pagination'];
    $paged          = isset( $args['paged'] ) ? $args['paged'] : 1;
    $link_title     = isset( $args['link_title'] ) ? $args['link_title'] : 'yes' ;
    $target_link    = isset( $args['target_link'] ) ? $args['target_link'] : '' ;
    $detail_label   = isset( $args['detail_label'] ) ? $args['detail_label'] : esc_html__('View Epidose', 'ovau');
    $category_link  = get_post_type_archive_link( 'ova_audio' );

    $slug           = isset( $args['slug'] ) ? $args['slug'] : '';
    $ovau_category_name = $ovau_category_link = '';
    if ( $slug ) {
        $ovau_category = get_term_by( 'slug', $slug, 'category_audio' );
        if ( $ovau_category && is_object( $ovau_category ) ) {
            $ovau_category_id   = $ovau_category->term_id;
            $ovau_category_name = $ovau_category->name;
            $ovau_category_link = get_term_link( $ovau_category_id, 'category_audio' );
        }
    }

    // Additional Options
    $play_icon      = isset( $args['play_icon'] )  ? $args['play_icon']  : 'fas fa-play';
    $pause_icon     = isset( $args['pause_icon'] ) ? $args['pause_icon'] : 'fas fa-pause';
    $loop           = ( isset( $args['loop'] ) && ( $args['loop'] == 'yes' ) ) ? true : false;
    $skip_back      = isset( $args['skip_back'] ) ? $args['skip_back'] : 15;
    $jump_forward   = isset( $args['jump_forward'] ) ? $args['jump_forward'] : 15;
    $start_volume   = isset( $args['start_volume'] ) ? $args['start_volume'] : 0.5;
?>

<?php if ( $list_audio->have_posts() ): ?>

    <?php while ( $list_audio->have_posts() ) : $list_audio->the_post(); 
        $id         = get_the_id();
        $host_id    = get_post_meta( $id, 'ovau_host_id', true);
        $title      = get_the_title();
        $src        = get_post_meta( $id, 'ovau_audio_url', true );
        $player_id  = rand(1,1000000000000000000);
        $episode    = get_post_meta( $id, 'ovau_episode', true );
        $audio_link = get_post_permalink( $id );

        $audio_class = '';
        $audio_media    = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';
        if ( 'video' === $audio_media ) {
            $audio_class = ' ovau-media-video';
        }

        $audio_type     = get_post_meta( $id, 'ovau_type', true ) ? get_post_meta( $id, 'ovau_type', true ) : 'upload_file';
        $audio_oembed   = get_post_meta( $id, 'ovau_audio_oembed', true );
        $audio_iframe   = get_post_meta( $id, 'ovau_audio_iframe', true );

        // Get list cagegory
        $terms = get_the_terms( $id, 'category_audio' );
        $category_audio = array();

        if ( $terms && is_array( $terms ) ) {
            foreach( $terms as $term ) {
                $category_url   =  get_term_link( $term->term_id, 'category_audio' );
                $category_name  =  $term->name;
                $category_link  = '<a href="'. get_term_link( $term->term_id, 'category_audio' ) .'">'. esc_html( $term->name ) .'</a>';
                array_push( $category_audio, $category_link );
            }
        }

        $html_category = join( ", ", $category_audio );

        // get host
        if( !empty($host_id) ) {
            $host_name = get_the_title( $host_id );
            $host_link = '<a href="'. get_the_permalink( $host_id ) .'">'. esc_html( $host_name ) .'</a>';
        } else {
            $host_link = '';
        }
    ?>

        <div class="item-audio-list<?php echo esc_attr( $audio_class ); ?>" 
            data-type="<?php echo esc_attr( $audio_type ); ?>" 
            data-audio-id="<?php echo esc_attr( $id ); ?>" 
            data-player-id="<?php echo esc_attr( $player_id ); ?>" 
            data-title="<?php echo esc_attr( $title ); ?>" 
            data-host= "<?php echo esc_attr( $host_link ); ?>"
            data-episode= "<?php echo esc_attr( $episode ); ?>"
            data-category="<?php echo esc_attr( $html_category ); ?>" 
            data-src="<?php echo esc_url( $src ); ?>" 
            data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
            data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
            data-loop="<?php echo esc_attr( $loop ); ?>" 
            data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
            data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
            data-start-volume="<?php echo esc_attr( $start_volume ); ?>">
            <div class="ova-controls">
                <?php if( !empty($play_icon) ) : ?>
                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
                        <div class="loader">
                            <span class="stroke"></span>
                            <span class="stroke"></span>
                            <span class="stroke"></span>
                            <span class="stroke"></span>
                            <span class="stroke"></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $show_title == 'yes' ) : ?>
                    <h2 class="title">
                        <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target_link ); ?>>
                            <?php echo esc_html( $title ); ?>
                        </a>
                    </h2>
                <?php endif; ?>
            </div>
            <div class="ovau-info">
               
                <?php if( !empty( $host_id ) && $show_host == 'yes' ) : ?>
                    <a class="host" href="<?php the_permalink( $host_id );?>">
                        <span><?php echo get_the_title( $host_id ); ?></span>
                    </a>
                <?php endif; ?>
                
                <?php if ( $episode && $show_episode == 'yes' ): ?>
                    <div class="episode">
                        <span class="label"><?php echo esc_html( $episode ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $show_category == 'yes' ): ?>
                    <div class="ovau-category">
                        <?php if ( $ovau_category_name && $ovau_category_link ): ?>
                            <a href="<?php echo esc_url( $ovau_category_link ); ?>">
                                <?php echo esc_html( $ovau_category_name ); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url( $category_url ); ?>">
                                <?php echo esc_html( $category_name ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( !empty($detail_label) ) : ?>
                    <div class="detail-link">
                        <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target_link ); ?>>
                            <?php echo esc_html( $detail_label ); ?>
                            <i aria-hidden="true" class="ovaicon ovaicon-next-4"></i>
                        </a>
                    </div>
                <?php endif; ?> 
            </div>
            <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>
        </div>

    <?php endwhile; ?>

    <?php
        $total = $list_audio->max_num_pages;
        if (  $total > 1 && 'yes' == $pagination ) {
            echo ovau_pagination_ajax( $list_audio->found_posts, $list_audio->query_vars['posts_per_page'], $paged );
        }
    ?>

<?php else: ?>
    <div class="episode-not-found"><?php esc_html_e( 'Not Found episode!', 'ovau' ); ?></div>
<?php endif; wp_reset_postdata(); ?>