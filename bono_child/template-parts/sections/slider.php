<?php

defined('ABSPATH') || exit;

$slider = theme_container()->get(\Wpshop\TheTheme\Slider::class);

$section_options = !empty($section_options) ? transform_slide_items_data($section_options) : [];
$slide_items     = !empty($section_options['slide_items']) ? $section_options['slide_items'] : [];

/**
 * 'header' => string 'slide 1' (length=7)
 * 'description' => string 'sample of slide 1' (length=17)
 * 'btn_txt' => string 'slide 1' (length=7)
 * 'link' => string 'http://example.com' (length=18)
 * 'type' => string 'media' (length=5)
 * 'id' => string '' (length=0)
 * 'media' => string 'http://bono.local/wp-content/uploads/2019/01/pennant-1.jpg' (length=58)
 */

$css_class_full = empty($section_options['width_full']) ? '' : ' full';

$slide_items = array_filter($slide_items, function ($item) {
    if (in_array($item['type'], ['product', 'post'], true) && empty($item['id'])) {
        return false;
    }

    return true;
});

if ($slide_items) : ?>
    <?php $slider_thumbnails = [] ?>
    <div class="card-slider-container swiper-container js-swiper-home<?php echo $slider->acquire_id($section_options) . $css_class_full ?>">
        <div class="swiper-wrapper">


            <?php
            $posts = get_posts(array(
                'numberposts' => -1,
                'order' => 'ASC',
                'orderby' => 'ID',
                'post_type'   => 'slide',
            ));
            foreach ($posts as $post) : setup_postdata($post);
                $title_slider = get_the_title();
                $description = get_field('slider_description');
                $thumb_url = get_the_post_thumbnail_url($post, 'full');
            ?>
                <div class="swiper-slide card-slider card-slider--type-media">
                    <a href="<?php the_field('slider_link') ?>">
                        <div class="card-slider__image" <?php echo $thumb_url ? ' style="background-image: url(' . $thumb_url . ');"' : '' ?>></div>
                        <div class="card-slider__body">
                            <div class="card-slider__body-inner">
                                <?php if ($title_slider) : ?>
                                    <div class="card-slider__title"><span><?php echo $title_slider ?></span></div>
                                <?php endif ?>
                                <?php if (trim($description)) : ?>
                                    <div class="card-slider__excerpt">
                                        <span><?php echo nl2br($description) ?></span>
                                    </div>
                                <?php endif ?>
                                <span class="card-slider__button"><?php the_field('button_text_slider'); ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>



        </div>
        <div class="swiper-pagination"></div>

    </div>
<?php endif ?>