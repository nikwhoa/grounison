<?php


namespace Wpshop\TheTheme\Setup;


use Wpshop\TheTheme\Features\CompareProducts;

class DataSetup {

    /**
     * @var string
     */
    protected $version_option;

    /**
     * @var CompareProducts
     */
    protected $compare_products;

    /**
     * DataSetup constructor.
     *
     * @param                 $version_option
     * @param CompareProducts $compare_products
     */
    public function __construct(
        $version_option,
        CompareProducts $compare_products
    ) {
        $this->version_option   = $version_option;
        $this->compare_products = $compare_products;
    }

    /**
     * @return void
     */
    public function init() {
        add_action( 'init', [ $this, 'setup' ], 9999 );

        do_action( __METHOD__, $this );
    }

    /**
     * @return $this
     */
    public function setup() {
        $version = get_option( $this->version_option, '0.0.0' );
        if ( version_compare( THEME_VERSION, $version, '>' ) ) {
            if ( function_exists( 'opcache_reset' ) ) {
                @opcache_reset();
            }

            $this->upgrade( $version, THEME_VERSION );

            update_option( $this->version_option, THEME_VERSION );
        }

        return $this;
    }

    /**
     * @param string $old_version
     * @param string $new_version
     *
     * @return void
     */
    protected function upgrade( $old_version, $new_version ) {
        if ( version_compare( $old_version, '1.1.0', '<' ) ) {
            $this->compare_products->create_default_pages();
        }
    }
}
