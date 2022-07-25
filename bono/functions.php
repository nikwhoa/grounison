<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Pimple\Psr11\Container;
use Psr\Container\ContainerInterface;
use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\Favorite;
use Wpshop\TheTheme\ProductTabs;

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/core/constants.php';
require __DIR__ . '/core/init.php';

/**
 * @return ContainerInterface
 */
function theme_container() {
    static $container;
    if ( ! $container ) {
        $config    = require __DIR__ . '/core/config.php';
        $init      = require __DIR__ . '/core/container.php';
        $container = new Container( $init( $config ) );
    }

    return $container;
}

/**
 * Check if WooCommerce plugin is enabled
 *
 * @return bool
 */
function is_wc_enabled() {
    return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/**
 * Check if WP-PostViews plugin is enabled
 *
 * @return bool
 */
function is_postviews_enabled() {
    return in_array( 'wp-postviews/wp-postviews.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}

/**
 * @return bool
 * @deprecated
 */
function bono_is_home_page() {
    return is_front_page() || is_home();
}

/**
 * @return bool
 * @deprecated
 */
function bono_is_blog_page() {
    $show_on_front  = get_option( 'show_on_front' );
    $page_for_posts = get_option( 'page_for_posts' );

    return $show_on_front === 'page' &&
           $page_for_posts &&
           get_queried_object_id() == $page_for_posts;
}

/**
 * @return bool
 */
function bono_is_favorite_page() {
    return theme_container()->get( Favorite::class )->is_favorite_page();
}

/**
 * @return bool
 */
function bono_is_compare_page() {
    return theme_container()->get( CompareProducts::class )->is_compare_page();
}

/**
 * Transforms:
 * <pre>
 * [
 *     'slide_item[1][header]'      => 'header 1',
 *     'slide_item[2][header]'      => 'header 2',
 *     'slide_item[1][description]' => 'description 1',
 *     'slide_item[2][description]' => 'description 2',
 * ]
 * </pre>
 * to
 * <pre>
 * 'slide_item' => [
 *     1 => [
 *         'header'      => 'header 1'
 *         'description' => 'description 1'
 *     ],
 *     2 => [
 *         'header'      => 'header 2'
 *         'description' => 'description 2'
 *     ],
 * ]
 * </pre>
 *
 * @param array  $items
 * @param string $prefix
 *
 * @return mixed
 */
function transform_slide_items_data( $items, $prefix = 'slide_items' ) {

    $others     = [];
    $to_implode = [];
    foreach ( $items as $key => $value ) {
        if ( substr( $key, 0, strlen( $prefix ) + 1 ) === $prefix . '[' ) {
            $to_implode[] = $key . '=' . rawurldecode( $value );
        } else {
            $others[ $key ] = $value;
        }
    }
    $result = [];
    parse_str( implode( '&', $to_implode ), $result );

    if ( isset( $result[ $prefix ] ) && is_array( $result[ $prefix ] ) ) {
        $result[ $prefix ] = array_values( $result[ $prefix ] ); // reset indexes
    }

    return $others + $result;
}

if ( ! function_exists( 'woocommerce_default_product_tabs' ) ) {

    /**
     * Add default product tabs to product pages.
     *
     * @param array $tabs Array of tabs.
     *
     * @return array
     */
    function woocommerce_default_product_tabs( $tabs = [] ) {

        global $product, $post;

        // Description tab - shows product content.
        if ( $post->post_content ) {
            $tabs['description'] = [
                'title'    => __( 'Description', 'woocommerce' ),
                'priority' => 10,
                'callback' => 'woocommerce_product_description_tab',
            ];
        } elseif ( is_customize_preview() ) {
            $tabs['description'] = [
                'title'    => __( 'Description', 'woocommerce' ),
                'priority' => 10,
                'callback' => [ theme_container()->get( ProductTabs::class ), 'dummy_callback' ],
            ];
        }

        // Additional information tab - shows attributes.
        if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
            $tabs['additional_information'] = [
                'title'    => __( 'Additional information', 'woocommerce' ),
                'priority' => 20,
                'callback' => 'woocommerce_product_additional_information_tab',
            ];
        } elseif ( is_customize_preview() ) {
            $tabs['additional_information'] = [
                'title'    => __( 'Additional information', 'woocommerce' ),
                'priority' => 20,
                'callback' => [ theme_container()->get( ProductTabs::class ), 'dummy_callback' ],
            ];
        }

        // Reviews tab - shows comments.
        if ( comments_open() ) {
            $tabs['reviews'] = [
                /* translators: %s: reviews count */
                'title'    => sprintf( __( 'Reviews (%d)', 'woocommerce' ), $product->get_review_count() ),
                'priority' => 30,
                'callback' => 'comments_template',
            ];
        } elseif ( is_customize_preview() ) {
            $tabs['reviews'] = [
                'title'    => sprintf( __( 'Reviews (%d)', 'woocommerce' ), $product->get_review_count() ),
                'priority' => 30,
                'callback' => [ theme_container()->get( ProductTabs::class ), 'dummy_callback' ],
            ];
        }

        return $tabs;
    }
}

if ( ! function_exists( 'bono_track_product_view' ) ) {
    /**
     * @see wc_track_product_view()
     */
    function bono_track_product_view() {
        if ( is_active_widget( false, false, 'woocommerce_recently_viewed_products', true ) ) {
            return; // because it will be handled with original function
        }

        if ( ! is_singular( 'product' ) ) {
            return;
        }

        global $post;

        if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) { // @codingStandardsIgnoreLine.
            $viewed_products = [];
        } else {
            $viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
        }

        // Unset if already in viewed products list.
        $keys = array_flip( $viewed_products );

        if ( isset( $keys[ $post->ID ] ) ) {
            unset( $viewed_products[ $keys[ $post->ID ] ] );
        }

        $viewed_products[] = $post->ID;

        if ( count( $viewed_products ) > 15 ) {
            array_shift( $viewed_products );
        }

        // Store for session only.
        wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
    }
}

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
 function jk_related_products_args( $args ) {

$args['posts_per_page'] = 3; // количество "Похожих товаров"
 $args['columns'] = 1; // количество колонок
 return $args;
}

add_filter( 'woocommerce_recently_viewed', 'jk_recently_viewed_products' );
 function jk_recently_viewed_products( $args ) {

$args['posts_per_page'] = 3; // количество "Похожих товаров"
 $args['columns'] = 1; // количество колонок
 return $args;
}

// gdfgfdggfdg


/**
 * Add field to show slogan after logo
 */
add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets(){

	register_sidebar( array(
		'name'          => __('Slogan'),
		'id'            => "slogan",
		'description'   => 'Slogan after logo',
		'class'         => '',
		'before_widget' => '<div id="%1$s" class="slogan_widget widget %2$s">',
		'after_widget'  => "</div>\n",

	) );
}

/* Register a custom post type  */

function wpdocs_codex_slider_init() {
	$labels = array(
		'name'                  => _x( 'Slider', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Slider', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Slider', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Slider', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add Slide', 'textdomain' ),
		'add_new_item'          => __( 'Add New Slider', 'textdomain' ),
		'new_item'              => __( 'New Slider', 'textdomain' ),
		'edit_item'             => __( 'Edit Slider', 'textdomain' ),
		'view_item'             => __( 'View Slider', 'textdomain' ),
		'all_items'             => __( 'All Slider', 'textdomain' ),
		'search_items'          => __( 'Search Slider', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent Slider:', 'textdomain' ),
		'not_found'             => __( 'No Slider found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No Slider found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Slider Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'archives'              => _x( 'Slider archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
		'insert_into_item'      => _x( 'Insert into products', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this products', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
		'filter_items_list'     => _x( 'Filter sliders list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
		'items_list_navigation' => _x( 'Sliders list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
		'items_list'            => _x( 'Sliders list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'slides' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'taxonomies'         => array('post_tag'),
		'supports'           => array('title', 'thumbnail'),
		'menu_icon'          => 'dashicons-format-gallery',
	);

	register_post_type( 'slide', $args );
}

add_action( 'init', 'wpdocs_codex_slider_init' );