<?php
// Prints meta field HTML
if ( ! function_exists( 'antreas_meta_fields' ) ) {
	function antreas_meta_fields( $post, $metadata = null ) {
		if ( $metadata == null || sizeof( $metadata ) == 0 ) {
			return;
		}
		$output = '';
		wp_enqueue_style( 'antreas_admin' );
		wp_nonce_field( 'antreas_savemeta', 'antreas_nonce' );

		foreach ( $metadata as $current_meta ) {
			$field_name  = $current_meta['name'];
			$field_title = $current_meta['label'];
			$field_desc  = $current_meta['desc'];
			$field_type  = $current_meta['type'];
			$field_value = '';
			$field_value = get_post_meta( $post->ID, $field_name, true );

			//Additional CSS classes depending on field type
			$field_classes = '';
			if ( $field_type == 'collection' ) {
				$field_classes = ' cpometabox-wide';
			}

			$output .= '<div class="cpometabox ' . $field_classes . '"><div class="name">' . $field_title . '</div>';
			$output .= '<div class="field">';

			// Print metaboxes here. Develop different cases for each type of field.
			if ( $field_type == 'readonly' ) {
				$output .= antreas_form_readonly( $field_name, $field_value );

			} elseif ( $field_type == 'text' ) {
				$output .= antreas_form_text( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'textarea' ) {
				$output .= antreas_form_textarea( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'select' ) {
				$output .= antreas_form_select( $field_name, $field_value, $current_meta['option'], $current_meta );

			} elseif ( $field_type == 'collection' ) {
				$output .= antreas_form_collection( $field_name, $field_value, $current_meta['option'], $current_meta );

			} elseif ( $field_type == 'checkbox' ) {
				$output .= antreas_form_checkbox( $field_name, $field_value, $current_meta['option'], $current_meta );

			} elseif ( $field_type == 'yesno' ) {
				$output .= antreas_form_yesno( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'color' ) {
				$output .= antreas_form_color( $field_name, $field_value );

			} elseif ( $field_type == 'imagelist' ) {
				$output .= antreas_form_imagelist( $field_name, $field_value, $current_meta['option'], $current_meta );

			} elseif ( $field_type == 'iconlist' ) {
				$output .= antreas_form_iconlist( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'upload' ) {
				$output .= antreas_form_upload( $field_name, $field_value, null, $post );

			} elseif ( $field_type == 'date' ) {
				$output .= antreas_form_date( $field_name, $field_value, null );

			} elseif ( $field_type == 'range' ) {
				$output .= antreas_form_range( $field_name, $field_value, $current_meta );
			}

			$output .= '</div>';
			$output .= '<div class="desc">' . $field_desc . '</div></div>';
		}
		echo $output;
	}
}

// Saves meta field data into database
if ( ! function_exists( 'antreas_meta_save' ) ) {
	function antreas_meta_save( $option ) {

		if ( ! isset( $_POST['post_ID'] ) || ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['antreas_nonce'], 'antreas_savemeta' ) ) {
			return;
		}

		$metaboxes = $option;
		$post_id       = $_POST['post_ID'];

		//Check if we're editing a post
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ) {

			//Check every option, and process the ones there's an update for.
			if ( sizeof( $metaboxes ) > 0 ) {
				foreach ( $metaboxes as $current_meta ) {

					$field_name = $current_meta['name'];

					//If the field has an update, process it.
					if ( isset( $_POST[ $field_name ] ) ) {
						if ( ! is_array( $_POST[ $field_name ] ) ) {
							$field_value = esc_html( $_POST[ $field_name ] );
						} else {
							$field_value = $_POST[ $field_name ];
						}

						// Delete unused metadata
						if ( empty( $field_value ) || $field_value == '' ) {
							delete_post_meta( $post_id, $field_name, get_post_meta( $post_id, $field_name, true ) );
						} // Update metadata
						else {
							update_post_meta( $post_id, $field_name, $field_value );
						}
					}
				}
			}
		}
	}
}

if ( ! function_exists( 'antreas_meta_message' ) ) {
	function antreas_meta_message( $message ) {
		echo '<div class="cpometabox-message">' . $message . '</div>';
	}
}
