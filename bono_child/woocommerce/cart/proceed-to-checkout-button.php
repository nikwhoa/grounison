<?php

/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<?php if (strpos(get_permalink(), '/ee/') !== false) { ?>
	<a href="<?php echo get_site_url(); ?>/ee/checkout" class="checkout-button button alt wc-forward">
		<?php esc_html_e('Proceed to checkout', 'woocommerce'); ?>
	</a>

<?php } else { ?>
	<a href="<?php echo get_site_url(); ?>/ru/checkout" class="checkout-button button alt wc-forward">
		<?php esc_html_e('Proceed to checkout', 'woocommerce'); ?>
	</a>
<?php } ?>