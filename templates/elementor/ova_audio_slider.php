<?php
	/**
	 * @package    OVA Audio by ovatheme
	 * @author     Ovatheme
	 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
	 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
	 */
	if ( !defined( 'ABSPATH' ) ) exit();

    $text_button  = isset( $args['text_button'] ) 		  ? $args['text_button'] 		 : esc_html__('Episode page', 'ovau') ;
    $show_link_to = isset( $args['show_link_to_detail'] ) ? $args['show_link_to_detail'] : 'yes' ;

    $get_related_audio_by_id = isset( $args['get_related_audio_by_id'] ) ? $args['get_related_audio_by_id'] : 'no';

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

	// Related audio when slider in audio single page
	if ( $get_related_audio_by_id == "yes" ) {
		$single_audio_id = '';

		if( is_singular( 'ova_audio' ) ) {
			$single_audio_id = get_the_id();
		}

		if( !empty($single_audio_id) ) {
			$single_category = get_the_terms( $single_audio_id, 'category_audio' );
			$single_cat_slug = array();   
			if( $single_category && is_array($single_category) ) {
				foreach ( $single_category as $single_cat){
				   array_push($single_cat_slug,$single_cat->slug);
				}
				if( !empty($single_cat_slug) ) {
					$args['category'] = $single_cat_slug;
				}
			} 
			$args['exclude_ids'] = $single_audio_id;
		}
	}

	$audios = ovau_get_data_audio_slider_el( $args );

?>

<div class="ova-audio-slider">

	<div class="content slide-audio owl-carousel owl-theme" data-options="<?php echo esc_attr(json_encode($data_options)); ?>">

		<?php if( $audios->have_posts() ) : while ( $audios->have_posts() ) : $audios->the_post(); ?>

			<div class="item">
				<?php 
                    $thumbnail   = wp_get_attachment_image_url(get_post_thumbnail_id() , 'ovau_thumbnail' );
                    if ( $thumbnail == '') {
				        $thumbnail   =  \Elementor\Utils::get_placeholder_image_src();
					}
					
					$id              = get_the_id();
					$episode         = get_post_meta( $id, 'ovau_episode', true);
					// get first category from audio
					$first_category  = isset( wp_get_post_terms( $id, 'category_audio' )[0]->name ) ? wp_get_post_terms( $id, 'category_audio' )[0]->name : '';
					$first_term_id 	 = isset( wp_get_post_terms( $id, 'category_audio' )[0]->term_id ) ? wp_get_post_terms( $id, 'category_audio' )[0]->term_id : '';
				    $category_id     = get_the_terms( $id, 'category_audio' );  
				    $category_link   = get_term_link( $first_term_id, 'category_audio' );
				    // get host
				    $host_id         = get_post_meta( $id, 'ovau_host_id', true);
				    $host_avatar     = wp_get_attachment_image_url(get_post_thumbnail_id($host_id) , 'thumbnail' );
				    if ( $host_avatar == '') {
				        $host_avatar   =  \Elementor\Utils::get_placeholder_image_src();
					}
				?>

				<div class="ova-media <?php if( $show_thumbnail != 'yes' ) echo 'no-thumbnail';?>">
       				
       				<?php if( $show_thumbnail == 'yes' ): ?>
						<div class="audio-img-wrapper">
							<?php if( $show_link_to == 'yes' ): ?>
						        <a class="not-mega-link link-full-height" href="<?php the_permalink();?>">
							<?php endif; ?>	
							    <img class="audio-img" src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
							<?php if( $show_link_to == 'yes' ): ?>
								</a>
							<?php endif; ?>

							<?php if( !empty($host_id) && $show_host == 'yes' ) : ?>
								<a class="not-mega-link" href="<?php the_permalink( $host_id );?>" title="<?php echo get_the_title( $host_id ); ?>">
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

				    	<?php if( !empty( $first_category ) && $show_category == 'yes' ) : ?>
					    	<span class="category">
								<a class="not-mega-link" href="<?php echo esc_url($category_link); ?>">
									<?php echo esc_html($first_category); ?>
								</a>
							</span>
						<?php endif; ?>

						<?php if( !empty($episode) && $show_episode == 'yes' ) : ?>
							<span class="episode <?php if($show_category != 'yes') echo 'no-separator'; ?>">
								<?php echo esc_html($episode); ?>	
							</span>
						<?php endif; ?>

						<?php if( $show_title == 'yes' ): ?>
					    	<?php if( $show_link_to == 'yes' ): ?>
					        <a class="not-mega-link" href="<?php the_permalink();?>">
						    <?php endif; ?>	

								<h3 class="title">
									<?php the_title() ?>
								</h3>
		
							<?php if( $show_link_to == 'yes' ): ?>
								</a>
						    <?php endif; ?>	
						<?php endif; ?>	

						<?php if( !empty( $text_button ) ) : ?>
						    <a class="audio-button" href="<?php the_permalink();?>">
								<?php echo esc_html( $text_button ) ; ?>
							</a>
						<?php endif; ?>	
						
				    </div>

				</div>

			</div>

		<?php endwhile; endif; wp_reset_postdata(); ?>
	</div>

</div>