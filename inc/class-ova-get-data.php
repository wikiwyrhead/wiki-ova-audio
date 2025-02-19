<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

// The query Audio
add_action( 'pre_get_posts', 'ovau_post_per_page_archive' );
function ovau_post_per_page_archive( $query ) {

    if ( is_post_type_archive( 'ova_audio' ) && !is_admin() && !empty($_GET['host']) ) {
        if ( $query->is_post_type_archive( 'ova_audio' ) ) {
            $query->set('post_type', array( 'ova_audio' ) );
            $query->set('posts_per_page', get_theme_mod( 'ovau_total_record', 6 ) );
            $query->set('order', get_theme_mod( 'ovau_archive_order', 'DESC' ) );

            $orderby = get_theme_mod( 'ovau_archive_orderby', 'ovau_order' );

            if ( 'ovau_order' === $orderby ) {
                $query->set('orderby', 'meta_value_num' );
                $query->set('meta_type', 'NUMERIC' );
                $query->set('meta_key', 'ovau_order' );
            } else {
                $query->set('meta_key', $orderby );
            }
            
            // get host id by slug
            $post     = get_page_by_path( $_GET['host'], OBJECT, 'ova_audio_host' );
            $host_id  = $post->ID;

            // query get by host id
            if($host_id != '') {
                $meta_query = (array)$query->get('meta_query');
                $meta_query[] = array(
                    'key'     => 'ovau_host_id',
                    'value'   => $host_id,
                    'compare' => '=',
                );    
                $query->set('meta_query',$meta_query);
            }
        }
    } elseif( ( is_post_type_archive( 'ova_audio' ) || is_tax('category_audio') || is_tax('season_audio') || is_tax('tag_audio') ) && !is_admin() ) {
        if ( $query->is_post_type_archive( 'ova_audio' ) || $query->is_tax('category_audio') || $query->is_tax('season_audio') || $query->is_tax('tag_audio') ) {
            $query->set('post_type', array( 'ova_audio' ) );
            $query->set('posts_per_page', get_theme_mod( 'ovau_total_record', 6 ) );
            $query->set('order', get_theme_mod( 'ovau_archive_order', 'DESC' ) );

            $orderby = get_theme_mod( 'ovau_archive_orderby', 'ovau_order' );

            if ( 'ovau_order' === $orderby ) {
                $query->set('orderby', 'meta_value_num' );
                $query->set('meta_type', 'NUMERIC' );
                $query->set('meta_key', 'ovau_order' );
            } else {
                $query->set('orderby', $orderby );
            }
        }
    }
}

// The query Audio Host
add_action( 'pre_get_posts', 'ovau_host_post_per_page_archive' );
function ovau_host_post_per_page_archive( $query ) {

    if ( is_post_type_archive( 'ova_audio_host' ) && !is_admin() ) {
        if ( $query->is_post_type_archive( 'ova_audio_host' ) ) {
            $query->set('post_type', array( 'ova_audio_host' ) );
            $query->set('posts_per_page', get_theme_mod( 'ovau_host_total_record', 6 ) );
            $query->set('order', get_theme_mod( 'ovau_host_archive_order', 'ASC' ) );

            $orderby = get_theme_mod( 'ovau_host_archive_orderby', 'ovau_host_order' );

            if ( 'ovau_host_order' === $orderby ) {
                $query->set('orderby', 'meta_value_num' );
                $query->set('meta_type', 'NUMERIC' );
                $query->set('meta_key', 'ovau_host_order' );
            } else {
                $query->set('orderby', $orderby );
            }
        }
    }
}

// Audio Host data element
if ( !function_exists( 'ovau_get_data_audio_host_el' ) ) {
    function ovau_get_data_audio_host_el( $args ){

        $args_new = array(
            'post_type' => 'ova_audio_host',
            'post_status' => 'publish',
            'posts_per_page' => $args['total_count'],
            'fields' => 'ids',
        );

        $args_audio_host_order = [];
        if( $args['orderby'] === 'ovau_host_order' ) {
            $args_audio_host_order = [
                'meta_key'   => $args['orderby'],
                'orderby'    => 'meta_value_num',
                'meta_type' => 'NUMERIC',
                'order'   => "ASC",
            ];
        } else { 
            $args_audio_host_order = [
                'orderby'        => $args['orderby'],
            ];
        }

        $args_audio_host = array_merge( $args_new, $args_audio_host_order );

        $audio_hosts  = new \WP_Query($args_audio_host);

        return $audio_hosts;
    }
}

// Hosts
if ( !function_exists( 'ovau_get_hosts' ) ) {
    function ovau_get_hosts() {
        $arr_hosts = array();

        $base_query = array(
           'post_type'      => 'ova_audio_host',
           'posts_per_page' => -1,
           'post_status'    => 'publish',
           'orderby'        => 'meta_value_num',
           'order'          => 'ASC',
           'meta_type'      => 'NUMERIC',
           'meta_key'       => 'ovau_host_order',
           'fields'         => 'ids'
        );

        $hosts = new \WP_Query( $base_query );
        wp_reset_postdata();

        if (  $hosts && is_object( $hosts ) && $hosts->posts ) {
            foreach ( $hosts->posts as $host_id ) {
                $arr_hosts[$host_id] = get_the_title( $host_id );
            }
        }

        return $arr_hosts;
    }
}

// Get form Donations
if ( !function_exists( 'ovau_get_form_donations' ) ) {
    function ovau_get_form_donations() {
        $arr_donations = array();

        $base_query = array(
           'post_type'      => 'give_forms',
           'posts_per_page' => -1,
           'post_status'    => 'publish',
           'orderby'        => 'date',
           'order'          => 'ASC',
           'fields'         => 'ids'
        );

        $donations = new \WP_Query( $base_query );
        wp_reset_postdata();

        if (  $donations && is_object( $donations ) && $donations->posts ) {
            foreach ( $donations->posts as $donation_id ) {
                $arr_donations[$donation_id] = get_the_title( $donation_id );
            }
        }

        return $arr_donations;
    }
}

// Query get post count audio
if ( !function_exists( 'ovau_get_post_count_audio' ) ) {
    function ovau_get_post_count_audio() {
        $count_audio = '';

        $base_query = array(
           'post_type'      => 'ova_audio',
           'posts_per_page' => -1,
           'post_status'    => 'publish',
           'fields'         => 'ids'
        );

        $hosts = new \WP_Query( $base_query );
        wp_reset_postdata();

        if (  $hosts && is_object( $hosts ) ) {
            $count_audio = $hosts->post_count;
        }

        return $count_audio;
    }
}

// Get default Episode
if ( !function_exists( 'ovau_get_episode' ) ) {
    function ovau_get_episode() {
        $episode        = esc_html__( 'Episode 1', 'ovau' );
        $count_audio    = ovau_get_post_count_audio();

        if ( $count_audio ) {
            $episode = esc_html__( 'Episode ', 'ovau' ) . $count_audio;
        }

        return $episode;
    }
}

// Get default Sort Order Audio
if ( !function_exists( 'ovau_get_sort_order_audio' ) ) {
    function ovau_get_sort_order_audio() {
        $count_audio    = ovau_get_post_count_audio();
        $order          = $count_audio ? $count_audio: 1;

        return $order;
    }
}

// Get default Sort Order
if ( !function_exists( 'ovau_get_sort_order_host' ) ) {
    function ovau_get_sort_order_host() {
        $order = 1;

        $base_query = array(
           'post_type'      => 'ova_audio_host',
           'posts_per_page' => -1,
           'post_status'    => 'publish',
           'fields'         => 'ids'
        );

        $hosts = new \WP_Query( $base_query );
        wp_reset_postdata();

        if (  $hosts && is_object( $hosts ) ) {
            $count_hosts = $hosts->post_count;

            if ( $count_hosts ) {
                $order = $count_hosts;
            }
        }

        return $order;
    }
}

// htmlspecialchars <iframe>
if ( !function_exists( 'ovau_sanitization_cb_iframe' ) ) {
    function ovau_sanitization_cb_iframe( $value, $field_args, $field ) {
        $value = htmlspecialchars_decode( $value );

        return $value;
    }
}

// filter oembed
if ( !function_exists( 'ovau_filter_oembed_result' ) ) {
    function ovau_filter_oembed_result( $html ) {
        if ( $html ) {
            $param_keys = array(
                'auto_play'         => 'false',
                'buying'            => 'true',
                'liking'            => 'true',
                'download'          => 'true',
                'sharing'           => 'true',
                'show_comments'     => 'true',
                'show_playcount'    => 'true',
                'show_user'         => 'true',
                'show_artwork'      => 'true',
            );

            $params = apply_filters( 'ft_ovau_oembed_params', $param_keys );
            $visual = apply_filters( 'ft_ovau_oembed_visual', 'false' );
            $height = apply_filters( 'ft_ovau_oembed_height', 'auto' );

            preg_match( '/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $html, $matches );

            $url = esc_url( add_query_arg( $params, $matches[1] ) );

            $html = str_replace( [ $matches[1], 'visual=true' ], [ $url, 'visual=' . $visual ], $html );

            if ( 'false' === $visual ) {
                $html = str_replace( 'height="400"', 'height="'.$height.'"', $html );
            }
        }

        return $html;
    }
}

// Get Audio Featured
if ( !function_exists( 'ovau_get_audio_featured' ) ) {
    function ovau_get_audio_featured( $args ) {
        $total_posts    = isset($args['total_posts'])   ? $args['total_posts'] : apply_filters( 'el_ova_audio_featured_total_posts', 3 );
        $order          = isset($args['order'])         ? $args['order']    : 'ASC';
        $orderby        = isset($args['orderby'])       ? $args['orderby']  : 'ovau_order';
        $featured       = isset($args['featured'])      ? $args['featured'] : '';
        $category       = isset($args['category'])      ? $args['category'] : '';
        $paged          = isset($args['paged'])         ? $args['paged']    : 1;

        $start_date     = isset($args['start_date'])    ? $args['start_date']   : '';
        $end_date       = isset($args['end_date'])      ? $args['end_date']     : '';
        $season         = isset($args['season'])        ? $args['season']       : 'all';

        $start_day   = date("d",strtotime($start_date));
        $start_month = date("m",strtotime($start_date));
        $start_year  = date("Y",strtotime($start_date));

        $end_day   = date("d",strtotime($end_date));
        $end_month = date("m",strtotime($end_date));
        $end_year  = date("Y",strtotime($end_date));
        
        // Base Query
        $base_query = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $total_posts,
            'order'             => $order,
            'paged'             => $paged,
        );

        if ( 'yes' === $featured ) {
            $base_query['meta_query'] = array(
                array(
                    'key'     => 'ovau_featured',
                    'value'   => 'on',
                    'compare' => '=',
                ),
            );
        }


        if ( $start_date != '' && $end_date != ''  ) {
            $base_query['date_query'] = array(
                array(
                    'after'  => array(
                        'year'   => $start_year,
                        'month'  => $start_month,
                        'day'    => $start_day,
                    ),
                    'before'     => array(
                        'year'   => $end_year,
                        'month'  => $end_month,
                        'day'    => $end_day,
                    ),
                    'inclusive' => true,
                )
            );
        } elseif( $start_date != '' ) {
            $base_query['date_query'] = array(
                array(
                    'after'  => array(
                        'year'   => $start_year,
                        'month'  => $start_month,
                        'day'    => $start_day,
                    ),
                    'before'     => array(
                        'year'   => 2050,
                        'month'  => $end_month,
                        'day'    => $end_day,
                    ),
                    'inclusive' => true,
                )
            );
        } elseif( $end_date != '' ) {
            $base_query['date_query'] = array(
               array(
                    'after'  => array(
                        'year'   => 2000,
                        'month'  => $start_month,
                        'day'    => $start_day,
                    ),
                    'before'     => array(
                        'year'   => $end_year,
                        'month'  => $end_month,
                        'day'    => $end_day,
                    ),
                    'inclusive' => true,
                )
            );
        }

        // Order by
        if ( 'ovau_order' === $orderby ) {
            $base_query['orderby']      = 'meta_value_num';
            $base_query['meta_type']    = 'NUMERIC';
            $base_query['meta_key']     = 'ovau_order';
        } else {
            $base_query['orderby']      = $orderby;
        }

        // Tax Query
        if ( ($category && 'all' != $category) && ($season && 'all' != $season) ) {
            $base_query['tax_query'] = array(
               'relation' => 'AND',
                array(
                    'taxonomy' => 'category_audio',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
                array(
                   'taxonomy' => 'season_audio',
                    'field'    => 'slug',
                    'terms'    => $season,
                ),
            );
        } elseif ( $category && 'all' != $category ) {
            $base_query['tax_query'] = array(
                array(
                    'taxonomy' => 'category_audio',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
            );
        } elseif ( $season && 'all' != $season ) {
            $base_query['tax_query'] = array(
                array(
                   'taxonomy' => 'season_audio',
                    'field'    => 'slug',
                    'terms'    => $season,
                ),
            );
        }

        $audios = new \WP_Query( $base_query );

        return $audios;
    }
}

// Get Audio by Category
if ( !function_exists( 'ovau_get_audio_by_category' ) ) {
    function ovau_get_audio_by_category( $args ) {
        $total_posts    = $args['total_posts'] ? $args['total_posts'] : apply_filters( 'el_ova_audio_seasons_total_posts', 3 );
        $category       = $args['category'] ? $args['category'] : 'all';
        $order          = $args['order'] ? $args['order'] : 'ASC';
        $orderby        = $args['orderby'] ? $args['orderby'] : 'ovau_order';

        // Base Query
        $base_query = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $total_posts,
            'order'             => $order,
            'fields'            => 'ids'
        );

        // Order by
        if ( 'ovau_order' === $orderby ) {
            $base_query['orderby']      = 'meta_value_num';
            $base_query['meta_type']    = 'NUMERIC';
            $base_query['meta_key']     = 'ovau_order';
        } else {
            $base_query['orderby']      = $orderby;
        }

        // Category
        if ( $category && 'all' != $category ) {
            $base_query['tax_query'] = array(
                array(
                    'taxonomy' => 'category_audio',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
            );
        }

        $audios = new \WP_Query( $base_query );

        return $audios;
    }
}

// Get Audio Seasons
if ( !function_exists( 'ovau_get_audio_by_seasons' ) ) {
    function ovau_get_audio_by_seasons( $args ) {
        $total_posts    = $args['total_posts'] ? $args['total_posts'] : apply_filters( 'el_ova_audio_seasons_total_posts', 3 );
        $season         = $args['season'] ? $args['season'] : 'all';
        $order          = $args['order'] ? $args['order'] : 'ASC';
        $orderby        = $args['orderby'] ? $args['orderby'] : 'ovau_order';

        // Base Query
        $base_query = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $total_posts,
            'order'             => $order,
            'fields'            => 'ids'
        );

        // Order by
        if ( 'ovau_order' === $orderby ) {
            $base_query['orderby']      = 'meta_value_num';
            $base_query['meta_type']    = 'NUMERIC';
            $base_query['meta_key']     = 'ovau_order';
        } else {
            $base_query['orderby']      = $orderby;
        }

        // Seasons
        if ( $season && 'all' != $season ) {
            $base_query['tax_query'] = array(
                array(
                    'taxonomy' => 'season_audio',
                    'field'    => 'slug',
                    'terms'    => $season,
                ),
            );
        }

        $audios = new \WP_Query( $base_query );

        return $audios;
    }
}

// Get Audio Podcast
if ( !function_exists( 'ovau_get_audio_podcast' ) ) {
    function ovau_get_audio_podcast( $args ) {
        $total_posts    = $args['total_posts'] ? $args['total_posts'] : apply_filters( 'el_ova_audio_list_total_posts', 5 );
        $categories     = $args['categories'] ? $args['categories'] : array();
        $order          = $args['order'] ? $args['order'] : 'ASC';
        $orderby        = $args['orderby'] ? $args['orderby'] : 'ovau_order';

        // Base Query
        $base_query = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $total_posts,
            'order'             => $order,
            'fields'            => 'ids'
        );

        // Order by
        if ( 'ovau_order' === $orderby ) {
            $base_query['orderby']      = 'meta_value_num';
            $base_query['meta_type']    = 'NUMERIC';
            $base_query['meta_key']     = 'ovau_order';
        } else {
            $base_query['orderby']      = $orderby;
        }

        // Category
        if ( !empty( $categories ) && is_array( $categories ) ) {
            $base_query['tax_query'] = array(
                array(
                    'taxonomy' => 'category_audio',
                    'field'    => 'slug',
                    'terms'    => $categories,
                ),
            );
        }

        $audios = new \WP_Query( $base_query );

        return $audios;
    }
}

// Get Audio Data by ids (select manual audios)
if ( !function_exists( 'ovau_get_data_audio_manual' ) ) {
    function ovau_get_data_audio_manual( $args ){

        $audio_id = isset($args['audio_id']) ? $args['audio_id'] : array();

        $total_posts    = isset($args['total_posts'])  ? $args['total_posts']  : 3;
        $order          = isset($args['order'])        ? $args['order']        : 'ASC';
        $orderby        = isset($args['orderby'])      ? $args['orderby']      : 'ovau_order';

        $base_query = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $total_posts,
            'order'             => $order,
            'fields'            => 'ids',
            'post__in'          => $audio_id
        );

        // Order by
        if ( 'ovau_order' === $orderby ) {
            $base_query['orderby']      = 'meta_value_num';
            $base_query['meta_type']    = 'NUMERIC';
            $base_query['meta_key']     = 'ovau_order';
        } else {
            $base_query['orderby']      = $orderby;
        }

        $audio = new \WP_Query($base_query);

        return $audio;
    }
}

// Get Audio Data
if ( !function_exists( 'ovau_get_data_audio_el' ) ) {
    function ovau_get_data_audio_el( $args ){

        $total_posts    = isset($args['total_posts'])  ? $args['total_posts']  : 3;
        $offset         = isset($args['offset'])       ? $args['offset']       : 0;
        $categories     = isset($args['categories'])   ? $args['categories']   : array();
        $order          = isset($args['order'])        ? $args['order']        : 'ASC';
        $orderby        = isset($args['orderby'])      ? $args['orderby']      : 'ovau_order';
        $paged          = isset($args['paged'])        ? $args['paged']        : 1;

        // Base Query
        $base_query = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $total_posts,
            'order'             => $order,
            'offset'            => $offset,
            'paged'             => $paged,
            'fields'            => 'ids'
        );

        if ( isset($args['no_offset']) ) {
            $base_query = array(
                'post_type'         => 'ova_audio',
                'post_status'       => 'publish',
                'posts_per_page'    => $total_posts,
                'order'             => $order,
                'paged'             => $paged,
                'fields'            => 'ids'
            );
        }

        // Order by
        if ( 'ovau_order' === $orderby ) {
            $base_query['orderby']      = 'meta_value_num';
            $base_query['meta_type']    = 'NUMERIC';
            $base_query['meta_key']     = 'ovau_order';
        } else {
            $base_query['orderby']      = $orderby;
        }

        // Category
        if ( !empty( $categories ) && is_array( $categories ) ) {
            $base_query['tax_query'] = array(
                array(
                    'taxonomy' => 'category_audio',
                    'field'    => 'slug',
                    'terms'    => $categories,
                ),
            );
        }

        $audios = new \WP_Query( $base_query );

        return $audios;
    }
}

// Get Audio Slider
if ( !function_exists( 'ovau_get_data_audio_slider_el' ) ) {
    function ovau_get_data_audio_slider_el( $args ){

        $category       = $args['category'];
        $post_per_page  = $args['total_count'];
        $order          = $args['order'] ? $args['order'] : 'ASC';

        $args_new = array(
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $post_per_page,
            'order'             => $order,
            'fields'            => 'ids',
        );

        if( isset($args['exclude_ids']) ) {
            $args_new = array(
                'post_type'         => 'ova_audio',
                'post_status'       => 'publish',
                'posts_per_page'    => $post_per_page,
                'order'             => $order,
                'fields'            => 'ids',
                'post__not_in'      => array($args['exclude_ids'])
            );
        }
    
        if( $category != 'all' ) {
            $args_new['tax_query'] = array(
                array(
                    'taxonomy' => 'category_audio',
                    'field'    => 'slug',
                    'terms'    => $category,
                )
            );
        }

        $args_meta_query = [];
        if( isset( $args['show_featured'] ) &&  ( $args['show_featured'] === 'yes' ) ) {
            $args_meta_query['meta_query'] = array(
                array(
                    'key'     => 'ovau_featured', 
                    'value'   => 'on', 
                    'compare' => '=',
                ),
            );
        } else { 
            $args_meta_query = [];
        }

        if( isset( $args['host'] ) &&  ( $args['host'] != 0 ) ) {
            $args_meta_query_hosts['meta_query'] = array(
                array(
                    'key'     => 'ovau_host_id', 
                    'value'   => $args['host'], 
                    'compare' => '=',
                ),
            );
        } else { 
            $args_meta_query_hosts = [];
        }

        $args_audio_order = [];
        if( $args['orderby'] === 'ovau_order' ) {
            $args_audio_order = [
                'meta_key'      => $args['orderby'],
                'orderby'       => 'meta_value_num',
                'meta_type'     => 'NUMERIC',
            ];
        } else { 
            $args_audio_order = [
                'orderby'        => $args['orderby'],
            ];
        }

        $args_audio = array_merge( $args_new, $args_meta_query, $args_meta_query_hosts, $args_audio_order );

        $audio      = new \WP_Query($args_audio);

        return $audio;
    }
}

/* Get Categories Audio */
if ( ! function_exists( 'ovau_get_category_filter' ) ) {

    function ovau_get_category_filter( $settings ) {
        $args = [
            'taxonomy'  => 'category_audio',
            'order'     => $settings['category_order'],
            'orderby'   => $settings['category_order_by']  
        ];

        if ( $settings['category_not_in'] ) {
            $args['exclude'] = explode( '|', $settings['category_not_in'] );
        }

        $categories = get_categories( $args );
        $result     = [];

        if ( $categories ) {
            foreach ( $categories as $category ) {
                $args_category = [
                    'slug' => $category->slug,
                    'name' => $category->cat_name,
                ];
                array_push( $result, $args_category );
            }
        }

        return $result;
    }
}

/* Get Posts Audio */
if ( ! function_exists( 'ovau_get_list_category_filter' ) ) {

    function ovau_get_list_category_filter( $settings ) {
        $list_category_filter = [
            'post_type'         => 'ova_audio',
            'post_status'       => 'publish',
            'posts_per_page'    => $settings['posts_per_page'],
            'paged'             => isset( $settings['paged'] ) ? $settings['paged'] : 1,
            'orderby'           => $settings['order_by'],
            'order'             => $settings['order'],
            'fields'            => 'ids',
            'tax_query'         => [],
        ];

        $slug = isset( $settings['slug'] ) ? $settings['slug'] : '';

        if ( $slug && $settings['category_not_in'] ) {
            $list_category_filter['tax_query']['relation'] = "AND";
        }

        if ( $slug ) {
            $category_args = [
                'taxonomy' => 'category_audio',
                'field'    => 'slug',
                'terms'    => $slug,
            ];
            array_push( $list_category_filter['tax_query'], $category_args );
        }

        if ( $settings['category_not_in'] ) {
            $category_not_in = [
                [
                    'taxonomy'  => 'category_audio',
                    'field'     => 'term_id',
                    'terms'     => explode( '|', $settings['category_not_in'] ),
                    'operator'  => 'NOT IN',
                ],
            ];
            array_push( $list_category_filter['tax_query'], $category_not_in );
        }

        $result  = new WP_Query( $list_category_filter );

        return $result;
    }
}

/* Get Posts Audio For Single Host */
if ( !function_exists( 'ovau_get_data_audio_host_single' ) ) {
    function ovau_get_data_audio_host_single( $args ){

        $args_new = array(
            'post_type' => 'ova_audio',
            'post_status' => 'publish',
            'posts_per_page' => $args['number_audio'],
            'orderby'    => 'ID',
            'order'   => 'DESC',
            'fields' => 'ids',
        );

        if( isset( $args['id'] ) &&  ( $args['id'] != 0 ) ) {
            $args_meta_query['meta_query'] = array(
                array(
                    'key'     => 'ovau_host_id', 
                    'value'   => $args['id'], 
                    'compare' => '=',
                ),
            );
        } else { 
            $args_meta_query = [];
        }

        $args_audio = array_merge( $args_new, $args_meta_query);

        $audio      = new \WP_Query($args_audio);

        return $audio;
    }
}