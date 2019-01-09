<?php
/**
 * The template for displaying home page.
 * Template Name: Front-page Template
 *
 * @package StoreCommerce
 */


get_header();
?>
<?php $theme_path = get_template_directory_uri(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php dynamic_sidebar('frontpage-content-widgets'); ?>


        </main><!-- #main -->
    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
