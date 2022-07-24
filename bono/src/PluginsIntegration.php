<?php


namespace Wpshop\TheTheme;


class PluginsIntegration {

    /**
     * @return void
     */
    public function init() {
        $this->integrate_with_br_lmp();

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    protected function integrate_with_br_lmp() {
        $plugin = 'load-more-products-for-woocommerce/load-more-products.php';
        if ( ! $this->is_plugin_active( $plugin ) ) {
            return;
        }

        add_filter( 'berocket_lmp_button_style', [ $this, '_remove_br_lmp_button_style' ], 11, 3 );
    }

    /**
     * @param string $button
     * @param string $option_name
     * @param array  $options_btn
     *
     * @return string
     */
    public function _remove_br_lmp_button_style( $button, $option_name, $options_btn ) {
        $classes = [ 'shop-item__buttons-cart' ];
        if ( ! empty( $options_btn['custom_class'] ) && in_array( $options_btn['custom_class'], $classes ) ) {
            return '';
        }

        return $button;
    }

    /**
     * @param string $plugin
     *
     * @return bool
     * @see is_plugin_active()
     */
    protected function is_plugin_active( $plugin ) {
        return in_array( $plugin, (array) get_option( 'active_plugins', [] ) ) || $this->is_plugin_active_for_network( $plugin );
    }

    /**
     * @param string $plugin
     *
     * @return bool
     * @see is_plugin_active_for_network()
     */
    function is_plugin_active_for_network( $plugin ) {
        if ( ! is_multisite() ) {
            return false;
        }

        $plugins = get_site_option( 'active_sitewide_plugins' );
        if ( isset( $plugins[ $plugin ] ) ) {
            return true;
        }

        return false;
    }
}
