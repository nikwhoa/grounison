<?php

namespace Wpshop\TheTheme\Settings;

use Wpshop\Core\ThemeOptions;

class ResetSettingsAction {

    /**
     * @var ThemeOptions
     */
    protected $options;

    /**
     * ResetSettingsAction constructor.
     *
     * @param ThemeOptions $options
     */
    public function __construct( ThemeOptions $options ) {
        $this->options = $options;
    }

    /**
     * @return void
     */
    public function init() {
        if ( is_admin() ) {
            add_action( 'wp_ajax_wpshop_reset_settings', [ $this, 'reset' ] );
        }
    }

    /**
     * @return void
     */
    public function reset() {
        check_ajax_referer( 'wpshop_reset_settings' );

        if ( false === get_option( $this->options->option_name ) ) {
            _e( 'Settings are already deleted', $this->options->text_domain );
        } elseif ( delete_option( $this->options->option_name ) ) {
            _e( 'Settings are successfully deleted', $this->options->text_domain );
        } else {
            _e( 'We cant delete settings', $this->options->text_domain );
        }

        wp_die();
    }
}
