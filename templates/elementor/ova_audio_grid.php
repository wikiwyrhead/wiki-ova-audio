<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

$column = $args['column'] ? $args['column'] : 'three_column';

$audios = ovau_get_data_audio_el($args);

?>

<!-- Audio Grid -->
<?php if ( $audios->have_posts() ) : ?>
    <div class="ova-audio-grid archive_audio_grid_content <?php echo esc_attr($column);?>">
        <?php while ( $audios->have_posts() ) : $audios->the_post();
            ovau_get_template( 'parts/audio-item-grid.php', $args );
        endwhile; wp_reset_postdata(); ?>
    </div>
<?php else : ?>
    <p class="post-not-found"><?php esc_html_e( 'Not found!' ); ?></p>
<?php endif; ?>