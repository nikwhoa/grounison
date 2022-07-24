<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://docs.wpshop.ru/child-themes/
 *
 * *****************************************************************************
 *
 * @package bono
 */

$wpshop_core = theme_container()->get( \Wpshop\Core\Core::class );

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', THEME_TEXTDOMAIN ); ?></p>
    <?php
    endif;


    $commenter = wp_get_current_commenter();
    $req       = get_option( 'require_name_email' );
    $html_req  = ( $req ? " required='required'" : '' );
    $html5     = true;

    $comment_form_args = [
        'comment_notes_before' => '',
        'title_reply_before'   => '<div id="reply-title" class="comment-reply-title">',
        'title_reply_after'    => '</div>',

        'comment_field' => '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="' . _x( 'Comment', 'noun' ) . '" ></textarea></p>',
        'fields'        => [
            'author' => '<p class="comment-form-author">' . '<label class="screen-reader-text" for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" ' . $html_req . ' placeholder="' . __( 'Name' ) . '" /></p>',
            'email'  => '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                        '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" ' . $html_req . ' placeholder="' . __( 'Email' ) . '" /></p>',
            'url'    => '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . __( 'Website' ) . '</label> ' .
                        '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" placeholder="' . __( 'Website' ) . '" /></p>',
        ],
    ];

    $title_comments = get_post_meta( $post->ID, 'comments_title', true );

    if ( ! empty( $title_comments ) ) {
        $comment_form_args['title_reply'] = $title_comments;
    }

    // текст перед кнопкой Отправить
    $comments_text_before_submit = $wpshop_core->get_option( 'comments_text_before_submit' );
    if ( ! empty( $comments_text_before_submit ) ) {
        $comment_form_args['comment_notes_after'] = '<div class="comment-notes-after">' . $comments_text_before_submit . '</div>';
    }

    $comment_form_args = apply_filters( THEME_SLUG . '_comment_form_args', $comment_form_args );
    comment_form( $comment_form_args );

    ?>


    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) : ?>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-above" class="navigation comment-navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', THEME_TEXTDOMAIN ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', THEME_TEXTDOMAIN ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', THEME_TEXTDOMAIN ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-above -->
        <?php endif; // Check for comment navigation. ?>

        <ol class="comment-list">
            <?php
            wp_list_comments( [
                'type'     => 'comment',
                'style'    => 'ol',
                'callback' => theme_container()->get( \Wpshop\TheTheme\CommentCallback::class ),
            ] );
            ?>
        </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-below" class="navigation comment-navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', THEME_TEXTDOMAIN ); ?></h2>
                <div class="nav-links">

                    <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', THEME_TEXTDOMAIN ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', THEME_TEXTDOMAIN ) ); ?></div>

                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
        <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().

    ?>

</div><!-- #comments -->
