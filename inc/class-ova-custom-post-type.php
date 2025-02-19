<?php 
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

if ( !class_exists( 'OVAU_custom_post_type' ) ) {

	class OVAU_custom_post_type{

		public function __construct(){
			add_action( 'init', array( $this, 'OVAU_register_post_type_audio' ) );
			add_action( 'init', array( $this, 'OVAU_register_taxonomy_audio' ) );
			add_action( 'init', array( $this, 'OVAU_register_post_type_audio_host' ) );
			add_action( 'init', array( $this, 'OVAU_register_taxonomy_audio_seasons' ) );
			add_action( 'init', array( $this, 'OVAU_register_taxonomy_audio_tags' ) );
		}

		function OVAU_register_post_type_audio() {

			$labels = array(
				'name'                  => _x( 'Audios', 'Post Type General Name', 'ovau' ),
				'singular_name'         => _x( 'Audio', 'Post Type Singular Name', 'ovau' ),
				'menu_name'             => esc_html__( 'Audios', 'ovau' ),
				'name_admin_bar'        => esc_html__( 'Audio', 'ovau' ),
				'archives'              => esc_html__( 'Item Archives', 'ovau' ),
				'attributes'            => esc_html__( 'Item Attributes', 'ovau' ),
				'parent_item_colon'     => esc_html__( 'Parent Item:', 'ovau' ),
				'all_items'             => esc_html__( 'All Audios', 'ovau' ),
				'add_new_item'          => esc_html__( 'Add New Audio', 'ovau' ),
				'add_new'               => esc_html__( 'Add New', 'ovau' ),
				'new_item'              => esc_html__( 'New Item', 'ovau' ),
				'edit_item'             => esc_html__( 'Edit', 'ovau' ),
				'view_item'             => esc_html__( 'View Item', 'ovau' ),
				'view_items'            => esc_html__( 'View Items', 'ovau' ),
				'search_items'          => esc_html__( 'Search Item', 'ovau' ),
				'not_found'             => esc_html__( 'Not found', 'ovau' ),
				'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'ovau' ),
			);

			$args = array(
				'description'         => esc_html__( 'Post Type Description', 'ovau' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_rest'		  => true,
				'menu_position'       => 5,
				'query_var'           => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => array( 'slug' => _x( 'audio', 'URL slug', 'ovau' ) ),
				'capability_type'     => 'post',
				'menu_icon'           => 'dashicons-media-audio'
			);

			register_post_type( 'ova_audio', $args );
		}

		function OVAU_register_taxonomy_audio(){
			
			$labels = array(
				'name'                       => _x( 'Audio Categories', 'Post Type General Name', 'ovau' ),
				'singular_name'              => _x( 'Audio Category', 'Post Type Singular Name', 'ovau' ),
				'menu_name'                  => esc_html__( 'Categories', 'ovau' ),
				'all_items'                  => esc_html__( 'All Category Audio', 'ovau' ),
				'parent_item'                => esc_html__( 'Parent Item', 'ovau' ),
				'parent_item_colon'          => esc_html__( 'Parent Item:', 'ovau' ),
				'new_item_name'              => esc_html__( 'New Item Name', 'ovau' ),
				'add_new_item'               => esc_html__( 'Add New Category Audio', 'ovau' ),
				'add_new'                    => esc_html__( 'Add New Category Audio', 'ovau' ),
				'edit_item'                  => esc_html__( 'Edit Category Audio', 'ovau' ),
				'view_item'                  => esc_html__( 'View Item', 'ovau' ),
				'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'ovau' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove items', 'ovau' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'ovau' ),
				'popular_items'              => esc_html__( 'Popular Items', 'ovau' ),
				'search_items'               => esc_html__( 'Search Items', 'ovau' ),
				'not_found'                  => esc_html__( 'Not Found', 'ovau' ),
				'no_terms'                   => esc_html__( 'No items', 'ovau' ),
				'items_list'                 => esc_html__( 'Items list', 'ovau' ),
				'items_list_navigation'      => esc_html__( 'Items list navigation', 'ovau' ),

			);

			$args = array(
				'labels'            	=> $labels,
				'hierarchical'      	=> true,
				'publicly_queryable' 	=> true,
				'public'            	=> true,
				'show_ui'           	=> true,
				'show_admin_column' 	=> true,
				'show_in_nav_menus' 	=> true,
				'show_tagcloud'     	=> false,
				'show_in_rest'          => true,
				'rewrite'            	=> array(
					'slug'       => _x( 'category-audio', 'Category Audio Slug', 'ovau' ),
					'with_front' => false,
					'feeds'      => true,
				),
			);
			
			register_taxonomy( 'category_audio', array( 'ova_audio' ), $args );
		}

		function OVAU_register_post_type_audio_host() {

			$labels = array(
				'name'                  => _x( 'Hosts', 'Post Type General Name', 'ovau' ),
				'singular_name'         => _x( 'Host', 'Post Type Singular Name', 'ovau' ),
				'menu_name'             => esc_html__( 'Hosts', 'ovau' ),
				'name_admin_bar'        => esc_html__( 'Audio Host', 'ovau' ),
				'archives'              => esc_html__( 'Item Archives', 'ovau' ),
				'attributes'            => esc_html__( 'Item Attributes', 'ovau' ),
				'parent_item_colon'     => esc_html__( 'Parent Item:', 'ovau' ),
				'all_items'             => esc_html__( 'All Hosts', 'ovau' ),
				'add_new_item'          => esc_html__( 'Add New Host', 'ovau' ),
				'add_new'               => esc_html__( 'Add New', 'ovau' ),
				'new_item'              => esc_html__( 'New Item', 'ovau' ),
				'edit_item'             => esc_html__( 'Edit', 'ovau' ),
				'view_item'             => esc_html__( 'View Item', 'ovau' ),
				'view_items'            => esc_html__( 'View Items', 'ovau' ),
				'search_items'          => esc_html__( 'Search Item', 'ovau' ),
				'not_found'             => esc_html__( 'Not found', 'ovau' ),
				'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'ovau' ),
			);

			$args = array(
				'description'         => esc_html__( 'Post Type Description', 'ovau' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'menu_position'       => 5,
				'query_var'           => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => array( 'slug' => _x( 'audio-host', 'URL slug', 'ovau' ) ),
				'capability_type'     => 'post',
				'menu_icon'           => 'dashicons-admin-users'
			);

			register_post_type( 'ova_audio_host', $args );
		}

		function OVAU_register_taxonomy_audio_seasons() {

			$labels = array(
				'name'                       => _x( 'Seasons', 'Post Type General Name', 'ovau' ),
				'singular_name'              => _x( 'Seasons', 'Post Type Singular Name', 'ovau' ),
				'menu_name'                  => esc_html__( 'Seasons', 'ovau' ),
				'all_items'                  => esc_html__( 'All Seasons Audio', 'ovau' ),
				'parent_item'                => esc_html__( 'Parent Item', 'ovau' ),
				'parent_item_colon'          => esc_html__( 'Parent Item:', 'ovau' ),
				'new_item_name'              => esc_html__( 'New Item Name', 'ovau' ),
				'add_new_item'               => esc_html__( 'Add New Season Audio', 'ovau' ),
				'add_new'                    => esc_html__( 'Add New Season Audio', 'ovau' ),
				'edit_item'                  => esc_html__( 'Edit Season Audio', 'ovau' ),
				'view_item'                  => esc_html__( 'View Item', 'ovau' ),
				'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'ovau' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove items', 'ovau' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'ovau' ),
				'popular_items'              => esc_html__( 'Popular Items', 'ovau' ),
				'search_items'               => esc_html__( 'Search Items', 'ovau' ),
				'not_found'                  => esc_html__( 'Not Found', 'ovau' ),
				'no_terms'                   => esc_html__( 'No items', 'ovau' ),
				'items_list'                 => esc_html__( 'Items list', 'ovau' ),
				'items_list_navigation'      => esc_html__( 'Items list navigation', 'ovau' ),
			);

			$args = array(
				'labels'            	=> $labels,
				'hierarchical'      	=> true,
				'publicly_queryable' 	=> true,
				'public'            	=> true,
				'show_ui'           	=> true,
				'show_admin_column' 	=> true,
				'show_in_nav_menus' 	=> true,
				'show_tagcloud'     	=> false,
				'show_in_rest'          => true,
				'rewrite'            	=> array(
					'slug'       => _x( 'season-audio', 'Season Audio Slug', 'ovau' ),
					'with_front' => false,
					'feeds'      => true,
				),
			);
			
			register_taxonomy( 'season_audio', array( 'ova_audio' ), $args );
		}

		function OVAU_register_taxonomy_audio_tags() {

			$labels = array(
				'name'                       => _x( 'Audio Tags', 'Post Type General Name', 'ovau' ),
				'singular_name'              => _x( 'Audio Tag', 'Post Type Singular Name', 'ovau' ),
				'menu_name'                  => esc_html__( 'Tags', 'ovau' ),
				'all_items'                  => esc_html__( 'All Tags Audio', 'ovau' ),
				'parent_item'                => esc_html__( 'Parent Item', 'ovau' ),
				'parent_item_colon'          => esc_html__( 'Parent Item:', 'ovau' ),
				'new_item_name'              => esc_html__( 'New Item Name', 'ovau' ),
				'add_new_item'               => esc_html__( 'Add New Tag Audio', 'ovau' ),
				'add_new'                    => esc_html__( 'Add New Tag Audio', 'ovau' ),
				'edit_item'                  => esc_html__( 'Edit Tag Audio', 'ovau' ),
				'view_item'                  => esc_html__( 'View Item', 'ovau' ),
				'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'ovau' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove items', 'ovau' ),
				'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'ovau' ),
				'popular_items'              => esc_html__( 'Popular Items', 'ovau' ),
				'search_items'               => esc_html__( 'Search Items', 'ovau' ),
				'not_found'                  => esc_html__( 'Not Found', 'ovau' ),
				'no_terms'                   => esc_html__( 'No items', 'ovau' ),
				'items_list'                 => esc_html__( 'Items list', 'ovau' ),
				'items_list_navigation'      => esc_html__( 'Items list navigation', 'ovau' ),
			);

			$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'publicly_queryable' => true,
				'public'            => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => true,
				'show_in_rest'      => true,
				'show_tagcloud'     => false,
				'rewrite'            => array(
					'slug'       => _x('audio-tag','Tag Audio Slug', 'ovau'),
					'with_front' => false,
					'feeds'      => true,
				),
			);

			register_taxonomy( 'tag_audio', array( 'ova_audio' ), $args );
			
		}
		
	}

	new OVAU_custom_post_type();
}