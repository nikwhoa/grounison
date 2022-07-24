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

$wpshop_core    = theme_container()->get( \Wpshop\Core\Core::class );
$logotype_image = $wpshop_core->get_option( 'logotype_image' );
$logotype_alt   = apply_filters( THEME_SLUG . '_logotype_alt', get_bloginfo( 'name' ) );

?>
<div class="site-branding">
    <?php

    if ( ! empty( $logotype_image ) ) {
        if ( is_front_page() && ! is_paged() ) {
            echo '<div class="site-logotype"><img src="' . $logotype_image . '" alt="' . $logotype_alt . '"></div>';
        } else {
            echo '<div class="site-logotype"><a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . $logotype_image . '" alt="' . $logotype_alt . '"></a></div>';
        }
    }

    if ( ! $wpshop_core->get_option( 'header_hide_title' ) || ! $wpshop_core->get_option( 'header_hide_description' ) ) {

        $structure_home_h1 = $wpshop_core->get_option( 'structure_home_h1' );
        if ( ! $structure_home_h1 ) {
            $structure_home_h1 = '';
        }

        $site_title_text = get_bloginfo( 'name' );
        $site_title_tag  = apply_filters( THEME_SLUG . '_site_title_tag', 'div' );

        $description = get_bloginfo( 'description', 'display' );

        if ( is_front_page() && is_home() ) {

            if ( empty( $structure_home_h1 ) ) {
                $site_title_tag = 'h1';
            }

            if ( is_paged() ) {
                $site_title_text = '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>';
            }

        } else {
            if ( ! is_front_page() ) {
                $site_title_text = '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>';
            }
        }

        echo '<div class="site-branding__body">';

        if ( ! $wpshop_core->get_option( 'header_hide_title' ) ) {
            echo '<' . $site_title_tag . ' class="site-title">' . $site_title_text . '</' . $site_title_tag . '>';
        }
        if ( ( $description || is_customize_preview() ) && ! $wpshop_core->get_option( 'header_hide_description' ) ) {
            echo '<p class="site-description">' . $description . '</p>';
        }

        echo '</div>';

    }
    ?>
</div><!-- .site-branding -->
