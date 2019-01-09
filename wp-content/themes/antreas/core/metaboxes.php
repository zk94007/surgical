<?php

//Add default metaboxes to posts
add_action( 'add_meta_boxes', 'antreas_metaboxes' );
function antreas_metaboxes() {
	$args = array( 'public' => true );

	//Add common metaboxes
	$post_types     = get_post_types( $args, 'names' );
	$post_type_list = array();
	foreach ( $post_types as $current_type ) {
		add_meta_box( 'antreas_layout_' . $current_type, __( 'Layout Options', 'antreas' ), 'antreas_metabox_layout', $current_type, 'normal', 'low' );
	}

	if ( defined( 'CPOTHEME_USE_SLIDES' ) && CPOTHEME_USE_SLIDES == true ) {
		add_meta_box( 'antreas_slide', __( 'Slide Options', 'antreas' ), 'antreas_metabox_slide', 'cpo_slide', 'normal', 'high' );
	}
	if ( defined( 'CPOTHEME_USE_FEATURES' ) && CPOTHEME_USE_FEATURES == true ) {
		add_meta_box( 'antreas_feature', __( 'Feature Options', 'antreas' ), 'antreas_metabox_feature', 'cpo_feature', 'normal', 'high' );
	}
	if ( defined( 'CPOTHEME_USE_PORTFOLIO' ) && CPOTHEME_USE_PORTFOLIO == true ) {
		add_meta_box( 'antreas_portfolio', __( 'Portfolio Options', 'antreas' ), 'antreas_metabox_portfolio', 'cpo_portfolio', 'normal', 'high' );
	}
	if ( defined( 'CPOTHEME_USE_SERVICES' ) && CPOTHEME_USE_SERVICES == true ) {
		add_meta_box( 'antreas_service', __( 'Service Options', 'antreas' ), 'antreas_metabox_service', 'cpo_service', 'normal', 'high' );
	}
	if ( defined( 'CPOTHEME_USE_CLIENTS' ) && CPOTHEME_USE_CLIENTS == true ) {
		add_meta_box( 'antreas_client', __( 'Client Options', 'antreas' ), 'antreas_metabox_client', 'cpo_client', 'normal', 'high' );
	}
	if ( defined( 'CPOTHEME_USE_TEAM' ) && CPOTHEME_USE_TEAM == true ) {
		add_meta_box( 'antreas_team', __( 'Member Options', 'antreas' ), 'antreas_metabox_team', 'cpo_team', 'normal', 'high' );
	}
	if ( defined( 'CPOTHEME_USE_TESTIMONIALS' ) && CPOTHEME_USE_TESTIMONIALS == true ) {
		add_meta_box( 'antreas_testimonial', __( 'Testimonial Options', 'antreas' ), 'antreas_metabox_testimonial', 'cpo_testimonial', 'normal', 'high' );
	}
	//Featured posts and pages
	if ( defined( 'CPOTHEME_USE_PAGES' ) && CPOTHEME_USE_PAGES == true ) {
		add_meta_box( 'antreas_post', __( 'Post Options', 'antreas' ), 'antreas_metabox_page', 'post', 'normal', 'high' );
		add_meta_box( 'antreas_page', __( 'Page Options', 'antreas' ), 'antreas_metabox_page', 'page', 'normal', 'high' );
	}
}

//Display and save post metaboxes
function antreas_metabox_layout( $post ) {
	antreas_meta_fields( $post, antreas_metadata_layout_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s for multiple sidebar layouts, control over the header/title/footer.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_slide( $post ) {
	antreas_meta_message( sprintf( __( 'Upgrade to %s to control the position and appearance of slides, as well as adding captions, foreground images, buttons, overlays.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_feature( $post ) {
	antreas_meta_fields( $post, antreas_metadata_feature_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s to control the linking of feature blocks and access multiple icon libraries.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_portfolio( $post ) {
	antreas_meta_fields( $post, antreas_metadata_portfolio_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s to control the layout of portfolio items.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_product( $post ) {
	antreas_meta_fields( $post, antreas_metadata_product_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s to control the layout of products.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_service( $post ) {
	antreas_meta_fields( $post, antreas_metadata_service_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s to control the layout of services and access multiple icon libraries.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_client( $post ) {
	antreas_meta_fields( $post, antreas_metadata_client_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s to link client items to a URL.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_team( $post ) {
	antreas_meta_fields( $post, antreas_metadata_team_options() );
	antreas_meta_message( sprintf( __( 'Upgrade to %s to add descriptions and social links to team members.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
}
function antreas_metabox_testimonial( $post ) {
	antreas_meta_message( sprintf( __( 'Upgrade to %s to add descriptions to testimonials.', 'antreas' ), '<a target="_blank" href="' . esc_url( antreas_upgrade_link( 'metabox' ) ) . '">' . esc_attr( ANTREAS_PREMIUM_NAME ) . '</a>' ) );
	antreas_meta_fields( $post, antreas_metadata_testimonial_options() );
}
function antreas_metabox_page( $post ) {
	antreas_meta_fields( $post, antreas_metadata_page_options() );
}
add_action( 'edit_post', 'antreas_metaboxes_save' );
function antreas_metaboxes_save( $post ) {
	antreas_meta_save( antreas_metadata_layout_options() );
	if ( defined( 'CPOTHEME_USE_SLIDES' ) && CPOTHEME_USE_SLIDES == true ) {
		antreas_meta_save( antreas_metadata_slide_options() );
	}
	if ( defined( 'CPOTHEME_USE_FEATURES' ) && CPOTHEME_USE_FEATURES == true ) {
		antreas_meta_save( antreas_metadata_feature_options() );
	}
	if ( defined( 'CPOTHEME_USE_PORTFOLIO' ) && CPOTHEME_USE_PORTFOLIO == true ) {
		antreas_meta_save( antreas_metadata_portfolio_options() );
	}
	if ( defined( 'CPOTHEME_USE_SERVICES' ) && CPOTHEME_USE_SERVICES == true ) {
		antreas_meta_save( antreas_metadata_service_options() );
	}
	if ( defined( 'CPOTHEME_USE_CLIENTS' ) && CPOTHEME_USE_CLIENTS == true ) {
		antreas_meta_save( antreas_metadata_client_options() );
	}
	if ( defined( 'CPOTHEME_USE_TEAM' ) && CPOTHEME_USE_TEAM == true ) {
		antreas_meta_save( antreas_metadata_team_options() );
	}
	if ( defined( 'CPOTHEME_USE_TESTIMONIALS' ) && CPOTHEME_USE_TESTIMONIALS == true ) {
		antreas_meta_save( antreas_metadata_testimonial_options() );
	}
	if ( defined( 'CPOTHEME_USE_PAGES' ) && CPOTHEME_USE_PAGES == true ) {
		antreas_meta_save( antreas_metadata_page_options() );
	}

	//Save page gallery, if it exists
	if ( isset( $_POST['page_gallery'] ) ) {
		$page_gallery = esc_attr( $_POST['page_gallery'] );
		$page_gallery = implode( ',', array_filter( explode( ',', $page_gallery ) ) );
		update_post_meta( $post, 'page_gallery', $page_gallery );
	}
}


//Add default metaboxes to taxonomies
add_action( 'admin_init', 'antreas_taxonomy_metaboxes' );
function antreas_taxonomy_metaboxes() {
	$args = array( 'public' => true );

	//Add common metaboxes
	$taxonomy_types = get_taxonomies( $args, 'names' );
	foreach ( $taxonomy_types as $current_taxonomy ) {
		add_action( $current_taxonomy . '_edit_form', 'antreas_taxonomy_metabox_layout' );
		add_action( 'edit_' . $current_taxonomy, 'antreas_taxonomy_layout_save' );
		add_action( 'delete_' . $current_taxonomy, 'antreas_taxonomy_layout_delete' );
	}
}

//Display forms for all public taxonomies
function antreas_taxonomy_metabox_layout( $post ) {
	antreas_taxonomy_meta_form( __( 'Layout Options', 'antreas' ), $post, antreas_metadata_layout_options() );
}

//Save the data
function antreas_taxonomy_layout_save( $post ) {
	antreas_taxonomy_meta_save( antreas_metadata_layout_options() );
}

//Delete the data
function antreas_taxonomy_layout_delete() {
	antreas_taxonomy_meta_delete( antreas_metadata_layout_options() );
}
