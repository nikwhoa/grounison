<?php

if ( ! defined( 'WPINC' ) ) {
    die;
}

use Pimple\Container;
use Wpshop\Core\AdminNotices;
use Wpshop\Core\Advertising;
use Wpshop\Core\Breadcrumbs;
use Wpshop\Core\ContactForm;
use Wpshop\Core\Core;
use Wpshop\Core\Customizer\Customizer;
use Wpshop\Core\Fonts;
use Wpshop\Core\Social;
use Wpshop\SettingApi\SettingsManagerProvider;
use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\HomeConstructor\ProductSection;
use Wpshop\TheTheme\Features\OneClickBuy;
use Wpshop\TheTheme\Features\ProductMicroData;
use Wpshop\TheTheme\Features\SaleFlash;
use Wpshop\TheTheme\Features\HomeConstructor;
use Wpshop\TheTheme\MetaBox\ProductHideElements;
use Wpshop\TheTheme\PluginsIntegration;
use Wpshop\TheTheme\ProductTabs;
use Wpshop\TheTheme\Setup\DataSetup;
use Wpshop\TheTheme\Support\CatalogModeSupport;
use Wpshop\TheTheme\Support\ProductGallerySupport;
use Wpshop\TheTheme\ThemeProvider;
use Wpshop\TheTheme\CommentCallback;
use Wpshop\TheTheme\CoreProvider;
use Wpshop\Core\ThemeOptions;
use Wpshop\TheTheme\Features\QuickView;
use Wpshop\TheTheme\MetaBox\PageHideElements;
use Wpshop\TheTheme\MetaBox\PostHideElements;
use Wpshop\TheTheme\MetaBox\PostSettings;
use Wpshop\TheTheme\MetaBox\PostThumbnails;
use Wpshop\TheTheme\Settings\ResetSettingsAction as ResetAction;
use Wpshop\TheTheme\Settings\Storage\ToolsOptionStorage;
use Wpshop\TheTheme\Setup\CustomizerSetup;
use Wpshop\TheTheme\Features\AjaxAddToCart;
use Wpshop\TheTheme\Features\ImageManagement;
use Wpshop\TheTheme\PostCard;
use Wpshop\TheTheme\Settings\Storage\BaseOptionStorage;
use Wpshop\TheTheme\Settings\SettingsProvider;
use Wpshop\TheTheme\Features\Favorite;
use Wpshop\TheTheme\Setup\ThemeSetup;
use Wpshop\TheTheme\Setup\WoocommerceSetup;
use Wpshop\TheTheme\Sidebar;
use Wpshop\TheTheme\Slider;
use Wpshop\TheTheme\SocialHelper;
use Wpshop\TheTheme\TemplateRenderer;
use Wpshop\TheTheme\TinyMce;
use Wpshop\TheTheme\WcHelper;

return function ( $config ) {
    global $wpdb;

    $container = new Container( [
        'config'                   => $config,
        ThemeOptions::class        => function ( $c ) {
            $options                 = new \Wpshop\TheTheme\ThemeOptions();
            $options->version        = THEME_VERSION;
            $options->text_domain    = THEME_TEXTDOMAIN;
            $options->theme_name     = THEME_NAME;
            $options->theme_title    = THEME_TITLE;
            $options->theme_slug     = THEME_SLUG;
            $options->settings_name  = THEME_SLUG . '_settings';
            $options->option_name    = THEME_SLUG . '_options';
            $options->license        = THEME_SLUG . '_license';
            $options->license_verify = THEME_SLUG . '_license_verify';
            $options->license_error  = THEME_SLUG . '_license_error';

            $options->license_request_error = THEME_SLUG . '_license_request_error';

            $options->settings_page_title = __( 'Theme Settings', THEME_TEXTDOMAIN );
            $options->settings_menu_title = __( 'Theme Settings', THEME_TEXTDOMAIN );

            $options->updater_url = isset( $c['config']['update_url'] ) ? $c['config']['update_url'] : '';

            return $options;
        },
        SettingsProvider::class    => function ( $c ) {
            return new SettingsProvider(
                $c[ BaseOptionStorage::class ],
                $c[ ToolsOptionStorage::class ],
                $c[ ThemeProvider::class ],
                $c[ ThemeOptions::class ]
            );
        },
        ResetAction::class         => function ( $c ) {
            return new ResetAction( $c[ ThemeOptions::class ] );
        },
        ThemeProvider::class       => function ( $c ) {
            return new ThemeProvider(
                $c[ ThemeOptions::class ],
                isset( $c['config']['activate_url'] ) ? $c['config']['activate_url'] : ''
            );
        },
        BaseOptionStorage::class   => function () {
            return new BaseOptionStorage();
        },
        ToolsOptionStorage::class  => function ( $c ) {
            return new ToolsOptionStorage( $c[ ThemeOptions::class ] );
        },
        ThemeSetup::class          => function ( $c ) {
            return new ThemeSetup(
                $c[ ThemeOptions::class ],
                $c[ Core::class ],
                $c[ Customizer::class ],
                $c[ Social::class ],
                $c[ Fonts::class ],
                $c[ Breadcrumbs::class ],
                $c[ ContactForm::class ],
                $c[ Advertising::class ]
            );
        },
        WoocommerceSetup::class    => function ( $c ) {
            return new WoocommerceSetup(
                $c[ Core::class ],
                $c[ Breadcrumbs::class ],
                $c[ AdminNotices::class ]
            );
        },
        CustomizerSetup::class     => function ( $c ) {
            return new CustomizerSetup(
                $c[ Core::class ],
                $c[ Customizer::class ],
                $c[ Social::class ],
                $c[ Sidebar::class ],
                $c[ ThemeOptions::class ]
            );
        },
        DataSetup::class           => function ( $c ) {
            return new DataSetup(
                THEME_SLUG . '_data_version',
                $c[ CompareProducts::class ]
            );
        },
        TinyMce::class             => function () {
            return new TinyMce();
        },
        PostCard::class            => function ( $c ) {
            return new PostCard( $c[ Core::class ] );
        },
        CommentCallback::class     => function ( $c ) {
            return new CommentCallback( $c[ Core::class ], $c[ TemplateRenderer::class ] );
        },
        TemplateRenderer::class    => function () {
            return new TemplateRenderer();
        },
        SocialHelper::class        => function ( $c ) {
            return new SocialHelper(
                $c[ Core::class ],
                $c[ ThemeOptions::class ],
                $c[ Favorite::class ]
            );
        },
        CompareProducts::class     => function ( $c ) {
            return new CompareProducts( $c[ Core::class ] );
        },
        Favorite::class            => function ( $c ) {
            return new Favorite( $c[ ThemeOptions::class ], $c[ Core::class ] );
        },
        ImageManagement::class     => function () {
            return new ImageManagement();
        },
        OneClickBuy::class         => function ( $c ) {
            return new OneClickBuy(
                $c[ Core::class ],
                $c[ TemplateRenderer::class ]
            );
        },
        ProductMicroData::class    => function () {
            return new ProductMicroData();
        },
        QuickView::class           => function () {
            return new QuickView();
        },
        SaleFlash::class           => function ( $c ) {
            return new SaleFlash( $c[ Core::class ] );
        },
        AjaxAddToCart::class       => function () {
            return new AjaxAddToCart();
        },
        Sidebar::class             => function ( $c ) {
            return new Sidebar(
                $c[ Core::class ],
                $c[ Favorite::class ],
                $c[ CompareProducts::class ]
            );
        },
        PageHideElements::class    => function () {
            return new PageHideElements();
        },
        ProductHideElements::class => function () {
            return new ProductHideElements();
        },
        PostHideElements::class    => function () {
            return new PostHideElements();
        },
        PostSettings::class        => function () {
            return new PostSettings();
        },
        PostThumbnails::class      => function () {
            return new PostThumbnails();
        },
        WcHelper::class            => function () {
            return new WcHelper();
        },
        Slider::class              => function ( $c ) {
            return new Slider( $c[ Core::class ] );
        },
        ProductTabs::class         => function ( $c ) {
            return new ProductTabs( $c[ Core::class ] );
        },
        PluginsIntegration::class  => function () {
            return new PluginsIntegration();
        },
        HomeConstructor::class     => function ( $c ) {
            return new HomeConstructor( $c[ Core::class ] );
        },
        ProductSection::class      => function () {
            return new ProductSection();
        },

        CatalogModeSupport::class    => function () {
            return new CatalogModeSupport();
        },
        ProductGallerySupport::class => function () {
            return new ProductGallerySupport();
        },
    ] );

    $container->register( new CoreProvider() );
    $container->register( new SettingsManagerProvider() );

    return $container;
};
