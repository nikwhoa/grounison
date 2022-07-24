<?php

namespace Wpshop\Core;

/**
 * Class ThemeSettings
 *
 * 1.0.0    2020-09-10    Edit link to documentation
 * 1.1.0    2020-12-24    Add fallback url for license check, add check 200 status code
 */
class ThemeSettings {

    protected $options;

    /**
     * ThemeSettings constructor.
     *
     * @param ThemeOptions $options
     */
    public function __construct( ThemeOptions $options ) {

        $this->options = $options;

        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'init_settings' ) );

        add_action( 'wp_ajax_wpshop_reset_settings', array( $this, 'ajax_reset_settings' ) );

    }


    public function add_admin_menu() {
        add_options_page(
            esc_html__( $this->options->settings_page_title, $this->options->text_domain ),
            esc_html__( $this->options->settings_menu_title, $this->options->text_domain ),
            'manage_options',
            $this->options->settings_menu_slug,
            array( $this, 'page_layout' )
        );
    }


    public function init_settings() {
        register_setting(
            'settings_group',
            $this->options->settings_name,
            array( $this, 'sanitize_callback' )
        );

        add_settings_section(
            'site_settings_section',
            '',
            '',
            'site_settings'
        );

        add_settings_field(
            $this->options->settings_name . '_license',
            __( 'License key', $this->options->text_domain ),
            array( $this, 'render_license_field' ),
            'site_settings',
            'site_settings_section'
        );

        add_settings_field(
            $this->options->settings_name . '_settings',
            __( 'Settings', $this->options->text_domain ),
            array( $this, 'render_settings_field' ),
            'site_settings',
            'site_settings_section'
        );
    }


    public function page_layout() {
        // Check required user capability
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', $this->options->text_domain ) );
        }

        // Admin Page Layout
        echo '<div class="wrap">' . PHP_EOL;
        echo '	<h1>' . get_admin_page_title() . '</h1>' . PHP_EOL;
        echo '<div style="background: #fff;padding: 10px 20px;border: 2px solid #4057a3;margin: 10px 0;">';
        echo '  <h2>' . __( 'You can familiarize yourself with the documentation on the topic', $this->options->text_domain ) . ' <a href="https://support.wpshop.ru/docs/themes/' . $this->options->theme_name . '/" target="_blank">' . __( 'by this link', $this->options->text_domain ) . '</a>.</h2>';
        echo '  <p>' . __( 'Appearance and color settings are in the customizer', $this->options->text_domain ) . ' <strong>' . __( 'Appearance> Settings', $this->options->text_domain ) . '</strong>.</p>';
        echo '</div>';
        echo '	<form action="options.php" method="post">' . PHP_EOL;

        settings_fields( 'settings_group' );
        do_settings_sections( 'site_settings' );
        submit_button();

        echo '	</form>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
    }


    public function render_license_field() {

        $license       = get_option( $this->options->license, '' );
        $license_error = get_option( $this->options->license_error, '' );

        $options = get_option( $this->options->settings_name );
        $license_hide = ( ! empty( $options['license_hide'] ) ) ? $options['license_hide'] : '' ;

        if ( $license_request_error = get_option( $this->options->theme_slug . '_license_request_error', '' ) ) {
            echo '<p style="color:#f00;"><strong>' . $license_request_error . '</strong></p>';
        }

        if ( ! empty( $license_error ) ) echo '<p style="color:#f00;"><strong>' . $license_error . '</strong></p>';

        if ( ! empty( $license_error ) || $license_hide != 'hide' ) {
            echo '<input type="text" name="' . $this->options->settings_name . '[license]" class="regular-text license_field" value="' . esc_attr( $license ) . '">';
            echo '<p class="description">' . sprintf( __( 'Enter your License key that was sent to the e-mail after the purchase.', $this->options->text_domain ) ) . '</p><br>';
            echo '<label><input type="checkbox" name="' . $this->options->settings_name . '[license_hide]" value="hide"' . checked( 'hide', $license_hide, false ) . '> ' . __( 'Hide license key after activation', $this->options->text_domain ) . '</label>';
        } else {
            echo '<p>' . __( 'You have hidden the license key.', $this->options->text_domain ) . '</p>';
        }
    }


    public function render_settings_field() {

        $nonce = wp_create_nonce( 'wpshop_reset_settings' );

        $export = get_option( $this->options->option_name );
        if ( ! empty( $export ) ) {
            $export = base64_encode( json_encode( $export ) );
        }

        echo '<div class="wpshop-export-settings">';
        echo '<label>' . __( 'Export settings', $this->options->text_domain ) . ':</label>';
        echo '<textarea class="large-text code" onmouseover="this.select()">' . $export . '</textarea>';
        echo '<p class="description">' . __( 'Copy this code to any text file to save all settings of this site', $this->options->text_domain ) . '</p>';
        echo '</div>';

        echo '<div class="wpshop-import-settings">';
        echo '<label>' . __( 'Import settings', $this->options->text_domain ) . ':</label>';
        echo '<textarea name="import_settings" class="large-text code"></textarea>';
        echo '<p class="description">' . __( 'Danger! Old settings will be removed before import! Paste code to this field and press Save', $this->options->text_domain ) . '</p>';
        echo '</div>';

        echo '<div class="wpshop-reset-settings">';
        echo '<button class="button button-danger js-wpshop-reset-settings" data-nonce="'. $nonce .'">' . __( 'Reset all settings', $this->options->text_domain ) . '</button>';
        echo '<p class="description">' . __( 'Danger! Reset all customizer settings. Reset counters, styles, sidebar settings etc.', $this->options->text_domain ) . '</p>';
        echo '</div>';

    }

    /**
     * @param array $options
     *
     * @return false|mixed|void
     */
    public function sanitize_callback( $options ) {
        if ( ! empty( $_POST['import_settings'] ) ) {
            $import = $_POST['import_settings'];
            $base64decode = base64_decode( $import );
            if ( $base64decode ) {
                $import_settings = json_decode( $base64decode, true );

                if ( $import_settings && ! empty( $import_settings ) ) {
                    update_option( $this->options->option_name, $import_settings );
                }

            } else {
                //echo 'false';
            }
        }

        if ( ! empty( $options ) ) {

            foreach( $options as $name => $val ) {

                if ( $name == 'import_settings' && ! empty( $val ) ) {
                    var_dump( $val );
                    die();
                }

                if ( $name == 'license' && ! empty( $val ) ) {

                    $license = trim( $val );
                    $response = $this->get_success_response( $license );

                    /**
                     * If error - return false
                     */
                    if ( ! $response || is_wp_error( $response ) ) {
                        update_option( $this->options->theme_slug . '_license_request_error', __( 'Can\'t get response from license server', $this->options->text_domain ) );
                        continue;
                    }

                    /**
                     * Decode response
                     */
                    $license_data = wp_remote_retrieve_body( $response );

                    if ( mb_substr( $license_data, 0, 2) == 'ok' ) {
                        update_option( $this->options->license, $license );
                        update_option( $this->options->license_verify, time() + (WEEK_IN_SECONDS * 4) );
                        delete_option( $this->options->license_error );
                        delete_option( $this->options->theme_slug . '_license_request_error' );
                    } else {
                        update_option( $this->options->license_error, $license_data );
                    }

                }
            }
        } else {

            /**
             * Если настройки скрыты - проверяем есть ли они, если есть - их и ставим, чтобы поле не обнулилось
             */
            $old_options = get_option( $this->options->settings_name );
            if ( ! empty( $old_options['license'] ) && $old_options['license_hide'] == 'hide' ) {
                $options = $old_options;
            }

        }

        return $options;

    }

    /**
     * @param string $license
     *
     * @return array|\WP_Error|null
     */
    protected function get_success_response( $license ) {
        $api_urls = [
            'https://wpshop.ru/api.php',
            'https://wpshop.biz/api.php',
        ];
        foreach ( $api_urls as $api_url ) {
            $api_params = [
                'action'    => 'activate_license',
                'license'   => $license,
                'item_name' => urlencode( THEME_NAME ),
                'version'   => THEME_VERSION,
                'type'      => 'theme',
                'url'       => home_url(),
                'ip'        => \Wpshop\Core\Helper::get_ip(),
            ];

            /**
             * Send to api
             */
            $response = wp_remote_post( $api_url, [
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $api_params,
            ] );

            /**
             * If error - try to change https on http
             */
            if ( is_wp_error( $response ) ) {
                $api_url = str_replace( "https", "http", $api_url );

                $response = wp_remote_post( $api_url, [
                    'timeout'   => 15,
                    'sslverify' => false,
                    'body'      => $api_params,
                ] );
            }

            if ( is_wp_error( $response ) ||
                 200 == wp_remote_retrieve_response_code( $response )
            ) {
                return $response;
            }
        }

        return null;
    }


    function ajax_reset_settings() {

        check_ajax_referer( 'wpshop_reset_settings' );

        if ( delete_option( $this->options->option_name ) ) {
            _e( 'Successfully deleted', $this->options->text_domain );
        } else {
            _e( 'We cant delete settings', $this->options->text_domain );
        }

        wp_die();
    }
}
