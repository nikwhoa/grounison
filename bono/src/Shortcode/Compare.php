<?php


namespace Wpshop\TheTheme\Shortcode;


class Compare extends \WC_Shortcode_Products {

    /**
     * @var string
     */
    protected $type = 'compare_products';

    /**
     * @var array
     */
    protected $template = [ 'compare', 'products' ];



    /**
     * @inheritDoc
     */
    protected function product_loop() {
        $classes[] = $this->attributes['class'];
        $products  = $this->get_query_results();

        ob_start();

        if ( $products && $products->ids ) {
            // Prime caches to reduce future queries.
            if ( is_callable( '_prime_post_caches' ) ) {
                _prime_post_caches( $products->ids );
            }

            // Setup the loop.
            wc_setup_loop(
                [
                    'name'         => $this->type,
                    'is_shortcode' => true,
                    'is_search'    => false,
                    'is_paginated' => false,
                    'total'        => $products->total,
                    'total_pages'  => $products->total_pages,
                    'per_page'     => $products->per_page,
                    'current_page' => $products->current_page,
                ]
            );

            $original_post = $GLOBALS['post'];

            do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                echo '<div class="compare-products compare-table--columns-' . count( $products->ids ) . '">';
                echo '<div class="compare-products__row">';
                echo '<div class="compare-products__item compare-products__item-header"></div>';

                foreach ( $products->ids as $product_id ) {
                    $GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
                    setup_postdata( $GLOBALS['post'] );

                    // Set custom product visibility when quering hidden products.
                    add_action( 'woocommerce_product_is_visible', [ $this, 'set_product_as_visible' ] );

                    echo '<div class="compare-products__item">';
                    call_user_func_array( 'wc_get_template_part', $this->template );
                    echo '</div>';

                    // Restore product visibility.
                    remove_action( 'woocommerce_product_is_visible', [ $this, 'set_product_as_visible' ] );
                }

                echo '</div><!-- ./compare-products__row -->';

                $compare_attributes = $this->gather_attributes( $products->ids );
                $compare_attributes = apply_filters( 'bono_compare_attributes', $compare_attributes );

                $rows = [];
                foreach ( $compare_attributes as $product_id => $attributes ) {
                    foreach ( $attributes as $code => $attribute ) {
                        $rows[ $code ][ $product_id ] = $attribute;
                    }
                }

                foreach ( $rows as $row ) {
                    echo '<div class="compare-products__row">';
                    $item = current( $row );

                    $label = ! empty( $item['label'] )
                        ? $item['label']
                        : apply_filters( 'bono_compare_attributes:empty_label', '—' );

                    echo '<div class="compare-products__item compare-products__item-header">' . $label . '</div>';

                    foreach ( $row as $key => $item ) {
                        echo '<div class="compare-products__item">' . $item['value'] . '</div>';
                    }
                    echo '</div><!-- ./compare-products__row -->';
                }

                echo '</div><!-- ./compare-products -->';
            }


            $GLOBALS['post'] = $original_post; // WPCS: override ok.
            woocommerce_product_loop_end();

            do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

            wp_reset_postdata();
            wc_reset_loop();
        } else {
            do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
        }

        return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . ob_get_clean() . '</div>';
    }

    /**
     * @param array $ids
     *
     * @return array
     * @see wc_display_product_attributes()
     */
    protected function gather_attributes( $ids ) {
        $all_product_attributes = [];

        $attr_keys = [];
        foreach ( $ids as $product_id ) {

            $product            = wc_get_product( $product_id );
            $product_attributes = [];

            $attr_keys['price']          = __( 'Price', 'woocommerce' );
            $product_attributes['price'] = [
                'label' => __( 'Price', 'woocommerce' ),
                'value' => '<span class="price">' . $product->get_price_html() . '</span>',
            ];


            $display_dimensions = apply_filters(
                'wc_product_enable_dimensions_display',
                $product->has_weight() || $product->has_dimensions()
            );

            if ( $display_dimensions && $product->has_weight() ) {
                $attr_keys['weight']          = __( 'Weight', 'woocommerce' );
                $product_attributes['weight'] = [
                    'label' => __( 'Weight', 'woocommerce' ),
                    'value' => wc_format_weight( $product->get_weight() ),
                ];
            }
            if ( $display_dimensions && $product->has_dimensions() ) {
                $attr_keys['dimensions']          = __( 'Dimensions', 'woocommerce' );
                $product_attributes['dimensions'] = [
                    'label' => __( 'Dimensions', 'woocommerce' ),
                    'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
                ];
            }

            $attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );

            foreach ( $attributes as $attribute ) {
                $values = [];

                if ( $attribute->is_taxonomy() ) {
                    $attribute_taxonomy = $attribute->get_taxonomy_object();
                    $attribute_values   = wc_get_product_terms(
                        $product->get_id(),
                        $attribute->get_name(),
                        [ 'fields' => 'all' ]
                    );

                    foreach ( $attribute_values as $attribute_value ) {
                        $value_name = esc_html( $attribute_value->name );

                        if ( $attribute_taxonomy->attribute_public ) {
                            $values[] = sprintf(
                                '<a href="%s" rel="tag">%s</a>',
                                esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ),
                                $value_name
                            );
                        } else {
                            $values[] = $value_name;
                        }
                    }
                } else {
                    $values = $attribute->get_options();

                    foreach ( $values as &$value ) {
                        $value = make_clickable( esc_html( $value ) );
                    }
                }

                $key               = 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() );
                $label             = wc_attribute_label( $attribute->get_name() );
                $attr_keys[ $key ] = wc_attribute_label( $attribute->get_name() );

                $product_attributes[ $key ] = [
                    'label' => $label,
                    'value' => wptexturize( implode( ', ', $values ) ),
                ];
            }

            $additional_product_attributes = apply_filters(
                'bono_compare_products:additional_product_attributes', [],
                $product, $product_attributes, $attr_keys
            );
            foreach ( $additional_product_attributes as $key => $data ) {
                if ( ! empty( $data['label'] ) ) {
                    $attr_keys[ $key ]          = $data['label'];
                    $product_attributes[ $key ] = $data;
                }
            }

            $all_product_attributes[ $product->get_id() ] = $product_attributes;
        }

        $result = [];
        foreach ( $all_product_attributes as $id => $attributes ) {
            $ordered_attributes = [];
            foreach ( $attr_keys as $key => $label ) {
                if ( isset( $attributes[ $key ] ) ) {
                    $ordered_attributes[ $key ] = $attributes[ $key ];
                } else {
                    $ordered_attributes[ $key ] = [
                        'label' => $label,
                        'value' => apply_filters( 'bono_compare_attributes:empty_value', '—' ),
                    ];
                }
            }

            $result[ $id ] = $ordered_attributes;
        }

        return $result;
    }
}
