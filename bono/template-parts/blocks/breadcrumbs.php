<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *   After update you will lose all changes. Use child theme
 *
 *   https://docs.wpshop.ru/start/child-themes
 *
 * *****************************************************************************
 *
 * @package bono
 */

$wpshop_core        = theme_container()->get( \Wpshop\Core\Core::class );
$wpshop_breadcrumbs = theme_container()->get( \Wpshop\Core\Breadcrumbs::class );

$breadcrumbs_display = $wpshop_core->get_option( 'breadcrumbs_display' );

if ( ! $wpshop_core->get_option( 'breadcrumbs_shop' ) && is_wc_enabled() ) {
    if (
        is_shop() ||
        is_product() ||
        is_product_category() ||
        is_cart() ||
        is_checkout() ||
        is_account_page() ||
        bono_is_favorite_page() ||
        bono_is_compare_page()
    ) {
        $breadcrumbs_display = false;
    }
}

$breadcrumbs_display = apply_filters( 'bono_breadcrumbs_do_show', $breadcrumbs_display );

if ( $breadcrumbs_display ) :

    $breadcrumbs_service = 'self';

    if ( function_exists( 'yoast_breadcrumb' ) ) {
        $wpseo_internallinks = get_option( 'wpseo_internallinks' );
        if ( $wpseo_internallinks['breadcrumbs-enable'] === true ) {
            $breadcrumbs_service = 'yoast';
        }
    }

    if ( $breadcrumbs_service == 'yoast' && function_exists( 'yoast_breadcrumb' ) ) {
        yoast_breadcrumb( '<div class="breadcrumb" id="breadcrumbs">', '</div>' );
    } else {
        echo $wpshop_breadcrumbs->output();
    }

endif;
