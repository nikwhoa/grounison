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

use Wpshop\TheTheme\Features\CompareProducts;
use Wpshop\TheTheme\Features\Favorite;
use Wpshop\TheTheme\Widget\MiniCart;

$wpshop_core        = theme_container()->get(\Wpshop\Core\Core::class);
$header_block_order = $wpshop_core->get_option('header_block_order');
$header_block_order = explode(',', $header_block_order);

$header_style = ($header_style = $wpshop_core->get_option('header_style_type')) ? ' site-header--' . $header_style : '';

?>

<?php do_action(THEME_SLUG . '_before_header') ?>
<script>

    <?php if (strpos(get_permalink(), '/ee/') !== false) {?>
    document.getElementsByName('s')[0].placeholder='Otsing';<?php } ?>

</script>
<header id="masthead" class="site-header<?php echo $header_style ?> <?php $wpshop_core->the_option('header_width') ?>" itemscope itemtype="http://schema.org/WPHeader">
    <div class="site-header-inner <?php $wpshop_core->the_option('header_inner_width') ?>">



        <?php foreach ($header_block_order as $order) {

            if ($order == 'site_branding') {
                get_template_part('template-parts/header/site', 'branding');
            }

            $header_html_block_1 = $wpshop_core->get_option('header_html_block_1');
            if ($order == 'header_html_block_1' && !empty($header_html_block_1)) { ?>
                <div class="header-html-1">
                    <?php echo do_shortcode($header_html_block_1) ?>
                </div>
            <?php }

            if ($order == 'header_social') {
                get_template_part('template-parts/blocks/social', 'links');
            }

            if ($order == 'top_menu') {
                get_template_part('template-parts/navigation/top');
            }

            $header_html_block_2 = $wpshop_core->get_option('header_html_block_2');
            if ($order == 'header_html_block_2' && !empty($header_html_block_2)) { ?>
                <div class="header-html-2">
                    <?php echo do_shortcode($header_html_block_2) ?>
                </div>
            <?php }

            if ($order == 'header_search') { ?>
                <?php $search_type = $wpshop_core->get_option('header_search_type') ?>

                <div class="header-search header-search--<?php echo $search_type ?>">
                    <?php if ($search_type == 'compact') : ?>
                        <span class="header-search-ico js-header-search-ico"></span>
                    <?php endif; ?>
                    <?php //aws_get_search_form( true ); ?>
                    <?php //do_shortcode('[aws_search_form]'); ?>
                    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                        <label>
                            <span class="screen-reader-text"><?php echo __('Search for:', THEME_TEXTDOMAIN) ?></span>
                            <?php aws_get_search_form( true ); ?>
                        </label>
                        <button type="submit" class="search-submit"></button>
                    </form>
                </div>
                <style>.search-submit{display:none;}</style>
            <?php }

            if ($order == 'header_phone_number' && $wpshop_core->get_option('header_phone_number')) {
            ?>
                <div class="header-phone">
                    <?php
                    $phones = $wpshop_core->get_option('header_phone_number');
                    $phones = explode("\n", $phones);
                    $phones = array_map('trim', $phones);
                    $phones = array_filter($phones);
                    foreach ($phones as $phone) {
                        $phone_parts = explode("//", $phone);
                        $phone_parts = array_map('trim', $phone_parts);
                        $phone_clean = preg_replace('/[^\d+]/ui', '', wp_strip_all_tags($phone_parts[0]));

                        $phone_clean = apply_filters('bono_header_phone_clean', $phone_clean, $phone_parts);

                        echo '<div class="header-phone__item">';
                        echo '<a href="tel:' . urlencode($phone_clean) . '">';
                        echo $phone_parts[0];
                        if (!empty($phone_parts[1])) {
                            echo '<br><small>' . $phone_parts[1] . '</small>';
                        }
                        echo '</a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            <?php
            }

            //$favorite = theme_container()->get(Favorite::class);
            //if ($order == 'header_favorite' && $favorite->enabled()) {
            ?>
                <!--<a href="<?php //echo $favorite->get_page_url() ?>" title="<?php //echo __('Favorite', THEME_TEXTDOMAIN) ?>" class=" header-favorite header-favorite--vis js-header-favorite">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.85447 0C4.34801 0 2.84134 0.590008 1.70462 1.77984C-0.569017 4.15911 -0.566097 7.97143 1.70462 10.3523L10.3833 19.4534V19.4536C10.543 19.621 10.7643 19.716 10.9957 19.716C11.227 19.716 11.4485 19.621 11.6081 19.4536C14.5031 16.424 17.4005 13.3909 20.2954 10.3611C22.5688 7.9818 22.5688 4.16746 20.2954 1.7886C18.022 -0.590667 14.2695 -0.590869 11.9958 1.7886L11.0003 2.81954L10.0048 1.77999C8.8681 0.590356 7.36164 0.000146347 5.85497 0.000146347L5.85447 0ZM5.85447 1.65629C6.90605 1.65629 7.96489 2.08974 8.7883 2.95155L10.3919 4.63443C10.5516 4.80198 10.7729 4.89678 11.0043 4.89678C11.2356 4.89678 11.4569 4.80198 11.6166 4.63443L13.2113 2.96041C14.8582 1.23686 17.4235 1.23686 19.0706 2.96041C20.7175 4.68397 20.7175 7.47466 19.0706 9.19832C16.3808 12.0132 13.6896 14.824 11.0001 17.6389L2.9296 9.18976C1.28353 7.46384 1.28272 4.67531 2.9296 2.95185C3.75301 2.09008 4.80304 1.65659 5.85482 1.65659L5.85447 1.65629Z" stroke-width="0.4" fill="#282828" />
                    </svg>

                    <?php //if ($favorite->show_counter()) : ?>
                        <?php //$favorite_count = $favorite->count() ?>
                        <sup style="opacity: 1;<?php //echo apply_filters('bono_favorite:counter:show_zero', (bool) $favorite_count) ? '' : 'display:none;' ?>">
                            <?php //echo $favorite_count ?>
                        </sup>
                    <?php //endif ?>
                </a> -->
            <?php
            //}

            if (strpos(get_permalink(), '/ee/') !== false) {
    $favorite = theme_container()->get(Favorite::class);
            if ($order == 'header_favorite' && $favorite->enabled()) {
            ?>
                <a href="<?php echo get_site_url(); ?>/ee/favorite/" title="<?php echo __('Favorite', THEME_TEXTDOMAIN) ?>" class=" header-favorite header-favorite--vis js-header-favorite">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.85447 0C4.34801 0 2.84134 0.590008 1.70462 1.77984C-0.569017 4.15911 -0.566097 7.97143 1.70462 10.3523L10.3833 19.4534V19.4536C10.543 19.621 10.7643 19.716 10.9957 19.716C11.227 19.716 11.4485 19.621 11.6081 19.4536C14.5031 16.424 17.4005 13.3909 20.2954 10.3611C22.5688 7.9818 22.5688 4.16746 20.2954 1.7886C18.022 -0.590667 14.2695 -0.590869 11.9958 1.7886L11.0003 2.81954L10.0048 1.77999C8.8681 0.590356 7.36164 0.000146347 5.85497 0.000146347L5.85447 0ZM5.85447 1.65629C6.90605 1.65629 7.96489 2.08974 8.7883 2.95155L10.3919 4.63443C10.5516 4.80198 10.7729 4.89678 11.0043 4.89678C11.2356 4.89678 11.4569 4.80198 11.6166 4.63443L13.2113 2.96041C14.8582 1.23686 17.4235 1.23686 19.0706 2.96041C20.7175 4.68397 20.7175 7.47466 19.0706 9.19832C16.3808 12.0132 13.6896 14.824 11.0001 17.6389L2.9296 9.18976C1.28353 7.46384 1.28272 4.67531 2.9296 2.95185C3.75301 2.09008 4.80304 1.65659 5.85482 1.65659L5.85447 1.65629Z" stroke-width="0.4" fill="#282828" />
                    </svg>

                    <?php if ($favorite->show_counter()) : ?>
                        <?php $favorite_count = $favorite->count() ?>
                        <sup style="opacity: 1;<?php echo apply_filters('bono_favorite:counter:show_zero', (bool) $favorite_count) ? '' : 'display:none;' ?>">
                            <?php echo $favorite_count ?>
                        </sup>
                    <?php endif ?>
                </a>
            <?php
            }
}else{
	$favorite = theme_container()->get(Favorite::class);
    if ($order == 'header_favorite' && $favorite->enabled()) {
            ?>
                <a href="<?php echo $favorite->get_page_url() ?>" title="<?php echo __('Favorite', THEME_TEXTDOMAIN) ?>" class=" header-favorite header-favorite--vis js-header-favorite">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.85447 0C4.34801 0 2.84134 0.590008 1.70462 1.77984C-0.569017 4.15911 -0.566097 7.97143 1.70462 10.3523L10.3833 19.4534V19.4536C10.543 19.621 10.7643 19.716 10.9957 19.716C11.227 19.716 11.4485 19.621 11.6081 19.4536C14.5031 16.424 17.4005 13.3909 20.2954 10.3611C22.5688 7.9818 22.5688 4.16746 20.2954 1.7886C18.022 -0.590667 14.2695 -0.590869 11.9958 1.7886L11.0003 2.81954L10.0048 1.77999C8.8681 0.590356 7.36164 0.000146347 5.85497 0.000146347L5.85447 0ZM5.85447 1.65629C6.90605 1.65629 7.96489 2.08974 8.7883 2.95155L10.3919 4.63443C10.5516 4.80198 10.7729 4.89678 11.0043 4.89678C11.2356 4.89678 11.4569 4.80198 11.6166 4.63443L13.2113 2.96041C14.8582 1.23686 17.4235 1.23686 19.0706 2.96041C20.7175 4.68397 20.7175 7.47466 19.0706 9.19832C16.3808 12.0132 13.6896 14.824 11.0001 17.6389L2.9296 9.18976C1.28353 7.46384 1.28272 4.67531 2.9296 2.95185C3.75301 2.09008 4.80304 1.65659 5.85482 1.65659L5.85447 1.65629Z" stroke-width="0.4" fill="#282828" />
                    </svg>

                    <?php if ($favorite->show_counter()) : ?>
                        <?php $favorite_count = $favorite->count() ?>
                        <sup style="opacity: 1;<?php echo apply_filters('bono_favorite:counter:show_zero', (bool) $favorite_count) ? '' : 'display:none;' ?>">
                            <?php echo $favorite_count ?>
                        </sup>
                    <?php endif ?>
                </a>
            <?php
            }
}

            //$compare_products = theme_container()->get(CompareProducts::class);
            //if ($order == 'header_compare' && $compare_products->enabled()) {
            ?>


               <!-- <a href="<?php //echo $compare_products->get_page_url() ?>" title="<?php //echo __('Compare Products', THEME_TEXTDOMAIN) ?>" class="header-compare header-compare--vis js-header-compare">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.0004 13.6285V13.5284V13.4282L20.1424 4.75986C20.0923 4.55939 19.892 4.40907 19.6915 4.40907L14.33 4.40924C14.1297 3.50736 13.4282 2.7558 12.4763 2.55532V0.501101C12.4763 0.200475 12.2758 0 11.9752 0C11.6746 0 11.4741 0.200475 11.4741 0.501101V2.55532C10.5221 2.7558 9.82065 3.50736 9.62017 4.40924H4.3094C4.10893 4.40924 3.90863 4.55955 3.85846 4.76003L0.000488281 13.4279V13.5281V13.6282C0.000488281 16.0333 1.95456 17.9873 4.35956 17.9873C6.76457 17.9873 8.71864 16.0333 8.71864 13.6282V13.5281V13.4279L5.16129 5.4111H9.72093C9.9214 6.36314 10.673 7.06454 11.5748 7.26502V19.5404C9.62078 19.7909 8.06748 21.4945 8.06748 23.4987C8.06748 23.7994 8.26796 23.9998 8.56858 23.9998H15.583C15.8837 23.9998 16.0841 23.7994 16.0841 23.4987C16.0841 21.4445 14.5309 19.7911 12.5768 19.5404L12.5766 7.31483C13.5287 7.11436 14.2301 6.3628 14.4305 5.46092H18.9902L15.4328 13.4778V13.5779V13.6781C15.4328 16.0831 17.3869 18.0371 19.7919 18.0371C22.0464 17.9871 24.0005 16.0331 24.0005 13.6282L24.0004 13.6285ZM22.7477 13.1276H16.5849L19.6413 6.16293L22.7477 13.1276ZM4.30949 6.16293L7.36591 13.1276H1.20308L4.30949 6.16293ZM4.30949 16.9855C2.65605 16.9855 1.25307 15.7328 1.0026 14.1295H7.61637C7.36591 15.7328 5.96293 16.9855 4.30949 16.9855ZM14.9315 23.0482H9.01944C9.2699 21.6453 10.4724 20.5431 11.9755 20.5431C13.4787 20.5429 14.6812 21.6453 14.9316 23.0482H14.9315ZM11.9754 6.36349C11.1736 6.36349 10.5724 5.71207 10.5724 4.96051C10.5724 4.15878 11.1736 3.50754 11.9754 3.50754C12.7771 3.50754 13.3783 4.15895 13.3783 4.91052C13.3783 5.71207 12.7771 6.36349 11.9754 6.36349ZM19.6413 16.9855C17.9879 16.9855 16.5849 15.7328 16.3344 14.1295H22.9482C22.6977 15.7328 21.3449 16.9855 19.6413 16.9855Z" fill="#282828" stroke="#282828" stroke-width="0.4" />
                    </svg>
                    <?php //if ($compare_products->show_counter()) : ?>

                        <?php //$compare_count = $compare_products->count() ?>
                        <sup style="opacity: 1;<?php //echo apply_filters('bono_compare_products:counter:show_zero', (bool) $compare_count) ? '' : 'display:none;' ?>">
                            <?php //echo $compare_count ?>
                        </sup>
                    <?php //endif ?>
                </a> -->
        <?php
            //}

            if (strpos(get_permalink(), '/ee/') !== false) {
    $compare_products = theme_container()->get(CompareProducts::class);
            if ($order == 'header_compare' && $compare_products->enabled()) {
            ?>


                <a href="https://easycutfor.lexweb.studio/ee/compare/" title="<?php echo __('Compare Products', THEME_TEXTDOMAIN) ?>" class="header-compare header-compare--vis js-header-compare">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.0004 13.6285V13.5284V13.4282L20.1424 4.75986C20.0923 4.55939 19.892 4.40907 19.6915 4.40907L14.33 4.40924C14.1297 3.50736 13.4282 2.7558 12.4763 2.55532V0.501101C12.4763 0.200475 12.2758 0 11.9752 0C11.6746 0 11.4741 0.200475 11.4741 0.501101V2.55532C10.5221 2.7558 9.82065 3.50736 9.62017 4.40924H4.3094C4.10893 4.40924 3.90863 4.55955 3.85846 4.76003L0.000488281 13.4279V13.5281V13.6282C0.000488281 16.0333 1.95456 17.9873 4.35956 17.9873C6.76457 17.9873 8.71864 16.0333 8.71864 13.6282V13.5281V13.4279L5.16129 5.4111H9.72093C9.9214 6.36314 10.673 7.06454 11.5748 7.26502V19.5404C9.62078 19.7909 8.06748 21.4945 8.06748 23.4987C8.06748 23.7994 8.26796 23.9998 8.56858 23.9998H15.583C15.8837 23.9998 16.0841 23.7994 16.0841 23.4987C16.0841 21.4445 14.5309 19.7911 12.5768 19.5404L12.5766 7.31483C13.5287 7.11436 14.2301 6.3628 14.4305 5.46092H18.9902L15.4328 13.4778V13.5779V13.6781C15.4328 16.0831 17.3869 18.0371 19.7919 18.0371C22.0464 17.9871 24.0005 16.0331 24.0005 13.6282L24.0004 13.6285ZM22.7477 13.1276H16.5849L19.6413 6.16293L22.7477 13.1276ZM4.30949 6.16293L7.36591 13.1276H1.20308L4.30949 6.16293ZM4.30949 16.9855C2.65605 16.9855 1.25307 15.7328 1.0026 14.1295H7.61637C7.36591 15.7328 5.96293 16.9855 4.30949 16.9855ZM14.9315 23.0482H9.01944C9.2699 21.6453 10.4724 20.5431 11.9755 20.5431C13.4787 20.5429 14.6812 21.6453 14.9316 23.0482H14.9315ZM11.9754 6.36349C11.1736 6.36349 10.5724 5.71207 10.5724 4.96051C10.5724 4.15878 11.1736 3.50754 11.9754 3.50754C12.7771 3.50754 13.3783 4.15895 13.3783 4.91052C13.3783 5.71207 12.7771 6.36349 11.9754 6.36349ZM19.6413 16.9855C17.9879 16.9855 16.5849 15.7328 16.3344 14.1295H22.9482C22.6977 15.7328 21.3449 16.9855 19.6413 16.9855Z" fill="#282828" stroke="#282828" stroke-width="0.4" />
                    </svg>
                    <?php if ($compare_products->show_counter()) : ?>

                        <?php $compare_count = $compare_products->count() ?>
                        <sup style="opacity: 1;<?php echo apply_filters('bono_compare_products:counter:show_zero', (bool) $compare_count) ? '' : 'display:none;' ?>">
                            <?php echo $compare_count ?>
                        </sup>
                    <?php endif ?>
                </a>
        <?php
            }
}else{
    $compare_products = theme_container()->get(CompareProducts::class);
            if ($order == 'header_compare' && $compare_products->enabled()) {
            ?>


                <a href="https://easycutfor.lexweb.studio/compare/" title="<?php echo __('Compare Products', THEME_TEXTDOMAIN) ?>" class="header-compare header-compare--vis js-header-compare">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.0004 13.6285V13.5284V13.4282L20.1424 4.75986C20.0923 4.55939 19.892 4.40907 19.6915 4.40907L14.33 4.40924C14.1297 3.50736 13.4282 2.7558 12.4763 2.55532V0.501101C12.4763 0.200475 12.2758 0 11.9752 0C11.6746 0 11.4741 0.200475 11.4741 0.501101V2.55532C10.5221 2.7558 9.82065 3.50736 9.62017 4.40924H4.3094C4.10893 4.40924 3.90863 4.55955 3.85846 4.76003L0.000488281 13.4279V13.5281V13.6282C0.000488281 16.0333 1.95456 17.9873 4.35956 17.9873C6.76457 17.9873 8.71864 16.0333 8.71864 13.6282V13.5281V13.4279L5.16129 5.4111H9.72093C9.9214 6.36314 10.673 7.06454 11.5748 7.26502V19.5404C9.62078 19.7909 8.06748 21.4945 8.06748 23.4987C8.06748 23.7994 8.26796 23.9998 8.56858 23.9998H15.583C15.8837 23.9998 16.0841 23.7994 16.0841 23.4987C16.0841 21.4445 14.5309 19.7911 12.5768 19.5404L12.5766 7.31483C13.5287 7.11436 14.2301 6.3628 14.4305 5.46092H18.9902L15.4328 13.4778V13.5779V13.6781C15.4328 16.0831 17.3869 18.0371 19.7919 18.0371C22.0464 17.9871 24.0005 16.0331 24.0005 13.6282L24.0004 13.6285ZM22.7477 13.1276H16.5849L19.6413 6.16293L22.7477 13.1276ZM4.30949 6.16293L7.36591 13.1276H1.20308L4.30949 6.16293ZM4.30949 16.9855C2.65605 16.9855 1.25307 15.7328 1.0026 14.1295H7.61637C7.36591 15.7328 5.96293 16.9855 4.30949 16.9855ZM14.9315 23.0482H9.01944C9.2699 21.6453 10.4724 20.5431 11.9755 20.5431C13.4787 20.5429 14.6812 21.6453 14.9316 23.0482H14.9315ZM11.9754 6.36349C11.1736 6.36349 10.5724 5.71207 10.5724 4.96051C10.5724 4.15878 11.1736 3.50754 11.9754 3.50754C12.7771 3.50754 13.3783 4.15895 13.3783 4.91052C13.3783 5.71207 12.7771 6.36349 11.9754 6.36349ZM19.6413 16.9855C17.9879 16.9855 16.5849 15.7328 16.3344 14.1295H22.9482C22.6977 15.7328 21.3449 16.9855 19.6413 16.9855Z" fill="#282828" stroke="#282828" stroke-width="0.4" />
                    </svg>
                    <?php if ($compare_products->show_counter()) : ?>

                        <?php $compare_count = $compare_products->count() ?>
                        <sup style="opacity: 1;<?php echo apply_filters('bono_compare_products:counter:show_zero', (bool) $compare_count) ? '' : 'display:none;' ?>">
                            <?php echo $compare_count ?>
                        </sup>
                    <?php endif ?>
                </a>
        <?php
            }
}

            if ($order == 'header_cart' && apply_filters('bono_enabled_minicart', true)) {
                the_widget(MiniCart::class, 'title=', [
                    'wc_cart_widget_args' => [],
                ]);
            }
        } ?>
        <div class="humburger js-humburger"><span></span><span></span><span></span></div>
    </div>
</header><!-- #masthead -->

<?php do_action(THEME_SLUG . '_after_header') ?>