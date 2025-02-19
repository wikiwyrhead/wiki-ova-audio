<?php if ( !defined( 'ABSPATH' ) ) exit();
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! class_exists( 'Ovau_Ajax' ) ) {

	class Ovau_Ajax{

		public function __construct(){

			// Category Filter
			add_action( 'wp_ajax_load_list_category_filter', array( $this, 'load_list_category_filter') );
			add_action( 'wp_ajax_nopriv_load_list_category_filter', array( $this, 'load_list_category_filter') );

			// Audio Grid 2 Pagination Ajax
			add_action( 'wp_ajax_load_audio_grid_2', array( $this, 'load_audio_grid_2') );
			add_action( 'wp_ajax_nopriv_load_audio_grid_2', array( $this, 'load_audio_grid_2') );

			// Audio Featured Ajax
			add_action( 'wp_ajax_load_audio_featured', array( $this, 'load_audio_featured') );
			add_action( 'wp_ajax_nopriv_load_audio_featured', array( $this, 'load_audio_featured') );

			// Audio Category
			add_action( 'wp_ajax_ovau_load_audio_iframe', array( $this, 'ovau_load_audio_iframe') );
			add_action( 'wp_ajax_nopriv_ovau_load_audio_iframe', array( $this, 'ovau_load_audio_iframe') );

			// Popup Video
			add_action( 'wp_ajax_ovau_load_media_video', array( $this, 'ovau_load_media_video') );
			add_action( 'wp_ajax_nopriv_ovau_load_media_video', array( $this, 'ovau_load_media_video') );
		
		}

		public function load_list_category_filter() {
			check_ajax_referer( apply_filters( 'ovau_ajax_security', 'ajax_ovau_plugin' ), 'security' );

			$per_page 		= isset( $_POST['per_page'] ) ? sanitize_text_field( $_POST['per_page'] ) : 4;
			$order_by 		= isset( $_POST['order_by'] ) ? sanitize_text_field( $_POST['order_by'] ) : 'date';
			$order 			= isset( $_POST['order'] ) ? sanitize_text_field( $_POST['order'] ) : 'DESC';
			$cate_not_in 	= isset( $_POST['cate_not_in'] ) ? sanitize_text_field( $_POST['cate_not_in'] ) : '';
			$slug 			= isset( $_POST['slug'] ) ? sanitize_text_field( $_POST['slug'] ) : '';
			$paged 			= isset( $_POST['paged'] ) ? sanitize_text_field( $_POST['paged'] ) : 1;
			$show_thumbnail	= isset( $_POST['show_thumbnail'] ) ? sanitize_text_field( $_POST['show_thumbnail'] ) : 'yes';
			$show_title	    = isset( $_POST['show_title'] ) ? sanitize_text_field( $_POST['show_title'] ) : 'yes';
			$show_host	    = isset( $_POST['show_host'] ) ? sanitize_text_field( $_POST['show_host'] ) : 'yes';
			$show_episode	= isset( $_POST['show_episode'] ) ? sanitize_text_field( $_POST['show_episode'] ) : 'yes';
			$show_category	= isset( $_POST['show_category'] ) ? sanitize_text_field( $_POST['show_category'] ) : 'yes';
			$pagination 	= isset( $_POST['show_pagination'] ) ? sanitize_text_field( $_POST['show_pagination'] ) : 'no';
			$target 		= isset( $_POST['target_link'] ) ? sanitize_text_field( $_POST['target_link'] ) : 'yes';
			$detail_label   = isset( $_POST['detail_label'] ) ? sanitize_text_field( $_POST['detail_label'] ) : esc_html__('View Epidose', 'ovau');
			$layout         = isset( $_POST['layout'] ) ? sanitize_text_field( $_POST['layout'] ) : 1 ;

			$play_icon      = isset($_POST['play_icon'])  ? sanitize_text_field($_POST['play_icon']) : 'fas fa-play';
			$pause_icon     = isset($_POST['pause_icon']) ? sanitize_text_field($_POST['pause_icon']) : 'fas fa-pause';
			$redo_icon      = isset($_POST['redo_icon'])  ? sanitize_text_field($_POST['redo_icon']) : 'fas fa-redo-alt';
			$loop           = isset($_POST['loop']) === 'yes' ? 'true' : 'false';
			$skip_back      = isset($_POST['skip_back']) ? sanitize_text_field($_POST['skip_back']) : 15;
			$jump_forward   = isset($_POST['jump_forward']) ? sanitize_text_field($_POST['jump_forward']) : 15;
			$start_volume   = isset($_POST['start_volume']) ? sanitize_text_field($_POST['start_volume']) : 0.5;

			$args = [
				'posts_per_page' 	=> $per_page,
				'paged' 			=> $paged,
				'order_by'			=> $order_by,
				'order' 			=> $order,
				'slug'				=> $slug,
				'show_thumbnail'    => $show_thumbnail,
				'show_title' 		=> $show_title,
				'show_host' 		=> $show_host,
				'show_episode' 		=> $show_episode,
				'show_category' 	=> $show_category,
				'pagination' 		=> $pagination,
				'category_not_in'	=> $cate_not_in,
				'target_link' 		=> $target,
				'detail_label'      => $detail_label,
				'layout'            => $layout,
				'play_icon' 		=> $play_icon,
				'pause_icon' 	    => $pause_icon,
				'redo_icon' 		=> $redo_icon,
				'loop'				=> $loop,
				'skip_back' 		=> $skip_back,
				'jump_forward'      => $jump_forward,
				'start_volume'      => $start_volume,
			];

			switch ( $layout ) {
				case '1':
					ovau_get_template( 'parts/audio-item-list.php', $args );
					break;
				case '2':
					ovau_get_template( 'parts/audio-item-list-2.php', $args );
					break;
				default:
					ovau_get_template( 'parts/audio-item-list.php', $args );
			}
				
			
			wp_die();
		}

		public function load_audio_grid_2() {
			check_ajax_referer( apply_filters( 'ovau_ajax_security', 'ajax_ovau_plugin' ), 'security' );

			$total_posts 	= isset( $_POST['total_posts'] ) ? sanitize_text_field( $_POST['total_posts'] ) : 3;
			$orderby 		= isset( $_POST['orderby'] ) 	 ? sanitize_text_field( $_POST['orderby'] ) : 'date';
			$order 			= isset( $_POST['order'] ) 		 ? sanitize_text_field( $_POST['order'] ) : 'DESC';
			$categories     = isset( $_POST['categories'] )  ? $_POST['categories'] : array();
			$paged 			= isset( $_POST['paged'] ) 		 ? sanitize_text_field( $_POST['paged'] ) : 1;
			$column 		= isset( $_POST['column'] ) 	 ? sanitize_text_field( $_POST['column'] ) : 3;
			$pagination 	= isset( $_POST['pagination'] )  ? sanitize_text_field( $_POST['pagination'] ) : 'no';

			$class_icon            = isset( $_POST['class_icon'] ) 	  		 ? $_POST['class_icon']	: array();
			$show_excerpt          = isset( $_POST['show_excerpt'] ) 	  	 ? sanitize_text_field( $_POST['show_excerpt'] ) 	: '' ;
			$show_comment          = isset( $_POST['show_comment'] ) 	  	 ? sanitize_text_field( $_POST['show_comment'] ) 	: 'yes' ;
			$time_type             = isset( $_POST['time_type'] ) 	  	 	 ? sanitize_text_field( $_POST['time_type'] ) 		: 'default';
			$show_thumbnail        = isset( $_POST['show_thumbnail'] ) 	     ? sanitize_text_field( $_POST['show_thumbnail'] ) 	: 'yes' ;
			$show_title      	   = isset( $_POST['show_title'] ) 	  		 ? sanitize_text_field( $_POST['show_title'] ) 		: 'yes' ;
			$show_host      	   = isset( $_POST['show_host'] ) 	  		 ? sanitize_text_field( $_POST['show_host'] ) 		: 'yes' ;
			$show_category     	   = isset( $_POST['show_category'] ) 	  	 ? sanitize_text_field( $_POST['show_category'] ) 	: 'yes' ;
			$show_episode     	   = isset( $_POST['show_episode'] ) 	  	 ? sanitize_text_field( $_POST['show_episode'] ) 	: 'yes' ;
			$show_date       	   = isset( $_POST['show_date'] ) 	  		 ? sanitize_text_field( $_POST['show_date'] ) 		: 'yes' ;
			$show_duration         = isset( $_POST['show_duration'] ) 	  	 ? sanitize_text_field( $_POST['show_duration'] ) 	: 'yes' ;
			$show_link_to_detail   = isset( $_POST['show_link_to_detail'] )  ? sanitize_text_field( $_POST['show_link_to_detail'] )  : 'yes';
			$replace_date_by_cate  = isset( $_POST['replace_date_by_cate'] ) ? sanitize_text_field( $_POST['replace_date_by_cate'] ) : '' ;

			$play_icon      = isset($_POST['play_icon'])  ? $_POST['play_icon'] : array();
			$pause_icon     = isset($_POST['pause_icon']) ? $_POST['pause_icon'] : array();
			$loop           = isset($_POST['loop']) === 'yes' ? 'true' : 'false';
			$skip_back      = isset($_POST['skip_back']) ? sanitize_text_field($_POST['skip_back']) : 15;
			$jump_forward   = isset($_POST['jump_forward']) ? sanitize_text_field($_POST['jump_forward']) : 15;
			$start_volume   = isset($_POST['start_volume']) ? sanitize_text_field($_POST['start_volume']) : 0.5;

			$args_query = [
				'total_posts' 		=> $total_posts,
				'orderby'			=> $orderby,
				'order' 			=> $order,
				'no_offset' 		=> '', // if set paged >> not set offset
				'paged' 			=> $paged,
				'categories'		=> $categories,
			];

			$args = [
				'class_icon'		=> $class_icon,
				'show_excerpt'		=> $show_excerpt,
				'show_comment'		=> $show_comment,
				'time_type'			=> $time_type,
				'show_thumbnail'	=> $show_thumbnail,
				'show_title'		=> $show_title,
				'show_category'		=> $show_category,
				'show_episode'		=> $show_episode,
				'show_host'			=> $show_host,
				'show_duration'		=> $show_duration,
				'show_date'			=> $show_date,
				'show_duration'		=> $show_duration,
				'show_link_to_detail'  => $show_link_to_detail,
				'replace_date_by_cate' => $replace_date_by_cate,
				'play_icon' 		=> $play_icon,
				'pause_icon' 	    => $pause_icon,
				'loop'				=> $loop,
				'skip_back' 		=> $skip_back,
				'jump_forward'      => $jump_forward,
				'start_volume'      => $start_volume,
			];

			$audios = ovau_get_data_audio_el( $args_query );

			?>

			<div class="ova-audio-grid-2 archive_audio_grid_content <?php echo esc_attr($column);?>">
                <?php while ( $audios->have_posts() ) : $audios->the_post();
                    ovau_get_template( 'parts/audio-item-grid-2.php', $args );
                endwhile; wp_reset_postdata(); ?>
            </div>

            <?php $total = $audios->max_num_pages;
                if (  $total > 1 && $pagination == 'yes' ):
                    echo ovau_pagination_ajax( $audios->found_posts, $audios->query_vars['posts_per_page'], $paged );
            endif;
				
			
			wp_die();
		}

		public function load_audio_featured() {
			check_ajax_referer( apply_filters( 'ovau_ajax_security', 'ajax_ovau_plugin' ), 'security' );

			$featured 	    = isset( $_POST['featured'] ) 	 ? sanitize_text_field( $_POST['featured'] ) : '';
			$total_posts 	= isset( $_POST['total_posts'] ) ? sanitize_text_field( $_POST['total_posts'] ) : 3;
			$orderby 		= isset( $_POST['orderby'] ) 	 ? sanitize_text_field( $_POST['orderby'] ) : 'date';
			$order 			= isset( $_POST['order'] ) 		 ? sanitize_text_field( $_POST['order'] ) : '';
			$category       = isset( $_POST['category'] )  	 ? sanitize_text_field( $_POST['category'] ) : 'all';
			$paged 			= isset( $_POST['paged'] ) 		 ? sanitize_text_field( $_POST['paged'] ) : 1;
			$filter 		= isset( $_POST['filter'] )  	 ? sanitize_text_field( $_POST['filter'] ) : 'no';
			$pagination 	= isset( $_POST['pagination'] )  ? sanitize_text_field( $_POST['pagination'] ) : 'no';
			$detail_label 	= isset( $_POST['detail_label'] ) ? sanitize_text_field( $_POST['detail_label'] ) : '';
			$seperate 		= isset( $_POST['seperate'] ) 	 ? sanitize_text_field( $_POST['seperate'] ) : '.';

			$time_type		= isset( $_POST['time_type'] )   ? sanitize_text_field( $_POST['time_type'] ) : 'default';
			$target_link    = isset( $_POST['target_link'] ) ? sanitize_text_field( $_POST['target_link'] ) : '' ;
			$link_title  	= isset( $_POST['link_title'] )  ? sanitize_text_field( $_POST['link_title'] )  : 'yes';
			$show_title     = isset( $_POST['show_title'] )  ? sanitize_text_field( $_POST['show_title'] )  : 'yes';
			$show_thumbnail = isset( $_POST['show_thumbnail'] ) ? sanitize_text_field( $_POST['show_thumbnail'] )  : 'yes';
			$show_host      = isset( $_POST['show_host'] )  ? sanitize_text_field( $_POST['show_host'] )  : 'yes';
			$show_episode   = isset( $_POST['show_episode'] )  ? sanitize_text_field( $_POST['show_episode'] )  : 'yes';
			$show_category  = isset( $_POST['show_category'] )  ? sanitize_text_field( $_POST['show_category'] )  : 'yes';
			$show_excerpt   = isset( $_POST['show_excerpt'] )  ? sanitize_text_field( $_POST['show_excerpt'] )  : 'yes';
			$start_date     = isset( $_POST['start_date'] )  ? sanitize_text_field( $_POST['start_date'] ) : '';
			$end_date       = isset( $_POST['end_date'] )  	 ? sanitize_text_field( $_POST['end_date'] ) : '';
			$season         = isset( $_POST['season'] )  	 ? sanitize_text_field( $_POST['season'] ) : 'all';

			$args_query = [
				'featured' 		=> $featured,
				'total_posts' 	=> $total_posts,
				'orderby'		=> $orderby,
				'order' 		=> $order,
				'paged' 		=> $paged,
				'category'		=> $category,
				'season'		=> $season,
				'start_date'	=> $start_date,
				'end_date'		=> $end_date,
			];

			$audios = ovau_get_audio_featured( $args_query );

			$total  = $audios->max_num_pages;

			$category_name  = esc_html__( 'All', 'ovau' );
			$category_link  = get_post_type_archive_link( 'ova_audio' );

			$play_icon      = isset($_POST['play_icon'])  ? sanitize_text_field($_POST['play_icon']) : 'fas fa-play';
			$pause_icon     = isset($_POST['pause_icon']) ? sanitize_text_field($_POST['pause_icon']) : 'fas fa-pause';
			$redo_icon      = isset($_POST['redo_icon'])  ? sanitize_text_field($_POST['redo_icon']) : 'fas fa-redo-alt';
			$loop           = isset($_POST['loop']) === 'yes' ? 'true' : 'false';
			$skip_back      = isset($_POST['skip_back']) ? sanitize_text_field($_POST['skip_back']) : 15;
			$jump_forward   = isset($_POST['jump_forward']) ? sanitize_text_field($_POST['jump_forward']) : 15;
			$start_volume   = isset($_POST['start_volume']) ? sanitize_text_field($_POST['start_volume']) : 0.5;

			$audio_date_fortmat = apply_filters('ovau_audio_featured_date_format','m/d/Y');

			?>

			<?php if( $filter == 'yes') : ?>
                <div class="ovau-filter">
                    <?php ovau_get_template( 'search-form-audio.php', $args_query ); ?>
                    <?php if (  $total > 1 && $pagination == 'yes' ):
                        echo ovau_pagination_next_prev_ajax( $audios->found_posts, $audios->query_vars['posts_per_page'], $paged );
                    endif; ?>
                </div>
            <?php endif; ?>

			<?php if ( $audios->have_posts() ) : ?>

				<div class="ova-audio-featured">
	                <?php while ( $audios->have_posts() ) : $audios->the_post();
	                    $id         = get_the_id();
	                    $title      = get_the_title();
	                    $src        = get_post_meta( $id, 'ovau_audio_url', true );
	                    $id_player  = rand(1,1000000000000000000);
	                    $episode    = get_post_meta( $id, 'ovau_episode', true );
	                    $audio_link = get_post_permalink( $id );
	                    $img_audio  = get_the_post_thumbnail( $id, 'podover_thumbnail', apply_filters( 'ft_ovau_thumbnail_args', array('class' => 'audio-img') ) );
	                    $excerpt    = get_the_excerpt( $id );

	                    // get first category from audio
	                    $category_id     = get_the_terms( $id, 'category_audio' );
	                    if ( $category_id && is_array( $category_id ) ) {
	                        $category_name  = $category_id[0]->name;
	                        $category_link  = get_term_link( $category_id[0], 'category_audio' );
	                    }
	                    

	                    // get host
	                    $host_id           = get_post_meta( $id, 'ovau_host_id', true);
	                    $host_avatar       = wp_get_attachment_image_url(get_post_thumbnail_id($host_id) , 'thumbnail' );
	                    if ( $host_avatar == '') {
	                        $host_avatar   =  \Elementor\Utils::get_placeholder_image_src();
	                    }

	                    $audio_class    = '';
	                    $audio_media    = get_post_meta( $id, 'ovau_media', true ) ? get_post_meta( $id, 'ovau_media', true ) : 'audio';
	                    if ( 'video' === $audio_media ) {
	                        $audio_class = ' ovau-media-video';
	                    }
	                    $audio_type     = get_post_meta( $id, 'ovau_type', true ) ? get_post_meta( $id, 'ovau_type', true ) : 'upload_file';
	                    $audio_oembed   = get_post_meta( $id, 'ovau_audio_oembed', true );
	                    $audio_iframe   = get_post_meta( $id, 'ovau_audio_iframe', true );

	                    $audio_date = get_the_date('m/d/Y m:i',$id);
	                ?>

	                <div class="item-featured<?php echo esc_attr( $audio_class ); ?>"
	                    data-id="<?php echo esc_attr( $id_player ); ?>" 
	                    data-title="<?php echo esc_attr( $title ); ?>" 
	                    data-src="<?php echo esc_url( $src ); ?>" 
	                    data-play-icon="<?php echo esc_attr( $play_icon ); ?>" 
	                    data-pause-icon="<?php echo esc_attr( $pause_icon ); ?>" 
	                    data-redo-icon="<?php echo esc_attr( $redo_icon ); ?>" 
	                    data-loop="<?php echo esc_attr( $loop ); ?>" 
	                    data-skip-back="<?php echo esc_attr( $skip_back ); ?>" 
	                    data-jump-forward="<?php echo esc_attr( $jump_forward ); ?>" 
	                    data-start-volume="<?php echo esc_attr( $start_volume ); ?>"
	                >

	                    <div class="image <?php if($show_thumbnail != 'yes') echo 'no-thumbnail'; ?>">
	                        <?php if($show_thumbnail == 'yes') { 
	                            printf( $img_audio );
	                        } ?>

	                        <?php if( !empty($host_id) && $show_host == 'yes' ) : ?>
	                            <a href="<?php the_permalink( $host_id );?>">
	                                <img src="<?php echo esc_url( $host_avatar ); ?>" class="host-img" title="<?php echo get_the_title( $host_id ); ?>" alt="<?php echo get_the_title( $host_id ); ?>">
	                            </a>
	                        <?php endif; ?>
	                    </div>

	                    <div class="item-content">
	                        <div class="episode-category">
	                            <?php if( $show_episode == 'yes' ) : ?>
	                                <span class="episode">
	                                    <?php echo esc_html( $episode ); ?>
	                                </span>
	                            <?php endif; ?>
	                            <?php if( !empty($seperate) ) : ?>
	                                <span class="seperate">
	                                    <?php echo esc_html( $seperate ); ?>
	                                </span>
	                            <?php endif; ?>
	                            <?php if( $show_category == 'yes' ) : ?>
	                                <span class="category">
	                                    <a href="<?php echo esc_url( $category_link ); ?>">
	                                        <?php echo esc_html( $category_name ); ?>
	                                    </a>
	                                </span>
	                            <?php endif; ?>
	                        </div>
	                        <?php if ( 'yes' === $show_title ): ?>
	                            <?php if ( 'yes' === $link_title ): ?>
	                                <h2 class="title">
	                                    <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target_link ); ?>>
	                                        <?php echo esc_html( $title ); ?>
	                                    </a>
	                                </h2>
	                            <?php else: ?>
	                                <h2 class="title">
	                                    <?php echo esc_html( $title ); ?>
	                                </h2>
	                            <?php endif; ?>
	                        <?php endif; ?>

	                        <?php if ( !empty($play_icon) ): ?>
	                        <div class="item-player">
	                            <?php if ( 'oembed' === $audio_type && $audio_oembed ): ?>
	                                <?php if ( 'video' === $audio_media ): ?>
	                                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
	                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
	                                    </div>
	                                <?php else: ?>
	                                    <?php echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, apply_filters('ft_ovau_single_oembed', array())) ); ?>
	                                <?php endif; ?>
	                            <?php elseif ( 'iframe' === $audio_type && $audio_iframe ): ?>
	                                <?php if ( 'video' === $audio_media ): ?>
	                                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
	                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
	                                    </div>
	                                <?php else: ?>
	                                    <?php echo ovau_filter_oembed_result( $audio_iframe ); ?>
	                                <?php endif; ?>
	                            <?php else: ?>
	                                <?php if ( 'video' === $audio_media ): ?>
	                                    <div class="ovau-btn-play" data-id="<?php echo esc_attr( $id ); ?>">
	                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
	                                    </div>
	                                <?php else: ?>
	                                    <div class="ovau-btn-play">
	                                        <i class="<?php echo esc_attr( $play_icon ); ?>"></i>
	                                    </div>
	                                    <div class="ovau-player-featured"></div>
	                                <?php endif; ?>
	                            <?php endif; ?>
	                        </div>
	                        <?php endif; ?>

	                        <?php if ( !empty($excerpt) && $show_excerpt == 'yes' ): ?>
	                            <p class="excerpt">
	                                <?php printf( $excerpt ); ?>
	                            </p>
	                        <?php endif; ?>
	                        
	                        <div class="btn-view-detail">
	                        	<?php if ( !empty($detail_label) ): ?>
	                            <a href="<?php echo esc_url( $audio_link ); ?>"<?php printf( $target_link ); ?>>
	                                <?php echo esc_html( $detail_label ); ?>
	                                <i aria-hidden="true" class="ovaicon ovaicon-next-4"></i>
	                            </a>
	                            <?php endif; ?>

	                            <?php if($time_type != 'none'): ?>
	                                <span class="audio-date">
	                                    <?php if($time_type == 'time_ago'):
	                                        echo ovau_time_elapsed_string($audio_date, false);
	                                    else:
	                                       the_time($audio_date_fortmat);
	                                    endif; ?>
	                                </span>
	                            <?php endif; ?>
	                        </div>
	                    </div>
	                    <audio id="id_<?php echo esc_attr( $id_player ); ?>" src="<?php echo esc_url( $src ); ?>"></audio>
	                </div>

	                <?php endwhile; wp_reset_postdata(); ?>
	            </div>

	            <?php if (  $total > 1 && $pagination == 'yes' ):
	                echo ovau_pagination_ajax( $audios->found_posts, $audios->query_vars['posts_per_page'], $paged );
	            endif;

            else : ?>
			    <p class="post-not-found"><?php esc_html_e( 'Not found!' ); ?></p>
			<?php endif;
				
			
			wp_die();
		}

		public function ovau_load_audio_iframe() {
			check_ajax_referer( apply_filters( 'ovau_ajax_security', 'ajax_ovau_plugin' ), 'security' );

			$type 		= isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
			$audio_id 	= isset( $_POST['audio_id'] ) ? sanitize_text_field( $_POST['audio_id'] ) : '';

			if ( 'oembed' === $type ) {
				$audio_oembed = get_post_meta( $audio_id, 'ovau_audio_oembed', true );
				echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, apply_filters('ft_ovau_single_oembed', array())) );
			}

			if ( 'iframe' === $type ) {
				$audio_iframe   = get_post_meta( $audio_id, 'ovau_audio_iframe', true );
				echo ovau_filter_oembed_result( $audio_iframe );;
			}

			wp_die();
		}

		public function ovau_load_media_video() {
			check_ajax_referer( apply_filters( 'ovau_ajax_security', 'ajax_ovau_plugin' ), 'security' );

			$audio_id 	= isset( $_POST['audio_id'] ) ? sanitize_text_field( $_POST['audio_id'] ) : '';
			$w    		= apply_filters( 'ft_ovau_load_media_video_width', 900 );
			$h   		= apply_filters( 'ft_ovau_load_media_video_height', 507 );

			if ( $audio_id ) {
				$audio_type 	= get_post_meta( $audio_id, 'ovau_type', true ) ? get_post_meta( $audio_id, 'ovau_type', true ) : '';
				$audio_media 	= get_post_meta( $audio_id, 'ovau_media', true ) ? get_post_meta( $audio_id, 'ovau_media', true ) : '';

				if ( 'video' === $audio_media ) {
					if ( 'oembed' === $audio_type ) {
						$audio_oembed = get_post_meta( $audio_id, 'ovau_audio_oembed', true );
						echo ovau_filter_oembed_result( wp_oembed_get( $audio_oembed, array( 'width' => $w, 'height' => $h )) );
					} elseif ( 'iframe' === $audio_type ) {
						$audio_iframe   = get_post_meta( $audio_id, 'ovau_audio_iframe', true );
						echo ovau_filter_oembed_result( $audio_iframe );
					} else {
						$src 		= get_post_meta( $audio_id, 'ovau_audio_url', true );
						$src_id 	= get_post_meta( $audio_id, 'ovau_audio_url_id', true );
						$mime_type  = 'video/mp4';

						if ( $src_id ) {
						    $attachment_metadata = get_post_meta( $src_id, '_wp_attachment_metadata', true );

						    if ( $attachment_metadata && is_array( $attachment_metadata ) ) {
						        $mime_type  = isset( $attachment_metadata['mime_type'] ) ? $attachment_metadata['mime_type'] : $mime_type;
						    }
						}
						
						$html_video  = '';
						$html_video .= '<video id="ovau_video_'.$audio_id.'" width="'.$w.'" height="'.$h.'" controls preload="metadata">';
						$html_video .= '<source src="'.$src.'" type="'.$mime_type.'">';
						$html_video .= '</video>';

						echo $html_video;
					}
				}
			}

			wp_die();
		}
	}

	new Ovau_Ajax();
}