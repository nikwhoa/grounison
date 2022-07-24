<?php

namespace Wpshop\TheTheme\MetaBox;

use Wpshop\Core\MetaBox;

class PostSettings extends MetaBox {

    /**
     * PostSettings constructor.
     */
    public function __construct() {
        $this->set_settings( [
            'prefix'         => 'posts_settings_',
            'post_type'      => 'post',
            'meta_box_title' => __( 'Post settings', THEME_TEXTDOMAIN ),
            'context'        => 'side',
        ] );

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function render_fields() {
        $this->field_text( 'comments_title', __( 'Comment title', THEME_TEXTDOMAIN ), '', __( 'If you need to set the title of the block of comments for this page, fill in this field', THEME_TEXTDOMAIN ) );
        $this->field_text( 'source_link', __( 'Source', THEME_TEXTDOMAIN ), 'http://...', __( 'If you need to provide a link to an external site as a source, fill in this field', THEME_TEXTDOMAIN ) );
        $this->field_checkbox( 'source_hide', '', __( 'Hide link to source using JS', THEME_TEXTDOMAIN ) );
        $this->field_text( 'related_posts_ids', __( 'ID related posts', THEME_TEXTDOMAIN ), '', __( 'Enter the ID of the posts separated by commas to display certain posts in related posts', THEME_TEXTDOMAIN ) );
    }
}
