<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function storecommerce_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Main Sidebar', 'storecommerce'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets for main sidebar.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span>',
        'after_title' => '</span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Above Banner Section', 'storecommerce'),
        'id' => 'above-banner-section',
        'description' => esc_html__('Add widgets for Above Banner Section.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span>',
        'after_title' => '</span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Off-canvas Panel', 'storecommerce'),
        'id' => 'express-off-canvas-panel',
        'description' => esc_html__('Add widgets for off-canvas panel.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span>',
        'after_title' => '</span></h2>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Static Frontpage Section', 'storecommerce'),
        'id' => 'frontpage-content-widgets',
        'description' => esc_html__('Add widgets to Static Frontpage Section.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title"><span>',
        'after_title' => '</span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Store Sidebar', 'storecommerce'),
        'id' => 'shop-sidebar-widgets',
        'description' => esc_html__('Add widgets to Store Sidebar.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span>',
        'after_title' => '</span></h2>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Footer First Section', 'storecommerce'),
        'id' => 'footer-first-widgets-section',
        'description' => esc_html__('Displays items on footer first column.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="header-after">',
        'after_title' => '</span></h2>',
    ));


    register_sidebar(array(
        'name' => esc_html__('Footer Second Section', 'storecommerce'),
        'id' => 'footer-second-widgets-section',
        'description' => esc_html__('Displays items on footer second column.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="header-after">',
        'after_title' => '</span></h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Third Section', 'storecommerce'),
        'id' => 'footer-third-widgets-section',
        'description' => esc_html__('Displays items on footer third column.', 'storecommerce'),
        'before_widget' => '<div id="%1$s" class="widget storecommerce-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title widget-title-1"><span class="header-after">',
        'after_title' => '</span></h2>',
    ));

}

add_action('widgets_init', 'storecommerce_widgets_init');