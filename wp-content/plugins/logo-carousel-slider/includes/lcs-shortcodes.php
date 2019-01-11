<?php

/**
 * Protect direct access
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Accessing this file directly is denied.' );

if (!class_exists("LCS_Shortcode")){
    class LCS_Shortcode{
        public function __construct()
        {
            add_shortcode("logo_carousel_slider", array($this, 'output_shorcode'));
        }
        /**
         * Registers Shortcode
         */
        public function output_shorcode( $atts ) {
            extract(shortcode_atts(array(
                'slider_title' => ''
            ),$atts));

            ob_start();
            // enqueue all scripts and styles for the slider
            wp_enqueue_style( 'lcs-owl-carousel-style' );
            wp_enqueue_style( 'lcs-owl-theme-style' );
            wp_enqueue_style( 'lcs-owl-transitions' );
            wp_enqueue_style( 'lcs-custom-style' );
            wp_enqueue_script( 'lcs-owl-carousel-js' );
            // get the option from the free versions.
            $lcsDisplayNavArr = lcs_get_option( 'lcs_dna', 'lcs_general_settings', 'yes' );
            $nap = lcs_get_option( 'lcs_nap', 'lcs_general_settings', 'top_right' );
            $lcsLogoTitleDisplay = lcs_get_option( 'lcs_dlt', 'lcs_general_settings', 'no' );
            $lcsLogoBorderDisplay = lcs_get_option( 'lcs_dlb', 'lcs_general_settings', 'yes' );
            $lcsLogoHoverEffect = lcs_get_option( 'lcs_lhe', 'lcs_general_settings', 'yes' );
            $lcsImageCrop = lcs_get_option( 'lcs_ic', 'lcs_general_settings', 'yes' );
            $lcsImageCropWidth = lcs_get_option( 'lcs_iwfc', 'lcs_general_settings', '185' );
            $lcsImageCropHeight = lcs_get_option( 'lcs_ihfc', 'lcs_general_settings', '119' );
            $lcs_upscale = lcs_get_option( 'lcs_upscale', 'lcs_general_settings', 'yes' );
            $lcsLogoItems = lcs_get_option( 'lcs_lig', 'lcs_slider_settings', 5 );
            $lcsAutoPlay = lcs_get_option( 'lcs_apg', 'lcs_slider_settings', 'yes' );
            $lcsPagination = lcs_get_option( 'lcs_pagination', 'lcs_slider_settings', 'no' );
            $slider_title_f_size = lcs_get_option( 'lcs_stfs', 'lcs_style_settings', '' ); // It is better not to provide the default font size so that if a user does not use the style setting for any reason, theme can handle this style as the main feature of the theme is to style the content of a site.
            $slider_title_f_color = lcs_get_option( 'lcs_stfc', 'lcs_style_settings', '' ); // it is better not to provide any default color for the title so that theme can handle the style. Else, giving a different title color forcibly, may discourage user using the plugin.

            $lcsAutoPlayRun = ($lcsAutoPlay == "yes") ? "true" : "false";
            $lcsPagiTrueFalse = ($lcsPagination == "yes") ? 'true' : 'false';



            // get the option from the



            $logos = new WP_Query( array(
                'post_type'      => 'logocarousel',
                'posts_per_page' => -1
            ) );
            /*
             * TESTING CODE @TODO; Remove the following code after finishing logo carousel pro
             * Possible blue print for handing the import of the plugin
             * create an array of args to insert a new term. name can be like 'exported'
             * insert a term and get the term id and term_tax id
             * get all the posts from the free version
             *
             * loop through the fetched posts and create an array of args with the value of fetched post and the term id for inserting new posts
             * Insert news posts during each iteration of the loop
             * After all posts have been inserted, fetch all the settings from the old plugin and then
             * create a new carousel slider with a exported name and set the meta settings of the
             *
             *
             *
             * */
            //var_dump($logos->posts);

            // lets iterate over the array and build the array
           /* if ($logos->have_posts()){

                foreach ($logos->posts as $post){

                    $thumbnail_id = get_post_meta($post->ID, '_thumbnail_id', true);
                    $args = array(
                        'post_date' =>  $post->post_date ,
                        'post_date_gmt' =>  $post->post_date_gmt ,
                        'post_content' =>  $post->post_content ,
                        'post_title' =>  $post->post_title ,
                        'post_status' =>  $post->post_status ,
                        'comment_status' =>  $post->comment_status ,
                        'post_type' =>  'logocarouselpro' ,
                        'meta_input'   => array(
                            'lcsp_logo_link' => get_post_meta($post->ID, 'lcs_logo_link', true),
                            'lcsp_tooltip_text' => get_post_meta($post->ID, 'lcsp_tooltip_text', true),
                        ),
                    );
                    $inserted_id = wp_insert_post($args, true);

                    if (!is_wp_error($inserted_id)){
                        set_post_thumbnail($inserted_id, $thumbnail_id);
                    }

                }

            }*/


        if ( $logos->have_posts() ) { ?>

            <style type="text/css">

                <?php if (!empty($slider_title_f_color) || !empty($slider_title_f_size)){
                    echo 'h2.lcs_logo_carousel_slider_title{';
                    echo !empty($slider_title_f_size) ? "font-size: ". esc_attr($slider_title_f_size) ." !important;" : '';
                    echo !empty($slider_title_f_color) ? "color: ". esc_attr($slider_title_f_color) ." !important;" : '';
                    echo '}';
                } ?>

                <?php if ($lcsLogoHoverEffect == 'yes') {?>
                .lcs_logo_container a.lcs_logo_link:hover { border: 1px solid #A0A0A0; ?>; }
                .lcs_logo_container a:hover img { -moz-transform: scale(1.05); -webkit-transform: scale(1.05); -o-transform: scale(1.05); -ms-transform: scale(1.05); transform: scale(1.05); }
                <?php } ?>
                <?php if ($lcsLogoBorderDisplay == 'yes') {?>
                .lcs_logo_container a.lcs_logo_link { border: 1px solid #d6d4d4; }
                <?php } else { ?>
                .lcs_logo_container a.lcs_logo_link, .lcs_logo_container a.lcs_logo_link:hover { border: none; }
                <?php } ?>
                #lcs_logo_carousel_wrapper .owl-nav {
                    position: absolute;
                    margin-top: 0;
                }

                /* TOP Right*/
                <?php if ($nap == 'top_right') { ?>
                #lcs_logo_carousel_wrapper .owl-nav {
                    right: 0;
                    top: -34px;
                }
                <?php } ?>
                /* TOP Left*/
                <?php if ($nap == 'top_left') { ?>
                #lcs_logo_carousel_wrapper .owl-nav {
                    left: 0;
                    top: -34px;
                }
                <?php } ?>

                #lcs_logo_carousel_wrapper .owl-nav div {
                    background: #ffffff;
                    border-radius: 2px;
                    margin: 2px;
                    padding: 0;
                    width: 27px;
                    height: 27px;
                    line-height: 20px;
                    font-size: 22px;
                    color: #ccc;
                    border: 1px solid #ccc;
                    opacity: 1;
                    z-index: 999;
                    -moz-transition: all 0.3s linear;
                    -o-transition: all 0.3s linear;
                    -webkit-transition: all 0.3s linear;
                    transition: all 0.3s linear;
            </style>

            <?php if( !empty( $slider_title) ) { ?>
                <h2 class="lcs_logo_carousel_slider_title"><?php echo $slider_title; ?> </h2>
            <?php } ?>
            <div id="lcs_logo_carousel_wrapper">
                <div id="lcs_logo_carousel_slider" class="owl-carousel owl-theme">
                    <?php while ( $logos->have_posts() ) { $logos->the_post(); ?>

                        <?php
                        $post_id = get_the_ID();
                        $lcs_logo_link = get_post_meta( $post_id, 'lcs_logo_link', true );
                        // at this point we can add some kind of checking or setting to see if the user has new logo or using old logo.
                        // some idea. at the activation hook, we can catch the featured image/logo link of all logo and then update them to a new metakey sot that it matches updated metabox feature.
                        $lcs_logo_id = get_post_thumbnail_id();
                        $lcs_logo_url = wp_get_attachment_image_src($lcs_logo_id,'full',true);
                        $lcs_logo_mata = get_post_meta($lcs_logo_id,'_wp_attachment_image_alt',true);
                        $lcs_logo = ''; // let have precaution from probable error from undefined var
                        if ($lcsImageCrop == "yes"){
                            $lcs_upscale = (!empty($lcs_upscale) && 'yes' == $lcs_upscale) ? true : false;
                            $lcs_logo = aq_resize( $lcs_logo_url[0], $lcsImageCropWidth, $lcsImageCropHeight, true, true, $lcs_upscale );
                        }
                        ?>
                        <div class="lcs_logo_container">


                            <?php if(!empty($lcs_logo_link)) { ?>
                                <a href="<?php echo esc_url( $lcs_logo_link); ?>" class="lcs_logo_link" target="_blank">
                                    <?php
                                    if ( $lcsImageCrop == "yes" ) {
                                        echo '<img src="'.esc_url( $lcs_logo).'" alt="'. esc_attr( $lcs_logo_mata) . '" />';
                                    } else {
                                        echo '<img src="'.esc_url( $lcs_logo_url[0]).'" alt="'. esc_attr( $lcs_logo_mata) . '" />';
                                    }
                                    ?>
                                </a>
                            <?php } else { ?>
                                <a class="lcs_logo_link not_active">
                                    <?php
                                    if ( $lcsImageCrop == "yes" ) {
                                        echo '<img src="'.esc_url( $lcs_logo).'" alt="'. esc_attr( $lcs_logo_mata) . '" />';					} else {
                                        echo '<img src="'.esc_url( $lcs_logo_url[0]).'" alt="'. esc_attr( $lcs_logo_mata) . '" />';
                                    }
                                    ?>
                                </a>
                            <?php } ?>
                            <?php if( $lcsLogoTitleDisplay == "yes" ) { ?>
                                <?php if(!empty($lcs_logo_link)) { ?>
                                    <a href="<?php echo $lcs_logo_link; ?>" target="_blank"><h3 class="lcs_logo_title"><?php echo get_the_title() ?></h3></a>
                                <?php } else { ?>
                                    <h3 class="lcs_logo_title"><?php echo get_the_title() ?></h3>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php }
                    wp_reset_postdata(); ?>
                    <?php }  else {
                        _e('No logos found', LCS_TEXTDOMAIN);
                    } ?>
                </div> <!-- End lcs_logo_carousel_slider -->
            </div> <!--ends #lcs_logo_carousel_wrapper-->

            <!--UPDATED Carousel VERSION CODE-->
            <!--INITIALIZE THE SLIDER-->
            <script>
                jQuery(document).ready(function($){
                    var logoSlider = $("#lcs_logo_carousel_slider");

                    logoSlider.owlCarousel({
                        loop:true,
                        autoWidth:false,
                        responsiveClass:true,
                        dots:<?= $lcsPagiTrueFalse; ?>,
                        autoplay:<?= $lcsAutoPlayRun; ?>,

                        autoplayTimeout: <?= (!empty($slider_speed)) ? intval($slider_speed) : 4000; ?>,
                        autoplayHoverPause: false,
                        dotData:true,
                        dotsEach:false,
                        slideBy:1,
                        rtl:<?= is_rtl() ? 'true': 'false'; ?>,
                        nav:<?=( !empty( $lcsDisplayNavArr) && 'yes' == $lcsDisplayNavArr ) ? 'true':'false'; ?>,
                        navText:['‹','›'],
                        smartSpeed: 1000, // it smooths the transition
                        responsive:{
                            0 : {
                                items:2
                            },
                            500: {
                                items:3
                            },
                            600 : {
                                items:3
                            },
                            768:{
                                items:4
                            },
                            1199:{
                                items:<?= intval($lcsLogoItems); ?>
                            }
                        }
                    });


                    // custom navigation button for slider
                    // at first. let us cache the element
                    var $lcs_wrap = $('#lcs_logo_carousel_wrapper');
                    // Go to the next item
                    $lcs_wrap.on('click', '.prev', function () {
                        logoSlider.trigger('prev.owl.carousel');
                    });

                    // Go to the previous item
                    $lcs_wrap.on('click', '.next', function () {
                        // With optional speed parameter
                        // Parameters has to be in square bracket '[]'
                        logoSlider.trigger('next.owl.carousel');
                    })


                });
            </script>
            <?php

            return ob_get_clean();

        }

    } // end class LCS_Shortcode
} // end if


