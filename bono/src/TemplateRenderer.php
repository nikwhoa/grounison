<?php

namespace Wpshop\TheTheme;

class TemplateRenderer {

    /**
     * @param string $__file__
     * @param array  $__params__
     * @param bool   $__locate__
     *
     * @return false|string
     * @throws \Exception
     */
    public function render( $__file__, $__params__ = [], $__locate__ = false ) {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush( false );
        extract( $__params__, EXTR_OVERWRITE );
        try {
            if ( $__locate__ ) {
                $__file__ = $this->locate_template( $__file__ );
            }
            require $__file__;

            return ob_get_clean();
        } catch ( \Exception $e ) {
            while ( ob_get_level() > $_obInitialLevel_ ) {
                if ( ! @ob_end_clean() ) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public function locate_template( $file ) {
        $file = ltrim( $file, '/\\' );
        if ( file_exists( STYLESHEETPATH . '/' . $file ) ) {
            return STYLESHEETPATH . '/' . $file;
        }
        if ( file_exists( TEMPLATEPATH . '/' . $file ) ) {
            return TEMPLATEPATH . '/' . $file;
        }

        return $file;
    }
}
