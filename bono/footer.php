<?php

use Wpshop\Core\Advertising;
use Wpshop\Core\Core;

$core        = theme_container()->get( Core::class );
$advertising = theme_container()->get( Advertising::class );

?>

</div><!--.site-content-inner-->
</div><!--.site-content-->

<div class="block-after-site <?php echo apply_filters( 'bono_site_content_classes', 'fixed' ) ?>"><?php echo $advertising->show_ad( 'after_site_content' ); ?></div>

<?php do_action( THEME_SLUG . '_after_site_content' ) ?>

<?php get_template_part( 'template-parts/footer/footer' ) ?>

<?php if ( $core->get_option( 'arrow_display' ) ): ?>
    <button type="button" class="scrolltop js-scrolltop"<?php echo $core->get_option( 'arrow_mob_display' ) ? ' data-mob="on"' : '' ?>></button>
<?php endif ?>


</div><!-- #page -->

<?php wp_footer(); ?>
<?php $core->the_option( 'code_body' ) ?>

<?php do_action( THEME_SLUG . '_before_body' ) ?>

<?php get_template_part( 'template-parts/footer/init-slider' ) ?>



</body>
</html>
