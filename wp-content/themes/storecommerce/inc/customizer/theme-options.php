<?php

/**
 * Option Panel
 *
 * @package StoreCommerce
 */

$default = storecommerce_get_default_theme_options();
/*theme option panel info*/
require get_template_directory().'/inc/customizer/theme-options-frontpage.php';

//contact page options
require get_template_directory().'/inc/customizer/theme-options-contacts.php';

//woocommerce options
require get_template_directory().'/inc/customizer/theme-options-woocommerce.php';



// Add Theme Options Panel.
$wp_customize->add_panel('theme_option_panel',
	array(
		'title'      => esc_html__('Theme Options', 'storecommerce'),
		'priority'   => 200,
		'capability' => 'edit_theme_options',
	)
);


// Preloader Section.
$wp_customize->add_section('site_preloader_settings',
    array(
        'title'      => esc_html__('Preloader Options', 'storecommerce'),
        'priority'   => 4,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - preloader.
$wp_customize->add_setting('enable_site_preloader',
    array(
        'default'           => $default['enable_site_preloader'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);

$wp_customize->add_control('enable_site_preloader',
    array(
        'label'    => esc_html__('Enable preloader', 'storecommerce'),
        'section'  => 'site_preloader_settings',
        'type'     => 'checkbox',
        'priority' => 10,
    )
);


/**
 * Header section
 *
 * @package StoreCommerce
 */

// Frontpage Section.
$wp_customize->add_section('header_options_settings',
	array(
		'title'      => esc_html__('Header Options', 'storecommerce'),
		'priority'   => 49,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);




// Setting - show_site_title_section.
$wp_customize->add_setting('show_top_header',
    array(
        'default'           => $default['show_top_header'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_top_header',
    array(
        'label'    => esc_html__('Show Top Header', 'storecommerce'),
        'section'  => 'header_options_settings',
        'type'     => 'checkbox',
        'priority' => 5,

    )
);

// Setting - show_site_title_section.
$wp_customize->add_setting('show_top_header_store_contacts',
    array(
        'default'           => $default['show_top_header_store_contacts'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_top_header_store_contacts',
    array(
        'label'    => esc_html__('Show Store Address and Contacts at Top Header', 'storecommerce'),
        'section'  => 'header_options_settings',
        'type'     => 'checkbox',
        'priority' => 10,
        'active_callback' => 'storecommerce_top_header_status'
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('show_top_header_social_contacts',
    array(
        'default'           => $default['show_top_header_social_contacts'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_top_header_social_contacts',
    array(
        'label'    => esc_html__('Show Social Menu at Top Header', 'storecommerce'),
        'section'  => 'header_options_settings',
        'type'     => 'checkbox',
        'priority' => 10,
        'active_callback' => 'storecommerce_top_header_status'
    )
);

// Setting - sticky_header_option.
$wp_customize->add_setting('disable_sticky_header_option',
    array(
        'default'           => $default['disable_sticky_header_option'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);
$wp_customize->add_control('disable_sticky_header_option',
    array(
        'label'    => esc_html__('Disable Sticky Header', 'storecommerce'),
        'section'  => 'header_options_settings',
        'type'     => 'checkbox',
        'priority' => 10,
        //'active_callback' => 'storecommerce_header_layout_status'
    )
);


/**
 * Layout options section
 *
 * @package StoreCommerce
 */

// Layout Section.
$wp_customize->add_section('site_layout_settings',
    array(
        'title'      => esc_html__('Global Layout Options', 'storecommerce'),
        'priority'   => 9,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('global_content_alignment',
    array(
        'default'           => $default['global_content_alignment'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control( 'global_content_alignment',
    array(
        'label'       => esc_html__('Global Content Alignment', 'storecommerce'),
        'description' => esc_html__('Select global content alignment', 'storecommerce'),
        'section'     => 'site_layout_settings',
        'type'        => 'select',
        'choices'               => array(
            'align-content-left' => esc_html__( 'Content - Primary Sidebar', 'storecommerce' ),
            'align-content-right' => esc_html__( 'Primary Sidebar - Content', 'storecommerce' ),
            'full-width-content' => esc_html__( 'Full Width Content', 'storecommerce' )
        ),
        'priority'    => 130,
    ));

//========= secure payment icon option
// Advertisement Section.
$wp_customize->add_section('secure_payment_badge_settings',
    array(
        'title'      => esc_html__('Secure Payment Badge Options', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);



// Setting banner_advertisement_section.
$wp_customize->add_setting('secure_payment_badge',
    array(
        'default'           => $default['secure_payment_badge'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control($wp_customize, 'secure_payment_badge',
        array(
            'label'       => esc_html__('Banner Section Advertisement', 'storecommerce'),
            'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'storecommerce'), 600, 190),
            'section'     => 'secure_payment_badge_settings',
            'width' => 600,
            'height' => 190,
            'flex_width' => true,
            'flex_height' => true,
            'priority'    => 120,
        )
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('secure_payment_badge_url',
    array(
        'default'           => $default['secure_payment_badge_url'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('secure_payment_badge_url',
    array(
        'label'    => esc_html__('URL Link', 'storecommerce'),
        'section'  => 'secure_payment_badge_settings',
        'type'     => 'text',
        'priority' => 130,
    )
);




//========== footer section options ===============
// Footer Section.
$wp_customize->add_section('site_footer_settings',
    array(
        'title'      => esc_html__('Footer Options', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('footer_copyright_text',
    array(
        'default'           => $default['footer_copyright_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'footer_copyright_text',
    array(
        'label'    => __( 'Copyright Text', 'storecommerce' ),
        'section'  => 'site_footer_settings',
        'type'     => 'text',
        'priority' => 100,
    )
);