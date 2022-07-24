<?php
/**
 * Template part for displaying results in search pages
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bono
 */

global $post;
$wpshop_template = theme_container()->get( \Wpshop\Core\Template::class );
$wpshop_helper   = theme_container()->get( \Wpshop\Core\Helper::class );

$thumb = get_the_post_thumbnail( $post->ID, 'reboot_small', [ 'itemprop' => 'image' ] );
if ( empty( $thumb ) ) {
    $post_card_classes[] = 'post-card--thumbnail-no';
}
?>

<article id="post-<?php the_ID(); ?>" class="post-card post-card--horizontal">

    <?php if ( 'post' === get_post_type() ) : ?>

        <?php if ( ! empty( $thumb ) ) : ?>
            <div class="post-card__thumbnail">
                <a href="<?php the_permalink() ?>">
                    <?php echo $thumb ?>
                    <?php echo $wpshop_template->get_category( [
                        'classes' => 'post-card__category',
                        'micro'   => false,
                        'link'    => false,
                    ] ) ?>
                </a>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="post-card__body">

        <?php
        if ( 'post' === get_post_type() && empty( $thumb ) ) :
            echo $wpshop_template->get_category( [
                'classes' => 'post-card__category',
                'micro'   => false,
                'link'    => false,
            ] );
        endif;

        echo '<div class="post-card__title">';
        echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
        echo '</div>';

        echo '<div class="post-card__description">';
        echo $wpshop_helper->substring_by_word( get_the_excerpt(), '200' );
        echo '</div>';

        if ( 'post' === get_post_type() ) {

            echo '<div class="post-card__meta">';

            echo '<span class="post-card__date">';
            echo get_the_date();
            echo '</span>';

            echo '<span class="post-card__comments">' . get_comments_number() . '</span>';

            echo '<span class="post-card__views">';
            echo $wpshop_helper->rounded_number( $wpshop_template->get_views() );
            echo '</span>';

            echo '<span class="post-card__like">';
            echo $wpshop_helper->rounded_number( $wpshop_template->get_likes() );
            echo '</span>';

            echo '<span class="post-card__author" itemprop="author">';
            echo get_the_author();
            echo '</span>';

        }
        ?>

    </div>

</article><!-- #post-<?php the_ID(); ?> -->
