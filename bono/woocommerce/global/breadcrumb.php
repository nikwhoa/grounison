<?php

/**
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Wpshop\Core\Core;

/**
 * @var string $wrap_before
 * @var string $before
 * @var string $after
 * @var string $delimiter
 * @var string $wrap_after
 */

$wpshop_core = theme_container()->get( Core::class );

$breadcrumbs_display = true;
if ( ! $wpshop_core->get_option( 'breadcrumbs_display' ) ||
     ! ( $wpshop_core->get_option( 'breadcrumbs_shop' ) && is_wc_enabled() )
) {
    $breadcrumbs_display = false;
}

$breadcrumbs_display = apply_filters( 'bono_breadcrumbs_do_show', $breadcrumbs_display );

if ( ! $breadcrumbs_display ) {
    return;
}

if ( ! empty( $breadcrumb ) ) {

    echo $wrap_before;

    foreach ( $breadcrumb as $key => $crumb ) {

        echo $before;

        if ( ! empty( $crumb[1] ) ) {
            echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
        } else {
            echo esc_html( $crumb[0] );
        }

        echo $after;

        if ( sizeof( $breadcrumb ) !== $key + 1 ) {
            echo $delimiter;
        }
    }

    echo $wrap_after;

}
