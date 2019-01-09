<?php /* Template Name: Portfolio */ ?>
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

			<?php antreas_secondary_menu( 'cpo_portfolio_category', 'menu-portfolio' ); ?>

			<?php $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; ?>
			<?php $columns      = 5; ?>
			<?php $post_number  = $columns * 3; ?>
			<?php $query        = new WP_Query( 'post_type=cpo_portfolio&paged=' . $current_page . '&posts_per_page=' . $post_number . '&order=ASC&orderby=menu_order' ); ?>

			<?php if ( $query->posts ) : ?>
				<?php $feature_count = 0; ?>
				<section id="portfolio" class="portfolio">
					<?php antreas_grid( $query->posts, 'element', 'portfolio', $columns, array( 'class' => 'column-fit' ) ); ?>
				</section>
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
