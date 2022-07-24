<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Core;

class Slider {

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var array
     */
    protected $slider_params = [];

    /**
     * SliderHelper constructor.
     *
     * @param Core $core
     */
    public function __construct( Core $core ) {
        $this->core = $core;
    }

    /**
     * @param array $options
     *
     * @return string
     */
    public function acquire_id( $options ) {
        $id = uniqid( '--slider-' );

        $this->slider_params[ $id ] = $options;

        return $id;
    }

    /**
     * @return array
     */
    public function get_slider_params() {
        return $this->slider_params;
    }

    /**
     * @return bool
     */
    public function has_sliders() {
        $hc = $this->core->get_option( 'home_constructor' );
        if ( ! empty( $hc ) ) {
            $hc = json_decode( $hc, true );
            foreach ( $hc as $section ) {
                if ( ! empty( $section['section_type'] ) && 'slider' === $section['section_type'] ) {
                    return true;
                }
            }
        }

        return false;
    }
}
