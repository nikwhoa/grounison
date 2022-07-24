<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Helper;

class ThemeProvider {

    /**
     * @var ThemeOptions
     */
    protected $options;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * Activation constructor.
     *
     * @param ThemeOptions $options
     * @param string       $url
     */
    public function __construct( ThemeOptions $options, $url ) {
        $this->options = $options;
        $this->apiUrl  = $url;
    }

    /**
     * @return void
     */
    public function init() {
        add_action( 'admin_notices', function () {
            $this->license_notice();
        } );
    }

    /**
     * @return void
     */
    public function check() {
        if ( ! $this->verify() ) {
            exit( '<p style="text-align: center;font-size:20px;">' . __( 'You need to activate the license in Settings section of Admin panel', $this->options->text_domain ) . '</p>' );
        }
    }

    /**
     * @return void
     */
    protected function license_notice() {
        if ( ! $this->verify() ) {
            echo '<div class="notice notice-error">';
            echo '<h2>' . __( 'Attention!', $this->options->text_domain ) . '</h2>';
            echo '<p>' . sprintf( __( 'To activate theme you need to enter the license key on <a href="%s">this page</a>.', $this->options->text_domain ), admin_url( 'options-general.php?page=bono-theme-setting' ) ) . '</p>';
            echo '</div>';
        }
    }

    /**
     * @return bool
     */
    public function verify() {
        $license        = get_option( $this->options->license );
        $license_verify = get_option( $this->options->license_verify );
        $license_error  = get_option( $this->options->license_error );

        if ( ! empty( $license ) && ! empty( $license_verify ) && empty( $license_error ) ) {
            //TODO: проверка на истечение лицензии
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $license
     *
     * @return bool
     */
    public function activate( $license ) {
        $response = $this->get_success_response( $license );

        if ( ! $response || is_wp_error( $response ) ) {
            update_option( $this->options->license_request_error, __( 'Can\'t get response from license server', $this->options->text_domain ) );

            return false;
        }

        delete_option( $this->options->license_request_error );

        /**
         * Decode response
         */
        $body = wp_remote_retrieve_body( $response );

        if ( mb_substr( $body, 0, 2 ) == 'ok' ) {
            update_option( $this->options->license, $license );
            update_option( $this->options->license_verify, time() + ( WEEK_IN_SECONDS * 4 ) );
            delete_option( $this->options->license_error );

            return true;
        }

        update_option( $this->options->license_error, $body );

        return false;

    }

    /**
     * @param string $license
     *
     * @return array|\WP_Error|null
     */
    protected function get_success_response( $license ) {
        $urls = [
            'https://wpshop.ru/api.php',
            'https://wpshop.biz/api.php',
        ];
        foreach ( $urls as $api_url ) {
            $api_params = [
                'action'    => 'activate_license',
                'license'   => $license,
                'item_name' => urlencode( THEME_NAME ),
                'version'   => THEME_VERSION,
                'type'      => 'theme',
                'url'       => home_url(),
                'ip'        => Helper::get_ip(),
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
}
