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
 * @package bonot
 */

$wpshop_core = theme_container()->get( \Wpshop\Core\Core::class );
?>

<?php if ( has_nav_menu( 'footer' ) && $wpshop_core->is_show_element( 'footer_menu' ) ) { ?>
    <div class="footer-navigation <?php $wpshop_core->the_option( 'footer_menu_width' ) ?>" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <div class="main-navigation-inner <?php $wpshop_core->the_option( 'footer_menu_inner_width' ) ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'footer',
                'menu_id'        => 'footer_menu',
            ] );
            ?>
        </div>
    </div><!--footer-navigation-->
<?php } ?>
