<?php get_header(); ?>

<div id="main" class="main">
	<div class="container">
		<section id="content" class="content">
			<?php do_action( 'antreas_before_content' ); ?>
			
			<?php $description = term_description(); ?>
			<?php if ( $description !== '' ) : ?>
				<div class="page-content">
					<?php echo $description; ?>
				</div>
			<?php endif; ?>
			
			<?php antreas_secondary_menu( 'cpo_portfolio_category', 'menu-portfolio' ); ?>
				
			<?php if ( have_posts() ) : ?>
				<div id="portfolio" class="portfolio">
					<?php antreas_grid( null, 'element', 'portfolio', 5, array( 'class' => 'column-fit' ) ); ?>
				</div>
			<?php endif; ?>
			<?php antreas_numbered_pagination(); ?>
			
			<?php do_action( 'antreas_after_content' ); ?>
		</section>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
