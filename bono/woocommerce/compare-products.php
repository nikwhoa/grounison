<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\Favorite;
use Wpshop\TheTheme\Features\QuickView;

/**
 * @var $product WC_Product
 */
global $product, $compare_attributes;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}


$attributes   = isset( $compare_attributes[ $product->get_id() ] ) ? $compare_attributes[ $product->get_id() ] : [];
$availability = $product->get_availability();
?>

<div <?php wc_product_class( $availability['class'], $product ) ?>>
    <div class="shop-item-inner">

        <div class="shop-item__image">

            <?php echo woocommerce_get_product_thumbnail() ?>

            <?php if ( $product->is_in_stock() ): ?>
                <div class="shop-item__buttons">
                    <?php woocommerce_template_loop_add_to_cart() ?>

                    <?php // added to prevent appear "View Cart" text ?>
                    <div class="added_to_cart"></div>

                </div>
            <?php else: ?>
                <div class="shop-item__outofstock"><?php echo $availability['availability'] ?></div>
            <?php endif ?>

            <div class="shop-item__icons">
                <?php if ( theme_container()->get( Favorite::class )->enabled() ): ?>
                    <span class="shop-item__icons-favorite js-shop-item-favorite" title="<?php echo __( 'Add to Favorite', THEME_TEXTDOMAIN ) ?>" data-product_id="<?php echo $product->get_id() ?>"></span>
                <?php endif ?>
                <?php if ( theme_container()->get( QuickView::class )->enabled() ): ?>
                    <span class="shop-item__icons-quick js-shop-item-quick" title="<?php echo __( 'Quick View', THEME_TEXTDOMAIN ) ?>" data-product_id="<?php echo get_the_ID() ?>"></span>
                <?php endif ?>
                <?php if ( theme_container()->get( CompareProducts::class )->enabled() ): ?>
                    <span class="shop-item__icons-compare js-shop-item-compare" title="<?php echo __( 'Add to Compare', THEME_TEXTDOMAIN ) ?>" data-product_id="<?php echo $product->get_id() ?>"></span>
                <?php endif ?>
            </div>
        </div>
        <?php woocommerce_show_product_loop_sale_flash() ?>

        <?php

        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
        do_action( 'woocommerce_before_shop_loop_item_title' );

        ?>

        <div class="shop-item__title">
            <?php
            remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
            do_action( 'woocommerce_shop_loop_item_title' );
            ?>
            <a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a>
        </div>

        <?php

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
        do_action( 'woocommerce_after_shop_loop_item_title' );

        ?>

    </div>
</div>
