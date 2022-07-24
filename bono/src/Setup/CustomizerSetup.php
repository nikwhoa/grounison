<?php

namespace Wpshop\TheTheme\Setup;

use WP_Customize_Manager;
use Wpshop\Core\Core;
use Wpshop\Core\Customizer\Control\SortableCheckboxes;
use Wpshop\Core\Customizer\Customizer as CoreCustomizer;
use Wpshop\Core\Customizer\CustomizerCSS;
use Wpshop\Core\Social;
use Wpshop\TheTheme\Customizer\Control\BonoPageConstructor;
use Wpshop\TheTheme\Customizer\Control\DocLink;
use Wpshop\TheTheme\Customizer\Control\TextArea;
use Wpshop\TheTheme\ProductTabs;
use Wpshop\TheTheme\Sidebar;
use Wpshop\TheTheme\ThemeOptions;

class CustomizerSetup {

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var CoreCustomizer
     */
    protected $customizer;

    /**
     * @var Social
     */
    protected $social;

    /**
     * @var ThemeOptions
     */
    protected $themeOptions;

    /**
     * @var Sidebar
     */
    protected $sidebar;

    /**
     * @var ThemeOptions
     */
    protected $theme_options;

    /**
     * CustomizerSetup constructor.
     *
     * @param Core           $core
     * @param CoreCustomizer $customizer
     * @param Social         $social
     * @param Sidebar        $sidebar
     * @param ThemeOptions   $theme_options
     */
    public function __construct(
        Core $core,
        CoreCustomizer $customizer,
        Social $social,
        Sidebar $sidebar,
        ThemeOptions $theme_options
    ) {
        $this->core          = $core;
        $this->customizer    = $customizer;
        $this->social        = $social;
        $this->sidebar       = $sidebar;
        $this->theme_options = $theme_options;
    }

    /**
     * @return void
     */
    public function init() {
        $this->core->set_default_options( $this->getDefaultOptions() );

        $this->update_wc_defaults();

        add_action( 'customize_register', [ $this, '_register' ] );
        add_action( 'customize_register', [ $this, 'on_customize_register' ] );
        add_action( 'wp_head', [ $this, '_style' ] );
        add_filter( 'body_class', [ $this, '_body_class' ] );
        add_action( 'customize_preview_init', [ $this, '_js' ] );

        add_filter( 'woocommerce_product_tabs', [
            theme_container()->get( ProductTabs::class ),
            'prepare_product_tabs',
        ], 90 );

        add_filter( 'wpshop_breadcrumbs_home_text', function ( $string ) {
            if ( $text = trim( $this->core->get_option( 'breadcrumbs_home_text' ) ) ) {
                return $text;
            }

            return $string;
        } );
        add_filter( 'wpshop_breadcrumb_single_link', function () {
            return $this->core->get_option( 'breadcrumbs_single_link' );
        } );

        add_action( 'wp_head', function () {
            if ( $this->core->get_option( 'header_menu_fixed' ) ) {
                echo "<script>var fixed_main_menu = 'yes';</script>";
            }
        } );

        add_filter( 'bono_site_content_classes', function ( $classes = '' ) {
            if ( $this->core->get_option( 'content_full_width' ) ) {
                return '';
            }

            return $classes;
        } );

        add_filter( 'bono_social_share_title', function ( $title ) {
            if ( $opt_title = $this->core->get_option( 'social_share_title' ) ) {
                return $opt_title;
            }

            return $title;
        } );

        add_filter( 'bono_single_social_share_title_show', function () {
            return $this->core->get_option( 'single_social_share_title_show' );
        } );
        add_filter( 'bono_page_social_share_title_show', function () {
            return $this->core->get_option( 'page_social_share_title_show' );
        } );

        add_filter( 'bono_single_rating_title', function ( $title ) {
            if ( $opt_title = $this->core->get_option( 'single_rating_title' ) ) {
                return $opt_title;
            }

            return $title;
        } );
        add_filter( 'bono_page_rating_title', function ( $title ) {
            if ( $opt_title = $this->core->get_option( 'page_rating_title' ) ) {
                return $opt_title;
            }

            return $title;
        } );
        add_filter( 'bono_rating_text_show', function () {
            return $this->core->get_option( 'rating_text_show' );
        } );

        add_filter( 'bono_related_title', function ( $title ) {
            if ( $opt_title = $this->core->get_option( 'related_posts_title' ) ) {
                return $opt_title;
            }

            return $title;
        } );

        add_filter( 'wpshop_sitemap_show_pages', function () {
            return $this->core->get_option( 'sitemap_pages_show' );
        } );

        add_filter( 'wpshop_microdata_publisher_telephone', function ( $result ) {
            if ( $phone = $this->core->get_option( 'microdata_publisher_telephone' ) ) {
                return $phone;
            }

            return $result;
        } );
        add_filter( 'wpshop_microdata_publisher_address', function ( $result ) {
            if ( $phone = $this->core->get_option( 'microdata_publisher_address' ) ) {
                return $phone;
            }

            return $result;
        } );

        add_filter( 'wpshop_advertising_single', function () {
            return ! $this->core->get_option( 'advertising_page_display' );
        } );

        add_filter( 'woocommerce_checkout_fields', [ $this, '_hide_address_fields' ], 25 );

        add_filter( 'bono_do_output_constructor', [ $this, '_do_output_constructor' ] );

        do_action( __METHOD__, $this );
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    public function _hide_address_fields( $fields ) {
        if ( $this->core->get_option( 'hide_address_fields' ) ) {
            unset( $fields['billing']['billing_company'] );
            unset( $fields['billing']['billing_country'] );
            unset( $fields['billing']['billing_address_1'] );
            unset( $fields['billing']['billing_address_2'] );
            unset( $fields['billing']['billing_city'] );
            unset( $fields['billing']['billing_state'] );
            unset( $fields['billing']['billing_postcode'] );
            //unset( $fields['order']['order_comments'] );
        }

        return $fields;
    }

    /**
     * @param bool $result
     *
     * @return bool
     */
    public function _do_output_constructor( $result ) {
        return $result && $this->core->get_option( 'home_constructor_enabled' );
    }

    /**
     * @return void
     */
    protected function update_wc_defaults() {
        add_filter( 'customize_dynamic_setting_args', function ( $args, $id ) {
            if ( $id === 'woocommerce_catalog_rows' ) {
                $args['default'] = 3;
            }

            return $args;
        }, 10, 2 );
    }

    /**
     * Add additional option for WooCommerce section
     *
     * @param WP_Customize_Manager $manager
     *
     * @return void
     */
    public function on_customize_register( WP_Customize_Manager $manager ) {
        $configure_setting = function ( $name, array $setting_args, array $control_args ) use ( $manager ) {
            $name = "{$this->theme_options->option_name}[{$name}]";
            $manager->add_setting( $name, wp_parse_args( $setting_args, [
                'type' => 'option',
            ] ) );
            if ( class_exists( $control_args['type'] ) ) {
                $class = $control_args['type'];
                unset( $control_args['type'] );
                $manager->add_control( new $class( $manager, $name, $control_args ) );
            } else {
                $manager->add_control( $name, $control_args );
            }
        };

        $sidebar_position = [
            'none'  => _x( 'Don\'t show', 'sidebar position', THEME_TEXTDOMAIN ),
            'right' => _x( 'Right', 'sidebar position', THEME_TEXTDOMAIN ),
            'left'  => _x( 'Left', 'sidebar position', THEME_TEXTDOMAIN ),
        ];

        $sidebars        = [];
        $sidebar_widgets = min( max( 1, absint( $this->core->get_option( 'sidebar_widgets' ) ) ), 5 );
        for ( $n = 1 ; $n <= $sidebar_widgets ; $n ++ ) {
            $sidebars["sidebar-{$n}"] = sprintf( __( 'Sidebar %d', THEME_TEXTDOMAIN ), $n );
        }


        /**
         * Category
         */
        $manager->add_section(
            'bono_categories',
            [
                'title'    => _x( 'Category', 'wc', THEME_TEXTDOMAIN ),
                'priority' => 25,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'sidebar_on_shop_category', [
            'default'           => 'none',
            'sanitize_callback' => function ( $value ) use ( $sidebar_position ) {
                return array_key_exists( $value, $sidebar_position ) ? $value : 'none';
            },
        ], [
            'label'   => __( 'Show Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_categories',
            'type'    => 'select',
            'choices' => $sidebar_position,
        ] );
        $configure_setting( 'sidebar_on_shop_category_type', [
            'default'           => 'sidebar-2',
            'sanitize_callback' => function ( $value ) use ( $sidebars ) {
                return array_key_exists( $value, $sidebars ) ? $value : 'sidebar-1';
            },
        ], [
            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_categories',
            'type'    => 'select',
            'choices' => $sidebars,
        ] );

        /**
         * Shop
         */
        $manager->add_section(
            'bono_shop',
            [
                'title'    => __( 'Shop', THEME_TEXTDOMAIN ),
                'priority' => 30,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'sidebar_on_shop', [
            'default'           => 'none',
            'sanitize_callback' => function ( $value ) use ( $sidebar_position ) {
                return array_key_exists( $value, $sidebar_position ) ? $value : 'none';
            },
        ], [
            'label'   => __( 'Show Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_shop',
            'type'    => 'select',
            'choices' => $sidebar_position,
        ] );
        $configure_setting( 'sidebar_on_shop_type', [
            'default'           => 'sidebar-2',
            'sanitize_callback' => function ( $value ) use ( $sidebars ) {
                return array_key_exists( $value, $sidebars ) ? $value : 'sidebar-1';
            },
        ], [
            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_shop',
            'type'    => 'select',
            'choices' => $sidebars,
        ] );

        /**
         * Product
         */
        $manager->add_section(
            'bono_product',
            [
                'title'    => __( 'Product', THEME_TEXTDOMAIN ),
                'priority' => 35,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'bono_wc_recently_viewed_columns', [
            'default'           => 4,
            'sanitize_callback' => 'absint',
        ], [
            'label'       => __( 'Recently Viewed Columns', THEME_TEXTDOMAIN ),
            'section'     => 'bono_product',
            'type'        => 'number',
            'input_attrs' => [ 'min' => 1, 'max' => 1000, 'step' => 1 ],
        ] );
        $configure_setting( 'bono_wc_recently_viewed_limit', [
            'default'           => 4,
            'sanitize_callback' => 'absint',
        ], [
            'label'       => __( 'Recently Viewed Limit', THEME_TEXTDOMAIN ),
            'section'     => 'bono_product',
            'type'        => 'number',
            'input_attrs' => [ 'min' => 1, 'max' => 1000, 'step' => 1 ],
        ] );
        $configure_setting( 'sidebar_on_product', [
            'default'           => 'none',
            'sanitize_callback' => function ( $value ) use ( $sidebar_position ) {
                return array_key_exists( $value, $sidebar_position ) ? $value : 'none';
            },
        ], [
            'label'   => __( 'Show Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_product',
            'type'    => 'select',
            'choices' => $sidebar_position,
        ] );
        $configure_setting( 'sidebar_on_product_type', [
            'default'           => 'sidebar-2',
            'sanitize_callback' => function ( $value ) use ( $sidebars ) {
                return array_key_exists( $value, $sidebars ) ? $value : 'sidebar-1';
            },
        ], [
            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_product',
            'type'    => 'select',
            'choices' => $sidebars,
        ] );

        $product_tabs_appearance = [
            'horizontal'   => _x( 'Horizontal', 'customizer', THEME_TEXTDOMAIN ),
            'vertical'     => _x( 'Vertical', 'customizer', THEME_TEXTDOMAIN ),
            'successively' => _x( 'Successively', 'customizer', THEME_TEXTDOMAIN ),
        ];
        $product_tabs_order      = apply_filters( 'bono_customize_product_tabs', [
            'description'            => __( 'Description', 'woocommerce' ),
            'additional_information' => __( 'Additional information', 'woocommerce' ),
            'reviews'                => __( 'Reviews', 'woocommerce' ),
        ] );
        $configure_setting( 'product_info_tabs_appearance', [
            'default'           => 'horizontal',
            'sanitize_callback' => function ( $value ) use ( $product_tabs_appearance ) {
                return array_key_exists( $value, $product_tabs_appearance ) ? $value : 'horizontal';
            },
        ], [
            'label'   => __( 'Tabs Appearance', THEME_TEXTDOMAIN ),
            'section' => 'bono_product',
            'type'    => 'select',
            'choices' => $product_tabs_appearance,
        ] );
        $configure_setting( 'product_description_wide_content', [
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'   => __( 'Description Wide Content', THEME_TEXTDOMAIN ),
            'section' => 'bono_product',
            'type'    => 'checkbox',
        ] );
        $configure_setting( 'product_info_tabs_order', [
            'default' => 'description,additional_information,reviews',
        ], [
            'label'   => __( 'Tabs Order', THEME_TEXTDOMAIN ),
            'section' => 'bono_product',
            'type'    => SortableCheckboxes::class,
            'choices' => $product_tabs_order,
        ] );

        $configure_setting( 'product_info_additional_tabs_behavior', [
            'default' => 'ignore',
        ], [
            'label'   => __( 'Additional Tabs', THEME_TEXTDOMAIN ),
            'section' => 'bono_product',
            'type'    => 'select',
            'choices' => [
                'ignore'  => __( 'Ignore', THEME_TEXTDOMAIN ),
                'prepend' => __( 'Prepend', THEME_TEXTDOMAIN ),
                'append'  => __( 'Append', THEME_TEXTDOMAIN ),
                'as_is'   => __( 'Order as Is', THEME_TEXTDOMAIN ),
            ],
        ] );

        /**
         * Product Cards
         */
        $manager->add_section(
            'bono_product_cards',
            [
                'title'    => __( 'Product Cards', THEME_TEXTDOMAIN ),
                'priority' => 35,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'product_cards_type', [
            'default' => 'standard',
        ], [
            'label'   => __( 'Card Type', THEME_TEXTDOMAIN ),
            'section' => 'bono_product_cards',
            'type'    => 'select',
            'choices' => [
//                'small'    => __( 'Small', THEME_TEXTDOMAIN ),
'standard' => __( 'Standard', THEME_TEXTDOMAIN ),
            ],
        ] );
//        $configure_setting( 'fix_add_to_cart_button', [
//            'sanitize_callback' => function ( $checked ) {
//                return ( isset( $checked ) && $checked );
//            },
//        ], [
//            'label'           => __( 'Fix Add to Cart Button', THEME_TEXTDOMAIN ),
//            'section'         => 'bono_product_cards',
//            'type'            => 'checkbox',
//            'active_callback' => function () {
//                return $this->core->get_option( 'product_cards_type' ) === 'standard';
//            },
//        ] );

        /**
         * Favorite
         */
        $manager->add_section(
            'bono_favorite',
            [
                'title'    => __( 'Favorite', THEME_TEXTDOMAIN ),
                'priority' => 45,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'favorite_enabled', [
            'default'           => true,
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'   => __( 'Enable Favorite', THEME_TEXTDOMAIN ),
            'section' => 'bono_favorite',
            'type'    => 'checkbox',
        ] );
        $configure_setting( 'favorite_counter_enabled', [
            'default'           => false,
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'   => __( 'Show Count Badge', THEME_TEXTDOMAIN ),
            'section' => 'bono_favorite',
            'type'    => 'checkbox',
        ] );
        $configure_setting( 'sidebar_on_favorite', [
            'default'           => 'none',
            'sanitize_callback' => function ( $value ) use ( $sidebar_position ) {
                return array_key_exists( $value, $sidebar_position ) ? $value : 'none';
            },
        ], [
            'label'   => __( 'Show Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_favorite',
            'type'    => 'select',
            'choices' => $sidebar_position,
        ] );
        $configure_setting( 'sidebar_on_favorite_type', [
            'default'           => 'sidebar-2',
            'sanitize_callback' => function ( $value ) use ( $sidebars ) {
                return array_key_exists( $value, $sidebars ) ? $value : 'sidebar-1';
            },
        ], [
            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_favorite',
            'type'    => 'select',
            'choices' => $sidebars,
        ] );

        /**
         * Compare products
         */
        $manager->add_section(
            'bono_compare',
            [
                'title'    => __( 'Compare Products', THEME_TEXTDOMAIN ),
                'priority' => 50,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'compare_products_enabled', [
            'default'           => true,
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'   => __( 'Enable Product Compare', THEME_TEXTDOMAIN ),
            'section' => 'bono_compare',
            'type'    => 'checkbox',
        ] );
        $configure_setting( 'compare_products_enable_counter', [
            'default'           => false,
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'   => __( 'Show Count Badge', THEME_TEXTDOMAIN ),
            'section' => 'bono_compare',
            'type'    => 'checkbox',
        ] );
        $configure_setting( 'compare_products_limit', [
            'default'           => 5,
            'sanitize_callback' => 'absint',
        ], [
            'label'       => __( 'Products Limit', THEME_TEXTDOMAIN ),
            'description' => __( 'limit of products available to add to compare', THEME_TEXTDOMAIN ),
            'section'     => 'bono_compare',
            'type'        => 'number',
        ] );
        $configure_setting( 'sidebar_on_compare', [
            'default'           => 'none',
            'sanitize_callback' => function ( $value ) use ( $sidebar_position ) {
                return array_key_exists( $value, $sidebar_position ) ? $value : 'none';
            },
        ], [
            'label'   => __( 'Show Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_compare',
            'type'    => 'select',
            'choices' => $sidebar_position,
        ] );
        $configure_setting( 'sidebar_on_compare_type', [
            'default'           => 'sidebar-2',
            'sanitize_callback' => function ( $value ) use ( $sidebars ) {
                return array_key_exists( $value, $sidebars ) ? $value : 'sidebar-1';
            },
        ], [
            'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
            'section' => 'bono_compare',
            'type'    => 'select',
            'choices' => $sidebars,
        ] );

        /**
         * Prices
         */
        $manager->add_section(
            'bono_prices',
            [
                'title'    => __( 'Prices', THEME_TEXTDOMAIN ),
                'priority' => 55,
                'panel'    => 'woocommerce',
            ]
        );
        $configure_setting( 'variable_price_with_from', [
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'       => __( 'Variable Price with From', THEME_TEXTDOMAIN ),
            'section'     => 'bono_prices',
            'type'        => 'checkbox',
            'description' => __( 'show price like "from 10$" instead of "10$ - 20$"', THEME_TEXTDOMAIN ),
        ] );
        $configure_setting( 'sale_flash_default', [
            'default' => __( 'Sale!', 'woocommerce' ),
        ], [
            'label'   => __( 'Sale Default Message', THEME_TEXTDOMAIN ),
            'section' => 'bono_prices',
            'type'    => 'text',
        ] );
        $configure_setting( 'sale_flash_price_format', [
            'default' => __( 'Discount -{{discount_percent}}%', THEME_TEXTDOMAIN ),
        ], [
            'label'       => __( 'Sale Price Format', THEME_TEXTDOMAIN ),
            'section'     => 'bono_prices',
            'type'        => 'text',
            'description' => __( 'Available variables: {{discount_percent}}, {{discount_value}}. Leave empty for default message', THEME_TEXTDOMAIN ),
        ] );


        $configure_setting( 'hide_address_fields', [
            'sanitize_callback' => function ( $checked ) {
                return ( isset( $checked ) && $checked );
            },
        ], [
            'label'   => __( 'Hide Address Fields', THEME_TEXTDOMAIN ),
            'section' => 'woocommerce_checkout',
            'type'    => 'checkbox',
        ] );
    }

    /**
     * @return array
     */
    public function _body_class( $classes ) {
        /**
         * Sidebar
         */
        $class = 'sidebar-show';
        if ( $this->sidebar->hide() ) {
            $class = 'sidebar-none';
        } elseif ( is_wc_enabled() ) {
            // Сайдбар на главной
            if ( bono_is_home_page() ) {
                $class = 'sidebar-' . $this->core->get_option( 'structure_home_sidebar' );
            }

            // Сайдбар в архивах
            if ( is_archive() ) {
                $class = 'sidebar-' . $this->core->get_option( 'structure_archive_sidebar' );
            }

            // Сайдбар записи
            if ( is_single() ) {
                $class = 'sidebar-' . $this->core->get_option( 'structure_single_sidebar' );
            }

            // Сайдбар страниц
            if ( is_page() ) {
                $class = 'sidebar-' . $this->core->get_option( 'structure_page_sidebar' );
            }

            if ( is_shop() ) {
                $class = 'sidebar-' . $this->core->get_option( 'sidebar_on_shop' );
            }

            if ( is_product() && ! $this->sidebar->is_hidden_in_post() ) {
                $class = 'sidebar-' . $this->core->get_option( 'sidebar_on_product' );
            }

            if ( is_product_category() ) {
                $class = 'sidebar-' . $this->core->get_option( 'sidebar_on_shop_category' );
            }

            if ( bono_is_favorite_page() ) {
                $class = 'sidebar-' . $this->core->get_option( 'sidebar_on_compare' );
            }

            if ( bono_is_compare_page() ) {
                $class = 'sidebar-' . $this->core->get_option( 'sidebar_on_compare' );
            }
        }

        $classes[] = $class;

        return $classes;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    protected function tooltip_link( $type = null ) {
        if ( $type ) {
            return 'https://support.wpshop.ru/faq/' . $type;
        }

        return 'https://support.wpshop.ru/fag_tag/bono/';
    }

    /**
     * @param WP_Customize_Manager $wpCustomizer
     *
     * @return void
     */
    public function _register( WP_Customize_Manager $wpCustomizer ) {
//        $post_card_animations = [
//            'no'         => 'No',
//            'fadein'     => 'fadein',
//            'fadeinup'   => 'fadeinup',
//            'fadeindown' => 'fadeindown',
//            'fadeinleft' => 'fadeinleft',
//            'zoomin'     => 'zoomin',
//            'zoomout'    => 'zoomout',
//        ];

        $post_card_order_meta = [
            'date'            => __( 'Date', THEME_TEXTDOMAIN ),
            'comments_number' => __( 'Comments number', THEME_TEXTDOMAIN ),
            'views'           => _x( 'Views', 'Hide elements', THEME_TEXTDOMAIN ),
            'author'          => __( 'Author', THEME_TEXTDOMAIN ),
            'category'        => __( 'Category', THEME_TEXTDOMAIN ),
        ];

        $post_card_types = [
            'vertical' => __( 'Vertical', THEME_TEXTDOMAIN ),
            'standard' => __( 'Standard', THEME_TEXTDOMAIN ),
        ];

        $sidebar_position = [
            'none'  => _x( 'Don\'t show', 'sidebar position', THEME_TEXTDOMAIN ),
            'right' => _x( 'Right', 'sidebar position', THEME_TEXTDOMAIN ),
            'left'  => _x( 'Left', 'sidebar position', THEME_TEXTDOMAIN ),
        ];

        $controls = [
            'layout'           => [
                'title'    => __( 'Layout', THEME_TEXTDOMAIN ),
                'priority' => 10,
                'sections' => [
                    'header'      => [
                        'title'    => __( 'Header', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'header_width'          => [
                                'label'   => __( 'Header width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'header_inner_width'    => [
                                'label'   => __( 'Header inner width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'header_padding_top'    => [
                                'label'       => __( 'Header padding top', THEME_TEXTDOMAIN ),
                                'type'        => 'range',
                                'sanitize'    => 'integer',
                                'description' => __( 'You can set padding top and bottom, ex. for background image.', THEME_TEXTDOMAIN ),
                                'input_attrs' => [ 'min' => 0, 'max' => 200, 'step' => 1 ],
                            ],
                            'header_padding_bottom' => [
                                'label'       => __( 'Header padding bottom', THEME_TEXTDOMAIN ),
                                'type'        => 'range',
                                'sanitize'    => 'integer',
                                'input_attrs' => [ 'min' => 0, 'max' => 200, 'step' => 1 ],
                            ],
                        ],
                    ],
                    'header_menu' => [
                        'title'    => __( 'Header menu', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'header_menu_width'       => [
                                'label'   => __( 'Header menu width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'header_menu_inner_width' => [
                                'label'   => __( 'Header menu inner width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'header_menu_fixed'       => [
                                'label' => __( 'Fixed menu', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                        ],
                    ],
                    'footer_menu' => [
                        'title'    => __( 'Footer menu', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'footer_menu_width'       => [
                                'label'   => __( 'Footer menu width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'footer_menu_inner_width' => [
                                'label'   => __( 'Footer menu inner width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'footer_menu_mob'         => [
                                'label' => __( 'Show menu on mobile', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                        ],
                    ],
                    'footer'      => [
                        'title'    => __( 'Footer', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'footer_width'       => [
                                'label'   => __( 'Footer width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'footer_inner_width' => [
                                'label'   => __( 'Footer inner width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'structure'        => [
                'title'    => __( 'Blocks', THEME_TEXTDOMAIN ),
                'priority' => 12,
                'sections' => [
                    'super_header' => [
                        'title'    => __( 'Super Header', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'super_header_info'         => [
                                'description' => __( 'Get more info', THEME_TEXTDOMAIN ),
                                'type'        => DocLink::class,
                                'link'        => $this->tooltip_link(),
                            ],
                            'super_header_show'         => [
                                'label' => __( 'Show', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'super_header_show_mob'     => [
                                'label' => __( 'Enable on mobile', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'super_header_width'        => [
                                'label'   => __( 'Width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'super_header_inner_width'  => [
                                'label'   => __( 'Inner width', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'full'  => __( 'Full width', THEME_TEXTDOMAIN ),
                                    'fixed' => __( 'Fixed width', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'super_header_color_txt'    => [
                                'label' => __( 'Text color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'super_header_color_link'   => [
                                'label' => __( 'Link color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'super_header_color_bg'     => [
                                'label' => __( 'Background color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'super_header_html_block_1' => [
                                'label' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 1 ),
                                'type'  => 'textarea',
                            ],
                            'super_header_html_block_2' => [
                                'label' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 2 ),
                                'type'  => 'textarea',
                            ],
                            'super_header_html_block_3' => [
                                'label' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 3 ),
                                'type'  => 'textarea',
                            ],
                            'super_header_html_block_4' => [
                                'label' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 4 ),
                                'type'  => 'textarea',
                            ],
                            'super_header_html_block_5' => [
                                'label' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 5 ),
                                'type'  => 'textarea',
                            ],
                            'super_header_html_block_6' => [
                                'label' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 6 ),
                                'type'  => 'textarea',
                            ],
                            'super_header_block_order'  => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                                'choices' => [
                                    'super_header_html_block_1' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 1 ),
                                    'super_header_html_block_2' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 2 ),
                                    'super_header_html_block_3' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 3 ),
                                    'super_header_html_block_4' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 4 ),
                                    'super_header_html_block_5' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 5 ),
                                    'super_header_html_block_6' => sprintf( __( 'HTML code #%d', THEME_TEXTDOMAIN ), 6 ),
                                ],
                            ],
                        ],
                    ],
                    'header'       => [
                        'title'    => __( 'Header', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'logotype_image'          => [
                                'name'  => 'logotype_image',
                                'label' => __( 'Logotype', THEME_TEXTDOMAIN ),
                                'type'  => 'image',
                            ],
                            'header_style_type'       => [
                                'label'   => _x( 'Header Shadow Style', 'customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    ''        => _x( 'Without style', 'Customizer', THEME_TEXTDOMAIN ),
                                    'style-1' => _x( 'Style 1', 'Customizer', THEME_TEXTDOMAIN ),
                                    'style-2' => _x( 'Style 2', 'Customizer', THEME_TEXTDOMAIN ),
                                    'style-3' => _x( 'Style 3', 'Customizer', THEME_TEXTDOMAIN ),
                                    'style-4' => _x( 'Style 4', 'Customizer', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'header_hide_title'       => [
                                'label' => __( 'Hide site title', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'header_hide_description' => [
                                'label' => __( 'Hide site description', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'header_search_type'      => [
                                'label'   => _x( 'Search Appearance', 'customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'compact'  => _x( 'Compact', 'customizer', THEME_TEXTDOMAIN ),
                                    'expanded' => _x( 'Expanded', 'customizer', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            /*
                            'header_cart_style'       => [
                                'label'   => _x( 'Cart Appearance', 'customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'style-1' => _x( 'Style 1', 'Customizer', THEME_TEXTDOMAIN ),
                                    'style-2' => _x( 'Style 2', 'Customizer', THEME_TEXTDOMAIN ),
                                    'style-3' => _x( 'Style 3', 'Customizer', THEME_TEXTDOMAIN ),
                                ],
                            ],*/
                            'header_phone_number'     => [
                                'label'        => _x( 'Phone Numbers', 'customizer', THEME_TEXTDOMAIN ),
                                'type'         => TextArea::class,
                                'description'  => _x( 'new line separated values', 'customizer', THEME_TEXTDOMAIN ),
                                'tooltip_link' => $this->tooltip_link( 'bono-add-and-customize-phones/' ),
                                'tooltip_text' => _x( 'how to configure numbers', 'customizer', THEME_TEXTDOMAIN ),
                            ],
                            'header_html_block_1'     => [
                                'label' => __( 'HTML code #1', THEME_TEXTDOMAIN ),
                                'type'  => 'textarea',
                                //'description'   => __( 'Code will be displayed after logotype', THEME_TEXTDOMAIN ),
                            ],
                            'header_html_block_2'     => [
                                'label' => __( 'HTML code #2', THEME_TEXTDOMAIN ),
                                'type'  => 'textarea',
                                //'description'   => __( 'Code will be displayed after top menu', THEME_TEXTDOMAIN ),
                            ],
                            'header_block_order'      => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                                'choices' => [
                                    'site_branding'       => __( 'Logotype', THEME_TEXTDOMAIN ),
                                    'header_html_block_1' => __( 'HTML code #1', THEME_TEXTDOMAIN ),
                                    'header_social'       => __( 'Social links', THEME_TEXTDOMAIN ),
                                    'top_menu'            => __( 'Top menu', THEME_TEXTDOMAIN ),
                                    'header_html_block_2' => __( 'HTML code #2', THEME_TEXTDOMAIN ),
                                    'header_phone_number' => _x( 'Phone Numbers', 'customizer', THEME_TEXTDOMAIN ),
                                    'header_search'       => __( 'Search', THEME_TEXTDOMAIN ),
                                    'header_favorite'     => __( 'Favorite', THEME_TEXTDOMAIN ),
                                    'header_compare'      => __( 'Compare Products', THEME_TEXTDOMAIN ),
                                    'header_cart'         => __( 'Cart', THEME_TEXTDOMAIN ),
                                ],
                            ],
                        ],
                    ],
                    'footer'       => [
                        'title'    => __( 'Footer', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'footer_widgets'   => [
                                'label'       => __( 'Number of widget areas', THEME_TEXTDOMAIN ),
                                'description' => __( '0 - for disable, maximum 5', THEME_TEXTDOMAIN ),
                                'type'        => 'number',
                                'input_attrs' => [ 'min' => 0, 'max' => 5, 'step' => 1 ],
                            ],
                            'footer_copyright' => [
                                'label'       => __( 'Copyright', THEME_TEXTDOMAIN ),
                                'description' => __( 'Use %year% to add the current year', THEME_TEXTDOMAIN ),
                                'type'        => 'textarea',
                            ],
                            /*'footer_social'     => [
                                'label'         => __( 'Show social links', THEME_TEXTDOMAIN ),
                                'type'          => 'checkbox',
                                'description'   => __( 'Ссылки на соц. сети можно задать в разделе Блоки и расположение > Социальные сети', THEME_TEXTDOMAIN ),
                            ],*/
                            'footer_counters'  => [
                                'label' => __( 'Counters and analytics', THEME_TEXTDOMAIN ),
                                'type'  => 'textarea',
                            ],
                        ],
                    ],
                    'home'         => [
                        'title'    => __( 'Home', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'structure_home_posts'    => [
                                'label'   => __( 'Post cards in home', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => $post_card_types,
                            ],
                            'structure_home_sidebar'  => [
                                'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => $sidebar_position,
                            ],
                            'structure_home_h1'       => [
                                'label'       => __( 'Header H1', THEME_TEXTDOMAIN ),
                                'description' => __( 'If the field is not specified, the logo (site name) becomes the h1 header', THEME_TEXTDOMAIN ),
                            ],
                            'structure_home_text'     => [
                                'label'       => __( 'Text', THEME_TEXTDOMAIN ),
                                'type'        => 'textarea',
                                'description' => __( 'The text under the heading H1 is displayed only on the main', THEME_TEXTDOMAIN ),
                            ],
                            'structure_home_position' => [
                                'label'   => __( 'H1 and text position', THEME_TEXTDOMAIN ),
                                'type'    => 'radio',
                                'choices' => [
                                    'top'    => __( 'Top', THEME_TEXTDOMAIN ),
                                    'bottom' => __( 'Bottom', THEME_TEXTDOMAIN ),
                                ],
                            ],
                        ],
                    ],
                    'single'       => [
                        'title'    => __( 'Single', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'structure_single_sidebar' => [
                                'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => $sidebar_position,
                            ],
                            'structure_single_hide'    => [
                                'label'   => __( 'Hide elements', THEME_TEXTDOMAIN ),
                                'type'    => 'multicheck',
                                'choices' => [
                                    'thumbnail'     => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                    'category'      => __( 'Category', THEME_TEXTDOMAIN ),
                                    'author'        => __( 'Author', THEME_TEXTDOMAIN ),
                                    //'reading_time'  => __( 'Reading time', THEME_TEXTDOMAIN ),
                                    'views'         => __( 'Views', THEME_TEXTDOMAIN ),
                                    'date'          => __( 'Date', THEME_TEXTDOMAIN ),
                                    //'comments_count' => __( 'Comments count', THEME_TEXTDOMAIN ),
                                    'excerpt'       => __( 'Excerpt', THEME_TEXTDOMAIN ),
                                    'social_bottom' => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
                                    'rating'        => __( 'Rating', THEME_TEXTDOMAIN ),
                                    'tags'          => __( 'Tags', THEME_TEXTDOMAIN ),
                                    'author_box'    => __( 'Author block', THEME_TEXTDOMAIN ),
                                    'comments'      => __( 'Comments', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'structure_single_related' => [
                                'label'       => __( 'Count of related articles', THEME_TEXTDOMAIN ),
                                'type'        => 'number',
                                'input_attrs' => [ 'min' => 0, 'max' => 50, 'step' => 1 ],
                                'description' => __( '0 - for disable, maximum 50', THEME_TEXTDOMAIN ),
                            ],
                        ],
                    ],
                    'page'         => [
                        'title'    => __( 'Page', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'structure_page_sidebar' => [
                                'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => $sidebar_position,
                            ],
                            'structure_page_hide'    => [
                                'label'   => __( 'Hide elements', THEME_TEXTDOMAIN ),
                                'type'    => 'multicheck',
                                'choices' => [
                                    'thumbnail'     => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                    'social_bottom' => __( 'Bottom social buttons', THEME_TEXTDOMAIN ),
                                    'rating'        => __( 'Rating', THEME_TEXTDOMAIN ),
                                    'comments'      => __( 'Comments', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'structure_page_related' => [
                                'label'       => __( 'Count of related articles', THEME_TEXTDOMAIN ),
                                'type'        => 'number',
                                'input_attrs' => [ 'min' => 0, 'max' => 50, 'step' => 1 ],
                                'description' => __( '0 - for disable, maximum 50', THEME_TEXTDOMAIN ),
                            ],
                        ],
                    ],
                    'archive'      => [
                        'title'    => __( 'Archive', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'structure_archive_posts'         => [
                                'label'   => __( 'Post cards in archive', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => $post_card_types,
                            ],
                            'structure_archive_sidebar'       => [
                                'label'   => __( 'Sidebar', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => $sidebar_position,
                            ],
                            'structure_archive_subcategories' => [
                                'label' => __( 'Show subcategories', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'structure_archive_description'   => [
                                'label'   => __( 'Position of archive description', THEME_TEXTDOMAIN ),
                                'type'    => 'radio',
                                'choices' => [
                                    'top'    => __( 'Top', THEME_TEXTDOMAIN ),
                                    'bottom' => __( 'Bottom', THEME_TEXTDOMAIN ),
                                ],
                            ],
                        ],
                    ],
                    'comments'     => [
                        'title'    => __( 'Comments', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'comments_text_before_submit' => [
                                'label'       => __( 'Text before Send button', THEME_TEXTDOMAIN ),
                                'type'        => 'textarea',
                                'description' => 'Вы можете добавить любой HTML код, пример с ссылками (# нужно заменить на адрес ссылки):<br><br>Нажимая на кнопку "Отправить комментарий", я даю согласие на &lt;a href="#"&gt;обработку персональных данных&lt;/a&gt; и принимаю &lt;a href="#" target="_blank"&gt;политику конфиденциальности&lt;/a&gt;.',
                            ],
                            'comments_date'               => [
                                'label' => __( 'Show comment date', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'comments_time'               => [
                                'label' => __( 'Show comment time', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                        ],
                    ],
                    'sidebar'      => [
                        'title'       => __( 'Sidebar', THEME_TEXTDOMAIN ),
                        'description' => __( 'In this section, you can customize the appearance of the sidebar', THEME_TEXTDOMAIN ),
                        'controls'    => [
                            'sidebar_mob'     => [
                                'label' => __( 'Show sidebar on mobile', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'sidebar_widgets' => [
                                'label'       => __( 'Number of widget areas', THEME_TEXTDOMAIN ),
                                'description' => __( 'maximum 5', THEME_TEXTDOMAIN ),
                                'type'        => 'number',
                                'input_attrs' => [ 'min' => 1, 'max' => 5, 'step' => 1 ],
                            ],
                        ],
                    ],
                ],
            ],
            'modules'          => [
                'title'    => __( 'Modules', THEME_TEXTDOMAIN ),
                'priority' => 12,
                'sections' => [
                    'toc'             => [
                        'title'    => __( 'Table of Contents', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'toc_display'       => [
                                'label' => __( 'Enable on posts', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'toc_display_pages' => [
                                'label' => __( 'Enable on pages', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'toc_open'          => [
                                'label' => __( 'Default open', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'toc_noindex'       => [
                                'label' => __( 'Wrap the content in noindex', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            /*
                            'toc_place'         => [
                                'label' => __( 'Display the content at the beginning of the post', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            */
                            'toc_title'         => [
                                'label' => __( 'Content title', THEME_TEXTDOMAIN ),
                            ],
                        ],
                    ],
                    'lightbox'        => [
                        'title'       => __( 'Lightbox', THEME_TEXTDOMAIN ),
                        'description' => __( 'In this section, you can turn on the zoom when clicking on it', THEME_TEXTDOMAIN ),
                        'controls'    => [
                            'lightbox_display' => [
                                'label' => __( 'Enable lightbox', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                        ],
                    ],
                    'breadcrumbs'     => [
                        'title'    => __( 'Breadcrumbs', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'breadcrumbs_display'     => [
                                'label' => __( 'Enable breadcrumbs', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'breadcrumbs_home_text'   => [
                                'label' => __( 'Home text', THEME_TEXTDOMAIN ),
                            ],
                            'breadcrumbs_archive'     => [
                                'label' => __( 'Show breadcrumbs in archives', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'breadcrumbs_single_link' => [
                                'label' => __( 'Display page title', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'breadcrumbs_shop'        => [
                                'label' => __( 'Show breadcrumbs in shop pages', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                        ],
                    ],
                    'contact_form'    => [
                        'title'    => __( 'Contact Form', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'contact_form_text_before_submit' => [
                                'label'       => __( 'Text before Send button', THEME_TEXTDOMAIN ),
                                'type'        => 'textarea',
                                'description' => 'Вы можете добавить любой HTML код, пример с ссылками (# нужно заменить на адрес ссылки):<br><br>Нажимая на кнопку "Отправить комментарий", я даю согласие на &lt;a href="#"&gt;обработку персональных данных&lt;/a&gt; и принимаю &lt;a href="#" target="_blank"&gt;политику конфиденциальности&lt;/a&gt;.',
                            ],
                        ],
                    ],
                    'social_profiles' => [
                        'title'    => __( 'Social profiles', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'social_facebook'      => [
                                'label' => __( 'Facebook', THEME_TEXTDOMAIN ),
                            ],
                            'social_vkontakte'     => [
                                'label' => __( 'Vk', THEME_TEXTDOMAIN ),
                            ],
                            'social_twitter'       => [
                                'label' => __( 'Twitter', THEME_TEXTDOMAIN ),
                            ],
                            'social_odnoklassniki' => [
                                'label' => __( 'Odnoklassniki', THEME_TEXTDOMAIN ),
                            ],
                            'social_telegram'      => [
                                'label' => __( 'Telegram', THEME_TEXTDOMAIN ),
                            ],
                            'social_youtube'       => [
                                'label' => __( 'Youtube', THEME_TEXTDOMAIN ),
                            ],
                            'social_instagram'     => [
                                'label' => __( 'Instagram', THEME_TEXTDOMAIN ),
                            ],
                            'social_linkedin'      => [
                                'label' => __( 'Linkedin', THEME_TEXTDOMAIN ),
                            ],
                            'social_whatsapp'      => [
                                'label' => __( 'WhatsApp', THEME_TEXTDOMAIN ),
                            ],
                            'social_viber'         => [
                                'label' => __( 'Viber', THEME_TEXTDOMAIN ),
                            ],
                            'social_pinterest'     => [
                                'label' => __( 'Pinterest', THEME_TEXTDOMAIN ),
                            ],
                            'social_yandexzen'     => [
                                'label' => __( 'Yandex Zen', THEME_TEXTDOMAIN ),
                            ],
                            'structure_social_js'  => [
                                'label' => __( 'Hide links by JS', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                        ],
                    ],
                    'share_buttons'   => [
                        'title'    => __( 'Share buttons', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'share_buttons_counters' => [
                                'label' => __( 'Enable counters', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'share_buttons'          => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Share buttons', THEME_TEXTDOMAIN ),
                                'choices' => $this->social->get_share_services(),
                            ],
                        ],
                    ],
                    'arrow'           => [
                        'title'    => __( 'Scroll to top button', THEME_TEXTDOMAIN ),
                        'controls' => [

                            'arrow_display'     => [
                                'label' => __( 'Enable scroll to top button', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'arrow_mob_display' => [
                                'label' => __( 'Enable on mobile', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'arrow_bg'          => [
                                'label' => __( 'Background color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'arrow_color'       => [
                                'label' => __( 'Arrow color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'arrow_width'       => [
                                'label'       => __( 'Button width', THEME_TEXTDOMAIN ),
                                'type'        => 'range',
                                'sanitize'    => 'integer',
                                'input_attrs' => [ 'min' => 30, 'max' => 80, 'step' => 1 ],
                            ],
                            'arrow_height'      => [
                                'label'       => __( 'Button height', THEME_TEXTDOMAIN ),
                                'type'        => 'range',
                                'sanitize'    => 'integer',
                                'input_attrs' => [ 'min' => 30, 'max' => 80, 'step' => 1 ],
                            ],
                            'arrow_icon'        => [
                                'label'   => __( 'Button icon', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    '\fe3f' => '︿',
                                    '\fe3d' => '︽',
                                    '\2191' => '↑',
                                    '\21d1' => '⇑',
                                    '\2924' => '⤤',
                                ],
                            ],
                        ],
                    ],
                    'views_counter'   => [
                        'title'    => _x( 'Views Counter', 'Customizer', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'wpshop_views_counter_enable'       => [
                                'label' => _x( 'Enable the Module', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'wpshop_views_counter_to_count'     => [
                                'label'   => _x( 'Cunt Views', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    '0' => _x( 'Everyone', 'Customizer', THEME_TEXTDOMAIN ),
                                    '1' => _x( 'Guests Only', 'Customizer', THEME_TEXTDOMAIN ),
                                    '2' => _x( 'Registered Users Only', 'Customizer', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'wpshop_views_counter_exclude_bots' => [
                                'label'   => _x( 'Exclude Bot Views', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    '0' => _x( 'No', 'Customizer', THEME_TEXTDOMAIN ),
                                    '1' => _x( 'Yes', 'Customizer', THEME_TEXTDOMAIN ),
                                ],
                            ],
                        ],

                    ],
                    'one_click_buy'   => [
                        'title'    => _x( 'One Click Buy', 'Customizer', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'one_click_buy_enable'          => [
                                'label' => _x( 'Enable the Module', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'  => 'checkbox',
                            ],
                            'one_click_buy_mode'            => [
                                'label'   => _x( 'Button Action', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'send_email'   => _x( 'Send Email', 'Customizer', THEME_TEXTDOMAIN ),
                                    'create_order' => _x( 'Create Order', 'Customizer', THEME_TEXTDOMAIN ),
                                    'both'         => _x( 'Create Order and Send Email', 'Customizer', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'one_click_buy_order_status' => [
                                'label'   => _x( 'Order Status', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => wc_get_order_statuses(),
                            ],
                            'one_click_buy_success_message' => [
                                'label'       => _x( 'Success Message', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'        => 'textarea',
                                'description' => _x( 'message on success handled on click', 'Customizer', THEME_TEXTDOMAIN ),
                            ],
                            'one_click_buy_email_to'        => [
                                'label' => _x( 'Email To', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'  => 'text',
                            ],
                            'one_click_buy_name_to'         => [
                                'label' => _x( 'Name To', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'  => 'text',
                            ],
                            'one_click_buy_email_subject'   => [
                                'label' => _x( 'Email Subject', 'Customizer', THEME_TEXTDOMAIN ),
                                'type'  => 'text',
                            ],
                        ],
                    ],
                ],
            ],
            'post_cards'       => [
                'title'       => __( 'Post cards', THEME_TEXTDOMAIN ),
                'description' => __( 'In this section, you can customize the appearance of postcards that are displayed on the main, in headings, search, etc.', THEME_TEXTDOMAIN ),
                'priority'    => 12,
                'sections'    => [
                    'post_card_vertical' => [
                        'title'    => __( 'Vertical', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'post_card_vertical_order'          => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                                'choices' => [
                                    'thumbnail' => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                    //'category'  => __( 'Category', THEME_TEXTDOMAIN ),
                                    'title'     => __( 'Title', THEME_TEXTDOMAIN ),
                                    'excerpt'   => __( 'Excerpt', THEME_TEXTDOMAIN ),
                                    'meta'      => __( 'Meta', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'post_card_vertical_order_meta'     => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                                'choices' => $post_card_order_meta,
                            ],
                            'post_card_vertical_excerpt_length' => [
                                'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                                'type'  => 'number',
                            ],
                        ],
                    ],
                    'post_card_standard' => [
                        'title'    => __( 'Standard', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'post_card_standard_order'          => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                                //'description' => __( 'Category is displayed only when there is no thumbnail', THEME_TEXTDOMAIN ),
                                'choices' => [
                                    //'category'  => __( 'Category', THEME_TEXTDOMAIN ),
                                    'title'     => __( 'Title', THEME_TEXTDOMAIN ),
                                    'thumbnail' => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                    'meta'      => __( 'Meta', THEME_TEXTDOMAIN ),
                                    'excerpt'   => __( 'Excerpt', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'post_card_standard_order_meta'     => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                                'choices' => $post_card_order_meta,
                            ],
                            'post_card_standard_excerpt_length' => [
                                'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                                'type'  => 'number',
                            ],
                        ],
                    ],
                    'post_card_related'  => [
                        'title'    => __( 'Related posts', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'post_card_related_order'          => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order', THEME_TEXTDOMAIN ),
                                'choices' => [
                                    'thumbnail' => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                    'title'     => __( 'Title', THEME_TEXTDOMAIN ),
                                    'excerpt'   => __( 'Excerpt', THEME_TEXTDOMAIN ),
                                    'meta'      => __( 'Meta', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'post_card_related_order_meta'     => [
                                'type'    => 'sortable-checkboxes',
                                'label'   => __( 'Order Meta', THEME_TEXTDOMAIN ),
                                'choices' => [
                                    'comments_number' => __( 'Comments number', THEME_TEXTDOMAIN ),
                                    'views'           => _x( 'Views', 'Hide elements', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'post_card_related_excerpt_length' => [
                                'label' => __( 'Excerpt length', THEME_TEXTDOMAIN ),
                                'type'  => 'number',
                            ],
                        ],
                    ],
                ],
            ],
            'codes'            => [
                'title'    => __( 'Codes', THEME_TEXTDOMAIN ),
                'priority' => 13,
                'controls' => [
                    'code_head'          => [
                        'label'       => __( 'In &lt;head&gt; section', THEME_TEXTDOMAIN ),
                        'description' => __( 'Before &lt;/head&gt; tag', THEME_TEXTDOMAIN ),
                        'type'        => 'textarea',
                    ],
                    'code_body'          => [
                        'label' => __( 'Before &lt;/body&gt;', THEME_TEXTDOMAIN ),
                        'type'  => 'textarea',
                    ],
                    'code_after_content' => [
                        'label' => __( 'After content', THEME_TEXTDOMAIN ),
                        'type'  => 'textarea',
                    ],
                ],
            ],
            'theme_colors'     => [
                'title'    => __( 'Colors and background', THEME_TEXTDOMAIN ),
                'priority' => 14,
                'sections' => [
                    'theme_colors_general' => [
                        'title'    => _x( 'General', 'General colors', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'colors_body'       => [
                                'label' => __( 'Site text color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_body_bg'    => [
                                'label' => __( 'Site background color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_main'       => [
                                'label'       => __( 'Base site color', THEME_TEXTDOMAIN ),
                                'type'        => 'color',
                                'description' => __( 'Separators, pagination, lists, buttons, mob. menu, etc. It is desirable to choose a color that stands out on a white background', THEME_TEXTDOMAIN ),
                            ],
                            'colors_link'       => [
                                'label' => __( 'Link color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_link_hover' => [
                                'label' => __( 'Link hover color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                        ],
                    ],
                    'theme_colors_header'  => [
                        'title'    => _x( 'Header', 'Header colors', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'colors_header'                  => [
                                'label' => __( 'Color text and links', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_header_bg'               => [
                                'label' => __( 'Background color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_header_site_title'       => [
                                'label' => __( 'Site title', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_header_site_description' => [
                                'label' => __( 'Site description', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'header_bg'                      => [
                                'label' => __( 'Header background', THEME_TEXTDOMAIN ),
                                'type'  => 'image',
                            ],
                            'header_bg_repeat'               => [
                                'label'   => __( 'Header background repeat', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'no-repeat' => __( 'No repeat', THEME_TEXTDOMAIN ),
                                    'repeat'    => __( 'Repeat horizontal and vertical', THEME_TEXTDOMAIN ),
                                    'repeat-x'  => __( 'Repeat horizontal', THEME_TEXTDOMAIN ),
                                    'repeat-y'  => __( 'Repeat vertical', THEME_TEXTDOMAIN ),
                                ],
                            ],
                            'header_bg_position'             => [
                                'label'   => __( 'Header background position', THEME_TEXTDOMAIN ),
                                'type'    => 'select',
                                'choices' => [
                                    'left top'      => __( 'Top left', THEME_TEXTDOMAIN ),
                                    'center top'    => __( 'Top center', THEME_TEXTDOMAIN ),
                                    'right top'     => __( 'Top right', THEME_TEXTDOMAIN ),
                                    'left center'   => __( 'Middle left', THEME_TEXTDOMAIN ),
                                    'center center' => __( 'Middle center', THEME_TEXTDOMAIN ),
                                    'right center'  => __( 'Middle right', THEME_TEXTDOMAIN ),
                                    'left bottom'   => __( 'Bottom left', THEME_TEXTDOMAIN ),
                                    'center bottom' => __( 'Bottom center', THEME_TEXTDOMAIN ),
                                    'right bottom'  => __( 'Bottom right', THEME_TEXTDOMAIN ),
                                ],
                            ],
                        ],
                    ],
                    'theme_colors_menu'    => [
                        'title'    => _x( 'Menu', 'Menu colors', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'colors_menu'    => [
                                'label' => __( 'Links color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_menu_bg' => [
                                'label' => __( 'Background color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                        ],
                    ],
                    'theme_colors_footer'  => [
                        'title'    => _x( 'Footer', 'Footer colors', THEME_TEXTDOMAIN ),
                        'controls' => [
                            'colors_footer'    => [
                                'label' => __( 'Color text and links', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                            'colors_footer_bg' => [
                                'label' => __( 'Background color', THEME_TEXTDOMAIN ),
                                'type'  => 'color',
                            ],
                        ],
                    ],
                ],
            ],
            'typography'       => [
                'title'    => __( 'Typography', THEME_TEXTDOMAIN ),
                'priority' => 15,
                'controls' => [
                    'typography_body'             => [
                        'label'   => __( 'Main text', THEME_TEXTDOMAIN ),
                        'type'    => 'typography',
                        'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                    ],
                    'typography_site_title'       => [
                        'label'   => __( 'Site title', THEME_TEXTDOMAIN ),
                        'type'    => 'typography',
                        'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                    ],
                    'typography_site_description' => [
                        'label'   => __( 'Site description', THEME_TEXTDOMAIN ),
                        'type'    => 'typography',
                        'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                    ],
                    'typography_menu_links'       => [
                        'label'   => __( 'Links in the menu', THEME_TEXTDOMAIN ),
                        'type'    => 'typography',
                        'choices' => [ 'font-family', 'font-styles', 'font-size', 'line-height' ],
                    ],
                ],
            ],
            'home_constructor' => [
                'title'    => __( 'Home constructor', THEME_TEXTDOMAIN ),
                'priority' => 16,
                'controls' => [
                    'home_constructor_enabled' => [
                        'label' => __( 'Enabled', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'home_constructor'         => [
                        'label'   => __( 'Home constructor', THEME_TEXTDOMAIN ),
                        'type'    => BonoPageConstructor::class,
                        'choices' => [
                            'post_card_types'       => [
                                //'grid',
                                //'small',
                                'vertical',
                                //'horizontal',
                                'standard',
                            ],
                            'product_card_types'    => [
                                'small',
                                'standard',
                            ],
                            'post_card_elements'    => [
                                'thumbnail'       => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                'date'            => __( 'Date', THEME_TEXTDOMAIN ),
                                'excerpt'         => __( 'Excerpt', THEME_TEXTDOMAIN ),
                                'category'        => __( 'Category', THEME_TEXTDOMAIN ),
                                'author'          => __( 'Author', THEME_TEXTDOMAIN ),
                                'views'           => __( 'Views', THEME_TEXTDOMAIN ),
                                'comments_number' => __( 'Comments number', THEME_TEXTDOMAIN ),
                            ],
                            'product_card_elements' => [
                                'thumbnail'       => __( 'Thumbnail', THEME_TEXTDOMAIN ),
                                'category'        => __( 'Category', THEME_TEXTDOMAIN ),
                                'views'           => __( 'Views', THEME_TEXTDOMAIN ),
                                'comments_number' => __( 'Comments number', THEME_TEXTDOMAIN ),
                            ],
                            'presets'               => [
                                'gradient-1',
                                'gradient-2',
                                'gradient-3',
                                'bgc-1',
                                'bgc-2',
                                'bgc-3',
                                'bgc-4',
                                'bgc-5',
                                'bgc-6',
                                'bgc-7',
                                'bgc-8',
                                'bgc-9',
                                'bgc-10',
                                'bgc-11',
                                'bgc-12',
                                'bgc-13',
                                'bgc-14',
                                'bgc-15',
                                'bgc-16',
                                'bgc-17',
                                'bg-dark-1',
                                'bg-dark-2',
                                'bg-dark-3',
                                'bg-dark-4',
                                'bg-dark-5',
                                'bg-dark-6',
                                'bg-dark-7',
                                'bg-dark-8',
                                'bg-dark-9',
                                'bgi-1',
                                'bgi-2',
                            ],
                        ],
                    ],
                ],
            ],
            'tweak'            => [
                'title'    => __( 'Tweak options', THEME_TEXTDOMAIN ),
                'priority' => 210,
                'controls' => [
                    'logotype_max_width'             => [
                        'label'       => __( 'Logotype max width, px', THEME_TEXTDOMAIN ),
                        'type'        => 'number',
                        'input_attrs' => [ 'min' => 20, 'max' => 1000, 'step' => 1 ],
                    ],
                    'logotype_max_height'            => [
                        'label'       => __( 'Logotype max height, px', THEME_TEXTDOMAIN ),
                        'type'        => 'number',
                        'input_attrs' => [ 'min' => 20, 'max' => 500, 'step' => 1 ],
                    ],
                    'content_full_width'             => [
                        'label' => __( 'Content on full width', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'social_share_title'             => [
                        'label' => __( 'Social buttons title', THEME_TEXTDOMAIN ),
                    ],
                    'single_social_share_title_show' => [
                        'label' => __( 'Show title social buttons in posts', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'page_social_share_title_show'   => [
                        'label' => __( 'Show title social buttons on pages', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'single_rating_title'            => [
                        'label' => __( 'Rating title in posts', THEME_TEXTDOMAIN ),
                    ],
                    'page_rating_title'              => [
                        'label' => __( 'Rating title on pages', THEME_TEXTDOMAIN ),
                    ],
                    'rating_text_show'               => [
                        'label' => __( 'Show rating statistics', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'move_jquery_in_footer'          => [
                        'label' => __( 'Move jquery in footer', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'related_posts_title'            => [
                        'label' => __( 'Related posts title', THEME_TEXTDOMAIN ),
                    ],
                    'sitemap_pages_show'             => [
                        'label' => __( 'Show pages in sitemap', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'advertising_page_display'       => [
                        'label' => __( 'Enable advertising on pages', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'microdata_publisher_telephone'  => [
                        'label'       => __( 'The value of the telephone field for publisher microdata', THEME_TEXTDOMAIN ),
                        'description' => __( 'If the field is not specified, the site name will be displayed as the telephone value', THEME_TEXTDOMAIN ),
                    ],
                    'microdata_publisher_address'    => [
                        'label'       => __( 'The value of the address field for publisher microdata', THEME_TEXTDOMAIN ),
                        'description' => __( 'If the field is not specified, the site address will be displayed as the address value', THEME_TEXTDOMAIN ),
                    ],
                ],
            ],
            'partner'          => [
                'title'       => __( 'Affiliate program', THEME_TEXTDOMAIN ),
                'description' => 'Мы добавили возможность зарабатывать Вам на нашей <a href="https://wpshop.ru/partner" target="_blank" rel="noopener">партнерской программе</a>. Вы можете встроить партнерскую ссылку в подвал сайта и зарабатывать 25% с продаж. Ваш партнерский ID уже встроен в тему.<br><br>Ссылка замаскирована через JS, она не индексируется и не передает вес страницы и обернута в noindex.<br><br>О продаже по партнерской ссылке мы сообщим Вам на e-mail, Вы ничего не пропустите.',
                'priority'    => 999,
                'controls'    => [
                    'wpshop_partner_enable'  => [
                        'label' => __( 'Start earning money', THEME_TEXTDOMAIN ),
                        'type'  => 'checkbox',
                    ],
                    'wpshop_partner_prefix'  => [
                        'label' => __( 'Text before link', THEME_TEXTDOMAIN ),
                    ],
                    'wpshop_partner_postfix' => [
                        'label' => __( 'Text after link', THEME_TEXTDOMAIN ),
                    ],
                ],
            ],
        ];

        $controls = apply_filters( THEME_SLUG . '_customizer_controls', $controls );

        $this->customizer->set_defaults( $this->core->get_default_options() );
        $this->customizer->add_controls( $controls );
        $this->customizer->init( $wpCustomizer );
    }

    /**
     * @return array
     */
    protected function getDefaultOptions() {
        return apply_filters( THEME_SLUG . '_options_defaults', [

            // woocommerce > category
            'sidebar_on_shop_category'         => 'none',
            'sidebar_on_shop_category_type'    => 'sidebar-2',
            // woocommerce > shop
            'sidebar_on_shop'                  => 'none',
            'sidebar_on_shop_type'             => 'sidebar-2',
            // woocommerce > product
            'bono_wc_recently_viewed_columns'  => 4,
            'bono_wc_recently_viewed_limit'    => 4,
            'sidebar_on_product'               => 'none',
            'sidebar_on_product_type'          => 'sidebar-2',
            'product_info_tabs_appearance'     => 'horizontal',
            'product_description_wide_content' => false,
            'product_info_tabs_order'          => 'description,additional_information,reviews',
            'product_info_additional_tabs'     => 'ignore',
            // woocommerce > product cards
            'product_cards_type'               => 'standard',
            'fix_add_to_cart_button'           => false,
            // woocommerce > favorite
            'favorite_enabled'                 => true,
            'favorite_counter_enabled'         => false,
            'sidebar_on_favorite'              => 'none',
            'sidebar_on_favorite_type'         => 'sidebar-2',
            // woocommerce > compare products
            'compare_products_enabled'         => true,
            'compare_products_enable_counter'  => false,
            'compare_products_limit'           => 5,
            'sidebar_on_compare'               => 'none',
            'sidebar_on_compare_type'          => 'sidebar-2',
            // woocommerce > prices
            'sale_flash_default'               => __( 'Sale!', 'woocommerce' ),
            'sale_flash_price_format'          => __( 'Discount -{{discount_percent}}%', THEME_TEXTDOMAIN ),

            'hide_address_fields'               => false,

            // layout  >  header
            'header_width'                      => 'full',
            'header_inner_width'                => 'fixed',
            'header_padding_top'                => 0,
            'header_padding_bottom'             => 0,

            // layout  >  header menu
            'header_menu_width'                 => 'fixed',
            'header_menu_inner_width'           => 'full',
            'header_menu_fixed'                 => false,

            // layout  >  footer menu
            'footer_menu_width'                 => 'fixed',
            'footer_menu_inner_width'           => 'full',
            'footer_menu_mob'                   => false,

            // layout  >  footer
            'footer_width'                      => 'full',
            'footer_inner_width'                => 'fixed',

            // blocks > super header
            'super_header_show'                 => false,
            'super_header_show_mob'             => false,
            'super_header_width'                => 'full',
            'super_header_inner_width'          => 'fixed',
            'super_header_block_order'          => 'super_header_html_block_1,super_header_html_block_2,super_header_html_block_3,super_header_html_block_4,super_header_html_block_5,super_header_html_block_6',
            'super_header_color_txt'            => '#ffffff',
            'super_header_color_bg'             => '#3960ff',
            'super_header_color_link'           => '#ffffff',

            // blocks  >  header
            'logotype_image'                    => '',
            'header_style_type'                 => 'style-1',
            'header_hide_title'                 => false,
            'header_hide_description'           => false,
            'header_hide_social'                => false,
            'header_hide_search'                => false,
            'header_search_type'                => 'compact',
            'header_cart_style'                 => 'style-1',
            'header_html_block_1'               => '',
            'header_html_block_2'               => '',
            'header_block_order'                => 'site_branding,header_html_block_1,top_menu,header_phone_number,header_html_block_2,header_search,header_cart',

            // blocks  >  footer
            'footer_widgets'                    => 0,
            'footer_copyright'                  => '© %year% ' . get_bloginfo( 'name' ),
            'footer_counters'                   => '',

            // blocks  >  home
            'structure_home_posts'              => 'standard',
            'structure_home_sidebar'            => 'right',
            'structure_home_h1'                 => '',
            'structure_home_text'               => '',
            'structure_home_position'           => 'bottom',

            // blocks  >  single
            'structure_single_sidebar'          => 'none',
            'structure_single_hide'             => 'author,rating,author_box',
            'structure_single_related'          => 8,

            // blocks  >  page
            'structure_page_sidebar'            => 'right',
            'structure_page_hide'               => 'rating,social_bottom',
            'structure_page_related'            => 0,

            // blocks  >  archive
            'structure_archive_posts'           => 'standard',
            'structure_archive_sidebar'         => 'right',
            'structure_archive_subcategories'   => 'yes',
            'structure_archive_description'     => 'top',

            // blocks  >  comments
            'comments_text_before_submit'       => '',
            'comments_date'                     => true,
            'comments_time'                     => true,
            'comments_output'                   => false,

            // blocks  >  sidebar
            'sidebar_mob'                       => false,
            'sidebar_widgets'                   => 2,

            // modules  >  slider
            'slider_width'                      => 'fixed',
            'slider_autoplay'                   => 2500,
            'slider_type'                       => 'one',
            'slider_count'                      => 0,
            'slider_order_post'                 => 'new',
            'slider_post_in'                    => '',
            'slider_category_in'                => '',
            'slider_show_category'              => true,
            'slider_show_title'                 => true,
            'slider_show_excerpt'               => true,
            'slider_show_on_paged'              => false,

            // modules  >  toc
            'toc_display'                       => true,
            'toc_display_pages'                 => false,
            'toc_noindex'                       => false,
            'toc_open'                          => true,
            'toc_place'                         => false,
            'toc_title'                         => __( 'Contents', THEME_TEXTDOMAIN ),

            // modules  >  lightbox
            'lightbox_display'                  => true,

            // modules  >  breadcrumbs
            'breadcrumbs_display'               => true,
            'breadcrumbs_home_text'             => __( 'Home', THEME_TEXTDOMAIN ),
            'breadcrumbs_archive'               => true,
            'breadcrumbs_single_link'           => false,
            'breadcrumbs_shop'                  => true,

            // modules  >  contact form
            'contact_form_text_before_submit'   => '',

            // modules  >  social profiles
            'social_facebook'                   => '',
            'social_vk'                         => '',
            'social_twitter'                    => '',
            'social_ok'                         => '',
            'social_telegram'                   => '',
            'social_youtube'                    => '',
            'social_instagram'                  => '',
            'social_linkedin'                   => '',
            'social_whatsapp'                   => '',
            'social_viber'                      => '',
            'social_pinterest'                  => '',
            'social_yandexzen'                  => '',
            'structure_social_js'               => true,

            // modules  >  share buttons
            'share_buttons'                     => 'vkontakte,facebook,telegram,odnoklassniki,twitter,sms,whatsapp',
            'share_buttons_counters'            => false,
            'share_buttons_label'               => false,

            // modules  >  scroll to top
            'arrow_display'                     => true,
            'arrow_mob_display'                 => false,
            'arrow_bg'                          => '#ffffff',
            'arrow_color'                       => '#305cf7',
            'arrow_width'                       => '60',
            'arrow_height'                      => '50',
            'arrow_icon'                        => '\fe3f',

            // modules > views counter
            'wpshop_views_counter_enable'       => true,
            'wpshop_views_counter_to_count'     => '0',
            'wpshop_views_counter_exclude_bots' => '1',

            // modules // one click buy
            'one_click_buy_enable'              => false,
            'one_click_buy_mode'                => 'both',
            'one_click_buy_order_status'        => 'wc-processing', // @see wc_get_order_statuses()
            'one_click_buy_success_message'     => __( 'New order was successfully created', THEME_TEXTDOMAIN ),
            'one_click_buy_email_to'            => get_option( 'woocommerce_email_from_address' ),
            'one_click_buy_name_to'             => get_option( 'woocommerce_email_from_name' ),
            'one_click_buy_email_subject'       => __( 'New One Click Buy Order', THEME_TEXTDOMAIN ),

            // blocks  >  post card  >  vertical
            'post_card_vertical_order'          => 'title,excerpt,meta',
            'post_card_vertical_order_meta'     => 'date,comments_number,views',
            'post_card_vertical_excerpt_length' => 100,
            //            'post_card_vertical_animation_type'   => 'fadeinup',

            // blocks  >  post card  >  standard
            'post_card_standard_order'          => 'title,thumbnail,meta,excerpt',
            'post_card_standard_order_meta'     => 'date,comments_number,views',
            'post_card_standard_excerpt_length' => 100,
            'post_card_standard_animation_type' => 'no',

            // blocks  >  post card  >  related
            'post_card_related_order'           => 'thumbnail,title,excerpt,meta',
            'post_card_related_order_meta'      => 'comments_number,views',
            'post_card_related_excerpt_length'  => 50,

            // codes
            'code_head'                         => '',
            'code_body'                         => '',
            'code_after_content'                => '',

            // typography
            'typography_body'                   => json_encode( [
                'font-family' => 'rubik',
                'font-size'   => '16',
                'line-height' => '1.5',
                'font-style'  => '',
                'unit'        => 'px',
            ] ),
            'typography_site_title'             => json_encode( [
                'font-family' => 'rubik',
                'font-size'   => '32',
                'line-height' => '1.5',
                'font-style'  => '',
                'unit'        => 'px',
            ] ),
            'typography_site_description'       => json_encode( [
                'font-family' => 'rubik',
                'font-size'   => '13',
                'line-height' => '1.3',
                'font-style'  => '',
                'unit'        => 'px',
            ] ),
            'typography_menu_links'             => json_encode( [
                'font-family' => 'rubik',
                'font-size'   => '16',
                'line-height' => '1.5',
                'font-style'  => '',
                'unit'        => 'px',
            ] ),

            // home page constructor
            'home_constructor_enabled'          => true,

            // colors  >  general
            'colors_body'                       => '#111111',
            'colors_body_bg'                    => '#ffffff',
            'colors_main'                       => '#4d3bfe',
            'colors_link'                       => '#111111',
            'colors_link_hover'                 => '#f43c33',

            // colors  >  header
            'colors_header'                     => '#111111',
            'colors_header_bg'                  => '#ffffff',
            'colors_header_site_title'          => '#111111',
            'colors_header_site_description'    => '#111111',

            // colors  >  menu
            'colors_menu'                       => '#111111',
            'colors_menu_bg'                    => '#ffffff',

            // colors  >  footer
            'colors_footer'                     => '#111111',
            'colors_footer_bg'                  => '#ffffff',

            // background
            'header_bg'                         => '',
            'header_bg_repeat'                  => 'no-repeat',
            'header_bg_position'                => 'center center',

            // tweak
            'logotype_max_width'                => 1000,
            'logotype_max_height'               => 100,
            'content_full_width'                => false,
            'social_share_title'                => __( 'Share to friends', THEME_TEXTDOMAIN ),
            'single_social_share_title_show'    => false,
            'page_social_share_title_show'      => true,
            'single_rating_title'               => __( 'Rate article', THEME_TEXTDOMAIN ),
            'page_rating_title'                 => __( 'Rating', THEME_TEXTDOMAIN ),
            'rating_text_show'                  => false,
            'move_jquery_in_footer'             => false,
            'related_posts_title'               => __( 'You may also like', THEME_TEXTDOMAIN ),
            'sitemap_pages_show'                => true,
            'advertising_page_display'          => false,
            'microdata_publisher_telephone'     => '',
            'microdata_publisher_address'       => '',

            // partner program
            'wpshop_partner_enable'             => false,
            'wpshop_partner_prefix'             => __( 'Powered by theme', THEME_TEXTDOMAIN ),
            'wpshop_partner_postfix'            => '',
        ] );
    }

    public function _js() {

    }

    /**
     * @return void
     */
    public function _style() {
        $defaults   = $this->getDefaultOptions();
        $customizer = new CustomizerCSS( [ 'defaults' => $defaults, 'theme_slug' => THEME_SLUG ] );

        $customizer->add(
            '.super-header',
            [ 'color:%s', 'super_header_color_txt' ]
        );

        $customizer->add(
            '.super-header',
            [ 'background-color:%s', 'super_header_color_bg', ]
        );

        $customizer->add(
            '.super-header a',
            [ 'color:%s', 'super_header_color_link', ]
        );


        // layout  ->  header
        $customizer->add(
            '.site-header',
            [ 'padding-top:%dpx', 'header_padding_top' ],
            '(min-width: 768px)'
        );

        $customizer->add(
            '.site-header',
            [ 'padding-bottom:%dpx', 'header_padding_bottom' ],
            '(min-width: 768px)'
        );


        // modules  ->  scroll to top
        $customizer->add(
            '.scrolltop',
            [ 'background-color:%s', 'arrow_bg' ]
        );

        $customizer->add(
            '.scrolltop:before',
            [ 'color:%s', 'arrow_color' ]
        );

        $customizer->add(
            '.scrolltop',
            [ 'width:%dpx', 'arrow_width' ]
        );

        $customizer->add(
            '.scrolltop',
            [ 'height:%dpx', 'arrow_height' ]
        );

        $customizer->add(
            '.scrolltop:before',
            [ 'content:"%s"', 'arrow_icon' ]
        );


        // colors and background  ->  general
        $customizer->add(
            'body, .price del, .post-card__description',
            [ 'color:%s', 'colors_body' ]
        );

        $customizer->add(
            'body',
            [ 'background-color:%s', 'colors_body_bg' ]
        );

        $customizer->add(
            '::selection, 
            .card-slider__category, 
            .card-slider-container .swiper-pagination-bullet-active,
            .post-card--grid .post-card__thumbnail:before,
            .post-card:not(.post-card--small) .post-card__thumbnail a:before,
            .post-card:not(.post-card--small) .post-card__category,
            .post-box--high .post-box__category span,
            .page-separator,
            .pagination .nav-links .page-numbers:not(.dots):not(.current):before,
            .btn,
            .btn-primary:hover,
            .btn-primary:not(:disabled):not(.disabled).active,
            .btn-primary:not(:disabled):not(.disabled):active,
            .show>.btn-primary.dropdown-toggle,
            .comment-respond .form-submit input,
            .page-links__item',
            [ 'background-color:%s', 'colors_main' ]
        );
        $customizer->add(
            '.entry-image--big .entry-image__body .post-card__category a,
            .home-text ul:not([class])>li:before,
            .page-content ul:not([class])>li:before,
            .taxonomy-description ul:not([class])>li:before,
            .widget-area .widget_categories ul.menu li a:before,
            .widget-area .widget_categories ul.menu li span:before,
            .widget-area .widget_categories>ul li a:before,
            .widget-area .widget_categories>ul li span:before.widget-area .widget_nav_menu ul.menu li a:before,
            .widget-area .widget_nav_menu ul.menu li span:before,
            .widget-area .widget_nav_menu>ul li a:before,
            .widget-area .widget_nav_menu>ul li span:before,
            .page-links .page-numbers:not(.dots):not(.current):before,
            .page-links .post-page-numbers:not(.dots):not(.current):before,
            .pagination .nav-links .page-numbers:not(.dots):not(.current):before,
            .pagination .nav-links .post-page-numbers:not(.dots):not(.current):before,
            .entry-image--full .entry-image__body .post-card__category a,
            .entry-image--fullscreen .entry-image__body .post-card__category a',
            [ 'background-color:%s', 'colors_main' ]
        );

        $customizer->add(
            '.comment-respond input:focus,
            select:focus,
            textarea:focus,
            .post-card--grid.post-card--thumbnail-no,
            .post-card--standard:after,
            .post-card--related.post-card--thumbnail-no:hover,
            .spoiler-box,
            .btn-primary,
            .btn-primary:hover,
            .btn-primary:not(:disabled):not(.disabled).active,
            .btn-primary:not(:disabled):not(.disabled):active,
            .show>.btn-primary.dropdown-toggle,
            .inp:focus,
            .entry-tag:focus,
            .entry-tag:hover,
            .search-screen .search-form .search-field:focus,
            .entry-content ul:not([class])>li:before,
            .text-content ul:not([class])>li:before,
            .entry-content blockquote,
            .button:hover:not(:disabled):not(.disabled)',
            [ 'border-color:%s !important', 'colors_main' ]
        );
        $customizer->add(
            '.input:focus,
            input[type=color]:focus,
            input[type=date]:focus,
            input[type=datetime-local]:focus,
            input[type=datetime]:focus,
            input[type=email]:focus,
            input[type=month]:focus,
            input[type=number]:focus,
            input[type=password]:focus,
            input[type=range]:focus,
            input[type=search]:focus,
            input[type=tel]:focus,
            input[type=text]:focus,
            input[type=time]:focus,
            input[type=url]:focus,
            input[type=week]:focus,
            select:focus,
            textarea:focus',
            [ 'border-color:%s', 'colors_main' ]
        );

        $customizer->add(
            '.post-card--grid a:hover, .post-card--small .post-card__category, .post-card__author:before, .post-card__comments:before, .post-card__date:before, .post-card__like:before, .post-card__views:before, .entry-author:before, .entry-date:before, .entry-time:before, .entry-views:before, .entry-content ol:not([class])>li:before, .text-content ol:not([class])>li:before, .entry-content blockquote:before, .spoiler-box__title:after, .search-icon:hover:before, .search-form .search-submit:hover:before, .star-rating-item.hover,
            .comment-list .bypostauthor>.comment-body .comment-author:after,
            .breadcrumb a, .breadcrumb span,
            .search-screen .search-form .search-submit:before, 
            .star-rating--score-1:not(.hover) .star-rating-item:nth-child(1),
            .star-rating--score-2:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-2:not(.hover) .star-rating-item:nth-child(2),
            .star-rating--score-3:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-3:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-3:not(.hover) .star-rating-item:nth-child(3),
            .star-rating--score-4:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(3), .star-rating--score-4:not(.hover) .star-rating-item:nth-child(4),
            .star-rating--score-5:not(.hover) .star-rating-item:nth-child(1), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(2), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(3), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(4), .star-rating--score-5:not(.hover) .star-rating-item:nth-child(5),
            .card-slider__button:hover:not(:disabled):not(.disabled),
            .single_add_to_cart_button:hover:not(:disabled):not(.disabled), 
            .bono_buy_one_click:hover:not(:disabled):not(.disabled), 
            .shop-item__buttons-cart:hover, 
            .shop-item__buttons-view:hover,
            .shop-item__buttons-cart:hover:not(:disabled):not(.disabled),
            .cart-collaterals .checkout-button:hover:not(:disabled):not(.disabled), 
            .woocommerce-mini-cart__buttons .button:hover:not(:disabled):not(.disabled),
            .woocommerce .woocommerce-checkout .woocommerce-checkout-payment .button:hover:not(:disabled):not(.disabled),
            .comment-respond .form-submit input:hover:not(:disabled):not(.disabled),
            .woocommerce-info .button:hover:not(:disabled):not(.disabled),
            .woocommerce-info:before,
            .woocommerce-address-fields .button:hover:not(:disabled):not(.disabled),
            .woocommerce-EditAccountForm .button:hover:not(:disabled):not(.disabled),
            .woocommerce-account h2,
            .page-numbers a,
            .entry-content ul:not([class])>li:not(.sitemap-list__block):before,
            .woocommerce-cart-form .shop_table th,
            .cart-collaterals .shop_table th,
            .button:hover:not(:disabled):not(.disabled),
            .woocommerce-cart-form .shop_table td.actions .coupon .coupon-btn-apply:before,
            .woocommerce-checkout-review-order .shop_table th,
            .woocommerce-order-details .shop_table th',
            [ 'color:%s', 'colors_main' ]
        );

        $customizer->add( '.woocommerce-info', [ 'border-left-color:%s', 'colors_main' ] );

        $customizer->add(
            '.single_add_to_cart_button, .bono_buy_one_click, .card-slider__button, .shop-item__buttons-cart,
            .woocommerce-mini-cart__buttons button,
            .cart-collaterals .checkout-button,
            .woocommerce-mini-cart__buttons .button,
            .woocommerce .woocommerce-checkout .woocommerce-checkout-payment .button,
            .comment-respond .form-submit input,
            .woocommerce-info .button,
            .woocommerce-address-fields .button,
            .woocommerce-EditAccountForm .button:not(:disabled):not(.disabled),
            .woocommerce-MyAccount-orders .button:not(:disabled):not(.disabled),
            .woocommerce-pagination>.page-numbers .page-numbers:not(.dots):not(.current):before,
            .woocommerce-message .button,
            .woocommerce .wc-backward',
            [ 'background-color:%s', 'colors_main' ]
        );

        $customizer->add(
            '.shop-item__icons-favorite:hover, .shop-item__icons-quick:hover, .shop-item__icons-compare:hover',
            [ 'box-shadow:inset 0 -3.25em 0 0 %s', 'colors_main' ]
        );
        $customizer->add(
            '.shop-item__icons-favorite:hover, .shop-item__icons-quick:hover, .shop-item__icons-compare:hover',
            [ '-webkit-box-shadow:inset 0 -3.25em 0 0 %s', 'colors_main' ]
        );


        $customizer->add(
            '.woocommerce-tabs .wc-tabs li.active a, .shop-item__icons-quick:hover',
            [ 'box-shadow: inset 0 -2px 0 0 %s', 'colors_link' ]
        );
        $customizer->add(
            '.woocommerce-tabs .wc-tabs li.active a, .shop-item__icons-quick:hover',
            [ '-webkit-box-shadow: inset 0 -2px 0 0 %s', 'colors_link' ]
        );

        $customizer->add(
            '.shop-item--type-small .shop-item__buttons-cart',
            [ 'border-color:%s', 'colors_main' ]
        );

        $customizer->add(
            '.comment-respond input:focus, select:focus, textarea:focus, .post-card--grid.post-card--thumbnail-no, .post-card--standard:after, .post-card--related.post-card--thumbnail-no:hover, .spoiler-box, .btn-primary, .btn-primary:hover, .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle, .inp:focus, .entry-tag:focus, .entry-tag:hover, .search-screen .search-form .search-field:focus, .entry-content ul:not([class])>li:before, .text-content ul:not([class])>li:before, .entry-content blockquote',
            [ 'border-color:%s !important', 'colors_main' ]
        );

        $customizer->add(
            '.entry-content a, .entry-content a:visited, .spanlink, .comment-reply-link, .pseudo-link, .widget_calendar a, 
            .widget a:not(:hover),
            .child-categories ul li a,
            .woocommerce-tabs .wc-tabs li.active a',
            [ 'color:%s', 'colors_link' ]
        );

        $customizer->add(
            '.child-categories ul li a',
            [ 'border-color:%s', 'colors_link' ]
        );

        $customizer->add(
            '.widget-area .widget_product_categories>ul>li:before',
            [ 'background-color:%s', 'colors_link' ]
        );

        $customizer->add(
            'a:hover, a:focus, a:active, .spanlink:hover, .top-menu ul li>span:hover, .main-navigation ul li a:hover, .main-navigation ul li span:hover, .footer-navigation ul li a:hover, .footer-navigation ul li span:hover, .comment-reply-link:hover, .pseudo-link:hover, .child-categories ul li a:hover,
            .top-menu ul li>a:hover, .product-category a:hover,
            .woocommerce-tabs .wc-tabs li a:hover,
            .post-card__title a:hover',
            [ 'color:%s', 'colors_link_hover' ]
        );

        $customizer->add(
            '.top-menu>ul>li>a:before,
            .top-menu>ul>li>span:before',
            [ 'background:%s', 'colors_link_hover' ]
        );

        $customizer->add(
            '.child-categories ul li a:hover, .post-box--no-thumb a:hover',
            [ 'border-color:%s', 'colors_link_hover' ]
        );

        $customizer->add(
            '.post-box--card:hover',
            [ 'box-shadow: inset 0 0 0 1px %s', 'colors_link_hover' ]
        );

        $customizer->add(
            '.post-box--card:hover',
            [ '-webkit-box-shadow: inset 0 0 0 1px %s', 'colors_link_hover' ]
        );


        // colors and background  ->  header
        $customizer->add(
            '.site-header, .site-header a, .site-header .pseudo-link,
            .header-favorite:before,
            .header-compare:before,
            .top-menu ul li>span, .top-menu ul li>a',
            [ 'color:%s', 'colors_header' ]
        );

        $customizer->add(
            '.humburger span, .top-menu>ul>li>a:before, .top-menu>ul>li>span:before',
            [ 'background:%s', 'colors_header' ]
        );

        $customizer->add(
            '.site-header',
            [ 'background-color:%s', 'colors_header_bg' ]
        );

        $customizer->add(
            '.top-menu ul li .sub-menu',
            [ 'background-color:%s', 'colors_header_bg' ],
            '(min-width: 992px)'
        );

        $customizer->add(
            '.site-title, .site-title a',
            [ 'color:%s', 'colors_header_site_title' ]
        );

        $customizer->add(
            '.site-description',
            [ 'color:%s', 'colors_header_site_description' ]
        );

        $customizer->add(
            '.site-header',
            [ 'background-image: url("%s")', 'header_bg' ],
            '(min-width: 768px)'
        );

        $customizer->add(
            '.site-header',
            [ 'background-repeat:%s', 'header_bg_repeat' ],
            '(min-width: 768px)'
        );

        $customizer->add(
            '.site-header',
            [ 'background-position:%s', 'header_bg_position' ],
            '(min-width: 768px)'
        );


        // colors and background  ->  menu
        $customizer->add(
            '.main-navigation, .footer-navigation, .footer-navigation .removed-link, .main-navigation .removed-link, .main-navigation ul li>a, .footer-navigation ul li>a',
            [ 'color:%s', 'colors_menu' ]
        );
        $customizer->add(
            '.main-navigation, .main-navigation ul li .sub-menu li, .main-navigation ul li.menu-item-has-children:before, .footer-navigation, .footer-navigation ul li .sub-menu li, .footer-navigation ul li.menu-item-has-children:before',
            [ 'background-color:%s', 'colors_menu_bg' ]
        );


        // colors and background  ->  footer
        $customizer->add(
            '.site-footer, .site-footer a, .site-footer .pseudo-link',
            [ 'color:%s', 'colors_footer' ]
        );

        $customizer->add(
            '.site-footer',
            [ 'background-color:%s', 'colors_footer_bg' ]
        );


        // typography
        $customizer->add(
            'body',
            [ 'typography', 'typography_body' ]
        );

        $customizer->add(
            '.site-title, .site-title a',
            [ 'typography', 'typography_site_title' ]
        );

        $customizer->add(
            '.site-description',
            [ 'typography', 'typography_site_description' ]
        );

        $customizer->add(
            '.main-navigation ul li a, .main-navigation ul li span, .footer-navigation ul li a, .footer-navigation ul li span',
            [ 'typography', 'typography_menu_links' ]
        );


        // tweak
        $customizer->add(
            '.site-logotype',
            [ 'max-width:%dpx', 'logotype_max_width' ]
        );

        $customizer->add(
            '.site-logotype img',
            [ 'max-height:%dpx', 'logotype_max_height' ]
        );

        // pattern
        $customizer->add(
            'body',
            [
                'background-image:url(' . get_bloginfo( 'template_url' ) . '/assets/images/backgrounds/%s)',
                'bg_pattern',
            ]
        );

        $wpshop_sidebar_mob = $this->core->get_option( 'sidebar_mob' );
        if ( $wpshop_sidebar_mob == 'yes' ) {
            $customizer->add(
                '.widget-area',
                [ 'display: block', '' ],
                '(max-width: 991px)'
            );
        }


        $wpshop_footer_menu_mob = $this->core->get_option( 'footer_menu_mob' );
        if ( $wpshop_footer_menu_mob == 'yes' ) {
            $customizer->add(
                '.footer-navigation',
                [ 'display: block', '' ],
                '(max-width: 991px)'
            );
        }


        $output = $customizer->output();
        if ( ! empty( $output ) ) {
            echo PHP_EOL . '    <style>' . $output . '</style>' . PHP_EOL;
        }
    }
}
