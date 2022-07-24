<?php

namespace Wpshop\TheTheme\Features;

use DOMDocument;
use WC_Product;

class ProductMicroData {

    /**
     * @return void
     */
    public function init() {
        add_action( 'woocommerce_after_single_product', [ $this, 'on_after_single_product' ] );
    }

    /**
     * @return void
     */
    public function on_after_single_product() {
        /**
         * @var $product WC_Product
         */
        global $product;

        if ( ! $product ) {
            return;
        }

        $doc               = new DOMDocument();
        $doc->formatOutput = defined( 'WP_DEBUG' ) && WP_DEBUG;

        $doc->appendChild( $main = $doc->createElement( 'div' ) );

        $main->setAttribute( 'itemtype', 'http://schema.org/Product' );
        $main->appendChild( $doc->createAttribute( 'itemscope' ) );
        $main->setAttribute( 'style', 'display:none' );

        // name
        $main->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'name' );
        $meta->setAttribute( 'content', $product->get_title() );
        // @todo add brand support
        // description
        $main->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'description' );
        $meta->setAttribute( 'content', wp_strip_all_tags( do_shortcode( $product->get_description() ) ) );
        // sku
        $main->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'sku' );
        $meta->setAttribute( 'content', $product->get_sku() );
        // images
        foreach ( $this->get_images( $product ) as $src ) {
            $main->appendChild( $link = $doc->createElement( 'link' ) );
            $link->setAttribute( 'itemprop', 'image' );
            $link->setAttribute( 'href', $src );
        }

        // offers
        $main->appendChild( $offers = $doc->createElement( 'div' ) );
        $offers->setAttribute( 'itemprop', 'offers' );
        $offers->setAttribute( 'itemtype', 'http://schema.org/Offer' );
        $offers->appendChild( $doc->createAttribute( 'itemscope' ) );
        // url
        $offers->appendChild( $link = $doc->createElement( 'link' ) );
        $link->setAttribute( 'itemprop', 'url' );
        $link->setAttribute( 'href', get_permalink( $product->get_id() ) );
        // availability
        $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'availability' );
        $meta->setAttribute( 'content', $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' );
        // priceCurrency
        $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'priceCurrency' );
        $meta->setAttribute( 'content', get_woocommerce_currency() );
        // itemCondition
        $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'itemCondition' );
        $meta->setAttribute( 'content', 'https://schema.org/UsedCondition' );

        // price
        $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
        $meta->setAttribute( 'itemprop', 'price' );
        $meta->setAttribute( 'content', $product->get_price() );
        if ( $product->is_type( 'variable' ) ) {
            $available_variations = $product->get_available_variations();
            $max_price            = null;
            $min_price            = null;
            $offer_count          = 0;
            for ( $i = 0 ; $i < count( $available_variations ) ; ++ $i ) {
                $variation_id     = $available_variations[ $i ]['variation_id'];
                $variable_product = new \WC_Product_Variation( $variation_id );

                $offer_count ++;

                $price = $variable_product->get_regular_price();
                if ( null === $max_price || $price > $max_price ) {
                    $max_price = $price;
                }
                if ( null === $min_price || $price < $min_price ) {
                    $min_price = $price;
                }
            }
            $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
            $meta->setAttribute( 'itemprop', 'offerCount' );
            $meta->setAttribute( 'content', $offer_count );
            $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
            $meta->setAttribute( 'itemprop', 'highPrice' );
            $meta->setAttribute( 'content', $max_price );
            $offers->appendChild( $meta = $doc->createElement( 'meta' ) );
            $meta->setAttribute( 'itemprop', 'lowPrice' );
            $meta->setAttribute( 'content', $min_price );
        }

        if ( $product->get_review_count() && wc_review_ratings_enabled() ) {
            $main->appendChild( $avgRating = $doc->createElement( 'div' ) );
            $avgRating->setAttribute( 'itemprop', 'aggregateRating' );
            $avgRating->setAttribute( 'itemtype', 'http://schema.org/AggregateRating' );
            $avgRating->appendChild( $doc->createAttribute( 'itemscope' ) );
            // review count
            $avgRating->appendChild( $meta = $doc->createElement( 'meta' ) );
            $meta->setAttribute( 'itemprop', 'reviewCount' );
            $meta->setAttribute( 'content', $product->get_review_count() );
            // rating value
            $avgRating->appendChild( $meta = $doc->createElement( 'meta' ) );
            $meta->setAttribute( 'itemprop', 'ratingValue' );
            $meta->setAttribute( 'content', $product->get_average_rating() );

            /** @var \WP_Comment[] $comments */
            $comments = get_comments( apply_filters( 'bono_product_microdata_comments_args', [
                'post_id' => $product->get_id(),
                'orderby' => 'comment_date_gmt',
                'order'   => 'ASC',
                'status'  => 'approve',
                'number'  => 5,
            ] ) );

            foreach ( $comments as $comment ) {
                $main->appendChild( $review = $doc->createElement( 'div' ) );
                $review->setAttribute( 'itemprop', 'review' );
                $review->setAttribute( 'itemtype', 'http://schema.org/Review' );
                $review->appendChild( $doc->createAttribute( 'itemscope' ) );

                $review->appendChild( $person = $doc->createElement( 'div' ) );
                $person->setAttribute( 'itemprop', 'author' );
                $person->setAttribute( 'itemtype', 'http://schema.org/Person' );
                $person->appendChild( $doc->createAttribute( 'itemscope' ) );

                $person->appendChild( $meta = $doc->createElement( 'meta' ) );
                $meta->setAttribute( 'itemprop', 'name' );
                $meta->setAttribute( 'content', $comment->comment_author );

                $review->appendChild( $reviewRate = $doc->createElement( 'div' ) );
                $reviewRate->setAttribute( 'itemprop', 'reviewRating' );
                $reviewRate->setAttribute( 'itemtype', 'http://schema.org/Rating' );
                $reviewRate->appendChild( $doc->createAttribute( 'itemscope' ) );

                $reviewRate->appendChild( $meta = $doc->createElement( 'meta' ) );
                $meta->setAttribute( 'itemprop', 'ratingValue' );
                $meta->setAttribute( 'content', intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) );
                $reviewRate->appendChild( $meta = $doc->createElement( 'meta' ) );
                $meta->setAttribute( 'itemprop', 'bestRating' );
                $meta->setAttribute( 'content', 5 );
                $reviewRate->appendChild( $meta = $doc->createElement( 'meta' ) );
                $meta->setAttribute( 'itemprop', 'worstRating' );
                $meta->setAttribute( 'content', 1 );

                $review->appendChild( $meta = $doc->createElement( 'div', wp_strip_all_tags( $comment->comment_content ) ) );
                $meta->setAttribute( 'itemprop', 'reviewBody' );
                $review->appendChild( $meta = $doc->createElement( 'meta' ) );
                $meta->setAttribute( 'itemprop', 'datePublished' );
                $meta->setAttribute( 'content', $comment->comment_date );
            }
        }

        /** @var DOMDocument $doc */
        if ( $doc = apply_filters( 'bono_product_microdata_doc', $doc, $product ) ) {
            echo '<!-- product microdata -->' . PHP_EOL;
            echo $doc->saveHTML() . PHP_EOL;
            echo '<!-- /product microdata -->' . PHP_EOL;
        }
    }

    /**
     * @param WC_Product $product
     *
     * @return array
     */
    protected function get_images( $product ) {
        $result       = [];
        $images_sizes = apply_filters( 'bono_product_microdata_image_sizes', [
            'woocommerce_single',
            'woocommerce_thumbnail',
        ] );
        foreach ( $images_sizes as $size ) {
            $src = null;
            if ( $product->get_image_id() ) {
                $src = wp_get_attachment_image_src( $product->get_image_id(), $size );
            } elseif ( $product->get_parent_id() && ( $parent = wc_get_product( $product->get_parent_id() ) ) ) {
                $src = wp_get_attachment_image_src( $parent->get_image_id(), $size );
            }
            if ( isset( $src[0] ) ) {
                $result[] = $src[0];
            }
        }

        return $result;
    }
}
