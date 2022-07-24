<?php

defined( 'ABSPATH' ) || exit;

$slider = theme_container()->get( \Wpshop\TheTheme\Slider::class );

$section_options = ! empty( $section_options ) ? transform_slide_items_data( $section_options ) : [];
$slide_items     = ! empty( $section_options['slide_items'] ) ? $section_options['slide_items'] : [];

/**
 * 'header' => string 'slide 1' (length=7)
 * 'description' => string 'sample of slide 1' (length=17)
 * 'btn_txt' => string 'slide 1' (length=7)
 * 'link' => string 'http://example.com' (length=18)
 * 'type' => string 'media' (length=5)
 * 'id' => string '' (length=0)
 * 'media' => string 'http://bono.local/wp-content/uploads/2019/01/pennant-1.jpg' (length=58)
 */

$css_class_full = empty( $section_options['width_full'] ) ? '' : ' full';

$slide_items = array_filter( $slide_items, function ( $item ) {
    if ( in_array( $item['type'], [ 'product', 'post' ], true ) && empty( $item['id'] ) ) {
        return false;
    }

    return true;
} );

if ( $slide_items ): ?>
    <?php $slider_thumbnails = [] ?>
    <div class="card-slider-container swiper-container js-swiper-home<?php echo $slider->acquire_id( $section_options ) . $css_class_full ?>">
        <div class="swiper-wrapper">
            <?php foreach ( $slide_items as $item ): ?>
                <?php

                $title       = '';
                $excerpt     = '';
                $url         = $item['link'];
                $button_text = __( 'More', THEME_TEXTDOMAIN );

                if ( 'media' === $item['type'] ) {
                    $thumb_url = $item['media'];
                } elseif ( 'post' === $item['type'] && ( $post = get_post( $item['id'] ) ) ) {
                    $thumb_url = get_the_post_thumbnail_url( $post, 'full' );
                    $title     = get_the_title( $post->ID );
                } elseif ( 'product' === $item['type'] && ( $post = get_post( $item['id'] ) ) ) {
                    $title = get_the_title( $post->ID );

                    $url = get_the_permalink( $post );
                    if ( ! empty( $item['link'] ) ) {
                        $url = $item['link'];
                    }

                    $_product = wc_get_product( $post->ID );
                } elseif ( 'category' === $item['type'] &&
                           ( $terms = get_the_terms( $item['id'], 'product_cat' ) ) &&
                           ! is_wp_error( $terms )
                ) {
                    $_category = current( $terms );
                }

                if ( ! empty( $item['header'] ) ) {
                    $title = $item['header'];
                }
                if ( ! empty( $item['description'] ) ) {
                    $excerpt = ( $item['description'] );
                }
                if ( ! empty( $item['btn_txt'] ) ) {
                    $button_text = $item['btn_txt'];
                }
                ?>

                <?php if ( 'product' === $item['type'] && $_product ) { ?>
                    <?php $excerpt = $excerpt ? nl2br( $excerpt ) : $_product->get_short_description() ?>

                    <div class="swiper-slide card-slider card-slider--type-<?php echo $item['type'] ?>">
                        <a href="<?php echo $url ?>" class="card-slider-wrap">
                            <div class="card-slider__image">
                                <?php the_post_thumbnail( 'woocommerce_thumbnail' ) ?>
                            </div>
                            <div class="card-slider__body">
                                <div class="card-slider__body-inner">
                                    <div class="card-slider__title"><?php echo $title ?></div>
                                    <div class="card-slider__price price    ">
                                        <?php echo $_product->get_price_html() ?>
                                    </div>
                                    <div class="card-slider__excerpt">
                                        <?php echo $excerpt ?>
                                    </div>
                                    <span class="card-slider__button"><?php echo $button_text ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } elseif ( 'category' === $item['type'] && ! empty( $_category ) ) { ?>
                    <?php
                    set_query_var( '_category', $_category );
                    set_query_var( '_item', $item );
                    get_template_part( 'template-parts/sections/slide-item', 'category' );
                    ?>
                <?php } else if ( 'media' === $item['type'] ) { ?>

                    <div class="swiper-slide card-slider card-slider--type-<?php echo $item['type'] ?>">
                        <a href="<?php echo $url ?>">
                            <div class="card-slider__image"<?php echo $thumb_url ? ' style="background-image: url(' . $thumb_url . ');"' : '' ?>></div>
                            <div class="card-slider__body">
                                <div class="card-slider__body-inner">
                                    <?php if ( $title ): ?>
                                        <div class="card-slider__title"><span><?php echo $title ?></span></div>
                                    <?php endif ?>
                                    <?php if ( trim( $excerpt ) ): ?>
                                        <div class="card-slider__excerpt">
                                            <span><?php echo nl2br( $excerpt ) ?></span>
                                        </div>
                                    <?php endif ?>
                                    <?php if ( ! empty( $item['btn_txt'] ) && trim( $item['btn_txt'] ) ): ?>
                                        <span class="card-slider__button"><?php echo $button_text ?></span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php } else if ( 'post' === $item['type'] ) { ?>
                    <?php $excerpt = $excerpt ? nl2br( $excerpt ) : $post->post_excerpt ?>
                    <div class="swiper-slide card-slider card-slider--type-<?php echo $item['type'] ?>">
                        <a href="<?php echo $url ?>">
                            <div class="card-slider__image"<?php echo $thumb_url ? ' style="background-image: url(' . $thumb_url . ');"' : '' ?>></div>
                            <div class="card-slider__body">
                                <div class="card-slider__body-inner">
                                    <div class="card-slider__title"><?php echo $title ?></div>
                                    <div class="card-slider__excerpt">
                                        <?php echo $excerpt ?>
                                    </div>
                                    <span class="card-slider__button"><?php echo $button_text ?></span>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php } ?>

            <?php endforeach ?>
        </div>
        <div class="swiper-pagination"></div>

    </div>
<?php endif ?>
