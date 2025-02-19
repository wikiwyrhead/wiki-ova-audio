<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$category       = isset($args['category']) ? $args['category'] : 'all';
$category_name  = esc_html__( 'All', 'ovau' );
$category_link  = get_post_type_archive_link( 'ova_audio' );
$img_url        = isset($args['image']['url']) && $args['image']['url'] ? $args['image']['url'] : '';
$img_alt        = isset($args['image']['alt']) && $args['image']['alt'] ? $args['image']['alt'] : esc_html__( 'Image', 'ovau' );
$title          = $args['title'];
$custom_link    = $args['custom_link'];
$btn_label      = $args['btn_label'];
$btn_link       = $args['btn_link']['url'];
$target         = $args['btn_link']['is_external'] ? ' target="_blank"' : '';

$link_title     = isset($args['link_title']) ? $args['link_title'] : '' ;
$target_title   = (isset($args['target_title']) && 'yes' === $args['target_title']) ? ' target="_blank"' : '';
$show_title_au  = isset($args['show_title']) ? $args['show_title'] : 'yes';

$show_host    = isset($args['show_host']) ? $args['show_host'] : '' ;
$show_episode = isset($args['show_episode']) ? $args['show_episode'] : '' ;

// Additional Options
$play_icon      = $args['play_icon'] ? $args['play_icon']['value'] : 'fas fa-play';
$pause_icon     = $args['pause_icon'] ? $args['pause_icon']['value'] : 'fas fa-pause';
$loop           = $args['loop'] === 'yes' ? 'true' : 'false';
$skip_back      = $args['skip_back'] ? $args['skip_back'] : 15;
$jump_forward   = $args['jump_forward'] ? $args['jump_forward'] : 15;
$start_volume   = $args['start_volume'] ? $args['start_volume'] : 0;

// Category
$show_category  = isset($args['show_category']) ? $args['show_category'] : 'yes';

if ( $category && 'all' != $category ) {
    $term = get_term_by( 'slug', $category, 'category_audio' );

    if ( $term && is_object( $term ) ) {
        $category_name = $term->name;
        $category_link = get_term_link(  $term->term_id );
    }
}

$audios = ovau_get_audio_by_category( $args );

?>

<!-- Audio Category -->
<?php if ( $audios->have_posts() ) : ?>
    <div class="ova-audio-category">
        
        <?php if( !empty($img_url) || $show_category == 'yes') : ?>
            <div class="ova-img">
                <?php if( !empty($img_url) ) : ?>
                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
                <?php endif; ?>
                <?php if( $show_category == 'yes' ) : ?>
                    <div class="category-name">
                        <?php echo esc_html( $category_name ); ?>
                    </div>
                <?php endif; ?>
            </div>
         <?php endif; ?>

        <?php if ( $title ): ?>
            <h2 class="title">
                <?php echo esc_html( $title ); ?>
            </h2>
        <?php endif; ?>

        <ul class="items">
            <?php while ( $audios->have_posts() ) : $audios->the_post();
                $id         = get_the_id();
                $host_id    = get_post_meta( $id, 'ovau_host_id', true);
                $title_au   = get_the_title();
                $src        = get_post_meta( $id, 'ovau_audio_url', true );
                $player_id  = rand(1,1000000000000000000);
                $episode    = get_post_meta( $id, 'ovau_episode', true );
                $audio_url  = get_post_permalink( $id );

                $audio_class = '';
                $audio_media = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';
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
                        $category_url  =  get_term_link( $term->term_id, 'category_audio' );
                        $category_link = '<a href="'. get_term_link( $term->term_id, 'category_audio' ) .'">'. esc_html( $term->name ) .'</a>';
                        array_push( $category_audio, $category_link );
                    }
                }

                $html_category = join( ", ", $category_audio );
                
                // Get host
                if( !empty($host_id) ) {
                    $host_name = get_the_title( $host_id );
                    $host_link = '<a href="'. get_the_permalink( $host_id ) .'">'. esc_html( $host_name ) .'</a>';
                } else {
                    $host_link = '';
                }
            ?>

            <li class="ovau-item-category<?php echo esc_attr( $audio_class ); ?>" 
                data-type="<?php echo esc_attr( $audio_type ); ?>" 
                data-audio-id="<?php echo esc_attr( $id ); ?>" 
                data-player-id="<?php echo esc_attr( $player_id ); ?>" 
                data-title="<?php echo esc_attr( $title_au ); ?>" 
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
                <?php if(!empty($play_icon)) : ?>
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
                    <?php if( !empty( $host_id ) && $show_host == 'yes' ) : ?>
                        <a class="label" href="<?php the_permalink( $host_id );?>">
                            <span><?php echo get_the_title( $host_id ); ?></span>
                            <span class="separator label"><?php esc_html_e('.', 'ovau'); ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ( $episode && $show_episode == 'yes' ): ?>
                        <span class="label"><?php echo esc_html( $episode ); ?></span>
                    <?php endif; ?>

                    <?php if( $show_title_au == 'yes' ) : ?>
                        <?php if ( 'yes' === $link_title ): ?>
                            <h2 class="title">
                                <a href="<?php echo esc_url( $audio_url ); ?>"<?php printf( $target_title ); ?>>
                                    <?php echo esc_html( $title_au ); ?>
                                </a>
                            </h2>
                        <?php else: ?>
                            <h2 class="title"><?php echo esc_html( $title_au ); ?></h2>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <audio id="id_<?php echo esc_attr( $player_id ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>
            </li>

            <?php endwhile; wp_reset_postdata(); ?>
        </ul>
        <?php if ( $btn_label ): ?>
            <div class="view-all">
                <?php if ( 'yes' === $custom_link ): ?>
                    <a href="<?php echo esc_url( $btn_link ); ?>"<?php printf( $target ); ?>>
                        <?php echo esc_html( $btn_label ); ?>
                        <i aria-hidden="true" class="ovaicon ovaicon-next-4"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo esc_url( $category_url ); ?>">
                        <?php echo esc_html( $btn_label ); ?>
                        <i aria-hidden="true" class="ovaicon ovaicon-next-4"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <p class="post-not-found"><?php esc_html_e( 'Not found!', 'ovau' ); ?></p>
<?php endif; ?>