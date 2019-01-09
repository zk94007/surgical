<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package StoreCommerce
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<div class="post-thumbnail-wrap">
        <?php  if ('post' === get_post_type()) : ?>
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
        <?php endif; ?>


        <?php storecommerce_post_thumbnail(); ?>
    </div>
    <div class="entry-wrapper">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			storecommerce_posted_on();
			storecommerce_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->


	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php storecommerce_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</div>
</article><!-- #post-<?php the_ID(); ?> -->
