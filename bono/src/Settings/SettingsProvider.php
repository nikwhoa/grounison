<?php

namespace Wpshop\TheTheme\Settings;

use Wpshop\Core\ThemeOptions;
use Wpshop\SettingApi\OptionField\Checkbox;
use Wpshop\SettingApi\OptionField\RawHtml;
use Wpshop\SettingApi\OptionField\Text;
use Wpshop\SettingApi\Section\Section;
use Wpshop\SettingApi\SettingsPage\SettingsPageInterface;
use Wpshop\SettingApi\SettingsPage\TabSettingsPage;
use Wpshop\SettingApi\SettingsProviderInterface;
use Wpshop\TheTheme\ThemeProvider;
use Wpshop\TheTheme\Settings\OptionField\ExportSettingsTextarea;
use Wpshop\TheTheme\Settings\OptionField\ImportSettingsTextarea;
use Wpshop\TheTheme\Settings\Storage\BaseOptionStorage;
use Wpshop\TheTheme\Settings\Storage\ToolsOptionStorage;

class SettingsProvider implements SettingsProviderInterface {

    /**
     * @var BaseOptionStorage
     */
    protected $baseOptionStorage;

    /**
     * @var ToolsOptionStorage
     */
    protected $toolsOptions;

    /**
     * @var ThemeProvider
     */
    protected $activation;

    /**
     * @var ThemeOptions
     */
    protected $options;

    /**
     * SettingsProvider constructor.
     *
     * @param BaseOptionStorage  $baseOptionStorage
     * @param ToolsOptionStorage $toolsOptionStorage
     * @param ThemeProvider      $activation
     * @param ThemeOptions       $options
     */
    public function __construct(
        BaseOptionStorage $baseOptionStorage,
        ToolsOptionStorage $toolsOptionStorage,
        ThemeProvider $activation,
        ThemeOptions $options
    ) {
        $this->baseOptionStorage = $baseOptionStorage;
        $this->toolsOptions      = $toolsOptionStorage;
        $this->activation        = $activation;
        $this->options           = $options;
    }

    /**
     * @return SettingsPageInterface
     */
    public function getSettingsSubmenu() {
        $page = new TabSettingsPage(
            __( 'Bono Theme Settings', THEME_TEXTDOMAIN ),
            __( 'Bono Theme Settings ', THEME_TEXTDOMAIN ),
            'delete_posts',
            'bono-theme-setting'
        );
        $page->setBeforeRenderCallback( function () {
            echo '<div class="wrap">' . PHP_EOL;
            echo '<div style="background: #fff;padding: 10px 20px;border: 2px solid #4057a3;margin: 10px 0;">';
            echo '  <h2>С документацией по теме Вы можете ознакомиться <a href="https://support.wpshop.ru/docs/themes/' . $this->options->theme_slug . '/" target="_blank" rel="noopener">по этой ссылке</a>.</h2>';
            echo '  <p>Настройки внешнего вида и цветов находятся в кастомайзере <strong>Внешний вид > Настройки</strong>.</p>';
            echo '</div>';
        } );

        $page->addSection( $this->getBaseSection() );
        $page->addSection( $this->getToolsSection() );

        return $page;
    }

    /**
     * @return Section
     */
    protected function getBaseSection() {
        $baseOptions = $this->baseOptionStorage;
        $section     = new Section(
            $this->baseOptionStorage->getSection(),
            __( 'Basic Settings', THEME_TEXTDOMAIN ),
            $this->baseOptionStorage
        );

        $section->addField( $field = new Text( 'license' ) );
        $field
            ->setLabel( __( 'License', THEME_TEXTDOMAIN ) )
            ->setPlaceholder( $baseOptions->license ? '*****' : __( 'enter license key', THEME_TEXTDOMAIN ) )
            ->setValue( $baseOptions->show_license_key ? null : '' )
            ->setSanitizeCallback( function ( $value ) use ( $baseOptions ) {
                if ( ! $value && ! $baseOptions->show_license_key ) {
                    $value = $baseOptions->license;
                }
                $value = trim( $value );
                if ( current_user_can( 'administrator' ) && $value && $this->activation->activate( $value ) ) {
                    $baseOptions->license = $value;
                    $baseOptions->save();
                }

                return null;
            } )
            ->setDescription( get_option( $this->options->license_request_error ) )
        ;

        $section->addField( $field = new Checkbox( 'show_license_key' ) );
        $field
            ->setLabel( __( 'Show License', THEME_TEXTDOMAIN ) )
            ->setDescription( __( 'Show license key in input', THEME_TEXTDOMAIN ) )
            ->setEnabled( current_user_can( 'administrator' ) )
        ;

        return $section;
    }

    /**
     * @return Section
     */
    protected function getToolsSection() {
        $toolsOptions = $this->toolsOptions;
        $section      = new Section(
            $toolsOptions->getSection(),
            __( 'Tools', THEME_TEXTDOMAIN ),
            $toolsOptions
        );

        $section->addField( $field = new ExportSettingsTextarea( 'settings_export' ) );
        $field
            ->setLabel( __( 'Export', THEME_TEXTDOMAIN ) )
            ->setDescription( __( 'Copy this code to any text file to save all settings of this site', $this->options->text_domain ) )
            ->setSanitizeCallback( '__return_null' )
        ;

        $section->addField( $field = new ImportSettingsTextarea( 'settings_import' ) );
        $field
            ->setLabel( __( 'Import', THEME_TEXTDOMAIN ) )
            ->setDescription( __( 'Danger! Old settings will be removed before import! Paste code to this field and press Save', $this->options->text_domain ) )
            ->setSanitizeCallback( function ( $value ) use ( $toolsOptions ) {
                $toolsOptions->setSettingsImport( $value );

                return null;
            } )
        ;
        $section->addField( $field = new RawHtml( 'settings_reset' ) );
        $field->setRenderCallback( function () {
            $nonce = wp_create_nonce( 'wpshop_reset_settings' );
            echo '<button class="button button-danger js-wpshop-reset-settings" data-nonce="' . $nonce . '">' . __( 'Reset all settings', $this->options->text_domain ) . '</button>';
            echo '<p class="description" style="color: #dc3545">' . __( 'Danger! Reset all customizer settings. Reset counters, styles, sidebar settings etc.', $this->options->text_domain ) . '</p>';
        } );


        return $section;
    }
}
