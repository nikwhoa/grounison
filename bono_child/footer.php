<?php

use Wpshop\Core\Advertising;
use Wpshop\Core\Core;

$core        = theme_container()->get(Core::class);
$advertising = theme_container()->get(Advertising::class);

?>

</div>
<!--.site-content-inner-->
</div>
<!--.site-content-->
<?php
$args = array(
	'p' => 2593,
);

$latest_posts = get_posts($args);
if ($latest_posts) {
	foreach ($latest_posts as $post) :
		setup_postdata($post); ?>
		<div class="seo-section-wrapper">
			<section class="main-page-seo-section">
				<h2><?php the_title(); ?></h2>
				<div class="seo-section-description">
					<?php the_content(); ?>
				</div>
			</section>
		</div>
<?php
	endforeach;
	wp_reset_postdata();
}
?>
<div class="block-after-site <?php echo apply_filters('bono_site_content_classes', 'fixed') ?>"><?php echo $advertising->show_ad('after_site_content'); ?></div>

<?php do_action(THEME_SLUG . '_after_site_content') ?>

<?php get_template_part('template-parts/footer/footer') ?>

<?php if ($core->get_option('arrow_display')) : ?>
	<button type="button" class="scrolltop js-scrolltop" <?php echo $core->get_option('arrow_mob_display') ? ' data-mob="on"' : '' ?>>
		<svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_71_2697)">
				<path d="M6.94214 6.68L1.77731 11.8548C1.37424 12.2629 0.714234 12.2629 0.306118 11.8548C-0.101968 11.4517 -0.101968 10.7917 0.306118 10.3836L6.20637 4.47333C6.40289 4.27681 6.66483 4.16602 6.94207 4.16602C7.21932 4.16602 7.48126 4.27681 7.67777 4.46832L13.5881 10.3886C13.7896 10.5901 13.8904 10.857 13.8904 11.1243C13.8904 11.3912 13.7896 11.6584 13.5881 11.86C13.18 12.268 12.525 12.268 12.1169 11.86L6.94214 6.68Z" fill="#F8F8F8" />
			</g>
			<defs>
				<clipPath id="clip0_71_2697">
					<rect width="14" height="14" fill="white" transform="translate(0 14.4995) rotate(-90)" />
				</clipPath>
			</defs>
		</svg>
		<svg class="scrolltop-down-arrow" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g clip-path="url(#clip0_71_2697)">
				<path d="M6.94214 6.68L1.77731 11.8548C1.37424 12.2629 0.714234 12.2629 0.306118 11.8548C-0.101968 11.4517 -0.101968 10.7917 0.306118 10.3836L6.20637 4.47333C6.40289 4.27681 6.66483 4.16602 6.94207 4.16602C7.21932 4.16602 7.48126 4.27681 7.67777 4.46832L13.5881 10.3886C13.7896 10.5901 13.8904 10.857 13.8904 11.1243C13.8904 11.3912 13.7896 11.6584 13.5881 11.86C13.18 12.268 12.525 12.268 12.1169 11.86L6.94214 6.68Z" fill="#F8F8F8" />
			</g>
			<defs>
				<clipPath id="clip0_71_2697">
					<rect width="14" height="14" fill="white" transform="translate(0 14.4995) rotate(-90)" />
				</clipPath>
			</defs>
		</svg>

	</button>
<?php endif ?>


</div><!-- #page -->

<?php wp_footer(); ?>
<?php $core->the_option('code_body') ?>

<?php do_action(THEME_SLUG . '_before_body') ?>

<?php get_template_part('template-parts/footer/init-slider')  ?>

</body>

</html>