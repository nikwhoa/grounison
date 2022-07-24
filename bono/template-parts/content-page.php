<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bono
 */

$wpshop_core     = theme_container()->get( \Wpshop\Core\Core::class );
$wpshop_template = theme_container()->get( \Wpshop\Core\Template::class );
$wpshop_rating   = theme_container()->get( \Wpshop\Core\StarRating::class );
$social          = theme_container()->get( \Wpshop\TheTheme\SocialHelper::class )->setup_default_hooks();

$thumbnail_type = get_post_meta( $post->ID, 'thumbnail_type', true );

$thumb = get_the_post_thumbnail( $post->ID, 'reboot_standard', [ 'itemprop' => 'image' ] );

$thumb_url = get_the_post_thumbnail_url( $post, 'full' );

$structure_page_hide = $social->get_structure_page_to_hide();

$is_show_breadcrumbs   = $wpshop_core->is_show_element( 'breadcrumbs' );
$is_show_title_h1      = $wpshop_core->is_show_element( 'title_h1' );
$is_show_social_bottom = $social->do_show_on_bottom();
$is_show_thumb         = ( ! in_array( 'thumbnail', $structure_page_hide ) && $wpshop_core->is_show_element( 'thumbnail' ) );
$is_show_rating        = ( ! in_array( 'rating', $structure_page_hide ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-post' ); ?>>

    <?php if ( $thumbnail_type != 'full' && $thumbnail_type != 'fullscreen' ) : ?>

        <div class="article-meta">
            <?php if ( $is_show_breadcrumbs ) {
                get_template_part( 'template-parts/blocks/breadcrumbs' );
            } ?>
        </div>

        <?php if ( $is_show_title_h1 ) { ?>
            <?php do_action( THEME_SLUG . '_page_before_title' ) ?>
            <h1 class="page-title" itemprop="headline"><?php the_title() ?></h1>
            <?php do_action( THEME_SLUG . '_page_after_title' ) ?>
        <?php } ?>

        <?php if ( $is_show_thumb && ! empty( $thumb ) ) : ?>
            <div class="entry-image post-card post-card__thumbnail">
                <?php echo $thumb; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="entry-content">
        <?php
        do_action( THEME_SLUG . '_page_before_the_content' );
        the_content();
        do_action( THEME_SLUG . '_page_after_the_content' );

        wp_link_pages( [
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', THEME_TEXTDOMAIN ),
            'after'  => '</div>',
        ] );
        ?>
    </div><!-- .entry-content -->

</article>

<?php if ( $is_show_rating ) { ?>
    <div class="rating-box">
        <div class="rating-box__header"><?php echo apply_filters( THEME_SLUG . '_page_rating_title', __( 'Rating', THEME_TEXTDOMAIN ) ) ?></div>
        <?php $post_id = $post ? $post->ID : 0;
        $wpshop_rating->the_rating( $post_id, apply_filters( THEME_SLUG . '_rating_text_show', false ) ); ?>
    </div>
<?php } ?>

<?php if ( $is_show_social_bottom ) { ?>
    <div class="entry-social">
        <?php if ( apply_filters( THEME_SLUG . '_page_social_share_title_show', false ) ) : ?>
            <div class="entry-bottom__header"><?php echo apply_filters( THEME_SLUG . '_social_share_title', __( 'Share to friends', THEME_TEXTDOMAIN ) ) ?></div>
        <?php endif; ?>
        <?php get_template_part( 'template-parts/blocks/social', 'buttons' ) ?>
    </div>
<?php } ?>



<?php if ( ! empty( $thumb ) && ( $thumbnail_type == 'full' || $thumbnail_type == 'fullscreen' ) ) { ?>
    <meta itemprop="image" content="<?php echo $thumb_url ?>">
    <meta itemprop="headline" content="<?php echo esc_attr( get_the_title() ) ?>">
<?php } ?>
<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' ) ?>">
<meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
<meta itemprop="author" content="<?php the_author() ?>">
<?php echo $wpshop_template->get_microdata_publisher() ?>
