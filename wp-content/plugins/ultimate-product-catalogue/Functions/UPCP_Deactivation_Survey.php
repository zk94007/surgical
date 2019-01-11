<?php
add_action('current_screen', 'UPCP_Deactivation_Survey');
function UPCP_Deactivation_Survey() {
	if (in_array(get_current_screen()->id, array( 'plugins', 'plugins-network' ), true)) {
		add_action('admin_enqueue_scripts', 'UPCP_Enqueue_Deactivation_Scripts');
		add_action( 'admin_footer', 'UPCP_Deactivation_Survey_HTML'); 
	}
}

function UPCP_Enqueue_Deactivation_Scripts() {
	wp_enqueue_style('upcp-deactivation-css', UPCP_CD_PLUGIN_URL . 'css/upcp-plugin-deactivation.css');
	wp_enqueue_script('upcp-deactivation-js', UPCP_CD_PLUGIN_URL . 'js/upcp-plugin-deactivation.js', array('jquery'));

	wp_localize_script('upcp-deactivation-js', 'upcp_deactivation_data', array('site_url' => site_url()));
}

function UPCP_Deactivation_Survey_HTML() {
	$options = array(
		1 => array(
			'title'   => esc_html__( 'I no longer need the plugin', 'ultimate-product-catalogue' ),
		),
		2 => array(
			'title'   => esc_html__( 'I\'m switching to a different plugin', 'ultimate-product-catalogue' ),
			'details' => esc_html__( 'Please share which plugin', 'ultimate-product-catalogue' ),
		),
		3 => array(
			'title'   => esc_html__( 'I couldn\'t get the plugin to work', 'ultimate-product-catalogue' ),
		),
		4 => array(
			'title'   => esc_html__( 'It\'s a temporary deactivation', 'ultimate-product-catalogue' ),
		),
		5 => array(
			'title'   => esc_html__( 'Other', 'ultimate-product-catalogue' ),
			'details' => esc_html__( 'Please share the reason', 'ultimate-product-catalogue' ),
		),
	);
	?>
	<div class="upcp-deactivate-survey-modal" id="upcp-deactivate-survey-ultimate-faqs">
		<div class="upcp-deactivate-survey-wrap">
			<form class="upcp-deactivate-survey" method="post">
				<span class="upcp-deactivate-survey-title"><span class="dashicons dashicons-testimonial"></span><?php echo ' ' . __( 'Quick Feedback', 'ultimate-product-catalogue' ); ?></span>
				<span class="upcp-deactivate-survey-desc"><?php echo __('If you have a moment, please share why you are deactivating Ultimate Product Catalog', 'ultimate-product-catalogue' ); ?></span>
				<div class="upcp-deactivate-survey-options">
					<?php foreach ( $options as $id => $option ) : ?>
						<div class="upcp-deactivate-survey-option">
							<label for="upcp-deactivate-survey-option-ultimate-faqs-<?php echo $id; ?>" class="upcp-deactivate-survey-option-label">
								<input id="upcp-deactivate-survey-option-ultimate-faqs-<?php echo $id; ?>" class="upcp-deactivate-survey-option-input" type="radio" name="code" value="<?php echo $id; ?>" />
								<span class="upcp-deactivate-survey-option-reason"><?php echo $option['title']; ?></span>
							</label>
							<?php if ( ! empty( $option['details'] ) ) : ?>
								<input class="upcp-deactivate-survey-option-details" type="text" placeholder="<?php echo $option['details']; ?>" />
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="upcp-deactivate-survey-footer">
					<button type="submit" class="upcp-deactivate-survey-submit button button-primary button-large"><?php _e('Submit and Deactivate', 'ultimate-product-catalogue' ); ?></button>
					<a href="#" class="upcp-deactivate-survey-deactivate"><?php _e('Skip and Deactivate', 'ultimate-product-catalogue' ); ?></a>
				</div>
			</form>
		</div>
	</div>
	<?php
}

?>