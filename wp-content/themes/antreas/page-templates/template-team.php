<?php /* Template Name: Team */ ?>
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

			<?php $columns = 4; ?>
			<?php $query   = new WP_Query( 'post_type=cpo_team&posts_per_page=-1&order=ASC&orderby=menu_order' ); ?>
			<?php if ( $query->posts ) : ?>
				<section id="team" class="team">
					<?php antreas_grid( $query->posts, 'element', 'team', $columns, array( 'class' => 'column-narrow' ) ); ?>
				</section>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			
			<?php do_action( 'antreas_after_content' ); ?>
		</section>
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>
