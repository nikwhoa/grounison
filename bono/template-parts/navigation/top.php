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

if ( has_nav_menu( 'top' ) ) {
    echo '<div class="top-menu">';
    wp_nav_menu(
        [
            'theme_location'  => 'top',
            'container'       => 'ul',
            'menu_id'         => 'top-menu',
            'menu_class'      => 'menu',
            'container_class' => 'top-menu',
        ]
    );
    echo '</div>';
}
