<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
//do_action( 'woocommerce_before_main_content' );
?>

    <div class="product type-product status-publish has-post-thumbnail product_cat-t-shirts pif-has-gallery first instock shipping-taxable purchasable product-type-simple">
		<?php while ( have_posts() ) : the_post(); ?>

            <!--	--><?php //wc_get_template_part( 'content', 'single-product' ); ?>

            <div class="product-container">
                <div class="product-images">

                    <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">
                        <div class="flex-viewport">
                            <img src="assets/images/thumb-1000-1260-1.png" alt="">
                        </div>
                        <ol class="flex-control-nav flex-control-thumbs">
                            <li><img src="assets/images/thumb-100-100-1.png" class="flex-active" draggable="false"></li>
                            <li><img src="assets/images/thumb-100-100-2.png" alt="" draggable="false" class=""></li>
                            <li><img src="assets/images/thumb-100-100-1.png" alt="" draggable="false" class=""></li>
                        </ol>
                    </div>

                </div>
                <div class="product-info">

                    <?php woocommerce_breadcrumb() ?>

                    <h1>Стул Everyone Equal</h1>

	                <?php wc_get_template( 'loop/price.php' ); ?>
<!--                    <p class="price"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>39.00</span></p>-->

                    <div class="woocommerce-product-details__short-description">
                        <p>Современный стул с принтом Everyone Equal, подчеркнет Ваш стиль. Модель выполнена из мягкой на ощупь вискозы. Современный стул с принтом Everyone Equal, подчеркнет Ваш стиль. Модель выполнена из мягкой на ощупь вискозы.</p>
                        <p>Модель выполнена из мягкой на ощупь вискозы.</p>
                    </div>

                    <form class="cart" method="post" enctype="multipart/form-data">
                        <div class="quantity">
                            <label class="screen-reader-text" for="quantity_5d65778fd0077">Количество</label>
                            <input type="number" id="quantity_5d65778fd0077" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric">
                            <button type="button" class="quantity-minus"></button>
                            <button type="button" class="quantity-plus"></button>
                        </div>

                        <button type="submit" name="add-to-cart" value="37" class="single_add_to_cart_button button alt">В корзину</button>
                        <button type="button" name="add-favorite" class="product-favorite-btn js-product-favorite"></button>
                    </form>

                    <div class="product_meta">
                        <span class="sku_wrapper">Артикул: <span class="sku">CH-342</span></span>
                        <span class="posted_in">Категория: <a href="#" rel="tag">Стулья</a></span>
                        <span class="tagged_as">Теги: <a href="#" rel="tag">everyone</a>, <a href="#" rel="tag">кухня</a></span>
                    </div>

                </div>
            </div><!--.product-container-->

		<?php endwhile; // end of the loop. ?>
    </div>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
//do_action( 'woocommerce_after_main_content' );
?>

<?php
/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );
?>

<?php get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
