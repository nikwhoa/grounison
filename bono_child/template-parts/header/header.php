<?php

use Wpshop\TheTheme\Widget\MiniCart;

$wpshop_core        = theme_container()->get(\Wpshop\Core\Core::class);
$header_block_order = $wpshop_core->get_option('header_block_order');
$header_block_order = explode(',', $header_block_order);

$header_style = ($header_style = $wpshop_core->get_option('header_style_type')) ? ' site-header--' . $header_style : '';

?>

<?php do_action(THEME_SLUG . '_before_header') ?>

<script>
    <?php if (strpos(get_permalink(), '/ee/') !== false) { ?>
        document.getElementsByName('s')[0].placeholder = 'Otsing';
    <?php } ?>
</script>
<header id="masthead" class="site-header<?php echo $header_style; ?> <?php $wpshop_core->the_option('header_width'); ?>" itemscope itemtype="http://schema.org/WPHeader">
    <div class="site-header-inner <?php $wpshop_core->the_option('header_inner_width'); ?>">
        <?php foreach ($header_block_order as $order) {
            if ($order == 'site_branding') {
                get_template_part('template-parts/header/site', 'branding');
            }

            $header_html_block_1 = $wpshop_core->get_option('header_html_block_1');

            if ($order == 'header_html_block_1' && !empty($header_html_block_1)) { ?>

                <div class="header-html-1">
                    <?php echo do_shortcode($header_html_block_1); ?>
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
            <?php } ?>

            <?php if ($order == 'header_search') : ?>

                <?php $search_type = $wpshop_core->get_option('header_search_type') ?>

                <div class="header-search header-search--<?php echo $search_type ?>">
                    <?php if ($search_type == 'compact') : ?>
                        <span class="header-search-ico js-header-search-ico"></span>
                    <?php endif; ?>
                    <?php //aws_get_search_form( true );
                    ?>
                    <?php //do_shortcode('[aws_search_form]');
                    ?>
                    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                        <label>
                            <span class="screen-reader-text"><?php echo __('Search for:', THEME_TEXTDOMAIN) ?></span>
                            <?php aws_get_search_form(true); ?>
                        </label>
                        <button type="submit" class="search-submit"></button>
                    </form>
                </div>
                <style>
                    .search-submit {
                        display: none;
                    }
                </style>
            <?php endif; ?>

            <?php if ($order == 'header_phone_number' && $wpshop_core->get_option('header_phone_number')) : ?>
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
            <?php endif; ?>

            <?php  if ($order === 'header_favorite') : ?>
                <?php get_template_part('template-parts/header/favorites'); ?>
            <?php endif; ?>

            <?php if ($order == 'header_compare') : ?>
                <?php get_template_part('template-parts/header/compare'); ?>
            <?php endif; ?>

            <?php if ($order == 'header_cart') : ?>

                <?php if (apply_filters('bono_enabled_minicart', true)) {
                    the_widget(MiniCart::class, 'title=', [
                        'wc_cart_widget_args' => [],
                    ]);
                }
                ?>
            <?php endif; ?>
        <?php }  ?>
        <!-- foreach end -->
        <div class="humburger js-humburger"><span></span><span></span><span></span></div>
    </div>
</header><!-- #masthead -->

<?php do_action(THEME_SLUG . '_after_header') ?>