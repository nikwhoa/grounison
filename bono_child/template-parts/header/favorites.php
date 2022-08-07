<?php
    use Wpshop\TheTheme\Features\Favorite;
?>

<?php $favorite = theme_container()->get(Favorite::class); ?>

<?php if (strpos(get_permalink(), '/ee/') !== false) { ?>

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
<?php } else { ?>
    <a href="<?php echo get_site_url(); ?>/ru/favorite/" title="<?php echo __('Favorite', THEME_TEXTDOMAIN) ?>" class=" header-favorite header-favorite--vis js-header-favorite">
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
<?php } ?>
