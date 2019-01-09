<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class Antreas_Customize_Tinymce_Control extends WP_Customize_Control {

	public function enqueue() {
		wp_enqueue_script( 'antreas-tinymce-control', ANTREAS_ASSETS_JS . 'customizer-controls/tinymce-control.js', array( 'jquery', 'customize-controls' ), ANTREAS_VERSION );
	}

	public function to_json() {
		parent::to_json();
		$this->json['toolbar1'] = isset( $this->input_attrs['toolbar1'] ) ? esc_attr( $this->input_attrs['toolbar1'] ) : 'bold italic bullist alignleft aligncenter alignright link';
		$this->json['toolbar2'] = isset( $this->input_attrs['toolbar2'] ) ? esc_attr( $this->input_attrs['toolbar2'] ) : '';
	}

	public function render_content() {
	?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

		<?php if ( ! empty( $this->description ) ) { ?>
			<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php } ?>

		<textarea id="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?>>
			<?php echo esc_attr( $this->value() ); ?>
		</textarea>
	<?php
	}
}
