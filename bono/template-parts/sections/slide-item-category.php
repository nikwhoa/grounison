<?php

defined( 'ABSPATH' ) || exit;


/**
 * @var WP_Term $_category
 * @var array   $_item
 */

if ( empty( $_category ) || empty( $_item ) ) {
    return;
}

$title       = apply_filters( 'bono_category_slide_item_title',
    esc_html( $_category->name ),
    $_item,
    $_category
);
$description = apply_filters(
    'bono_category_slide_item_description',
    esc_html( $_category->description ),
    $_item,
    $_category
);
$url         = apply_filters(
    'bono_category_slide_item_url',
    $_item['link'] ?: get_term_link( $_category ),
    $_item,
    $_category
);
$button_text = apply_filters(
    'bono_category_slide_item_button_text',
    esc_html( $_item['btn_txt'] ?: __( 'More', THEME_TEXTDOMAIN ) ),
    $_item,
    $_category
);

?>
<div class="swiper-slide ss card-slider card-slider--type-<?php echo esc_attr( $_item['type'] ) ?>">
    <a href="<?php echo $url ?>" class="card-slider-wrap">
        <div class="card-slider__image">
            <?php woocommerce_subcategory_thumbnail( $_category ) ?>
        </div>
        <div class="card-slider__body">
            <div class="card-slider__body-inner">
                <div class="card-slider__title"><?php echo $title ?></div>
                <div class="card-slider__excerpt">
                    <p><?php echo $description ?></p>
                </div>
                <span class="card-slider__button"><?php echo $button_text ?></span>
            </div>
        </div>
    </a>
</div>
