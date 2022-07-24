<?php

namespace Wpshop\TheTheme;

class WcHelper {

    /**
     * @param int $id
     *
     * @return array
     * @see get_the_category();
     */
    protected function retrieve_categories( $id ) {
        $terms = get_the_terms( $id, 'product_cat' );

        $categories = array_values( $terms );

        foreach ( array_keys( $categories ) as $key ) {
            _make_cat_compat( $categories[ $key ] );
        }

        return $categories;
    }

    /**
     * @param $cat_id
     *
     * @return string
     * @see get_cat_name()
     */
    protected function get_category_name( $cat_id ) {
        $cat_id   = (int) $cat_id;
        $category = get_term( $cat_id, 'product_cat' );
        if ( ! $category || is_wp_error( $category ) ) {
            return '';
        }

        return $category->name;
    }

    /**
     * @param array $args
     *
     * @return bool|string
     */
    public function get_product_category( $args = [] ) {
        $defaults = [
            'post'      => '',
            'classes'   => '',
            'micro'     => true,
            'micro_out' => ' itemprop="articleSection"',
            'link'      => true,
        ];
        $args     = wp_parse_args( $args, $defaults );

        if ( is_array( $args ) ) {
            $post = $args['post'];
        } else {
            $post = null;
        }

        if ( ! $post = get_post( $post ) ) {
            return false;
        }

        $classes_out = '';
        if ( ! empty( $args['classes'] ) ) {
            $classes_out = ' class="' . $args['classes'] . '"';
        }

        $category = $this->retrieve_categories( $post->ID );
        $cat_id   = $category[0]->cat_ID;

        if ( class_exists( '\WPSEO_Primary_Term' ) ) {
            $primary_cat = new \WPSEO_Primary_Term( 'category', $post->ID );
            $primary_cat = $primary_cat->get_primary_term();
            if ( $primary_cat ) {
                $cat_id = $primary_cat;
            }
        }

        if ( $args['micro'] ) {
            $micro_out = $args['micro_out'];
        } else {
            $micro_out = '';
        }

        if ( $args['link'] ) {
            return '<a href="' . get_category_link( $cat_id ) . '"' . $micro_out . $classes_out . '>' . $this->get_category_name( $cat_id ) . '</a>';
        } else {
            return '<span' . $micro_out . $classes_out . '>' . $this->get_category_name( $cat_id ) . '</span>';
        }
    }
}
