<?php

namespace Wpshop\TheTheme\Customizer\Control;

use WP_Customize_Control;

class TextArea extends WP_Customize_Control {

    /**
     * @var string
     */
    public $type = 'textarea';

    /**
     * @var string
     */
    public $tooltip_text;

    /**
     * @var string|null
     */
    public $tooltip_link;

    /**
     * TextArea constructor.
     *
     * @inheritDoc
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
        $input_id         = '_customize-input-' . $this->id;
        $description_id   = '_customize-description-' . $this->id;
        $describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
        ?>
        <?php if ( ! empty( $this->label ) ) : ?>
            <label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
	            <?php if ( $this->tooltip_link ): ?>
                    <a href="<?php echo $this->tooltip_link ?>" target="_blank" rel="noopener" class="wpshop-customizer-tooltip-button"><span class="dashicons dashicons-info" title="<?php echo $this->tooltip_text ?>"></span></a>
	            <?php endif ?>
            </label>
        <?php endif; ?>
        <?php if ( ! empty( $this->description ) ) : ?>
            <span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo $this->description; ?></span>
        <?php endif; ?>
        <textarea
                id="<?php echo esc_attr( $input_id ); ?>"
                rows="5"
					<?php echo $describedby_attr; ?>
            <?php $this->input_attrs(); ?>
            <?php $this->link(); ?>
				><?php echo esc_textarea( $this->value() ); ?></textarea>
        <?php
    }
}
