<?php
/**
 * Customizer callback functions for active_callback.
 *
 * @package StoreCommerce
 */

/*select page for slider*/
if ( ! function_exists( 'storecommerce_frontpage_content_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_frontpage_content_status( $control ) {

        if ( 'page' == $control->manager->get_setting( 'show_on_front' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;


    /*select page for trending news*/
if ( ! function_exists( 'storecommerce_flash_posts_section_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_flash_posts_section_status( $control ) {

        if ( true == $control->manager->get_setting( 'show_flash_news_section' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;


    /*select page for trending news*/
if ( ! function_exists( 'storecommerce_top_header_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_top_header_status( $control ) {

        if ( true == $control->manager->get_setting( 'show_top_header' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

    /*select page for trending news*/
if ( ! function_exists( 'storecommerce_header_layout_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_header_layout_status( $control ) {

        if ( 'header-style-2' == $control->manager->get_setting( 'header_layout' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

    /*select page for slider*/
if ( ! function_exists( 'storecommerce_main_banner_section_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_main_banner_section_status( $control ) {

        if ( true == $control->manager->get_setting( 'show_main_news_section' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

/*select page for slider*/
if ( ! function_exists( 'storecommerce_page_slider_banner_mode_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_page_slider_banner_mode_status( $control ) {

        if ( 'page-slider' == $control->manager->get_setting( 'select_main_banner_section_mode' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

/*select page for slider*/
if ( ! function_exists( 'storecommerce_product_slider_banner_mode_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_product_slider_banner_mode_status( $control ) {

        if ( 'product-slider' == $control->manager->get_setting( 'select_main_banner_section_mode' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;


/*select page for slider*/
if ( ! function_exists( 'storecommerce_featured_news_section_status' ) ) :

    /**
     * Check if ticker section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_featured_news_section_status( $control ) {

        if ( true == $control->manager->get_setting( 'show_featured_news_section' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

/*select page for slider*/
if ( ! function_exists( 'storecommerce_featured_product_section_status' ) ) :

    /**
     * Check if ticker section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_featured_product_section_status( $control ) {

        if ( true == $control->manager->get_setting( 'show_featured_products_section' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

/*select page for slider*/
if ( ! function_exists( 'storecommerce_latest_news_section_status' ) ) :

    /**
     * Check if ticker section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_latest_news_section_status( $control ) {

        if ( true == $control->manager->get_setting( 'frontpage_show_latest_posts' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;



/*select page for slider*/
if ( ! function_exists( 'storecommerce_archive_image_status' ) ) :

    /**
     * Check if archive no image is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_archive_image_status( $control ) {

        if ( 'archive-layout-list' == $control->manager->get_setting( 'archive_layout' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

/*related posts*/
if ( ! function_exists( 'storecommerce_related_posts_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_related_posts_status( $control ) {

        if ( true == $control->manager->get_setting( 'single_show_related_posts' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

    /*related posts*/
if ( ! function_exists( 'store_product_page_related_products_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function store_product_page_related_products_status( $control ) {

        if ( 'yes' == $control->manager->get_setting( 'store_product_page_related_products' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;



/*mailchimp*/
if ( ! function_exists( 'storecommerce_mailchimp_subscriptions_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_mailchimp_subscriptions_status( $control ) {

        if ( true == $control->manager->get_setting( 'footer_show_mailchimp_subscriptions' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

    /*select page for slider*/
if ( ! function_exists( 'storecommerce_footer_instagram_posts_status' ) ) :

    /**
     * Check if slider section page/post is active.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function storecommerce_footer_instagram_posts_status( $control ) {

        if ( true == $control->manager->get_setting( 'footer_show_instagram_post_carousel' )->value() ) {
            return true;
        } else {
            return false;
        }

    }

endif;

