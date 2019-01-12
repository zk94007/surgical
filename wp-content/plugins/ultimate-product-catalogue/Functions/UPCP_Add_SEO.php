<?php

function UPCP_Add_SEO() {
	$SEO_Option = get_option("UPCP_SEO_Option");
	$Update_Breadcrumbs = get_option("UPCP_Update_Breadcrumbs");

	if ($SEO_Option == "Yoast") {
		add_action( 'wpseo_opengraph', 'UPCP_Add_OG_Image', 29 );

		add_filter( 'wpseo_canonical', 'UPCP_Yoast_Change_Canonical_URL', 10, 1 );
		add_filter( 'wpseo_metadesc', 'UPCP_Yoast_Change_Description', 10, 1 );
		add_filter( 'wpseo_title', 'UPCP_Yoast_Change_Title', 10, 1 );
		if ("Update_Breadcrumbs" == "Yes") {add_filter( 'wp_seo_get_bc_ancestors  ', 'UPCP_Yoast_Change_Breadcrumbs', 10, 1 );}
	}
}

function UPCP_Yoast_Change_Canonical_URL( $str ) {
	$Permalink_Base = get_option("UPCP_Permalink_Base");
	if ($Permalink_Base == "") {$Permalink_Base = "product";}

	if (get_query_var('single_product') == "" and $_GET['SingleProduct'] == "") {return $str;}
	elseif (get_query_var('single_product') != "") {return $str . $Permalink_Base . "/" . get_query_var('single_product') . "/";}
	elseif ($_GET['SingleProduct'] != "") {return $str . "?SingleProduct=" . $_GET['SingleProduct'];}
	else {return $str;}
}

function UPCP_Yoast_Change_Description( $str ) {
	global $wpdb, $items_table_name;

	$SEO_Integration = get_option("UPCP_SEO_Integration");
	$Pretty_Links = get_option("UPCP_Pretty_Links");

	if (get_query_var('single_product') == "" and $_GET['SingleProduct'] == "") {return $str;}

	if ($Pretty_Links == "Yes") {$SEO_Description = $wpdb->get_var("SELECT Item_SEO_Description FROM $items_table_name WHERE Item_Slug='" . trim(get_query_var('single_product'), "/? ") . "'");}
	else {$SEO_Description = $wpdb->get_var("SELECT Item_SEO_Description FROM $items_table_name WHERE Item_ID='" . $_GET['SingleProduct'] . "'");}
	
	if ($SEO_Integration == "Replace") {return $SEO_Description;}
	else {return $str . "," . $SEO_Description;}
}

function UPCP_Yoast_Change_Title( $str ) {
	global $wpdb, $items_table_name;

	$SEO_Title = get_option("UPCP_SEO_Title");
	$Pretty_Links = get_option("UPCP_Pretty_Links");
	$SEO_Title = get_option("UPCP_SEO_Title");

	if (get_query_var('single_product') == "" and $_GET['SingleProduct'] == "") {return $str;}

	if ($Pretty_Links == "Yes") {$Title_Elements = $wpdb->get_row("SELECT Item_Name, Category_Name, SubCategory_Name FROM $items_table_name WHERE Item_Slug='" . trim(get_query_var('single_product'), "/? ") . "'");}
	else {$Title_Elements = $wpdb->get_row("SELECT Item_Name, Category_Name, SubCategory_Name FROM $items_table_name WHERE Item_ID='" . $_GET['SingleProduct'] . "'");}

	$SEO_Title = str_replace("[page-title]", $str, $SEO_Title);
	$SEO_Title = str_replace("[product-name]", $Title_Elements->Item_Name, $SEO_Title);
	$SEO_Title = str_replace("[category-name]", $Title_Elements->Category_Name, $SEO_Title);
	$SEO_Title = str_replace("[subcategory-name]", $Title_Elements->SubCategory_Name, $SEO_Title);

	return $SEO_Title;
}

function UPCP_Yoast_Change_Breadcrumbs( $array ) {
	$SEO_Integration = get_option("UPCP_SEO_Integration");
	$Pretty_Links = get_option("UPCP_Pretty_Links");

	if (get_query_var('single_product') == "" and $_GET['SingleProduct'] == "") {return $array;}

	if ($Pretty_Links == "Yes") {$SEO_Description = $wpdb->get_var("SELECT Item_SEO_Description FROM $items_table_name WHERE Item_Slug='" . trim(get_query_var('single_product'), "/? ") . "'");}
	else {$SEO_Description = $wpdb->get_var("SELECT Item_SEO_Description FROM $items_table_name WHERE Item_ID='" . $_GET['SingleProduct'] . "'");}
	
	echo "Breadcrumbs trail: " . print_r($array, true) . "<br>";

	return $array;
}

function UPCP_Add_OG_Image() {
	global $wpdb, $items_table_name;

	$Pretty_Links = get_option("UPCP_Pretty_Links");

	if (get_query_var('single_product') == "" and $_GET['SingleProduct'] == "") {return;}

	if ($Pretty_Links == "Yes") {$Item_Photo_URL = $wpdb->get_var("SELECT Item_Photo_URL FROM $items_table_name WHERE Item_Slug='" . trim(get_query_var('single_product'), "/? ") . "'");}
	else {$Item_Photo_URL = $wpdb->get_var("SELECT Item_Photo_URL FROM $items_table_name WHERE Item_ID='" . $_GET['SingleProduct'] . "'");}

	$GLOBALS['wpseo_og']->image_output($Item_Photo_URL);
}

?>