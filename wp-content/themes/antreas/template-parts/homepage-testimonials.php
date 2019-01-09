<?php $query = new WP_Query( 'post_type=cpo_testimonial&posts_per_page=-1&order=ASC&orderby=menu_order' ); ?>
<?php if ( $query->posts ) : ?>
<div id="testimonials" class="section testimonials">
	<div class="container">
		<?php antreas_section_heading( 'testimonials' ); ?>
		<?php antreas_grid( $query->posts, 'element', 'testimonial', 3 ); ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
