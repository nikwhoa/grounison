<?php

namespace Wpshop\TheTheme\Widget;

use WP_Widget;
use Wpshop\Core\Core;

class MiniCart extends WP_Widget {

    /**
     * @inheritDoc
     */
    public function __construct() {
        parent::__construct(
            THEME_SLUG . '_minicart_widget',
            __( 'Mini Cart', THEME_TEXTDOMAIN ),
            [
                'description' => sprintf( __( 'Mini Cart Widget from theme %s', THEME_TEXTDOMAIN ), THEME_TITLE ),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function widget( $args, $instance ) {
        if ( ! class_exists( \WooCommerce::class ) ) {
            return;
        }

        $cart_style = theme_container()->get( Core::class )->get_option( 'header_cart_style' );

        echo '<div class="header-cart site-header-cart header-cart--' . $cart_style . '">';

        if ( is_cart() ) {
            printf(
                '<span class="header-cart__link"><span class="header-cart__link-ico"></span><sup class="bono_header_widget_shopping_cart_count">%d</sup></span>',
                WC()->cart->get_cart_contents_count()
            );
        } else {
            printf(
                '<a href="%s" class="header-cart__link js-header-cart-link"><span class="header-cart__link-ico"></span><sup class="bono_header_widget_shopping_cart_count">%d</sup></a>',
                wc_get_cart_url(),
                WC()->cart->get_cart_contents_count()
            );
        }

        $wc_args = isset( $args['wc_cart_widget_args'] ) ? $args['wc_cart_widget_args'] : [];

        $wc_args['before_widget'] = '<div style="display: none" class="site-header-cart-hidden">';
        $wc_args['after_widget']  = '</div>';

        $wc_args['before_title'] = '<div class="header-cart__title">';
        $wc_args['after_title']  = '</div>';

        $instance['title'] = apply_filters( 'bono_minicart_header', __( 'Cart', THEME_TEXTDOMAIN ) );

        the_widget( 'WC_Widget_Cart', $instance, $wc_args );

        echo '</div>';
    }
}
