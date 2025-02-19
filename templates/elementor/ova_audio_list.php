<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$total_posts    = $args['total_posts'] ? $args['total_posts'] : apply_filters( 'el_ova_audio_list_total_posts', 5 );
$categories     = $args['categories'] ? $args['categories'] : array();
$order          = $args['order'] ? $args['order'] : 'ASC';
$orderby        = $args['orderby'] ? $args['orderby'] : 'ovau_order';

// Additional Options
$seperate       = $args['seperate'];
$play_icon      = $args['play_icon'] ? $args['play_icon']['value'] : 'fas fa-play';
$pause_icon     = $args['pause_icon'] ? $args['pause_icon']['value'] : 'fas fa-pause';
$loop           = $args['loop'] === 'yes' ? 'true' : 'false';
$skip_back      = $args['skip_back'] ? $args['skip_back'] : 15;
$jump_forward   = $args['jump_forward'] ? $args['jump_forward'] : 15;
$start_volume   = $args['start_volume'] ? $args['start_volume'] : 0;

$link_title     = $args['link_title'];
$target         = 'yes' === $args['target'] ? ' target="_blank"' : '';

// Base Query
$base_query = array(
    'post_type'         => 'ova_audio',
    'post_status'       => 'publish',
    'posts_per_page'    => $total_posts,
    'order'             => $order,
    'fields'            => 'ids'
);

// Order by
if ( 'ovau_order' === $orderby ) {
    $base_query['orderby']      = 'meta_value_num';
    $base_query['meta_type']    = 'NUMERIC';
    $base_query['meta_key']     = 'ovau_order';
} else {
    $base_query['orderby']      = $orderby;
}

// Category
if ( !empty( $categories ) && is_array( $categories ) ) {
    $base_query['tax_query'] = array(
        array(
            'taxonomy' => 'category_audio',
            'field'    => 'slug',
            'terms'    => $categories,
        ),
    );
}

$audios = new \WP_Query( $base_query );

?>
<!-- Audio List -->
<?php if ( $audios->have_posts() ) : ?>
    <div class="ova-audio-list">
        <?php while ( $audios->have_posts() ) : $audios->the_post();
            $id         = get_the_id();
            $host_id    = get_post_meta( $id, 'ovau_host_id', true);
            $title      = get_the_title();
            $src        = get_post_meta( $id, 'ovau_audio_url', true );
            $player_id  = rand(1,1000000000000000000);
            $episode    = get_post_meta( $id, 'ovau_episode', true );
            $audio_link = get_post_permalink( $id );

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
            <div class="item-audio<?php echo esc_attr( $audio_class ); ?>" 
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
                data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
            >
                <?php if ( !empty($play_icon) ): ?>
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
                <div class="ovau-content">
                    <div class="episode">
                        <?php if ( $show_host === 'yes' ): ?>
                            <a class="ovau-host" href="<?php the_permalink( $host_id );?>">
                                <span class="label"><?php echo get_the_title( $host_id ); ?></span>
                            </a>
                            <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                        <?php endif; ?>
                        <?php if ( $show_episode === 'yes' ): ?>
                            <span class="label"><?php echo esc_html( $episode ); ?></span>
                        <?php endif; ?>
                        <?php if ( !empty($category_audio) && $show_category === 'yes' ): ?>
                            <?php if ( $show_episode === 'yes' ): ?>
                             <span class="seperate"><?php echo esc_html( $seperate ); ?></span>
                            <?php endif; ?>
                            <span class="ovau-categories"><?php echo join( ", ", $category_audio ); ?></span>   
                        <?php endif; ?>
                    </div>
                    <?php if ( 'yes' === $show_title ): ?>
                        <?php if ( 'yes' === $link_title ): ?>
                            <h2 class="title">
                                <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target ); ?>>
                                    <?php echo esc_html( $title ); ?>
                                </a>
                            </h2>
                        <?php else: ?>
                            <h2 class="title"><?php echo esc_html( $title ); ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
<?php else : ?>
    <p class="post-not-found"><?php esc_html_e( 'Not found!' ); ?></p>
<?php endif; ?>