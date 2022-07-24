<?php

use Wpshop\Core\Core;

$core = theme_container()->get( Core::class );

$structure_home_h1   = $core->get_option( 'structure_home_h1' );
$structure_home_text = $core->get_option( 'structure_home_text' );
?>

<?php if ( ! empty( $structure_home_h1 ) || ! empty( $structure_home_text ) || is_customize_preview() ): ?>
    <div class="home-content">
        <?php if ( ! empty( $structure_home_h1 ) || is_customize_preview() ): ?>
            <h1 class="home-header"><?php echo $structure_home_h1 ?></h1>
        <?php endif ?>
        <?php if ( ( ! empty( $structure_home_text ) || is_customize_preview() ) && ! is_paged() ): ?>
            <div class="home-text"><?php echo do_shortcode( $structure_home_text ) ?></div>
        <?php endif ?>
    </div>
<?php endif ?>
