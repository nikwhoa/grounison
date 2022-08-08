<?php

/**
 * Child theme of Bono
 * https://wpshop.ru/themes/bono
 *
 * @package Bono
 */

function load_swiper_bundle()
{
  wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), false, true);
}
function bono_child_script_enqueue_script()
{
  wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/js/script.js', array('swiper'), false, true);
}

add_action('wp_enqueue_scripts', 'bono_child_script_enqueue_script');
add_action('wp_enqueue_scripts', 'load_swiper_bundle');


/**
 * Enqueue child styles
 *
 * НЕ УДАЛЯЙТЕ ДАННЫЙ КОД
 */
add_action('wp_enqueue_scripts', 'enqueue_child_theme_styles', 100);
function enqueue_child_theme_styles()
{
  wp_enqueue_style('bono-style-child', get_stylesheet_uri(), array('bono-style'));
}

/*
* Load google fonts
*/
function wpb_add_google_fonts()
{
  wp_enqueue_style(
    'wpb-google-fonts',
    'https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap',
    false
  );
}

add_action('wp_enqueue_scripts', 'wpb_add_google_fonts');

/**
 * НИЖЕ ВЫ МОЖЕТЕ ДОБАВИТЬ ЛЮБОЙ СВОЙ КОД
 */


/*
 * Function for post duplication. Dups appear as drafts. User is redirected to the edit screen
 */
function rd_duplicate_post_as_draft()
{
  global $wpdb;
  if (!(isset($_GET['post']) || isset($_POST['post'])  || (isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action']))) {
    wp_die('No post to duplicate has been supplied!');
  }

  /*
   * Nonce verification
   */
  if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__)))
    return;

  /*
   * get the original post id
   */
  $post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));
  /*
   * and all the original post data then
   */
  $post = get_post($post_id);

  /*
   * if you don't want current user to be the new post author,
   * then change next couple of lines to this: $new_post_author = $post->post_author;
   */
  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;

  /*
   * if post data exists, create the post duplicate
   */
  if (isset($post) && $post != null) {

    /*
     * new post data array
     */
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );

    /*
     * insert the post by wp_insert_post() function
     */
    $new_post_id = wp_insert_post($args);

    /*
     * get all current post terms ad set them to the new post draft
     */
    $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }

    /*
     * duplicate all post meta just in two SQL queries
     */
    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
    if (count($post_meta_infos) != 0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        if ($meta_key == '_wp_old_slug') continue;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }
      $sql_query .= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }


    /*
     * finally, redirect to the edit post screen for the new draft
     */
    wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action('admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft');

/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link($actions, $post)
{
  if (current_user_can('edit_posts')) {
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
  }
  return $actions;
}

add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);





add_filter('woocommerce_checkout_fields', 'truemisha_del_fields', 25);

function truemisha_del_fields($fields)
{

  // оставляем эти поля
  // unset( $fields[ 'billing' ][ 'billing_first_name' ] ); // имя
  // unset( $fields[ 'billing' ][ 'billing_last_name' ] ); // фамилия
  // unset( $fields[ 'billing' ][ 'billing_phone' ] ); // телефон
  // unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл

  // удаляем все эти поля
  unset($fields['billing']['billing_company']); // компания
  //unset( $fields[ 'billing' ][ 'billing_country' ] );  страна
  unset($fields['billing']['billing_address_1']); // адрес 1
  unset($fields['billing']['billing_address_2']); // адрес 2
  unset($fields['billing']['billing_city']); // город
  //unset( $fields[ 'billing' ][ 'billing_state' ] );  регион, штат
  unset($fields['billing']['billing_postcode']); // почтовый индекс
  // unset( $fields[ 'order' ][ 'order_comments' ] ); // заметки к заказу

  return $fields;
}

add_filter('woocommerce_email_subject_customer_processing_order', 'customizing_on_hold_email_subject', 10, 2);
function customizing_on_hold_email_subject($formated_subject, $order)
{
  if ($order->get_customer_note() == 'ee') {
    return __('Teie tellimus on kätte saadud!', "woocommerce");
  }
  if ($order->get_customer_note() == 'ru') {
    return __('Ваш заказ был успешно создан!', "woocommerce");
  }
}

add_filter('woocommerce_subcategory_count_html', 'filter_function_name_4815', 10, 2);
function filter_function_name_4815($html, $category)
{
  // filter...

  return false;
}

//dsfsdf

// cart and checkout inline styles (To be removed and added in your theme styles.css file)
add_action('wp_head', 'custom_inline_styles', 900);
function custom_inline_styles()
{
  if (is_checkout() || is_cart()) {
?><style>
      .product-item-thumbnail {
        float: left;
        padding-right: 10px;
      }

      .product-item-thumbnail img {
        margin: 0 !important;
      }

      .product-name {
        display: flex;
        align-items: center;
      }
    </style><?php
          }
        }

        // Product thumbnail in checkout
        add_filter('woocommerce_cart_item_name', 'product_thumbnail_in_checkout', 20, 3);
        function product_thumbnail_in_checkout($product_name, $cart_item, $cart_item_key)
        {
          if (is_checkout()) {

            $thumbnail   = $cart_item['data']->get_image(array(70, 70));
            $image_html  = '<div class="product-item-thumbnail">' . $thumbnail . '</div> ';

            $product_name = $image_html . $product_name;
          }
          return $product_name;
        }

        // Cart item qquantity in checkout
        add_filter('woocommerce_checkout_cart_item_quantity', 'filter_checkout_cart_item_quantity', 20, 3);
        function filter_checkout_cart_item_quantity($quantity_html, $cart_item, $cart_item_key)
        {
          return ' <strong class="product-quantity">' . sprintf('&times; %s', $cart_item['quantity']) . '</strong><br clear="all">';
        }

        // Product attribute in cart and checkout
        add_filter('woocommerce_get_item_data', 'product_descrition_to_cart_items', 20, 2);
        function product_descrition_to_cart_items($cart_item_data, $cart_item)
        {
          $product_id = $cart_item['product_id'];
          $product = wc_get_product($product_id);
          $taxonomy = 'pa_delivery';
          $value = $product->get_attribute($taxonomy);
          if ($product->get_attribute($taxonomy)) {
            $cart_item_data[] = array(
              'name' => get_taxonomy($taxonomy)->labels->singular_name,
              'value' => $product->get_attribute($taxonomy),
            );
          }
          return $cart_item_data;
        }




        /**
         * Change cart buttons
         */

        add_action('woocommerce_widget_shopping_cart_buttons', function () {
          // Removing Buttons
          remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
          remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

          // Adding customized Buttons
          add_action('woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_button_view_cart', 10);
          add_action('woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_proceed_to_checkout', 20);
        }, 1);

        // Custom cart button
        function custom_widget_shopping_cart_button_view_cart()
        {
          $original_link = wc_get_cart_url();
          $custom_link = home_url('/cart'); // HERE replacing checkout link
          echo '<a href="' . esc_url($custom_link) . '" class="button wc-forward">' . esc_html__('View cart', 'woocommerce') . '</a>';
        }

        // Custom Checkout button
        function custom_widget_shopping_cart_proceed_to_checkout()
        {
          $original_link = wc_get_checkout_url();
          $custom_link = home_url('/checkout'); // HERE replacing checkout link
          echo '<a href="' . esc_url($custom_link) . '" class="button checkout wc-forward">' . esc_html__('Checkout', 'woocommerce') . '</a>';
        }




        // change the text of the add to cart button according to the language
        add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text', 99, 1);
        add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text', 99, 1);
        function woocommerce_custom_single_add_to_cart_text($text)
        {

          // returns the current language "Polylang"
          switch (pll_current_language()) {
            case 'ru':
              return __('В корзину', 'woocommerce');
            case 'ee':
              return __('Lisa korvi', 'woocommerce');
          }

          return $text;
        }
