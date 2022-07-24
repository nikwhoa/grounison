<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\OneClickBuy\Email;

/**
 * @var Email $email
 */

echo __( 'Request for new One Click Buy Order', THEME_TEXTDOMAIN );
echo __( 'From' ) . ': ' . $email->from_name . ( $email->from_address ? ' <' . $email->from_address . '>' : '' );
echo __( 'Product' ) . ': ' . ( $email->product ? $email->product->get_formatted_name() : __( '(no product found)', THEME_TEXTDOMAIN ) );
echo __( 'Quantity' ) . ': ' . absint( $email->qty );
