<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

get_header();

$number_column = get_theme_mod( 'ovau_host_column_layout', 'three_column' );

?>

    <div class="row_site">
        <div class="container_site">

            <div class="ova-audio-host archive-audio-host">
                
                <div class="content <?php echo esc_attr( $number_column ) ?>">

                    <?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                       
                        <?php ovau_get_template( 'parts/audio-host-item.php' ); ?>

                    <?php endwhile; endif; wp_reset_postdata(); ?>
                </div>

            </div>
        </div>
    </div>

    <?php 
        $args = array(
            'type'      => 'list',
            'next_text' => '<i class="ovaicon ovaicon-next"></i>',
            'prev_text' => '<i class="ovaicon ovaicon-back"></i>',
        );

        the_posts_pagination($args);
    ?>

<?php get_footer();