<?php

namespace Wpshop\TheTheme;

class Helper {

    /**
     * @param string $plugin
     *
     * @return bool
     */
    public static function is_plugin_active( $plugin ) {
        $active_plugins = (array) get_option( 'active_plugins', [] );
        if ( is_multisite() ) {
            $active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', [] ) );
        }

        return in_array( $plugin, $active_plugins ) ||
               array_key_exists( $plugin, $active_plugins );
    }
}
