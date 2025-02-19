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
    $category_link  = get_post_type_archive_link( 'ova_audio' );

    $args['text_button'] = $args['detail_label'];
?>

<?php if ( $list_audio->have_posts() ): ?>

    <?php while ( $list_audio->have_posts() ) : $list_audio->the_post(); 
        $id         = get_the_id();
        $host_id    = get_post_meta( $id, 'ovau_host_id', true);
        $title      = get_the_title();
        $src        = get_post_meta( $id, 'ovau_audio_url', true );
        $id_audio   = rand(1,1000000000000000000);
        $episode    = get_post_meta( $id, 'ovau_episode', true );
        $audio_link = get_post_permalink( $id );

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

        <?php ovau_get_template( 'parts/audio-item-grid.php', $args ); ?>

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