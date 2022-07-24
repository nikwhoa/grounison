<?php
/**
 * The sidebar containing the main widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bono
 */

use Wpshop\TheTheme\Sidebar;

$sidebar = theme_container()->get( Sidebar::class );
if ( $sidebar->hide() ) {
    return;
}

$sidebar_name = $sidebar->get_sidebar_name();

if ( ! is_active_sidebar( $sidebar_name ) ) {
    return;
}
?>


<aside id="secondary" class="widget-area" itemscope itemtype="http://schema.org/WPSideBar">
    <div class="sticky-sidebar js-sticky-sidebar">
        <?php dynamic_sidebar( $sidebar_name ); ?>
    </div>
</aside><!-- #secondary -->
