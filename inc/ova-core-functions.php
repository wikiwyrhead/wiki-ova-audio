<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

// Search template
if ( !function_exists( 'ovau_locate_template' ) ) {
	function ovau_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		
		// Set variable to search in ovau-templates folder of theme.
		if ( ! $template_path ) {
			$template_path = 'ovau-templates/';
		}

		// Set default plugin templates path.
		if ( ! $default_path ) {
			$default_path = OVAU_PLUGIN_PATH . 'templates/'; // Path to the template folder
		}

		// Search template file in theme folder.
		$template = locate_template( array( $template_path . $template_name ) );

		// Get plugins template file.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		return apply_filters( 'ovau_locate_template', $template, $template_name, $template_path, $default_path );
	}
}

// Get template
if ( !function_exists( 'ovau_get_template' ) ) {
	function ovau_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;
		$template_file = ovau_locate_template( $template_name, $tempate_path, $default_path );
		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
			return;
		endif;

		include $template_file;
	}
}

// Get Audio Header
add_filter( 'podover_header_customize', 'ovau_header_customize_audio', 10, 1 );
function ovau_header_customize_audio( $header ){

    $single_audio_template = get_theme_mod( 'ovau_single_audio_template', 'template_1' );

    $single_template = get_post_meta( get_the_ID(), 'ovau_single_template', true );
    if ( $single_template != '' ) {
        $single_audio_template = $single_template;
    }
    if (isset($_GET['single_audio_template'])) {
        $single_audio_template = $_GET['single_audio_template'];
    }

	if ( is_tax( 'category_audio' ) ||  get_query_var( 'category_audio' ) != '' || is_tax( 'season_audio' ) ||  get_query_var( 'season_audio' ) != '' || is_tax( 'tag_audio' ) ||  get_query_var( 'tag_audio' ) != '' || is_post_type_archive( 'ova_audio' ) ) {

	  	$header = get_theme_mod( 'header_archive_audio', 'default' );

	} else if( is_singular( 'ova_audio' ) ) {

        if ( $single_audio_template == 'template_2' ) {
            $header = get_theme_mod( 'header_single_audio_2', 'default' );
        } else {
           $header = get_theme_mod( 'header_single_audio', 'default' );
        }

	}

	return $header;
}

// Get Audio Footer
add_filter( 'podover_footer_customize', 'ovau_footer_customize_audio', 10, 1 );
function ovau_footer_customize_audio( $footer ){

    $single_audio_template = isset($_GET['single_audio_template']) ? $_GET['single_audio_template'] : get_theme_mod( 'ovau_single_audio_template', 'template_1' );

    $single_template = get_post_meta( get_the_ID(), 'ovau_single_template', true );
    if ( $single_template != '' ) {
        $single_audio_template = $single_template;
    }

   	if ( is_tax( 'category_audio' ) ||  get_query_var( 'category_audio' ) != '' || is_tax( 'season_audio' ) ||  get_query_var( 'season_audio' ) != '' || is_tax( 'tag_audio' ) ||  get_query_var( 'tag_audio' ) != '' || is_post_type_archive( 'ova_audio' ) ) {

        $footer = get_theme_mod( 'footer_archive_audio', 'default' );

    } else if( is_singular( 'ova_audio' ) ) {

        if ( $single_audio_template == 'template_2' ) {
            $footer = get_theme_mod( 'footer_single_audio_2', 'default' );
        } else {
            $footer = get_theme_mod( 'footer_single_audio', 'default' );
        }
    }

    return $footer;
}


// Get Audio Host Header
add_filter( 'podover_header_customize', 'ovau_header_customize_audio_host', 10, 1 );
function ovau_header_customize_audio_host( $header ){
	if ( is_post_type_archive( 'ova_audio_host' ) ) {
	  	$header = get_theme_mod( 'header_archive_audio_host', 'default' );
	} else if( is_singular( 'ova_audio_host' ) ) {
		$header = get_theme_mod( 'header_single_audio_host', 'default' );
	}

	return $header;
}

// Get Audio Host Footer
add_filter( 'podover_footer_customize', 'ovau_footer_customize_audio_host', 10, 1 );
function ovau_footer_customize_audio_host( $footer ){
   	if ( is_post_type_archive( 'ova_audio_host' ) ) {
        $footer = get_theme_mod( 'footer_archive_audio_host', 'default' );
    } else if( is_singular( 'ova_audio_host' ) ) {
        $footer = get_theme_mod( 'footer_single_audio_host', 'default' );
    }

    return $footer;
}

// Add image site
add_action( 'plugins_loaded', 'ovau_plugins_support' );
if ( !function_exists( 'ovau_plugins_support' ) ) {
	function ovau_plugins_support() {
		add_image_size( 'ovau_thumbnail', 510, 335, true );
	}
}

/**
 * Categories Audio
 */
if ( ! function_exists( 'ovau_select_audio_cat' ) ) {
    function ovau_select_audio_cat($selected){

        $args = array(
            'show_option_all'   => '' ,
            'show_option_none'   => esc_html__( 'All Categories', 'ovaev' ),
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => '-1',
            'option_none_value' => '',
            'orderby'           => 'ID',
            'order'             => 'ASC',
            'show_count'        => 0,
            'hide_empty'        => 0,
            'child_of'          => 0,
            'exclude'           => '',
            'include'           => '',
            'echo'              => 1,
            'selected'          => $selected,
            'hierarchical'      => 1,
            'name'              => 'ovau_cat',
            'id'                => '',
            'depth'             => 0,
            'tab_index'         => 0,
            'taxonomy'          => 'category_audio',
            'hide_if_empty'     => false,
            'value_field'       => 'slug',
            'class'             => 'ovau_cat',
        );
        
        return wp_dropdown_categories($args);
    }
}

/**
 * Episodes Audio
 */
if ( ! function_exists( 'ovau_select_audio_season' ) ) {
    function ovau_select_audio_season($selected){

        $args = array(
            'show_option_all'   => '' ,
            'show_option_none'   => esc_html__( 'All Seasons', 'ovaev' ),
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => '-1',
            'option_none_value' => '',
            'orderby'           => 'ID',
            'order'             => 'ASC',
            'show_count'        => 0,
            'hide_empty'        => 0,
            'child_of'          => 0,
            'exclude'           => '',
            'include'           => '',
            'echo'              => 1,
            'selected'          => $selected,
            'hierarchical'      => 1,
            'name'              => 'ovau_season',
            'id'                => '',
            'depth'             => 0,
            'tab_index'         => 0,
            'taxonomy'          => 'season_audio',
            'hide_if_empty'     => false,
            'value_field'       => 'slug',
            'class'             => 'ovau_season',
        );
        
        return wp_dropdown_categories($args);
    }
}

/* Pagination */
if ( ! function_exists( 'ovau_pagination_ajax' ) ) {
    function ovau_pagination_ajax( $total, $limit, $current ) {
        $html   = '';
        $pages  = ceil( $total / $limit );

        if ( $pages > 1 ) {
            $html .= '<ul class="ovau_pagination_ajax category-filter-pagination">';

            if ( $current > 1 ) {
                $html .=    '<li><span data-paged="'. ( $current - 1 ) .'" class="prev page-numbers" >'
                                . '<i class="ovaicon-back"></i>'  .
                            '</span></li>';
            }

            for ( $i = 1; $i <= $pages; $i++ ) {
                if ( $current == $i ) {
                    $html .=    '<li><span data-paged="'. $i .'" class="prev page-numbers current" >'. esc_html( $i ) .'</span></li>';
                } else {
                    $html .=    '<li><span data-paged="'. $i .'" class="page-numbers" >'. esc_html( $i ) .'</span></li>';
                }
            }

            if ( $current < $pages ) {
                $html .=    '<li><span data-paged="'. ( $current + 1 ) .'" class="next page-numbers" >'
                                . '<i class="ovaicon-next"></i>' .
                            '</span></li>';
            }
        }

        return $html;
    }
}

/* Pagination Next Prev */
if ( ! function_exists( 'ovau_pagination_next_prev_ajax' ) ) {
    function ovau_pagination_next_prev_ajax( $total, $limit, $current ) {
        $html   = '';
        $pages  = ceil( $total / $limit );

        if ( $pages > 1 ) {
            $html .= '<ul class="ovau_pagination_ajax">';
            
            if ( $current > 1 ) {
                $html .=    '<li><span data-paged="'. ( $current - 1 ) .'" class="prev page-numbers" >'
                                . '<i class="ovaicon-back"></i>'  .
                            '</span></li>';
            } else {
                $html .=    '<li><span style="pointer-events: none;" data-paged="'. ( $current - 1 ) .'" class="prev page-numbers" >'
                                . '<i class="ovaicon-back"></i>'  .
                            '</span></li>';
            }
         
            if ( $current < $pages ) {
                $html .=    '<li><span data-paged="'. ( $current + 1 ) .'" class="next page-numbers" >'
                                . '<i class="ovaicon-next"></i>' .
                            '</span></li>';
            } else {
                $html .=    '<li><span style="pointer-events: none;" data-paged="'. ( $current + 1 ) .'" class="next page-numbers" >'
                                . '<i class="ovaicon-next"></i>' .
                            '</span></li>';
            }
        }

        return $html;
    }
}

/* Caculate time ago */
function ovau_time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    // Tính số tuần
    $weeks = floor($diff->d / 7);
    $diff->d -= $weeks * 7;

    $string = array(
        'y' => esc_html__('year','ovau'),
        'm' => esc_html__('month','ovau'),
        'w' => esc_html__('week','ovau'),
        'd' => esc_html__('day','ovau'),
        'h' => esc_html__('hour','ovau'),
        'i' => esc_html__('minute','ovau'),
        's' => esc_html__('second','ovau'),
    );

   
    if ($weeks) {
        $string['w'] = $weeks . ' ' . esc_html__('week','ovau') . ($weeks > 1 ? 's' : '');
    }

    foreach ($string as $k => &$v) {
        if (isset($diff->$k) && $diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } elseif ($k != 'w') { // Không unset 'w' vì đã tính riêng
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . esc_html__(' ago','ovau') : esc_html__('just now','ovau');
}

