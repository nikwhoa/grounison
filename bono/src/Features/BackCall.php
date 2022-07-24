<?php


namespace Wpshop\TheTheme\Features;


class BackCall {

    public function init() {

        do_action( __METHOD__, $this );
    }
}
