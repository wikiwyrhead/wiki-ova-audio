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

    $show_link_to        = isset( $args['show_link_to_detail'] ) ? $args['show_link_to_detail'] : 'yes' ;
    $text_button         = isset( $args['text_button'] ) ? $args['text_button'] : esc_html__('Episode page', 'ovau') ;
    $class_icon          = isset( $args['class_icon']['value'] ) ? $args['class_icon']['value'] : 'flaticon flaticon-headphones';
    $class_icon_button   = isset( $args['class_icon_button']['value'] ) ? $args['class_icon_button']['value'] : 'flaticon flaticon-right-arrow-1';

    $slug               = isset( $args['slug'] ) ? $args['slug'] : '';
    $ovau_category_name = $ovau_category_link = '';
    if ( $slug ) {
        $ovau_category = get_term_by( 'slug', $slug, 'category_audio' );
        if ( $ovau_category && is_object( $ovau_category ) ) {
            $ovau_category_id   = $ovau_category->term_id;
            $ovau_category_name = $ovau_category->name;
            $ovau_category_link = get_term_link( $ovau_category_id, 'category_audio' );
        }
    }

	$thumbnail   = wp_get_attachment_image_url(get_post_thumbnail_id() , 'ovau_thumbnail' );
    if ( $thumbnail == '') {
        $thumbnail   =  \Elementor\Utils::get_placeholder_image_src();
    }
    
    $id          = get_the_id();
    $episode     = get_post_meta( $id, 'ovau_episode', true);
    $excerpt     = get_the_excerpt( $id );

    // get first category from audio
    $first_category  = $first_category_link = '';
    $category_id     = get_the_terms( $id, 'category_audio' );
    if ( $category_id && is_array( $category_id ) ) {
        $first_category  = $category_id[0]->name;
        $first_category_link   = get_term_link( $category_id[0], 'category_audio' );
    }

    // get host
    $host_id         = get_post_meta( $id, 'ovau_host_id', true);
    $host_avatar     = wp_get_attachment_image_url(get_post_thumbnail_id($host_id) , 'thumbnail' );
    if ( $host_avatar == '') {
        $host_avatar   =  \Elementor\Utils::get_placeholder_image_src();
    }

    $show_thumbnail = isset($args['show_thumbnail']) ? $args['show_thumbnail']  : 'yes';
    $show_title     = isset($args['show_title']) ? $args['show_title'] : 'yes';
    $show_host      = isset($args['show_host']) ? $args['show_host'] : 'yes';
    $show_category  = isset($args['show_category']) ? $args['show_category'] : 'yes';
    $show_episode   = isset($args['show_episode']) ? $args['show_episode'] : 'yes';
    $show_excerpt   = isset($args['show_excerpt']) ? $args['show_excerpt'] : '';

    $show_text_button = isset($args['show_text_button']) ? $args['show_text_button'] : 'yes';

?>

<div class="ovau-item-part-grid item">

    <div class="ova-media">
         
        <?php if( $show_thumbnail == 'yes' ) : ?>
            <div class="audio-img-wrapper">
                <?php if( $show_link_to == 'yes' ): ?>
                    <a class="not-mega-link" href="<?php the_permalink();?>">
                <?php endif; ?> 
                    <img src="<?php echo esc_url( $thumbnail ); ?>" class="audio-img" alt="<?php the_title(); ?>">
                <?php if( $show_link_to == 'yes' ): ?>
                    </a>
                <?php endif; ?>

                <?php if( !empty($host_id) && $show_host == 'yes' ) : ?>
                    <a class="not-mega-link" href="<?php the_permalink( $host_id );?>">
                        <img src="<?php echo esc_url( $host_avatar ); ?>" class="host-img" title="<?php echo get_the_title( $host_id ); ?>" alt="<?php echo get_the_title( $host_id ); ?>">
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="content">
                
            <?php if( !empty($host_id) && $show_host == 'yes' && $show_thumbnail != 'yes' ) : ?>
                <a class="not-mega-link" href="<?php the_permalink( $host_id );?>">
                    <img src="<?php echo esc_url( $host_avatar ); ?>" class="host-img" title="<?php echo get_the_title( $host_id ); ?>" alt="<?php echo get_the_title( $host_id ); ?>">
                </a>
            <?php endif; ?>

            <?php if( !empty($first_category) && $show_category == 'yes' ) : ?>
                <?php if( !empty($class_icon) ) : ?>
                    <div class="icon">
                        <i class="<?php echo esc_attr( $class_icon ); ?>"></i>
                    </div>
                <?php endif; ?>
                <span class="category">
                    <?php if ( $ovau_category_name && $ovau_category_link ): ?>
                        <a class="not-mega-link" href="<?php echo esc_url( $ovau_category_link ); ?>">
                            <?php echo esc_html( $ovau_category_name ); ?>
                        </a>
                    <?php else: ?>
                        <a class="not-mega-link" href="<?php echo esc_url($first_category_link); ?>">
                            <?php echo esc_html($first_category); ?>
                        </a>
                    <?php endif; ?>
                </span>
            <?php endif; ?>

            <?php if( !empty($episode) && $show_episode == 'yes' ) : ?>
                <span class="episode <?php if($show_category != 'yes' || empty($first_category)) echo 'no-separator'; ?>">
                    <?php echo esc_html($episode); ?>   
                </span>
            <?php endif; ?>

            <?php if( $show_title == 'yes' ): ?>
                <?php if( $show_link_to == 'yes' ): ?>
                <a class="not-mega-link" href="<?php the_permalink();?>">
                <?php endif; ?> 

                    <h3 class="title">
                        <?php the_title(); ?>
                    </h3>

                <?php if( $show_link_to == 'yes' ): ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( 'yes' === $show_excerpt ): ?>
                <p class="excerpt">
                    <?php printf( $excerpt ); ?>
                </p>
            <?php endif; ?>

            <?php if ( !empty($text_button) && $show_text_button == 'yes' ): ?>
                <?php if( $show_link_to == 'yes' ): ?>
                    <a class="audio-button" href="<?php the_permalink();?>">
                        <?php echo esc_html( $text_button ) ; ?>
                        <i class="<?php echo esc_attr( $class_icon_button ); ?>"></i>
                    </a>
                <?php else: ?>
                    <span class="audio-button">
                        <?php echo esc_html( $text_button ) ; ?>
                        <i class="<?php echo esc_attr( $class_icon_button ); ?>"></i>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
            
        </div>

    </div>

</div>