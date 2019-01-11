<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Accessing this file directly is denied.' );


if ( !class_exists('LCS_settings' ) ):
class LCS_settings {
    /**
     * Settings of Logo Carousel Slider.
     *
     * @var object|lCS_Settings_API
     * @since 1.5
     */
    private $settings_api;

    /**
     * LCS_settings constructor.
     * @param object | lCS_Settings_API $setting_api
     */
    function __construct(lCS_Settings_API $setting_api) {
        $this->settings_api = new $setting_api;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 'edit.php?post_type=logocarousel', __('Settings', LCS_TEXTDOMAIN), 'Settings', 'manage_options', 'settings', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'lcs_general_settings',
                'title' => __( 'General Settings', LCS_TEXTDOMAIN )
            ),
            array(
                'id' => 'lcs_slider_settings',
                'title' => __( 'Slider Settings', LCS_TEXTDOMAIN ),

            ),
            array(
                'id' => 'lcs_style_settings',
                'title' => __( 'Style Settings', LCS_TEXTDOMAIN ),

            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'lcs_general_settings' => array(
                array(
                    'name' => 'lcs_dna',
                    'label' => __( 'Display Navigation Arrows', LCS_TEXTDOMAIN ),
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    )
                ),
                array(
                    'name' => 'lcs_nap',
                    'label' => __( 'Navigation Arrows Position', LCS_TEXTDOMAIN ),
                    'default' => 'top_right',
                    'type' => 'radio',
                    'options' => array(
                        'top_right' => __('Top Right', LCS_TEXTDOMAIN),
                        'top_left' => __('Top Left ', LCS_TEXTDOMAIN),
                    ),

                ),
                //Pro version promotion
                array(
                    'name' => 'lcs_nap_promotion',
                    'type' => 'radio',
                    'options' => array(
                        'top_right' => __('<div class="lcs_pro_promo">The following Navigation Arrow Positions are available in <a href="http://aazztech.com/product/logo-carousel-slider-pro" target="_blank">Pro version</a></div>', 'logo-carousel-slider'),
                        'top_middle' => __('Top Middle ', 'logo-carousel-slider'),
                        'top_left' => __('Top Left ', 'logo-carousel-slider'),
                        'middle' => __('Middle (visible on hover only) ', 'logo-carousel-slider'),
                        'middle_const' => __('Middle (always) ', 'logo-carousel-slider'),
                        'bottom_middle' => __('Bottom Middle ', 'logo-carousel-slider'),
                        'bottom_left' => __('Bottom Left ', 'logo-carousel-slider'),
                        'bottom_right' => __('Bottom Right ', 'logo-carousel-slider'),
                    ),

                ),
                array(
                    'name' => 'lcs_logotype',
                    'label' => __( 'Logo Type', 'logo-carousel-slider' ),
                    'default' => 'top_right',
                    'type' => 'radio',
                    'options' => array(
                        'top_right' => __('Display Logos from Latest Published', 'logo-carousel-slider'),
                    ),

                ),
                //PRO VERSION Promotion
                array(
                    'name' => 'lcs_logotype_test',
                    'type' => 'radio',
                    'options' => array(
                        'top_right' => __('<div class="lcs_pro_promo">The following Logo Type Options are available in <a href="http://aazztech.com/product/logo-carousel-slider-pro" target="_blank">Pro version</a></div>', 'logo-carousel-slider'),
                        'top_middle' => __('Display Logos from Older Published
 ', 'logo-carousel-slider'),
                        'top_left' => __('Display Logos randomly
 ', 'logo-carousel-slider'),
                        'middle' => __('Display Logos from Category
', 'logo-carousel-slider'),
                        'middle_const' => __('Display Logos by ID
 ', 'logo-carousel-slider'),
                        'bottom_middle' => __('Display Logos by Year
 ', 'logo-carousel-slider'),
                        'bottom_left' => __('Display Logos by Month
 ', 'logo-carousel-slider'),
                    ),

                ),


                array(
                    'name' => 'lcs_dlt',
                    'label' => __( 'Display Logo Title', LCS_TEXTDOMAIN ),
                    'default' => 'no',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    )
                ),
                array(
                    'name' => 'lcs_dlb',
                    'label' => __( 'Display Logo Border', LCS_TEXTDOMAIN ),
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    )
                ),
                array(
                    'name' => 'lcs_lhe',
                    'label' => __( 'Logo Hover Effect', LCS_TEXTDOMAIN ),
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    )
                ),
                array(
                    'name' => 'lcs_ic',
                    'label' => __( 'Image Crop', LCS_TEXTDOMAIN ),
                    'desc' => __( 'If logos are not in the same size, this feature is helpful. It automatically resizes and crops. <br/> Note: your image must be higher than/equal to the cropping size set below. Otherwise, you may need to enable image upscaling from the settings below.', LCS_TEXTDOMAIN ),
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    )
                ),
                array(
                    'name'              => 'lcs_iwfc',
                    'label'             => __( 'Image Cropping Width', LCS_TEXTDOMAIN ),
                    'type'              => 'number',
                    'default'           => '185',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'              => 'lcs_ihfc',
                    'label'             => __( 'Image Cropping height', LCS_TEXTDOMAIN ),
                    'type'              => 'number',
                    'default'           => '119',
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name' => 'lcs_upscale',
                    'label' => __( 'Enable Image Upscaling', LCS_TEXTDOMAIN ),
                    'desc' => __( 'If the logo size is less than the cropping size set above then by default, image will break. However, you can solve this problem by enabling upscaling. ', LCS_TEXTDOMAIN ),
                    'default' => 'yes',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    )
                ),


            ),

            'lcs_slider_settings' => array(
                array(
                    'name'              => 'lcs_lig',
                    'label'             => __( 'Items', LCS_TEXTDOMAIN ),
                    'desc'              => __( 'Maximum amount of items to display at a time', LCS_TEXTDOMAIN ),
                    'type'              => 'number',
                    'default'           => 5,
                    'sanitize_callback' => 'intval'
                ),
                array(
                    'name'    => 'lcs_apg',
                    'label'   => __( 'Auto Play', LCS_TEXTDOMAIN ),
                    'desc'    => __( 'Whether to play slider automatically or not', LCS_TEXTDOMAIN ),
                    'default' => 'yes',
                    'type'    => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no'  => __('No', LCS_TEXTDOMAIN)
                    )
                ),
                array(
                    'name' => 'lcs_pagination',
                    'label' => __( 'Pagination', LCS_TEXTDOMAIN ),
                    'default' => 'no',
                    'type' => 'radio',
                    'options' => array(
                        'yes' => __('Yes', LCS_TEXTDOMAIN),
                        'no' => __('No', LCS_TEXTDOMAIN)
                    ),
                    'desc'    => __( 'You can enable or disable pagination of the slider.', LCS_TEXTDOMAIN ),

                ),


            ),

            'lcs_style_settings' => array(
                array(
                    'name'              => 'lcs_stfs',
                    'label'             => __( 'Slider Title Font Size', LCS_TEXTDOMAIN ),
                    'desc'              => esc_html__('Enter the font size for the slider title in pixel. eg. 18px'),
                    'type'              => 'text',
                    'default'           => '18px'
                ),
                array(
                    'name'    => 'lcs_stfc',
                    'label'   => __( 'Slider Title Font Color', LCS_TEXTDOMAIN ),
                    'type'    => 'color',
                    'desc'    => esc_html__('Select the color for the slider title. Default color is #444'),

                    'default' => '#444'
                ),
            ),


        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap lcs_settings_page">';
        $this->settings_api->show_notification();
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
//Retrieving the values
function lcs_get_option( $option, $section, $default = '' ) {
 
    $options = get_option( $section );
 
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
 
    return $default;
}