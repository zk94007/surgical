<?php
/**
 * StoreCommerce functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package StoreCommerce
 */

if (!function_exists('storecommerce_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function storecommerce_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on StoreCommerce, use a find and replace
         * to change 'storecommerce' to the name of your theme in all the template files.
         */
        load_theme_textdomain('storecommerce', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // Add featured image sizes
        add_image_size('storecommerce-slider-full', 1440, 900, true); // width, height, crop
        add_image_size('storecommerce-featured', 1024, 0, false); // width, height, crop
        add_image_size('storecommerce-medium-center', 936, 897, true); // width, height, crop
        add_image_size('storecommerce-thumbnail', 450, 450, true); // width, height, crop

        /*
     * Enable support for Post Formats on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/post-formats/
     */
        add_theme_support('post-formats', array('image', 'video'));

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'aft-primary-nav' => esc_html__('Primary Menu', 'storecommerce'),
            'aft-social-nav' => esc_html__('Social Menu', 'storecommerce'),
            'aft-footer-nav' => esc_html__('Footer Menu', 'storecommerce'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('storecommerce_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');



        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));


    }
endif;
add_action('after_setup_theme', 'storecommerce_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function storecommerce_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('storecommerce_content_width', 640);
}

add_action('after_setup_theme', 'storecommerce_content_width', 0);

/**
 * Demo export/import
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package StoreCommerce
 */
if (!function_exists('storecommerce_ocdi_files')) :
    /**
     * OCDI files.
     *
     * @since 1.0.0
     *
     * @return array Files.
     */
    function storecommerce_ocdi_files()
    {

        return apply_filters('aft_demo_import_files', array(
            array(

                'import_file_name' => esc_html__('StoreCommerce Default', 'storecommerce'),
                'local_import_file' => trailingslashit(get_template_directory()) . 'demo-content/default/storecommerce.xml',
                'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demo-content/default/storecommerce.wie',
                'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demo-content/default/storecommerce.dat',
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-content/assets/storecommerce-default.jpg',
                'preview_url' => 'https://demo.afthemes.com/storecommerce/',
            ),
            array(

                'import_file_name' => esc_html__('StoreCommerce Gadgets', 'storecommerce'),
                'local_import_file' => trailingslashit(get_template_directory()) . 'demo-content/gadgets/storecommerce.xml',
                'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demo-content/gadgets/storecommerce.wie',
                'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demo-content/gadgets/storecommerce.dat',
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-content/assets/storecommerce-gadgets.jpg',
                'preview_url' => 'https://demo.afthemes.com/storecommerce/gadgets',
            ),
            array(

                'import_file_name' => esc_html__('StoreCommerce Interior', 'storecommerce'),
                'local_import_file' => trailingslashit(get_template_directory()) . 'demo-content/interior/storecommerce.xml',
                'local_import_widget_file' => trailingslashit(get_template_directory()) . 'demo-content/interior/storecommerce.wie',
                'local_import_customizer_file' => trailingslashit(get_template_directory()) . 'demo-content/interior/storecommerce.dat',
                'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'demo-content/assets/storecommerce-interior.jpg',
                'preview_url' => 'https://demo.afthemes.com/storecommerce/interior',
            ),

        ));
    }
endif;
add_filter('pt-ocdi/import_files', 'storecommerce_ocdi_files');


/**
 * function for google fonts
 */
if (!function_exists('storecommerce_fonts_url')):

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function storecommerce_fonts_url()
    {

        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Oswald, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Source Sans Pro font: on or off', 'storecommerce')) {
            $fonts[] = 'Source+Sans+Pro:400,400i,700,700i';
        }

        /* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Lato font: on or off', 'storecommerce')) {
            $fonts[] = 'Raleway:400,300,500,600,700,900';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'subset' => urldecode($subsets),
            ), 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;

    }
endif;


/**
 * Enqueue scripts and styles.
 */
function storecommerce_scripts()
{

    $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap' . $min . '.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome' . $min . '.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/owl-carousel-v2/assets/owl.carousel' . $min . '.css');
    wp_enqueue_style('owl-theme-default', get_template_directory_uri() . '/assets/owl-carousel-v2/assets/owl.theme.default.css');
    wp_enqueue_style('sidr', get_template_directory_uri() . '/assets/sidr/css/jquery.sidr.dark.css');

    wp_enqueue_script('matchheight', get_template_directory_uri() . '/assets/jquery-match-height/jquery.matchHeight' . $min . '.js', array('jquery'), '', true);


    $fonts_url = storecommerce_fonts_url();

    if (!empty($fonts_url)) {
        wp_enqueue_style('storecommerce-google-fonts', $fonts_url, array(), null);
    }


    /**
     * Load WooCommerce compatibility file.
     */
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('storecommerce-woocommerce-style', get_template_directory_uri() . '/woocommerce.css');

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
    wp_enqueue_style('storecommerce-style', get_stylesheet_uri());

    wp_enqueue_script('storecommerce-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);
    wp_enqueue_script('storecommerce-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }


    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap' . $min . '.js', array('jquery'), '', true);
    wp_enqueue_script('sidr', get_template_directory_uri() . '/assets/sidr/js/jquery.sidr' . $min . '.js', array('jquery'), '', true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/owl-carousel-v2/owl.carousel' . $min . '.js', array('jquery'), '', true);
    if (function_exists('YITH_WCWL')){
        wp_enqueue_script('storecommerce-wishlist-script', get_template_directory_uri() . '/assets/wishlist.js', array('jquery'), '', true);
    }
    wp_enqueue_script('storecommerce-script', get_template_directory_uri() . '/assets/script.js', array('jquery', 'jquery-ui-accordion'), '', 1);
    

   $disable_sticky_header_option = storecommerce_get_option('disable_sticky_header_option');
    if($disable_sticky_header_option == false ){        
        wp_enqueue_script('storecommerce-fixed-header-script', get_template_directory_uri() . '/assets/fixed-header-script.js', array('jquery'), '', true);
    }

}

add_action('wp_enqueue_scripts', 'storecommerce_scripts');


/**
 * Enqueue admin scripts and styles.
 *
 * @since StoreCommerce 1.0.0
 */
function storecommerce__admin_scripts($hook)
{
    if ('widgets.php' === $hook) {
        wp_enqueue_script('jquery');
        wp_enqueue_media();
        wp_enqueue_script('storecommerce-widgets', get_template_directory_uri() . '/assets/widgets.js', array('jquery'), '1.0.0', true);
    }
}

add_action('admin_enqueue_scripts', 'storecommerce__admin_scripts');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/ocdi.php';

function print_pre($args)
{
    if ($args) {
        echo "<pre>";
        print_r($args);
        echo "</pre>";
    } else {
        echo "<pre>";
        print_r('Empty');
        echo "</pre>";
    }

}