<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$id = get_the_id();

$categories     = ovau_get_category_filter( $args );
$target_link    = ( isset( $args['target_link'] ) && 'yes' === $args['target_link'] ) ? ' target="_blank"' : '';
$play_icon      = isset($args['play_icon']['value'])  ? $args['play_icon']['value'] : 'fas fa-play';
$pause_icon     = isset($args['pause_icon']['value']) ? $args['pause_icon']['value'] : 'fas fa-pause';
$redo_icon      = isset($args['redo_icon']['value'])  ? $args['redo_icon']['value'] : 'fas fa-redo-alt';
$loop           = isset($args['loop']) === 'yes' ? 'true' : 'false';
$skip_back      = isset($args['skip_back']) ? $args['skip_back'] : 15;
$jump_forward   = isset($args['jump_forward']) ? $args['jump_forward'] : 15;
$start_volume   = isset($args['start_volume']) ? $args['start_volume'] : 0.5;

?>

<!-- Audio Category Filter -->
<div class="ova-audio-category-filter ova-audio-category-filter-2"
    data-per-page="<?php echo esc_attr( $posts_per_page ); ?>" 
    data-order_by="<?php echo esc_attr( $order_by ); ?>" 
    data-order="<?php echo esc_attr( $order ); ?>" 
    data-category-not-in="<?php echo esc_attr( $category_not_in ); ?>" 
    data-show-thumbnail="<?php echo esc_attr( $show_thumbnail ); ?>" 
    data-show-title="<?php echo esc_attr( $show_title ); ?>" 
    data-show-host="<?php echo esc_attr( $show_host ); ?>" 
    data-show-episode="<?php echo esc_attr( $show_episode ); ?>" 
    data-show-category="<?php echo esc_attr( $show_category ); ?>" 
    data-show-pagination="<?php echo esc_attr( $pagination ); ?>" 
    data-target="<?php echo esc_attr( $target_link ); ?>" 
    data-detail-label="<?php echo esc_attr( $detail_label ); ?>" 
    data-layout="2"
    data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
    data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
    data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
    data-loop="<?php echo esc_attr( $loop ); ?>" 
    data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
    data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
    data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
>
    <?php if ( $categories && is_array( $categories ) ): ?>
        <ul class="audio-categories">
            <?php foreach( $categories as $k => $data_category ): 
                $active = ( 0 == $k ) ? ' audio-active' : '';
                $slug   = $data_category['slug'];
                $name   = $data_category['name'];
            ?>
                <li class="audio-category<?php echo esc_attr( $active ); ?>" data-slug="<?php echo esc_attr( $slug ); ?>">
                    <?php echo esc_html( $name ); ?>
                    <?php if ( $active ): ?>
                        <i aria-hidden="true" class="ovaicon ovaicon-minus"></i>
                    <?php else: ?>
                        <i aria-hidden="true" class="ovaicon ovaicon-plus"></i>
                    <?php endif; ?>
                </li>
                <?php if ( $active ): ?>
                    <div class="audio-container-mobile"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- ajax reponse html -->
    <div class="audio-container">
        
    </div>

    <div class="wrap_loader">
        <svg class="loader" width="50" height="50">
            <circle cx="25" cy="25" r="10" />
            <circle cx="25" cy="25" r="20" />
        </svg>
    </div>
</div>
