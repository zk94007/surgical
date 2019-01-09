<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
 * <?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package StoreCommerce
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses storecommerce_header_style()
 */
function storecommerce_custom_header_setup()
{
    add_theme_support('custom-header', apply_filters('storecommerce_custom_header_args', array(
        'default-image' => '',
        'default-text-color' => '000000',
        'width' => 1500,
        'height' => 175,
        'flex-height' => true,
        'wp-head-callback' => 'storecommerce_header_style',
    )));
}

add_action('after_setup_theme', 'storecommerce_custom_header_setup');

if (!function_exists('storecommerce_header_style')) :
    /**
     * Styles the header image and text displayed on the blog.
     *
     * @see storecommerce_custom_header_setup().
     */
    function storecommerce_header_style()
    {
        $header_text_color = get_header_textcolor();
        $site_title_font_size = storecommerce_get_option('site_title_font_size');
        $enable_tint_overlay = storecommerce_get_option('enable_header_image_tint_overlay');

        /*
         * If no custom options for text are set, let's bail.
         * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
         */
        if (get_theme_support('custom-header', 'default-text-color') === $header_text_color) {
            return;
        }

        // If we get this far, we have custom styles. Let's do this.
        ?>
        <style type="text/css">
            body .header-left-part .logo-brand .site-title {
                font-size: <?php echo esc_attr( $site_title_font_size ); ?>px;
            }
            <?php

           if($enable_tint_overlay):
            ?>
             body .aft-header-background.data-bg:before {
                 content: "";
                 position: absolute;
                 left: 0;
                 right: 0;
                 top: 0;
                 bottom: 0;
                 background: rgba(0, 0, 0, .5);
             }
            <?php
            endif;
            // Has the text been hidden?
            if ( ! display_header_text() ) :
                ?>
            .site-title,
            .site-description {
                position: absolute;
                clip: rect(1px, 1px, 1px, 1px);
            }

            <?php
            // If the user has set a custom color for the text use that.
            else :
                ?>
            body.home .header-style-2.aft-transparent-header .cart-shop, body.home .header-style-2.aft-transparent-header .account-user a, body.home .header-style-2.aft-transparent-header .open-search-form, body.home .header-style-2.aft-transparent-header .aft-wishlist-trigger, body.home .header-style-2.aft-transparent-header .header-left-part .logo-brand .site-title a, body.home .header-style-2.aft-transparent-header .header-left-part .logo-brand .site-description,
            body .header-left-part .logo-brand .site-title a,
            body .header-left-part .logo-brand .site-title a:hover,
            body .header-left-part .logo-brand .site-title a:visited,
            body .header-left-part .logo-brand .site-description,
            body .header-style-3 .account-user a,
            body .header-style-3 .account-user a:visited,
            body .header-style-3 .account-user a:hover {

                color: #<?php echo esc_attr( $header_text_color ); ?>;
            }

            <?php endif; ?>
        </style>
        <?php
    }
endif;
