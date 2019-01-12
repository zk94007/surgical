<?php
function UpdateTables() {
	global $wpdb;
	global $categories_table_name, $subcategories_table_name, $items_table_name, $item_images_table_name, $tagged_items_table_name, $tags_table_name, $tag_groups_table_name, $item_videos_table_name, $catalogues_table_name, $catalogue_items_table_name, $fields_table_name, $fields_meta_table_name;
	
	/* Update the categories table */  
   	$sql = "CREATE TABLE $categories_table_name (
  		Category_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Category_Name text DEFAULT '' NOT NULL,
		Category_Description text DEFAULT '' NOT NULL,
		Category_Image text DEFAULT '' NOT NULL,
		Category_Item_Count mediumint(9) DEFAULT '0',
		Category_Sidebar_Order mediumint(9) DEFAULT '9999',
		Category_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		Category_WC_ID mediumint(9) DEFAULT '0',
  		UNIQUE KEY id (Category_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the sub-categories table */
	$sql = "CREATE TABLE $subcategories_table_name (
  		SubCategory_ID mediumint(9) NOT NULL AUTO_INCREMENT,
		Category_ID mediumint(9) DEFAULT '0' NOT NULL,
		Category_Name text DEFAULT '' NOT NULL,
  		SubCategory_Name text DEFAULT '' NOT NULL,
		SubCategory_Description text DEFAULT '' NOT NULL,
		SubCategory_Image text DEFAULT '' NOT NULL,
		SubCategory_Item_Count mediumint(9) DEFAULT '0' NOT NULL,
		SubCategory_Sidebar_Order mediumint(9) DEFAULT '9999',
		SubCategory_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		SubCategory_WC_ID mediumint(9) DEFAULT '0',
  		UNIQUE KEY id (SubCategory_ID)
    	)	
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the items(products) table */
	$sql = "CREATE TABLE $items_table_name (
  		Item_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Item_Name text DEFAULT '' DEFAULT '' NOT NULL,
		Item_Slug text DEFAULT '' NOT NULL,
  		Item_Description text DEFAULT '',
		Item_Price text DEFAULT '' NOT NULL,
		Item_Sale_Price text DEFAULT '' NOT NULL,
		Item_Sale_Mode text DEFAULT '' NOT NULL,
		Item_Link text DEFAULT '',
		Item_Photo_URL text DEFAULT '',
		Category_ID mediumint(9) DEFAULT '0',
		Category_Name text DEFAULT '',
		Global_Item_ID mediumint(9) DEFAULT '0',
		Item_Special_Attr text DEFAULT '',
		SubCategory_ID mediumint(9) DEFAULT '0',
		SubCategory_Name text DEFAULT '',
		Item_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		Item_Views mediumint(9) DEFAULT '0',
		Item_Display_Status text DEFAULT '',
		Item_Related_Products text DEFAULT '',
		Item_Next_Previous text DEFAULT '',
		Item_SEO_Description text DEFAULT '',
		Item_Category_Product_Order mediumint(9) DEFAULT '9999',
		Item_WC_ID mediumint(9) DEFAULT '0',
  		UNIQUE KEY id (Item_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the table that stores links to additional images for products */
	$sql = "CREATE TABLE $item_images_table_name (
  		Item_Image_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Item_ID mediumint(9) DEFAULT '0' NOT NULL,
  		Item_Image_URL text DEFAULT '',
		Item_Image_Description text DEFAULT '',
		Item_Image_Order mediumint(9) DEFAULT '0' NOT NULL,
  		UNIQUE KEY id (Item_Image_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);

   	/* Update the table that stores video IDs for products */
	$sql = "CREATE TABLE $item_videos_table_name (
  		Item_Video_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Item_ID mediumint(9) DEFAULT '0' NOT NULL,
  		Item_Video_URL text DEFAULT '',
		Item_Video_Type text DEFAULT '',
		Item_Video_Order mediumint(9) DEFAULT '0' NOT NULL,
  		UNIQUE KEY id (Item_Video_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the tags table */
	$sql = "CREATE TABLE $tags_table_name (
  		Tag_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Tag_Name text DEFAULT '' NOT NULL,
		Tag_Description text DEFAULT '' NOT NULL,
		Tag_Item_Count text DEFAULT '' NOT NULL,
		Tag_Group_ID mediumint(9) DEFAULT '0' NOT NULL,
		Tag_Sidebar_Order mediumint(9) DEFAULT '9999',
		Tag_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		Tag_WC_ID mediumint(9) DEFAULT '0',
  		UNIQUE KEY id (Tag_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);

   	/* Update the tag groups table */
	$sql = "CREATE TABLE $tag_groups_table_name (
  		Tag_Group_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Tag_Group_Name text DEFAULT '' NOT NULL,
		Tag_Group_Description text DEFAULT '' NOT NULL,
		Display_Tag_Group text DEFAULT '' NOT NULL,
		Tag_Group_Order mediumint(9) DEFAULT '0' NOT NULL,
  		UNIQUE KEY id (Tag_Group_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the table detemines which products have what tags */
	$sql = "CREATE TABLE $tagged_items_table_name (
  		Tagged_Item_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Tag_ID mediumint(9) DEFAULT '0' NOT NULL,
		Item_ID mediumint(9) DEFAULT '0' NOT NULL,
  		UNIQUE KEY id (Tagged_Item_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the catalogues table */
	$sql = "CREATE TABLE $catalogues_table_name (
  		Catalogue_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Catalogue_Name text DEFAULT '' NOT NULL,
		Catalogue_Description text DEFAULT '' NOT NULL,
		Catalogue_Layout_Format text DEFAULT '' NOT NULL,
		Catalogue_Custom_CSS text DEFAULT '' NOT NULL,
		Catalogue_Item_Count mediumint(9) DEFAULT '0' NOT NULL,
		Catalogue_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  		UNIQUE KEY id (Catalogue_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the table that determines what items are in each catalogue */
	$sql = "CREATE TABLE $catalogue_items_table_name (
  		Catalogue_Item_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Catalogue_ID mediumint(9) DEFAULT '0',
  		Item_ID mediumint(9) DEFAULT '0',
		Category_ID mediumint(9) DEFAULT '0',
		SubCategory_ID mediumint(9) DEFAULT '0',
		Position mediumint(9) DEFAULT '0' NOT NULL,
  		UNIQUE KEY id (Catalogue_Item_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the custom fields table */
	$sql = "CREATE TABLE $fields_table_name (
  		Field_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Field_Name text DEFAULT '' NOT NULL,
		Field_Slug text DEFAULT '' NOT NULL,
		Field_Type text DEFAULT '' NOT NULL,
		Field_Description text DEFAULT '' NOT NULL,
		Field_Values text DEFAULT '' NOT NULL,
		Field_Displays text DEFAULT '' NOT NULL,
		Field_Searchable text DEFAULT '' NOT NULL,
		Field_Sidebar_Order mediumint(9) DEFAULT '9999',
		Field_Display_Tabbed text DEFAULT '' NOT NULL,
		Field_Control_Type text DEFAULT '' NOT NULL,
		Field_Display_Comparison text DEFAULT '' NOT NULL,
		Field_Date_Created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		Field_WC_ID mediumint(9) DEFAULT '0',
  		UNIQUE KEY id (Field_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	/* Update the custom fields meta table */
	$sql = "CREATE TABLE $fields_meta_table_name (
  		Meta_ID mediumint(9) NOT NULL AUTO_INCREMENT,
  		Field_ID mediumint(9) DEFAULT '0',
		Item_ID mediumint(9) DEFAULT '0',
		Meta_Value text DEFAULT '' NOT NULL,
  		UNIQUE KEY id (Meta_ID)
    	)
		DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
		
	if (get_option("UPCP_Thumb_Auto_Adjust") == "") {update_option("UPCP_Thumb_Auto_Adjust", "No");}
	if (get_option("UPCP_Currency_Symbol_Location") == "") {update_option("UPCP_Currency_Symbol_Location", "Before");}
	if (get_option("UPCP_Price_Filter") == "") {update_option("UPCP_Price_Filter", "No");}
	if (get_option("UPCP_Slider_Filter_Inputs") == "") {update_option("UPCP_Slider_Filter_Inputs", "No");}
	if (get_option("UPCP_Sale_Mode") == "") {update_option("UPCP_Sale_Mode", "Individual");}
	if (get_option("UPCP_Product_Sort") == "") {update_option("UPCP_Product_Sort", "Price_Name");}
	if (get_option("UPCP_Product_Search") == "") {update_option("UPCP_Product_Search", "name");}
	if (get_option("UPCP_Custom_Product_Page") == "") {update_option("UPCP_Custom_Product_Page", "No");}
	if (get_option("UPCP_Sidebar_Order") == "") {update_option("UPCP_Sidebar_Order", "Normal");}
	if (get_option("UPCP_Apply_Contents_Filter") == "") {update_option("UPCP_Apply_Contents_Filter", "Yes");}
	if (get_option("UPCP_Maintain_Filtering") == "") {update_option("UPCP_Maintain_Filtering", "Yes");}
	if (get_option("UPCP_Thumbnail_Support") == "") {update_option("UPCP_Thumbnail_Support", "No");}
	if (get_option("UPCP_Show_Category_Descriptions") == "") {update_option("UPCP_Show_Category_Descriptions", "No");}
	if (get_option("UPCP_Show_Catalogue_Information") == "") {update_option("UPCP_Show_Catalogue_Information", "None");}
	if (get_option("UPCP_Display_Category_Image") == "") {update_option("UPCP_Display_Category_Image", "No");}
	if (get_option("UPCP_Display_SubCategory_Image") == "") {update_option("UPCP_Display_SubCategory_Image", "No");}
	if (get_option("UPCP_Overview_Mode") == "") {update_option("UPCP_Overview_Mode", "None");}
	if (get_option("UPCP_Product_Page_Serialized_Mobile") == "") {update_option("UPCP_Product_Page_Serialized_Mobile", get_option("UPCP_Product_Page_Serialized"));}
	if (get_option("UPCP_Inner_Filter") == "") {update_option("UPCP_Inner_Filter", "No");}
	if (get_option("UPCP_Clear_All") == "") {update_option("UPCP_Clear_All", "No");}
	if (get_option("UPCP_Hide_Empty_Options") == "") {update_option("UPCP_Hide_Empty_Options", "No");}
	if (get_option("UPCP_Breadcrumbs") == "") {update_option("UPCP_Breadcrumbs", "None");}

	if (get_option("UPCP_Product_Comparison") == "") {update_option("UPCP_Product_Comparison", "No");}
	if (get_option("UPCP_Product_Inquiry_Form") == "") {update_option("UPCP_Product_Inquiry_Form", "No");}
	if (get_option("UPCP_Product_Inquiry_Cart") == "") {update_option("UPCP_Product_Inquiry_Cart", "No");}
	if (get_option("UPCP_Inquiry_Form_Email") == "") {update_option("UPCP_Inquiry_Form_Email", 0);}
	if (get_option("UPCP_Product_Reviews") == "") {update_option("UPCP_Product_Reviews", "No");}
	if (get_option("UPCP_Catalog_Display_Reviews") == "") {update_option("UPCP_Catalog_Display_Reviews", "No");}
	if (get_option("UPCP_Lightbox") == "") {update_option("UPCP_Lightbox", "No");}
	if (get_option("UPCP_Lightbox_Mode") == "") {update_option("UPCP_Lightbox_Mode", "No");}
	if (get_option("UPCP_Hidden_Drop_Down_Sidebar_On_Mobile") == "") {update_option("UPCP_Hidden_Drop_Down_Sidebar_On_Mobile", "No");}
	if (get_option("UPCP_Infinite_Scroll") == "") {update_option("UPCP_Infinite_Scroll", "No");}
	if (get_option("UPCP_Products_Per_Page") == "") {update_option("UPCP_Products_Per_Page", 5);}
	if (get_option("UPCP_Pagination_Location") == "") {update_option("UPCP_Pagination_Location", "Top");}
	if (get_option("UPCP_CF_Conversion") == "") {update_option("UPCP_CF_Conversion", "No");}
	if (get_option("UPCP_Access_Role") == "") {update_option("UPCP_Access_Role", "administrator");}
	if (get_option("UPCP_PP_Grid_Width") == "") {update_option("UPCP_PP_Grid_Width", 90);}
	if (get_option("UPCP_PP_Grid_Height") == "") {update_option("UPCP_PP_Grid_Height", 35);}
	if (get_option("UPCP_Top_Bottom_Padding") == "") {update_option("UPCP_Top_Bottom_Padding", 10);}
	if (get_option("UPCP_Left_Right_Padding") == "") {update_option("UPCP_Left_Right_Padding", 10);}

	if (get_option("UPCP_WooCommerce_Sync") == "") {update_option("UPCP_WooCommerce_Sync", "No");}
	if (get_option("UPCP_WooCommerce_Show_Cart_Count") == "") {update_option("UPCP_WooCommerce_Show_Cart_Count", "No");}
	if (get_option("UPCP_WooCommerce_Checkout") == "") {update_option("UPCP_WooCommerce_Checkout", "No");}
	if (get_option("UPCP_WooCommerce_Cart_Page") == "") {update_option("UPCP_WooCommerce_Cart_Page", "Checkout");}
	if (get_option("UPCP_WooCommerce_Product_Page") == "") {update_option("UPCP_WooCommerce_Product_Page", "No");}
	if (get_option("UPCP_WooCommerce_Back_Link") == "") {update_option("UPCP_WooCommerce_Back_Link", "No");}

	if (get_option("UPCP_SEO_Option") == "") {update_option("UPCP_SEO_Option", "None");}
	if (get_option("UPCP_SEO_Integration") == "") {update_option("UPCP_SEO_Integration", "Add");}
	if (get_option("UPCP_SEO_Title") == "") {update_option("UPCP_SEO_Title", "[page-title] | [product-name]");}
	if (get_option("UPCP_Update_Breadcrumbs") == "") {update_option("UPCP_Update_Breadcrumbs", "No");}

	if (get_option("UPCP_List_View_Click_Action") == "") {update_option("UPCP_List_View_Click_Action", "Expand");}
	if (get_option("UPCP_Details_Icon_Type") == "") {update_option("UPCP_Details_Icon_Type", "Default");}
	if (get_option("UPCP_Pagination_Background") == "") {update_option("UPCP_Pagination_Background", "None");}
	if (get_option("UPCP_Pagination_Border") == "") {update_option("UPCP_Pagination_Border", "none");}
	if (get_option("UPCP_Pagination_Shadow") == "") {update_option("UPCP_Pagination_Shadow", "shadow-none");}
	if (get_option("UPCP_Pagination_Gradient") == "") {update_option("UPCP_Pagination_Gradient", "gradient-none");}
	if (get_option("UPCP_Pagination_Font") == "") {update_option("UPCP_Pagination_Font", "none");}
	if (get_option("UPCP_Sidebar_Title_Collapse") == "") {update_option("UPCP_Sidebar_Title_Collapse", "no");}
	if (get_option("UPCP_Sidebar_Start_Collapsed") == "") {update_option("UPCP_Sidebar_Start_Collapsed", "no");}
	if (get_option("UPCP_Sidebar_Title_Hover") == "") {update_option("UPCP_Sidebar_Title_Hover", "none");}
	if (get_option("UPCP_Sidebar_Checkbox_Style") == "") {update_option("UPCP_Sidebar_Checkbox_Style", "none");}
	if (get_option("UPCP_Categories_Control_Type") == "") {update_option("UPCP_Categories_Control_Type", "Checkbox");}
	if (get_option("UPCP_SubCategories_Control_Type") == "") {update_option("UPCP_SubCategories_Control_Type", "Checkbox");}
	if (get_option("UPCP_Tags_Control_Type") == "") {update_option("UPCP_Tags_Control_Type", "Checkbox");}
	if (get_option("UPCP_Sidebar_Items_Order") == "") {update_option("UPCP_Sidebar_Items_Order", array("Product Sort", "Product Search", "Price Filter", "Categories", "Sub-Categories", "Tags", "Custom Fields"));}

	if (get_option("UPCP_Installed_Skins") == "") {update_option("UPCP_Installed_Skins", array());}

	if (!is_array(get_option("UPCP_Product_Sort"))) {
		$Current_Sort = get_option("UPCP_Product_Sort");
		$Product_Sort = array();
		if ($Current_Sort == "Name" or $Current_Sort == "Price_Name") {$Product_Sort[] = "Name";}
		if ($Current_Sort == "Price" or $Current_Sort == "Price_Name") {$Product_Sort[] = "Price";}
		update_option("UPCP_Product_Sort", $Product_Sort);
	}
}
?>