<?php

namespace Wpshop\TheTheme\Support;

class CatalogModeSupport {

    use CheckPluginTrait;

    /**
     * @return void
     */
    public function init() {
        if ( $this->is_plugin_enabled( 'yith-woocommerce-catalog-mode/init.php' ) ) {
            if ( get_option( 'ywctm_disable_shop' ) === 'yes' ) {
                add_filter( 'bono_enabled_minicart', [ $this, '_check_disabled' ], 11 );
                add_filter( 'bono_quick_view', [ $this, '_check_disabled' ], 11 );
//                add_filter( 'bono_favorite_enabled', [ $this, '_check_disabled' ], 11 );
//                add_filter( 'bono_compare_products_enabled', [ $this, '_check_disabled' ], 11 );
//                add_filter( 'bono_one_click_buy', [ $this, '_check_disabled' ], 11 );
            }
        }

        do_action( __METHOD__, $this );
    }

    /**
     * @return bool
     */
    public function _check_disabled() {
        return YITH_WCTM()->check_user_admin_enable();
    }
}
