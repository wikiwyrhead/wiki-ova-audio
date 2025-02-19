<?php
	/**
	 * @package    OVA Audio by ovatheme
	 * @author     Ovatheme
	 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
	 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
	 */
	if ( !defined( 'ABSPATH' ) ) exit();
    
    // Additional Options Slide
    $data_options['items']              = isset( $args['item_number'] ) ? $args['item_number'] : 3 ;
	$data_options['slideBy']            = isset( $args['slides_to_scroll'] ) ? $args['slides_to_scroll'] : 1 ;
	$data_options['margin']             = isset( $args['margin_items'] ) ? $args['margin_items'] : 30 ;
	$data_options['autoplayTimeout']    = isset( $args['autoplay_speed'] ) ? $args['autoplay_speed'] : 3000;
	$data_options['smartSpeed']         = isset( $args['smartspeed'] ) ? $args['smartspeed'] : 500;
	$data_options['stagePadding']       = isset( $args['stagePadding'] ) ? $args['stagePadding'] : 0 ;
	$data_options['autoplayHoverPause'] = $args['pause_on_hover'] === 'yes' ? true : false;
	$data_options['loop']               = $args['infinite'] === 'yes' ? true : false;
	$data_options['autoplay']           = $args['autoplay'] === 'yes' ? true : false;
	$data_options['nav']                = $args['nav_control'] === 'yes' ? true : false;
	$data_options['dots']               = $args['dot_control'] === 'yes' ? true : false;
	$data_options['rtl']                = is_rtl() ? true : false;

	$data_options['iconPrev']           = isset( $args['class_icon_prev_control']['value'] )  ? $args['class_icon_prev_control']['value'] : 'flaticon flaticon-left-arrow-1';
	$data_options['iconNext']           = isset( $args['class_icon_next_control']['value'] )  ? $args['class_icon_next_control']['value'] : 'flaticon flaticon-right-arrow-1';

	$include_ids	  = isset( $args['include_ids'] ) ? $args['include_ids'] : [];
	$total_categories = isset( $args['total_categories'] ) ? $args['total_categories'] : 6;

	$show_title   	  = isset( $args['show_title'] ) ? $args['show_title'] : 'yes';
	$show_thumbnail   = isset( $args['show_thumbnail'] ) ? $args['show_thumbnail'] : 'yes';

	// get data
	$taxonomy 	= "category_audio";
	$args_cat   = array(
		'number' => $total_categories, 
		'order' => 'ASC', 
		'orderby' => 'slug', 
		'hide_empty' => true
	);

	if( !empty($include_ids) ) {
		$args_cat['include'] = $include_ids;
	}

	$terms = get_terms( $taxonomy, $args_cat );

?>

<div class="ova-audio-categories-slider">
	<div class="slide-audio-categories owl-carousel owl-theme" data-options="<?php echo esc_attr(json_encode($data_options)) ?>">
		<?php foreach ($terms as $term) :
			$placeholder_image_url = OVAU_PLUGIN_URL . 'assets/img/woocommerce-placeholder-600x600.png';

			$thumbnail_id 	= get_term_meta($term->term_id, 'audio_cat_thumbnail_id', true);
			$thumbnail_url 	= wp_get_attachment_url($thumbnail_id) ? wp_get_attachment_url($thumbnail_id) : $placeholder_image_url;
			$name  			= $term->name;
			$link 			= get_term_link( $term->term_id, $taxonomy );
		?>
			<div class="item">
				<?php if ($show_title == 'yes') : ?>
					<a href="<?php echo esc_url( $link ); ?>" >
						<h4 class="cat-title">
							<?php echo esc_html($name); ?>
						</h4>
					</a>
				<?php endif; ?>
				<?php if ($show_thumbnail == 'yes') : ?>
					<a href="<?php echo esc_url( $link ); ?>" >
						<div class="image-thumbnail">
							<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_html($name); ?>">
						</div>
					</a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>