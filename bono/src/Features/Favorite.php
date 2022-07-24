<?php

namespace Wpshop\TheTheme\Features;

use Wpshop\Core\Core;
use Wpshop\Core\ThemeOptions;

class Favorite {

    /**
     * @var ThemeOptions
     */
    protected $options;

    /**
     * @var Core
     */
    protected $core;

    /**
     * Favorite constructor.
     *
     * @param ThemeOptions $options
     * @param Core         $core
     */
    public function __construct( ThemeOptions $options, Core $core ) {
        $this->options = $options;
        $this->core    = $core;
    }

    /**
     * @return bool
     */
    public function enabled() {
        $result = apply_filters( __METHOD__, $this->core->get_option( 'favorite_enabled' ) );
        $result = apply_filters( 'bono_favorite_enabled', $result );

        return $result;
    }

    /**
     * @return bool
     */
    public function show_counter() {
        return (bool) apply_filters( 'bono_compare_products_show_counter', $this->core->get_option( 'favorite_counter_enabled' ) );
    }

    /**
     * @return bool
     */
    public function is_wc_enabled() {
        return class_exists( \WooCommerce::class );
    }

    /**
     * @return void
     */
    public function init() {
        if ( ! $this->enabled() ) {
            return;
        }

        add_action( 'woocommerce_installed', function () {
            set_transient( 'is_wc_installed', 'yes', HOUR_IN_SECONDS * 2 );
        } );

        if ( ! $this->is_wc_enabled() ) {
            return;
        }

        add_action( 'init', [ $this, '_create_default_pages_transient' ] );
        add_action( 'after_switch_theme', [ $this, '_create_default_pages' ] );

        add_filter( 'woocommerce_settings_pages', [ $this, '_add_page_settings' ] );

        add_shortcode( 'bono_favorite_shortcode', [ $this, 'favorites_short_code' ] );

        add_filter( 'body_class', $page_favorite_class_filter = function ( $classes ) {
            if ( $this->is_favorite_page() ) {
                $classes[] = 'page-favorite';
            }

            return $classes;
        } );

        add_filter( 'bono_is_page_woocommerce', function ( $result ) {
            if ( ! $result ) {
                $result = $this->is_favorite_page();
            }

            return $result;
        } );

        do_action( __METHOD__, $this );
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
        if ( empty( $_COOKIE['b:favorites'] ) ) {
            return [];
        }

        return (array) json_decode( $_COOKIE['b:favorites'], true );
    }

    /**
     * @param array $atts
     *
     * @return string
     */
    public function favorites_short_code( $atts ) {
        $ids = $this->get_ids();
        if ( ! $ids ) {
            return '';
        }

        $atts = wp_parse_args( $atts, [
            'ids'      => implode( ',', $ids ),
            'paginate' => true,
            //			'cache'    => false,
            'per_page' => apply_filters( 'loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page() ),
        ] );
        $atts = wp_parse_args( $_SERVER['QUERY_STRING'], $atts );

        $shortcode = new \WC_Shortcode_Products( $atts, 'products' );

        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

        return $shortcode->get_content();
    }

    /**
     * @return bool
     */
    public function is_favorite_page() {
        if ( $this->enabled() && $this->is_wc_enabled() ) {
            $key  = 'favorite';
            $page = get_option( "{$this->options->theme_slug}_{$key}_page_id" );

            return is_page( $page ? absint( $page ) : - 1 );
        }

        return false;
    }

    /**
     * @return void
     */
    public function _create_default_pages_transient() {
        if ( 'yes' === get_transient( 'is_wc_installed' ) ) {
            $this->_create_default_pages();
            delete_transient( 'is_wc_installed' );
        }
    }

    /**
     * @return void
     * @see WC_Install::create_pages();
     */
    public function _create_default_pages() {
        if ( defined( 'WC_PLUGIN_FILE' ) ) {
            include_once dirname( WC_PLUGIN_FILE ) . '/includes/admin/wc-admin-functions.php';
        }

        if ( ! function_exists( 'wc_create_page' ) ) {
            return;
        }

        $pages = apply_filters( $this->options->theme_slug . '_create_pages', [
            'favorite' => [
                'name'    => _x( 'favorite', 'Page slug', $this->options->text_domain ),
                'title'   => _x( 'Favorite', 'Page title', $this->options->text_domain ),
                'content' => '<!-- wp:shortcode -->[bono_favorite_shortcode]<!-- /wp:shortcode -->',
            ],
        ] );

        foreach ( $pages as $key => $page ) {
            wc_create_page(
                esc_sql( $page['name'] ),
                "{$this->options->theme_slug}_{$key}_page_id",
                $page['title'],
                $page['content'],
                ! empty( $page['parent'] ) ? wc_get_page_id( $page['parent'] ) : ''
            );
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function get_page_url( $key = 'favorite' ) {
        $page = get_option( "{$this->options->theme_slug}_{$key}_page_id" );

        return get_page_link( $page );
    }

    /**
     * @param array $settings
     *
     * @return array
     * @see WC_Settings_Advanced::get_settings()
     */
    public function _add_page_settings( $settings ) {
        $item = [
            'title'    => __( 'Favorite page', $this->options->text_domain ),
            'desc'     => sprintf( __( 'Added by theme %s', $this->options->text_domain ), $this->options->theme_name ),
            'id'       => $this->options->theme_slug . '_favorite_page_id',
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
