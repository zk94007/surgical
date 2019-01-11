<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function UPCP_Output_Options() {
	global $wpdb, $error, $Full_Version;
	global $categories_table_name, $subcategories_table_name, $items_table_name, $item_images_table_name, $item_videos_table_name, $catalogues_table_name, $catalogue_items_table_name, $tagged_items_table_name, $tags_table_name, $tag_groups_table_name, $fields_table_name, $fields_meta_table_name;
		
	$Related_Products = get_option("UPCP_Related_Products");
	$Next_Previous = get_option("UPCP_Next_Previous");

	if (isset($_GET['DisplayPage'])) {
		  $Display_Page = $_GET['DisplayPage'];
	}
	else {
		$Display_Page = null;
	}

	if (!isset($_GET['Action'])) {
		$_GET['Action'] = null;
	}

	if (!isset($_GET['OrderBy'])) {
		$_GET['OrderBy'] = null;
	}

	if (!isset($_GET['SingleProduct'])) {
		$_GET['SingleProduct'] = null;
	}

	include UPCP_CD_PLUGIN_PATH . 'html/AdminHeader.php';
	if ($_GET['Action'] == "UPCP_Item_Details" or
		$_GET['Action'] == "UPCP_AddProduct" or
		$_GET['Action'] == "UPCP_Duplicate_Product" or
		$_GET['Action'] == "UPCP_Category_Details" or 
		$_GET['Action'] == "UPCP_SubCategory_Details" or 
		$_GET['Action'] == "UPCP_Catalogue_Details" or 
		$_GET['Action'] == "UPCP_Tag_Details" or 
		$_GET['Action'] == "UPCP_Tag_Groups" or
		$_GET['Action'] == "UPCP_Optional_Image" or
		$_GET['Action'] == "UPCP_Field_Details" or
		$_GET['Action'] == "UPCP_MassDeleteCatalogueItems") {
			include UPCP_CD_PLUGIN_PATH . 'html/ItemDetails.php';
	}
	elseif ($_GET['Action'] == 'UPCP_Add_Product_Screen') {
		include UPCP_CD_PLUGIN_PATH . 'html/AddProduct.php';
	}
	elseif (isset($_GET['Update_Item'])){
		$selected = $_GET['Update_Item'];
		include UPCP_CD_PLUGIN_PATH . 'html/ItemDetails.php';
	} else {
		include UPCP_CD_PLUGIN_PATH . 'html/MainScreen.php';
	}
	include UPCP_CD_PLUGIN_PATH . 'html/AdminFooter.php';
}
?>