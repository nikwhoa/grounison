<?php

/**
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Wpshop\Core\Core;

$core = theme_container()->get( Core::class );

$tab_type = $core->get_option( 'product_info_tabs_appearance' );

//var_dump($tab_type);

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', [] );
if ( ! $product_tabs ) {
    return;
}
switch ( $tab_type ) {
    case 'horizontal':
        ?>
        <div class="woocommerce-tabs wc-tabs-wrapper">
            <ul class="tabs wc-tabs" role="tablist">
                <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                    <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                        <a href="#tab-<?php echo esc_attr( $key ); ?>">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <?php
                $product_description_wide_class = ( $key === 'description' && $core->get_option( 'product_description_wide_content' ) )
                    ? ' product-description-wide' : '';
                ?>
                <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab<?php echo $product_description_wide_class ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                    <?php
                    if ( isset( $product_tab['callback'] ) ) {
                        call_user_func( $product_tab['callback'], $key, $product_tab );
                    }
                    ?>
                </div>
            <?php endforeach; ?>

        </div>
        <?php
        break;
    case 'vertical':
        ?>

        <div class="woocommerce-tabs woocommerce-tabs--vertical wc-tabs-wrapper">
            <ul class="tabs wc-tabs" role="tablist">
			    <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                    <li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                        <a href="#tab-<?php echo esc_attr( $key ); ?>">
						    <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                        </a>
                    </li>
			    <?php endforeach; ?>
            </ul>

            <div class="woocommerce-tabs-vertical">
                <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                    <?php
                    $product_description_wide_class = ( $key === 'description' && $core->get_option( 'product_description_wide_content' ) )
                        ? ' product-description-wide' : '';
                    ?>
                    <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab<?php echo $product_description_wide_class ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                        <?php
                        if ( isset( $product_tab['callback'] ) ) {
                            call_user_func( $product_tab['callback'], $key, $product_tab );
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <?php
        break;
    case 'successively':

        echo '<div class="woocommerce-tabs wc-tabs-wrapper">';

        foreach ( $product_tabs as $key => $product_tab ) {

	        $product_description_wide_class = ( $key === 'description' && $core->get_option( 'product_description_wide_content' ) )
		        ? ' product-description-wide' : '';

            ?>
            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> entry-content<?php echo $product_description_wide_class ?>">

                <?php if ( apply_filters( 'bono_product_tab_' . $key . '_header_show', false ) ) : ?>
                <div>
                    <h2><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></h2>
                </div>
                <?php endif; ?>

                <?php
                if ( isset( $product_tab['callback'] ) ) {
                    call_user_func( $product_tab['callback'], $key, $product_tab );
                }
                ?>

            </div>

            <?php
        }

        echo '</div>';

        break;
    default:
        break;
}
do_action( 'woocommerce_product_after_tabs' );

