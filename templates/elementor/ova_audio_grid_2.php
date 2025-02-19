<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$pagination = isset($args['show_pagination']) ? $args['show_pagination']  : 'no';

$audios = ovau_get_data_audio_el( $args );

?>

<!-- Audio Grid -->
<?php if ( $audios->have_posts() ) : ?>
    <?php if( $pagination == 'yes') : ?>
    <div class="ova-audio-grid-has-ajax" style="position: relative;"
        data-column="<?php echo esc_attr( $column ); ?>" 
        data-per_page="<?php echo esc_attr( $total_posts ); ?>" 
        data-orderby="<?php echo esc_attr( $orderby ); ?>" 
        data-order="<?php echo esc_attr( $order ); ?>" 
        data-categories="<?php echo esc_attr( json_encode($categories) ); ?>" 
        data-class_icon="<?php echo esc_attr( json_encode($class_icon) ); ?>"
        data-time_type="<?php echo esc_attr( $time_type ); ?>" 
        data-replace_date_by_cate="<?php echo esc_attr( $replace_date_by_cate ); ?>"
        data-show_thumbnail="<?php echo esc_attr( $show_thumbnail ); ?>"
        data-show_title="<?php echo esc_attr( $show_title ); ?>"
        data-show_host="<?php echo esc_attr( $show_host ); ?>"
        data-show_category="<?php echo esc_attr( $show_category ); ?>"
        data-show_episode="<?php echo esc_attr( $show_episode ); ?>"
        data-show_excerpt="<?php echo esc_attr( $show_excerpt ); ?>"
        data-show_date="<?php echo esc_attr( $show_date ); ?>"
        data-show_comment="<?php echo esc_attr( $show_comment ); ?>"
        data-show_duration="<?php echo esc_attr( $show_duration ); ?>"
        data-show_link_to_detail="<?php echo esc_attr( $show_link_to_detail ); ?>"
        data-pagination="<?php echo esc_attr( $pagination ); ?>" 
        data-play-icon="<?php echo esc_attr( json_encode($play_icon) ); ?>" 
        data-pause-icon="<?php echo esc_attr( json_encode($pause_icon) ); ?>" 
        data-loop="<?php echo esc_attr( $loop ); ?>" 
        data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
        data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
        data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
    >
    <?php endif; ?>

        <div class="wrap-audio-posts-result">

            <div class="ova-audio-grid-2 archive_audio_grid_content <?php echo esc_attr($column);?>">
                <?php while ( $audios->have_posts() ) : $audios->the_post();
                    ovau_get_template( 'parts/audio-item-grid-2.php', $args );
                endwhile; wp_reset_postdata(); ?>
            </div>

            <?php $total = $audios->max_num_pages; $paged = 1;
                if (  $total > 1 && $pagination == 'yes' ):
                    echo ovau_pagination_ajax( $audios->found_posts, $audios->query_vars['posts_per_page'], $paged );
            endif; ?>

        </div>

        <?php if( $pagination == 'yes') : ?>
            <div class="wrap_loader">
                <svg class="loader" width="50" height="50">
                    <circle cx="25" cy="25" r="10" />
                    <circle cx="25" cy="25" r="20" />
                </svg>
            </div>
        <?php endif; ?>

    <?php if( $pagination == 'yes') : ?>
    </div>
    <?php endif; ?>

<?php else : ?>
    <p class="post-not-found"><?php esc_html_e( 'Not found!' ); ?></p>
<?php endif; ?>