<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$audio_hosts   = ovau_get_data_audio_host_el( $args );

$data_options['items']              = isset( $args['item_number'] ) ? $args['item_number'] : 3 ;
$data_options['slideBy']            = isset( $args['slides_to_scroll'] ) ? $args['slides_to_scroll'] : 1 ;
$data_options['margin']             = isset( $args['margin_items'] ) ? $args['margin_items'] : 30 ;
$data_options['autoplayTimeout']    = isset( $args['autoplay_speed'] ) ? $args['autoplay_speed'] : 3000;
$data_options['smartSpeed']         = isset( $args['smartspeed'] ) ? $args['smartspeed'] : 500;
$data_options['stagePadding']       = isset( $args['stagePadding'] ) ? $args['stagePadding'] : 0 ;
$data_options['autoplayHoverPause'] = $args['pause_on_hover'] === 'yes' ? true : false;
$data_options['loop']               = $args['infinite'] === 'yes' ? true : false;
$data_options['autoplay']           = $args['autoplay'] === 'yes' ? true : false;
$data_options['dots']               = $args['dot_control'] === 'yes' ? true : false;
$data_options['rtl']                = is_rtl() ? true : false;

?>

<div class="ova-audio-host-slider">      

    <div class="content slide-audio-host owl-carousel owl-theme" data-options="<?php echo esc_attr(json_encode($data_options)); ?>">

        <?php if($audio_hosts->have_posts() ) : while ( $audio_hosts->have_posts() ) : $audio_hosts->the_post();

            ovau_get_template( 'parts/audio-host-item.php', $args );
            
        endwhile; endif; wp_reset_postdata(); ?>

    </div>

</div>