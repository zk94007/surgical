<?php
/**
 * Default theme options.
 *
 * @package StoreCommerce
 */

if (!function_exists('storecommerce_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function storecommerce_get_default_theme_options() {

    $defaults = array();
    // Preloader options section
    $defaults['enable_site_preloader'] = 1;
    $defaults['site_preloader_background'] = '#f1f1f1';
    $defaults['site_preloader_spinner_color'] = '#dd3333';

    // Header options section
    $defaults['header_layout'] = 'header-style-1';
    $defaults['header_layout_transparent'] = 1;
    $defaults['disable_sticky_header_option'] = 0;

    $defaults['show_top_header'] = 1;
    $defaults['show_top_header_store_contacts'] = 1;
    $defaults['show_top_header_social_contacts'] = 1;
    $defaults['top_header_background_color'] = "#353535";
    $defaults['top_header_text_color'] = "#ffffff";

    $defaults['show_top_menu'] = 0;
    $defaults['show_social_menu_section'] = 1;
    $defaults['show_minicart_section'] = 1;
    $defaults['show_store_contact_section'] = 1;


    $defaults['add_to_wishlist_icon'] = 'fa fa-heart';
    $defaults['already_in_wishlist_icon'] = 'fa fa-heart';

    $defaults['enable_header_image_tint_overlay'] = 0;
    $defaults['show_offpanel_menu_section'] = 1;


    $defaults['banner_advertisement_section'] = '';
    $defaults['banner_advertisement_section_url'] = '';
    $defaults['banner_advertisement_open_on_new_tab'] = 1;
    $defaults['banner_advertisement_scope'] = 'front-page-only';


    // breadcrumb options section
    $defaults['enable_general_breadcrumb'] = 'yes';
    $defaults['select_breadcrumb_mode'] = 'simple';


    // Slider.
    $defaults['slider_status']                  = false;
    $defaults['button_text_1']                  = esc_html__( 'Shop Now', 'storecommerce' );
    $defaults['button_text_2']                  = esc_html__( 'Shop Now', 'storecommerce' );
    $defaults['button_text_3']                  = esc_html__( 'Shop Now', 'storecommerce' );

    $defaults['button_link_1']                  = '';
    $defaults['button_link_2']                  = '';
    $defaults['button_link_3']                  = '';


    $defaults['page_caption_position_1']             = 'left';
    $defaults['page_caption_position_2']             = 'left';
    $defaults['page_caption_position_3']             = 'left';

    $defaults['slider_autoplay_status']         = true;
    $defaults['slider_pager_status']            = true;
    $defaults['slider_transition_effect']       = 'fade';
    $defaults['slider_transition_delay']        = 3;



    // Frontpage Section.

    $defaults['show_main_news_section'] = 1;

    $defaults['main_news_slider_title'] = __('Main Story', 'storecommerce');
    $defaults['select_slider_news_category'] = 0;
    $defaults['select_main_banner_section_mode'] = 'page-slider';
    $defaults['number_of_slides'] = 5;



    $defaults['frontpage_content_alignment'] = 'align-content-left';

    //layout options
    $defaults['global_content_layout'] = 'default-content-layout';
    $defaults['global_content_alignment'] = 'align-content-left';
    $defaults['global_image_alignment'] = 'full-width-image';
    $defaults['global_post_date_author_setting'] = 'show-date-author';
    $defaults['global_excerpt_length'] = 20;
    $defaults['global_read_more_texts'] = __('Read more', 'storecommerce');

    $defaults['archive_layout'] = 'archive-layout-grid';
    $defaults['archive_image_alignment'] = 'archive-image-left';
    $defaults['archive_content_view'] = 'archive-content-excerpt';
    $defaults['disable_main_banner_on_blog_archive'] = 0;



    //Related posts
    $defaults['store_contact_name'] = '';
    $defaults['store_contact_address'] = '107-95 Prospect Park West Brooklyn, NY 11215, USA';
    $defaults['store_contact_phone']     = '+1 212-0123456789';
    $defaults['store_contact_email']  = 'storecontact@email.com';

    $defaults['store_contact_form']  = '';
    $defaults['store_contact_page']  = '';

    //Secure Payment Options
    $defaults['secure_payment_badge'] = '';
    $defaults['secure_payment_badge_url'] = '';


    //Pagination.
    $defaults['site_pagination_type'] = 'default';
    $defaults['site_title_font_size']    = 48;

    // Footer.


    $defaults['footer_copyright_text'] = esc_html__('Copyright &copy; All rights reserved.', 'storecommerce');

    $defaults['number_of_footer_widget']  = 3;

    //woocommerce
    $defaults['store_global_alignment']    = 'align-content-left';
    $defaults['store_enable_breadcrumbs']    = 'yes';
    $defaults['store_single_sale_text']    = 'Sale!';
    $defaults['store_single_add_to_cart_text']    = 'Add to cart';
    $defaults['store_simple_add_to_cart_text']    = 'Add to cart';


    $defaults['store_product_search_placeholder']    = 'Search Products...';
    $defaults['store_product_search_category_placeholder']    = 'Select Category';
    $defaults['aft_product_loop_button_display']    = 'show-on-hover';
    $defaults['aft_product_loop_category']    = 'yes';
    $defaults['store_product_shop_page_row']    = '3';
    $defaults['store_product_shop_page_product_per_page']    = '12';
    $defaults['store_product_shop_page_product_sort']    = 'yes';

    $defaults['store_product_page_product_zoom']    = 'yes';
    $defaults['store_product_page_gallery_thumbnail_columns']    = '4';
    $defaults['store_product_page_related_products']    = 'yes';
    $defaults['store_product_page_related_products_per_row']    = '3';
    $defaults['store_product_page_related_products_per_page']    = '3';



    // Pass through filter.
    $defaults = apply_filters('storecommerce_filter_default_theme_options', $defaults);

	return $defaults;

}

endif;
