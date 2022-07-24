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

$post_card_type       = 'standard';
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
$post_card_attributes = [ 'itemscope', 'itemtype="http://schema.org/BlogPosting"' ];
$post_card_classes    = [ 'post-card--' . $post_card_type ];
$description_length   = (int) $wpshop_core->get_option( 'post_card_' . $post_card_type . '_excerpt_length' );


/**
 * prepare data
 */
$thumb = get_the_post_thumbnail( $post->ID, $post_card_thumb_size, [ 'itemprop' => 'image' ] );
if ( empty( $thumb ) ) {
    $post_card_classes[] = 'post-card--thumbnail-no';
}
?>
<div class="post-card <?php echo implode( ' ', $post_card_classes ) ?>" <?php echo implode( ' ', $post_card_attributes ) ?>>

    <?php
    $thumb_in_order = true;
    if ( count( $post_card_order ) &&
         $post_card_order[0] === 'thumbnail' &&
         ! empty( $thumb ) &&
         $post_card->doShowElement( 'thumbnail' )
    ) {
        $thumb_in_order = false;
        echo '<div class="post-card__thumbnail">';
        echo '<a href="' . get_the_permalink() . '">';
        echo $thumb;

        echo '</a>';
        echo '</div>';
    }
    ?>


    <div class="post-card__body">

        <?php
        foreach ( $post_card_order as $order ) {

            if ( $thumb_in_order && $order === 'thumbnail' && ! empty( $thumb ) && $post_card->doShowElement( 'thumbnail' ) ) {
                echo '<div class="post-card__thumbnail">';
                echo '<a href="' . get_the_permalink() . '">';
                echo $thumb;
                echo '</a>';
                echo '</div>';
            }


//            if ( $order == 'category' && $post_card->doShowElement( 'category' ) ) {
//                if ( empty( $thumb ) || ! $post_card->doShowElement( 'thumbnail' ) ) {
//                    echo '<span class="post-card__category" itemprop="articleSection">';
//                    echo $wpshop_template->get_category( [ 'link' => false ] );
//                    echo '</span>';
//                }
//            }

            if ( $order == 'title' ) {
                echo '<div class="post-card__title" itemprop="name">';
                echo '<span itemprop="headline">';
                echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
                echo '</span>';
                echo '</div>';
            }

            if ( $order == 'meta' ) {
                if (
                    $post_card->doShowElement( 'comments_number' ) ||
                    $post_card->doShowElement( 'views' ) ||
                    $post_card->doShowElement( 'date' ) ||
                    //$post_card->is_show_element( 'likes' ) ||
                    $post_card->doShowElement( 'author' )
                ) {
                    echo '<div class="post-card__meta">';

                    foreach ( $post_card_order_meta as $meta_order ) {

                        if ( $meta_order == 'date' && $post_card->doShowElement( 'date' ) ) {
                            echo '<span class="post-card__date">';
                            echo '<time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">';
                            echo get_the_date();
                            echo '</time>';
                            echo '</span>';
                        }

                        if ( $meta_order == 'comments_number' && $post_card->doShowElement( 'comments_number' ) ) {
                            echo '<span class="post-card__comments">' . get_comments_number() . '</span>';
                        }

                        if ( $meta_order == 'views' && $post_card->doShowElement( 'views' ) ) {
                            echo '<span class="post-card__views">';
                            echo $wpshop_helper->rounded_number( $wpshop_template->get_views() );
                            echo '</span>';
                        }

                        /*if ( $meta_order == 'likes' && $post_card->is_show_element( 'likes' ) ) {
                            echo '<span class="post-card__like">';
                            echo $wpshop_helper->rounded_number( $wpshop_template->get_likes() );
                            echo '</span>';
                        }*/

                        if ( $meta_order == 'author' && $post_card->doShowElement( 'author' ) ) {
                            echo '<span class="post-card__author" itemprop="author">';
                            echo get_the_author();
                            echo '</span>';
                        }

                        if ( $meta_order == 'category' && $post_card->doShowElement( 'category' ) ) {
	                        echo '<span class="post-card__category" itemprop="articleSection">';
	                        echo $wpshop_template->get_category( [ 'link' => false ] );
                            echo '</span>';
                        }

                    }

                    echo '</div>';
                }
            }

            if ( $order == 'excerpt' && $post_card->doShowElement( 'excerpt' ) ) {
                echo '<div class="post-card__description">';
                echo $wpshop_helper->substring_by_word( get_the_excerpt(), $description_length );
                echo '</div>';
            }

        }
        ?>

        <?php if ( ! empty( $is_show_excerpt ) ) : ?>
            <div class="post-card__description">
                <?php echo $wpshop_helper->substring_by_word( get_the_excerpt(), $description_length ) ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( ! $post_card->doShowElement( 'excerpt' ) ) { ?>
        <meta itemprop="articleBody" content="<?php echo get_the_excerpt() ?>">
    <?php } ?>
    <?php if ( ! $post_card->doShowElement( 'author' ) ) { ?>
        <meta itemprop="author" content="<?php the_author() ?>"/>
    <?php } ?>
    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
    <meta itemprop="dateModified" content="<?php the_modified_time( 'Y-m-d' ) ?>">
    <?php if ( ! $post_card->doShowElement( 'date' ) ) { ?>
        <meta itemprop="datePublished" content="<?php the_time( 'c' ) ?>">
    <?php } ?>
    <?php echo $wpshop_template->get_microdata_publisher() ?>
</div>
