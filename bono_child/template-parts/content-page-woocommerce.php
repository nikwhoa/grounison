<?php
/**
 * WooCommerce Page Template for Cart, Checkout, My Account
 *
 * @package bono
 */

$wpshop_core     = theme_container()->get( \Wpshop\Core\Core::class );
$wpshop_template = theme_container()->get( \Wpshop\Core\Template::class );
$wpshop_rating   = theme_container()->get( \Wpshop\Core\StarRating::class );
$social          = theme_container()->get( \Wpshop\TheTheme\SocialHelper::class )->setup_default_hooks();

$is_show_breadcrumbs = $wpshop_core->is_show_element( 'breadcrumbs' );
$is_show_title_h1    = $wpshop_core->is_show_element( 'title_h1' );

$class_content = 'entry-content';
if ( is_wc_enabled() && is_cart() ) {
    $class_content = 'cart-content';
}
if ( is_wc_enabled() && is_checkout() ) {
    $class_content = 'checkout-content';
}
if ( is_wc_enabled() && is_account_page() ) {
    $class_content = 'account-content';
}

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'woocommerce-page' ); ?>>

    <?php if ( $is_show_breadcrumbs ) {
        get_template_part( 'template-parts/blocks/breadcrumbs' );
    } ?>

    <?php if ( $is_show_title_h1 ) { ?>
        <?php do_action( THEME_SLUG . '_page_before_title' ) ?>
        <h1 class="page-title"><?php the_title() ?></h1>
        <?php do_action( THEME_SLUG . '_page_after_title' ) ?>
    <?php } ?>

    <div class="<?php echo $class_content ?>">
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

</div>


<?php $thumb_url = get_the_post_thumbnail_url( $post, 'full' ); ?>
<meta itemprop="image" content="<?php echo $thumb_url ?>">
<meta itemprop="headline" content="<?php echo esc_attr( get_the_title() ) ?>">
<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
<meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' ) ?>">
<meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
<meta itemprop="author" content="<?php the_author() ?>">
<?php echo $wpshop_template->get_microdata_publisher() ?>
