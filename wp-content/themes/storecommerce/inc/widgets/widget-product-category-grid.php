<?php
if (!class_exists('StoreCommerce_Product_Category_Grid')) :
    /**
     * Adds StoreCommerce_Product_Category_Grid widget.
     */
    class StoreCommerce_Product_Category_Grid extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-product-category-title', 'storecommerce-product-category-subtitle', 'storecommerce-product-category-title-note');
            $this->select_fields = array('storecommerce-select-category-1', 'storecommerce-select-category-2', 'storecommerce-select-category-3', 'storecommerce-product-onsale-count', 'storecommerce-product-count');

            $widget_ops = array(
                'classname' => 'storecommerce_product_category_grid_widget',
                'description' => __('Displays grid from selected categories.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_product_category_grid', __('AFTSC Product Category Grid', 'storecommerce'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         */

        public function widget($args, $instance)
        {

            $instance = parent::storecommerce_sanitize_data($instance, $instance);


            /** This filter is documented in wp-includes/default-widgets.php */

            $title = apply_filters('widget_title', $instance['storecommerce-product-category-title'], $instance, $this->id_base);

            $subtitle = isset($instance['storecommerce-product-category-subtitle']) ? $instance['storecommerce-product-category-subtitle'] : '';
            $title_note = '';
            $category_1 = isset($instance['storecommerce-select-category-1']) ? $instance['storecommerce-select-category-1'] : '0';
            $category_2 = isset($instance['storecommerce-select-category-2']) ? $instance['storecommerce-select-category-2'] : '0';
            $category_3 = isset($instance['storecommerce-select-category-3']) ? $instance['storecommerce-select-category-3'] : '0';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="categories">
                <div class="container-wrapper">
                    <div class="row">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <span class="header-after">
                                        <?php echo esc_html($title); ?>
                                    </span>
                                </h4>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)): ?>
                                <span class="section-subtitle">
                                    <?php echo esc_html($subtitle); ?>
                                </span>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                    <div class="section-body clearfix">
                        <div class="col-3 float-l pad btm-margi product-ful-wid">
                            <div class="sale-single-wrap">
                                <?php storecommerce_product_category_loop($category_1); ?>
                            </div>
                        </div>
                        <div class="col-3 float-l pad btm-margi product-ful-wid">
                            <div class="sale-single-wrap">
                                <?php storecommerce_product_category_loop($category_2); ?>
                            </div>
                        </div>
                        <div class="col-3 float-l pad btm-margi product-ful-wid">
                            <div class="sale-single-wrap">
                                <?php storecommerce_product_category_loop($category_3); ?>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </section>

            <?php
            // close the widget container
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance)
        {
            $this->form_instance = $instance;


            //print_pre($terms);
            $categories = storecommerce_get_terms('product_cat');
            $options = array(
                'true' => __('Yes', 'storecommerce'),
                'false' => __('No', 'storecommerce'),
            );

            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::storecommerce_generate_text_input('storecommerce-product-category-title', __('Title', 'storecommerce'), 'Product Categories Grid');
                echo parent::storecommerce_generate_text_input('storecommerce-product-category-subtitle', __('Subtitle', 'storecommerce'), 'Product Categories Grid Subtitle');
                echo parent::storecommerce_generate_select_options('storecommerce-select-category-1', __('Select category 1', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_select_options('storecommerce-select-category-2', __('Select category 2', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_select_options('storecommerce-select-category-3', __('Select category 3', 'storecommerce'), $categories);
                echo parent::storecommerce_generate_select_options('storecommerce-product-count', __('Show Product Count', 'storecommerce'), $options);


            }

            //print_pre($terms);


        }

    }
endif;