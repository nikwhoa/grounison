<?php
/**
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );
$core     = theme_container()->get( \Wpshop\Core\Core::class );

if ( '0' === $comment->comment_approved ): ?>

    <p class="meta">
        <em class="woocommerce-review__awaiting-approval">
            <?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
        </em>
    </p>

<?php else: ?>

    <p class="meta">
        <strong class="woocommerce-review__author"><?php comment_author(); ?> </strong>
        <?php
        if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
            echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'woocommerce' ) . ')</em> ';
        }

        ?>
        <?php if ( $core->get_option( 'comments_date' ) ): ?>
            <span class="woocommerce-review__dash">&ndash;</span>
            <time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>">
                <?php echo esc_html( get_comment_date( wc_date_format() ) ); ?>
                <?php if ( $core->get_option( 'comments_time' ) ): ?>
                    <?php comment_time( wc_time_format() ) ?>
                <?php endif ?>
            </time>
        <?php endif ?>
    </p>

<?php endif;
