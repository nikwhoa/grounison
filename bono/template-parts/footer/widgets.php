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

$wpshop_core = theme_container()->get( \Wpshop\Core\Core::class );

$footer_widgets = $wpshop_core->get_option( 'footer_widgets' );
if ( $footer_widgets > 5 ) {
    $footer_widgets = 5;
}

if ( $footer_widgets > 0 ) {

    echo '<div class="footer-widgets footer-widgets-' . $footer_widgets . '">';

    for ( $n = 1 ; $n <= $footer_widgets ; $n ++ ) {

        echo '<div class="footer-widget">';
        dynamic_sidebar( 'footer-widget-' . $n );
        echo '</div>';

    }

    echo '</div>';
}
