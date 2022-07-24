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

$wpshop_core    = theme_container()->get( \Wpshop\Core\Core::class );
$wpshop_partner = theme_container()->get( \Wpshop\Core\Partner::class );
?>

<div class="footer-bottom">
    <div class="footer-info">
        <?php
        $footer_copyright = $wpshop_core->get_option( 'footer_copyright' );
        $footer_copyright = str_replace( '%year%', date( 'Y' ), $footer_copyright );
        echo $footer_copyright;
        ?>

        <?php if ( 'yes' == $wpshop_core->get_option( 'wpshop_partner_enable' ) ) : ?>
            <!--noindex-->
            <div class="footer-partner">
                <?php
                $wpshop_partner->the_link( [
                    'prefix'     => $wpshop_core->get_option( 'wpshop_partner_prefix' ),
                    'postfix'    => $wpshop_core->get_option( 'wpshop_partner_postfix' ),
                    'partner_id' => ( defined( 'WPSHOP_PARTNER' ) ) ? WPSHOP_PARTNER : 0,
                ] );
                ?>
            </div>
            <!--/noindex-->
        <?php endif; ?>
    </div>

    <div class="footer-counters">
        <?php $wpshop_core->the_option( 'footer_counters' ) ?>
    </div>
</div>
