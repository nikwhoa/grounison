<?php

namespace Wpshop\TheTheme;

class TinyMce {

    /**
     * @return void
     */
    public function init() {
        add_filter( 'mce_external_plugins', function ( $plugin_array ) {
            $plugin_array["blockquote_button_plugin"] = get_template_directory_uri() . '/assets/js/theme/tinymce.js';

            return $plugin_array;
        } );

        add_filter( 'mce_buttons_3', function ( $buttons ) {
            array_push(
                $buttons,
                'blockquote_btn',
                'spoiler_btn',
                'mark_btn',
                'mask_link'
            );

            return $buttons;
        } );

        add_action( 'admin_enqueue_scripts', [ $this, 'on_admin_enqueue_scripts' ] );
        add_action( 'after_setup_theme', [ $this, 'add_editor_styles' ] );
        add_filter( 'wp_mce_translation', [ $this, 'add_mce_translation' ], 10, 2 );
    }

    /**
     * @return void
     */
    public function on_admin_enqueue_scripts() {
        wp_enqueue_script( THEME_SLUG . '-admin-blockquote', get_template_directory_uri() . '/assets/js/theme/blockquote.js', [ 'jquery' ], THEME_ORIG_VERSION, true );
    }

    /**
     * @return void
     */
    public function add_editor_styles() {
        add_editor_style( 'assets/css/editor-styles.min.css' );
    }

    /**
     * @param array  $map
     * @param string $locale @todo check locale for support
     *
     * @return array
     */
    public function add_mce_translation( $map, $locale ) {
        foreach (
            [
                'Extra Buttons'                        => _x( 'Extra Buttons', 'tinymce', THEME_TEXTDOMAIN ),
                'OK'                                   => _x( 'OK', 'tinymce', THEME_TEXTDOMAIN ),
                'Cancel'                               => _x( 'Cancel', 'tinymce', THEME_TEXTDOMAIN ),
                'Enter text'                           => _x( 'Enter text', 'tinymce', THEME_TEXTDOMAIN ),
                'Insert blockquote'                    => _x( 'Insert blockquote', 'tinymce', THEME_TEXTDOMAIN ),
                'Insert selected text'                 => _x( 'Insert selected text', 'tinymce', THEME_TEXTDOMAIN ),
                'Add blockquote'                       => _x( 'Add blockquote', 'tinymce', THEME_TEXTDOMAIN ),
                'Mark text'                            => _x( 'Mark text', 'tinymce', THEME_TEXTDOMAIN ),
                'Mask link'                            => _x( 'Mask link', 'tinymce', THEME_TEXTDOMAIN ),
                'Link text must be selected'           => _x( 'Link text must be selected', 'tinymce', THEME_TEXTDOMAIN ),
                'Enter link address'                   => _x( 'Enter link address', 'tinymce', THEME_TEXTDOMAIN ),
                'You must specify the link address'    => _x( 'You must specify the link address', 'tinymce', THEME_TEXTDOMAIN ),
                'Highlight the spoiler text'           => _x( 'Highlight the spoiler text', 'tinymce', THEME_TEXTDOMAIN ),
                'Enter a spoiler title or leave blank' => _x( 'Enter a spoiler title or leave blank', 'tinymce', THEME_TEXTDOMAIN ),
            ] as $key => $value
        ) {
            $map[ $key ] = $value;
        }

        return $map;
    }
}
