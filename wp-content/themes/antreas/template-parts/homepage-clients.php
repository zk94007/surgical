<?php $query = new WP_Query( 'post_type=cpo_client&posts_per_page=-1&order=ASC&orderby=menu_order' ); ?>
<?php if ( $query->posts ) : ?>
<div id="clients" class="section clients">
	<div class="container-fluid">	
		<?php antreas_section_heading( 'clients' ); ?>
		<?php antreas_grid( $query->posts, 'element', 'client', 5, array( 'class' => 'column-fit' ) ); ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
