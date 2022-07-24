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

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Wpshop\Core\Core;

$wpshop_core    = theme_container()->get( Core::class );
$ordered_blocks = $wpshop_core->get_option( 'super_header_block_order' );
$ordered_blocks = explode( ',', $ordered_blocks );
$ordered_blocks = array_filter( $ordered_blocks );

$super_header_show_mob = $wpshop_core->get_option( 'super_header_show_mob' );

$super_header_classes = [];
$super_header_classes[] = $wpshop_core->get_option( 'super_header_width' );
$super_header_classes[] = 'super-header--items-' . count( $ordered_blocks );
if ( $super_header_show_mob ) {
    $super_header_classes[] = 'super-header--mob-show';
} else {
	$super_header_classes[] = 'super-header--mob-hide';
}

?>

<div class="super-header <?php echo implode( ' ', $super_header_classes ) ?>">
    <div class="super-header-inner <?php echo $wpshop_core->get_option( 'super_header_inner_width' ) ?>">
        <?php foreach ( $ordered_blocks as $ordered_block ): ?>
            <?php for ( $i = 1 ; $i <= 6 ; $i ++ ) {
                $block_option = 'super_header_html_block_' . $i;
                if ( $ordered_block !== $block_option ) {
                    continue;
                }
                $block = $wpshop_core->get_option( $block_option );
                ?>
                <div class="super-header__item super-header__item--<?php echo $i ?>"><?php echo do_shortcode( $block ) ?></div>
                <?php
            } ?>

        <?php endforeach ?>
    </div>
</div>

