<?php

namespace Wpshop\TheTheme;

use Wpshop\Core\Core;

class PostCard {

    protected $core;
    protected $customizerOptionName = '';
    protected $sectionOptions = [];
    protected $orders = [];

    /**
     * PostCard constructor.
     *
     * @param Core $core
     */
    public function __construct( Core $core ) {
        $this->core = $core;
    }

    /**
     * @param string $element
     *
     * @return bool
     */
    public function doShowElement( $element = '' ) {

        $show = ( in_array( $element, $this->orders ) );

        if ( ! empty( $this->sectionOptions[ 'show_' . $element ] ) && in_array( $this->sectionOptions[ 'show_' . $element ], [
                'show',
                'hide',
            ] ) ) {
            $show = ( $this->sectionOptions[ 'show_' . $element ] == 'show' ) ? true : false;
        }

        return $show;
    }

    /**
     * @param $sectionOptions
     *
     * @return $this
     */
    public function setSectionOptions( $sectionOptions ) {
        $this->sectionOptions = $sectionOptions;

        return $this;
    }

    /**
     * @param $customizerOptionName
     *
     * @return $this
     */
    public function setCustomizerOptionName( $customizerOptionName ) {
        $this->customizerOptionName = $customizerOptionName;

        return $this;
    }

    /**
     * @param $orders
     *
     * @return $this
     */
    public function setOrders( $orders ) {
        $this->orders = $orders;

        return $this;
    }
}
