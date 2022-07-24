<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\OneClickBuy\Email;

/**
 * @var Email  $email
 * @var string $email_heading
 */

$data = wp_parse_args( $email->get_post_data(), [ 'phone' => '' ] );

$email_heading = ! empty( $email_heading ) ? $email_heading : '';

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );

?>
    <p><?php echo __( 'Request for new One Click Buy Order', THEME_TEXTDOMAIN ) ?></p>
    <p>
        <?php echo __( 'From' ) ?>: <?php echo esc_html( $email->from_name ) ?>
        <?php if ( $email->from_address ): ?>
            &nbsp;&lt;<?php echo esc_html( $email->from_address ) ?>&gt;
        <?php endif ?>
    </p>
    <p>
        <?php echo __( 'Product', THEME_TEXTDOMAIN ) ?>:
        <?php if ( $product = $email->product ): ?>
            <a href="<?php echo get_permalink( $product->get_id() ) ?>" rel="noopener" target="_blank"><?php echo $product->get_formatted_name() ?></a>
        <?php else: ?>
            <?php echo __( '(no product found)', THEME_TEXTDOMAIN ) ?>
        <?php endif ?>
    </p>
    <p>
        <?php echo __( 'Quantity', THEME_TEXTDOMAIN ) ?>:
        <?php echo absint( $email->qty ) ?>
    </p>
    <?php if ( $data['phone'] ): ?>
    <p>
        <?php echo __( 'Telephone', THEME_TEXTDOMAIN ) ?>:
        <?php echo esc_html( $data['phone'] ) ?>
    </p>
    <?php endif ?>
<?php

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
