<?php if ( is_singular( 'post' ) || comments_open() ) : ?>
	<div id="comments" class="comments">
		<?php
		if ( antreas_comments_protected() ) {
			return;
		}
		?>

		<?php if ( have_comments() ) : ?>
			<?php antreas_comments_title(); ?>
			<ol class="comments-list">
				<?php wp_list_comments( 'type=comment&callback=antreas_comment' ); ?>
			</ol>
			<?php antreas_comments_pagination(); ?>
		<?php endif; ?>
		
	</div>
	<?php comment_form(); ?>
<?php endif; ?>
