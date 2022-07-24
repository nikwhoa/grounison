<?php
/**
 * The template for displaying archive pages
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bono
 */

$wpshop_core = theme_container()->get( \Wpshop\Core\Core::class );

$is_show_breadcrumbs   = $wpshop_core->get_option( 'breadcrumbs_archive' );
$is_show_subcategories = $wpshop_core->get_option( 'structure_archive_subcategories' );
$is_show_sidebar       = in_array( $wpshop_core->get_option( 'structure_archive_sidebar' ), [ 'left', 'right' ] );

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if ( $is_show_breadcrumbs ) {
                get_template_part( 'template-parts/blocks/breadcrumbs' );
            } ?>

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <?php do_action( THEME_SLUG . '_archive_before_title' ); ?>
                    <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                    <?php do_action( THEME_SLUG . '_archive_after_title' ); ?>

                    <?php if ( is_category() && $is_show_subcategories ) {
                        $cat = get_query_var( 'cat' );

                        $categories = get_categories( [
                            'parent' => $cat,
                        ] );

                        if ( ! empty( $categories ) ) {
                            echo '<div class="child-categories"><ul>';
                            foreach ( $categories as $category ) {
                                echo '<li>';
                                echo '<a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a>';
                                echo '</li>';
                            }
                            echo '</ul></div>';
                        }
                    } ?>

                    <?php if ( 'top' == $wpshop_core->get_option( 'structure_archive_description' ) && ! is_paged() ) {
                        the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    } ?>
                </header><!-- .page-header -->

                <?php

                /*
                    * Include the Post-Type-specific template for the content.
                    * If you want to override this in a child theme, then include a file
                    * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                    */
                do_action( THEME_SLUG . '_archive_before_posts' );
                get_template_part( 'template-parts/post-container/' . $wpshop_core->get_option( 'structure_archive_posts' ) );
                do_action( THEME_SLUG . '_archive_after_posts' );

                the_posts_pagination();
                ?>

                <?php if ( 'bottom' == $wpshop_core->get_option( 'structure_archive_description' ) && ! is_paged() ) {
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                } ?>

            <?php else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php if ( $is_show_sidebar ) {
    get_sidebar();
} ?>

<?php
get_footer();
