<?php
if (!class_exists('StoreCommerce_Store_Features')) :
    /**
     * Adds StoreCommerce_Store_Features widget.
     */
    class StoreCommerce_Store_Features extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array(
                'storecommerce-store-features-title',
                'storecommerce-store-features-subtitle',
                'storecommerce-store-features-1-icon',
                'storecommerce-store-features-1-title',
                'storecommerce-store-features-1-desc',
                'storecommerce-store-features-2-icon',
                'storecommerce-store-features-2-title',
                'storecommerce-store-features-2-desc',
                'storecommerce-store-features-3-icon',
                'storecommerce-store-features-3-title',
                'storecommerce-store-features-3-desc',
            );

            $widget_ops = array(
                'classname' => 'storecommerce_store_features_widget grid-layout',
                'description' => __('Displays posts carousel from selected category.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_store_features', __('AFTSC Store Features', 'storecommerce'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['storecommerce-store-features-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-store-features-subtitle']) ? $instance['storecommerce-store-features-subtitle'] : '';

            $features = array();

            for ($i = 1; $i <= 3; $i++) {
                if (isset($instance['storecommerce-store-features-'.$i.'-title']) && !empty($instance['storecommerce-store-features-'.$i.'-title'])) {
                    $features['features_'.$i.''][] = isset($instance['storecommerce-store-features-'.$i.'-icon']) ? $instance['storecommerce-store-features-'.$i.'-icon'] : '';
                    $features['features_'.$i.''][] = isset($instance['storecommerce-store-features-'.$i.'-title']) ? $instance['storecommerce-store-features-'.$i.'-title'] : '';
                    $features['features_'.$i.''][] = isset($instance['storecommerce-store-features-'.$i.'-desc']) ? $instance['storecommerce-store-features-'.$i.'-desc'] : '';
                }
            }

            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="customer-support">
                <div class="container-wrapper">
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
                    <div class="support-wrap section-body clearfix">
                        <?php if (isset($features)):
                            $col = count($features);
                            $col_class = 'col-'.$col;
                            $count = 1;
                            foreach ($features as $feature):

                                ?>


                                <div class="<?php echo esc_attr($col_class); ?> float-l pad">
                                    <div class="suport-single">
                                        <div class="icon-box">
                                   <span class="icon-box-circle icon-box-circle-color-<?php echo esc_attr($count); ?>">
                                       <i class="<?php echo esc_attr($feature[0]); ?>"></i>
                                   </span>
                                        </div>
                                        <div class="support-content support-content-color-<?php echo esc_attr($count); ?>">
                                            <h5><?php echo esc_html($feature[1]); ?></h5>
                                            <p><?php echo esc_html($feature[2]); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $count++;
                            endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </section>

            <?php
            //print_pre($all_posts);

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
            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-title', 'Title', 'Store Features');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-subtitle', 'Subtitle', 'Store Features Subtitle');
            echo parent::storecommerce_generate_section_title('storecommerce-store-features-1', 'Store Features 1');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-1-icon', 'Icon', 'fa fa-paper-plane');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-1-title', 'Title', 'Free Shipping');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-1-desc', 'Descriptions', 'On all orders over $75.00');
            echo parent::storecommerce_generate_section_title('storecommerce-store-features-2', 'Store Features 2');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-2-icon', 'Icon', 'fa fa-gift');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-2-title', 'Title', 'Get Discount');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-2-desc', 'Descriptions', 'Get Coupon & Discount');
            echo parent::storecommerce_generate_section_title('storecommerce-store-features-3', 'Store Features 3');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-3-icon', 'Icon', 'fa fa-life-ring');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-3-title', 'Title', '24/7 Suport');
            echo parent::storecommerce_generate_text_input('storecommerce-store-features-3-desc', 'Descriptions', 'We will be at your service');

        }
    }
endif;