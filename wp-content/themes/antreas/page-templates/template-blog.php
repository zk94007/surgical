<?php /* Template Name: Blog */ ?>
<?php get_header(); ?>

<div id="main" class="main">
	<div class="container">
		<section id="content" class="content">
			<?php do_action( 'antreas_before_content' ); ?>

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="page-content">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php $query = new WP_Query( 'post_type=post&paged=' . antreas_current_page() . '&posts_per_page=' . get_option( 'posts_per_page' ) ); ?>
			<?php if ( $query->posts ) : ?>
				<?php antreas_grid( $query->posts, 'element', 'blog', 3, array( 'class' => 'column-narrow' ) ); ?>
				<?php antreas_numbered_pagination( $query ); ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<?php do_action( 'antreas_after_content' ); ?>
		</section>
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>
