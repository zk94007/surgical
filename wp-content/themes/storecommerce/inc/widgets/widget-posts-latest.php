<?php
if (!class_exists('StoreCommerce_Posts_Latest')) :
    /**
     * Adds StoreCommerce_Posts_Latest widget.
     */
    class StoreCommerce_Posts_Latest extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('storecommerce-posts-latest-title', 'storecommerce-posts-latest-subtitle', 'storecommerce-number-of-items');

            $this->select_fields = array('storecommerce-show-excerpt', 'storecommerce-select-category', 'storecommerce-show-all-link');

            $widget_ops = array(
                'classname' => 'posts_latest_widget',
                'description' => __('Displays latest posts lists from selected category.', 'storecommerce'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('product_posts_latest', __('AFTSC Latest Posts', 'storecommerce'), $widget_ops);
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
            $title = apply_filters('widget_title', $instance['storecommerce-posts-latest-title'], $instance, $this->id_base);
            $subtitle = isset($instance['storecommerce-posts-latest-subtitle']) ? $instance['storecommerce-posts-latest-subtitle'] : '';
            $show_exceprt = isset($instance['storecommerce-show-excerpt']) ? $instance['storecommerce-show-excerpt'] : 'true';

            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="blog">
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
                    <div class="blog-wrapper section-body clearfix">
                        <?php
                        $all_posts = storecommerce_get_posts(3, 0);
                        if ($all_posts->have_posts()) :
                            while ($all_posts->have_posts()) : $all_posts->the_post();
                                if (has_post_thumbnail()) {
                                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'storecommerce-medium-square');
                                    $url = $thumb['0'];
                                } else {
                                    $url = '';
                                }
                                global $post;

                                ?>
                                <div class="col-3 float-l pad half-post-wid" data-mh="latest-post-loop">
                                    <div class="blog-single">
                                        <div class="blog-img">
                                            <a href="#">
                                        <span class="data-bg data-bg-hover post-image"
                                              data-background="<?php echo esc_url($url); ?>">
                                            <span class="view-blog"></span>
                                        </span>
                                            </a>
                                            <span class="item-metadata posts-date">
                                                <span class="posted-day">
                                                    <?php echo get_the_time('d'); ?>
                                                </span>
                                                <span class="posted-month">
                                                <?php echo get_the_time('M'); ?>
                                                </span>
                                                <span class="posted-year">
                                                <?php echo get_the_time('Y'); ?>
                                                </span>
                                             </span>
                                        </div>
                                        <div class="blog-details">
                                            <div class="blog-categories">
                                                <?php echo storecommerce_post_format($post->ID); ?>
                                                <?php storecommerce_post_categories('&nbsp', 'category'); ?>
                                            </div>
                                            <div class="blog-title">
                                                <h4>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>
                                            </div>
                                            <div class="entry-meta">
                                                <?php
                                                storecommerce_posted_by();
                                                ?>
                                            </div><!-- .entry-meta -->
                                            <?php if ($show_exceprt == 'true'): ?>
                                                <div class="blog-content">
                                                <span>
                                                    <?php
                                                    $excerpt = storecommerce_get_excerpt(25, get_the_content());
                                                    echo wp_kses_post(wpautop($excerpt));
                                                    ?>
                                                </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
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

            $options = array(
                'true' => __('Yes', 'storecommerce'),
                'false' => __('No', 'storecommerce'),

            );


            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry

            $categories = storecommerce_get_terms('category');
            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::storecommerce_generate_text_input('storecommerce-posts-latest-title', __('Title', 'storecommerce'), __('Latest Posts', 'storecommerce'));
            echo parent::storecommerce_generate_text_input('storecommerce-posts-latest-subtitle', __('Subtitle', 'storecommerce'), __('Latest Posts Subtitle', 'storecommerce'));
            echo parent::storecommerce_generate_select_options('storecommerce-show-excerpt', __('Show excerpt', 'storecommerce'), $options);




        }
    }
endif;