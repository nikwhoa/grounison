<?php

defined( 'WPINC' ) || die;

/**
 * @var string $button_label
 */
global $product;

$attributes = apply_filters( 'bono_one_click_buy:button_attributes', [
    'class'           => 'button bono_buy_one_click js-buy-one-click',
    'data-product_id' => $product->get_id(),
] );
$result     = [];
foreach ( $attributes as $k => $v ) {
    $result[] = "$k=\"$v\"";
}
$attributes = implode( ' ', $result );
?>
<button <?php echo $attributes ?>>
    <?php echo esc_html( apply_filters( 'bono_one_click_buy:button_label', $button_label ) ) ?>
</button>
