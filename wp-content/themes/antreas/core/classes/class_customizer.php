<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Class to create a custom layout control
 */
class Antreas_Customize_Imagelist_Control extends WP_Customize_Control {

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		$name  = $this->id;
		$value = $this->value(); ?>

		<?php if ( ! empty( $this->label ) ) : ?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->description ) ) : ?>
		<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php
		endif;
		$output = '';
		$output = '<div id="cpotheme-imagelist">';
foreach ( $this->choices as $list_key => $list_value ) {
	$selected = '';
	if ( $list_key == $value ) {
		$selected = ' class="cpotheme-imagelist-selected"';
	}
	$output .= '<label class="cpotheme-imagelist-item" for="' . esc_attr( $name ) . '_' . $list_key . '">';
	$output .= '<img ' . $selected . ' src="' . $list_value . '"/><br/>';
	$output .= '<input type="radio" ' . $this->get_link() . ' name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '_' . $list_key . '" value="' . esc_attr( $list_key ) . '" ' . checked( $value, $list_value ) . '/>';
	$output .= '</label>';
}
		$output .= '</div>';
		echo $output;
	}
}


class Antreas_Customize_Collection_Control extends WP_Customize_Control {

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		$name  = $this->id;
		$value = $this->value();
		?>

		<?php if ( ! empty( $this->label ) ) : ?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->description ) ) : ?>
		<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php
		endif;

		//Table contents
		$counter = -1;
		$output  = '<div class="cpotheme-collection" id="cpotheme-collection">';
foreach ( $value as $current_key => $current_value ) {
	$counter++;
	$output .= '<div class="cpotheme-collection-row" data-index="' . $current_key . '">';
	foreach ( $this->choices as $list_key => $list_value ) {

		//Save field data-- collections can be of any field type
		$field_name    = '[' . $current_key . '][' . $list_key . ']';
		$field_type    = isset( $list_value['type'] ) ? $list_value['type'] : 'text';
		$field_width   = isset( $list_value['width'] ) ? $list_value['width'] : '100';
		$field_args    = isset( $list_value['args'] ) ? $list_value['args'] : null;
		$field_options = isset( $list_value['option'] ) ? $list_value['option'] : null;
		$field_value   = isset( $current_value[ $list_key ] ) ? $current_value[ $list_key ] : '';
		$output       .= '<div class="cpotheme-collection-cell" style="width:' . $field_width . '%;">';

		//Display corresponding type of field
		if ( $field_type == 'text' ) {
			if ( isset( $field_args['placeholder'] ) ) {
				$field_placeholder = ' placeholder="' . $field_args['placeholder'] . '"';
			} else {
				$field_placeholder = '';
			}
			$output .= '<input type="text" data-customize-setting-link="' . esc_attr( $this->settings['default']->id ) . $field_name . '" value="' . $field_value . '" name="' . $field_name . '" id="' . $field_name . '"' . $field_placeholder . '/>';

		} elseif ( $field_type == 'select' ) {
			$field_class = ( isset( $field_args['class'] ) ? $field_args['class'] : '' );
			$output     .= '<select data-customize-setting-link="' . esc_attr( $this->settings['default']->id ) . $field_name . '" class="cpometabox_field_select ' . $field_class . '" name="' . $field_name . '" id="' . $field_name . '">';
			if ( sizeof( $field_options ) > 0 ) {
				foreach ( $field_options as $options_key => $options_value ) {
					$output .= '<option value="' . $options_key . '" ' . selected( $field_value, $options_key, false ) . '>' . $options_value . '</option>';
				}
			}
			$output .= '</select>';
		}
		$output .= '</div>';
	}
	$output .= '<a href="#" tabindex="-1" class="cpotheme-collection-remove">' . __( 'Remove', 'antreas' ) . '</a>';
	$output .= '</div>';
}
		$output .= '<div>';
		$output .= '<a href="#" class="button cpotheme-collection-add">' . __( 'Add Row', 'antreas' ) . '</a>';
		$output .= '</div>';
		$output .= '</div>';
		echo $output;
	}
}
