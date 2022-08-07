<?php

use Wpshop\TheTheme\Slider;

defined( 'ABSPATH' ) || exit;

$slider = theme_container()->get( Slider::class );

$do_init = is_front_page() || is_home();

?>
<?php if ( $do_init ): ?>
    <!-- init swiper -->
    <script type="text/javascript">
        <?php foreach ($slider->get_slider_params() as $id => $options): ?>

        <?php $delay = max( 0, absint( $options['delay'] ) ) ?>

        var bonoSwiper = new Swiper('.js-swiper-home<?php echo $id ?>', {
            slidesPerView: 1,
            spaceBetween: 35,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: <?php echo max( 1, absint( $options['slides_per_view'] ) )?>,
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
            <?php if ($delay): ?>,
            autoplay: {
                delay: <?php echo $delay ?>, // move to options
                disableOnInteraction: true,
            }
            <?php endif ?>
        });
        <?php endforeach ?>
    </script>
<?php endif;
