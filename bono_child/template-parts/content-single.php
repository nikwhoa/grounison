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

use Wpshop\TheTheme\TemplateHelper;

$wpshop_core     = theme_container()->get( \Wpshop\Core\Core::class );
$wpshop_template = theme_container()->get( \Wpshop\Core\Template::class );
$wpshop_helper   = theme_container()->get( \Wpshop\Core\Helper::class );
$wpshop_rating   = theme_container()->get( \Wpshop\Core\StarRating::class );
$thumbnail_type  = get_post_meta( $post->ID, 'thumbnail_type', true );

$thumb = get_the_post_thumbnail( $post->ID, 'post-thumbnail', [ 'itemprop' => 'image' ] );

$thumb_url = get_the_post_thumbnail_url( $post, 'full' );

$structure_single_hide = $wpshop_core->get_option( 'structure_single_hide' );
if ( ! empty( $structure_single_hide ) ) {
    $structure_single_hide = explode( ',', $structure_single_hide );
    if ( is_array( $structure_single_hide ) ) {
        $structure_single_hide = array_map( 'trim', $structure_single_hide );
    }
} else {
    $structure_single_hide = [];
}

$is_show_breadcrumbs   = $wpshop_core->is_show_element( 'breadcrumbs' );
$is_show_title_h1      = $wpshop_core->is_show_element( 'title_h1' );
$is_show_thumb         = ( ! in_array( 'thumbnail', $structure_single_hide ) && $wpshop_core->is_show_element( 'thumbnail' ) );
$is_show_category      = ! in_array( 'category', $structure_single_hide ) && $wpshop_core->is_show_element( 'category' );
$is_show_meta          = $wpshop_core->is_show_element( 'meta' );
$is_show_author        = ( ! in_array( 'author', $structure_single_hide ) );
$is_show_views         = ( ! in_array( 'views', $structure_single_hide ) );
$is_show_date          = ( ! in_array( 'date', $structure_single_hide ) );
$is_show_excerpt       = ( ! in_array( 'excerpt', $structure_single_hide ) );
$is_show_social_bottom = ( ! in_array( 'social_bottom', $structure_single_hide ) && $wpshop_core->is_show_element( 'social_bottom' ) );
$is_show_rating        = ! in_array( 'rating', $structure_single_hide ) && $wpshop_core->is_show_element( 'rating' );
$is_show_tags          = ( ! in_array( 'tags', $structure_single_hide ) );
$is_show_author_box    = ( ! in_array( 'author_box', $structure_single_hide ) && $wpshop_core->is_show_element( 'author_box' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-post' ); ?>>

    <?php if ( $thumbnail_type != 'full' && $thumbnail_type != 'fullscreen' ) : ?>

        <div class="article-meta">
            <?php if ( $is_show_breadcrumbs ) {
                get_template_part( 'template-parts/blocks/breadcrumbs' );
            } ?>

            <?php if ( $is_show_category && is_singular( 'post' ) ) { ?>
                <span class="entry-category"><?php echo $wpshop_template->get_category() ?></span>
            <?php } ?>

            <?php if ( $is_show_meta ) { ?>
                <?php if ( $is_show_author ) {
                    echo '<span class="entry-author" itemprop="author">' . get_the_author() . '</span>';
                } ?>
                <?php if ( $is_show_views && $wpshop_template->get_views() > 0 ) {
                    echo '<span class="entry-views js-views-count" data-post_id="' . $post->ID . '">' . $wpshop_helper->rounded_number( $wpshop_template->get_views() ) . '</span>';
                } ?>
                <?php if ( $is_show_date ) {
                    echo '<span class="entry-date"><time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_date() . '</time></span>';
                } ?>
            <?php } ?>
        </div>

        <?php if ( $is_show_title_h1 ) { ?>
            <?php do_action( THEME_SLUG . '_single_before_title' ) ?>
            <h1 class="entry-title" itemprop="headline"><?php the_title() ?></h1>
            <?php do_action( THEME_SLUG . '_single_after_title' ) ?>
        <?php } ?>

        <?php if ( $is_show_thumb && ! empty( $thumb ) ) : ?>
            <div class="entry-image">
                <?php echo $thumb; ?>
            </div>

        <?php endif; ?>

    <?php else: ?>
        <div class="article-meta">

            <?php if ( $is_show_category && is_singular( 'post' ) ) { ?>
                <span class="entry-category"><?php echo $wpshop_template->get_category() ?></span>
            <?php } ?>

            <?php if ( $is_show_meta ) { ?>
                <?php if ( $is_show_author ) {
                    echo '<span class="entry-author" itemprop="author">' . get_the_author() . '</span>';
                } ?>
                <?php if ( $is_show_views && $wpshop_template->get_views() > 0 ) {
                    echo '<span class="entry-views js-views-count" data-post_id="' . $post->ID . '">' . $wpshop_helper->rounded_number( $wpshop_template->get_views() ) . '</span>';
                } ?>
                <?php if ( $is_show_date ) {
                    echo '<span class="entry-date"><time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">' . get_the_date() . '</time></span>';
                } ?>
            <?php } ?>
        </div>
    <?php endif; ?>

    <?php
    $excerpt = get_the_excerpt();
    if ( has_excerpt() && $is_show_excerpt ) {
        do_action( THEME_SLUG . '_single_before_excerpt' );
        echo '<div class="entry-excerpt">' . $excerpt . '</div>';
        do_action( THEME_SLUG . '_single_after_excerpt' );
    }
    ?>

    <div class="entry-content" itemprop="articleBody">
        <?php
        do_action( THEME_SLUG . '_single_before_the_content' );
        the_content();
        do_action( THEME_SLUG . '_single_after_the_content' );

        wp_link_pages( [
            'before'      => '<div class="page-links">' . esc_html__( 'Pages:', THEME_TEXTDOMAIN ),
            'after'       => '</div>',
            'link_before' => '<span class="page-links__item">',
            'link_after'  => '</span>',
        ] );
        ?>
    </div><!-- .entry-content -->

</article>

<?php $wpshop_core->the_option( 'code_after_content' ) ?>

<?php
$source_link = get_post_meta( $post->ID, 'source_link', true );
$source_hide = get_post_meta( $post->ID, 'source_hide', true );

if ( ! empty( $source_link ) ) {
    echo '<div class="meta-source">';

    if ( $source_hide == 'checked' ) {
        echo '<span class="ps-link js-link" data-href="' . $source_link . '" data-target="_blank" rel="noopener">' . __( 'Source', THEME_TEXTDOMAIN ) . '</span>';
    } else {
        echo '<a href="' . $source_link . '" target="_blank">' . __( 'Source', THEME_TEXTDOMAIN ) . '</a>';
    }

    echo '</div>';
}
?>


<?php if ( $is_show_tags ) {
    $post_tags = get_the_tags();
    if ( $post_tags ) {
        echo '<div class="entry-tags">';
        foreach ( $post_tags as $tag ) {
            echo '<a href="' . get_tag_link( $tag->term_id ) . '" class="entry-tag">' . $tag->name . '</a> ';
        }
        echo '</div>';
    }
} ?>


<?php if ( $is_show_rating && ! $is_show_author_box ) { ?>
    <div class="rating-box">
        <div class="rating-box__header"><?php echo apply_filters( THEME_SLUG . '_single_rating_title', __( 'Rate article', THEME_TEXTDOMAIN ) ) ?></div>
        <?php $post_id = $post ? $post->ID : 0;
        $wpshop_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', false ) ); ?>
    </div>
<?php } ?>


<?php if ( $is_show_social_bottom ) { ?>
    <div class="entry-social">
        <?php if ( apply_filters( THEME_SLUG . '_single_social_share_title_show', false ) ) : ?>
            <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_social_share_title', __( 'Share to friends', THEME_TEXTDOMAIN ) ) ?></div>
        <?php endif; ?>

        <?php get_template_part( 'template-parts/blocks/social', 'buttons' ) ?>
    </div>
<?php } ?>



<?php if ( $is_show_author_box ) {
    get_template_part( 'template-parts/blocks/author', 'box' );
} ?>


<?php if ( ! empty( $thumb ) && ( $thumbnail_type == 'full' || $thumbnail_type == 'fullscreen' ) ) { ?>
    <meta itemprop="image" content="<?php echo $thumb_url ?>">
    <meta itemprop="headline" content="<?php echo esc_attr( get_the_title() ) ?>">
    <meta itemprop="articleSection" content="<?php get_the_category() ?>">
<?php } ?>
<?php if ( ! $is_show_author ) { ?>
    <meta itemprop="author" content="<?php echo get_the_author() ?>">
<?php } ?>
<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' ) ?>">
<?php if ( ! $is_show_date ) { ?>
    <meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
<?php } ?>
<?php echo $wpshop_template->get_microdata_publisher() ?>
