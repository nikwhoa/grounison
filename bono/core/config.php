<?php

use Wpshop\TheTheme\Settings\SettingsProvider;

if ( ! defined( 'WPINC' ) ) {
    die;
}

$local = file_exists( __DIR__ . '/config.local.php' ) ? include __DIR__ . '/config.local.php' : [];

return array_replace_recursive( [
    'activate_url'       => 'https://wpshop.ru/api.php', // @deprecated
    'update_url'         => 'https://api.wpgenerator.ru/wp-update-server/',
    'settings_providers' => [
        SettingsProvider::class,
    ],
], $local );

