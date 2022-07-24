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

?>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x( 'Search for:', THEME_TEXTDOMAIN ) ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_html__( 'Search…', THEME_TEXTDOMAIN ) ?>" value="<?php echo get_search_query() ?>" name="s">
    </label>
    <button type="submit" class="search-submit"></button>
</form>
