<?php

use Wpshop\Core\Advertising;
use Wpshop\Core\Core;
use Wpshop\TheTheme\ThemeProvider;

$core        = theme_container()->get( Core::class );
$advertising = theme_container()->get( Advertising::class );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
    <?php $core->the_option( 'code_head' ) ?>
</head>
<body <?php body_class(); ?>>

<?php theme_container()->get( ThemeProvider::class )->check(); ?>

<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
} ?>

<?php do_action( THEME_SLUG . '_after_body' ) ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', THEME_TEXTDOMAIN ); ?></a>

    <?php
    if ( $core->get_option( 'super_header_show' ) || $core->get_option( 'super_header_show_mob' ) ): ?>
        <?php get_template_part( 'template-parts/header/super-header' ) ?>
    <?php endif ?>

    <?php
    if ( $core->is_show_element( 'header' ) ): ?>
        <?php get_template_part( 'template-parts/header/header' ) ?>
    <?php endif ?>

    <?php
    if ( $core->is_show_element( 'header_menu' ) ): ?>
        <?php get_template_part( 'template-parts/navigation/header' ) ?>
    <?php endif ?>

    <?php do_action( THEME_SLUG . '_before_site_content' ) ?>

    <div id="content" class="site-content <?php echo apply_filters( 'bono_site_content_classes', 'fixed' ) ?>">

        <?php echo $advertising->show_ad( 'before_site_content' ); ?>

        <div class="site-content-inner">
