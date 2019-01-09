<?php
/**
 * Getting started template
 */
$customizer_url = admin_url() . 'customize.php';
$count          = $this->count_actions();
?>

<div class="feature-section getting-started three-col">
	<div class="col">
		<h4><?php esc_html_e( 'Implement recommended actions', 'antreas' ); ?></h4>
		<p><?php esc_html_e( 'Make sure you implement all of our recommended actions.', 'antreas' ); ?></p>
		<?php if ( $count == 0 ) { ?>
			<p><span class="dashicons dashicons-yes"></span>
				<a href="<?php echo admin_url( 'themes.php?page=' . ANTREAS_SLUG . '-welcome&tab=recommended-actions' ); ?>"><?php esc_html_e( 'No recommended actions left to perform', 'antreas' ); ?></a>
			</p>
		<?php } else { ?>
			<p><span class="dashicons dashicons-no-alt"></span> <a href="<?php echo admin_url( 'themes.php?page=' . ANTREAS_SLUG . '-welcome&tab=recommended-actions' ); ?>"><?php esc_html_e( 'Check recommended actions', 'antreas' ); ?></a>
			</p>
			<?php
};
		?>
	</div><!--/.col-->

	<div class="col">
		<h4><?php esc_html_e( 'Check our documentation', 'antreas' ); ?></h4>
		<p><?php esc_html_e( 'Even if you\'re a long-time WordPress user, we believe you should give our docs a read.', 'antreas' ); ?></p>
		<p>
			<a target="_blank"
			   href="<?php echo esc_url( 'https://docs.machothemes.com?utm_source=antreas&utm_medium=about-page&utm_campaign=docs-button' ); ?>"><?php esc_html_e( 'Full documentation', 'antreas' ); ?></a>
		</p>
	</div><!--/.col-->

	<div class="col">
		<h4><?php esc_html_e( 'Customize everything', 'antreas' ); ?></h4>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'antreas' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( $customizer_url ); ?>"
			  class="button button-primary"><?php esc_html_e( 'Start Customising your theme', 'antreas' ); ?></a>
		</p>
	</div><!--/.col-->
</div><!--/.feature-section-->
