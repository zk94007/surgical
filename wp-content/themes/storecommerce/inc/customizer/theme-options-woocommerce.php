<?php

/**
 * Option Panel
 *
 * @package StoreCommerce
 */

$default = storecommerce_get_default_theme_options();

/**
 * Contact options section
 *
 * @package StoreCommerce
 */


//=====================================================
//================== Global Options ===================
//=====================================================

// Product Search Section.
$wp_customize->add_section('store_global_options_settings',
    array(
        'title'      => esc_html__('Store Global Options', 'storecommerce'),
        'priority'   => 9,
        'capability' => 'edit_theme_options',
        'panel'      => 'woocommerce',
    )
);



// Setting - show_site_title_section.
$wp_customize->add_setting('store_global_alignment',
    array(
        'default'           => $default['store_global_alignment'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('store_global_alignment',
    array(
        'label'    => esc_html__('Content Alignment', 'storecommerce'),
        'section'  => 'store_global_options_settings',
        'type'        => 'select',
        'choices'     => array(
            'align-content-left' => esc_html__( 'Content - Store Sidebar', 'storecommerce' ),
            'align-content-right' => esc_html__( 'Store Sidebar - Content', 'storecommerce' ),
            'full-width-content' => esc_html__( 'Full Width Content', 'storecommerce' )
        ),
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('store_enable_breadcrumbs',
    array(
        'default'           => $default['store_enable_breadcrumbs'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('store_enable_breadcrumbs',
    array(
        'label'    => esc_html__('Enable Breadcrumbs', 'storecommerce'),
        'section'  => 'store_global_options_settings',
        'type'        => 'select',
        'choices'     => array(
            'yes'              => __( 'Yes', 'storecommerce' ),
            'no' => __( 'No', 'storecommerce' ),
        ),
    )
);

/*store_single_sale_text*/
$wp_customize->add_setting('store_single_sale_text',
    array(
        'default'           => $default['store_single_sale_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('store_single_sale_text',
    array(
        'label'    => esc_html__('Sale Texts', 'storecommerce'),
        'section'  => 'store_global_options_settings',
        'type'     => 'text',
        'priority' => 10,
    )
);



/*store_product_search_placeholder*/
$wp_customize->add_setting('store_single_add_to_cart_text',
    array(
        'default'           => $default['store_single_add_to_cart_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('store_single_add_to_cart_text',
    array(
        'label'    => esc_html__('Single Add to Cart Texts', 'storecommerce'),
        'section'  => 'store_global_options_settings',
        'type'     => 'text',
        'priority' => 10,
    )
);

/*store_product_search_placeholder*/
$wp_customize->add_setting('store_simple_add_to_cart_text',
    array(
        'default'           => $default['store_simple_add_to_cart_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('store_simple_add_to_cart_text',
    array(
        'label'    => esc_html__('Simple Product Add to Cart Texts', 'storecommerce'),
        'section'  => 'store_global_options_settings',
        'type'     => 'text',
        'priority' => 10,
    )
);



//=====================================================
//================== Search Options ===================
//=====================================================

// Product Search Section.
$wp_customize->add_section('store_product_search_settings',
    array(
        'title'      => esc_html__('Product Search', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'woocommerce',
    )
);


/*store_product_search_placeholder*/
$wp_customize->add_setting('store_product_search_placeholder',
    array(
        'default'           => $default['store_product_search_placeholder'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('store_product_search_placeholder',
    array(
        'label'    => esc_html__('Product Search Placeholder', 'storecommerce'),
        'section'  => 'store_product_search_settings',
        'type'     => 'text',
        'priority' => 10,
    )
);

/*store_product_search_placeholder*/
$wp_customize->add_setting('store_product_search_category_placeholder',
    array(
        'default'           => $default['store_product_search_category_placeholder'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('store_product_search_category_placeholder',
    array(
        'label'    => esc_html__('Select Category', 'storecommerce'),
        'section'  => 'store_product_search_settings',
        'type'     => 'text',
        'priority' => 10,
    )
);



//=====================================================
//================== Product Loop Options ===================
//=====================================================

// Advertisement Section.
$wp_customize->add_section('store_product_loop_settings',
    array(
        'title'      => esc_html__('Product Loop', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'woocommerce',
    )
);

// Setting - show_site_title_section.
$wp_customize->add_setting('aft_product_loop_category',
    array(
        'default'           => $default['aft_product_loop_category'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('aft_product_loop_category',
    array(
        'label'    => esc_html__('Show Product Category', 'storecommerce'),
        'section'  => 'store_product_loop_settings',
        'type'        => 'select',
        'choices'     => array(
            'yes'              => __( 'Yes', 'storecommerce' ),
            'no' => __( 'No', 'storecommerce' ),
        ),
    )
);


//=====================================================
//================== Shop Options ===================
//=====================================================

// Shop Section.
$wp_customize->add_section('store_product_shop_page_settings',
    array(
        'title'      => esc_html__('Shop Page', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'woocommerce',
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('store_product_shop_page_row',
    array(
        'default'           => $default['store_product_shop_page_row'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('store_product_shop_page_row',
    array(
        'label'    => esc_html__('Shop Product Columns', 'storecommerce'),
        'section'  => 'store_product_shop_page_settings',
        'type'        => 'select',
        'choices'     => array(
            '2' => __( 'Two', 'storecommerce' ),
            '3' => __( 'Three', 'storecommerce' ),
            '4' => __( 'Four', 'storecommerce' ),

        ),
    )
);

/*store_product_search_placeholder*/
$wp_customize->add_setting('store_product_shop_page_product_per_page',
    array(
        'default'           => $default['store_product_shop_page_product_per_page'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('store_product_shop_page_product_per_page',
    array(
        'label'    => esc_html__('Products per Page', 'storecommerce'),
        'section'  => 'store_product_shop_page_settings',
        'type'     => 'number',
        'priority' => 10,
    )
);


//=====================================================
//================== Product Page Options ===================
//=====================================================
// Shop Section.
$wp_customize->add_section('store_product_page_settings',
    array(
        'title'      => esc_html__('Product Page', 'storecommerce'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'woocommerce',
    )
);

// Setting - show_site_title_section.
$wp_customize->add_setting('store_product_page_product_zoom',
    array(
        'default'           => $default['store_product_page_product_zoom'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('store_product_page_product_zoom',
    array(
        'label'    => esc_html__('Enable Product Zoom', 'storecommerce'),
        'section'  => 'store_product_page_settings',
        'type'        => 'select',
        'choices'     => array(
            'yes'              => __( 'Yes', 'storecommerce' ),
            'no' => __( 'No', 'storecommerce' ),
        ),
    )
);




// Setting - show_site_title_section.
$wp_customize->add_setting('store_product_page_related_products',
    array(
        'default'           => $default['store_product_page_related_products'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('store_product_page_related_products',
    array(
        'label'    => esc_html__('Show Related Products', 'storecommerce'),
        'section'  => 'store_product_page_settings',
        'type'        => 'select',
        'choices'     => array(
            'yes'              => __( 'Yes', 'storecommerce' ),
            'no' => __( 'No', 'storecommerce' ),
        ),
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('store_product_page_related_products_per_row',
    array(
        'default'           => $default['store_product_page_related_products_per_row'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'storecommerce_sanitize_select',
    )
);

$wp_customize->add_control('store_product_page_related_products_per_row',
    array(
        'label'    => esc_html__('Related Products per Rows', 'storecommerce'),
        'section'  => 'store_product_page_settings',
        'type'        => 'select',
        'choices'     => array(
            '2' => __( 'Two', 'storecommerce' ),
            '3' => __( 'Three', 'storecommerce' ),
            '4' => __( 'Four', 'storecommerce' ),
        ),
        'active_callback' => 'store_product_page_related_products_status'
    )
);