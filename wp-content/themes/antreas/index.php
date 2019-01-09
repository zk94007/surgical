<?php get_header(); ?>

<?php if ( antreas_show_posts() ) : ?>
	<div id="main" class="main section">
		<div class="container">
			<?php antreas_section_heading( 'blog' ); ?>
			<section id="content" class="content">
				<?php do_action( 'antreas_before_content' ); ?>
				<?php antreas_grid( null, 'element', 'blog', 3, array( 'class' => 'column-narrow' ) ); ?>
				<?php antreas_numbered_pagination(); ?>
				<?php do_action( 'antreas_after_content' ); ?>
			</section>
			<?php get_sidebar(); ?>
			<div class="clear"></div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
