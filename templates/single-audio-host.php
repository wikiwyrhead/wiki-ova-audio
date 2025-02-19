<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

get_header( );

$id = get_the_ID();

$avatar      = get_the_post_thumbnail_url( $id, 'large' );
$job         = get_post_meta( $id, 'ovau_host_job', true );
$list_social = get_post_meta( $id, 'ovau_host_group_icon', true );
$slogans     = get_post_meta( $id, 'ovau_host_slogans', true );

$number_audio = get_theme_mod('ovau_host_audio_total_record', 3 );
$sub_title    = get_theme_mod('ovau_host_audio_sub_title', '');
$title        = get_theme_mod('ovau_host_audio_title', 'My podcasts');
$column       = get_theme_mod('ovau_host_audio_column_layout', 'three_column' );
$text_button  = get_theme_mod('ovau_host_audio_text_button', 'View all My Podcasts');
$show_button  = get_theme_mod('ovau_host_audio_single_show_button', 'yes');

$args_column['column'] = $column ;

// get audio by host id
$args['number_audio'] = $number_audio;
$args['id']           = $id;
$audios               = ovau_get_data_audio_host_single($args);

// link button view all
$slug_host   = get_post_field( 'post_name', $id );
$link_button = get_post_type_archive_link( 'ova_audio' ) . '?host=' . $slug_host;

?>

<!-- HTML -->

    <div class="row_site">
		<div class="container_site">

			<div class="ova_audio_host_single">

				<div class="info">

					<!-- Image -->
					<div class="img">
						<?php if( ! empty( $avatar ) ){ ?>
							<img src="<?php echo esc_url( $avatar ) ?>" class="img-responsive" alt="<?php echo get_the_title() ?>">
						<?php } ?>
					</div>

					<div class="main_content">

						<h2 class="name">
							<?php echo get_the_title() ?>
						</h2>

						<?php if( ! empty( $job ) ) { ?>
							<div class="job content-contact">
								<?php echo esc_html( $job ) ?>
							</div>
						<?php } ?>

						<?php if( ! empty( $list_social ) ) {  ?>
							<ul class="list-social">
								<?php
									foreach( $list_social as $social ){

										$class_icon = isset( $social['ovau_host_class_icon_social'] ) ? $social['ovau_host_class_icon_social'] : '';
										$link_social = isset( $social['ovau_host_link_social'] ) ? $social['ovau_host_link_social'] : '';
										?>
										<li>
											<a href="<?php echo esc_url( $link_social ); ?>" target="_blank">
												<i class="<?php echo esc_attr( $class_icon ) ?>"></i>
											</a>
										</li>
								<?php } ?>
								
							</ul>
						<?php } ?>
	                    
	                    
						<?php if( ! empty( $slogans ) ) { ?>
							<div class="slogans">
								<?php echo apply_filters( 'widget_text_content', $slogans ); ?>
							</div>
					    <?php } ?>
					    
					</div>

				</div>

				<?php if( $audios->found_posts != 0 ) : ?>
	                <div class="host-my-podcast">
	                	<?php if( !empty( $sub_title) ) : ?>
							<h4 class="sub-title"><?php echo esc_html( $sub_title ); ?></h4>
						<?php endif; ?>
						<h2 class="title"><?php echo esc_html( $title ); ?></h2>

						<div class="host-my-podcast-item">
							<?php if( $audios->have_posts() ) : while ( $audios->have_posts() ) : $audios->the_post(); ?>
		                	    <?php ovau_get_template( 'parts/audio-item-grid-player.php', $args_column ); ?>
		                	<?php endwhile; endif; wp_reset_postdata(); ?>
		                </div>
                        <?php if( $show_button === 'yes' ) : ?>
			                <a class="button-view-all-podcast" href="<?php echo esc_attr($link_button); ?>">
			                	<?php echo esc_html( $text_button ); ?>
			                </a>
		                <?php endif; ?>
	                </div>
                <?php endif; ?>

				<div class="description">
					<?php the_content(); ?>
				</div>		

			</div>

		</div>
	</div>

<?php get_footer( );
