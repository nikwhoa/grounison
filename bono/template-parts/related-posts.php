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

$wpshop_core       = theme_container()->get( \Wpshop\Core\Core::class );
$class_advertising = theme_container()->get( \Wpshop\Core\Advertising::class );

if ( is_page() ) {
    $related_count_mod = $wpshop_core->get_option( 'structure_page_related' );
} else {
    $related_count_mod = $wpshop_core->get_option( 'structure_single_related' );
}
$related_yarpp_enabled = apply_filters( THEME_SLUG . '_yarpp_enabled', false );


if ( ! empty( $related_count_mod ) && ! $related_yarpp_enabled ) {

    $related_articles = [];

    $related_count = 4;
    if ( is_numeric( $related_count_mod ) && $related_count_mod > - 1 ) {
        if ( $related_count_mod > 50 ) {
            $related_count_mod = 50;
        }
        $related_count = $related_count_mod;
    }

    $related_posts_ids = get_post_meta( $post->ID, 'related_posts_ids', true );

    // если указаны посты - набираем их
    if ( ! empty( $related_posts_ids ) ) {

        $related_posts_id_exp = explode( ',', $related_posts_ids );

        if ( is_array( $related_posts_id_exp ) ) {
            $related_posts_ids = array_map( 'trim', $related_posts_id_exp );
        } else {
            $related_posts_ids = [ $related_posts_ids ];
        }

        $related_articles = get_posts( [
            'posts_per_page' => $related_count,
            'post__not_in'   => [ $post->ID ],
            'post__in'       => $related_posts_ids,
        ] );

    }


    // если не хватило, добираем из категории
    if ( count( $related_articles ) < $related_count ) {

        // сколько осталось постов
        $delta = $related_count - count( $related_articles );

        // убираем текущий пост + уже выведенные
        $post__not_in = [ $post->ID ];
        foreach ( $related_articles as $article ) {
            $post__not_in[] = $article->ID;
        }

        // подготавливаем категории
        global $post;
        $category_ids = [];
        $categories   = get_the_category( $post->ID );
        if ( $categories ) {
            foreach ( $categories as $_category ) {
                $category_ids[] = $_category->term_id;
            }
        }

        $related_articles_category = get_posts( [
            'category__in'   => $category_ids,
            'posts_per_page' => $delta,
            'post__not_in'   => $post__not_in,
        ] );

        if ( ! empty( $related_articles_category ) ) {
            $related_articles = array_merge( $related_articles, $related_articles_category );
        }


        // если не хватило, добираем рандом
        if ( count( $related_articles ) < $related_count ) {

            // сколько осталось постов
            $delta = $related_count - count( $related_articles );

            // убираем текущий пост + уже выведенные
            $post__not_in = [ $post->ID ];
            foreach ( $related_articles as $article ) {
                $post__not_in[] = $article->ID;
            }

            $related_articles_second = get_posts( [
                'posts_per_page' => $delta,
                'orderby'        => 'rand',
                'post__not_in'   => $post__not_in,
            ] );

            // если все ок, объединяем
            if ( ! empty( $related_articles_second ) ) {
                $related_articles = array_merge( $related_articles, $related_articles_second );
            }
        }
    }

    if ( ! empty( $related_articles ) ) {

        ?>

        <div class="related-posts fixed">

            <?php echo $class_advertising->show_ad( 'before_related' ); ?>

            <div class="related-posts__header"><?php echo apply_filters( THEME_SLUG . '_related_title', __( 'You may also like', THEME_TEXTDOMAIN ) ) ?></div>

            <div class="post-cards post-cards--related">

                <?php
                foreach ( $related_articles as $post ) {
                    setup_postdata( $post );
                    get_template_part( 'template-parts/post-card/related' );
                }
                wp_reset_postdata();
                ?>

            </div>

            <?php echo $class_advertising->show_ad( 'after_related' ); ?>

        </div>

        <?php
    }

} else {

    /**
     * If yarpp enabled
     */
    if ( function_exists( 'related_posts' ) && $related_yarpp_enabled ) {
        related_posts();
    }

}
