<?php


namespace Wpshop\TheTheme\Features;


use WC_Product;
use Wpshop\Core\Core;

class SaleFlash {

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var string
     */
    protected $default_message;

    /**
     * SalesDiscount constructor.
     *
     * @param Core $core
     */
    public function __construct( Core $core ) {
        $this->core            = $core;
        $this->default_message = $this->core->get_option( 'sale_flash_default' );
    }

    /**
     * @param WC_Product $product
     *
     * @return string
     */
    public function get_message( $product ) {
        $format = trim( $this->core->get_option( 'sale_flash_price_format' ) );

        if ( $format ) {
            if ( false !== strpos( $format, '{{' ) ) {
                if ( $discount_data = $this->get_discounts( $product, 0 ) ) {
                    $replace_pairs = array_combine( [ '{{discount_percent}}', '{{discount_value}}' ], $discount_data );

                    return strtr( $format, $replace_pairs );
                } else {
                    return $this->default_message;
                }
            }

            return $format;
        }

        return $this->default_message;
    }

    /**
     * @param WC_Product $product
     * @param int        $precision
     *
     * @return array|null [percent, discount]
     */
    protected function get_discounts( $product, $precision = 2 ) {
        if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
            $price      = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            $percent    = round( ( ( floatval( $price ) - floatval( $sale_price ) ) / floatval( $price ) ) * 100, $precision );

            return [ $percent, $this->format_price( $price - $sale_price ) ];

        } elseif ( $product->is_type( 'variable' ) ) {
            $available_variations = $product->get_available_variations();
            $max_percent          = 0;
            $max_discount         = 0;

            for ( $i = 0 ; $i < count( $available_variations ) ; ++ $i ) {
                $variation_id     = $available_variations[ $i ]['variation_id'];
                $variable_product = new \WC_Product_Variation( $variation_id );

                if ( ! $variable_product->is_on_sale() ) {
                    continue;
                }

                $price      = $variable_product->get_regular_price();
                $sale_price = $variable_product->get_sale_price();
                $percent    = round( ( ( floatval( $price ) - floatval( $sale_price ) ) / floatval( $price ) ) * 100, $precision );
                $discount   = $price - $sale_price;

                if ( $percent > $max_percent ) {
                    $max_percent = $percent;
                }

                if ( $discount > $max_discount ) {
                    $max_discount = $discount;
                }
            }

            return [ $max_percent, $this->format_price( $max_discount ) ];
        }

        return null;
    }

    /**
     * @param float $price
     * @param array $args
     *
     * @return string
     * @see wc_price()
     */
    protected function format_price( $price, $args = [] ) {
        $args = apply_filters(
            'wc_price_args',
            wp_parse_args(
                $args,
                [
                    'currency'           => '',
                    'decimal_separator'  => wc_get_price_decimal_separator(),
                    'thousand_separator' => wc_get_price_thousand_separator(),
                    'decimals'           => wc_get_price_decimals(),
                    'price_format'       => get_woocommerce_price_format(),
                ]
            )
        );

        $negative = $price < 0;
        $price    = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * - 1 : $price ) );
        $price    = apply_filters(
            'formatted_woocommerce_price',
            number_format(
                $price,
                $args['decimals'],
                $args['decimal_separator'],
                $args['thousand_separator']
            ),
            $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator']
        );

        if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
            $price = wc_trim_zeros( $price );
        }

        $formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], '<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $args['currency'] ) . '</span>', $price );

        return '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';
    }
}
