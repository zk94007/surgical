<?php

//Create meta fields for pages and taxonomies alike
function antreas_metadata_layout_options() {

	$data = array();

	$data['layout_sidebar'] = array(
		'name'   => 'layout_sidebar',
		'label'  => __( 'Sidebar Position', 'antreas' ),
		'desc'   => __( 'Determines the location of the sidebar by default.', 'antreas' ),
		'type'   => 'imagelist',
		'option' => antreas_metadata_sidebarposition(),
		'std'    => 'default',
	);

	return apply_filters( 'antreas_metadata_layout', $data );
}

//Create slide meta fields
function antreas_metadata_slide_options() {

	$data = array();

	return apply_filters( 'antreas_metadata_slide', $data );
}

//Create feature meta fields
function antreas_metadata_feature_options() {

	$data = array();

	$data['feature_icon'] = array(
		'name'  => 'feature_icon',
		'std'   => '',
		'label' => __( 'Feature Icon', 'antreas' ),
		'desc'  => __( 'Sets an icon to be used as the featured element.', 'antreas' ),
		'type'  => 'iconlist',
	);

	return apply_filters( 'antreas_metadata_feature', $data );
}


//Create portfolio meta fields
function antreas_metadata_portfolio_options() {

	$data = array();

	$data['portfolio_featured'] = array(
		'name'  => 'portfolio_featured',
		'std'   => '',
		'label' => __( 'Featured Item', 'antreas' ),
		'desc'  => __( 'Specifies whether this item appears in the homepage.', 'antreas' ),
		'type'  => 'yesno',
	);

	return apply_filters( 'antreas_metadata_portfolio', $data );
}

//Create service meta fields
function antreas_metadata_service_options() {

	$data = array();

	$data['service_featured'] = array(
		'name'  => 'service_featured',
		'std'   => '',
		'label' => __( 'Featured Item', 'antreas' ),
		'desc'  => __( 'Specifies whether this item appears in the homepage.', 'antreas' ),
		'type'  => 'yesno',
	);

	$data['service_icon'] = array(
		'name'  => 'service_icon',
		'std'   => '',
		'label' => __( 'Service Icon', 'antreas' ),
		'desc'  => __( 'Sets an icon to be used as the service preview.', 'antreas' ),
		'type'  => 'iconlist',
	);

	return apply_filters( 'antreas_metadata_service', $data );
}


//Create client meta fields
function antreas_metadata_client_options() {

	$data = array();

	return apply_filters( 'antreas_metadata_client', $data );
}


//Create team meta fields
function antreas_metadata_team_options() {

	$data = array();

	$data['team_featured'] = array(
		'name'  => 'team_featured',
		'std'   => '',
		'label' => __( 'Featured Member', 'antreas' ),
		'desc'  => __( 'Specifies whether this member appears in the homepage.', 'antreas' ),
		'type'  => 'yesno',
	);

	return apply_filters( 'antreas_metadata_team', $data );
}


//Create testimonial meta fields
function antreas_metadata_testimonial_options() {

	$data = array();

	return apply_filters( 'antreas_metadata_testimonial', $data );
}


//Create page meta fields
function antreas_metadata_page_options() {

	$data = array();

	$data['page_featured'] = array(
		'name'   => 'page_featured',
		'std'    => '',
		'label'  => __( 'Show In Homepage', 'antreas' ),
		'desc'   => __( 'Specifies whether this item is featured in the homepage.', 'antreas' ),
		'type'   => 'select',
		'option' => antreas_metadata_featured_page(),
	);

	return apply_filters( 'antreas_metadata_page', $data );
}
