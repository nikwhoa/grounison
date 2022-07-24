<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Core;

class ProductTabs {

    /**
     * @var Core
     */
    protected $core;

    /**
     * ProductTabs constructor.
     *
     * @param Core $core
     */
    public function __construct( Core $core ) {
        $this->core = $core;
    }

    /**
     * @param array $tabs
     *
     * @return array
     */
    public function prepare_product_tabs( $tabs = [] ) {
        if ( ! $tabs || ! is_array( $tabs ) ) {
            return $tabs;
        }

        $order_data = $this->core->get_option( 'product_info_tabs_order' );
        $order_data = explode( ',', $order_data );
        $priority   = 10;
        $step       = 10;
        $result     = [];
        foreach ( $order_data as $key ) {
            if ( array_key_exists( $key, $tabs ) ) {
                $result[ $key ]             = $tabs[ $key ];
                $result[ $key ]['priority'] = $priority;
                $priority                   += $step;
            }
        }

        $behavior = $this->core->get_option( 'product_info_additional_tabs_behavior' );

        $left_items = array_diff_key( $tabs, $result );

        switch ( $behavior ) {
            case 'ignore':
                // do nothing
                break;
            case 'prepend':
                $priority   = 10;
                $step       = 10;
                $new_result = [];
                foreach ( $left_items as $key => $data ) {
                    $data['priority']   = $priority;
                    $priority           += $step;
                    $new_result[ $key ] = $data;
                }
                foreach ( $result as $key => $data ) {
                    $data['priority']   = $priority;
                    $priority           += $step;
                    $new_result[ $key ] = $data;
                }

                $result = $new_result;
                break;
            case 'append':
                foreach ( $left_items as $key => $data ) {
                    $data['priority'] = $priority;
                    $priority         += $step;
                    $result[ $key ]   = $data;
                }
                break;
            case 'as_is':
                foreach ( $left_items as $key => $data ) {
                    $result[ $key ] = $data;
                }
                break;
            default:
                break;
        }

        return $result;
    }

    /**
     * @return void
     */
    public function dummy_callback() {
        echo '<span class="tab-preview-preview-text">';
        echo __( 'Empty tab appearing for customizer preview only', THEME_TEXTDOMAIN );
        echo '</span>';
    }
}
