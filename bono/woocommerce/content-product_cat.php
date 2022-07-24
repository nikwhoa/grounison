<?php

/**
 * @version    4.7.0
 * @deprecated since 1.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @var WP_Term $category
 */
?>
<style>
.page-title{

        background:#F8F8F8;}
</style>
<div <?php wc_product_cat_class( '', $category ); ?> data-qwerty="qwerty">
    <?php
    /**
     * woocommerce_before_subcategory hook.
     *
     * @hooked woocommerce_template_loop_category_link_open - 10
     */
    do_action( 'woocommerce_before_subcategory', $category );

    /**
     * woocommerce_before_subcategory_title hook.
     *
     * @hooked woocommerce_subcategory_thumbnail - 10
     */
    do_action( 'woocommerce_before_subcategory_title', $category );

    /**
     * woocommerce_shop_loop_subcategory_title hook.
     *
     * @hooked woocommerce_template_loop_category_title - 10
     */
    do_action( 'woocommerce_shop_loop_subcategory_title', $category );
    /**
     * woocommerce_after_subcategory_title hook.
     */
    do_action( 'woocommerce_after_subcategory_title', $category );

    /**
     * woocommerce_after_subcategory hook.
     *
     * @hooked woocommerce_template_loop_category_link_close - 10
     */
    do_action( 'woocommerce_after_subcategory', $category ); ?>
</div>