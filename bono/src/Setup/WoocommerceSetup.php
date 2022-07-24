<?php

namespace Wpshop\TheTheme\Setup;

use WC_Shortcodes;
use Wpshop\Core\AdminNotices;
use Wpshop\Core\Breadcrumbs;
use Wpshop\Core\Core;
use Wpshop\TheTheme\Shortcode\Products;

class WoocommerceSetup {

    const DEFAULT_PRODUCTS_PER_PAGE  = 12;
    const DEFAULT_SHOP_COLUMNS_COUNT = 4;

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var Breadcrumbs
     */
    protected $breadcrumbs;

    /**
     * @var AdminNotices
     */
    protected $notices;

    /**
     * WoocommerceSetup constructor.
     *
     * @param Core         $core
     * @param Breadcrumbs  $breadcrumbs
     * @param AdminNotices $notices
     */
    public function __construct( Core $core, Breadcrumbs $breadcrumbs, AdminNotices $notices ) {
        $this->core        = $core;
        $this->breadcrumbs = $breadcrumbs;
        $this->notices     = $notices;
    }

    /**
     * @return void
     */
    public function init() {

        $this->extendWcSettings();

        if ( ! has_filter( 'woocommerce_product_get_short_description', 'wpautop' ) ) {
            add_filter( 'woocommerce_product_get_short_description', 'wpautop' );
        }

        if ( add_filter( 'bono_remove_loop_rating', true ) ) {
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        }

        // remove product gallery zoom image
        if ( is_wc_enabled() && ! static::is_image_zoom_disabled() ) {
            add_action( 'wp_enqueue_scripts', function () {
                $script = <<<'JS'
	jQuery(function($) {
	    $('.woocommerce-product-gallery').each(function () {
	        $(this).on('wc-product-gallery-after-init', function (e, gallery) {
	            $(gallery).find('.woocommerce-product-gallery__trigger').remove();
	            $(gallery).prepend( '<a href="#" class="woocommerce-product-gallery__trigger"></a>' );
	        });
	    });
	});
JS;
                wp_add_inline_script( 'zoom', $script, 'before' );
            } );
        }

        add_action( 'init', [ $this, '_wrap_sorting' ] );

        $this->breadcrumbs->set_separator(
            $breadcrumbs_separator = '&nbsp;&nbsp;<span class="wci-chevron-right"></span>&nbsp;&nbsp;'
        );
        add_filter( 'woocommerce_breadcrumb_defaults', function ( $args ) use ( $breadcrumbs_separator ) {
            $args['delimiter'] = $breadcrumbs_separator;

            return $args;
        } );

        $this->fix_loop_category_title();
        $this->fix_breadcrumbs_trailed();

        add_action( 'woocommerce_before_mini_cart', [ $this, '_before_mini_cart_close_mark' ] );

        add_filter( 'woocommerce_product_description_heading', function () {
            return null;
        } );
        add_filter( 'woocommerce_product_additional_information_heading', function () {
            return null;
        } );

        add_filter( 'woocommerce_loop_add_to_cart_args', function ( $args ) {
            $args['class'] = 'shop-item__buttons-cart' . ( isset( $args['class'] ) ? ' ' . $args['class'] : '' );

            return $args;
        } );

        add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
            $fragments['sup.bono_header_widget_shopping_cart_count'] = sprintf(
                '<sup class="bono_header_widget_shopping_cart_count">%s</sup>',
                WC()->cart->get_cart_contents_count()
            );

            return $fragments;
        } );

        add_action( 'woocommerce_after_quantity_input_field', function () {
            echo '<button type="button" class="quantity-minus"></button>';
            echo '<button type="button" class="quantity-plus"></button>';
        } );

        add_action( 'init', function () {
            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
            add_action( 'woocommerce_after_cart', function () {
                woocommerce_cross_sell_display( 4, 4 );
            } );
        } );

//		add_filter( 'woocommerce_widget_cart_is_hidden', '__return_true' );


//		add_action( 'wp_enqueue_scripts', function () {
//			wp_enqueue_style( 'bono-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );
//
//			$font_path   = WC()->plugin_url() . '/assets/fonts/';
//			$inline_font = '@font-face {
//			font-family: "star";
//			src: url("' . $font_path . 'star.eot");
//			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
//				url("' . $font_path . 'star.woff") format("woff"),
//				url("' . $font_path . 'star.ttf") format("truetype"),
//				url("' . $font_path . 'star.svg#star") format("svg");
//			font-weight: normal;
//			font-style: normal;
//		}';
//
//			wp_add_inline_style( 'bono-woocommerce-style', $inline_font );
//		} );

        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

        add_filter( 'body_class', function ( $classes ) {
            $classes[] = 'woocommerce-active';

            return $classes;
        } );

        add_filter( 'woocommerce_product_thumbnails_columns', function () {
            return 4;
        } );

//		add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
//			$defaults = [
//				'posts_per_page' => 3,
//				'columns'        => 3,
//			];
//
//			$args = wp_parse_args( $defaults, $args );
//
//			return $args;
//		} );

        add_action( 'woocommerce_after_single_product_summary', [ $this, '_add_recently_viewed' ], 30 );

        $this->add_no_wc_notice();


        /**
         * Remove braces from category and product category widget
         */
        add_filter( 'wp_list_categories', $bono_list_categories_hook = function ( $output ) {
            $output = preg_replace( '/\(([0-9]+)+?\)/ui', '<sup>$1</sup>', $output );

            return $output;
        } );

        add_filter( 'woocommerce_layered_nav_count', $woocommerce_layered_nav_count_hook = function ( $count ) {
            $count = str_replace( '<span', '<sup', $count );
            $count = str_replace( '</span>', '</sup>', $count );
            $count = str_replace( '(', '', $count );
            $count = str_replace( ')', '', $count );

            return $count;
        } );

        add_filter( 'woocommerce_rating_filter_count', $woocommerce_rating_filter_count_hook = function ( $count ) {
            $count = str_replace( '(', '', $count );
            $count = str_replace( ')', '', $count );

            return '<span class="sup">' . $count . '</span>';
        } );

        add_filter( 'woocommerce_variable_price_html', [ $this, '_filter_variable_price' ], 20, 2 );

        add_filter( 'wpshop_advertising_do_show', function ( $result ) {
            if ( ! is_wc_enabled() ) {
                return $result;
            }

            if ( is_product() ) { // hide ad from product description
                $result = false;
            }

            return $result;
        } );

        add_filter( 'bono_is_page_woocommerce', function ( $result ) {
            if ( ! $result ) {
                $result = is_cart() || is_checkout() || is_account_page();
            }

            return $result;
        } );

        add_filter( 'woocommerce_product_get_short_description', function ( $value ) {
            return do_shortcode( $value );
        } );

        add_action( 'template_redirect', 'bono_track_product_view', 21 );
        add_filter( 'woocommerce_shortcode_products_query', [
            $this,
            'filter_woocommerce_shortcode_products_query',
        ], 10, 3 );

        do_action( __METHOD__, $this );
    }

    /**
     * Require to update query of recently viewed products, shortcode [recent_products]
     *
     * @param array  $args
     * @param array  $attributes
     * @param string $type
     *
     * @return mixed
     */
    public function filter_woocommerce_shortcode_products_query( $args, $attributes, $type ) {
        if ( 'recent_products' === $type ) {
            $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] )
                ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) )
                : [];
            $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

            if ( ! empty( $viewed_products ) ) {
                $args['post__in']  = $viewed_products;
                $args['orderby']   = 'post__in';
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'outofstock',
                        'operator' => 'NOT IN',
                    ],
                ];
            }
        }

        return $args;
    }

    /**
     * @return void
     */
    protected function add_no_wc_notice() {
        $this->notices->add_notice( 'no_wc', function ( $close_link ) {
            if ( is_wc_enabled() ) {
                return;
            }

            $plugin = 'woocommerce';
            $link   = '<a href="' . esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin . '&TB_iframe=true&width=600&height=550' ) ) . '" class="thickbox" title="More info about ' . $plugin . '">' . __( 'here', THEME_TEXTDOMAIN ) . '</a>';

            echo '<div class="notice notice-warning">';
            printf( '<a href="%s" class="notice-dismiss" style="position: static; float: right; text-decoration: none;"></a>', $close_link );
            echo '<p>' . sprintf(
                    __( 'Your site does not appear to be using WooCommerce plugin. To get more advantage from the theme you can setup the plugin %s', THEME_TEXTDOMAIN ),
                    $link
                ) . '</p>';
            echo '</div>';
        } );
    }

    /**
     * @return void
     */
    public function _add_recently_viewed() {
        $columns = absint( $this->core->get_option( 'bono_wc_recently_viewed_columns' ) );
        $limit   = absint( $this->core->get_option( 'bono_wc_recently_viewed_limit' ) );

        if ( ! $columns || ! $limit ) {
            return;
        }

        $header = apply_filters( 'bono_recently_viewed__header', __( 'Recently viewed products', THEME_TEXTDOMAIN ) );
        echo WC_Shortcodes::shortcode_wrapper(
            function ( $atts ) {
                $atts = array_merge( [
                    'limit'        => '12',
                    'columns'      => '4',
                    'orderby'      => 'date',
                    'order'        => 'DESC',
                    'category'     => '',
                    'cat_operator' => 'IN',
                ], (array) $atts );

                $shortcode = new Products( $atts, 'recent_products' );

                $shortcode->set_template( 'content', 'product-small' );

                echo $shortcode->get_content();
            },
            [
                'columns' => $columns,
                'limit'   => $limit,
            ],
            [
                'before' => '<div class="related-products"><div class="related-products__header">' . $header . '</div>',
                'after'  => '</div>',
            ]
        );
    }

    /**
     *
     * @return void
     */
    public function _before_mini_cart_close_mark() {
        echo apply_filters(
            THEME_SLUG . '_woocommerce_mini_cart_close_content',
            '<div class="woocommerce-mini-cart__close js-woocommerce-mini-cart-close"></div>'
        );
    }

    /**
     * @return void
     */
    public function _wrap_sorting() {
        if ( has_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices' ) ) {
            remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices' );
            add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 7 );
        }

        add_action( 'woocommerce_before_shop_loop', function () {
            echo '<div class="shop-sorting">';
        }, 8 );
        add_action( 'woocommerce_before_shop_loop', function () {
            echo '</div><!-- /.shop-sorting -->';
        }, 30 );
    }

    /**
     * @param string      $price
     * @param \WC_Product $product
     *
     * @return string
     */
    public function _filter_variable_price( $price, $product ) {
        if ( ! $this->core->get_option( 'variable_price_with_from' ) ) {
            return $price;
        }

        if ( ! $product->is_type( 'variable' ) ) {
            return $price;
        }

        $min_regular_price = $product->get_variation_regular_price( 'min', true );
        $min_sale_price    = $product->get_variation_sale_price( 'min', true );
        $max_regular_price = $product->get_variation_regular_price( 'max', true );
        $max_sale_price    = $product->get_variation_sale_price( 'max', true );

        if ( ! ( $min_regular_price == $max_regular_price && $min_sale_price == $max_sale_price ) ) {
            if ( $min_sale_price < $min_regular_price ) {
                $price = sprintf( __( 'from&nbsp;<del>%1$s</del><ins>%2$s</ins>', THEME_TEXTDOMAIN ), wc_price( $min_regular_price ), wc_price( $min_sale_price ) );
            } else {
                $price = sprintf( __( 'from&nbsp;%s', THEME_TEXTDOMAIN ), wc_price( $min_regular_price ) );
            }
        }

        return $price;
    }

    /**
     * @return void
     * @see woocommerce_template_loop_category_title()
     */
    protected function fix_loop_category_title() {
        remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
        add_action( 'woocommerce_shop_loop_subcategory_title', function ( $category ) {
            echo '<div class="woocommerce-loop-category__title">';
            echo esc_html( $category->name );

            if ( $category->count > 0 ) {
                echo apply_filters( 'woocommerce_subcategory_count_html', ' <sup class="count">' . esc_html( $category->count ) . '</sup>', $category ); // WPCS: XSS ok.
            }
            echo '</div>';
        }, 10 );
    }

    /**
     * @return void
     */
    protected function fix_breadcrumbs_trailed() {
        add_filter( 'woocommerce_get_breadcrumb', function ( $crumbs ) {
            if ( get_query_var( 'paged' ) && 'subcategories' !== woocommerce_get_loop_display_mode() ) {
                array_pop( $crumbs );
            }

            if ( is_product() || is_product_category() || is_shop() ) {
                array_pop( $crumbs );
            }

            return $crumbs;
        }, 777 );
    }

    /**
     * @return void
     */
    protected function extendWcSettings() {
        add_filter( 'woocommerce_get_settings_products', function ( $settings ) {

            $settings[] = [
                'title' => __( 'Additional Custom Options from', THEME_TEXTDOMAIN ) . ' ' . THEME_TITLE,
                'type'  => 'title',
                'desc'  => '',
                'id'    => THEME_SLUG . '_additional_options',
            ];
            $settings[] = [
                'title'   => __( 'Image Zoom', THEME_TEXTDOMAIN ),
                'desc'    => __( 'Disable image zoom', THEME_TEXTDOMAIN ),
                'id'      => THEME_SLUG . '_disable_image_zoom',
                'default' => 'no',
                'type'    => 'checkbox',
            ];
            $settings[] = [
                'type' => 'sectionend',
                'id'   => THEME_SLUG . '_additional_options',
            ];

            return $settings;
        } );

        if ( static::is_image_zoom_disabled() ) {
            add_action( 'wp', function () {
                remove_theme_support( 'wc-product-gallery-zoom' );
            }, 100 );
        }
    }

    /**
     * @return bool
     */
    public static function is_image_zoom_disabled() {
        /**
         * @hook theme-bono_disable_image_zoom
         */
        $value = apply_filters( THEME_SLUG . '_disable_image_zoom', get_option( THEME_SLUG . '_disable_image_zoom', 'no' ) );

        return 0 === strcasecmp( 'yes', $value );
    }
}
