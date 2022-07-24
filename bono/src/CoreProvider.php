<?php

namespace Wpshop\TheTheme;

use Pimple\Container;
use Pimple\ServiceIterator;
use Pimple\ServiceProviderInterface;
use Wpshop\Core\AdminNotices;
use Wpshop\Core\Advertising;
use Wpshop\Core\Breadcrumbs;
use Wpshop\Core\ContactForm;
use Wpshop\Core\Core;
use Wpshop\Core\Customizer\Customizer;
use Wpshop\Core\Fonts;
use Wpshop\Core\Helper;
use Wpshop\Core\MetaBoxTaxonomy;
use Wpshop\Core\Partner;
use Wpshop\Core\Shortcodes;
use Wpshop\Core\Sitemap;
use Wpshop\Core\Social;
use Wpshop\Core\StarRating;
use Wpshop\Core\TableOfContents;
use Wpshop\Core\Template;
use Wpshop\Core\ThemeSettings;
use Wpshop\Core\ThemeUpdater;
use Wpshop\Core\Transliteration;
use Wpshop\Core\ThemeOptions;
use Wpshop\Core\ViewsCounter;

class CoreProvider implements ServiceProviderInterface {

    /**
     * @inheritDoc
     */
    public function register( Container $c ) {
        $c[ Helper::class ]           = function ( $c ) {
            return new Helper( $c[ ThemeOptions::class ] );
        };
        $c[ Core::class ]             = function ( $c ) {
            $core = new Core( $c[ ThemeOptions::class ] );
            remove_action( 'admin_notices', [ $core, 'notice_check_license' ] );

            return $core;
        };
        $c[ ThemeSettings::class ]    = function ( $c ) {
            return new ThemeSettings( $c[ ThemeOptions::class ] );
        };
        $c[ ThemeUpdater::class ]     = function ( $c ) {
            return new ThemeUpdater( $c[ ThemeOptions::class ] );
        };
        $c[ Customizer::class ]       = function ( $c ) {
            return new Customizer( $c[ ThemeOptions::class ] );
        };
        $c[ Template::class ]         = function ( $c ) {
            return new Template( $c[ ThemeOptions::class ] );
        };
        $c[ Breadcrumbs::class ]      = function ( $c ) {
            return new Breadcrumbs( $c[ ThemeOptions::class ] );
        };
        $c [ Sitemap::class ]         = function ( $c ) {
            return new Sitemap( $c[ ThemeOptions::class ] );
        };
        $c [ Advertising::class ]     = function ( $c ) {
            return new Advertising( $c[ ThemeOptions::class ] );
        };
        $c [ Shortcodes::class ]      = function ( $c ) {
            return new Shortcodes( $c[ ThemeOptions::class ] );
        };
        $c [ Social::class ]          = function ( $c ) {
            return new Social( $c[ ThemeOptions::class ] );
        };
        $c [ TableOfContents::class ] = function ( $c ) {
            return new TableOfContents( $c[ ThemeOptions::class ], $c[ Helper::class ], $c[ Core::class ] );
        };
        $c [ ContactForm::class ]     = function ( $c ) {
            return new ContactForm( $c[ ThemeOptions::class ] );
        };
        $c [ Fonts::class ]           = function ( $c ) {
            add_filter( 'wpshop_fonts_list', function ( $fonts ) {
                $fonts['rubik']['weight'] = '300,400,400i,500,700';

                return $fonts;
            } );

            return new Fonts( $c[ ThemeOptions::class ] );
        };
        $c [ MetaBoxTaxonomy::class ] = function () {
            return new MetaBoxTaxonomy();
        };
        $c [ Transliteration::class ] = function () {
            return new Transliteration();
        };
        $c[ StarRating::class ]       = function ( $c ) {
            return new StarRating( $c[ ThemeOptions::class ] );
        };
        $c[ Partner::class ]          = function ( $c ) {
            return new Partner( $c[ ThemeOptions::class ] );
        };
        $c[ AdminNotices::class ]     = function ( $c ) {
            return new AdminNotices( $c[ ThemeOptions::class ] );
        };
        $c[ ViewsCounter::class ]     = function ( $c ) {
            return new ViewsCounter(
                $c[ Core::class ],
                $c[ ThemeOptions::class ],
                $c[ AdminNotices::class ]
            );
        };

        foreach (
            $initServices = new ServiceIterator( $c, [
                Core::class,
                //				ThemeSettings::class,
                ThemeUpdater::class,
                Sitemap::class,
                Social::class,
                ContactForm::class,
                Fonts::class,
                MetaBoxTaxonomy::class,
            ] ) as $s
        ) {
        }
    }
}
