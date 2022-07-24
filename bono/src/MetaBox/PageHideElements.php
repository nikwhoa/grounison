<?php

namespace Wpshop\TheTheme\MetaBox;

use Wpshop\Core\MetaBox;

class PageHideElements extends MetaBox {

    /**
     * PageHideElements constructor.
     */
    public function __construct() {
        $this->set_settings( [
            'prefix'         => 'pages_hide_',
            'post_type'      => 'page',
            'meta_box_title' => __( 'Hide elements', THEME_TEXTDOMAIN ),
            'context'        => 'side',
        ] );

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function render_fields() {
        $this->field_checkboxes( 'hide_elements', '', [
            'header'        => __( 'Header', THEME_TEXTDOMAIN ),
            'header_menu'   => __( 'Header menu', THEME_TEXTDOMAIN ),
            'thumbnail'     => __( 'Thumbnail', THEME_TEXTDOMAIN ),
            'breadcrumbs'   => __( 'Breadcrumbs', THEME_TEXTDOMAIN ),
            'title_h1'      => __( 'Title', THEME_TEXTDOMAIN ),
            'toc'           => __( 'Contents', THEME_TEXTDOMAIN ),
            'social_bottom' => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
            'comments'      => __( 'Comments', THEME_TEXTDOMAIN ),
            'sidebar'       => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'related_posts' => __( 'Related posts', THEME_TEXTDOMAIN ),
            'footer_menu'   => __( 'Footer menu', THEME_TEXTDOMAIN ),
            'footer'        => __( 'Footer', THEME_TEXTDOMAIN ),
        ] );
    }
}
