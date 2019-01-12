<?php
/* Processes the ajax requests being put out in the admin area and the front-end
*  of the UPCP plugin */

// Updates the order of items in the catalogue after a user has dragged and dropped them
function Catalogue_Save_Order() {
	global $catalogue_items_table_name;
	global $wpdb;
	
	foreach ($_POST['list-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $catalogue_items_table_name SET Position=%d WHERE Catalogue_Item_ID=%d", sanitize_text_field($Key), $ID));
	}
		
}
add_action('wp_ajax_catalogue_update_order', 'Catalogue_Save_Order');

function Video_Save_Order(){
	global $item_videos_table_name;
	global $wpdb;
	
	foreach ($_POST['video-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $item_videos_table_name SET Item_Video_Order=%d WHERE Item_Video_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_video_update_order','Video_Save_Order');

function Image_Save_Order(){
	global $item_images_table_name;
	global $wpdb;
	
	foreach ($_POST['list-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $item_images_table_name SET Item_Image_Order=%d WHERE Item_Image_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_image_update_order','Image_Save_Order');

function Tag_Group_Save_Order(){
	global $tag_groups_table_name;
	global $wpdb;
	
	foreach ($_POST['list-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $tag_groups_table_name SET Tag_Group_Order=%d WHERE Tag_Group_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_tag_group_update_order','Tag_Group_Save_Order');

function Category_Products_Save_Order(){
	global $items_table_name;
	global $wpdb;
	
	foreach ($_POST['category-product-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $items_table_name SET Item_Category_Product_Order=%d WHERE Item_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_category_products_update_order','Category_Products_Save_Order');

function Custom_Fields_Save_Order(){
	global $fields_table_name;
	global $wpdb;
	
	foreach ($_POST['field-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $fields_table_name SET Field_Sidebar_Order=%d WHERE Field_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_custom_fields_update_order','Custom_Fields_Save_Order');

function Catergories_Save_Order(){
	global $categories_table_name;
	global $wpdb;
	
	foreach ($_POST['category-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $categories_table_name SET Category_Sidebar_Order=%d WHERE Category_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_categories_update_order','Catergories_Save_Order');

function SubCatergories_Save_Order(){
	global $subcategories_table_name;
	global $wpdb;
	
	foreach ($_POST['subcategory-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $subcategories_table_name SET SubCategory_Sidebar_Order=%d WHERE SubCategory_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_subcategories_update_order','SubCatergories_Save_Order');

function Tags_Save_Order(){
	global $tags_table_name;
	global $wpdb;

	foreach ($_POST['tag-list-item'] as $Key=>$ID) {
		$Result = $wpdb->query($wpdb->prepare("UPDATE $tags_table_name SET Tag_Sidebar_Order=%d WHERE Tag_ID=%d", sanitize_text_field($Key), $ID));
	}
}
add_action('wp_ajax_tags_update_order','Tags_Save_Order');

// Records the number of times a product has been viewed
function Record_Item_View() {
	global $items_table_name;
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);
	global $wpdb;

	$Item_ID = sanitize_text_field($_POST['Item_ID']);

	$Item = $wpdb->get_row($wpdb->prepare("SELECT Item_Views FROM $items_table_name WHERE Item_ID='%d'", $Item_ID));
	if ($Item->Item_Views == "") {$wpdb->query($wpdb->prepare("UPDATE $items_table_name SET Item_Views=1 WHERE Item_ID='%d'", $Item_ID));}
	else {$wpdb->query($wpdb->prepare("UPDATE $items_table_name SET Item_Views=Item_Views+1 WHERE Item_ID='%d'", $Item_ID));}
}
add_action('wp_ajax_record_view', 'Record_Item_View');
add_action( 'wp_ajax_nopriv_record_view', 'Record_Item_View' );

// Updates the catalogue results based on the text entered and search boxes selected
function UPCP_Filter_Catalogue() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);
	
	$id = sanitize_text_field($_POST['id']);
	$sidebar = sanitize_text_field($_POST['sidebar']);
	$start_layout = sanitize_text_field($_POST['start_layout']);
	$excluded_layouts = sanitize_text_field($_POST['excluded_layouts']);
	$current_page = sanitize_text_field($_POST['current_page']);
	$products_per_page = sanitize_text_field($_POST['products_per_page']);
	$default_search_text = sanitize_text_field($_POST['default_search_text']);
	$ajax_url = esc_url($_POST['ajax_url']);
	$ajax_reload = sanitize_text_field($_POST['ajax_reload']);
	$request_count = sanitize_text_field($_POST['request_count']);
	
	if (sanitize_text_field($_POST['Prod_Name']) != $default_search_text and $_POST['Prod_Name'] != "") {$Prod_Name = sanitize_text_field($_POST['Prod_Name']);}
	else {$Prod_Name = "";}
	$Min_Price = sanitize_text_field($_POST['min_price']);
	$Max_Price = sanitize_text_field($_POST['max_price']);
	$Category = sanitize_text_field($_POST['Category']);
	$SubCategory = sanitize_text_field($_POST['SubCategory']);
	$Tags = sanitize_text_field($_POST['Tags']);
	$Custom_Fields = sanitize_text_field($_POST['Custom_Fields']);
	
	echo do_shortcode("[product-catalogue id='" . $id . "' only_inner='Yes' starting_layout='" . $start_layout . "' excluded_layouts='" . $exclude_layouts . "' current_page='" . $current_page . "' products_per_page='" . $products_per_page . "' ajax_reload='" . $ajax_reload . "' ajax_url='" . $ajax_url . "' request_count='" . $request_count . "' category='" . $Category . "' subcategory='" . $SubCategory . "' tags='" . $Tags . "' custom_fields='" . $Custom_Fields . "' prod_name='" . $Prod_Name . "' min_price='" . $Min_Price . "' max_price='" . $Max_Price . "']");

	die();
}
add_action('wp_ajax_update_catalogue', 'UPCP_Filter_Catalogue');
add_action( 'wp_ajax_nopriv_update_catalogue', 'UPCP_Filter_Catalogue');

function Get_UPCP_Matching_Products() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);

	global $wpdb;
	global $items_table_name;

	$Search = sanitize_text_field($_POST['Search']);
	$Request_Count = sanitize_text_field($_POST['Request_Count']);
	$Catalogue_URL = sanitize_text_field($_POST['Catalogue_URL']);

	$Message_Array = array('request_count' => $Request_Count);

	$All_Product_IDs = array();

	$Products = $wpdb->get_results($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_Name LIKE (%s)", "%" . $Search . "%"));
	foreach ($Products as $Product) {$All_Product_IDs[] = $Product->Item_ID;}

	if ($wpdb->num_rows < 4) {
		$Additional_Products = $wpdb->get_results($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_Description LIKE (%s)", "%" . $Search . "%"));
		foreach ($Additional_Products as $Product) {$All_Product_IDs[] = $Product->Item_ID;}
	}

	$Product_IDs = array_slice($All_Product_IDs, 0, 4);
	$Product_IDs_String = implode(",", $Product_IDs);

	if (sizeOf($All_Product_IDs) > 0) {$Message_Array['message'] = do_shortcode("[insert-products catalogue_url='" . $Catalogue_URL . "' product_ids='" . $Product_IDs_String . "']");}
	else {$Message_Array['message'] = "No results found matching " . $Search . ".";}

	echo  json_encode($Message_Array);

	die();
}
add_action('wp_ajax_upcp_ajax_search', 'Get_UPCP_Matching_Products');
add_action('wp_ajax_nopriv_upcp_ajax_search', 'Get_UPCP_Matching_Products');

// Updates sub-categories drop-down box on the products pages, based on the product's category
function Get_UPCP_SubCategories() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);

	global $wpdb;
	global $subcategories_table_name;
	
	$SubCategories = $wpdb->get_results($wpdb->prepare("SELECT SubCategory_ID, SubCategory_Name FROM $subcategories_table_name WHERE Category_ID=%d", sanitize_text_field($_POST['CatID'])));
	foreach ($SubCategories as $SubCategory) {$Response_Array[] = $SubCategory->SubCategory_ID; $Response_Array[] = $SubCategory->SubCategory_Name;}
	if (is_array($Response_Array)) {$Response = implode(",", $Response_Array);}
	else {$Response = "";}
	echo $Response;
}
add_action('wp_ajax_get_upcp_subcategories', 'Get_UPCP_SubCategories');

function Save_Serialized_Product_Page() {	
	if ($_POST['type'] == "mobile" and isset($_POST['serialized_product_page'])) {return update_option("UPCP_Product_Page_Serialized_Mobile", $_POST['serialized_product_page']);}
	elseif (isset($_POST['serialized_product_page'])) {return update_option("UPCP_Product_Page_Serialized", $_POST['serialized_product_page']);}
}
add_action('wp_ajax_save_serialized_product_page', 'Save_Serialized_Product_Page');

// Adds an item to the plugin's cart
function UPCP_Add_To_Cart() {
	global $woocommerce;
	global $wpdb;
	global $items_table_name;

	$WooCommerce_Checkout = get_option("UPCP_WooCommerce_Checkout");

	if ($WooCommerce_Checkout == "Yes") {
		$WC_Prod_ID = $wpdb->get_var($wpdb->prepare("SELECT Item_WC_ID FROM $items_table_name WHERE Item_ID=%d", sanitize_text_field($_POST['prod_ID'])));
		echo "WC ID: " . $WC_Prod_ID . "<Br>";
		$woocommerce->cart->add_to_cart($WC_Prod_ID);
	}
	
	if (isset($_COOKIE['upcp_cart_products'])) {
		$Products_Array = explode(",", $_COOKIE['upcp_cart_products']);
	}
	else {
		$Products_Array = array();
	}
	
	$Products_Array[] = $_POST['prod_ID'];
	$Products_Array = array_unique($Products_Array);
	$Products_String = implode(",", $Products_Array);
	setcookie('upcp_cart_products', $Products_String, time()+3600*24*3, "/");
}
add_action('wp_ajax_upcp_add_to_cart', 'UPCP_Add_To_Cart');
add_action( 'wp_ajax_nopriv_upcp_add_to_cart', 'UPCP_Add_To_Cart' );

// Clears the plugin's cart
function UPCP_AJAX_Clear_Cart() {
	global $woocommerce;

	$WooCommerce_Checkout = get_option("UPCP_WooCommerce_Checkout");
	
	if ($WooCommerce_Checkout == "Yes") {
		if (is_object($woocommerce->cart)) {
			$woocommerce->cart->get_cart();
		}
	}

	setcookie('upcp_cart_products', "", time() - 3600, "/");
}
add_action('wp_ajax_upcp_clear_cart', 'UPCP_AJAX_Clear_Cart');
add_action( 'wp_ajax_nopriv_upcp_clear_cart', 'UPCP_AJAX_Clear_Cart' );


//REVIEW ASK POP-UP
function EWD_UPCP_Hide_Review_Ask(){   
    $Ask_Review_Date = sanitize_text_field($_POST['Ask_Review_Date']);

    update_option('UPCP_Ask_Review_Date', time()+3600*24*$Ask_Review_Date);

    die();
}
add_action('wp_ajax_ewd_upcp_hide_review_ask','EWD_UPCP_Hide_Review_Ask');

function EWD_UPCP_Send_Feedback() {   
    $Feedback = sanitize_text_field($_POST['Feedback']);

    wp_mail('contact@etoilewebdesign.com', 'UPCP Feedback - Dashboard Form', $Feedback);

    die();
}
add_action('wp_ajax_ewd_upcp_send_feedback','EWD_UPCP_Send_Feedback');

function EWD_UPCP_Dismiss_Pointers() {   
    $uid = get_current_user_id();
    $pointers = explode( ',', (string) get_user_meta( $uid, 'dismissed_wp_pointers', TRUE ) );

    $pointers[] = 'upcp_admin_pointers_tutorial-one';
    $pointers[] = 'upcp_admin_pointers_tutorial-two';
    $pointers[] = 'upcp_admin_pointers_tutorial-three';
    $pointers[] = 'upcp_admin_pointers_tutorial-four';
    $pointers[] = 'upcp_admin_pointers_tutorial-five';
    $pointers[] = 'upcp_admin_pointers_tutorial-six';
    
    $unique_pointers = array_unique($pointers);
    update_usermeta($uid, 'dismissed_wp_pointers', implode(",", $unique_pointers));
    
    die();
}
add_action('wp_ajax_upcp-dismiss-wp-pointers','EWD_UPCP_Dismiss_Pointers');