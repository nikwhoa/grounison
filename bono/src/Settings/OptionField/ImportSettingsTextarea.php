<?php

namespace Wpshop\TheTheme\Settings\OptionField;

use Wpshop\SettingApi\OptionField\Textarea;

class ImportSettingsTextarea extends Textarea {

    /**
     * @inheritDoc
     */
    public function render( $id, $name = null, $value = null ) {
        $name  = $name ?: $id;
        $value = $this->prepareValue( $value );

        printf(
            '<textarea id="%1$s" name="%2$s" class="large-text code">%3$s</textarea>',
            $id,
            $name,
            $value
        );
        if ( $this->description ) {
            printf( '<p class="description" style="color: #dc3545">%s</p>', $this->description );
        }
    }
}
