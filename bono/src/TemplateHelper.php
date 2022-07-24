<?php

namespace Wpshop\TheTheme;

class TemplateHelper {

    /**
     * @param int|\WP_Post|null $post
     *
     * @return float|null
     */
    public static function readTime( $post = null ) {
        $passRequired = false;

        add_filter( 'post_password_required', $checkPassRequired = function ( $required ) use ( &$passRequired ) {
            $passRequired = $required;

            return $required;
        }, 999 );

        $text = get_the_content( '', false, $post );

        remove_filter( 'post_password_required', $checkPassRequired, 999 );

        if ( $passRequired ) {
            return null;
        }

        $words = str_word_count( strip_tags( $text ), 0, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ' );
        if ( ! empty( $words ) ) {
            return ceil( $words / 180 );
        }

        return null;
    }
}
