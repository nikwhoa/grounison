<?php


namespace Wpshop\TheTheme\Customizer\Control;


class DocLink extends \WP_Customize_Control {

    /**
     * @var string
     */
    public $type = 'doc-link';


    /**
     * @var string|null
     */
    public $link;

    /**
     * DocLink constructor.
     *
     * @param \WP_Customize_Manager $manager
     * @param string                $id
     * @param array                 $args
     */
    public function __construct( $manager, $id, $args = [] ) {
        $args['type'] = $this->type;
        if ( empty( $args['tooltip_text'] ) ) {
            $args['tooltip_text'] = __( 'Get more info', THEME_TEXTDOMAIN );
        }
        parent::__construct( $manager, $id, $args );
    }

    /**
     * @inheritDoc
     */
    protected function render_content() {
        $description_id = '_customize-description-' . $this->id;

        $text = $this->description;

        if ( $this->link ) {
            $text = sprintf( '<a href="%s" target="_blank" rel="noopener" class="wpshop-customizer-doc-link">%s</a>', $this->link, $this->description );
        }
        ?>
        <span id="<?php echo esc_attr( $description_id ); ?>" class="wpshop-customizer-doc-link-wrap">
            <?php echo $text; ?>
        </span>
        <?php

    }
}
