<?php

namespace Wpshop\Core;

/**
 * Class Shortcodes
 *
 * 1.0.5    2020-12-26      Add param 'profiles' to social profiles shortcode
 * 1.0.4    2020-06-04      Edit output attribute style for button
 * 1.0.3    2019-09-29      Add shortcode current_year
 *                          Add method add_shortcode_support
 * 1.0.2    2019-08-13      Add base64encode url to [mask_link]
 * 1.0.1    2019-05-18      Add shortcode social_profiles
 * 1.0.0
 */
class Shortcodes {


    protected $options;


    public function __construct( ThemeOptions $options ) {
        $this->options = $options;
    }


    public function init_shortcode( $shortcode = '' ) {
        if ( empty( $shortcode ) ) {
            return;
        }
        if ( ! method_exists( $this, 'shortcode_' . $shortcode ) ) {
            return;
        }
        add_shortcode( $shortcode, [ $this, 'shortcode_' . $shortcode ] );
    }


    public function shortcode_current_year() {
        return date( 'Y' );
    }


    public function shortcode_button( $atts, $content ) {
        $atts = shortcode_atts( [
            'href'             => '',
            'hide_link'        => '',
            'background_color' => '',
            'color'            => '',
            'size'             => '',
            'target'           => '',
        ], $atts, 'button' );

        $href             = esc_attr( $atts['href'] );
        $hide_link        = esc_attr( $atts['hide_link'] );
        $background_color = esc_attr( $atts['background_color'] );
        $color            = esc_attr( $atts['color'] );
        $size             = esc_attr( $atts['size'] );
        $target           = esc_attr( $atts['target'] );

        $background_color_style = ( ! empty( $background_color ) ) ? 'background-color:' . $background_color . ';' : '';
        $color_style            = ( ! empty( $color ) ) ? 'color:' . $color . ';' : '';

        if ( ! empty( $background_color_style ) || ! empty( $color_style ) ) {
            $button_styles = ' style="' . $background_color_style . $color_style . '"';
        } else {
            $button_styles = '';
        }

        $out = '';
        $out .= '<div class="btn-box">';
        if ( $hide_link != 'yes' ) {
            $out .= '<a href="' . $href . '" class="btn btn-size-' . $size . '"' . $button_styles . ' target="' . $target . '">' . $content . '</a>';
        } else {
            $out .= '<span data-href="' . base64_encode( $href ) . '" class="btn btn-size-' . $size . ' js-link"' . $button_styles . ' data-target="' . $target . '">' . $content . '</span>';
        }
        $out .= '</div>';

        return $out;
    }


    public function shortcode_spoiler( $atts, $content ) {
        $atts = shortcode_atts( [
            'title' => __( 'Show hidden content', $this->options->text_domain ),
        ], $atts, 'spoiler' );

        $title = esc_attr( $atts['title'] );

        $out = '';
        $out .= '<div class="spoiler-box">';
        $out .= '<div class="spoiler-box__title js-spoiler-box-title">' . $title . '</div>';
        $out .= '<div class="spoiler-box__body">' . do_shortcode( $content ) . '</div>';
        $out .= '</div>';

        return $out;
    }


    /**
     * Mask link
     *
     * @param $atts
     * @param $content
     *
     * @return string
     */
    public function shortcode_mask_link( $atts, $content ) {
        $atts = shortcode_atts( [
            'href'   => '',
            'target' => '_blank',
        ], $atts, 'mask_link' );

        $href   = esc_attr( $atts['href'] );
        $target = esc_attr( $atts['target'] );


        // if href empty, but link exist in content
        if ( empty( $href ) && preg_match( '/<a/ui', $content ) ) {
            preg_match( '/<a (.*?)href=[\"\']([a-zA-Z]+:\/\/)?(.*?)[\"\'](.*?)>/', $content, $link_href );
            if ( ! empty( $link_href[2] ) && ! empty( $link_href[3] ) ) {
                $href = $link_href[2] . $link_href[3];
            }
        }


        $href    = do_shortcode( $href );
        $href    = htmlspecialchars_decode( $href );
        $href    = base64_encode( $href );
        $content = do_shortcode( $content );


        // remove all links in content
        $content = preg_replace( '/<a[^>]*>/i', '', $content );
        $content = preg_replace( '/<\/a>/i', '', $content );


        $out = '';
        $out .= '<span class="pseudo-link js-link" data-href="' . $href . '" data-target="' . $target . '" rel="noopener">' . $content . '</span>';

        return $out;
    }


    /**
     * Show social profiles links
     *
     * @param array  $atts
     * @param string $content
     *
     * @return string
     */
    public function shortcode_social_profiles( $atts, $content = '' ) {
        global $wpshop_social;
        global $wpshop_core;

        $atts = shortcode_atts( [
            'profiles' => '',
        ], $atts, 'social_profiles' );

        $social_profiles = apply_filters( 'wpshop_social_profiles', [
            'facebook',
            'vkontakte',
            'twitter',
            'odnoklassniki',
            'telegram',
            'youtube',
            'instagram',
            'linkedin',
            'whatsapp',
            'viber',
            'yandexzen',
        ] );

        if ( $atts['profiles'] ) {
            $atts_profiles   = wp_parse_list( $atts['profiles'] );
            $social_profiles = array_intersect( $social_profiles, $atts_profiles );
        }

        foreach ( $social_profiles as $social_profile ) {
            if ( $wpshop_core->get_option( 'social_' . $social_profile ) ) {
                $social_profile_links[ $social_profile ] = $wpshop_core->get_option( 'social_' . $social_profile );
            }
        }

        $out = '';

        if ( ! empty( $social_profile_links ) ) {

            $out .= '<div class="social-links">';
            $out .= '    <div class="social-buttons social-buttons--square social-buttons--circle">';
            $out .= $wpshop_social->social_profiles( $social_profile_links, true, false );
            $out .= '   </div>';
            $out .= '</div>';

        }

        return $out;
    }


    public function shortcode_helper( $content ) {
        return do_shortcode( shortcode_unautop( trim( $content ) ) );
    }


    public function add_shortcode_support() {

        // включить поддержку шорткодов в заголовках
        if ( apply_filters( $this->options->theme_slug . '_support_shortcode_the_title', true ) ) {
            add_filter( 'the_title', 'do_shortcode' );
            add_filter( 'single_post_title', 'do_shortcode' );
        }


        // включить поддержку шорткодов в описании рубрик
        if ( apply_filters( $this->options->theme_slug . '_support_shortcode_term_description', true ) ) {
            add_filter( 'term_description', 'shortcode_unautop' );
            add_filter( 'term_description', 'do_shortcode' );
        }


        // включить поддержку шорткодов в виджетах
        if ( apply_filters( $this->options->theme_slug . '_support_shortcode_widget_text', true ) ) {
            add_filter( 'widget_text', 'shortcode_unautop' );
            add_filter( 'widget_text', 'do_shortcode' );
        }


        // поддержка в плагине Yoast SEO
        if ( apply_filters( $this->options->theme_slug . '_support_shortcode_wpseo_title', true ) ) {
            add_filter( 'wpseo_title', 'do_shortcode' );
        }
        if ( apply_filters( $this->options->theme_slug . '_support_shortcode_wpseo_metadesc', true ) ) {
            add_filter( 'wpseo_metadesc', 'do_shortcode' );
        }

    }

}
