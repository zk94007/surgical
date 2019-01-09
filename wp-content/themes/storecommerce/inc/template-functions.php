<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package StoreCommerce
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function storecommerce_body_classes($classes)
{
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    global $post;
    $global_layout = storecommerce_get_option('global_content_layout');
    if (!empty($global_layout)) {
        $classes[] = $global_layout;
    }

    $global_alignment = storecommerce_get_option('global_content_alignment');
    $page_layout = $global_alignment;

    // Check if single.
    if ( $post && is_singular() ) {
        $post_options = get_post_meta($post->ID, 'storecommerce-meta-content-alignment', true);
        if (!empty($post_options)) {
            $page_layout = $post_options;
        } else {
            $page_layout = $global_alignment;
        }
    }

    if ( function_exists('is_woocommerce') && is_woocommerce() ) {
        $store_alignment = storecommerce_get_option('store_global_alignment');
        if (!empty($store_alignment)) {
            $page_layout = $store_alignment;
        } else {
            $page_layout = $global_alignment;
        }
    }


    if ($page_layout == 'align-content-right') {
        if ( is_front_page() ) {
            if (is_page_template('tmpl-front-page.php')) {
                $classes[] = 'full-width-content';
            } else {
                if (function_exists('is_woocommerce') && is_woocommerce()){
                    if (is_active_sidebar('shop-sidebar-widgets')) {
                        $classes[] = 'align-content-right';
                    } else {
                        $classes[] = 'full-width-content';
                    }

                } else {
                    if (is_active_sidebar('sidebar-1')) {
                        $classes[] = 'align-content-right';
                    } else {
                        $classes[] = 'full-width-content';
                    }
                }
            }
        } else {
            if (function_exists('is_woocommerce') && is_woocommerce()){
                if (is_active_sidebar('shop-sidebar-widgets')) {
                    $classes[] = 'align-content-right';
                } else {
                    $classes[] = 'full-width-content';
                }
            } else {
                if (is_active_sidebar('sidebar-1')) {
                    $classes[] = 'align-content-right';
                } else {
                    $classes[] = 'full-width-content';
                }
            }
        }
    } elseif ($page_layout == 'full-width-content') {
        $classes[] = 'full-width-content';
    } else {
        if ( is_front_page() ) {
            if (is_page_template('tmpl-front-page.php')) {
                $classes[] = 'full-width-content';
            } else {
                if (function_exists('is_woocommerce') && is_woocommerce()){
                    if (is_active_sidebar('shop-sidebar-widgets')) {
                        $classes[] = 'align-content-left';
                    } else {
                        $classes[] = 'full-width-content';
                    }
                } else {
                    if (is_active_sidebar('sidebar-1')) {
                        $classes[] = 'align-content-left';
                    } else {
                        $classes[] = 'full-width-content';
                    }
                }
            }

        } else {
            if (function_exists('is_woocommerce') && is_woocommerce()){
                if (is_active_sidebar('shop-sidebar-widgets')) {
                    $classes[] = 'align-content-left';
                } else {
                    $classes[] = 'full-width-content';
                }
            } else {
                if (is_active_sidebar('sidebar-1')) {
                    $classes[] = 'align-content-left';
                } else {
                    $classes[] = 'full-width-content';
                }
            }
        }
    }
    return $classes;


}

add_filter('body_class', 'storecommerce_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function storecommerce_pingback_header()
{
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
    }
}

add_action('wp_head', 'storecommerce_pingback_header');

if (!function_exists('storecommerce_post_categories')) :
    function storecommerce_post_categories($separator = '&nbsp', $taxonomy = 'product_cat')
    {
        // Hide category and tag text for pages.
        //if ('post' === get_post_type()) {

        global $post;
        //print_pre($post);
        $post_categories = get_the_terms($post->ID, $taxonomy);

        if ($post_categories) {
            $output = '<ul class="cat-links">';
            foreach ($post_categories as $post_category) {
                $t_id = $post_category->term_id;
                $color_id = "category_color_" . $t_id;

                // retrieve the existing value(s) for this meta field. This returns an array
                $term_meta = get_option($color_id);
                $color_class = ($term_meta) ? $term_meta['color_class_term_meta'] : 'category-color-1';
                $output .= '<li class="meta-category">
                             <a class="storecommerce-categories ' . esc_attr($color_class) . '" href="' . esc_url(get_term_link($post_category)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'storecommerce'), $post_category->name)) . '"> 
                                 ' . esc_html($post_category->name) . '
                             </a>
                        </li>';
            }
            $output .= '</ul>';
            echo $output;

        }
        // }
    }
endif;



if (!function_exists('storecommerce_get_block')) :
    /**
     *
     * @since StoreCommerce 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function storecommerce_get_block($block = '')
    {
        if (!empty($block)) {
            get_template_part('inc/blocks/block', $block);
        }

    }
endif;

if (!function_exists('storecommerce_archive_title')) :
    /**
     *
     * @since Magazine 7 1.0.0
     *
     * @param null
     * @return null
     *
     */

    function storecommerce_archive_title($title)
    {
        if (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_tag()) {
            $title = single_tag_title('', false);
        } elseif (is_author()) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        } elseif (is_post_type_archive()) {
            $title = post_type_archive_title('', false);
        } elseif (is_tax()) {
            $title = single_term_title('', false);
        }

        return $title;
    }

endif;
add_filter('get_the_archive_title', 'storecommerce_archive_title');


if (!function_exists('storecommerce_get_category_color_class')) :

    function storecommerce_get_category_color_class($term_id)
    {

        $color_id = "category_color_" . $term_id;
        // retrieve the existing value(s) for this meta field. This returns an array
        $term_meta = get_option($color_id);
        $color_class = ($term_meta) ? $term_meta['color_class_term_meta'] : '';
        return $color_class;


    }
endif;

/**
 * Descriptions on Header Menu
 * @author AF themes
 * @param string $item_output , HTML outputp for the menu item
 * @param object $item , menu item object
 * @param int $depth , depth in menu structure
 * @param object $args , arguments passed to wp_nav_menu()
 * @return string $item_output
 */
function storecommerce_header_menu_desc($item_output, $item, $depth, $args)
{

    if ('aft-primary-nav' == $args->theme_location && $item->description)
        $item_output = str_replace('</a>', '<span class="menu-description">' . $item->description . '</span></a>', $item_output);

    return $item_output;
}

add_filter('walker_nav_menu_start_el', 'storecommerce_header_menu_desc', 10, 4);


if (!function_exists('storecommerce_post_item_meta')) :

    function storecommerce_post_item_meta()
    {
        global $post;
        $author_id = $post->post_author;
        $display_setting = storecommerce_get_option('global_post_date_author_setting');
        ?>

        <span class="author-links">

            <?php if ($display_setting == 'show-date-author' || $display_setting == 'show-author-only'): ?>

                <span class="item-metadata posts-author">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)) ?>">
                <?php echo esc_html(get_the_author_meta('display_name', $author_id)); ?>
            </a>
        </span>
            <?php endif; ?>
            <?php

            if ($display_setting == 'show-date-author' || $display_setting == 'show-date-only'): ?>
                <span class="item-metadata posts-date">
                <?php echo get_the_time('d M, Y'); ?>
                </span>
            <?php endif; ?>
        </span>
        <?php


    }
endif;


if (!function_exists('storecommerce_post_item_tag')) :

    function storecommerce_post_item_tag($view = 'default')
    {
        global $post;

        if ('post' === get_post_type()) {

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'storecommerce'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html('Tags: %1$s') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }

        if (is_single()) {
            edit_post_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Edit <span class="screen-reader-text">%s</span>', 'storecommerce'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                '<span class="edit-link">',
                '</span>'
            );
        }

    }
endif;

if (!function_exists('storecommerce_get_products')) :
    /**
     * @param $number_of_products
     * @param $category
     * @param $show
     * @param $orderby
     * @param $order
     * @return WP_Query
     */
    function storecommerce_get_products($number_of_products = '4', $category = 0, $show = '', $orderby = 'date', $order = 'DESC')
    {


        $product_visibility_term_ids = wc_get_product_visibility_term_ids();

        $query_args = array(
            'posts_per_page' => $number_of_products,
            'post_status' => 'publish',
            'post_type' => 'product',
            'no_found_rows' => 1,
            'order' => $order,
            'meta_query' => array(),
            'tax_query' => array(
                'relation' => 'AND',
            ),
        );

        if (absint($category) > 0) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_taxonomy_id',
                'terms' => $category

            );

        }


        switch ($show) {
            case 'featured' :
                $query_args['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'term_taxonomy_id',
                    'terms' => $product_visibility_term_ids['featured'],
                );
                break;
            case 'onsale' :
                $product_ids_on_sale = wc_get_product_ids_on_sale();
                $product_ids_on_sale[] = 0;
                $query_args['post__in'] = $product_ids_on_sale;
                break;
        }

        switch ($orderby) {
            case 'price' :
                $query_args['meta_key'] = '_price';
                $query_args['orderby'] = 'meta_value_num';
                break;
            case 'rand' :
                $query_args['orderby'] = 'rand';
                break;
            case 'sales' :
                $query_args['meta_key'] = 'total_sales';
                $query_args['orderby'] = 'meta_value_num';
                break;
            default :
                $query_args['orderby'] = 'date';
        }

        return new WP_Query(apply_filters('storecommerce_widget_query_args', $query_args));
    }
endif;


if (!function_exists('storecommerce_get_featured_image')):
    function storecommerce_get_featured_image($post_id, $size = 'storecommerce-featured')
    {
        if (has_post_thumbnail()) {
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
            $url = $thumb['0'];
        } else {
            $url = '';
        }
        return $url;
    }
endif;


if (!function_exists('storecommerce_product_loop')):
    function storecommerce_product_loop($all_posts)
    { ?>
        <ul class="product-ul">
            <?php
            while ($all_posts->have_posts()): $all_posts->the_post();
                $url = storecommerce_get_featured_image(get_the_ID());
                ?>
                <li class="col-md-3">
                    <div class="product-wrapper">
                        <?php if ($url): ?>
                            <img src="<?php echo esc_attr($url); ?>">
                        <?php endif; ?>
                        <div class="badge-wrapper">
                            <?php do_action('storecommerce_woocommerce_show_product_loop_sale_flash'); ?>
                        </div>
                        <div class="product-description">
                            <ul class="product-item-meta">
                                <li><a href="#"><i class="fas fa-shopping-cart"></i></a></li>
                                <li><a href="#"><i class="fas fa-eye"></i></a></li>
                                <li><a href="#"><i class="fas fa-heart"></i></a></li>
                            </ul>
                            <span class="prodcut-catagory">
                                <?php storecommerce_post_categories(); ?>
                            </span>
                            <h4 class="product-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            <span class="price">
                                <?php do_action('storecommerce_woocommerce_after_shop_loop_item_title'); ?>
                            </span>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </ul>

    <?php }

endif;

if (!function_exists('storecommerce_product_category_loop')):
    function storecommerce_product_category_loop($category, $product_count = 'true', $onsale_product_count = 'true')
    {
        if (0 != absint($category)):
            $term = get_term_by('id', $category, 'product_cat');
            if ($term):
                $term_name = $term->name;
                $term_link = get_term_link($term);
                $products_count = storecommerce_product_count($term->term_id);
                $products_count = ($product_count == 'true') ? $products_count : 0;
                $meta = get_term_meta($category);

                if (isset($meta['thumbnail_id'])) {
                    $thumb_id = $meta['thumbnail_id'][0];
                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'storecommerce-medium-center');
                    $url = $thumb_url[0];
                } else {
                    $url = '';
                }
                ?>
                <div class="data-bg data-bg-hover sale-background"
                     data-background="<?php echo esc_url($url); ?>">
                    <a href="<?php echo esc_url($term_link); ?>"></a>
                </div>
                <div class="sale-info">
            <span class="off-tb">
                <span class="off-tc">
                    <?php if (absint($products_count) > 0): ?>
                        <span class="product-count"><?php printf(_n('<span class="item-count">%s</span><span class="item-texts">item</span>', '<span class="item-count">%s</span><span class="item-texts">items</span>', $products_count, 'storecommerce'), number_format_i18n($products_count)); ?></span>
                    <?php endif; ?>

                    <h4 class="sale-title"><?php echo esc_html($term_name); ?></h4>



                </span>
            </span>

                </div>

            <?php
            endif;
        endif;
    }

endif;

/* Display Product search form with categories*/
if (!function_exists('storecommerce_product_search_form')) :
    /**
     * Display Product search form with categories
     *
     * @since 1.0.0
     *
     * @return void
     */
    function storecommerce_product_search_form()
    {
        ?>
        <form role="search" method="get" class="form-inline woocommerce-product-search"
              action="<?php echo esc_url(home_url('/')); ?>">

            <div class="form-group style-3-search">
                <?php
                $product_cats = get_terms(array(
                    'taxonomy' => 'product_cat',
                ));

                $search_placeholder = storecommerce_get_option('store_product_search_placeholder');
                $cat_placeholder = storecommerce_get_option('store_product_search_category_placeholder');

                $search_autocomplete_class = '';
                $search_autocomplete = storecommerce_get_option('store_product_search_autocomplete');
                if($search_autocomplete == 'yes'){
                    $search_autocomplete_class = ' search-autocomplete';
                }

                if (!empty($product_cats) && !is_wp_error($product_cats)):
                    $selected_product_cat = get_query_var('product_cat');
                    ?>
                    <select name="product_cat" class="cate-dropdown">
                        <option value=""><?php echo '&mdash; '. esc_attr($cat_placeholder) .' &mdash;'; ?></option>
                        <?php
                        foreach ($product_cats as $product_cat) {
                            ?>
                            <option value="<?php echo esc_attr($product_cat->slug) ?>" <?php selected($product_cat->slug, $selected_product_cat) ?>><?php echo esc_html($product_cat->name); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                <?php endif; ?>

                <label class="screen-reader-text"
                       for="woocommerce-product-search-field"><?php esc_html_e('Search for:', 'storecommerce'); ?></label>
                <input type="search" id="woocommerce-product-search-field" class="search-field<?php echo esc_attr($search_autocomplete_class) ?>"
                       placeholder="<?php echo esc_attr($search_placeholder); ?>"
                       value="<?php echo get_search_query(); ?>" name="s"/>

                <button type="submit" value=""><i class="fa fa-search" aria-hidden="true"></i></button>
                <input type="hidden" name="post_type" value="product"/>

            </div>


        </form>
        <?php
    }
endif;

