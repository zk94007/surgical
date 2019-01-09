<?php


//Create the metadata fields for the metadata form.
if ( ! function_exists( 'antreas_taxonomy_meta_fields' ) ) {
	function antreas_taxonomy_meta_fields( $title, $post, $metadata ) {
		if ( $metadata == null || sizeof( $metadata ) == 0 ) {
			return;
		}
		$post_id      = isset( $_GET['tag_ID'] ) ? $_GET['tag_ID'] : false;
		$output       = '';
		$field_prefix = 'antreas_taxonomy_meta_';

		$output .= '<h3>' . $title . '</h3>';
		$output .= '<table class="form-table">';
		$output .= '<tbody>';

		//Loop through all the data taxonomies and create the field associated to them.
		foreach ( $metadata as $current_meta ) {
			$field_name  = $current_meta['name'];
			$field_title = $current_meta['label'];
			$field_desc  = $current_meta['desc'];
			$field_type  = $current_meta['type'];
			$field_value = antreas_tax_meta( $post_id, $field_name );

			$output .= '<tr>';
			$output .= '<th scope="row"><label for="' . $field_name . '" class="field_title">' . $field_title . '</label></th>';
			$output .= '<td>';

			// Print metaboxes here. Develop different cases for each type of field.
			if ( $field_type == 'text' ) {
				$output .= antreas_form_text( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'textarea' ) {
				$output .= antreas_form_textarea( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'select' ) {
				$output .= antreas_form_select( $field_name, $field_value, $current_meta['option'], $current_meta );

			} elseif ( $field_type == 'checkbox' ) {
				$output .= antreas_form_checkbox( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'yesno' ) {
				$output .= antreas_form_yesno( $field_name, $field_value, $current_meta );

			} elseif ( $field_type == 'color' ) {
				$output .= antreas_form_color( $field_name, $field_value );

			} elseif ( $field_type == 'imagelist' ) {
				$output .= antreas_form_imagelist( $field_name, $field_value, $current_meta['option'], $current_meta );

			} elseif ( $field_type == 'upload' ) {
				$output .= antreas_form_upload( $field_name, $field_value, null, $post );

			} elseif ( $field_type == 'date' ) {
				$output .= antreas_form_date( $field_name, $field_value, null );
			}

			//Separators
			if ( $field_type != 'separator' && $field_type != 'divider' ) {
				$output .= '<br><span class="description">' . $field_desc . '</span>';
				$output .= '</td>';
				$output .= '</tr>';
			}
		}

		$output .= '</tbody>';
		$output .= '</table>';

		return $output;
	}
}

// Create the form to insert the metadata in the category list.
if ( ! function_exists( 'antreas_taxonomy_meta_form' ) ) {
	function antreas_taxonomy_meta_form( $title, $post, $metadata = null ) {
		$output = '';

		//Call the field creator with the needed data.
		$output .= antreas_taxonomy_meta_fields( $title, $post, $metadata );
		echo $output;

	}
}


// Check and save metadata to a given tag_ID and taxonomy
if ( ! function_exists( 'antreas_taxonomy_meta_save' ) ) {
	function antreas_taxonomy_meta_save( $option_fields ) {
		$tax_meta = get_option( 'antreas_taxonomy' );
		$post_id  = $_POST['tag_ID'];

		//Loop through all fields
		foreach ( $option_fields as $current_field ) {
			$field_name = $current_field['name'];
			if ( isset( $_POST[ $field_name ] ) ) {
				$field_value = trim( $_POST[ $field_name ] );

				$current_value = '';
				$current_value = get_post_meta( $post_id, $field_name, true );

				// Add metadata
				if ( $field_value != '' ) {
					$tax_meta[ $post_id ][ $field_name ] = $field_value;
				} // Delete unused metadata
				else {
					unset( $tax_meta[ $post_id ][ $field_name ] );
				}
			}
		}

		// Save metadata to the database and redirect user.
		update_option( 'antreas_taxonomy', $tax_meta );
	}
}


//When a cpo_portfolio_category is deleted we also delete the metadata associated with it.
if ( ! function_exists( 'antreas_taxonomy_meta_delete' ) ) {
	function antreas_taxonomy_meta_delete( $option_fields ) {
		$tax_meta = get_option( 'antreas_taxonomy' );
		$post_id  = $_POST['tag_ID'];

		if ( $tax_meta && isset( $tax_meta[ $post_id ] ) ) {
			unset( $tax_meta[ $post_id ] );
		}

		update_option( 'antreas_taxonomy', $tax_meta );
	}
}


// Retrieve metadata field $key from the associated $tag_ID
if ( ! function_exists( 'antreas_tax_meta' ) ) {
	function antreas_tax_meta( $id, $key ) {
		$tax_meta = get_option( 'antreas_taxonomy' );
		if ( $tax_meta && isset( $tax_meta[ $id ][ $key ] ) ) {
			return $tax_meta[ $id ][ $key ];
		} else {
			return false;
		}
	}
}
