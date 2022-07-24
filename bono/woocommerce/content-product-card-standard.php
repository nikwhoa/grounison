<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\Favorite;
use Wpshop\TheTheme\Features\QuickView;

/**
 * @var $product WC_Product
 */
global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$availability = $product->get_availability();

?>

<div <?php wc_product_class( 'shop-item shop-item--type-standard ' . $availability['class'], $product ) ?>>

    <?php
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
    do_action( 'woocommerce_before_shop_loop_item' );
    ?>

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

        <?php if ( $product->is_on_sale() ): ?>
            <div class="shop-item__badges">
                <span class="onsale"><?php _e( 'Sale', 'woocommerce' ); ?>!</span>
            </div>
        <?php endif ?>

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
        <div class="shop-item__price">
            <?php wc_get_template( 'loop/price.php' ); ?>
        </div>

        <?php

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
        do_action( 'woocommerce_after_shop_loop_item_title' );

        ?>

    </div>

    <?php

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
    do_action( 'woocommerce_after_shop_loop_item' );

    ?>
</div>
