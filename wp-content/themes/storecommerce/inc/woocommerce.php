<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package StoreCommerce
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function storecommerce_woocommerce_setup()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'storecommerce_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function storecommerce_woocommerce_scripts()
{
    wp_enqueue_style('storecommerce-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array('storecommerce-style'));

    $font_path = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

    wp_add_inline_style('storecommerce-woocommerce-style', $inline_font);
}

//add_action('wp_enqueue_scripts', 'storecommerce_woocommerce_scripts', 9999);

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function storecommerce_woocommerce_active_body_class($classes)
{
    $classes[] = 'woocommerce-active';

    return $classes;
}

add_filter('body_class', 'storecommerce_woocommerce_active_body_class');





//Shop page control
if (!function_exists('storecommerce_loop_shop_columns')) {
    function storecommerce_loop_shop_columns($cols)
    {
        // $cols contains the current number of products per page based on the value stored on Options -> Reading
        // Return the number of products you wanna show per page.
        $cols = storecommerce_get_option('store_product_shop_page_row');;
        return $cols;
    }
}
add_filter( 'loop_shop_columns', 'storecommerce_loop_shop_columns', 20 );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function storecommerce_woocommerce_products_per_page()
{
    $product_loop = storecommerce_get_option('store_product_shop_page_product_per_page');;
    return $product_loop;
}

add_filter('loop_shop_per_page', 'storecommerce_woocommerce_products_per_page');




/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function storecommerce_woocommerce_loop_columns()
{
    $cols = storecommerce_get_option('store_product_shop_page_row');
    return $cols;
}

add_filter('loop_shop_columns', 'storecommerce_woocommerce_loop_columns');


/**
 * Remove product zoom
 */
if (!function_exists('storecommerece_remove_product_zoom')) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function storecommerece_remove_product_zoom($tabs)
    {
        $product_zoom = storecommerce_get_option('store_product_page_product_zoom');
        if($product_zoom == 'no'){
            remove_theme_support( 'wc-product-gallery-zoom' );
            remove_theme_support( 'wc-product-gallery-lightbox' );
        }
        return $tabs;
    }
}
add_action( 'wp_loaded', 'storecommerece_remove_product_zoom', 9999 );



/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function storecommerce_woocommerce_related_products_args($args)
{
    $cols = storecommerce_get_option('store_product_page_related_products_per_row');

    $defaults = array(
        'posts_per_page' => 3,
        'columns' => $cols,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}

add_filter('woocommerce_output_related_products_args', 'storecommerce_woocommerce_related_products_args');


/**
 * Remove related products output
 */
if (!function_exists('storecommerece_remove_related_products')) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function storecommerece_remove_related_products()
    {
        $related_products = storecommerce_get_option('store_product_page_related_products');
        if($related_products == 'no'){
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
        }

    }
}
add_action('wp_loaded', 'storecommerece_remove_related_products');



if (!function_exists('storecommerce_woocommerce_product_columns_wrapper')) {
    /**
     * Product columns wrapper.
     *
     * @return  void
     */
    function storecommerce_woocommerce_product_columns_wrapper()
    {
        $columns = storecommerce_woocommerce_loop_columns();
        echo '<div class="columns-' . absint($columns) . '">';
    }
}
add_action('woocommerce_before_shop_loop', 'storecommerce_woocommerce_product_columns_wrapper', 40);



if (!function_exists('storecommerce_woocommerce_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close.
     *
     * @return  void
     */
    function storecommerce_woocommerce_product_columns_wrapper_close()
    {
        echo '</div>';
    }
}
add_action('woocommerce_after_shop_loop', 'storecommerce_woocommerce_product_columns_wrapper_close', 40);

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('storecommerce_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function storecommerce_woocommerce_wrapper_before()
    {
        ?>
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
    }
}
add_action('woocommerce_before_main_content', 'storecommerce_woocommerce_wrapper_before');

if (!function_exists('storecommerce_woocommerce_wrapper_after')) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function storecommerce_woocommerce_wrapper_after()
    {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php
    }
}
add_action('woocommerce_after_main_content', 'storecommerce_woocommerce_wrapper_after');



if (!function_exists('storecommerce_product_count')) {
    function storecommerce_product_count($category_id = 0)
    {

        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $category_id, // Replace with the parent category ID
                    'include_children' => true,
                ),
            ),
            'nopaging' => true,
            'fields' => 'ids',
        );


        $query = new WP_Query($args);
        $count = $query->found_posts;
        return absint($count);
    }
}


/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 * <?php
 * if ( function_exists( 'storecommerce_woocommerce_header_cart' ) ) {
 * storecommerce_woocommerce_header_cart();
 * }
 * ?>
 */

if (!function_exists('storecommerce_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function storecommerce_woocommerce_header_cart()
    {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>

        <div class="af-cart-wrap">
            <div class="af-cart-icon-and-count dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                 aria-expanded="true">
                <i class="fa fa-shopping-cart"></i>
                <span class="item-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
            </div>
            <div class="top-cart-content primary-bgcolor dropdown-menu">
                <ul class="site-header-cart">

                    <li>
                        <?php
                        $instance = array(
                            'title' => '',
                        );

                        the_widget('WC_Widget_Cart', $instance);
                        ?>
                    </li>
                </ul>
            </div>
        </div>

        <?php
    }
}

if (!function_exists('storecommerce_woocommerce_cart_link_fragment')) {
    /**
     * Cart Fragments.
     *
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param array $fragments Fragments to refresh via AJAX.
     * @return array Fragments to refresh via AJAX.
     */
    function storecommerce_woocommerce_cart_link_fragment($fragments)
    {
        ob_start();
        storecommerce_woocommerce_cart_icon();
        $fragments['.af-cart-icon-and-count'] = ob_get_clean();

        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'storecommerce_woocommerce_cart_link_fragment');


if (!function_exists('storecommerce_woocommerce_cart_icon')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function storecommerce_woocommerce_cart_icon()
    {
        ?>
        <div class="af-cart-icon-and-count dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="fa fa-shopping-cart"></i>
            <span class="item-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
        </div>
        <?php
    }
}

if (!function_exists('storecommerce_woocommerce_cart_link')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function storecommerce_woocommerce_cart_link()
    {
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'storecommerce'); ?>">
            <?php
            $item_count_text = sprintf(
            /* translators: number of items in the mini cart. */
                _n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'storecommerce'),
                WC()->cart->get_cart_contents_count()
            );
            ?>
            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span
                    class="count"><?php echo esc_html($item_count_text); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('storecommerce_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function storecommerce_woocommerce_header_cart()
    {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
        <ul id="site-header-cart" class="site-header-cart">
            <li class="<?php echo esc_attr($class); ?>">
                <?php storecommerce_woocommerce_cart_link(); ?>
            </li>
            <li>
                <?php
                $instance = array(
                    'title' => '',
                );

                the_widget('WC_Widget_Cart', $instance);
                ?>
            </li>
        </ul>
        <?php
    }
}

/**
 * Remove the breadcrumbs
 */
add_action('wp_loaded', 'storecommerce_replace_wc_breadcrumbs');
function storecommerce_replace_wc_breadcrumbs()
{
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    $enable_breadcrumbs = storecommerce_get_option('store_enable_breadcrumbs');
    if($enable_breadcrumbs == 'yes'){
        add_action('storecommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    }

}

/*Display YITH Wishlist Buttons at shop page*/
if (!function_exists('storecommerce_display_yith_wishlist_loop')) {
    /**
     * Display YITH Wishlist Buttons at product archive page
     *
     */
    function storecommerce_display_yith_wishlist_loop()
    {
        if(!function_exists('YITH_WCWL')){
            return;
        }

        echo '<div class="yith-btn">';
        echo do_shortcode("[yith_wcwl_add_to_wishlist]");
        echo '</div>';
    }
}


add_action('storecommerce_woocommerce_add_to_wishlist_button', 'storecommerce_display_yith_wishlist_loop', 16);



if (!function_exists('storecommerce_woocommerce_header_wishlist')) {
    /**
     * Display Header Wishlist.
     *
     * @return void
     */
    function storecommerce_woocommerce_header_wishlist()
    {
        ?>
        <div class="aft-wishlist aft-woo-nav">
            <div class="aft-wooicon">
                <a class="aft-wishlist-trigger" href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>">
                    <?php
                    //$wishlist_icon = storecommerce_get_option('wishlist_icon', true);
                    //if( $wishlist_icon ){
                    echo '<i class="fa fa-heart"></i>';
                    //}
                    ?>
                    <span class="aft-woo-counter"><?php echo absint(yith_wcwl_count_all_products()); ?></span>
                </a>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('storecommerce_update_wishlist_count')) {
    /**
     * Return Wishlist product count.
     */
    function storecommerce_update_wishlist_count()
    {
        if (class_exists('YITH_WCWL')) {

        wp_send_json(array(
            'count' => yith_wcwl_count_all_products()
        ));
    }
    }
}
add_action('wp_ajax_storecommerce_update_wishlist_count', 'storecommerce_update_wishlist_count');
add_action('wp_ajax_nopriv_storecommerce_update_wishlist_count', 'storecommerce_update_wishlist_count');

if (!function_exists('storecommerce_display_wishlist_message')) {
    /**
     * Return Wishlist product added message.
     */
    function storecommerce_display_wishlist_message($msg)
    {
        if (class_exists('YITH_WCWL')) {
            if (property_exists('YITH_WCWL', 'details')) {
                $details = YITH_WCWL()->details;
                if (is_array($details) && isset($details['add_to_wishlist'])) {
                    $product_id = $details['add_to_wishlist'];
                    $product = wc_get_product($product_id);
                    if (!is_wp_error($product)) {
                        $product_title = sprintf(__('%s has been added to your wishist.', 'storecommerce'), '<strong>' . $product->get_title() . '</strong>');
                        $product_image = $product->get_image();

                        ob_start();
                        ?>
                        <div class="aft-notification-header">
                            <h3><?php _e('WishList Items', 'storecommerce') ?></h3>
                        </div>
                        <div class="aft-notification">
                            <div class="aft-notification-image">
                                <?php echo $product_image; ?>
                            </div>
                            <div class="aft-notification-title">
                                <?php echo $product_title; ?>
                            </div>
                        </div>
                        <div class="aft-notification-button">
                            <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>">
                                <?php _e('View Wishlist', 'storecommerce') ?>
                            </a>
                        </div>

                        <?php
                        $msg = ob_get_clean();
                    }
                }
            }
        }
        return $msg;
    }
}
add_filter('yith_wcwl_product_added_to_wishlist_message', 'storecommerce_display_wishlist_message');

/*Display YITH Quickview Buttons at shop page*/
if (!function_exists('storecommerce_display_yith_quickview_loop')) {
    /**
     * Display YITH Wishlist Buttons at product archive page
     *
     */
    function storecommerce_display_yith_quickview_loop()
    {

        if(!function_exists('yith_wcqv_install')){
            return;
        }

        echo '<div class="yith-btn">';
        global $product, $post;
        $product_id = $post->ID;

        if (!$product_id) {
            $product instanceof WC_Product && $product_id = yit_get_prop($product, 'id', true);
        }

        $button = '';
        if ($product_id) {
            // get label
            $button = '<a href="#" class="button yith-wcqv-button" data-product_id="' . $product_id . '"><div data-toggle="tooltip" data-placement="top" title="Quick View"><i class="fa fa-eye" aria-hidden="true"></i></div></a>';
        }
        echo $button;
        echo '</div>';


    }
}


add_action('storecommerce_woocommerce_yith_quick_view_button', 'storecommerce_display_yith_quickview_loop', 16);


/*Display YITH Compare Buttons at shop page*/
if (!function_exists('storecommerce_display_yith_compare_loop')) {
    /**
     * Display YITH Wishlist Buttons at product archive page
     *
     */
    function storecommerce_display_yith_compare_loop()
    {

        if(!class_exists('YITH_Woocompare')){
            return;
        }

        echo '<div class="yith-btn">';
        global $product, $post;
        $product_id = $post->ID;

        if (!$product_id) {
            $product instanceof WC_Product && $product_id = yit_get_prop($product, 'id', true);
        }

        $button = '';
        if ($product_id) {

            $button = do_shortcode('[yith_compare_button type="link" button_text="<i class="fa fa-adjust" aria-hidden="true"></i>"]');

        }
        echo $button;
        echo '</div>';


    }
}

//$enable_wishlists_on_listings = storecommerce_get_option('enable_wishlists_on_listings', true);
//if( $enable_wishlists_on_listings ){
add_action('storecommerce_woocommerce_yith_compare_button', 'storecommerce_display_yith_compare_loop', 16);
//}

if (!function_exists('storecommerec_sale_flash')) {
    function storecommerec_sale_flash($content, $post, $product)
    {
        $sale_flash = storecommerce_get_option('store_single_sale_text');
        if(!empty($sale_flash)){
            $content = '<span class="onsale">' . $sale_flash . '</span>';
        }

        return $content;
    }
}
add_filter('woocommerce_sale_flash', 'storecommerec_sale_flash', 10, 3);


/*Display YITH Quickview Buttons at shop page*/
if (!function_exists('storecommerce_add_to_cart_text')) {

    function storecommerce_add_to_cart_text($add_to_cart_texts) {
        global $product;

        $simple = storecommerce_get_option('store_simple_add_to_cart_text');

        if($product->is_type( 'simple' )){
            return $simple;
        }


        return $add_to_cart_texts;

    }

}
// Single Product
add_filter( 'woocommerce_product_add_to_cart_text', 'storecommerce_add_to_cart_text', 10, 2 );


/*Display YITH Quickview Buttons at shop page*/
if (!function_exists('storecommerce_single_add_to_cart_text')) {

    function storecommerce_single_add_to_cart_text() {
        $button_texts = storecommerce_get_option('store_single_add_to_cart_text');
        return $button_texts; // Change this to change the text on the Single Product Add to cart button.
    }

}
// Single Product
add_filter( 'woocommerce_product_single_add_to_cart_text', 'storecommerce_single_add_to_cart_text' );





if (!function_exists('storecommerce_woocommerce_template_loop_hooks')) :

    function storecommerce_woocommerce_template_loop_hooks()  {

        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
        add_action('storecommerce_woocommerce_template_loop_product_link_open', 'woocommerce_template_loop_product_link_open');
        add_action('storecommerce_woocommerce_template_loop_product_link_close', 'woocommerce_template_loop_product_link_close');
        add_action('storecommerce_woocommerce_show_product_loop_sale_flash', 'woocommerce_show_product_loop_sale_flash');
        add_action('storecommerce_woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail');
        add_action('storecommerce_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        add_action('storecommerce_woocommerce_template_loop_rating', 'woocommerce_template_loop_rating', 5);
        add_action('storecommerce_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
        add_action('storecommerce_woocommerce_template_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart');
    }
endif;

add_action('wp_loaded', 'storecommerce_woocommerce_template_loop_hooks');