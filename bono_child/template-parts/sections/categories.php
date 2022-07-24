<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\HomeConstructor;

$section_options = ( isset( $section_options ) ) ? $section_options : [];

$section_header_text = ! empty( $section_options['section_header_text'] ) ? $section_options['section_header_text'] : '';
$section_header_text = apply_filters( 'bono_homepage_constructor:categories_section_header_text', $section_header_text );
$columns             = apply_filters( 'bono_homepage_constructor:categories_section_columns', wc_get_loop_prop( 'columns' ) );

$homepage_constructor = theme_container()->get( HomeConstructor::class );

$section_classes = [];
if ( ! empty( $section_options['preset'] ) ) {
    $section_classes[] = 'section-preset--' . $section_options['preset'];
}

$product_categories = $homepage_constructor->get_categories( wp_parse_id_list( $section_options['cat'] ) );

do_action( 'bono_section_category_query_before' );

?>
    <div class="section-block section-categories <?php echo implode( ' ', $section_classes ) ?>">
        <?php if ( $section_header_text ): ?>
            <div class="section-block__header">
                <div class="section-block__title"><?php echo $section_header_text ?></div>
            </div>
        <?php endif ?>
        <!-- old code: columns-<?php /*  echo esc_attr( $columns )  */ ?>  -->
        <div class="shop-grid shop-grid--columns-2">
            <?php foreach ( $product_categories as $category ) {
                wc_get_template( 'content-product_cat.php', [
                    'category' => $category,
                    'count' => false
                ] );
            } ?>
        </div>
    </div>

<?php

do_action( 'bono_section_category_query_before' );
