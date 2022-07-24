<?php

namespace Wpshop\TheTheme\Settings\Storage;

use Wpshop\SettingApi\OptionStorage\AbstractOptionStorage;

/**
 * Class OptionStorage
 * @package Wpshop\TheTheme\Settings
 *
 * @property string|null $license
 * @property int|null    $show_license_key
 */
class BaseOptionStorage extends AbstractOptionStorage {

    const SECTION = 'bono_theme_base';

    /**
     * @return string
     */
    public function getSection() {
        return self::SECTION;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setLicense( $value ) {
        update_option( THEME_SLUG . '_license', $value );

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicense() {
        return get_option( THEME_SLUG . '_license' );
    }
}
