<?php
/**
 * StoreCommerce Theme Customizer
 *
 * @package StoreCommerce
 */

if (!function_exists('storecommerce_get_option')):
/**
 * Get theme option.
 *
 * @since 1.0.0
 *
 * @param string $key Option key.
 * @return mixed Option value.
 */
function storecommerce_get_option($key) {

	if (empty($key)) {
		return;
	}

	$value = '';

	$default       = storecommerce_get_default_theme_options();
	$default_value = null;

	if (is_array($default) && isset($default[$key])) {
		$default_value = $default[$key];
	}

	if (null !== $default_value) {
		$value = get_theme_mod($key, $default_value);
	} else {
		$value = get_theme_mod($key);
	}

	return $value;
}
endif;

// Load customize default values.
require get_template_directory().'/inc/customizer/customizer-callback.php';

// Load customize default values.
require get_template_directory().'/inc/customizer/customizer-default.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function storecommerce_customize_register($wp_customize) {

	// Load customize controls.
	require get_template_directory().'/inc/customizer/customizer-control.php';

	// Load customize sanitize.
	require get_template_directory().'/inc/customizer/customizer-sanitize.php';

	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial('blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'storecommerce_customize_partial_blogname',
			));
		$wp_customize->selective_refresh->add_partial('blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'storecommerce_customize_partial_blogdescription',
			));
	}

    $default = storecommerce_get_default_theme_options();

    // Setting - secondary_font.
    $wp_customize->add_setting('site_title_font_size',
        array(
            'default'           => $default['site_title_font_size'],
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control('site_title_font_size',
        array(
            'label'    => esc_html__('Site Title Size', 'storecommerce'),
            'section'  => 'title_tagline',
            'type'     => 'number',
            'priority' => 50,
        )
    );
    // use get control
    $wp_customize->get_control( 'header_textcolor')->label = __( 'Site Title/Tagline Color', 'storecommerce' );
    $wp_customize->get_control( 'header_textcolor')->section = 'title_tagline';


    // Setting - header overlay.
    $wp_customize->add_setting('enable_header_image_tint_overlay',
        array(
            'default'           => $default['enable_header_image_tint_overlay'],
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'storecommerce_sanitize_checkbox',
        )
    );

    $wp_customize->add_control('enable_header_image_tint_overlay',
        array(
            'label'    => esc_html__('Enable Header Image Tint/Overlay', 'storecommerce'),
            'section'  => 'header_image',
            'type'     => 'checkbox',
            'priority' => 50,
        )
    );


	/*theme option panel info*/
	require get_template_directory().'/inc/customizer/theme-options.php';

    // Register custom section types.
    $wp_customize->register_section_type( 'StoreCommerce_Customize_Section_Upsell' );

    // Register sections.
    $wp_customize->add_section(
        new StoreCommerce_Customize_Section_Upsell(
            $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'StoreCommerce Pro', 'storecommerce' ),
                'pro_text' => esc_html__( 'Upgrade now', 'storecommerce' ),
                'pro_url'  => 'https://www.afthemes.com/products/storecommerce-pro/',
                'priority'  => 1,
            )
        )
    );


}
add_action('customize_register', 'storecommerce_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function storecommerce_customize_partial_blogname() {
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function storecommerce_customize_partial_blogdescription() {
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function storecommerce_customize_preview_js() {
	wp_enqueue_script('storecommerce-customizer', get_template_directory_uri().'/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'storecommerce_customize_preview_js');

function storecommerce_customizer_css() {
    wp_enqueue_script( 'storecommerce-customize-controls', get_template_directory_uri() . '/inc/customizer/js/customizer-upsell.js', array( 'customize-controls' ) );

    wp_enqueue_style( 'storecommerce-customize-controls-style', get_template_directory_uri() . '/inc/customizer/css/customizer-upsell.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'storecommerce_customizer_css',0 );

