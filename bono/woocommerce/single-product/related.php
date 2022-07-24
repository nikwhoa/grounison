<?php

/**
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @var WC_Product[]|null $related_products
 */

if ( $related_products ) : ?>

    <div class="related-products">

        <div class="related-products__header"><?php esc_html_e( 'Related products', 'woocommerce' ); ?></div>

        <?php woocommerce_product_loop_start(); ?>

        <?php foreach ( $related_products as $related_product ) : ?>

            <?php
            $post_object = get_post( $related_product->get_id() );

            setup_postdata( $GLOBALS['post'] =& $post_object );

            wc_get_template_part( 'content', 'product' ); ?>

        <?php endforeach; ?>

        <?php woocommerce_product_loop_end(); ?>

    </div>

<?php endif;

wp_reset_postdata();
