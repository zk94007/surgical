<?php
function UPCP_Rewrite_Rules() { 
	global $wp_rewrite;

	$WooCommerce_Product_Page = get_option("UPCP_WooCommerce_Product_Page");
	$Permalink_Base = get_option("UPCP_Permalink_Base");
	if ($Permalink_Base == "") {$Permalink_Base = "product";}

	if ($WooCommerce_Product_Page == "Yes") {return;}

	$frontpage_id = get_option('page_on_front');
		
    add_rewrite_tag('%single_product%','([^&]+)');
		//add_rewrite_tag('%product_id%','([^+]+)');
		//add_rewrite_rule("(.?.+?)/([^+]+)/([^&]+)/?$", "index.php?pagename=\$matches[1]&product_id=\$matches[2]&single_product=\$matches[3]", 'top');
		add_rewrite_rule($Permalink_Base . "/([^&]+)/?$", "index.php?page_id=". $frontpage_id . "&single_product=\$matches[1]", 'top');
		add_rewrite_rule("(.?.+?)/" . $Permalink_Base . "/([^&]+)/?$", "index.php?pagename=\$matches[1]&single_product=\$matches[2]", 'top');
		flush_rewrite_rules();
}

function UPCP_add_query_vars_filter( $vars ){
	$vars[] = "single_product";
	$vars[] = "product_id";
	return $vars;
}


?>