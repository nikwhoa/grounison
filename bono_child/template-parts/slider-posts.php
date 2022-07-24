<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *   After update you will lose all changes. Use child theme
 *
 *   https://docs.wpshop.ru/start/child-themes
 *
 * *****************************************************************************
 *
 * @package bono
 */

$wpshop_core = theme_container()->get( \Wpshop\Core\Core::class );

$slider_count_mod = $wpshop_core->get_option( 'slider_count' );

if ( ! empty( $slider_count_mod ) ) {

    $slider_articles = [];

    $slider_count = 3;
    if ( is_numeric( $slider_count_mod ) && $slider_count_mod > - 1 ) {
        if ( $slider_count_mod > 15 ) {
            $slider_count_mod = 15;
        }
        $slider_count = $slider_count_mod;
    }

    $slider_posts_order = $wpshop_core->get_option( 'slider_order_post' );

    $slider_posts_meta_key = '';
    $slider_meta_query     = [
        [
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS',
        ],
    ];
    $slider_posts_orderby  = 'date';

    if ( $slider_posts_order == 'rand' ) {
        $slider_posts_orderby = 'rand';
    }

    if ( $slider_posts_order == 'views' ) {
        $slider_posts_orderby  = 'meta_value_num';
        $slider_posts_meta_key = 'views';
    }

    if ( $slider_posts_order == 'comments' ) {
        $slider_posts_orderby = 'comment_count';
    }

    if ( $slider_posts_order == 'new' ) {
        $slider_posts_orderby = 'date';
    }

    $slider_posts_ids = $wpshop_core->get_option( 'slider_post_in' );

    // если указаны посты - набираем их
    if ( ! empty( $slider_posts_ids ) ) {

        $slider_posts_id_exp = explode( ',', $slider_posts_ids );

        if ( is_array( $slider_posts_id_exp ) ) {
            $slider_posts_ids = array_map( 'trim', $slider_posts_id_exp );
        } else {
            $slider_posts_ids = [ $slider_posts_ids ];
        }

        $slider_articles = get_posts( [
            'posts_per_page' => $slider_count,
            'post__in'       => $slider_posts_ids,
            'meta_key'       => $slider_posts_meta_key,
            'orderby'        => $slider_posts_orderby,
        ] );

    }

    $slider_category_ids = $wpshop_core->get_option( 'slider_category_in' );

    // если указаны рубрики - набираем их
    if ( ! empty( $slider_category_ids ) ) {

        if ( count( $slider_articles ) < $slider_count ) {

            // сколько осталось постов
            $delta = $slider_count - count( $slider_articles );

            // убираем уже выведенные
            $post__not_in = [];
            foreach ( $slider_articles as $article ) {
                $post__not_in[] = $article->ID;
            }

            $slider_category_id_exp = explode( ',', $slider_category_ids );

            if ( is_array( $slider_category_id_exp ) ) {
                $slider_category_ids = array_map( 'trim', $slider_category_id_exp );
            } else {
                $slider_category_ids = [ $slider_category_ids ];
            }

            $slider_category_articles = get_posts( [
                'posts_per_page' => $delta,
                'post__not_in'   => $post__not_in,
                'category__in'   => $slider_category_ids,
                'meta_key'       => $slider_posts_meta_key,
                'orderby'        => $slider_posts_orderby,
                'meta_query'     => $slider_meta_query,
            ] );

            // если все ок, объединяем
            if ( ! empty( $slider_category_articles ) ) {
                $slider_articles = array_merge( $slider_articles, $slider_category_articles );
            }

        }

    }


    // если не хватило, добираем из последних
    if ( count( $slider_articles ) < $slider_count ) {

        // сколько осталось постов
        $delta = $slider_count - count( $slider_articles );

        // убираем уже выведенные
        $post__not_in = [];
        foreach ( $slider_articles as $article ) {
            $post__not_in[] = $article->ID;
        }

        $slider_articles_second = get_posts( [
            'posts_per_page' => $delta,
            'post__not_in'   => $post__not_in,
            'meta_key'       => $slider_posts_meta_key,
            'orderby'        => $slider_posts_orderby,
            'meta_query'     => $slider_meta_query,
        ] );

        // если все ок, объединяем
        if ( ! empty( $slider_articles_second ) ) {
            $slider_articles = array_merge( $slider_articles, $slider_articles_second );
        }

    }

    if ( ! empty( $slider_articles ) ) {

        ?>

        <?php do_action( THEME_SLUG . '_slider_before' ) ?>

        <div class="card-slider-container swiper-container js-swiper-home">
            <div class="swiper-wrapper">

                <?php
                $slider_thumbnails = [];
                foreach ( $slider_articles as $post ) {
                    setup_postdata( $post );
                    $slider_thumbnails[] = [
                        'image' => get_the_post_thumbnail_url( $post, THEME_SLUG . '_small' ),
                        'title' => get_the_title( $post->ID ),
                    ];
                    get_template_part( 'template-parts/post-card/slider' );
                }
                wp_reset_postdata();
                ?>

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>

        <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) { ?>
            <div class="slider-thumbnails swiper-container js-swiper-home-thumbnails">
                <div class="swiper-wrapper">
                    <?php
                    if ( ! empty( $slider_thumbnails ) ) {
                        foreach ( $slider_thumbnails as $slider_thumbnail ) {
                            echo '<div class="swiper-slide">';
                            echo '<div class="slider-thumbnails__slide" style="background-image: url(' . $slider_thumbnail['image'] . ');">';
                            echo '<span class="slider-thumbnails__title">' . $slider_thumbnail['title'] . '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php do_action( THEME_SLUG . '_slider_after' ) ?>

        <?php
    }

}
