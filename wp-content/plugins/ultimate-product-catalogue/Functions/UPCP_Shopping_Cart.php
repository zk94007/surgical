<?php
add_action( 'init', 'UPCP_Create_Order_Post_Type' );
function UPCP_Create_Order_Post_Type() {
	$labels = array(
		'name' => __('Orders', 'EWD_UASP'),
		'singular_name' => __('Order', 'EWD_UASP'),
		'menu_name' => __('Orders', 'EWD_UASP'),
		'add_new' => __('Add Order', 'EWD_UASP'),
		'add_new_item' => __('Add New Order', 'EWD_UASP'),
		'edit_item' => __('Edit Order', 'EWD_UASP'),
		'new_item' => __('New Order', 'EWD_UASP'),
		'view_item' => __('View Order', 'EWD_UASP'),
		'search_items' => __('Search Orders', 'EWD_UASP'),
		'not_found' =>  __('Nothing found', 'EWD_UASP'),
		'not_found_in_trash' => __('Nothing found in Trash', 'EWD_UASP'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'exclude_from_search' =>true,
		'publicly_queryable' => false,
		'show_ui' => false,
		'query_var' => false,
		'has_archive' => false,
		'menu_icon' => null,
		'rewrite' => array('slug' => 'locations'),
		'capability_type' => 'post',
		'menu_position' => null,
		'menu_icon' => 'dashicons-format-status',
		'supports' => array('title','editor')
	 ); 

	register_post_type( 'upcp-order' , $args );
}
?>