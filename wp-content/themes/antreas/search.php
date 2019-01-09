<?php get_header(); ?>

<div id="main" class="main">
	<div class="container">
		<section id="content" class="content">
			<?php do_action( 'antreas_before_content' ); ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<article class="search-result" id="post-<?php the_ID(); ?>"> 			
						<h4 class="search-title heading">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h4>
						<div class="search-byline">
							<?php the_permalink(); ?>
						</div>
					</article>
				<?php endwhile; ?>
				<?php antreas_numbered_pagination(); ?>
			<?php endif; ?>
			<?php do_action( 'antreas_after_content' ); ?>
		</section>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
