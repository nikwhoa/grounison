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

$is_show_rating = $wpshop_core->is_show_element( 'rating' );
$wpshop_rating  = theme_container()->get( \Wpshop\Core\StarRating::class );
?>

<!--noindex-->
<div class="author-box">
    <div class="author-info">
        <div class="author-box__ava">
            <?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ); ?>
        </div>

        <div class="author-box__body">
            <div class="author-box__author">
                <?php echo get_the_author() ?>
            </div>
            <div class="author-box__description">
                <!--noindex--><?php the_author_meta( 'description' ) ?><!--/noindex-->
            </div>
        </div>
    </div>

    <?php if ( $is_show_rating ) { ?>
        <div class="author-box__rating">
            <div class="author-box__rating-title"><?php echo apply_filters( THEME_SLUG . '_rating_title', __( 'Rate author', THEME_TEXTDOMAIN ) ) ?></div>
            <?php $post_id = $post ? $post->ID : 0;
            $wpshop_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', false ) ); ?>
        </div>
    <?php } ?>
</div>
<!--/noindex-->
