<?php $query = new WP_Query( 'post_type=cpo_slide&posts_per_page=-1&order=ASC&orderby=menu_order' ); ?>
<?php if ( $query->posts ) : ?>
	<div id="slider" class="slider">
		<div class="slider-slides cycle-slideshow" <?php antreas_slider_data(); ?>>
			<?php foreach ( $query->posts as $post ) : ?>
				
				<?php setup_postdata( $post ); ?>
			
				<?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( 1500, 7000 ), false, '' ); ?>
				
				<div id="slide-<?php echo get_the_ID(); ?>" class="slide slide-<?php echo get_the_ID(); ?> cycle-slide-active slide-center dark" style="background-image:url(<?php echo esc_url( $image_url[0] ); ?>);">
					<div class="slide-overlay"></div>	
					<div class="slide-body">
						<div class="container">
							<div class="slide-caption">
								<h2 class="slide-title">
									<?php the_title(); ?>
								</h2>
								
								<div class="slide-content">
									<?php the_content(); ?>
								</div>

								<?php antreas_edit(); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( count( $query->posts ) > 1 ) : ?>
			<?php wp_enqueue_script( 'antreas_cycle' ); ?>
			<div class="slider-prev" data-cycle-cmd="pause"></div>
			<div class="slider-next" data-cycle-cmd="pause"></div>
			<div class="slider-pages" data-cycle-cmd="pause"></div>
		<?php endif; ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
