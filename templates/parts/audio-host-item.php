<?php 
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( !defined( 'ABSPATH' ) ) exit();

	if ( isset( $args['id'] ) && $args['id'] ) {
		$id = $args['id'];
	} else {
		$id = get_the_id();
	}

    $template     = isset( $args['template'] ) ? $args['template'] : 'template_1' ;

	$avatar       = get_the_post_thumbnail_url( $id, 'ovau_thumbnail' );
    if ( $avatar == '') {
        $avatar   =  \Elementor\Utils::get_placeholder_image_src();
    }
    $job          = get_post_meta( $id, 'ovau_host_job', true );
    $list_social  = get_post_meta( $id, 'ovau_host_group_icon', true );

    $show_link_to = isset( $args['show_link_to_detail'] ) ? $args['show_link_to_detail'] : 'yes' ;
    $show_social  = isset( $args['show_social'] ) ? $args['show_social'] : 'yes' ;
    $show_name    = isset( $args['show_name'] ) ? $args['show_name'] : 'yes' ;
    $show_job     = isset( $args['show_job'] ) ? $args['show_job'] : 'yes' ;

?>

<div class="item-audio-host <?php echo esc_attr( $template ) ?>">

    <div class="img">
        
        <?php if( $show_link_to == 'yes' ): ?>
        <a href="<?php the_permalink();?>">
        <?php endif; ?> 
            <img src="<?php echo esc_url( $avatar ) ?>" alt="<?php the_title() ?>">
            <div class="host_img_overlay"></div>
        <?php if( $show_link_to == 'yes' ): ?>
        </a>
        <?php endif; ?> 
        
        <!-- list Icon -->
        <?php if( ( $show_social == 'yes' ) && ( !empty( $list_social ) ) ) { ?>
            <ul class="list-icon"> 
                <?php foreach( $list_social as $social ){
                    $class_icon = isset( $social['ovau_host_class_icon_social'] ) ? $social['ovau_host_class_icon_social'] : '';
                    $link_social = isset( $social['ovau_host_link_social'] ) ? $social['ovau_host_link_social'] : '';
                ?>
                    <li class="item">
                        <a href="<?php echo esc_url( $link_social ); ?>" target="_blank">
                            <i class="<?php echo esc_attr( $class_icon ) ?>"></i>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

    </div>

    <!-- Info -->
    <div class="info">
        
        <div class="name-job">
            <?php if( $show_name == 'yes' ){ ?>

            	<?php if( $show_link_to == 'yes' ): ?>
                    <a href="<?php the_permalink();?>">
                <?php endif; ?>
	                <h2 class="name">
	                    <?php the_title(); ?>   
	                </h2>
                <?php if( $show_link_to == 'yes' ): ?>
                    </a>
                <?php endif; ?>
            <?php } ?>
            

            <?php if ( !empty ($job) && $show_job == 'yes' ) : ?>
                <p class="job">
                    <?php echo esc_html($job) ; ?>
                </p>
            <?php endif; ?>
        </div>

    </div>
    
</div>