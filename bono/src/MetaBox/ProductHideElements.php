<?php

namespace Wpshop\TheTheme\MetaBox;

use Wpshop\Core\MetaBox;

class ProductHideElements extends MetaBox {

    /**
     * PageHideElements constructor.
     */
    public function __construct() {
        $this->set_settings( [
            'prefix'         => 'pages_hide_',
            'post_type'      => 'product',
            'meta_box_title' => __( 'Hide elements', THEME_TEXTDOMAIN ),
            'context'        => 'side',
        ] );

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function render_fields() {
        $this->field_checkboxes( 'hide_elements', '', apply_filters( 'bono_product_hide_elements', [
            'header'      => __( 'Header', THEME_TEXTDOMAIN ),
            'header_menu' => __( 'Header menu', THEME_TEXTDOMAIN ),
            'sidebar'     => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'footer_menu' => __( 'Footer menu', THEME_TEXTDOMAIN ),
            'footer'      => __( 'Footer', THEME_TEXTDOMAIN ),
            'toc'         => __( 'Contents', THEME_TEXTDOMAIN ),
        ] ) );
    }
}
