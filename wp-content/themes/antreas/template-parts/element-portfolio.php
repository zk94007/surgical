<div class="portfolio-item dark <?php echo has_excerpt() ? 'portfolio-item-has-excerpt': ''; ?>">
	<a class="portfolio-item-link" href="<?php the_permalink(); ?>"></a>
	<div class="portfolio-item-overlay primary-color-bg"></div>
	<h5 class="portfolio-item-title">
		<?php the_title(); ?>
	</h5>
	<?php antreas_edit(); ?>
	<?php the_post_thumbnail( 'portfolio', array( 'title' => '' ) ); ?>
</div>
