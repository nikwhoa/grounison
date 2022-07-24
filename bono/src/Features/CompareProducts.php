<?php

namespace Wpshop\TheTheme\Features;

use Wpshop\Core\Core;
use Wpshop\TheTheme\Shortcode\Compare;
use Wpshop\TheTheme\Shortcode\Products;

class CompareProducts {

    const PAGE_SLUG = 'compare';

    /**
     * @var Core
     */
    protected $core;

    /**
     * CompareProducts constructor.
     *
     * @param Core $core
     */
    public function __construct( Core $core ) {
        $this->core = $core;
    }


    /**
     * @return void
     */
    public function init() {

        add_action( 'woocommerce_installed', function () {
            set_transient( 'is_wc_installed:' . __CLASS__, 'yes', HOUR_IN_SECONDS * 2 );
        } );

        if ( ! is_wc_enabled() ) {
            return;
        }

        add_action( 'init', [ $this, '_create_default_pages_transient' ] );
        add_action( 'after_switch_theme', [ $this, 'create_default_pages' ] );

        add_filter( 'woocommerce_settings_pages', [ $this, '_add_page_settings' ] );

        add_shortcode( 'bono_product_compare', [ $this, '_shortcode' ] );

        add_filter( 'body_class', $page_favorite_class_filter = function ( $classes ) {
            if ( $this->is_compare_page() ) {
                $classes[] = 'page-compare';
            }

            return $classes;
        } );

        add_filter( 'bono_is_page_woocommerce', function ( $result ) {
            if ( ! $result ) {
                $result = $this->is_compare_page();
            }

            return $result;
        } );

        do_action( __METHOD__, $this );
    }

    /**
     * @return bool
     */
    public function enabled() {
        $result = apply_filters( __METHOD__, $this->core->get_option( 'compare_products_enabled' ) );
        $result = apply_filters( 'bono_compare_products_enabled', $result );

        return $result;
    }

    /**
     * @return bool
     */
    public function show_counter() {
        return (bool) apply_filters( 'bono_compare_products_show_counter', $this->core->get_option( 'compare_products_enable_counter' ) );
    }

    /**
     * @return bool
     */
    public function is_compare_page() {
        if ( $this->enabled() && is_wc_enabled() ) {
            $key  = static::PAGE_SLUG;
            $slug = THEME_SLUG;
            $page = get_option( "{$slug}_{$key}_page_id" );

            return is_page( $page ? absint( $page ) : - 1 );
        }

        return false;
    }

    /**
     * @param $atts
     *
     * @return string
     */
    public function _shortcode( $atts ) {
        $no_products = apply_filters(
            'bono_compare_no_ids',
            '<p>' . __( 'There are no products for compare', THEME_TEXTDOMAIN ) . '</p>'
        );;

        $ids = $this->get_ids();
        if ( ! $ids ) {
            return $no_products;
        }

        $atts = shortcode_atts( [], $atts, 'bono_product_compare' );

        $atts = wp_parse_args( $atts, [
            'ids'      => implode( ',', $ids ),
            'paginate' => true,
            'per_page' => apply_filters( 'loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page() ),
            'class'    => 'compare-table',
        ] );
        $atts = wp_parse_args( $_SERVER['QUERY_STRING'], $atts );

        $shortcode = new Compare( $atts, 'products' );

        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        return $shortcode->get_content();
    }

    /**
     * @return int
     */
    public function count() {
        return count( $this->get_ids() );
    }

    /**
     * @return array
     */
    protected function get_ids() {
        if ( empty( $_COOKIE['b:compare'] ) ) {
            return [];
        }

        return (array) json_decode( $_COOKIE['b:compare'], true );
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function get_page_url( $key = self::PAGE_SLUG ) {
        $slug = THEME_SLUG;
        $page = get_option( "{$slug}_{$key}_page_id" );

        return get_page_link( $page );
    }

    /**
     * @return void
     */
    public function _create_default_pages_transient() {
        if ( 'yes' === get_transient( 'is_wc_installed' . __CLASS__ ) ) {
            $this->create_default_pages();
            delete_transient( 'is_wc_installed' . __CLASS__ );
        }
    }

    /**
     * @param array $settings
     *
     * @return array
     * @see WC_Settings_Advanced::get_settings()
     */
    public function _add_page_settings( $settings ) {
        $slug = THEME_SLUG;
        $key  = self::PAGE_SLUG;

        $item = [
            'title'    => __( 'Compare page', THEME_TEXTDOMAIN ),
            'desc'     => sprintf( __( 'Added by theme %s', THEME_TEXTDOMAIN ), THEME_NAME ),
            'id'       => "{$slug}_{$key}_page_id",
            'type'     => 'single_select_page',
            'default'  => '',
            'class'    => 'wc-enhanced-select-nostd',
            'css'      => 'min-width:300px;',
            'args'     => [
                'exclude' =>
                    [
                        wc_get_page_id( 'checkout' ),
                        wc_get_page_id( 'myaccount' ),
                        wc_get_page_id( 'cart' ),
                        wc_get_page_id( 'shop' ),
                    ],
            ],
            'desc_tip' => true,
            'autoload' => false,
        ];

        if ( ! $this->insert_after( $settings, $item, 'woocommerce_terms_page_id' ) ) {
            $settings[] = $item;
        }

        return $settings;
    }

    /**
     * @return void
     * @see WC_Install::create_pages();
     */
    public function create_default_pages() {
        if ( defined( 'WC_PLUGIN_FILE' ) ) {
            include_once dirname( WC_PLUGIN_FILE ) . '/includes/admin/wc-admin-functions.php';
        }

        if ( ! function_exists( 'wc_create_page' ) ) {
            return;
        }

        $slug = THEME_SLUG;

        $pages = apply_filters( "{$slug}_create_pages", [
            self::PAGE_SLUG => [
                'name'    => _x( 'compare', 'compare', THEME_TEXTDOMAIN ),
                'title'   => _x( 'Compare Products', 'compare', THEME_TEXTDOMAIN ),
                'content' => '<!-- wp:shortcode -->[bono_product_compare]<!-- /wp:shortcode -->',
            ],
        ] );

        foreach ( $pages as $key => $page ) {
            wc_create_page(
                esc_sql( $page['name'] ),
                "{$slug}_{$key}_page_id",
                $page['title'],
                $page['content'],
                ! empty( $page['parent'] ) ? wc_get_page_id( $page['parent'] ) : ''
            );
        }
    }

    /**
     * @param array  $settings
     * @param array  $data
     * @param string $after_id
     *
     * @return bool
     */
    protected function insert_after( &$settings, $data, $after_id ) {
        $n = null;
        foreach ( $settings as $n => $item ) {
            if ( $item['id'] == $after_id ) {
                break;
            }
        }
        if ( null === $n ) {
            return false;
        }

        $n ++;
        $part1 = array_slice( $settings, 0, $n );
        $part2 = array_slice( $settings, $n );

        $settings = array_merge( $part1, [ $data ], $part2 );

        return true;
    }
}
