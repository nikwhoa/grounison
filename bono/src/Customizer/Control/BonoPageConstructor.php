<?php

namespace Wpshop\TheTheme\Customizer\Control;

use Wpshop\TheTheme\Features\HomeConstructor;

class BonoPageConstructor extends \WP_Customize_Control {

    const ITEM_TYPE_POSTS      = HomeConstructor::SECTION_TYPE_POSTS;
    const ITEM_TYPE_PRODUCTS   = HomeConstructor::SECTION_TYPE_PRODUCTS;
    const ITEM_TYPE_CATEGORIES = HomeConstructor::SECTION_TYPE_CATEGORIES;
    const ITEM_TYPE_HTML       = HomeConstructor::SECTION_TYPE_HTML;
    const ITEM_TYPE_SLIDER     = HomeConstructor::SECTION_TYPE_SLIDER;

    /**
     * @var string
     */
    public $type = 'bono-page-constructor';

    /**
     * @var array
     */
    public $presets = [];

    /**
     * @var array
     */
    public $post_card_types = [];

    /**
     * @var array
     */
    public $product_card_types = [];

    /**
     * @var array
     */
    public $post_card_elements = [];

    /**
     * @var array
     */
    public $product_card_elements = [];

    /**
     * @inheritDoc
     */
    public function __construct( $manager, $id, $args = [] ) {
        $args['type'] = $this->type;
        parent::__construct( $manager, $id, $args );
    }

    /**
     * @inheritDoc
     */
    public function render_content() {
        if ( empty( $this->choices ) ) {
            return;
        }

        if ( ! empty( $this->choices['presets'] ) ) {
            $this->presets[] = 'none';
            $this->presets   = array_merge( $this->presets, $this->choices['presets'] );
        }

        if ( ! empty( $this->choices['post_card_types'] ) ) {
            $this->post_card_types = $this->choices['post_card_types'];
        }

        if ( ! empty( $this->choices['post_card_types'] ) ) {
            $this->product_card_types = $this->choices['product_card_types'];
        }

        if ( ! empty( $this->choices['post_card_elements'] ) ) {
            $this->post_card_elements = $this->choices['post_card_elements'];
        }

        if ( ! empty( $this->choices['product_card_elements'] ) ) {
            $this->product_card_elements = $this->choices['product_card_elements'];
        }

        $value      = $this->value();
        $value_json = json_decode( $value, true );

        if ( ! empty( $this->label ) ) {
            echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
        }

        if ( ! empty( $this->description ) ) {
            echo '<span class="description customize-control-description">' . $this->description . '</span>';
        }

        echo '<div class="bono-customize-pc-items">';

        if ( ! empty( $value_json ) && is_array( $value_json ) ) {
            foreach ( $value_json as $section ) {
                $section = transform_slide_items_data( $section );
                $this->render_item( $section );
            }
        }

        echo '</div><!--.bono-customize-pc-items-->';


        echo '<div class="bono-customize-pc-add-buttons">';
        echo '<p>' . _x( 'Add section:', 'BonoPageConstructor', THEME_TEXTDOMAIN ) . '</p>';
        echo '<span class="button js-bono-customize-pc-add" data-type="' . self::ITEM_TYPE_POSTS . '">' . _x( 'Posts', 'BonoPageConstructor', THEME_TEXTDOMAIN ) . '</span> ';
        echo '<span class="button js-bono-customize-pc-add" data-type="' . self::ITEM_TYPE_HTML . '">' . _x( 'Html', 'BonoPageConstructor', THEME_TEXTDOMAIN ) . '</span> ';
        echo '<span class="button js-bono-customize-pc-add" data-type="' . self::ITEM_TYPE_SLIDER . '">' . _x( 'Slider', 'BonoPageConstructor', THEME_TEXTDOMAIN ) . '</span><br>';
        echo '<span class="button js-bono-customize-pc-add" data-type="' . self::ITEM_TYPE_PRODUCTS . '">' . _x( 'Products', 'BonoPageConstructor', THEME_TEXTDOMAIN ) . '</span> ';
        echo '<span class="button js-bono-customize-pc-add" data-type="' . self::ITEM_TYPE_CATEGORIES . '">' . _x( 'Categories', 'BonoPageConstructor', THEME_TEXTDOMAIN ) . '</span> ';
        echo '<p>' . sprintf( esc_html__( 'to output this widget area place %s in homepage constructor HTML block', THEME_TEXTDOMAIN ), HomeConstructor::HTML_WIDGET_PLACEHOLDER ) . '</p>';
        echo '</div>';

        echo '<div class="bono-customize-pc-placeholders">';
        $this->render_item( [ 'section_type' => self::ITEM_TYPE_POSTS ] );
        $this->render_item( [ 'section_type' => self::ITEM_TYPE_PRODUCTS ] );
        $this->render_item( [ 'section_type' => self::ITEM_TYPE_CATEGORIES ] );
        $this->render_item( [ 'section_type' => self::ITEM_TYPE_HTML ] );
        $this->render_item( [ 'section_type' => self::ITEM_TYPE_SLIDER ] );
        $this->render_slider_placeholder_tpl();
        echo '</div>';

        echo '<input type="hidden" class="bono-customize-pc-field" ' . $this->get_link() . ' value="' . esc_attr( $value ) . '">';

    }

    /**
     * @param array $section
     *
     * @return void
     */
    public function render_item( $section = [] ) {
        $section_type = ( ! empty( $section['section_type'] ) ) ? $section['section_type'] : 'posts';
        $body         = '';
        $item_header  = '';
        switch ( $section_type ) {
            case self::ITEM_TYPE_POSTS:
                $body        = $this->render_posts_section( $section );
                $item_header = _x( 'Posts', 'BonoPageConstructor', THEME_TEXTDOMAIN );
                break;
            case self::ITEM_TYPE_PRODUCTS:
                $body        = $this->render_products_section( $section );
                $item_header = _x( 'Products', 'BonoPageConstructor', THEME_TEXTDOMAIN );
                break;
            case self::ITEM_TYPE_CATEGORIES:
                $body        = $this->render_categories_section( $section );
                $item_header = _x( 'Categories', 'BonoPageConstructor', THEME_TEXTDOMAIN );
                break;
            case self::ITEM_TYPE_HTML:
                $body        = $this->render_html_section( $section );
                $item_header = _x( 'Html', 'BonoPageConstructor', THEME_TEXTDOMAIN );
                break;
            case self::ITEM_TYPE_SLIDER:
                $body        = $this->render_slider_section( $section );
                $item_header = _x( 'Slider', 'BonoPageConstructor', THEME_TEXTDOMAIN );
                break;
            default:
                break;
        }


        $section_header_text = $this->get_item_value( 'section_header_text', $section );

        echo '<div class="bono-customize-pc-item bono-customize-pc-item--' . $section_type . '" data-type="' . $section_type . '">';
        echo '  <div class="bono-customize-pc-item-header">';
        echo $item_header;
        echo ' <em>' . $section_header_text . '</em>';
        echo '</div>';

        echo '  <div class="bono-customize-pc-item-body">';

        echo $body;

        echo '    <input type="hidden" name="section_type" value="' . $section_type . '">';
        echo '    <span class="button js-bono-customize-pc-delete">' . esc_html__( 'Remove', THEME_TEXTDOMAIN ) . '</span> ';
        echo '  </div>';

        echo '</div><!--.bono-customize-pc-item-->';
    }

    /**
     * @return void
     */
    protected function render_slider_placeholder_tpl( $section = [] ) {
        echo '<div class="bono-customize-pc-item-slide js-bono-customize-pc-slider-item">';

        echo '<div class="bono-customize-pc-item-slide--header js-bono-customize-pc-item--slide-header">';
        echo '    <strong>' . __( 'Slide', THEME_TEXTDOMAIN ) . '</strong>';
        echo '</div><!--.bono-customize-pc-item--slide-header-->';

        echo '<div class="bono-customize-pc-item-slide--content js-bono-customize-pc-item--slide-content" style="display: none">';

        echo '    <label class="bono-customize-pc-label">Тип:</label>';
        echo '    <div class="bono-customize-pc-field">';
        echo '        <select name="slide_items[{{n}}][type]" class="js-bono-customize-pc-slide-item-type" autocomplete="off">';
        echo '            <option value="media">Медиа</option>';
        echo '            <option value="post">Пост</option>';
        echo '            <option value="product">Товар</option>';
        echo '            <option value="category">Категория</option>';
        echo '        </select>';
        echo '    </div>';

        echo '    <div class="js-bono-customize-pc-slide-item-id" style="display: none;">';
        echo '        <label class="bono-customize-pc-label">ID:</label>';
        echo '        <div class="bono-customize-pc-field"><input name="slide_items[{{n}}][id]" type="text" value="" autocomplete="off"></div>';
        echo '    </div>';

        echo '    <div class="js-bono-customize-pc-slide-item-media">';
        echo '        <label class="bono-customize-pc-label">Медиа файл:</label>';
        echo '        <div class="bono-customize-pc-field">';
        echo '            <input name="slide_items[{{n}}][media]" type="text" value="" autocomplete="off">';
        echo '            <span class="button media-button js-bono-customize-pc-slide-item-media-browse">Выбрать файл</span>';
        echo '        </div>';
        echo '    </div>';

        echo '    <label class="bono-customize-pc-label">Заголовок:</label>';
        echo '    <div class="bono-customize-pc-field"><input name="slide_items[{{n}}][header]" type="text" value="" class="js-bono-customize-pc-slide-item-header" autocomplete="off"></div>';

        echo '    <label class="bono-customize-pc-label">Описание:</label>';
        echo '    <div class="bono-customize-pc-field"><textarea rows="5" name="slide_items[{{n}}][description]"></textarea></div>';

        echo '    <label class="bono-customize-pc-label">Текст кнопки:</label>';
        echo '    <div class="bono-customize-pc-field"><input name="slide_items[{{n}}][btn_txt]" type="text" value="" autocomplete="off"></div>';

        echo '    <label class="bono-customize-pc-label">Ссылка:</label>';
        echo '    <div class="bono-customize-pc-field"><input name="slide_items[{{n}}][link]" type="text" value="" autocomplete="off"></div>';


        echo '    <span class="button js-bono-customize-pc-delete-slide-item">Удалить слайд</span>';
        echo '    <span class="bono-customize-pc-item-slide--toggle js-bono-customize-pc-toggle-slide-item" data-label_collapse="Свернуть" data-label_expand="Развернуть">Свернуть</span>';
        echo '</div><!--.bono-customize-pc-item--slide-content-->';

        echo '</div><!--.bono-customize-pc-item-->';
    }

    /**
     * @param array $section
     *
     * @return string
     */
    protected function render_posts_section( $section = [] ) {
        $out = '';

        $out .= '    <label class="bono-customize-pc-label">Заголовок:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="section_header_text" type="text" value="' . esc_attr( $this->get_item_value( 'section_header_text', $section ) ) . '" autocomplete="off"></div>';

        $out .= '    <label class="bono-customize-pc-label">ID рубрик:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="cat" type="text" value="' . esc_attr( $this->get_item_value( 'cat', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Показать только записи:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="post__in" type="text" value="' . esc_attr( $this->get_item_value( 'post__in', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Исключить записи:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="post__not_in" type="text" value="' . esc_attr( $this->get_item_value( 'post__not_in', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Отступ:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="offset" type="number" value="' . esc_attr( $this->get_item_value( 'offset', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Количество постов:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="posts_per_page" type="number" value="' . esc_attr( $this->get_item_value( 'posts_per_page', $section ) ) . '"></div>';

        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '      <label><input name="show_subcategories" type="checkbox"' . checked( true, $this->get_item_value( 'show_subcategories', $section ), false ) . '> show_subcategories</label>';
        $out .= '    </div>';

        $out .= '    <label class="bono-customize-pc-label">Вид карточек:</label>';
        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '      <select name="post_card_type">';
        foreach ( $this->post_card_types as $post_card_type ) {
            $out .= '<option value="' . $post_card_type . '"' . selected( $post_card_type, $this->get_item_value( 'post_card_type', $section ), false ) . '>' . $post_card_type . '</option>';
        }
        $out .= '      </select>';
        $out .= '    </div>';

        $out .= '<div class="bono-customize-pc-field">';
        $out .= '    <span class="button bono-customize-pc-post-card-settings-open">Настройка карточек постов</span>';
        $out .= '</div>';

        $out .= '<div class="bono-customize-pc-post-card-settings">';

        foreach ( $this->post_card_elements as $post_card_element_key => $post_card_element_label ) {
            $out .= $this->post_card_settings_options( $post_card_element_label, 'show_' . $post_card_element_key, $this->get_item_value( 'show_' . $post_card_element_key, $section ) );
        }

        $out .= '</div>';

        $out .= $this->render_pc_presets( $section );

        return $out;
    }

    /**
     * @param array $section
     *
     * @return string
     */
    protected function render_products_section( $section = [] ) {
        $out = '';

        $out .= '    <label class="bono-customize-pc-label">Заголовок:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="section_header_text" type="text" value="' . esc_attr( $this->get_item_value( 'section_header_text', $section ) ) . '" autocomplete="off"></div>';

        $out .= '    <label class="bono-customize-pc-label">ID категорий:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="cat" type="text" value="' . esc_attr( $this->get_item_value( 'cat', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Показать только товары:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="post__in" type="text" value="' . esc_attr( $this->get_item_value( 'post__in', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Исключить товары:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="post__not_in" type="text" value="' . esc_attr( $this->get_item_value( 'post__not_in', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Отступ:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="offset" type="number" value="' . esc_attr( $this->get_item_value( 'offset', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Количество товаров:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="posts_per_page" type="number" value="' . esc_attr( $this->get_item_value( 'posts_per_page', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Вид карточек:</label>';
        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '      <select name="post_card_type">';
        foreach ( $this->product_card_types as $post_card_type ) {
            $out .= '<option value="' . $post_card_type . '"' . selected( $post_card_type, $this->get_item_value( 'post_card_type', $section ), false ) . '>' . $post_card_type . '</option>';
        }
        $out .= '      </select>';
        $out .= '    </div>';


//		$out .= '<div class="bono-customize-pc-field">';
//		$out .= '    <span class="button bono-customize-pc-post-card-settings-open">Настройка карточек товаров</span>';
//		$out .= '</div>';
//
//		$out .= '<div class="bono-customize-pc-post-card-settings">';
//
//		foreach ( $this->product_card_elements as $key => $label ) {
//			$out .= $this->post_card_settings_options( $label, 'show_' . $key, $this->get_item_value( 'show_' . $key, $section ) );
//		}
//
//		$out .= '</div>';


        $out .= $this->render_pc_presets( $section );

        return $out;
    }

    /**
     * @param array $section
     *
     * @return string
     */
    protected function render_categories_section( $section ) {
        $out = '';

        $out .= '    <label class="bono-customize-pc-label">Заголовок:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="section_header_text" type="text" value="' . esc_attr( $this->get_item_value( 'section_header_text', $section ) ) . '" autocomplete="off"></div>';

        $out .= '    <label class="bono-customize-pc-label">ID категорий:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="cat" type="text" value="' . esc_attr( $this->get_item_value( 'cat', $section ) ) . '"></div>';

        $out .= $this->render_pc_presets( $section );

        return $out;
    }

    /**
     * @param array $section
     *
     * @return string
     */
    protected function render_html_section( $section = [] ) {
        $out = '';

        $out .= '    <label class="bono-customize-pc-label">Заголовок:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="section_header_text" type="text" value="' . esc_attr( $this->get_item_value( 'section_header_text', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">HTML:</label>';
        $out .= '    <div class="bono-customize-pc-field"><textarea rows="5" name="html_code">' . esc_textarea( $this->get_item_value( 'html_code', $section ) ) . '</textarea></div>';

        $out .= $this->render_pc_presets( $section );

        return $out;
    }

    protected function render_slider_section( $section = [] ) {
        $items = isset( $section['slide_items'] ) ? $section['slide_items'] : [];;

        $out = '';
        $out .= '    <label class="bono-customize-pc-label">Название:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="section_header_text" type="text" value="' . esc_attr( $this->get_item_value( 'section_header_text', $section ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Количество слайдов:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="slides_per_view" type="number" min="1" max="10" value="' . esc_attr( $this->get_item_value( 'slides_per_view', $section, 1 ) ) . '"></div>';

        $out .= '    <label class="bono-customize-pc-label">Скорость прокрутки:</label>';
        $out .= '    <div class="bono-customize-pc-field"><input name="delay" type="number" min="0" max="10" value="' . esc_attr( $this->get_item_value( 'delay', $section, '2500' ) ) . '">';
        $out .= '        <span class="description customize-control-description">Значение в мс. Если не задано, то без автопропкрутки</span></div>';


        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '        <label>';
        $out .= '            <input type="checkbox" name="width_full" value="1"' . checked( $this->get_item_value( 'width_full', $section, false ), true, false ) . '> На всю ширину';
        $out .= '        </label>';
        $out .= '        <span class="description customize-control-description">' . __( 'This option will not apply if sidebar enabled.', THEME_TEXTDOMAIN ) . '</span>';
        $out .= '    </div>';

        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '        <label>';
        $out .= '            <input type="checkbox" name="disable_on_mobile" value="1"' . checked( $this->get_item_value( 'disable_on_mobile', $section, false ), true, false ) . '> ';
        $out .= '            ' . esc_html__( 'Disable on mobile', THEME_TEXTDOMAIN );
        $out .= '        </label>';
        $out .= '    </div>';


        $out .= '    <div class="bono-customize-pc-slider-items js-bono-customize-pc-slider-items" data-items="' . esc_attr( json_encode( $items ) ) . '">';

        $out .= '    </div>';

        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '        <span class="button js-bono-customize-pc-add-slide-item" data-type="slider-item">Добавить слайд</span>';
        $out .= '    </div>';

//		$out .= $this->get_item_value( 'slide_items', $section );


//		$options = theme_container()->get( ThemeOptions::class );
//		$out     .= ( new \WP_Customize_Image_Control( $this->manager, $options->option_name . '[asd]' ) )->content_template();

        return $out;
    }

    /**
     * @param string $label
     * @param string $name
     * @param string $value
     *
     * @return string
     */
    protected function post_card_settings_options( $label = '', $name = '', $value = '' ) {
        $out = '';
        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '        <label>' . $label . '</label>';
        $out .= '        <select name="' . $name . '">';

        $out .= '            <option ' . selected( 'default', $value, false ) . ' value="default">по умолчанию</option>';
        $out .= '            <option ' . selected( 'show', $value, false ) . ' value="show">показывать</option>';
        $out .= '            <option ' . selected( 'hide', $value, false ) . ' value="hide">спрятать</option>';

        $out .= '        </select>';
        $out .= '    </div>';

        return $out;
    }

    /**
     * @param array $section
     *
     * @return string
     */
    protected function render_pc_presets( $section = [] ) {
        $out          = '';
        $preset_value = $this->get_item_value( 'preset', $section );

        $out .= '    <label class="bono-customize-pc-label">Пресеты:</label>';
        $out .= '    <div class="bono-customize-pc-field">';
        $out .= '    <div class="bono-customize-pc-presets">';
        foreach ( $this->presets as $preset ) {
            $active = ( $preset_value == $preset ) ? ' active' : '';
            $out    .= '        <span class="bono-customize-pc-preset preset-' . $preset . $active . '" data-preset-name="' . $preset . '"></span>';
        }
        $out .= '        <input type="hidden" name="preset" value="' . esc_attr( $preset_value ) . '">';
        $out .= '    </div>';
        $out .= '    </div>';

        return $out;
    }

    /**
     * @param string $name
     * @param array  $section
     * @param string $default
     *
     * @return mixed|string
     */
    protected function get_item_value( $name, $section = [], $default = '' ) {
        if ( isset( $section[ $name ] ) ) {
            return $section[ $name ];
        }

        return $default;
    }

    /**
     * @inheritDoc
     */
    public function enqueue() {
        wp_enqueue_style( 'bono-customize-control-' . $this->type, trailingslashit( get_template_directory_uri() ) . 'assets/css/' . $this->type . '.min.css' );
        wp_enqueue_script( 'bono-customize-control-' . $this->type, trailingslashit( get_template_directory_uri() ) . 'assets/js/theme/' . $this->type . '.js', [ 'jquery' ], null, true );
        wp_localize_script( 'bono-customize-control-' . $this->type, 'BonoPageConstructor', [
            'slide_items_count' => 0,
        ] );
    }
}
