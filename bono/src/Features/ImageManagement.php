<?php

namespace Wpshop\TheTheme\Features;

use WP_Customize_Manager;

class ImageManagement {

    /**
     * @return void
     */
    public function init() {
        if ( ! class_exists( \WooCommerce::class ) ) {
            return;
        }

        add_action( 'after_setup_theme', function () {
            add_theme_support( 'woocommerce', [
                'thumbnail_image_width'         => 500,
                'single_image_width'            => 640,
                'gallery_thumbnail_image_width' => 100,
            ] );
            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );


            // Enable support for Post Thumbnails on posts and pages.
            add_theme_support( 'post-thumbnails' );
            set_post_thumbnail_size( 1000, 545, true );

//			$image_size_post    = apply_filters( THEME_SLUG . '_image_size_post', [ 1100, 600, true ] );
            $image_size_card = apply_filters( THEME_SLUG . '_image_size_card', [ 550, 300, true ] );
//			$image_size_square   = apply_filters( THEME_SLUG . '_image_size_square', [ 100, 100, true ] );
            if ( function_exists( 'add_image_size' ) ) {
//				add_image_size( THEME_SLUG . '_post', $image_size_post[0], $image_size_post[1], $image_size_post[2] );
                add_image_size( THEME_SLUG . '_card', $image_size_card[0], $image_size_card[1], $image_size_card[2] );
//				add_image_size( THEME_SLUG . '_square', $image_size_square[0], $image_size_square[1], $image_size_square[2] );
            }
        } );

        add_action( 'customize_register', [ $this, '_update_wc_customizer_sections' ], 20 );
        add_filter( 'woocommerce_get_image_size_thumbnail', [ $this, '_get_image_size_thumbnail' ] );


        do_action( __METHOD__, $this );
    }

    /**
     * @param array $size
     *
     * @return array
     * @see wc_get_image_size()
     */
    public function _get_image_size_thumbnail( $size ) {
        return [
            'width'  => apply_filters( THEME_SLUG . '_woocommerce_thumbnail_width', 500 ),
            'height' => apply_filters( THEME_SLUG . '_woocommerce_thumbnail_height', 640 ),
            'crop'   => apply_filters( THEME_SLUG . '_woocommerce_thumbnail_crop', 0 ),
        ];
    }

    /**
     * @param WP_Customize_Manager $wp_customize
     *
     * @return void
     * @see WC_Shop_Customizer::add_product_images_section()
     */
    public function _update_wc_customizer_sections( $wp_customize ) {
        $wp_customize->remove_section( 'woocommerce_product_images' );
    }
}
