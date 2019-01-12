<?php
add_filter( 'block_categories', 'ewd_upcp_add_block_category' );
function ewd_upcp_add_block_category( $categories ) {
	$categories[] = array(
		'slug'  => 'ewd-upcp-blocks',
		'title' => __( 'Ultimate Product Catalog', 'ultimate-product-catalogue' ),
	);
	return $categories;
}

