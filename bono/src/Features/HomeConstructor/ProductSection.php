<?php

namespace Wpshop\TheTheme\Features\HomeConstructor;

use WP_Post;
use WP_Query;

class ProductSection {

    /**
     * @param array $options
     *
     * @return int[]|WP_Post[]
     */
    public function get_products( $options ) {
        /**
         * Prepare query
         */
        $args = [
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'posts_per_page'      => 4,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'menu_order',
        ];

        if ( $tax_query = $this->get_tax_query( $options ) ) {
            $args['tax_query'] = $tax_query;
        }

        if ( ! empty( $options['post__not_in'] ) ) {
            $args['post__not_in'] = wp_parse_id_list( $options['post__not_in'] );
        }
        if ( ! empty( $options['post__in'] ) ) {
            $args['post__in'] = wp_parse_id_list( $options['post__in'] );
        }

        if ( ! empty( $options['posts_per_page'] ) ) {
            $args['posts_per_page'] = absint( $options['posts_per_page'] );
        }
        if ( ! empty( $options['offset'] ) ) {
            $args['offset'] = (int) $options['offset'];
        }

        $args = apply_filters( 'bono_section_product_query_args', $args, $options );

        $query = new WP_Query( $args );

        return $query->get_posts();
    }

    /**
     * @param array $options
     *
     * @return array
     * @see WC_Query::get_tax_query()
     */
    protected function get_tax_query( $options ) {
        $product_visibility_terms  = wc_get_product_visibility_term_ids();
        $product_visibility_not_in = [
            is_search()
                ? $product_visibility_terms['exclude-from-search']
                : $product_visibility_terms['exclude-from-catalog'],
        ];

        if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
        }

        $tax_query = [];
        if ( ! empty( $product_visibility_not_in ) ) {
            $tax_query[] = [
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => $product_visibility_not_in,
                'operator' => 'NOT IN',
            ];
        }
        if ( ! empty( $options['cat'] ) ) {
            $tax_query[] = [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => implode( ',', wp_parse_id_list( $options['cat'] ) ),
                'operator' => 'IN',

            ];
        }

        return $tax_query;
    }
}
