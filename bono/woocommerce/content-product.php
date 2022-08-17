<?php
/**
 * @version 3.6.0
 */

use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\Favorite;
use Wpshop\TheTheme\Features\QuickView;

defined( 'ABSPATH' ) || exit;

/**
 * @var $product WC_Product
 */
global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$core = theme_container()->get( \Wpshop\Core\Core::class );

$availability    = $product->get_availability();
$card_type       = $core->get_option( 'product_cards_type' );
$fix_add_to_cart = $core->get_option( 'fix_add_to_cart_button' ) ? ' -fix-add-to-cart' : '';
?>
<style>


    .woocommerce-breadcrumb{
        padding-bottom: 25px;
        padding-top: 20px;
        width:155vw !important;
        position: relative;
        background:#F8F8F8;margin-bottom:0 !important;
        /*left: -20vw !important;
        padding-left: 200px;*/
        padding-left: 265px;
        left: -20vw !important;
    }


    .woocommerce-products-header__title{
        width:155vw;
        position: relative;
        background:#F8F8F8 !important;
        /*padding-left: 200px;
        left: -20vw !important;*/
        padding-left: 265px;
        left: -20vw !important;
        padding-bottom: 30px;
color: #282828;
    }

    .shop-item__buttons-cart{
        /*display:none;*/
    }


@media (max-width:850px){
    .woocommerce-breadcrumb{
        padding-left: 194px;
    }

    .page-title{
        padding-left: 194px;
    }
}

@media (max-width:740px){
    .woocommerce-breadcrumb{
        padding-left: 195px;
    }

    .page-title{
        padding-left: 195px;
    }
}

@media (max-width:650px){
    .woocommerce-breadcrumb{
        padding-left: 150px;
    }

    .page-title{
        padding-left: 150px;
    }
}

@media (max-width:546px){
    .woocommerce-breadcrumb{
        padding-left: 108px;
    }

    .page-title{
        padding-left: 146px;
    }
}

@media (max-width:400px){
    .woocommerce-breadcrumb{
        padding-left: 80px;
    }

    .page-title{
        padding-left: 146px;
    }
}
.btn-ktore-mob{
        display: none;
    }
@media (max-width:770px){
    .frig:hover{
padding: 8px 0px;
}
    .btn-ktore-mob{
        display: block;
    }

    .btn-ktore-pc{
        display: none;
    }

    .flex-foritems{flex-direction: column;}

    .pc-noo{
        display: none;
    }

    .mob-noo{
        display: block !important;
        padding-right: 30px;
        padding-bottom: 15px;
    }

    .good-knopki {flex-direction: column-reverse;}

    .costam{
        display: flex;
    flex-direction: row;
    align-content: space-around;
    }
}

.mob-noo{
    display: none;
}

@media (min-width:1350px){
    .breadcrumb{
        padding-left: 315px;
        padding-bottom:-4px;
    }

    .woocommerce-breadcrumb{
        padding-left: 315px;
    }

    .page-title{
        padding-left: 315px;
    }
}

@media (min-width:1500px){

    .breadcrumb{
        left:-25vw !important;
        padding-left:25px;
        padding-bottom:10px;
    }

    .woocommerce-breadcrumb{
        padding-left: 505px;
    }

    .page-title{
        left: -25vw !important;
        width:155vw !important;
        padding-left: 505px;
    }

}

@media (min-width:1550px){

    .breadcrumb{
        left:-25vw !important;
        padding-left:25px;
        padding-bottom:10px;
    }

    .woocommerce-breadcrumb{
        padding-left: 358px;
    }

    .page-title{
        left: -25vw !important;
        width:155vw !important;
        padding-left: 433px;
    }

}


@media (min-width:1600px){

    .breadcrumb{
        padding-left:490px;
        padding-bottom:10px;
        width:155vw !important;
    }

    .woocommerce-breadcrumb{
        padding-left: 465px;
        left:-25vw !important;
    }

    .page-title{
        left: -25vw !important;
        width:155vw !important;
        padding-left: 465px;
    }

}

@media (min-width:1920px){


    .page-title{
        left: -20vw !important;
    }

}
</style>


<div <?php wc_product_class( "shop-item shop-item--type-{$card_type}{$fix_add_to_cart} " . $availability['class'], $product ) ?>>

    <?php
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
    do_action( 'woocommerce_before_shop_loop_item' );
    ?>

    <div class="shop-item-inner">

        <div class="shop-item__image nb">

            <?php echo woocommerce_get_product_thumbnail() ?>

            <?php if ( $product->is_in_stock() ): ?>
                <div class="shop-item__buttons">
                    <?php //woocommerce_template_loop_add_to_cart() ?>

                    <?php // added to prevent appear "View Cart" text ?>
                    <div class="added_to_cart"></div>

                </div>
            <?php else: ?>
                <div class="shop-item__outofstock"><?php echo $availability['availability'] ?></div>
            <?php endif ?>

            <!-- <div class="shop-item__icons">
                <?php //if ( theme_container()->get( Favorite::class )->enabled() ): ?>
                    <span class="shop-item__icons-favorite js-shop-item-favorite" title="<?php //echo __( 'Add to Favorite', THEME_TEXTDOMAIN ) ?>" data-product_id="<?php //echo $product->get_id() ?>"></span>
                <?php //endif ?>
                <?php //if ( theme_container()->get( QuickView::class )->enabled() ): ?>
                    <span class="shop-item__icons-quick js-shop-item-quick" title="<?php //echo __( 'Quick View', THEME_TEXTDOMAIN ) ?>" data-product_id="<?php //echo get_the_ID() ?>"></span>
                <?php //endif ?>
                <?php //if ( theme_container()->get( CompareProducts::class )->enabled() ): ?>
                    <span class="shop-item__icons-compare js-shop-item-compare" title="<?php //echo __( 'Add to Compare', THEME_TEXTDOMAIN ) ?>" data-product_id="<?php //echo $product->get_id() ?>"></span>
                <?php //endif ?>
            </div> -->
        </div>

        <?php woocommerce_show_product_loop_sale_flash() ?>

        <?php

        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
        do_action( 'woocommerce_before_shop_loop_item_title' );

        ?>

        <div class="flex-foritems">
            <div class="shop-item__title">
                <?php
                remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
                do_action( 'woocommerce_shop_loop_item_title' );
                ?>
                <a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a>
            </div>
            <div class="shop-item__price pc-noo">
                <?php wc_get_template( 'loop/price.php' ); ?>
            </div>
        </div>

        <?php

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
        do_action( 'woocommerce_after_shop_loop_item_title' );

        ?>
<div class="good-knopki">
<div>

<?
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];

?>


<?php if (strpos(get_permalink(), '/ee/') !== false) {
    ?><?php woocommerce_template_loop_add_to_cart() ?><?
}else{
    ?><?php woocommerce_template_loop_add_to_cart() ?>
    <?
} ?></div>

<?php //woocommerce_tedfsdsdfstsdfyasdsdfdf; ?>
<div class="costam">
<div class="shop-item__price mob-noo">
                <?php wc_get_template( 'loop/price.php' ); ?>
</div>
<div class="good-peace">
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
</div>

    </div>

    <?php

    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
    do_action( 'woocommerce_after_shop_loop_item' );

    ?>


</div>