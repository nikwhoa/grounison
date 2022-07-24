<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Core;
use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\Favorite;

class Sidebar {

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var Favorite
     */
    protected $favorite;

    /**
     * @var CompareProducts
     */
    protected $compare_products;

    /**
     * Sidebar constructor.
     *
     * @param Core            $core
     * @param Favorite        $favorite
     * @param CompareProducts $compare_products
     */
    public function __construct(
        Core $core,
        Favorite $favorite,
        CompareProducts $compare_products
    ) {
        $this->core             = $core;
        $this->favorite         = $favorite;
        $this->compare_products = $compare_products;
    }

    /**
     * @return string
     */
    public function get_sidebar_name() {
        if ( is_wc_enabled() ) {
            if ( is_product_category() ) {
                return $this->core->get_option( 'sidebar_on_shop_category_type' );
            }
            if ( is_shop() ) {
                return $this->core->get_option( 'sidebar_on_shop_type' );
            }
            if ( $this->favorite->is_favorite_page() ) {
                return $this->core->get_option( 'sidebar_on_favorite_type' );
            }
            if ( $this->compare_products->is_compare_page() ) {
                return $this->core->get_option( 'sidebar_on_compare_type' );
            }
            if ( is_product() ) {
                return $this->core->get_option( 'sidebar_on_product_type' );
            }
        }

        return 'sidebar-1';
    }

    /**
     * @return bool
     */
    public function hide() {
        if ( is_wc_enabled() ) {
            if ( is_cart() || is_checkout() || is_account_page() ) {
                return apply_filters( 'bono_hide_sidebar', true );
            }
            if ( is_product_category() ) {
                return apply_filters( 'bono_hide_sidebar', 'none' == $this->core->get_option( 'sidebar_on_shop_category' ) );
            }
            if ( is_shop() ) {
                return apply_filters( 'bono_hide_sidebar', 'none' == $this->core->get_option( 'sidebar_on_shop' ) );
            }
            if ( $this->favorite->is_favorite_page() ) {
                return apply_filters( 'bono_hide_sidebar', 'none' == $this->core->get_option( 'sidebar_on_favorite' ) );
            }
            if ( $this->compare_products->is_compare_page() ) {
                return apply_filters( 'bono_hide_sidebar', 'none' == $this->core->get_option( 'sidebar_on_compare' ) );
            }
            if ( is_product() ) {
                return apply_filters( 'bono_hide_sidebar', $this->is_hidden_in_post() || 'none' == $this->core->get_option( 'sidebar_on_product' ) );
            }
        }

        if ( bono_is_home_page() && 'none' == $this->core->get_option( 'structure_home_sidebar' ) ) {
            return apply_filters( 'bono_hide_sidebar', true );
        }
        if ( is_archive() && 'none' == $this->core->get_option( 'structure_archive_sidebar' ) ) {
            return apply_filters( 'bono_hide_sidebar', true );
        }
        if ( is_single() && 'none' == $this->core->get_option( 'structure_single_sidebar' ) ) {
            return apply_filters( 'bono_hide_sidebar', true );
        }
        if ( is_page() && 'none' == $this->core->get_option( 'structure_page_sidebar' ) ) {
            return apply_filters( 'bono_hide_sidebar', true );
        }

        return apply_filters( 'bono_hide_sidebar', $this->is_hidden_in_post() );
    }

    /**
     * @return bool
     */
    public function is_hidden_in_post() {
        if ( is_single() || is_page() || ( is_wc_enabled() && is_product() ) ) {
            global $post;

            $hide_elements = get_post_meta( $post->ID, 'hide_elements', true );
            if ( empty( $hide_elements ) ) {
                $hide_elements = [];
            }

            return in_array( 'sidebar', $hide_elements );
        }

        return false;
    }
}
