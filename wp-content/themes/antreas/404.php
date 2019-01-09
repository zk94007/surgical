<?php get_header(); ?>

<div id="main" class="main">
	<div class="container">
		<section id="content" class="content content-wide">
			<?php do_action( 'antreas_before_404' ); ?>
			<div class="notfound">
				<div class="column col2 notfound-image">
					404
				</div>
				<div class="column col2 col-last notfound-content">
					<?php antreas_404(); ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php do_action( 'antreas_after_404' ); ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>
