<?php
if (!class_exists('StoreCommerce_Store_Author_Info')) :
    /**
     * Adds StoreCommerce_Store_Author_Info widget.
     */
    class StoreCommerce_Store_Author_Info extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-author-info-title', 'storecommerce-author-info-subtitle', 'storecommerce-author-info-image', 'storecommerce-author-info-name', 'storecommerce-author-info-desc', 'storecommerce-author-info-phone','storecommerce-author-info-email');
            $this->url_fields = array('storecommerce-author-info-facebook', 'storecommerce-author-info-twitter', 'storecommerce-author-info-linkedin', 'storecommerce-author-info-instagram', 'storecommerce-author-info-vk', 'storecommerce-author-info-youtube' );

            $widget_ops = array(
                'classname' => 'storecommerce_author_info_widget',
                'description' => __('Displays author info.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('storecommerce_author_info', __('AFTSC Author Info', 'storecommerce'), $widget_ops);
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
            echo $args['before_widget'];
            $title = apply_filters('widget_title', $instance['storecommerce-author-info-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-author-info-subtitle']) ? ($instance['storecommerce-author-info-subtitle']) : '';
            $profile_image = isset($instance['storecommerce-author-info-image']) ? ($instance['storecommerce-author-info-image']) : '';

            if($profile_image){
                $image_attributes = wp_get_attachment_image_src( $profile_image, 'large' );
                $image_src = $image_attributes[0];
                $image_class = 'data-bg data-bg-hover';

            }else{
                $image_src = '';
                $image_class = 'no-bg';
            }

            $name = isset($instance['storecommerce-author-info-name']) ? ($instance['storecommerce-author-info-name']) : '';

            $desc = isset($instance['storecommerce-author-info-desc']) ? ($instance['storecommerce-author-info-desc']) : '';
            $facebook = isset($instance['storecommerce-author-info-facebook']) ? ($instance['storecommerce-author-info-facebook']) : '';
            $twitter = isset($instance['storecommerce-author-info-twitter']) ? ($instance['storecommerce-author-info-twitter']) : '';
            $linkedin = isset($instance['storecommerce-author-info-linkedin']) ? ($instance['storecommerce-author-info-linkedin']) : '';
            $youtube = isset($instance['storecommerce-author-info-youtube']) ? ($instance['storecommerce-author-info-youtube']) : '';
            $instagram = isset($instance['storecommerce-author-info-instagram']) ? ($instance['storecommerce-author-info-instagram']) : '';
            $vk = isset($instance['storecommerce-author-info-vk']) ? ($instance['storecommerce-author-info-vk']) : '';

            ?>
            <section class="products">
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
            <div class="posts-author-wrapper">

                <?php if (!empty($image_src)) : ?>
                    <figure class="em-author-img <?php echo esc_attr($image_class); ?>" >
                        <img src="<?php echo esc_attr($image_src); ?>" alt=""/>
                    </figure>
                <?php endif; ?>
                <div class="em-author-details">
                    <?php if (!empty($name)) : ?>
                        <h4 class="em-author-display-name"><?php echo esc_html($name); ?></h4>
                    <?php endif; ?>
                    <?php if (!empty($phone)) : ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="em-author-display-phone"><?php echo esc_html($phone); ?></a>
                    <?php endif; ?>
                    <?php if (!empty($email)) : ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="em-author-display-email"><?php echo esc_html($email); ?></a>
                    <?php endif; ?>
                    <?php if (!empty($desc)) : ?>
                        <p class="em-author-display-name"><?php echo esc_html($desc); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($facebook) || !empty($twitter) || !empty($linkedin)) : ?>
                        <div class="social-navigation">
                        <ul>
                            <?php if (!empty($facebook)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($facebook); ?>" target="_blank"></a>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($youtube)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($youtube); ?>" target="_blank"></a>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($instagram)) : ?>
                                <li>
                                    <a href="<?php echo esc_url($instagram); ?>" target="_blank"></a>
                                </li>
                            <?php endif; ?>



                        </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            </div>
            </section>
            <?php
            //print_pre($all_posts);
            // close the widget container
            echo $args['after_widget'];

            //$instance = parent::storecommerce_sanitize_data( $instance, $instance );


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
            $categories = storecommerce_get_terms();
            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-title', __('About Store', 'storecommerce'), __('Title', 'storecommerce'));
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-subtitle', __('About Store Subtitle', 'storecommerce'), __('Subtitle', 'storecommerce'));
                echo parent::storecommerce_generate_image_upload('storecommerce-author-info-image', __('Profile image', 'storecommerce'), __('Profile image', 'storecommerce'));
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-name', __('Name', 'storecommerce'), __('Name', 'storecommerce'));
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-desc', __('Descriptions', 'storecommerce'), '');
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-facebook', __('Facebook', 'storecommerce'), '');
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-instagram', __('Instagram', 'storecommerce'), '');
                echo parent::storecommerce_generate_text_input('storecommerce-author-info-youtube', __('Youtube', 'storecommerce'), '');



            }
        }
    }
endif;