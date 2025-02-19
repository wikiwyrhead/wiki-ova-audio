<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$audio_hosts   = ovau_get_data_audio_host_el( $args );

?>

<div class="ova-audio-host">      

    <div class="content <?php echo esc_attr( $number_column ) ?>">

        <?php if($audio_hosts->have_posts() ) : while ( $audio_hosts->have_posts() ) : $audio_hosts->the_post();
            
            ovau_get_template( 'parts/audio-host-item.php', $args );

        endwhile; endif; wp_reset_postdata(); ?>

    </div>

</div>