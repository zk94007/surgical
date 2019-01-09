<?php
if (!class_exists('StoreCommerce_Social_Contacts')) :
    /**
     * Adds StoreCommerce_Social_Contacts widget.
     */
    class StoreCommerce_Social_Contacts extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-social-contacts-title', 'storecommerce-social-contacts-subtitle');


            $widget_ops = array(
                'classname' => 'storecommerce_social_contacts_widget',
                'description' => __('Displays social contacts lists from Social Menu items.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_social_contacts', __('AFTSC Social Contacts', 'storecommerce'), $widget_ops);
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
            $title = apply_filters('widget_title', $instance['storecommerce-social-contacts-title'], $instance, $this->id_base);
            $title = isset($title) ? $title : __('Social Contacts', 'storecommerce');
            $subtitle = isset($instance['storecommerce-social-contacts-subtitle']) ? $instance['storecommerce-social-contacts-subtitle'] : 'Social Contacts Subtitle';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="social-contacts">
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

                    <div class="social-navigation">
                        <?php
                        if (has_nav_menu('aft-social-nav')) {
                            wp_nav_menu(array(
                                'theme_location' => 'aft-social-nav',
                                'link_before' => '<span class="screen-reader-text">',
                                'link_after' => '</span>',
                            ));
                        } ?>
                    </div>
                    <?php if (!has_nav_menu('aft-social-nav')) : ?>
                        <p>
                            <?php esc_html_e('Your Social Menu is not set. You need to create menu and assign it to Social Menu from the Menu Settings.', 'storecommerce'); ?>
                        </p>
                    <?php endif; ?>
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

            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::storecommerce_generate_text_input('storecommerce-social-contacts-title', 'Title', 'StoreCommerce Social Contacts');
            echo parent::storecommerce_generate_text_input('storecommerce-social-contacts-subtitle', 'Subtitle', 'Social Contacts Subtitle');

        }


    }
endif;