<?php

$inputs = apply_filters( 'bono_one_click_buy:filters', [
    [
        'name'  => 'name',
        'label' => __( 'Name', THEME_TEXTDOMAIN ),
        'type'  => 'text',
    ],
    [
        'name'  => 'email',
        'label' => __( 'Email', THEME_TEXTDOMAIN ),
        'type'  => 'email',
    ],
    [
        'name'  => 'phone',
        'label' => __( 'Phone', THEME_TEXTDOMAIN ),
        'type'  => 'tel',
    ],
    [
        'name'            => 'consent',
        'label'           => __( 'Consent to the processing of personal data', THEME_TEXTDOMAIN ),
        'type'            => 'checkbox',
        'value'           => '1',
        'render_callback' => function ( $input ) {
            ?>
            <div class="one-click-buy__form-row">
                <label>
                    <input type="<?php echo esc_attr( $input['type'] ) ?>"
                           name="<?php echo esc_attr( $input['name'] ) ?>"
                           value="<?php echo ! empty( $input['value'] ) ? esc_attr( $input['value'] ) : '' ?>"
                           class="<?php echo ! empty( $input['class'] ) ? esc_attr( $input['class'] ) : 'input-text' ?>">
                    <?php echo esc_html( $input['label'] ) ?>
                </label>
            </div>
            <?php
        },
    ],
] );
?>
<template id="bono_one_click_buy_form">
    <div class="one-click-buy one-click-buy__holder js-one-click-buy-holder">
        <div class="one-click-buy__container">
            <div class="one-click-buy__close js-one-click-buy-close"></div>
            <div class="js-one-click-buy-container">
                <div class="js-messages"></div>
                <form action="" method="post">
                    <?php do_action( 'bono_one_click_buy:before_inputs' ); ?>
                    <?php foreach ( $inputs as $input ): ?>
                        <?php if ( ! empty( $input['render_callback'] ) ): ?>
                            <?php call_user_func( $input['render_callback'], $input ) ?>
                        <?php else: ?>
                            <div class="one-click-buy__form-row">
                                <label><?php echo esc_html( $input['label'] ) ?></label>
                                <input type="<?php echo esc_attr( $input['type'] ) ?>"
                                       name="<?php echo esc_attr( $input['name'] ) ?>"
                                       value="<?php echo ! empty( $input['value'] ) ? esc_attr( $input['value'] ) : '' ?>"
                                       class="<?php echo ! empty( $input['class'] ) ? esc_attr( $input['class'] ) : 'input-text' ?>">

                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                    <?php do_action( 'bono_one_click_buy:after_inputs' ); ?>
                    <button type="submit" class="button js-one-click-buy-submit"><?php echo __( 'Submit', THEME_TEXTDOMAIN ) ?></button>
                    <span class="button btn-outline js-one-click-buy-close"><?php echo __( 'Cancel', THEME_TEXTDOMAIN ) ?></span>
                </form>
            </div>
        </div>
    </div>
</template>
