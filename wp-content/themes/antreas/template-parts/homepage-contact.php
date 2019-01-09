<?php
	$home_contact = antreas_get_option( 'home_contact' );
	$contact_form_plugin = antreas_get_option( 'plugin_select' );
	$form_id = antreas_get_option( 'form_id' );

	if ( $home_contact === '' ) {
		return;
	}

	if ( $contact_form_plugin === 'wpforms' ) {
		$shortcode_tag = 'wpforms';
	} elseif ( $contact_form_plugin === 'cf7' ) {
		$shortcode_tag = 'contact-form-7';
	} else {
		$shortcode_tag = '';
	}
?>

<div id="contact" class="section contact">
	<div class="container">
		<?php antreas_section_heading( 'contact' ); ?>

		<div class="row">
			<?php if ( $shortcode_tag !== '' && $form_id !== '' ) { ?>
				<div class="column col2 contact__form">
					<?php echo do_shortcode( '[' . $shortcode_tag . ' id="' . $form_id . '"]' ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
