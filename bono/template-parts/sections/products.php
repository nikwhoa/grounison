<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\HomeConstructor\ProductSection;
use Wpshop\TheTheme\Features\QuickView;

if ( ! is_wc_enabled() ) {
    return;
}

$section_options = ( isset( $section_options ) ) ? $section_options : [];

$section_header_text = ! empty( $section_options['section_header_text'] ) ? $section_options['section_header_text'] : '';
$post_card_type      = ! empty( $section_options['post_card_type'] ) ? $section_options['post_card_type'] : 'vertical';
$section_classes     = [];
if ( ! empty( $section_options['preset'] ) ) {
    $section_classes[] = 'section-preset--' . $section_options['preset'];
}

do_action( 'bono_section_product_query_before' );

$posts = theme_container()->get( ProductSection::class )->get_products( $section_options );

$section_header_text = apply_filters( 'bono_homepage_constructor:products_section_header_text', $section_header_text );
$columns             = apply_filters( 'bono_homepage_constructor:products_section_columns', wc_get_loop_prop( 'columns' ) );
?>
    <div class="section-block section-products <?php echo implode( ' ', $section_classes ) ?>">
        <?php if ( $section_header_text ): ?>
            <div class="section-block__header">
                <div class="section-block__title"><?php echo $section_header_text ?></div>
            </div>
        <?php endif ?>
        <div class="shop-grid shop-grid--columns-<?php echo esc_attr( $columns ) ?>">
            <!--        <div class="post-cards post-cards----><?php //echo $post_card_type ?><!--">-->
            <?php foreach ( $posts as $post ):
                setup_postdata( $post );
                wc_get_template_part( 'content', 'product-card-' . $post_card_type );
//				get_template_part( 'template-parts/product-card/' . $post_card_type );
            endforeach;
            wp_reset_postdata();
            ?>
        </div><!--.post-cards-->
    </div><!--.section-block-->
<?php

do_action( 'bono_section_product_query_after' );

theme_container()->get( QuickView::class )->output_placeholder();
