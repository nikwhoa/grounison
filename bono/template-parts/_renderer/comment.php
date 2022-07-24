<?php

/**
 * @var       $commetn
 * @var array $args
 * @var       $depth
 * @var bool  $is_show_comments_date
 * @var bool  $is_show_comments_time
 */
?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
    <div class="comment-body" id="comment-<?php comment_ID(); ?>">
        <div class="comment-avatar">
            <?php echo get_avatar( $comment, 60 ); ?>
        </div>
        <div class="comment-meta">
            <?php
            if ( $comment->user_id ) {
                $userdata = get_userdata( $comment->user_id );
                echo '<cite class="comment-author" itemprop="creator">' . $userdata->display_name . '</cite>';
            } else {
                $comment_url = get_comment_author_url( $comment->user_id );
                if ( ! empty( $comment_url ) ) {
                    $microformat_comment_url = ' data-href="' . $comment_url . '"';
                } else {
                    $microformat_comment_url = '';
                }

                if ( ! empty( $comment_url ) ) {
                    echo '<cite class="comment-author pseudo-link js-link" itemprop="creator"' . $microformat_comment_url . ' data-target="_blank">' . get_comment_author( $comment->user_id ) . '</cite>';
                } else {
                    echo '<cite class="comment-author" itemprop="creator">' . get_comment_author( $comment->user_id ) . '</cite>';
                }
            }
            ?>

            <?php if ( $comment->user_id === $post->post_author ) {
                echo '<span class="comment-author-post">' . __( 'author', THEME_TEXTDOMAIN ) . '</span>';
            } ?>

            <?php if ( $is_show_comments_date ) { ?>
                <time class="comment-time" itemprop="datePublished" datetime="<?php comment_date( 'Y-m-d' ) ?>">
                    <?php comment_date( 'd.m.Y' ) ?>
                    <?php if ( apply_filters( THEME_SLUG . '_comments_show_time', $is_show_comments_time ) ) { ?>
                        <?php printf( __( 'at %s', THEME_TEXTDOMAIN ), get_comment_time( 'H:i' ) ) ?>
                    <?php } ?>
                </time>
            <?php } ?>
        </div>

        <div class="comment-content" itemprop="text">
            <?php comment_text() ?>
        </div><!-- .comment-content -->

        <div class="reply">
            <?php comment_reply_link( array_merge( $args, [
                'depth'     => $depth,
                'max_depth' => $args['max_depth'],
            ] ) ) ?>
        </div>
    </div>
