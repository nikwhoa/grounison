<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Core;

class CommentCallback {

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var TemplateRenderer
     */
    protected $renderer;

    /**
     * CommentCallback constructor.
     *
     * @param Core             $core
     * @param TemplateRenderer $renderer
     */
    public function __construct( Core $core, TemplateRenderer $renderer ) {
        $this->core     = $core;
        $this->renderer = $renderer;
    }


    /**
     * @param $comment
     * @param $args
     * @param $depth
     *
     * @throws \Exception
     */
    public function __invoke( $comment, $args, $depth ) {
        global $post;

        $GLOBALS['comment'] = $comment;

        echo $this->renderer->render( 'template-parts/_renderer/comment.php', [
            'post'                  => $post,
            'is_show_comments_date' => $this->core->get_option( 'comments_date' ),
            'is_show_comments_time' => $this->core->get_option( 'comments_time' ),
            'comment'               => $comment,
            'args'                  => $args,
            'depth'                 => $depth,
        ], true );
    }
}
