<?php

defined('ABSPATH') || exit;

$section_options = (isset($section_options)) ? $section_options : [];

// default
$section_header_text = '';
$show_subcategories  = true;
$section_classes     = [];
$post_card_type      = 'vertical';


// prepare categories
if (!empty($section_options['cat'])) {

    $cat_children = [];
    $cat_ids      = \Wpshop\Core\Helper::parse_ids_from_string($section_options['cat']);

    foreach ($cat_ids as $cat_id) {
        if (!empty($section_header_text)) {
            $section_header_text .= ', ' . get_the_category_by_ID($cat_id);
        } else {
            $section_header_text = get_the_category_by_ID($cat_id);
        }

        $term_children = get_term_children($cat_id, 'category');
        if (is_array($term_children)) {
            $cat_children = array_merge($cat_children, $term_children);
        }
    }
}


if (isset($section_options['show_subcategories']) && $section_options['show_subcategories'] == false) {
    $show_subcategories = false;
}

if (!empty($section_options['section_header_text'])) {
    $section_header_text = $section_options['section_header_text'];
}

if (!empty($section_options['preset'])) {
    $section_classes[] = 'section-preset--' . $section_options['preset'];
}

if (!empty($section_options['post_card_type'])) {
    $post_card_type = $section_options['post_card_type'];
}
if (isset($section_options['show_thumbnails']) && $section_options['show_thumbnails'] == 'hide') {
    $section_classes[] = 'is-show-thumbnails-false';
} else {
    $section_classes[] = 'is-show-thumbnails-true';
}
//if ( ! empty( $section_options['preset'] ) ) {
//	$section_classes[] = 'preset-' . $section_options['preset'];
//}


/**
 * Prepare query
 */
$args = [
    'posts_per_page' => 4,
];

if (!empty($section_options['cat'])) {
    $args['cat'] = $section_options['cat'];
}
if (!empty($section_options['post__not_in'])) {
    $args['post__not_in'] = \Wpshop\Core\Helper::parse_ids_from_string($section_options['post__not_in']);
}
if (!empty($section_options['post__in'])) {
    $args['post__in'] = \Wpshop\Core\Helper::parse_ids_from_string($section_options['post__in']);
}
if (!empty($section_options['posts_per_page'])) {
    $args['posts_per_page'] = (int) $section_options['posts_per_page'];
}
if (!empty($section_options['offset'])) {
    $args['offset'] = (int) $section_options['offset'];
}

do_action('bono_section_post_query_before');

$args = apply_filters('bono_section_post_query_args', $args);

$section_posts = get_posts($args);

$section_header_text = apply_filters('bono_homepage_constructor:posts_section_header_text', $section_header_text);
?>

<div class="section-block section-posts <?php echo implode(' ', $section_classes) ?>">
    <?php if (!empty($section_header_text) || ((!empty($cat_children) && $show_subcategories))) : ?>
        <div class="section-block__header">
            <div class="section-block__title"><?php echo $section_header_text ?></div>

            <?php if (!empty($cat_children) && $show_subcategories) : ?>
                <div class="section-posts__categories">
                    <div class="section-posts__categories-title"><?php echo __('Subcategories', THEME_TEXTDOMAIN) ?></div>

                    <?php
                    $categories = get_categories([
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'include' => $cat_children,
                    ]);

                    echo '<ul>';
                    foreach ($categories as $category) {
                        echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li> ';
                    }
                    echo '</ul>';
                    ?>

                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="post-cards post-cards--<?php echo $post_card_type ?>">

        <?php
        foreach ($section_posts as $post) :
            setup_postdata($post);
            get_template_part('template-parts/post-card/' . $post_card_type);
        endforeach;
        wp_reset_postdata();
        ?>
        <?php
        $args = array(
            'numberposts' => 1,
            'orderby'          => 'date',
        );

        $latest_posts = get_posts($args);
        if ($latest_posts) {
            foreach ($latest_posts as $post) :
                setup_postdata($post); ?>
                <div class="main-page-post-wrapper">
                    <div class="main-page-post">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php the_content(); ?>
                    </div>
                </div>
        <?php
            endforeach;
            wp_reset_postdata();
        }
        ?>
    </div>
    <!--.post-cards-->

</div>
<!--.section-posts-->

<?php do_action('bono_section_post_query_after');
