<?php

namespace Wpshop\TheTheme\Features;

use Wpshop\Core\Core;

class HomeConstructor {

    const SECTION_TYPE_POSTS      = 'posts';
    const SECTION_TYPE_PRODUCTS   = 'products';
    const SECTION_TYPE_CATEGORIES = 'categories';
    const SECTION_TYPE_HTML       = 'html';
    const SECTION_TYPE_SLIDER     = 'slider';

    const HTML_WIDGET_ID          = 'homepage-construct-html';
    const HTML_WIDGET_PLACEHOLDER = '{{homepage_construct_widget}}';

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var array|null
     */
    protected $_sections;

    /**
     * HomeConstructor constructor.
     *
     * @param Core $core
     */
    public function __construct( Core $core ) {
        $this->core = $core;
    }

    /**
     * @return void
     */
    public function init() {
        register_sidebar( [
            'id'            => self::HTML_WIDGET_ID,
            'name'          => esc_html__( 'Home Page Constructor Widget', THEME_TEXTDOMAIN ),
            'description'   => sprintf(
                esc_html__( 'to output this widget area place %s in homepage constructor HTML block', THEME_TEXTDOMAIN ),
                self::HTML_WIDGET_PLACEHOLDER
            ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="widget-header">',
            'after_title'   => '</div>',
        ] );

        $this->setup_default_hooks();

        do_action( __METHOD__, $this );
    }

    /**
     * @return void
     */
    protected function setup_default_hooks() {
        add_filter( 'bono_output_homepage_constructor_section', function ( $result, $section ) {
            if ( $section['section_type'] === self::SECTION_TYPE_SLIDER &&
                 ! empty( $section['disable_on_mobile'] ) &&
                 wp_is_mobile()
            ) {
                $result = false;
            }

            return $result;
        }, 10, 2 );

        add_filter( 'bono_home_page_constructor_section', function ( $section ) {
            if ( $section['section_type'] === self::SECTION_TYPE_HTML &&
                 false !== mb_strpos( $section['html_code'], self::HTML_WIDGET_PLACEHOLDER, 0, 'UTF-8' )
            ) {
                ob_start();
                ob_implicit_flush( false );
                get_template_part( 'template-parts/sections/html-widget' );
                $widget = ob_get_clean();

                $section['html_code'] = str_replace( self::HTML_WIDGET_PLACEHOLDER, $widget, $section['html_code'] );
            }

            return $section;
        } );

        add_filter( 'bono_homepage_constructor:section_category:list', [ $this, 'filter_category_list' ], 10, 2 );
    }

    /**
     * @param string|array|null $specific section_type one of <pre>HomeConstructor::SECTION_TYPE_*</pre>
     * @param bool              $revert   revert specific filter
     *
     * @return array
     */
    public function get_sections( $specific = null, $revert = false ) {
        $sections = $this->get_all_sections();
        if ( $specific ) {
            return array_filter( $sections, function ( $item ) use ( $specific, $revert ) {
                $result = is_array( $specific )
                    ? in_array( $item['section_type'], $specific, true )
                    : $item['section_type'] === $specific;

                return $revert ? ! $result : $result;
            } );
        }

        return $sections;
    }

    /**
     * @return bool
     */
    public function do_output_constructor() {
        return apply_filters(
            'bono_do_output_constructor',
            ( is_front_page() || is_home() ) && ! $this->is_blog_page() && $this->has_sections()
        );
    }

    /**
     * @return void
     */
    public function output() {
        do_action( 'bono_before_output_homepage_constructor' );

        foreach ( $this->get_sections() as $section ) {
            if ( ! apply_filters( 'bono_output_homepage_constructor_section', true, $section ) ) {
                continue;
            }

            $section = apply_filters( 'bono_home_page_constructor_section', $section );

            do_action( 'bono_before_output_homepage_constructor_section', $section );

            $section_type = ( ! empty( $section['section_type'] ) ) ? $section['section_type'] : 'posts';
            set_query_var( 'section_options', $section );
            get_template_part( 'template-parts/sections/' . $section_type );

            do_action( 'bono_after_output_homepage_constructor_section', $section );
        }

        do_action( 'bono_after_output_homepage_constructor' );
    }

    /**
     * @return bool
     */
    public function is_blog_page() {
        $show_on_front  = get_option( 'show_on_front' );
        $page_for_posts = get_option( 'page_for_posts' );

        return $show_on_front === 'page' &&
               $page_for_posts &&
               get_queried_object_id() == $page_for_posts;
    }

    /**
     * @return bool
     */
    public function has_sections() {
        return boolval( count( $this->get_all_sections() ) );
    }

    /**
     * @return array
     */
    protected function get_all_sections() {
        if ( null === $this->_sections ) {
            if ( $data = $this->core->get_option( 'home_constructor' ) ) {
                $this->_sections = json_decode( $data, true );
            } else {
                $this->_sections = [];
            }
        }

        return $this->_sections;
    }

    /**
     * @param $ids
     *
     * @return \WP_Term[]
     * @todo move to dedicated class
     */
    public function get_categories( array $ids = [] ) {
        $args = apply_filters( 'bono_section_category_query_args', [
            'taxonomy'     => 'product_cat',
            'hide_empty'   => 0,
            'hierarchical' => 0,
            'orderby'      => 'include',
            'include'      => $ids,
        ] );

        $args = apply_filters( 'bono_homepage_constructor:section_category:args', $args );

        return (array) apply_filters( 'bono_homepage_constructor:section_category:list', null, $args );
    }

    /**
     * @param array|null $items
     * @param array      $args
     *
     * @return \WP_Term[]
     */
    public function filter_category_list( array $items = null, array $args = [] ) {
        return null === $items ? get_categories( $args ) : $items;
    }
}
