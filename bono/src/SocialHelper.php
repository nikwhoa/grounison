<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Core;
use Wpshop\TheTheme\Features\Favorite;

class SocialHelper {

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var array|null
     */
    protected $_structure_page;

    /**
     * @var bool
     */
    protected $hooks_added = false;

    /**
     * @var ThemeOptions
     */
    protected $options;

    /**
     * @var Favorite
     */
    protected $favorite;

    /**
     *
     * SocialHelper constructor.
     *
     * @param Core         $core
     * @param ThemeOptions $options
     */
    public function __construct( Core $core, ThemeOptions $options, Favorite $favorite ) {
        $this->core     = $core;
        $this->options  = $options;
        $this->favorite = $favorite;
    }

    /**
     * @param int $priority
     *
     * @return $this
     */
    public function setup_default_hooks( $priority = 15 ) {
        if ( $this->hooks_added ) {
            return $this;
        }

        $this->hooks_added = true;

        if ( ! class_exists( 'WooCommerce' ) ) {
            return $this;
        }

        add_filter( $this->options->theme_slug . '_show_social_on_top', function ( $result ) {
            return ! is_cart() &&
                   ! is_checkout() &&
                   ! is_account_page() &&
                   ! $this->favorite->is_favorite_page() &&
                   $result;
        }, $priority );

        add_filter( $this->options->theme_slug . '_show_social_on_bottom', function ( $result ) {
            return ! is_cart() &&
                   ! is_checkout() &&
                   ! is_account_page() &&
                   ! $this->favorite->is_favorite_page() &&
                   $result;
        }, $priority );

        return $this;
    }

    /**
     * @return bool
     */
    public function do_show_on_bottom() {
        $result = ! in_array( 'social_bottom', $this->get_structure_page_to_hide() ) &&
                  $this->core->is_show_element( 'social_bottom' );

        /**
         * @hook theme-bono_show_social_on_bottom
         */
        return apply_filters( $this->options->theme_slug . '_show_social_on_bottom', $result );
    }

    /**
     * @return array
     */
    public function get_structure_page_to_hide() {
        if ( null === $this->_structure_page ) {
            $result = $this->core->get_option( 'structure_page_hide' );
            if ( ! empty( $result ) ) {
                $result = explode( ',', $result );
                if ( is_array( $result ) ) {
                    $result = array_map( 'trim', $result );
                }
            } else {
                $result = [];
            }

            $this->_structure_page = $result;
        }

        return $this->_structure_page;
    }
}
