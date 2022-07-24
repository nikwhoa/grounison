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

$wpshop_core = theme_container()->get(\Wpshop\Core\Core::class);
?>

<?php do_action(THEME_SLUG . '_before_footer') ?>

<div class="site-footer-container">

    <?php get_template_part('template-parts/navigation/footer') ?>

    <?php if ($wpshop_core->is_show_element('footer')) : ?>
        <footer id="colophon" class="site-footer site-footer--style-gray <?php $wpshop_core->the_option('footer_width') ?>">
            <div class="site-footer-inner <?php $wpshop_core->the_option('footer_inner_width') ?>">
                <div class="site-footer-logo">
                    <picture>
                        <source media="(max-width: 520px)" srcset="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/footer-mobile-logo.jpg">
                        <img width="370" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/footer-logo.jpg" alt="logo">
                    </picture>

                </div>

                <?php get_template_part('template-parts/footer/widgets') ?>
            </div>
            <div class="copyright">
                <div class="all-rights">
                    GRO.UNISON 2022 © All rights Reserved
                </div>
                <div class="site-developed">
                    Develop by <a href="https://lexweb.studio/">lexweb.studio</a>
                </div>
            </div>
        </footer>
        <!--.site-footer-->
    <?php endif ?>
</div>

<?php do_action(THEME_SLUG . '_after_footer') ?>