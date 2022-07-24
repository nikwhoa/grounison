<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

$orig_theme = $theme = wp_get_theme();
if ( $theme->parent() ) {
    $theme = $theme->parent();
}
define( 'THEME_VERSION', $theme->get( 'Version' ) );
define( 'THEME_ORIG_VERSION', $orig_theme->get( 'Version' ) );
define( 'THEME_TEXTDOMAIN', $theme->get( 'TextDomain' ) );
define( 'THEME_TITLE', 'Bono' );
define( 'THEME_NAME', 'bono' );
define( 'THEME_SLUG', 'bono' );

define( 'WPSHOP_PARTNER', '11541' );
