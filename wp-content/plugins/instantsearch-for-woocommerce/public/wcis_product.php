<?php
/**
 * wcis_product.php File
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
 * @copyright 2017 Fast Simon (http://www.instantsearchplus.com)
 * @license   Open Software License (OSL 3.0)*
 * @link      http://opensource.org/licenses/osl-3.0.php
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WCIS_WC_Product
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
 * @copyright 2017 Fast Simon (http://www.instantsearchplus.com)
 * @license   Open Software License (OSL 3.0)*
 * @link      http://opensource.org/licenses/osl-3.0.php
 */
class WCIS_WC_Product
{
    /**
     * @var WC_Product $product
     */
    private $product;
    /**
     * WCIS_WC_Product constructor.
     * 
     * @param WC_Product $product seed object
     */
    public function __construct($product) 
    {
        $this->product = $product;
    }

    /**
     * Magic __get method for backwards compatibility. Maps legacy vars to new getters.
     * without raising notices
     *
     * @param  string $key Key name.
     * @return mixed
     */
    public function __get($key)
    {

        if ('post_type' === $key) {
            return $this->product->get_type();
        }

        switch ( $key ) {
        case 'id' :
            $value = $this->product->is_type('variation') ? $this->get_parent_id() : $this->get_id();
            break;
        case 'product_type' :
            $value = $this->product->get_type();
            break;
        case 'product_attributes' :
            $value = isset($this->product->data['attributes']) ? $this->product->data['attributes'] : '';
            break;
        case 'visibility' :
            $value = $this->product->get_catalog_visibility();
            break;
        case 'sale_price_dates_from' :
            return $this->product->get_date_on_sale_from() ? $this->product->get_date_on_sale_from()->getTimestamp() : '';
            break;
        case 'sale_price_dates_to' :
            return $this->product->get_date_on_sale_to() ? $this->product->get_date_on_sale_to()->getTimestamp() : '';
            break;
        case 'post' :
            $value = get_post($this->product->get_id());
            break;
        case 'download_type' :
            return 'standard';
            break;
        case 'product_image_gallery' :
            $value = $this->product->get_gallery_image_ids();
            break;
        case 'variation_shipping_class' :
        case 'shipping_class' :
            $value = $this->product->get_shipping_class();
            break;
        case 'total_stock' :
            $value = $this->product->get_total_stock();
            break;
        case 'downloadable' :
        case 'virtual' :
        case 'manage_stock' :
        case 'featured' :
        case 'sold_individually' :
            $value = $this->product->{"get_$key"}() ? 'yes' : 'no';
            break;
        case 'crosssell_ids' :
            $value = $this->product->get_cross_sell_ids();
            break;
        case 'upsell_ids' :
            $value = $this->product->get_upsell_ids();
            break;
        case 'parent' :
            $value = wc_get_product($this->product->get_parent_id());
            break;
        case 'variation_id' :
            $value = $this->product->is_type('variation') ? $this->get_id() : '';
            break;
        case 'variation_data' :
            $value = $this->product->is_type('variation') ? wc_get_product_variation_attributes($this->product->get_id()) : '';
            break;
        case 'variation_has_stock' :
            $value = $this->product->is_type('variation') ? $this->product->managing_stock() : '';
            break;
        case 'variation_shipping_class_id' :
            $value = $this->product->is_type('variation') ? $this->product->get_shipping_class_id() : '';
            break;
        case 'variation_has_sku' :
        case 'variation_has_length' :
        case 'variation_has_width' :
        case 'variation_has_height' :
        case 'variation_has_weight' :
        case 'variation_has_tax_class' :
        case 'variation_has_downloadable_files' :
            $value = true; // These were deprecated in 2.2 and simply returned true in 2.6.x.
            break;
        default :
            if (in_array($key, array_keys($this->product->get_data()))) {
                $value = $this->product->{"get_$key"}();
            } else {
                $value = get_post_meta($this->product->get_id(), '_' . $key, true);
            }
            break;
        }
        return $value;
    }

    /**
     * __call if called method is not present in WCIS_WC_Product we will call it
     * from WC_Product class
     *
     * @param $name WC_Product method name
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($name, $parameters) {
        if (count($parameters) == 0) {
            $value = $this->product->$name();
        } else {
            switch (count($parameters)) {
                case 1: $value = $this->product->$name($parameters[0]);
                    break;
                case 2: $value = $this->product->$name($parameters[0], $parameters[1]);
                    break;
                case 3: $value = $this->product->$name($parameters[0], $parameters[1], $parameters[2]);
                    break;
                case 4: $value = $this->product->$name($parameters[0], $parameters[1], $parameters[2], $parameters[3]);
                    break;
                case 5: $value = $this->product->$name(
                            $parameters[0], $parameters[1], $parameters[2], $parameters[3], $parameters[4]
                            );
                    break;
                default: $value = $this->product->$name($parameters);
                    break;
            }
        }
        return $value;
    }

    /**
     * get_post_data wrapper for get_post
     *
     * @return array|null|WP_Post
     */
    public function get_post_data() {
        return get_post($this->product->get_id());
    }

    /**
     * get_image returns product image
     *
     * @param string $size
     *
     * @return string
     */
    public function get_image($size='shop_thumbnail') {
        return $this->product->get_image($size);
    }
}