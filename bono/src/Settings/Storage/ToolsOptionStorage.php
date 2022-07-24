<?php

namespace Wpshop\TheTheme\Settings\Storage;

use Wpshop\Core\ThemeOptions;
use Wpshop\SettingApi\OptionStorage\AbstractOptionStorage;

/**
 * Class ToolsOptionStorage
 * @package Wpshop\TheTheme\Settings
 *
 * @property string|null $settings_export
 * @property string|null $settings_import
 */
class ToolsOptionStorage extends AbstractOptionStorage {

    const SECTION = 'bono_theme_tools';

    /**
     * @var ThemeOptions
     */
    protected $options;

    /**
     * ToolsOptionStorage constructor.
     *
     * @param ThemeOptions $options
     */
    public function __construct( ThemeOptions $options ) {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getSection() {
        return self::SECTION;
    }

    /**
     * @return string|null
     */
    public function getSettingsExport() {
        if ( $value = get_option( $this->options->option_name ) ) {
            return $this->serialize( $value );
        }

        return null;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setSettingsImport( $value ) {
        if ( $value = $this->unserialize( $value ) ) {
            update_option( $this->options->option_name, $value );
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return string|null
     */
    public function serialize( $value ) {
        if ( $value ) {
            return base64_encode( json_encode( $value ) );
        }

        return null;
    }

    /**
     * @param string $value
     *
     * @return null|array
     */
    public function unserialize( $value ) {
        if ( false !== ( $value = base64_decode( $value ) ) ) {
            if ( $value = json_decode( $value, true ) ) {
                return $value;
            }
        }

        return null;
    }
}
