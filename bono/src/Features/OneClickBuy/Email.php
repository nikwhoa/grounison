<?php


namespace Wpshop\TheTheme\Features\OneClickBuy;

class Email extends \WC_Email {

    /**
     * @var string|null
     */
    public $from_address;

    /**
     * @var string|null
     */
    public $from_name;

    /**
     * @var \WC_Product|null
     */
    public $product;

    /**
     * @var int|null
     */
    public $qty;

    /**
     * Email constructor.
     */
    public function __construct() {
        $this->id    = 'one_click_buy';
        $this->title = __( 'One Click Buy', THEME_TEXTDOMAIN );
//        $this->description    = __( 'New order emails are sent to chosen recipient(s) when a new order is received.', 'woocommerce' );
        $this->template_html  = 'emails/one-click-buy.php';
        $this->template_plain = 'emails/plain/one-click-buy.php';
        $this->email_type     = 'html';
        parent::__construct();

        $this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );
    }

    /**
     * @inheritDoc
     *
     * @param string|array $to          Email to.
     * @param string       $subject     Email subject.
     * @param string       $message     Email message.
     * @param string|array $headers     Email headers.
     * @param string|array $attachments Email attachments.
     *
     * @return bool success
     */
    public function send( $to, $subject, $message, $headers, $attachments ) {
        add_filter( 'wp_mail_from', $mail_filter = function ( $default = '' ) {
            return $this->from_address ?: $default;
        } );
        add_filter( 'wp_mail_from_name', $name_filter = function ( $default = '' ) {
            return $this->from_name ?: $default;
        } );
        add_filter( 'wp_mail_content_type', $type_filter = function ( $default = '' ) {
            return 'text/html';
        } );

        $message              = apply_filters( 'bono_one_click_buy:mail_content', $this->style_inline( $this->get_content_html() ) );
        $mail_callback        = apply_filters( 'bono_one_click_buy:callback', 'wp_mail', $this );
        $mail_callback_params = apply_filters( 'bono_one_click_buy:callback_params', [
            $to,
            $subject,
            $message,
            $headers,
            $attachments,
        ], $this );
        $return               = call_user_func_array( $mail_callback, $mail_callback_params );

        remove_filter( 'wp_mail_from', $mail_filter );
        remove_filter( 'wp_mail_from_name', $name_filter );
        remove_filter( 'wp_mail_content_type', $type_filter );

        return $return;
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function get_content_html() {
        return wc_get_template_html(
            $this->template_html,
            [
                'email_heading' => $this->get_heading(),
                'email'         => $this,
            ]
        );
    }
}
