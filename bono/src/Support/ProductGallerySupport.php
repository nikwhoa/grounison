<?php

namespace Wpshop\TheTheme\Support;

class ProductGallerySupport {

    use CheckPluginTrait;

    /**
     * @return void
     */
    public function init() {
        if ( $this->is_plugin_enabled( 'woo-product-gallery-slider/woo-product-gallery-slider.php' ) ) {
            add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );

            remove_action( 'woocommerce_before_single_product_summary', 'wpgs_product_image', 20 );

            remove_action( 'bono_show_product_images', 'woocommerce_show_product_images' );
            add_action( 'bono_show_product_images', 'wpgs_product_image', 20 );
        }

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    public function register_assets() {
        wp_add_inline_script( 'wpgsjs', $this->js_script() );
    }

    /**
     * @return string
     */
    protected function js_script() {
        return <<<'JS'
jQuery(function ($) {
    'use strict';
    document.addEventListener('bono_quick_view_append_html', function (e) {
        var $container = e.detail.$container;
        $container.find('.wpgs-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: !0,
            infinite: !1,
            autoplay: false,
            nextArrow: '<i class="flaticon-right-arrow"></i>',
            prevArrow: '<i class="flaticon-back"></i>',
            asNavFor: '.wpgs-nav'
        });
        $container.find('.wpgs-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.wpgs-for',
            dots: !1,
            infinite: !1,
            arrows: true,
            centerMode: !1,
            focusOnSelect: !0,
            responsive: [{
                breakpoint: 767,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    vertical: !1,
                    draggable: !0,
                    autoplay: !1,
                    isMobile: !0,
                    arrows: !1
                }
            }]
        });
    });
});
JS;
    }
}
