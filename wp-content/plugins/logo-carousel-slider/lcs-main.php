<?php
/*
Plugin Name: Logo Carousel Slider
Plugin URI:  https://aazztech.com/product/logo-carousel-slider
Description: This plugin allows you to easily create logo carousel slider to display logos of clients, partners, sponsors, affiliates etc. in a beautiful carousel slider.
Version:     2.0
Author:      AazzTech
Author URI:  https://aazztech.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages/
Text Domain: logo-carousel-slider
*/

/**
 * Protect direct access
 * and one note, the message inside the die() can not be translated because even WordPress is not initiated if the file is access directly.
 */

if ( ! defined( 'ABSPATH' ) ) die( 'Accessing this file directly is denied.' );



if (!class_exists('Logo_Carousel_Slider')){
    class Logo_Carousel_Slider{
        /**
         * Logo_Carousel_Slider constructor.
         */
        public function __construct()
        {
            //At first, we need to define the required CONSTANT for the plugin
            $this->_define_constant();
            // now lets include all the required files
            $this->_include();
            // activate plugin settings
            new LCS_settings( new lCS_Settings_API());
            // register custom post and custom metabox
            new LCS_Utility();

            // Modify the text of the feature image meta box on our custom post page
            new LCP_Featured_Img_Customizer(array(
                'post_type'     => 'logocarousel',
                'metabox_title' => __( 'Logo', LCS_TEXTDOMAIN ),
                'set_text'      => __( 'Set logo', LCS_TEXTDOMAIN ),
                'remove_text'   => __( 'Remove logo', LCS_TEXTDOMAIN )
            ));
            // register shorcode
            new LCS_Shortcode();





            // enqueue all the required styles and scripts
            // the best hook to enqueue scripts and style for the front end is the template redirect hook as said by brad william, author of professional plugin development
            add_action( 'template_redirect', array($this, 'frontend_enqueue_scripts_and_styles') );
            add_action('admin_enqueue_scripts', array($this, 'backend_enqueue_scripts_and_styles'));

            // add a link to the pro version on the plugin activation screen
            add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'display_pro_version_link') );
            // add usage and support menu to the admin menu
            add_action('admin_menu', array($this, 'hook_usage_and_support_submenu'));





            // Miscellaneous features
            // Enables shortcode for the Text Widget
            add_filter('widget_text', 'do_shortcode');


        }

        /**
         * It enqueues all the styles and the scripts required by the plugin
         */
        public function frontend_enqueue_scripts_and_styles()
        {
            wp_register_style( 'lcs-owl-carousel-style', LCS_PLUGIN_URI . '/css/owl.carousel.css' );
            wp_register_style( 'lcs-owl-theme-style', LCS_PLUGIN_URI . '/css/owl.theme.css' );
            wp_register_style( 'lcs-owl-transitions', LCS_PLUGIN_URI . '/css/owl.transitions.css' );
            wp_register_style( 'lcs-custom-style', LCS_PLUGIN_URI . '/css/lcs-styles.css' );
            wp_register_script( 'lcs-owl-carousel-js', LCS_PLUGIN_URI . '/js/owl.carousel.min.js', array('jquery'),'2.2.1', true );

        }

        /**
         *It enqueues the scripts and styles for the backend operation of the plugin
         * @return void
         */
        public function backend_enqueue_scripts_and_styles()
        {
            global $typenow;
            // enqueue scripts and style only on our plugin page
            if ( ( 'logocarousel' == $typenow) ) {

                wp_enqueue_style( 'lcs_custom_wp_admin_css', LCS_PLUGIN_URI . '/css/lcs-admin-styles.css' );

                wp_enqueue_script( 'lcs_custom_wp_admin_js', LCS_PLUGIN_URI . '/js/lcs-admin-script.js', array('jquery'), '1.3.3', true );

            }
        }
        /**
         *It defines essential CONSTANT for the plugin (Logo carousel slider )
         * @return void
         */
        private function _define_constant()
        {
            /**
             * Defining constants
             */
            if( ! defined( 'LCS_PLUGIN_DIR' ) ) define( 'LCS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            if( ! defined( 'LCS_PLUGIN_URI' ) ) define( 'LCS_PLUGIN_URI', plugins_url( '', __FILE__ ) );
            if( ! defined( 'LCS_TEXTDOMAIN' ) ) define( 'LCS_TEXTDOMAIN', 'logo-carousel-slider' );
        }

        /**
         *It includes all the required files for the plugin (Logo carousel slider )
         * @return void
         */
        private function _include()
        {
            require_once LCS_PLUGIN_DIR . 'includes/lcs-metabox-overrider.php';
            require_once LCS_PLUGIN_DIR . 'includes/class.settings-api.php';
            require_once LCS_PLUGIN_DIR . 'includes/lcs-settings.php';
            require_once LCS_PLUGIN_DIR . 'includes/lcs-utility.php';
            require_once LCS_PLUGIN_DIR . 'includes/lcs-img-resizer.php';
            require_once LCS_PLUGIN_DIR . 'includes/lcs-shortcodes.php';
        }

        /**
         * It adds a link to the pro version of the plugin and then return the array
         * @param array $links The array of links under the plugin name on the plugin activation screen
         * @return array It returns an array after adding a link to the pro version of the logo carousel slider
         */
        public function display_pro_version_link( $links ) {
            $links[] = '<a href="'.esc_url('http://aazztech.com/product/logo-carousel-slider-pro').'" target="_blank">'.esc_html__('Pro Version', LCS_TEXTDOMAIN).'</a>';
            return $links;
        }

        /**
         * It adds the Usage and Support submenu page to the logo carousel's admin menu
         * @return void
         */
        function hook_usage_and_support_submenu() {
            add_submenu_page( 'edit.php?post_type=logocarousel', __('Usage & Support', LCS_TEXTDOMAIN), __('Usage & Support', LCS_TEXTDOMAIN), 'manage_options', 'lsc_usage_support', array($this, 'lcs_display_usage_and_support') );
        }

        /**
         * It displays content for the usage and support screen of the plugin
         */
        public function lcs_display_usage_and_support()
        {
            // lets include a file that contains the markup for the usage and the support screen
            include LCS_PLUGIN_DIR .'includes/lcs-usage-support.php';
        }


    } // end of Logo_Carousel_Slider class

} // end if



// get the plugin running
new Logo_Carousel_Slider();

