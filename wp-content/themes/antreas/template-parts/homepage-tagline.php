
<?php
$home_tagline = antreas_get_option( 'home_tagline' );
if ( $home_tagline === '' ) {
	return;
}
?>

<div id="tagline" class="section tagline dark">
	<div class="container">
		<div class="tagline-body">
			<?php antreas_tagline_title(); ?>
			<?php antreas_tagline_content(); ?>
		</div>
	</div>
</div>
