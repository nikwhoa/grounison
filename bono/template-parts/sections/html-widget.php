<?php

defined( 'ABSPATH' ) || exit;

use Wpshop\TheTheme\Features\HomeConstructor;

echo '<div class="homepage-construct-widgets">';
dynamic_sidebar( HomeConstructor::HTML_WIDGET_ID );
echo '</div>';
