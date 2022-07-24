<?php

namespace Wpshop\TheTheme\Support;

trait CheckPluginTrait {

    /**
     * @param string $plugin
     *
     * @return bool
     */
    public function is_plugin_enabled( $plugin ) {
        return in_array( $plugin, get_option( 'active_plugins', [] ) );
    }
}
