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

if ( has_nav_menu( 'header' ) ) { ?>

    <?php do_action( THEME_SLUG . '_before_main_navigation' ); ?>

    <nav id="site-navigation" class="main-navigation <?php $wpshop_core->the_option( 'header_menu_width' ) ?>">
        <div class="main-navigation-inner <?php $wpshop_core->the_option( 'header_menu_inner_width' ) ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'header',
                'menu_id'        => 'header_menu',
            ] );
            ?>
        </div>
    </nav><!-- #site-navigation -->

    <?php do_action( THEME_SLUG . '_after_main_navigation' ); ?>

<?php } ?>

<div class="mobile-menu-placeholder js-mobile-menu-placeholder"></div>
