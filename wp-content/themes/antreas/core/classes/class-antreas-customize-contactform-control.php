<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Antreas_Customize_ContactForm_Control extends WP_Customize_Control {

	public function enqueue() {
		wp_enqueue_script( 'antreas-contactform-control', ANTREAS_ASSETS_JS . 'customizer-controls/contactform-control.js', array( 'jquery', 'customize-controls' ), ANTREAS_VERSION );
	}

	public function is_cf7_active() {
		if ( class_exists( 'WPCF7' ) ) {
			return true;
		}
		return false;
	}

	public function is_wpforms_active() {
		if ( class_exists( 'WPForms' ) ) {
			return true;
		}
		return false;
	}

	public function get_cf7_forms() {
		$contact_forms = array();

		$args = array(
			'post_type'      => 'wpcf7_contact_form',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);
		$cf7forms = new WP_Query( $args );
		if ( $cf7forms->have_posts() ) {
			foreach ( $cf7forms->posts as $cf7form ) {
				$contact_forms[ $cf7form->ID ] = $cf7form->post_title;
			}
		}
		return $contact_forms;
	}

	public function get_wpforms() {
		$contact_forms = array();

		$args = array(
			'post_type'      => 'wpforms',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);
		$cf7forms = new WP_Query( $args );
		if ( $cf7forms->have_posts() ) {
			foreach ( $cf7forms->posts as $cf7form ) {
				$contact_forms[ $cf7form->ID ] = $cf7form->post_title;
			}
		}
		return $contact_forms;
	}

	public function render_content() {

		$plugin_select = antreas_get_option( 'plugin_select' );
		$form_id = antreas_get_option( 'form_id' );
		?>

		<?php if ( $this->is_wpforms_active() && $this->is_cf7_active() ) { ?>
			<span class="customize-control-title"><?php _e( 'Select contact form plugin', 'antreas' ); ?></span>
			<select>
				<option value="wpforms" <?php echo $plugin_select === 'wpforms' ? 'selected' : ''; ?> >wpforms</option>
				<option value="cf7" <?php echo $plugin_select === 'cf7' ? 'selected' : ''; ?> >contact form 7</option>
			</select>
		<?php } ?>

		<?php if ( ! $this->is_wpforms_active() && ! $this->is_cf7_active() ) { ?>
			<p><?php _e('There are no contact form plugins activated. Please activate WPForms or Contact Form 7', 'antreas'); ?></p>
		<?php } ?>

		<?php if ( $this->is_wpforms_active() ) { ?>
			<div class="cpotheme_contact_control__wpforms">
				<?php $forms = $this->get_wpforms(); ?>
				<?php if ( ! empty( $forms ) ) { ?>
					<span class="customize-control-title"><?php _e('Select form', 'antreas'); ?></span>
					<select>
						<option>...</option>
						<?php foreach ( $forms as $id => $form_title ) { ?>
							<option value="<?php echo $id; ?>" <?php echo $form_id == $id ? 'selected' : ''; ?>><?php echo $form_title; ?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<?php printf( __( '<p>%s <a href="' . admin_url( 'admin.php?page=wpforms-builder' ) . '">%s</a></p>', 'antreas' ), 'please add a', 'new form' );  ?>
				<?php } ?>
			</div>
		<?php } ?>

		<?php if ( $this->is_cf7_active() ) { ?>
			<div class="cpotheme_contact_control__cf7forms">
				<?php $forms = $this->get_cf7_forms(); ?>
				<?php if ( ! empty( $forms ) ) { ?>
					<span class="customize-control-title"><?php _e('Select form', 'antreas'); ?></span>
					<select>
						<option>...</option>
						<?php foreach ( $forms as $id => $form_title ) { ?>
							<option value="<?php echo $id; ?>" <?php echo $form_id == $id ? 'selected' : ''; ?>><?php echo $form_title; ?></option>
						<?php } ?>
					</select>
				<?php } else { ?>
					<?php printf( __( '<p>%s <a href="' . admin_url( 'admin.php?page=wpcf7-new' ) . '">%s</a></p>', 'antreas' ), 'please add a', 'new form' );  ?>
				<?php } ?>
			</div>
		<?php } ?>

		<?php
	}

}
