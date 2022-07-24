<?php

namespace Wpshop\TheTheme\Features;

class QuickView {

    protected $output_placeholder = false;

    /**
     * @return void
     */
    public function init() {
        if ( ! class_exists( \WooCommerce::class ) || ! $this->enabled() ) {
            return;
        }

        add_filter( 'woocommerce_product_loop_end', [ $this, '_append_popup_placeholder' ], 20 );

        add_action( 'wp_enqueue_scripts', [ $this, '_enqueue_scripts' ] );
        add_action( 'wp_ajax_quick_view_ajax', [ $this, '_ajax' ] );
        add_action( 'wp_ajax_nopriv_quick_view_ajax', [ $this, '_ajax' ] );


        do_action( __METHOD__, $this );
    }

    public function output_placeholder() {
        if ( ! $this->output_placeholder ) {
            echo $this->_append_popup_placeholder( '' );
            $this->output_placeholder = true;
        }
    }

    /**
     * @return void
     */
    public function _enqueue_scripts() {
        wp_localize_script( THEME_SLUG . '-scripts', 'quick_view_ajax', [
            'url'   => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'wpshop-nonce' ),
        ] );

        $this->enqueue_wc_scripts();
    }

    /**
     * WC resources for gallery
     *
     * @return void
     * @see WC_Frontend_Scripts::load_scripts()
     *
     * @see wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php
     */
    protected function enqueue_wc_scripts() {
        $suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        $scripts = [
            'wc-single-product'        => [
                'src'     => self::get_asset_url( 'assets/js/frontend/single-product' . $suffix . '.js' ),
                'deps'    => [ 'jquery' ],
                'version' => WC()->version,
            ],
            'flexslider'               => [
                'src'     => self::get_asset_url( 'assets/js/flexslider/jquery.flexslider' . $suffix . '.js' ),
                'deps'    => [ 'jquery' ],
                'version' => '2.7.2',
            ],
            'zoom'                     => [
                'src'     => self::get_asset_url( 'assets/js/zoom/jquery.zoom' . $suffix . '.js' ),
                'deps'    => [ 'jquery' ],
                'version' => '1.7.21',
            ],
            'wc-add-to-cart'           => [
                'src'     => self::get_asset_url( 'assets/js/frontend/add-to-cart' . $suffix . '.js' ),
                'deps'    => [ 'jquery', 'jquery-blockui' ],
                'version' => WC()->version,
            ],
            'wc-add-to-cart-variation' => [
                'src'     => self::get_asset_url( 'assets/js/frontend/add-to-cart-variation' . $suffix . '.js' ),
                'deps'    => [ 'jquery', 'wp-util', 'jquery-blockui' ],
                'version' => WC()->version,
            ],
            //			'photoswipe'            => [
            //				'src'     => self::get_asset_url( 'assets/js/photoswipe/photoswipe' . $suffix . '.js' ),
            //				'deps'    => [],
            //				'version' => '4.1.1',
            //			],
            //			'photoswipe-ui-default' => [
            //				'src'     => self::get_asset_url( 'assets/js/photoswipe/photoswipe-ui-default' . $suffix . '.js' ),
            //				'deps'    => [ 'photoswipe' ],
            //				'version' => '4.1.1',
            //			],
        ];
        foreach ( $scripts as $name => $args ) {
            $do_enqueue = true;
            switch ( $name ) {
                case 'zoom':
                    $do_enqueue = current_theme_supports( 'wc-product-gallery-zoom' );
                    break;
                case 'flexslider':
                    $do_enqueue = current_theme_supports( 'wc-product-gallery-slider' );
                    break;
                default:
                    break;
            }
            if ( $do_enqueue ) {
                wp_register_script( $name, $args['src'], $args['deps'], $args['version'], true );
                wp_enqueue_script( $name );
            }
        }
    }

    /**
     * @param string $path
     *
     * @return mixed|void
     * @see WC_Frontend_Scripts::get_asset_url()
     */
    protected static function get_asset_url( $path ) {
        return apply_filters( 'woocommerce_get_asset_url', plugins_url( $path, WC_PLUGIN_FILE ), $path );
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function _append_popup_placeholder( $content ) {
        $content .= <<<HTML
<div class="quick-view quick-view__holder js-quick-view-holder">
	<div class="quick-view__container">
		<div class="quick-view__close js-quick-view-close"></div>
		<div class="js-quick-view-container"></div>
	</div>
</div>
HTML;

        $this->output_placeholder = true;

        return $content;
    }

    /**
     * @return void
     */
    public function _ajax() {
        if ( isset( $_REQUEST['product_id'] ) ) {
            ob_start();
            $GLOBALS['post']    = get_post( $_REQUEST['product_id'] );
            $GLOBALS['product'] = wc_get_product();

            wc_get_template_part( 'content', 'single-product-ajax' );
            $html = ob_get_clean();

            wp_send_json( [
                'html' => $html,
            ] );
        }
    }

    /**
     * @return bool
     */
    public function enabled() {
        $result = apply_filters( __METHOD__, true );
        $result = apply_filters( 'bono_quick_view', $result );

        return $result;
    }
}
