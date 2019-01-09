<?php

/**
 * Option Panel
 *
 * @package StoreCommerce
 */

$default = storecommerce_get_default_theme_options();

/**
 * Frontpage options section
 *
 * @package StoreCommerce
 */


// Add Frontpage Options Panel.
$wp_customize->add_panel('frontpage_option_panel',
    array(
        'title'      => esc_html__('Frontpage Options', 'storecommerce'),
        'priority'   => 199,
        'capability' => 'edit_theme_options',
    )
);


// Advertisement Section.
$wp_customize->add_section('frontpage_advertisement_settings',
    array(
        'title'      => esc_html__('Banner Advertisement', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'frontpage_option_panel',
    )
);



// Setting banner_advertisement_section.
$wp_customize->add_setting('banner_advertisement_section',
    array(
        'default'           => $default['banner_advertisement_section'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control($wp_customize, 'banner_advertisement_section',
        array(
            'label'       => esc_html__('Banner Section Advertisement', 'storecommerce'),
            'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'storecommerce'), 1500, 100),
            'section'     => 'frontpage_advertisement_settings',
            'width' => 1500,
            'height' => 100,
            'flex_width' => true,
            'flex_height' => true,
            'priority'    => 120,
        )
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('banner_advertisement_section_url',
    array(
        'default'           => $default['banner_advertisement_section_url'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('banner_advertisement_section_url',
    array(
        'label'    => esc_html__('URL Link', 'storecommerce'),
        'section'  => 'frontpage_advertisement_settings',
        'type'     => 'text',
        'priority' => 130,
    )
);


/**
 * Main Banner Slider Section
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_main_banner_section_settings',
    array(
        'title'      => esc_html__('Main Banner Section', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'frontpage_option_panel',
    )
);


// Setting - show_main_news_section.
$wp_customize->add_setting('show_main_news_section',
    array(
        'default'           => $default['show_main_news_section'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_main_news_section',
    array(
        'label'    => esc_html__('Enable Main Banner Slider', 'storecommerce'),
        'section'  => 'frontpage_main_banner_section_settings',
        'type'     => 'checkbox',
        'priority' => 22,

    )
);



$slider_number = 3;

for ( $i = 1; $i <= $slider_number; $i++ ) {

    //Slide Details
    $wp_customize->add_setting('page_slide_'.$i.'_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new StoreCommerce_Section_Title(
            $wp_customize,
            'page_slide_'.$i.'_section_title',
            array(
                'label' 			=> esc_html__( 'Set Slide ', 'storecommerce' ) . ' - ' . $i,
                'section' 			=> 'frontpage_main_banner_section_settings',
                'priority' 			=> 100,
                'active_callback' => 'storecommerce_main_banner_section_status',
            )
        )
    );

    $wp_customize->add_setting( "slider_page_$i",
        array(
            'sanitize_callback' => 'storecommerce_sanitize_dropdown_pages',
        )
    );
    $wp_customize->add_control( "slider_page_$i",
        array(
            'label'           => esc_html__( 'Select Page', 'storecommerce' ),
            'section'         => 'frontpage_main_banner_section_settings',
            'type'            => 'dropdown-pages',            
            'priority' 		  => 100,
            'active_callback' => 'storecommerce_main_banner_section_status',
        )
    );

    $wp_customize->add_setting( "page_caption_position_$i",
        array(
            'default'           => 'left',
            'sanitize_callback' => 'storecommerce_sanitize_select',
        )
    );

    $wp_customize->add_control( "page_caption_position_$i",
        array(
            'label'           => esc_html__( 'Caption Position', 'storecommerce' ),
            'section'         => 'frontpage_main_banner_section_settings',
            'type'            => 'select',
            'choices'         => array(
                'left'     => esc_html__( 'Left', 'storecommerce' ),
                'right'    => esc_html__( 'Right', 'storecommerce' ),
                'center'   => esc_html__( 'Center', 'storecommerce' ),
            ),           
            'priority' 		  => 100,
            'active_callback' => 'storecommerce_main_banner_section_status',
        )
    );

    // Setting slider readmore text.
    $wp_customize->add_setting( "button_text_$i",
        array(
            'default'           => esc_html__( 'Shop Now', 'storecommerce' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control( "button_text_$i",
        array(
            'label'    => esc_html__( 'Button Text', 'storecommerce' ),
            'section'  => 'frontpage_main_banner_section_settings',
            'type'     => 'text',            
            'priority' => 100,
            'active_callback' => 'storecommerce_main_banner_section_status',
        )
    );

    // Setting slider readmore link.
    $wp_customize->add_setting( "button_link_$i",
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control( "button_link_$i",
        array(
            'label'    => esc_html__( 'Button Link', 'storecommerce' ),
            'section'  => 'frontpage_main_banner_section_settings',
            'type'     => 'text',            
            'priority' => 100,
            'active_callback' => 'storecommerce_main_banner_section_status',
        )
    );

}