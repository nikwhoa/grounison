<?php
/**
 * The template for displaying search results pages
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package bono
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', THEME_TEXTDOMAIN ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                </header><!-- .page-header -->

                <div class="post-cards post-cards--horizontal">

                    <?php while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'search' );
                    endwhile; ?>

                    <?php the_posts_pagination(); ?>

                </div>

            <?php else :

                get_template_part( 'template-parts/content', 'none' );

            endif; ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>

<?php do_action( THEME_SLUG . '_single_before_related' ); ?>
<?php get_template_part( 'template-parts/related', 'posts' ); ?>
<?php do_action( THEME_SLUG . '_single_after_related' ); ?>

<?php
get_footer();
