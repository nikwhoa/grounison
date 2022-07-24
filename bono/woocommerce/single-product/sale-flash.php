<?php

/**
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

use Wpshop\TheTheme\Features\SaleFlash;

global $post, $product;

$sale_flash = theme_container()->get( SaleFlash::class );
?>
<?php if ( $product->is_on_sale() ) : ?>

    <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . $sale_flash->get_message( $product ) . '</span>', $post, $product ); ?>

<?php
endif;
