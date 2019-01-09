<?php
$service_icon = get_post_meta( get_the_ID(), 'service_icon', true );
?>

<div class="service">
	<a href="<?php the_permalink(); ?>">
		<?php antreas_icon( $service_icon, 'primary-color service-icon' ); ?>
	</a>

	<div class="service-body">
		<h4 class="service-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h4>
	
		<div class="service-content">
			<?php the_excerpt(); ?>
		</div>
		<?php antreas_edit(); ?>
	</div>
</div>
