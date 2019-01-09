<?php
$about_pages = antreas_get_option( 'about_pages' );
if ( ! $about_pages ) {
	return;
}
$args = array(
	'post_type' => 'page',
	'post__in' => $about_pages,
	'orderby' => 'post__in',
	'posts_per_page' => -1,
);
$query = new WP_Query( $args );
?>
<?php if ( $query->posts ) : ?>
	<div id="about" class="section about">
		<div class="container">
			<?php antreas_section_heading( 'about' ); ?>
			<?php antreas_grid( $query->posts, 'element', 'about', $query->post_count, array( 'class' => 'column' ) ); ?>
		</div>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
