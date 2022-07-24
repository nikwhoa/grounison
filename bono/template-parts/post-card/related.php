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

$wpshop_core     = theme_container()->get( \Wpshop\Core\Core::class );
$wpshop_helper   = theme_container()->get( \Wpshop\Core\Helper::class );
$wpshop_template = theme_container()->get( \Wpshop\Core\Template::class );
$post_card       = theme_container()->get( \Wpshop\TheTheme\PostCard::class );

$post_card_type       = 'related';
$post_card_thumb_size = THEME_SLUG . '_card';
$section_options      = ( isset( $section_options ) ) ? $section_options : [];


/**
 * order
 */
$post_card_order = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order' );
$post_card_order = explode( ',', $post_card_order );

$post_card_order_meta = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order_meta' );
$post_card_order_meta = explode( ',', $post_card_order_meta );


/**
 * post card class
 */
$post_card->setOrders( array_merge( $post_card_order, $post_card_order_meta ) );
$post_card->setSectionOptions( $section_options );


/**
 * default
 */
$post_card_classes  = [ 'post-card--' . $post_card_type ];
$description_length = (int) $wpshop_core->get_option( 'post_card_' . $post_card_type . '_excerpt_length' );


/**
 * prepare data
 */
$thumb = get_the_post_thumbnail_url( $post->ID, $post_card_thumb_size );
if ( empty( $thumb ) ) {
    $post_card_classes[] = 'post-card--thumbnail-no';
}
if ( ! $post_card->doShowElement( 'thumbnail' ) ) {
    $post_card_classes[] = 'post-card--thumbnail-no';
}

?>

<div class="post-card <?php echo implode( ' ', $post_card_classes ) ?>">
    <?php if ( ! empty( $thumb ) && $post_card->doShowElement( 'thumbnail' ) ) : ?>
        <div class="post-card__thumbnail">
            <div class="post-card__thumbnail-image" style="background-image: url(<?php echo esc_attr( $thumb ) ?>)"></div>
        </div>
    <?php endif; ?>

    <div class="post-card__body">

        <?php
        foreach ( $post_card_order as $order ) {

            if ( $order == 'title' && $post_card->doShowElement( 'title' ) ) {
                echo '<div class="post-card__title">';
                echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                echo '</div>';
            }

            if ( $order == 'excerpt' && $post_card->doShowElement( 'excerpt' ) ) {
                echo '<div class="post-card__description">';
                echo $wpshop_helper->substring_by_word( get_the_excerpt(), $description_length );
                echo '</div>';
            }

            if ( $order == 'meta' && $post_card->doShowElement( 'meta' ) ) {
                if ( $post_card->doShowElement( 'comments_number' ) || $post_card->doShowElement( 'views' ) ) {
                    echo '<div class="post-card__meta">';

                    foreach ( $post_card_order_meta as $meta_order ) {

                        // echo '<span class="post-card__date">';
                        // echo get_the_date();
                        // echo '</span>';

                        if ( $meta_order == 'comments_number' && $post_card->doShowElement( 'comments_number' ) ) {
                            echo '<span class="post-card__comments">' . get_comments_number() . '</span>';
                        }

                        if ( $meta_order == 'views' && $post_card->doShowElement( 'views' ) ) {
                            echo '<span class="post-card__views">';
                            echo $wpshop_helper->rounded_number( $wpshop_template->get_views() );
                            echo '</span>';
                        }

                        // echo '<span class="post-card__author">';
                        // echo get_the_author();
                        // echo '</span>';

                    }

                    echo '</div>';
                }
            }

        }
        ?>

    </div>

</div>
