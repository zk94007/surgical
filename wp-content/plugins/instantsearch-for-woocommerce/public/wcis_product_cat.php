<?php
/**
 * wcis_product_cat.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category Mage
 *
 * @package   Instantsearchplus
 * @author    Fast Simon <info@instantsearchplus.com>
 * @copyright 2018 Fast Simon (http://www.instantsearchplus.com)
 * @license   Open Software License (OSL 3.0)*
 * @link      http://opensource.org/licenses/osl-3.0.php
 */

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
    <header class="woocommerce-products-header">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action( 'woocommerce_archive_description' );
        ?>
    </header>
<?php
global $wp_query;
const SERVER_URL = 'https://acp-magento.appspot.com/';

$html = '<script>var __isp_fulltext_search_obj = { uuid: "'. get_option('wcis_site_id').'",
                                                           store_id: '.get_current_blog_id().'}
        </script>';

$cat_str = '';
$full_cat_str = $wp_query->query['product_cat'];
$full_cat_arr = explode('/', $full_cat_str);
if (count($full_cat_arr) > 0) {
    $cat = get_term_by('slug', $full_cat_arr[count($full_cat_arr) - 1], 'product_cat');
    $cat_str = '&category_id=' . $cat->term_id;
}

echo $html;

echo '<script src="https://bigcommerce.instantsearchplus.com/js/search_result_loading_page.js?smart_navigation=1&isp_platform=woocommerce&UUID=' . get_option( 'wcis_site_id' ) . '&store_id=' . get_current_blog_id() . $cat_str . '"></script>';

do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );