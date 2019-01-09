<article <?php post_class(); ?> id="post-<?php the_ID(); ?>"> 
	
	<?php if ( ! is_single() ) : ?>
		<div class="post-image">
			<?php antreas_postpage_image(); ?>		
		</div>	
	<?php endif;?>
	<div class="post-body">
		<?php antreas_postpage_title(); ?>
		<div class="post-byline">
			<?php antreas_postpage_date(); ?>
			<?php antreas_postpage_author(); ?>
			<?php antreas_postpage_categories(); ?>
			<?php antreas_edit(); ?>
		</div>
		<div class="post-content">
			<?php antreas_postpage_content(); ?>
		</div>
		<?php antreas_postpage_comments( false, '%s' ); ?>
		<?php if ( is_singular( 'post' ) ) : ?>
			<?php antreas_postpage_tags( false, '', '', '' ); ?>
		<?php endif; ?>
		<?php antreas_postpage_readmore( 'button' ); ?>
		<div class="clear"></div>
	</div>
</article>
