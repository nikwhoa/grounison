<?php

namespace Wpshop\TheTheme\MetaBox;

use Wpshop\Core\MetaBox;

class PostThumbnails extends MetaBox {

    /**
     * PostThumbnails constructor.
     */
    public function __construct() {
        $this->set_settings( [
            'prefix'         => 'posts_thumb_',
            'post_type'      => apply_filters( THEME_SLUG . '_metabox_thumbnail_post_type', [ 'post', 'page' ] ),
            'meta_box_title' => __( 'Thumbnail settings', THEME_TEXTDOMAIN ),
            'context'        => 'side',
        ] );

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function render_fields() {
        $field_text = '';
        $field_text .= '<p><strong>' . __( 'Recommended sizes', THEME_TEXTDOMAIN ) . '</strong></p>';
        $field_text .= '<p>';
        $field_text .= sprintf( esc_html__( 'Standard: %s', THEME_TEXTDOMAIN ), '870x400' ) . '<br>';
        $field_text .= sprintf( esc_html__( 'Wide: %s', THEME_TEXTDOMAIN ), '1200x500' ) . '<br>';
        $field_text .= sprintf( esc_html__( 'Full width: %s', THEME_TEXTDOMAIN ), '1920x500' ) . '<br>';
        $field_text .= sprintf( esc_html__( 'Fullscreen: %s', THEME_TEXTDOMAIN ), '1920x500' ) . '<br>';
        $field_text .= '</p>';

        echo $field_text;

        $this->field_select(
            'thumbnail_type',
            __( 'Thumbnail type', THEME_TEXTDOMAIN ),
            [
                'standard'   => __( 'Standard', THEME_TEXTDOMAIN ),
                'full'       => __( 'Full', THEME_TEXTDOMAIN ),
                'fullscreen' => __( 'Fullscreen', THEME_TEXTDOMAIN ),
            ]
        );
    }
}
