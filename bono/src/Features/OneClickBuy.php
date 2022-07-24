<?php


namespace Wpshop\TheTheme\Features;


use WC_Data_Exception;
use WC_Order;
use WP_Error;
use Wpshop\Core\Core;
use Wpshop\TheTheme\Features\OneClickBuy\Email;
use Wpshop\TheTheme\TemplateRenderer;

class OneClickBuy {

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var TemplateRenderer
     */
    protected $renderer;

    /**
     * OneClickBuy constructor.
     *
     * @param Core             $core
     * @param TemplateRenderer $renderer
     */
    public function __construct( Core $core, TemplateRenderer $renderer ) {
        $this->core     = $core;
        $this->renderer = $renderer;
    }

    /**
     * @return void
     */
    public function init() {

        add_action( 'woocommerce_after_add_to_cart_button', function () {
            if ( ! $this->do_show_button() ) {
                return;
            }
            echo $this->renderer->render( 'template-parts/_renderer/one-click-buy-button.php', [
                'button_label' => __( 'Buy One Click', THEME_TEXTDOMAIN ),
            ], true );
        } );

        add_action( 'wp_footer', function () {
            if ( ! $this->do_show_button() ) {
                return;
            }
            echo $this->renderer->render( 'template-parts/_renderer/one-click-buy-popup.php', [], true );
        } );

        if ( wp_doing_ajax() && $this->enabled() ) {
            $action = 'one_click_buy';
            add_action( "wp_ajax_$action", [ $this, '_ajax' ] );
            add_action( "wp_ajax_nopriv_$action", [ $this, '_ajax' ] );
        }

        add_action( 'bono_one_click_buy:order_created', [ $this, 'on_order_created_default' ], 10, 4 );

        do_action( __METHOD__, $this );
    }

    /**
     * @return bool
     */
    public function do_show_button() {
        return apply_filters( 'bono_one_click_buy:show_button', $this->enabled() );
    }

    /**
     * @return bool
     */
    public function enabled() {
        $result = apply_filters( __METHOD__, is_wc_enabled() && $this->core->get_option( 'one_click_buy_enable' ) );
        $result = apply_filters( 'bono_one_click_buy_enabled', $result );

        return $result;
    }

    /**
     * @return void
     */
    public function _ajax() {
        if ( ! $this->enabled() ) {
            wp_send_json_error( [ 'message' => __( 'Forbidden', THEME_TEXTDOMAIN ) ], 403 );
        }

        if ( empty( $_POST['data'] ) ) {
            wp_send_json_error( [ 'message' => __( 'Unable to handle request with empty data', THEME_TEXTDOMAIN ) ] );
        }

        if ( is_customize_preview() ) {
            wp_send_json_success();
        }

        $data = map_deep( $_POST['data'], 'trim' );

        if ( ! wp_verify_nonce( $data['nonce'], 'wpshop-nonce' ) ) {
            wp_send_json_error( [ 'message' => __( 'Forbidden', THEME_TEXTDOMAIN ) ], 403 );
        }

        if ( apply_filters( 'bono_one_click_buy:do_handle', true, $data ) ) {

            if ( $errors = $this->validate( $data ) ) {
                wp_send_json_error( $errors, 'validation_failed' );
            }

            try {

                do_action( 'bono_one_click_buy:before_handle', $data );

                $product_id = absint( $data['product_id'] );
                $qty        = absint( $data['qty'] );

                $name    = ! empty( $data['form']['name'] ) ? sanitize_text_field( $data['form']['name'] ) : '';
                $email   = ! empty( $data['form']['email'] ) ? sanitize_text_field( $data['form']['email'] ) : '';
                $phone   = ! empty( $data['form']['phone'] ) ? sanitize_text_field( $data['form']['phone'] ) : '';
                $consent = ! empty( $data['form']['consent'] ) ? (bool) $data['form']['consent'] : false;

                $data = apply_filters( 'bono_one_click_buy:data', [
                    'phone' => $phone,
                ] );

                switch ( $this->core->get_option( 'one_click_buy_mode' ) ) {
                    case 'send_email':
                        $this->send_email( $product_id, $qty, $email, $name, $data );
                        break;
                    case 'create_order':
                        $this->create_order( $product_id, $qty, $name, $email, $phone );
                        break;
                    case 'both':
                        $this->send_email( $product_id, $qty, $email, $name, $data );
                        $this->create_order( $product_id, $qty, $name, $email, $phone );
                        break;
                    default:
                        break;
                }

                do_action( 'bono_one_click_buy:after_handle', $data );
            } catch ( WC_Data_Exception $e ) {
                wp_send_json_error( new WP_Error( 'failed', $e->getMessage() ) );
            } catch ( \Exception $e ) {
                wp_send_json_error( new WP_Error( 'failed', __( 'Something went wrong while handling one click buy', THEME_TEXTDOMAIN ) ) );
            }
        }

        wp_send_json_success( [
            'message' => $this->core->get_option( 'one_click_buy_success_message' ),
        ] );
    }

    /**
     * @param array $data
     *
     * @return WP_Error|null
     */
    protected function validate( $data ) {
        $errors = [];

        if ( empty( $data['form']['email'] ) ) {
            $errors['email'] = __( 'Email cannot be empty', THEME_TEXTDOMAIN );
        } elseif ( ! is_email( $data['form']['email'] ) ) {
            $errors['email'] = __( 'Invalid email address', 'woocommerce' );
        }

        if ( empty( $data['form']['name'] ) ) {
            $errors['name'] = __( 'Name cannot be empty', THEME_TEXTDOMAIN );
        }

        $errors = apply_filters( 'bono_one_click_buy:validate', $errors, $data );

        if ( $errors ) {
            $error = new WP_Error( 'validation_failed', __( 'Please fix errors', THEME_TEXTDOMAIN ) );
            foreach ( $errors as $code => $message ) {
                $error->add( $code, $message );
            }

            return $error;
        }

        return null;
    }

    /**
     * @param int    $product_id
     * @param int    $qty
     * @param string $name
     * @param string $email
     * @param string $phone
     *
     * @throws WC_Data_Exception
     */
    protected function create_order( $product_id, $qty, $name, $email, $phone ) {
        $address = apply_filters(
            'bono_order_address_arg',
            [
                'first_name' => $name,
                'email'      => $email,
                'phone'      => $phone,
            ]
        );

        $order = wc_create_order();

        do_action( 'bono_one_click_buy:order_created', $order, $product_id, $qty, $address );
    }

    /**
     * @param WC_Order $order
     * @param int      $product_id
     * @param int      $qty
     * @param array    $address
     *
     * @return void
     * @throws WC_Data_Exception
     * @see wc_get_order_statuses()
     */
    public function on_order_created_default( WC_Order $order, $product_id, $qty, $address ) {
        $order->add_product( wc_get_product( $product_id ), $qty );
        $order->set_address( $address, 'billing' );
        $order->set_address( $address, 'shipping' );
        $order->calculate_totals();
        $order->update_status( $this->core->get_option( 'one_click_buy_order_status' ), __( 'One click order', THEME_TEXTDOMAIN ), true );
    }

    /**
     * @param int    $product_id
     * @param int    $qty
     * @param string $from_email
     * @param string $from_name
     * @param array  $data
     *
     * @return bool
     */
    protected function send_email( $product_id, $qty, $from_email, $from_name = '', $data = [] ) {

        WC()->mailer(); // trigger load wc mail class

        $email = new Email();

        $email->from_address = $from_email;
        $email->from_name    = $from_name;
        $email->product      = wc_get_product( $product_id );
        $email->qty          = $qty;
        $email->set_post_data( $data );

        $message = wc_get_template_html( 'emails/one-click-buy.php', [
            'email' => $email,
        ] );

        $mail_to = $this->core->get_option( 'one_click_buy_email_to' );
        $name_to = $this->core->get_option( 'one_click_buy_name_to' );

        return $email->send(
            $name_to ? "$name_to <$mail_to>" : $mail_to,
            $this->core->get_option( 'one_click_buy_email_subject' ),
            $message,
            "Content-Type: text/html\r\n",
            ''
        );
    }
}
