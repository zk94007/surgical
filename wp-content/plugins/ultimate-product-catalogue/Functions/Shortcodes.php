<?php
function UPCP_Display_Catalog_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-upcp-blocks-js', plugins_url( '../blocks/ewd-upcp-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-upcp-blocks-css', plugins_url( '../blocks/ewd-upcp-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-upcp-blocks.css' ) );
		register_block_type( 'ultimate-product-catalogue/ewd-upcp-display-catalog-block', array(
			'attributes'      => array(
				'id' => array(
					'type' => 'string',
				),
				'sidebar' => array(
					'type' => 'string',
				),
				'starting_layout' => array(
					'type' => 'string',
				),
				'excluded_layouts' => array(
					'type' => 'string',
				),
			),
			'editor_script'   => 'ewd-upcp-blocks-js',
			'editor_style'  => 'ewd-upcp-blocks-css',
			'render_callback' => 'Insert_Product_Catalog',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("product-catalogue", "Insert_Product_Catalog");
	add_shortcode("product-catalog", "Insert_Product_Catalog");
}
add_action( 'init', 'UPCP_Display_Catalog_Block' );


/* The function that creates the HTML on the front-end, based on the parameters
* supplied in the product-catalog shortcode */
function Insert_Product_Catalog($atts) {
	// Include the required global variables, and create a few new ones
	global $wpdb, $categories_table_name, $subcategories_table_name, $tags_table_name, $tagged_items_table_name, $tag_groups_table_name, $catalogues_table_name, $catalogue_items_table_name, $items_table_name, $fields_table_name, $fields_meta_table_name, $item_videos_table_name;
	global $ProductString, $Product_Attributes, $ProdCats, $ProdSubCats, $ProdTags, $ProdCustomFields, $ProdCatString, $ProdSubCatString, $ProdTagString, $ProdCustomFieldsString, $Catalogue_ID, $Catalogue_Layout_Format, $Catalogue_Sidebar, $Full_Version, $TagGroupName, $Max_Price_Product, $Min_Price_Product;
	global $link_base;
	global $UPCP_Options;

	$Bottom_JS = "";
	$Top_JS = "";
	$InnerString = "";
	$HeaderBar = "";
	$ProductString = "";
	$MobileMenuString = "";
	$Currency_Symbol = $UPCP_Options->Get_Option("UPCP_Currency_Symbol");
	$Currency_Symbol_Location = $UPCP_Options->Get_Option("UPCP_Currency_Symbol_Location");
	$Color = $UPCP_Options->Get_Option("UPCP_Color_Scheme");
	$Links = $UPCP_Options->Get_Option("UPCP_Product_Links");
	$Detail_Image = $UPCP_Options->Get_Option("UPCP_Details_Image");
	$Pretty_Links = $UPCP_Options->Get_Option("UPCP_Pretty_Links");
	$Mobile_Style = $UPCP_Options->Get_Option("UPCP_Mobile_SS");
	$Tag_Logic = $UPCP_Options->Get_Option("UPCP_Tag_Logic");
	$Links = $UPCP_Options->Get_Option("UPCP_Product_Links");
	$Pagination_Location = $UPCP_Options->Get_Option("UPCP_Pagination_Location");
	$CaseInsensitiveSearch = $UPCP_Options->Get_Option("UPCP_Case_Insensitive_Search");
	$Maintain_Filtering = $UPCP_Options->Get_Option("UPCP_Maintain_Filtering");
	$Show_Category_Descriptions = $UPCP_Options->Get_Option("UPCP_Show_Category_Descriptions");
	$Show_Catalogue_Information = $UPCP_Options->Get_Option("UPCP_Show_Catalogue_Information");
	$Display_Category_Image = $UPCP_Options->Get_Option("UPCP_Display_Category_Image");
	$Overview_Mode = $UPCP_Options->Get_Option("UPCP_Overview_Mode");
	$Product_Inquiry_Cart = $UPCP_Options->Get_Option("UPCP_Product_Inquiry_Cart");
	$WooCommerce_Checkout = $UPCP_Options->Get_Option("UPCP_WooCommerce_Checkout");
	$Product_Comparison = $UPCP_Options->Get_Option("UPCP_Product_Comparison");
	$Lightbox_Mode = $UPCP_Options->Get_Option("UPCP_Lightbox_Mode");
	$Infinite_Scroll = $UPCP_Options->Get_Option("UPCP_Infinite_Scroll");
	$Products_Per_Page = $UPCP_Options->Get_Option("UPCP_Products_Per_Page");
	$ProductSearch = $UPCP_Options->Get_Option("UPCP_Product_Search");
	$Inner_Filter = $UPCP_Options->Get_Option("UPCP_Inner_Filter");

	$Category_Heading_Style = $UPCP_Options->Get_Option("UPCP_Category_Heading_Style");

	$Pagination_Background = $UPCP_Options->Get_Option("UPCP_Pagination_Background");
	$Pagination_Border = $UPCP_Options->Get_Option("UPCP_Pagination_Border");
	$Pagination_Shadow = $UPCP_Options->Get_Option("UPCP_Pagination_Shadow");
	$Pagination_Gradient = $UPCP_Options->Get_Option("UPCP_Pagination_Gradient");
	$Pagination_Font = $UPCP_Options->Get_Option("UPCP_Pagination_Font");

	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
				"id" => "1",
				"excluded_layouts" => "None",
				"starting_layout" => "",
				"products_per_page" => "",
				"current_page" => 1,
				"sidebar" => "Yes",
				"overview_mode" => "",
				"omit_fields" => "",
				"only_inner" => "No",
				"ajax_reload" => "No",
				"ajax_url" => "",
				"request_count" => 0,
				"category" => "",
				"subcategory" => "",
				"tags" => "",
				"custom_fields" => "",
				"prod_name" => "",
				"link_base" => "",
				"max_price" => 10000000,
				"min_price" => 0),
			$atts
		)
	);

	if (isset($_GET['overview_mode'])) {$overview_mode = $_GET['overview_mode'];}

	$Products_Pagination_Label = $UPCP_Options->Get_Option("UPCP_Products_Pagination_Label");
	$No_Results_Found_Label = $UPCP_Options->Get_Option("UPCP_No_Results_Found_Label");
	if ($Products_Pagination_Label != "") {$Products_Pagination_Text = $Products_Pagination_Label;}
	else {$Products_Pagination_Text = __(' products', 'ultimate-product-catalogue');}
	$Product_Name_Search_Label = $UPCP_Options->Get_Option("UPCP_Product_Name_Search_Label");
	$Product_Search_Text_Label = $UPCP_Options->Get_Option("UPCP_Product_Name_Text_Label");
	if ($Product_Name_Search_Label != "") {$SearchLabel = $Product_Name_Search_Label;}
	else {
		if ($ProductSearch == "namedesc" or $ProductSearch == "namedesccust") {$SearchLabel = __("Product Search:", 'ultimate-product-catalogue');}
		else {$SearchLabel = __("Product Name:", 'ultimate-product-catalogue');}
	}
	if ($prod_name != "") {$Product_Name_Text = $prod_name;}
	elseif ($Product_Search_Text_Label != "") {$Product_Name_Text = $Product_Search_Text_Label;
	}
	else {
		if ($ProductSearch == "namedesc" or $ProductSearch == "namedesccust") {$Product_Name_Text = __("Search...", 'ultimate-product-catalogue');}
		else {$Product_Name_Text = __("Name...", 'ultimate-product-catalogue');}
	}

	$Of_Pagination_Label = $UPCP_Options->Get_Option("UPCP_Of_Pagination_Label");
	if($Of_Pagination_Label == ""){$Of_Pagination_Label = __(' of ', 'ultimate-product-catalogue');}


	if ($Infinite_Scroll == "Yes") {$Infinite_Scroll_Class = "upcp-infinite-scroll";}
	else {$Infinite_Scroll_Class = "";}

	if ($ajax_reload != "No") {$ajax_reload = ucfirst(strtolower($ajax_reload));}

	if ($overview_mode != "") {$Overview_Mode = $overview_mode;}

	if (!is_numeric($id)) {return;}

	// Select the catalogue information from the database
	$Catalogue = $wpdb->get_row($wpdb->prepare("SELECT * FROM $catalogues_table_name WHERE Catalogue_ID=%d", $id));
	$CatalogueItems = $wpdb->get_results("SELECT * FROM $catalogue_items_table_name WHERE Catalogue_ID=" . $Catalogue->Catalogue_ID . " ORDER BY Position");

	// Add any additional CSS in-line
	if ($Catalogue->Catalogue_Custom_CSS != "") {
		$HeaderBar .= "<style type='text/css'>";
		$HeaderBar .= $Catalogue->Catalogue_Custom_CSS;
		$HeaderBar .= "</style>";
	}

	//Add styling options that have been set
	$HeaderBar .= UPCP_Add_Modified_Styles();

	if ($Detail_Image != "") {
		$HeaderBar .= "<style type='text/css'>";
		$HeaderBar .= ".upcp-thumb-details-link, .upcp-list-details-link, .upcp-detail-details-link {";
		$HeaderBar .= "background: url('" . $Detail_Image . "') no-repeat;";
		$HeaderBar .= "}";
		$HeaderBar .= "</style>";
	}
	if (!isset($_POST['categories'])){$_POST['categories'] = "";}
	if (!isset($_POST['sub-categories'])){$_POST['sub-categories'] = "";}
	if (!isset($_POST['tags'])){$_POST['tags'] = "";}
	if (!isset($_POST['prod_name'])) {$_POST['prod_name'] = "";}
	if (!isset($_POST['current_page'])) {$_POST['current_page'] = "";}
	if(!isset($_GET['SingleProduct'])){$_GET['SingleProduct'] = "";}



	$Top_JS .= "<script language='JavaScript' type='text/javascript'>";
	if ($Maintain_Filtering == "Yes") {$Top_JS .= "var maintain_filtering = 'Yes';";}
	else {$Top_JS .= "var maintain_filtering = 'No';";}
	$Top_JS .= "</script>";

	$HeaderBar .= $Top_JS;

	if ($Links == "New") {$Target = "_blank";}
	else {$Target = "_self";}

	$Max_Price_Product = 0;
	$Min_Price_Product = 0;

	$HeaderBar .= "<form id='upcp-hidden-filtering-form' method='post' target='" . $Target . "'>";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-categories' name='categories' value='" . $_POST['categories'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-subcategories' name='sub-categories' value='" . $_POST['sub-categories'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-tags' name='tags' value='" . $_POST['tags'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-prod-name' name='prod_name' value='" . $_POST['prod_name'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-current-page' name='current_page' value='" . $_POST['current_page'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-current-url' name='current_url' value='" . get_permalink() . "' />";
	$HeaderBar .= "</form>";

	if ($WooCommerce_Checkout == "Yes") {$HeaderBar .= UPCP_Add_WC_Cart_HTML();}

	if ($Product_Inquiry_Cart == "Yes" and $WooCommerce_Checkout != "Yes") {$HeaderBar .= UPCP_Add_Inquiry_Cart_HTML();}

	if (get_query_var('single_product') != "" or $_GET['SingleProduct'] != "") {
		$ProductString .= $HeaderBar;
		$ProductString .= SingleProductPage();
		return $ProductString;
	}

	if (isset($_POST['Comparison_Product_ID'])) {
		$ProductString .= $HeaderBar;
		$ProductString .= UPCP_Product_Comparison($_POST['Comparison_Product_ID'], $omit_fields);
		return $ProductString;
	}

	if (isset($_POST['Submit_Inquiry'])) {
		$ProductString .= $HeaderBar;
		$ProductString .= UPCP_Single_Page_Inquiry_Form();
		return $ProductString;
	}

	if (($Overview_Mode == "Cats" or $Overview_Mode == "Full") and $only_inner == "No") { //Use a session variable?
		if (!isset($_REQUEST['categories'])) {
			$OverviewString = UPCP_Get_Catalog_Overview($CatalogueItems, "Categories");
			if ($OverviewString != false) {
				$OverviewString = $HeaderBar . $OverviewString;
				return $OverviewString;
			}
		}
		if (!isset($_REQUEST['sub-categories']) and $Overview_Mode == "Full") {
			$OverviewString = UPCP_Get_Catalog_Overview($CatalogueItems, "SubCategories", $_REQUEST['categories']);
			if ($OverviewString != false) {
				$OverviewString = $HeaderBar . $OverviewString;
				return $OverviewString;
			}
		}
	}

	$CatalogAreaTopString = "";
	if ($Product_Comparison == "Yes") {
		$CatalogAreaTopString .= "<form id='upcp-product-comparison-form' method='post'>";
		$CatalogAreaTopString .= "</form>";
	}

	if ($Lightbox_Mode == "Yes") {
		$CatalogAreaTopString .= "<div id='upcp-lightbox-background-div'></div>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-div'>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-div-img-contatiner'><img id='upcp-lightbox-div-img' /></div>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-text-div'>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-text-div-inner'>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-title-div'></div>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-price-div'></div>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-description-div'></div>";
		$CatalogAreaTopString .= "<div id='upcp-lightbox-link-container-div'><a href='#'>" . __("Details", 'ultimate-product-catalogue') . "</a></div>";
		$CatalogAreaTopString .= "</div>"; //lightbox-text-div-inner
		$CatalogAreaTopString .= "</div>"; //lightbox-text-div
		$CatalogAreaTopString .= "</div>";
	}

	$layout_format = "";
	$Catalogue_ID = $id;
	$Catalogue_Sidebar = $sidebar;
	$Starting_Layout = ucfirst($starting_layout);
	if ($excluded_layouts != "None") {$Excluded_Layouts = explode(",", $excluded_layouts);}
	else {$Excluded_Layouts = array();}

	if (isset($_GET['categories'])) {$category = explode(",", $_GET['categories']);}
	elseif (isset($_POST['categories']) and $_POST['categories'] != "") {$category = explode(",", $_POST['categories']);}
	elseif ($category == "") {$category = array();}
	else {$category = explode(",", $category);}
	if (isset($_GET['sub-categories'])) {$subcategory = explode(",", $_GET['sub-categories']);}
	elseif (isset($_POST['sub-categories']) and $_POST['sub-categories'] != "") {$subcategory = explode(",", $_POST['sub-categories']);}
	elseif ($subcategory == "") {$subcategory = array();}
	else {$subcategory = explode(",", $subcategory);}
	if (isset($_GET['tags'])) {$tags = explode(",", $_GET['tags']);}
	elseif (isset($_POST['tags']) and $_POST['tags'] != "") {$tags = explode(",", $_POST['tags']);}
	elseif ($tags == "") {$tags = array();}
	else {$tags = explode(",", $tags);}
	if (isset($_POST['current_page']) and $_POST['current_page'] != "") {$current_page = $_POST['current_page'];}

	if (isset($_POST['prod_name']) and $_POST['prod_name'] != "") {$prod_name = $_POST['prod_name'];}

	//Pagination early work
	if ($products_per_page == "") {$products_per_page = $Products_Per_Page;}
	if ($category != "" or $subcategory != "" or $tags != "" or $prod_name != "") {$Filtered = "Yes";}
	else {$Filtered = "No";}

	$ProductString .= "<div class='upcp-Hide-Item' id='upcp-shortcode-atts'>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-catalogue-id'>" . $id . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-catalogue-sidebar'>" . $sidebar . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-starting-layout'>" . $starting_layout . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-current-layout'>" . $starting_layout . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-exclude-layouts'>" . $excluded_layouts . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-current-page'>" . $current_page . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-products-per-page'>" . $products_per_page . "</div>";
	$ProductString .= "<div class='shortcode-attr' id='upcp-default-search-text'>" . $Product_Name_Text . "</div>";
	if ($ajax_reload == "Yes") {$ProductString .= "<div class='shortcode-attr' id='upcp-base-url'>" . $ajax_url . "</div>";}
	else {
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		if (!array_key_exists(1, $uri_parts)) {$uri_parts[1] = '';}
		//if ($uri_parts[0] != "/") {$ProductString .= "<div class='shortcode-attr' id='upcp-base-url'>" . $uri_parts[0] . "</div>";}
		if (strpos($uri_parts[1], "page_id") === false) {$ProductString .= "<div class='shortcode-attr' id='upcp-base-url'>" . $uri_parts[0] . "</div>";}
		else {$ProductString .= "<div class='shortcode-attr' id='upcp-base-url'>" . $uri_parts[0] . "?" . $uri_parts[1] . "</div>";}
		//else {$ProductString .= "<div class='shortcode-attr' id='upcp-base-url'>/?" . $uri_parts[1] . "</div>";}
	}
	$ProductString .= "</div>";

	if (sizeOf($Excluded_Layouts)>0) {for ($i=0; $i<sizeOf($Excluded_Layouts); $i++) {$ExcludedLayouts[$i] = ucfirst(trim($Excluded_Layouts[$i]));}}
	else {$ExcludedLayouts = array();}

	if ($Starting_Layout == "") {
		if (!in_array("Thumbnail", $Excluded_Layouts)) {$Starting_Layout = "Thumbnail";}
		elseif (!in_array("List", $Excluded_Layouts)) {$Starting_Layout = "List";}
		else {$Starting_Layout = "Detail";}
	}

	// Make sure that the layout is set
	if ($layout_format != "Thumbnail" and $layout_format != "List") {
		if ($Catalogue->Catalogue_Layout_Format != "") {$format = $Catalogue->Catalogue_Layout_Format;}
		else {$format = "Thumbnail";}
	}
	else {$format = $layout_format;}

	// Arrays to store what categories, sub-categories and tags are applied to the product in the catalogue
	$ProdCats = array();
	$ProdSubCats = array();
	$ProdTags = array();
	$ProdCustomFields = array();
	$ProdThumbString = "";
	$ProdListString = "";
	$ProdDetailString = "";

	// If filtering for custom fields, build the field/value query string
	$Custom_Fields_Sql_String = "";
	$Custom_Field_Count = 0;
	if ($custom_fields != "") {
		$Custom_Field_IDs = explode(",", $custom_fields);
		foreach ($Custom_Field_IDs as $Custom_Field_ID){
			$Field_ID = substr($Custom_Field_ID, 0, strpos($Custom_Field_ID, "="));
			$Field_Value = substr($Custom_Field_ID, strpos($Custom_Field_ID, "=")+1);
			$Selected_Custom_Fields[$Field_ID][] = html_entity_decode($Field_Value);
		}
		$Custom_Fields_Sql_String .= "(";
		foreach ($Selected_Custom_Fields as $Field_ID => $Selected_Custom_Field) {
			$Custom_Fields_Sql_String .= "(";
			$Custom_Fields_Sql_String .= "Field_ID='" . $Field_ID . "' AND (";
			$Field_Control_Type = $wpdb->get_var($wpdb->prepare("SELECT Field_Control_Type FROM $fields_table_name WHERE Field_ID=%d", $Field_ID));
			foreach ($Selected_Custom_Field as $key => $Value){
				if ($Field_Control_Type == "Slider") {$Custom_Fields_Sql_String .= "Meta_Value BETWEEN " . $Value . " AND " . $Selected_Custom_Field[$key+1] . "    "; break;}
				else {$Custom_Fields_Sql_String .= "Meta_Value LIKE '" . $Value . "' OR Meta_Value LIKE '" . $Value . ",%' OR Meta_Value LIKE '%," . $Value . ",%' OR Meta_Value LIKE '%," . $Value . "' OR ";}
			}
			$Custom_Fields_Sql_String = substr($Custom_Fields_Sql_String, 0, -4);
			$Custom_Fields_Sql_String .= "))";
			$Custom_Fields_Sql_String .= " OR ";
		}
		$Custom_Fields_Sql_String = substr($Custom_Fields_Sql_String, 0, -4);
		$Custom_Fields_Sql_String .= ")";
		$Custom_Field_Count = sizeOf($Selected_Custom_Fields);
	}

	$ProdThumbString .=  "<div id='prod-cat-" . $id . "' class='prod-cat thumb-display ";
	if ($Starting_Layout != "Thumbnail") {$ProdThumbString .= "hidden-field";}
	$ProdThumbString .= "'>\n";
	$ProdThumbString .= "%upcp_pagination_placeholder_top%";

	$ProdListString .=  "<div id='prod-cat-" . $id . "' class='prod-cat list-display ";
	if ($Starting_Layout != "List") {$ProdListString .= "hidden-field";}
	$ProdListString .= "'>\n";
	$ProdListString .= "%upcp_pagination_placeholder_top%";

	$ProdDetailString .=  "<div id='prod-cat-" . $id . "' class='prod-cat detail-display ";
	if ($Starting_Layout != "Detail") {$ProdDetailString .= "hidden-field";}
	$ProdDetailString .= "'>\n";
	$ProdDetailString .= "%upcp_pagination_placeholder_top%";

	$Product_Count = 0;

	foreach ($CatalogueItems as $CatalogueItem) {

		// If the item is a product, then simply call the AddProduct function to add it to the code
		if ($CatalogueItem->Item_ID != "" and $CatalogueItem->Item_ID != 0) {
			$Product = new UPCP_Product(array("ID" => $CatalogueItem->Item_ID));
			$ProdTagObj = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $CatalogueItem->Item_ID);
			//if ($ajax_reload == "No") {
				$Prod_Custom_Fields = $wpdb->get_results("SELECT Field_ID, Meta_Value FROM $fields_meta_table_name WHERE Item_ID=" . $Product->Get_Item_ID());
			//}

			if ($Product->Get_Field_Value('Item_Display_Status') != "Hide") {
				$Item_Price = $Product->Get_Product_Price();
				$Max_Price_Product = UPCP_Max_Price($Max_Price_Product, $Item_Price);
				$Min_Price_Product = UPCP_Min_Price($Min_Price_Product, $Item_Price);
				if (sizeOf($category) == 0 or in_array($Product->Get_Field_Value('Category_ID'), $category)) {
					if (sizeOf($subcategory) == 0 or in_array($Product->Get_Field_Value('SubCategory_ID'), $subcategory)) {
						$ProdTag = UPCP_ObjectToArray($ProdTagObj);
						$Tag_Check = CheckTags($tags, $ProdTag, $Tag_Logic);
						if ($Tag_Check == "Yes") {
							$Custom_Field_Check = Custom_Field_Check($Custom_Fields_Sql_String, $Custom_Field_Count, $Product->Get_Item_ID());
							if ($Custom_Field_Check == "Yes") {
								$Name_Search_Match = SearchProductName($Product->Get_Item_ID(), $Product->Get_Field_Value('Item_Name'), $Product->Get_Field_Value('Item_Description'), $prod_name, $CaseInsensitiveSearch, $ProductSearch);
								if ($Name_Search_Match == "Yes") {
									if (UPCP_Price_Check($max_price, $min_price, $Item_Price)) {
										$Pagination_Check = CheckPagination($Product_Count, $products_per_page, $current_page, $Filtered);
										if ($Pagination_Check == "OK") {
											if (!in_array("Thumbnail", $ExcludedLayouts)) {$ProdThumbString .= UPCP_AddProduct("Thumbnail", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
											if (!in_array("List", $ExcludedLayouts)) {$ProdListString .= UPCP_AddProduct("List", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
											if (!in_array("Detail", $ExcludedLayouts)) {$ProdDetailString .= UPCP_AddProduct("Detail", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
										}
										$Product_Count++;
									}
								}
				}}}}
				if ($ajax_reload == "No") {FilterCount($Product, $ProdTagObj, $Prod_Custom_Fields);}
			}
			unset($NameSearchMatch);
		}

		// If the item is a category, then add the appropriate extra HTML and call the AddProduct function
		// for each individual product in the category
		if ($CatalogueItem->Category_ID != "" and $CatalogueItem->Category_ID != 0) {
			if ((sizeOf($category) == 0 or in_array($CatalogueItem->Category_ID, $category)) and $Category_Heading_Style != "None") {
				$CatProdCount = 0;
				$Category = $wpdb->get_row("SELECT Category_Name, Category_Description, Category_Image FROM $categories_table_name WHERE Category_ID=" . $CatalogueItem->Category_ID);

				$ProdThumbString .= "<div id='prod-cat-category-" . $CatalogueItem->Category_ID . "' class='prod-cat-category upcp-thumb-category'>\n";
				$ProdListString .= "<div id='prod-cat-category-" . $CatalogueItem->Category_ID . "' class='prod-cat-category upcp-list-category'>\n";
				$ProdDetailString .= "<div id='prod-cat-category-" . $CatalogueItem->Category_ID . "' class='prod-cat-category upcp-detail-category'>\n";

				$ProdThumbString .= "%Category_Label%";
				$ProdListString .= "%Category_Label%";
				$ProdDetailString .= "%Category_Label%";

				$CatThumbHead = "<div id='prod-cat-category-label-" . $CatalogueItem->Category_ID . "' class='prod-cat-category-label upcp-thumb-category-label'>";
				if ($Display_Category_Image == "Main" and $Category->Category_Image != "") {$CatThumbHead .= "<img class='upcp-category-main-img' src='" . $Category->Category_Image . "' />";}
				$CatThumbHead .= "<div class='prod-cat-category-name" . ($Category_Heading_Style == "Block" ? " blockCatHeading" : "") . "'>" . $Category->Category_Name . "</div>";
				if ($Show_Category_Descriptions == "Yes") {$CatThumbHead .= "<div class='prod-cat-category-description'>" . do_shortcode($Category->Category_Description) . "</div>\n";}
				$CatThumbHead .= "</div>";
				$CatListHead = "<div id='prod-cat-category-label-" . $CatalogueItem->Category_ID . "' class='prod-cat-category-label upcp-list-category-label'>";
				if ($Display_Category_Image == "Main" and $Category->Category_Image != "") {$CatListHead .= "<img class='upcp-category-main-img' src='" . $Category->Category_Image . "' />";}
				$CatListHead .= "<div class='prod-cat-category-name" . ($Category_Heading_Style == "Block" ? " blockCatHeading" : "") . "'>" . $Category->Category_Name ."</div>";
				if ($Show_Category_Descriptions == "Yes") {$CatListHead .= "<div class='prod-cat-category-description'>" . do_shortcode($Category->Category_Description) . "</div>\n";}
				$CatListHead .= "</div>";
				$CatDetailHead = "<div id='prod-cat-category-label-" . $CatalogueItem->Category_ID . "' class='prod-cat-category-label upcp-detail-category-label'>";
				if ($Display_Category_Image == "Main" and $Category->Category_Image != "") {$CatDetailHead .= "<img class='upcp-category-main-img' src='" . $Category->Category_Image . "' />";}
				$CatDetailHead .= "<div class='prod-cat-category-name" . ($Category_Heading_Style == "Block" ? " blockCatHeading" : "") . "'>" . $Category->Category_Name ."</div>";
				if ($Show_Category_Descriptions == "Yes") {$CatDetailHead .= "<div class='prod-cat-category-description'>" . do_shortcode($Category->Category_Description) . "</div>\n";}
				$CatDetailHead .= "</div>";
			}

			$Item_IDs = $wpdb->get_results("SELECT Item_ID FROM $items_table_name WHERE Category_ID=" . $CatalogueItem->Category_ID . " ORDER BY Item_Category_Product_Order");

			foreach ($Item_IDs as $Item_ID) {
				$Product = new UPCP_Product(array("ID" => $Item_ID->Item_ID));
				$ProdTagObj = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $Product->Get_Item_ID());
				//if ($ajax_reload == "No") {
					$Prod_Custom_Fields = $wpdb->get_results("SELECT Field_ID, Meta_Value FROM $fields_meta_table_name WHERE Item_ID=" . $Product->Get_Item_ID());
				//}

				if ($Product->Get_Field_Value('Item_Display_Status') != "Hide") {
					$Item_Price = $Product->Get_Product_Price();
					$Max_Price_Product = UPCP_Max_Price($Max_Price_Product, $Item_Price);
					$Min_Price_Product = UPCP_Min_Price($Min_Price_Product, $Item_Price);
					if (sizeOf($category) == 0 or in_array($Product->Get_Field_Value('Category_ID'), $category)) {
						if (sizeOf($subcategory) == 0 or in_array($Product->Get_Field_Value('SubCategory_ID'), $subcategory)) {
							$ProdTag = UPCP_ObjectToArray($ProdTagObj);
							$Tag_Check = CheckTags($tags, $ProdTag, $Tag_Logic);
							if ($Tag_Check == "Yes") {
								$Custom_Field_Check = Custom_Field_Check($Custom_Fields_Sql_String, $Custom_Field_Count, $Product->Get_Item_ID());
								if ($Custom_Field_Check == "Yes") {
									$Name_Search_Match = SearchProductName($Product->Get_Item_ID(), $Product->Get_Field_Value('Item_Name'), $Product->Get_Field_Value('Item_Description'), $prod_name, $CaseInsensitiveSearch, $ProductSearch);
									if ($Name_Search_Match == "Yes") {
										if (UPCP_Price_Check($max_price, $min_price, $Item_Price)) {
											$Pagination_Check = CheckPagination($Product_Count, $products_per_page, $current_page, $Filtered);
											if ($Pagination_Check == "OK") {
												if (!in_array("Thumbnail", $ExcludedLayouts)) {$ProdThumbString .= UPCP_AddProduct("Thumbnail", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
												if (!in_array("List", $ExcludedLayouts)) {$ProdListString .= UPCP_AddProduct("List", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
												if (!in_array("Detail", $ExcludedLayouts)) {$ProdDetailString .= UPCP_AddProduct("Detail", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
												$CatProdCount++;
											}
											$Product_Count++;
										}
									}
					}}}}
					if ($ajax_reload == "No") {FilterCount($Product, $ProdTagObj, $Prod_Custom_Fields);}
				}
				unset($NameSearchMatch);
			}

			if ((sizeOf($category) == 0 or in_array($CatalogueItem->Category_ID, $category)) and $Category_Heading_Style != "None") {
				if ($CatProdCount > 0) {
					$ProdThumbString =  str_replace("%Category_Label%", $CatThumbHead, $ProdThumbString);
					$ProdListString = str_replace("%Category_Label%", $CatListHead, $ProdListString);
					$ProdDetailString = str_replace("%Category_Label%", $CatDetailHead, $ProdDetailString);
				}
				else {
					$ProdThumbString = str_replace("%Category_Label%", "", $ProdThumbString);
					$ProdListString = str_replace("%Category_Label%", "", $ProdListString);
					$ProdDetailString = str_replace("%Category_Label%", "", $ProdDetailString);
				}

				$ProdThumbString .= "</div>";
				$ProdListString .= "</div>";
				$ProdDetailString .= "</div>";
			}
		}

		// If the item is a sub-category, then add the appropriate extra HTML and call the AddProduct function
		// for each individual product in the sub-category
		if ($CatalogueItem->SubCategory_ID != "" and $CatalogueItem->SubCategory_ID != 0) {
			if (sizeOf($subcategory) == 0 or in_array($CatalogueItem->SubCategory_ID, $subcategory)) {
				$Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE SubCategory_ID=" . $CatalogueItem->SubCategory_ID);

				foreach ($Products as $Product) {
					$ProdTagObj = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $CatalogueItem->Item_ID);
					//if ($ajax_reload == "No") {
						$Prod_Custom_Fields = $wpdb->get_results("SELECT Field_ID, Meta_Value FROM $fields_meta_table_name WHERE Item_ID=" . $Product->Item_ID);
					//}

					if ($Product->Item_Display_Status != "Hide") {
						if (sizeOf($category) == 0 or in_array($Product->Category_ID, $category)) {
							if (sizeOf($subcategory) == 0 or in_array($Product->SubCategory_ID, $subcategory)) {
								$ProdTag = UPCP_ObjectToArray($ProdTagObj);
								$Tag_Check = CheckTags($tags, $ProdTag, $Tag_Logic);
								if ($Tag_Check == "Yes") {
									$Custom_Field_Check = Custom_Field_Check($Custom_Fields_Sql_String, $Custom_Field_Count, $Product->Item_ID);
									if ($Custom_Field_Check == "Yes") {
										$Name_Search_Match = SearchProductName($Product->Item_ID, $Product->Item_Name, $Product->Item_Description, $prod_name, $CaseInsensitiveSearch, $ProductSearch);
										if ($Name_Search_Match == "Yes") {
											if (UPCP_Price_Check($max_price, $min_price, $Product->Item_Price)) {
												$Max_Price_Product = UPCP_Max_Price($Max_Price_Product, $Product->Item_Price);
												$Min_Price_Product = UPCP_Min_Price($Min_Price_Product, $Product->Item_Price);
												$Pagination_Check = CheckPagination($Product_Count, $products_per_page, $current_page, $Filtered);
												if ($Pagination_Check == "OK") {
													if (!in_array("Thumbnail", $ExcludedLayouts)) {$ProdThumbString .= UPCP_AddProduct("Thumbnail", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
													if (!in_array("List", $ExcludedLayouts)) {$ProdListString .= UPCP_AddProduct("List", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
													if (!in_array("Detail", $ExcludedLayouts)) {$ProdDetailString .= UPCP_AddProduct("Detail", $Product, $ProdTagObj, $ajax_reload, $ajax_url);}
												}
												$Product_Count++;
											}
										}
						}}}}
						if ($ajax_reload == "No") {FilterCount($Product, $ProdTagObj, $Prod_Custom_Fields);}
					}
					unset($NameSearchMatch);
				}
		}}

		//if ($Pagination_Check == "Over") {break;}
	}

	$Filtering_JS = "<script language='JavaScript' type='text/javascript'>";
	$Filtering_JS .= "var max_price = '" . ceil($Max_Price_Product) . "';";
	$Filtering_JS .= "var min_price = '" . floor($Min_Price_Product) . "';";
	$Filtering_JS .= "var currency_symbol = '" . $Currency_Symbol . "';";
	$Filtering_JS .= "var symbol_position = '" . $Currency_Symbol_Location . "';";
	$Filtering_JS .= "var filtering_values = '" . json_encode($Product_Attributes) . "';";
	$Filtering_JS .= "</script>";
	$HeaderBar .= $Filtering_JS;

	if ($Product_Count == 0) {
		$ProdThumbString .= $No_Results_Found_Label;
		$ProdListString .= $No_Results_Found_Label;
		$ProdDetailString .= $No_Results_Found_Label;
	}

	$ProdThumbString .= "<div class='upcp-clear'></div>\n";
	$ProdListString .= "<div class='upcp-clear'></div>\n";
	$ProdDetailString .= "<div class='upcp-clear'></div>\n";

	if ($Pagination_Location == "Bottom" or $Pagination_Location == "Both") {
		$ProdThumbString .= "%upcp_pagination_placeholder_bottom%";
		$ProdListString .= "%upcp_pagination_placeholder_bottom%";
		$ProdDetailString .= "%upcp_pagination_placeholder_bottom%";

		/*$ProdThumbString .= "<div class='upcp-clear'></div>\n";
		$ProdListString .= "<div class='upcp-clear'></div>\n";
		$ProdDetailString .= "<div class='upcp-clear'></div>\n";*/
	}

	$ProdThumbString .= "</div>\n";
	$ProdListString .= "</div>\n";
	$ProdDetailString .= "</div>\n";

	if (in_array("Thumbnail", $ExcludedLayouts)) {unset($ProdThumbString);}
	if (in_array("List", $ExcludedLayouts)) {unset($ProdListString);}
	if (in_array("Detail", $ExcludedLayouts)) {unset($ProdDetailString);}

	//Deal with creating the page counter, if pagination is neccessary
	if ($Filtered == "Yes") {$Total_Products = $Product_Count;}
	else {$Total_Products = $Catalogue->Catalogue_Item_Count;}
	$PaginationString = "";
	if ($Total_Products > $products_per_page) {
		$Num_Pages = ceil($Total_Products / $products_per_page);

		$PrevPage = max($current_page - 1, 1);
		$NextPage = min($current_page + 1, $Num_Pages);

		$PaginationString = "<div class='catalogue-nav ";
		$PaginationString .= "upcp-cat-nav-bg-" . $Pagination_Background . " ";
		$PaginationString .= "upcp-cat-nav-border-" . $Pagination_Border . " ";
		$PaginationString .= "upcp-cat-nav-" . $Pagination_Shadow . " ";
		$PaginationString .= "upcp-cat-nav-" . $Pagination_Gradient . " ";
		$PaginationString .= "'>";
		$PaginationString .= "<span class='displaying-num'>" . $Total_Products . $Products_Pagination_Text . "</span>";
		$PaginationString .= "<span class='pagination-links'>";
		$PaginationString .= "<a class='first-page' title='Go to the first page' href='#' onclick='UPCP_DisplayPage(\"1\")'>&#171;</a>";
		$PaginationString .= "<a class='prev-page' title='Go to the previous page' href='#' onclick='UPCP_DisplayPage(\"" . $PrevPage . "\")'>&#8249;</a>";
		$PaginationString .= "<span class='paging-input'>" . $current_page . " " . $Of_Pagination_Label . " " . "<span class='total-pages'>" . $Num_Pages . "</span></span>";
		$PaginationString .= "<a class='next-page' title='Go to the next page' href='#' onclick='UPCP_DisplayPage(\"" . $NextPage . "\")'>&#8250;</a>";
		$PaginationString .= "<a class='last-page' title='Go to the last page' href='#' onclick='UPCP_DisplayPage(\"" . $Num_Pages . "\")'>&#187;</a>";
		$PaginationString .= "</span>";
		$PaginationString .= "</div>";

		if ($current_page == 1) {$PaginationString = str_replace("first-page", "first-page disabled", $PaginationString);}
		if ($current_page == 1) {$PaginationString = str_replace("prev-page", "prev-page disabled", $PaginationString);}
		if ($current_page == $Num_Pages) {$PaginationString = str_replace("next-page", "next-page disabled", $PaginationString);}
		if ($current_page == $Num_Pages) {$PaginationString = str_replace("last-page", "last-page disabled", $PaginationString);}
	}
	if ($Pagination_Location == "Bottom" or $Infinite_Scroll == "Yes") {
		$ProdThumbString = str_replace("%upcp_pagination_placeholder_top%", "", $ProdThumbString);
		$ProdListString = str_replace("%upcp_pagination_placeholder_top%", "", $ProdListString);
		$ProdDetailString = str_replace("%upcp_pagination_placeholder_top%", "", $ProdDetailString);
	}
	if ($Pagination_Location == "Top" or $Infinite_Scroll == "Yes") {
		$ProdThumbString = str_replace("%upcp_pagination_placeholder_bottom%", "", $ProdThumbString);
		$ProdListString = str_replace("%upcp_pagination_placeholder_bottom%", "", $ProdListString);
		$ProdDetailString = str_replace("%upcp_pagination_placeholder_bottom%", "", $ProdDetailString);
	}

	$ProdThumbString = str_replace("%upcp_pagination_placeholder_top%", $PaginationString, $ProdThumbString);
	$ProdListString = str_replace("%upcp_pagination_placeholder_top%", $PaginationString, $ProdListString);
	$ProdDetailString = str_replace("%upcp_pagination_placeholder_top%", $PaginationString, $ProdDetailString);
	$ProdThumbString = str_replace("%upcp_pagination_placeholder_bottom%", $PaginationString, $ProdThumbString);
	$ProdListString = str_replace("%upcp_pagination_placeholder_bottom%", $PaginationString, $ProdListString);
	$ProdDetailString = str_replace("%upcp_pagination_placeholder_bottom%", $PaginationString, $ProdDetailString);

	if ($Infinite_Scroll == "Yes") {
		$Infinite_Scroll_String = "<div class='upcp-infinite-scroll-content-area'>";
		$Infinite_Scroll_String .= "<div class='shortcode-attr upcp-Hide-Item' id='upcp-max-page'>" . $Num_Pages . "</div>";
		$Infinite_Scroll_String .= "</div>";
	}
	else {
		$Infinite_Scroll_String = "";
	}

	// Create string from the arrays, should use the implode function instead
	foreach ($ProdCats as $key=>$value) {$ProdCatString .= $key . ",";}
	$ProdCatString = trim($ProdCatString, " ,");
	foreach ($ProdSubCats as $key=>$value) {$ProdSubCatString .= $key . ",";}
	$ProdSubCatString = trim($ProdSubCatString, " ,");
	foreach ($ProdTags as $key=>$value) {$ProdTagString .= $key . ",";}
	$ProdTagString = trim($ProdTagString, " ,");
	foreach ($ProdCustomFields as $key=>$value) {$ProdCustomFieldsString .= $key . ",";}
	$ProdCustomFieldsString = trim($ProdCustomFieldsString, " ,");

	// If the sidebar is requested, add it
	if (($sidebar == "Yes" or $sidebar == "yes" or $sidebar == "YES") and $only_inner != "Yes") {
		$SidebarString = BuildSidebar($category, $subcategory, $tags, $prod_name);
	}

	if ($Mobile_Style == "Yes") {
		$MobileMenuString .= "<div id='prod-cat-mobile-menu' class='upcp-mobile-menu'>\n";
		$MobileMenuString .= "<div id='prod-cat-mobile-search'>\n";
		if ($Tag_Logic == "OR") {$MobileMenuString .= "<input type='text' id='upcp-mobile-search' class='jquery-prod-name-text mobile-search' name='Mobile_Search' value='" . __('Product Name', 'ultimate-product-catalogue') . "...' onfocus='FieldFocus(this);' onblur='FieldBlur(this);' onkeyup='UPCP_Filer_Results_OR();'>\n";}
		else {$MobileMenuString .= "<input type='text' id='upcp-mobile-search' class='jquery-prod-name-text mobile-search' name='Mobile_Search' value='" . __('Product Name', 'ultimate-product-catalogue') . "...' onfocus='FieldFocus(this);' onblur='FieldBlur(this);'  onkeyup='UPCP_Filer_Results();'>\n";}
		$MobileMenuString .= "</div>";
		$MobileMenuString .= "</div>";
	}

	if ($Show_Catalogue_Information != "None") {
		$HeaderBar .= "<div class='prod-cat-information'>";
		if ($Show_Catalogue_Information == "NameDescription" or $Show_Catalogue_Information == "Name") {
			$HeaderBar .= "<div class='prod-cat-information-name'><h3>";
			$HeaderBar .= $Catalogue->Catalogue_Name;
			$HeaderBar .= "</h3></div>";
		}
		if ($Show_Catalogue_Information == "NameDescription" or $Show_Catalogue_Information == "Description") {
			$HeaderBar .= "<div class='prod-cat-information-description'>";
			$HeaderBar .= do_shortcode($Catalogue->Catalogue_Description);
			$HeaderBar .= "</div>";
		}
		$HeaderBar .= "</div>";
	}

	$HeaderBar .= "<div class='prod-cat-header-div " . $Color . "-prod-cat-header-div'>";
	$HeaderBar .= "<div class='prod-cat-header-padding'></div>";
	$HeaderBar .= "<div id='starting-layout' class='hidden-field'>" . $Starting_Layout . "</div>";
	if (!in_array("Thumbnail", $ExcludedLayouts)) {
		$HeaderBar .= "<a href='#' onclick='ToggleView(\"Thumbnail\");return false;' title='Thumbnail'><div class='upcp-thumb-toggle-icon " . $Color . "-thumb-icon'></div></a>";
	}
	if (!in_array("List", $ExcludedLayouts)) {
		$HeaderBar .= "<a href='#' onclick='ToggleView(\"List\"); return false;' title='List'><div class='upcp-list-toggle-icon " . $Color . "-list-icon'></div></a>";
	}
	if (!in_array("Detail", $ExcludedLayouts)) {
		$HeaderBar .= "<a href='#' onclick='ToggleView(\"Detail\"); return false;' title='Detail'><div class='upcp-details-toggle-icon " . $Color . "-details-icon'></div></a>";
	}
	$HeaderBar .= "<div class='upcp-clear'></div>";
	$HeaderBar .= "</div>";

	$Bottom_JS .= "<script language='JavaScript' type='text/javascript'>";
	if (isset($_GET['Product_ID'])) {$Bottom_JS .= "jQuery(window).load(OpenProduct('" . $_GET['Product_ID'] . "'));";}
	$Bottom_JS .= "</script>";

	if ($only_inner != "Yes") {$InnerString .= "<div class='prod-cat-inner " . $Infinite_Scroll_Class . "'>";}
	$InnerString .= $CatalogAreaTopString . $ProdThumbString . "<div class='upcp-clear'></div>" . $ProdListString . "<div class='upcp-clear'></div>" . $ProdDetailString . "<div class='upcp-clear'></div>" . $Infinite_Scroll_String;
	if ($only_inner != "Yes") {$InnerString .= "</div>";}
	if (function_exists("mb_convert_encoding")) {$InnerString = mb_convert_encoding($InnerString, 'UTF-8');}
	else {$InnerString = htmlspecialchars_decode(utf8_decode(htmlentities($InnerString, ENT_COMPAT, 'utf-8', false)));}

	if ($only_inner == "Yes") {
		if ($Inner_Filter == "Yes") {$InnerString = apply_filters('the_content', $InnerString);}
		$ReturnArray['request_count'] = $request_count;
		$ReturnArray['message'] = $InnerString;

		$PHP_Version = UPCP_Return_PHP_Version();
		if ($PHP_Version > 50400) {return json_encode($ReturnArray, JSON_UNESCAPED_UNICODE);}
		else {return json_encode($ReturnArray);}
	}

	$ProductString .= "<div class='prod-cat-container'>";
	$ProductString .= $HeaderBar;
	$ProductString .= $MobileMenuString;
	$ProductString .= $SidebarString;
	$ProductString .= $InnerString;
	$ProductString .= $Bottom_JS;
	$ProductString .= "<div class='upcp-clear'></div></div>";

	return $ProductString;
}

function Insert_Minimal_Products($atts) {
	global $wpdb, $items_table_name, $catalogue_items_table_name;

	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
				"catalogue_url" => "",
				"product_ids" => "",
				"catalogue_id" => "",
				"catalogue_search" => "rand",
				"category_id" => "",
				"subcategory_id" => "",
				"product_count" => 3,
				"products_wide" => 3),
			$atts
		)
	);

	// If there's a product select, return that product
	if ((get_query_var('single_product') != "" or $_GET['SingleProduct'] != "") and $catalogue_url == "") {
		return do_shortcode("[product-catalogue]");
	}

	$ProductString .= "<div class='upcp-minimal-catalogue upcp-minimal-width-" . $products_wide . "'>";
	if ($product_ids != "") {
		$Product_Array = explode(",", $product_ids);
		foreach ($Product_Array as $Product) {$Products_String .= $Product . ",";}
		$Products_String = substr($Products_String, 0, -1);
		$Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE Item_ID IN (" . $Products_String . ")");
	}
	elseif ($catalogue_id != "") {
		$Item_IDs = "'999999',";
		$Category_IDs = "'999999',";
		$SubCategory_IDs = "'999999',";
		$Catalogue_Items = $wpdb->get_results("SELECT * FROM $catalogue_items_table_name WHERE Catalogue_ID='" . $catalogue_id . "'");
		foreach ($Catalogue_Items as $Catalogue_Item) {
			if ($Catalogue_Item->Item_ID != 0) {$Item_IDs .= "'" . $Catalogue_Item->Item_ID . "',";}
			elseif ($Catalogue_Item->Category_ID != 0) {$Category_IDs .= "'" . $Catalogue_Item->Category_ID . "',";}
			elseif ($Catalogue_Item->SubCategory_ID != 0) {$SubCategory_IDs = "'" . $Catalogue_Item->SubCategory_ID . "',";}
		}
		$Item_IDs = substr($Item_IDs, 0, -1);
		$Category_IDs = substr($Category_IDs, 0, -1);
		$SubCategory_IDs = substr($SubCategory_IDs, 0, -1);
		$Sql = "SELECT * FROM $items_table_name WHERE (Item_ID IN (" . $Item_IDs . ") OR Category_ID IN (" . $Category_IDs . ") OR SubCategory_ID IN (" . $SubCategory_IDs . ")) AND Item_Display_Status!='Hide'";
		if ($catalogue_search == "rand") {$Products = $wpdb->get_results($Sql . " ORDER BY rand() LIMIT " . $product_count);}
		elseif ($catalogue_search == "popular") {$Products = $wpdb->get_results($Sql . " ORDER BY Item_Views DESC LIMIT " . $product_count);}
	}
	elseif ($category_id != "") {
		$Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE  Category_ID='" . $category_id . "' AND Item_Display_Status!='Hide' ORDER BY rand() LIMIT " . $product_count);
	}
	elseif ($subcategory_id != "") {
		$Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE  SubCategory_ID='" . $subcategory_id . "' AND Item_Display_Status!='Hide' ORDER BY rand() LIMIT " . $product_count);
	}
	else {
		$Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE Item_Date_Created!='0000-00-00 00:00:00' AND Item_Display_Status!='Hide' ORDER BY Item_Date_Created ASC LIMIT " . $product_count);
	}
	foreach ($Products as $Product) {
		$ProductString .= "<div class='upcp-insert-product upcp-minimal-product-listing'>";
		$ProductString .= Build_Minimal_Product_Listing($Product, $catalogue_url);
		$ProductString .= "</div>";
	}

	$ProductString .= "</div>";

	return $ProductString;
}
add_shortcode("insert-products", "Insert_Minimal_Products");

/* Function to add the HTML for an individual product to the catalog */
function UPCP_AddProduct($format, $Product_Object, $Tags, $AjaxReload = "No", $AjaxURL = "") {
	// Add the required global variables
	global $wpdb, $categories_table_name, $subcategories_table_name, $tags_table_name, $tagged_items_table_name, $catalogues_table_name, $catalogue_items_table_name, $items_table_name, $item_images_table_name, $item_videos_table_name;
	global $ProdCats, $ProdSubCats, $ProdTags, $ProdCustomFields, $link_base, $UPCP_Options;

	$Catalogue_Style = $UPCP_Options->Get_Option("UPCP_Catalogue_Style");

	$Thumb_Auto_Adjust = $UPCP_Options->Get_Option("UPCP_Thumb_Auto_Adjust");
	$ReadMore = $UPCP_Options->Get_Option("UPCP_Read_More");
	$Links = $UPCP_Options->Get_Option("UPCP_Product_Links");
	$Sale_Mode = $UPCP_Options->Get_Option("UPCP_Sale_Mode");
	$Detail_Desc_Chars = $UPCP_Options->Get_Option("UPCP_Desc_Chars");
	$Product_Comparison = $UPCP_Options->Get_Option("UPCP_Product_Comparison");
	$CF_Conversion = $UPCP_Options->Get_Option("UPCP_CF_Conversion");
	$Thumbnail_Support = $UPCP_Options->Get_Option("UPCP_Thumbnail_Support");

	$Display_Categories_In_Thumbnails = get_option("UPCP_Display_Categories_In_Thumbnails");
	$Display_Tags_In_Thumbnails = get_option("UPCP_Display_Tags_In_Thumbnails");

	$Product_Inquiry_Cart = $UPCP_Options->Get_Option("UPCP_Product_Inquiry_Cart");
	$Catalog_Display_Reviews = $UPCP_Options->Get_Option("UPCP_Catalog_Display_Reviews");
	$WooCommerce_Checkout = $UPCP_Options->Get_Option("UPCP_WooCommerce_Checkout");
	$Lightbox_Mode = $UPCP_Options->Get_Option("UPCP_Lightbox_Mode");

	$WooCommerce_Product_Page = $UPCP_Options->Get_Option("UPCP_WooCommerce_Product_Page");

	$List_View_Click_Action = $UPCP_Options->Get_Option("UPCP_List_View_Click_Action");
	$Details_Icon_Font_Selection = $UPCP_Options->Get_Option("UPCP_Details_Icon_Font_Selection");

	$Pretty_Links = $UPCP_Options->Get_Option("UPCP_Pretty_Links");
	$Permalink_Base = $UPCP_Options->Get_Option("UPCP_Permalink_Base");
	if ($Permalink_Base == "") {$Permalink_Base = "product";}

	$Details_Label = $UPCP_Options->Get_Option("UPCP_Details_Label");
	if ($Details_Label != "") {$Details_Text = $Details_Label;}
	else {$Details_Text = __("Details", 'ultimate-product-catalogue');}
	if ($Details_Label != "") {$More_Images_Label = $Details_Label;}
	else {$More_Images_Label = __("Images", 'ultimate-product-catalogue');}
	if ($UPCP_Options->Get_Option("UPCP_Read_More_Label") != "") {$Read_More_Label = $UPCP_Options->Get_Option("UPCP_Read_More_Label");}
	else {$Read_More_Label = __("Read More", 'ultimate-product-catalogue');}
	$Inquire_Button_Label = $UPCP_Options->Get_Option("UPCP_Inquire_Button_Label");
	if($Inquire_Button_Label == ""){$Inquire_Button_Label = __('Inquire', 'ultimate-product-catalogue');}
	$Add_To_Cart_Button_Label = $UPCP_Options->Get_Option("UPCP_Add_To_Cart_Button_Label");
	if($Add_To_Cart_Button_Label == ""){$Add_To_Cart_Button_Label = __('Add to Cart', 'ultimate-product-catalogue');}
	$Sale_Label = $UPCP_Options->Get_Option("UPCP_Sale_Label");
	if ($Sale_Label == "") {$Sale_Label = __("Sale", 'ultimate-product-catalogue');}
	$Compare_Label = $UPCP_Options->Get_Option("UPCP_Compare_Label");
	if ($Compare_Label == "") {$Compare_Label = __("Compare", 'ultimate-product-catalogue');}

	if ($Links == "New") {$NewWindowCode = "target='_blank'";}
	else {$NewWindowCode = "";}

	if ($Lightbox_Mode == "Yes") {$Lightbox_Mode_Class = "upcp-lightbox-mode";}
	else {$Lightbox_Mode_Class = "";}

	$Item_Price = $Product_Object->Get_Product_Price("Currency");
	$Item_Regular_Price = $Product_Object->Get_Product_Price("Currency", "Regular");
	$Item_Display_Price = $Product_Object->Get_Product_Price("Display");

	if ($Catalog_Display_Reviews == "Yes") {$ReviewsHTML = UPCP_Get_Reviews_HTML($Product_Object->Get_Field_Value('Item_Name'));}

	if ($CF_Conversion != "No") {$Description = ConvertCustomFields($Product_Object->Get_Field_Value('Item_Description'), $Product_Object->Get_Item_ID());}
	else {$Description = $Product_Object->Get_Field_Value('Item_Description');}
	$Description = apply_filters('upcp_description_filter', str_replace("[upcp-price]", $Item_Price, $Description), array("Item_ID" => $Product_Object->Get_Item_ID()));

	//Select the product info, tags and images for the product
	$Item_Images = $wpdb->get_results("SELECT Item_Image_URL, Item_Image_ID FROM $item_images_table_name WHERE Item_ID=" . $Product_Object->Get_Item_ID() . " ORDER BY Item_Image_Order");
	$TagsString = "";

	if ($Product_Object->Get_Field_Value('Item_Photo_URL') != "" and strlen($Product_Object->Get_Field_Value('Item_Photo_URL')) > 7 and substr($Product_Object->Get_Field_Value('Item_Photo_URL'), 0, 7) != "http://" and substr($Product_Object->Get_Field_Value('Item_Photo_URL'), 0, 8) != "https://") {
		$PhotoCode = $Product_Object->Get_Field_Value('Item_Photo_URL');
		$PhotoCode = do_shortcode($PhotoCode);
	}
	elseif ($Product_Object->Get_Field_Value('Item_Photo_URL') != "" and strlen($Product_Object->Get_Field_Value('Item_Photo_URL')) > 7) {
		$PhotoURL = htmlspecialchars($Product_Object->Get_Field_Value('Item_Photo_URL'), ENT_QUOTES);
		if ($Thumbnail_Support == "Yes") {
			$Post_ID = UPCP_getIDfromGUID($PhotoURL);
			if ($Post_ID != "") {$PhotoURL_Array = wp_get_attachment_image_src($Post_ID, "medium"); $PhotoURL = $PhotoURL_Array[0];}
		}
		$PhotoCode = "<img src='" . $PhotoURL . "' alt='" . $Product_Object->Get_Field_Value('Item_Name') . " Image' id='prod-cat-thumb-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-thumb-image upcp-thumb-image'>";
	}
	else {
		$PhotoURL = plugins_url('ultimate-product-catalogue/images/No-Photo-Available.png');
		$PhotoCode = "<img src='" . $PhotoURL . "' alt='" . $Product_Object->Get_Field_Value('Item_Name') . " Image' id='prod-cat-thumb-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-thumb-image upcp-thumb-image'>";
	}

	//Create the tag string for filtering
	foreach ($Tags as $Tag) {$TagsString .= $Tag->Tag_ID . ", ";}
	$TagsString = trim($TagsString, " ,");

	$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
	if (!array_key_exists(1, $uri_parts)) {$uri_parts[1] = '';}

	if ($AjaxReload == "Yes") {$Base = $AjaxURL;}
	else {$Base = $uri_parts[0];}
	if (trim($Product_Object->Get_Field_Value('Item_Link')) != "") {$ItemLink = $Product_Object->Get_Field_Value('Item_Link');}
	elseif ($WooCommerce_Product_Page == "Yes") {$ItemLink = get_site_url() . "/product/" . $Product_Object->Get_Field_Value('Item_Slug') . "/";}
	elseif ($link_base != "") {$ItemLink = $link_base . "?" . $uri_parts[1] . "&SingleProduct=" . $Product_Object->Get_Item_ID();}
	elseif ($Pretty_Links == "Yes") {$ItemLink = $Base . $Permalink_Base . "/" . $Product_Object->Get_Field_Value('Item_Slug') . "/?" . $uri_parts[1];}
	else {$ItemLink = $Base . "?" . $uri_parts[1] . "&SingleProduct=" . $Product_Object->Get_Item_ID();}

	//Create the listing for the thumbnail layout display
	$ProductString = '';
	if ($format == "Thumbnail") {
		$ProductString .= "<div id='prod-cat-thumb-item-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-item upcp-thumb-item " . $Lightbox_Mode_Class . " " . ($Thumb_Auto_Adjust == "Yes" ? 'upcp-thumb-adjust-height' : '') ."' data-itemid='" . $Product_Object->Get_Item_ID() . "'>\n";
		$ProductString .= "<div id='prod-cat-thumb-div-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-thumb-image-div upcp-thumb-image-div'>";
		if($Catalogue_Style == "contemporary" || $Catalogue_Style == "showcase"){
			$ProductString .= "<div class='prod-cat-contemporary-hover-div'>";
				if($WooCommerce_Checkout == "Yes"){
					$ProductString .= "<div class='prod-cat-contemporary-hover-button prod-cat-contemporary-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Add_To_Cart_Button_Label ."</div>";
				}
				elseif($Product_Inquiry_Cart == "Yes"){
					$ProductString .= "<div class='prod-cat-contemporary-hover-button prod-cat-contemporary-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Inquire_Button_Label ."</div>";
				}
				else{}
				$ProductString .= "<a class='prod-cat-contemporary-hover-button upcp-catalogue-link" . ( ($WooCommerce_Checkout != "Yes" && $Product_Inquiry_Cart != "Yes") ? " prod-cat-contemporary-hover-button-bigger-margin" : "" ) . "' href='" . $ItemLink . "'" . ($Links == "New" ? " target='_blank'" : "") . "><span>y</span>" . $Details_Text . "</a>";
			$ProductString .= "</div>";
		}
		if($Catalogue_Style == "main-minimalist"){
			$ProductString .= "<div class='prod-cat-minimalist-hover-div'>";
				if($WooCommerce_Checkout == "Yes"){
					$ProductString .= "<div class='prod-cat-minimalist-hover-button prod-cat-minimalist-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Add_To_Cart_Button_Label ."</div>";
				}
				elseif($Product_Inquiry_Cart == "Yes"){
					$ProductString .= "<div class='prod-cat-minimalist-hover-button prod-cat-minimalist-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Inquire_Button_Label ."</div>";
				}
				else{}
				$ProductString .= "<a class='prod-cat-minimalist-hover-button upcp-catalogue-link" . ( ($WooCommerce_Checkout != "Yes" && $Product_Inquiry_Cart != "Yes") ? " prod-cat-minimalist-hover-button-bigger-margin" : "" ) . "' href='" . $ItemLink . "'" . ($Links == "New" ? " target='_blank'" : "") . "><span>y</span>" . $Details_Text . "</a>";
			$ProductString .= "</div>";
		}
		if ($Product_Comparison == "Yes") {$ProductString .= "<div class='upcp-product-comparison-button' data-prodid='" . $Product_Object->Get_Item_ID() . "' data-prodname='" . $Product_Object->Get_Field_Value('Item_Name') ."'><span class='compareSpan'>" . $Compare_Label . "</span></div>";}
		if (($Sale_Mode == "All" and $Item_Price != $Item_Regular_Price) or ($Sale_Mode == "Individual" and $Product_Object->Get_Field_Value('Item_Sale_Mode') == "Yes")) {$ProductString .= "<div class='upcp-sale-flag'><span class='saleSpan'>" . $Sale_Label . "</span></div>";}
		$ProductString .= "<a class='upcp-catalogue-link " . ($Lightbox_Mode == "Yes" ? "disableLink" : "") . "' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
		$ProductString .= apply_filters('upcp_image_div', $PhotoCode, array('Item_ID' => $Product_Object->Get_Item_ID(), 'Image_URL' => $Product_Object->Get_Field_Value('Item_Photo_URL'), 'Layout' => $format));
		$ProductString .= "</a>";
		$ProductString .= "</div>\n";
		$ProductString .= "<div id='prod-cat-title-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-title upcp-thumb-title'>";
		if ($Catalog_Display_Reviews == "Yes") {$ProductString .= $ReviewsHTML;}
		$ProductString .= "<a class='upcp-catalogue-link no-underline " . ($Lightbox_Mode == "Yes" ? "disableLink" : "") . "' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>" . apply_filters('upcp_title_div', $Product_Object->Get_Field_Value('Item_Name'), array('Item_ID' => $Product_Object->Get_Item_ID(), 'Item_Title' => $Product_Object->Get_Field_Value('Item_Name'), 'Layout' => $format)) . "</a>";

		if($Display_Categories_In_Thumbnails == 'Yes' && $Product_Object->Get_Field_Value('Category_Name') != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-thumb-display-categories'>";
				$ProductString .= "<span class='upcp-display-category-label'>" . __("Category: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $Product_Object->Get_Field_Value('Category_Name');
			$ProductString .= "</div>\n";
		}
		if($Display_Categories_In_Thumbnails == 'Yes' && $Product_Object->Get_Field_Value('SubCategory_Name') != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-thumb-display-subcategories'>";
				$ProductString .= "<span class='upcp-display-subcategory-label'>" . __("Sub-Category: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $Product_Object->Get_Field_Value('SubCategory_Name');
			$ProductString .= "</div>\n";
		}
		$thumbnailTags = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $Product_Object->Get_Item_ID());
		if (is_array($thumbnailTags)) {
			foreach ($thumbnailTags as $thumbnailTag) {
				$thumbnailTagInfo = $wpdb->get_row("SELECT Tag_Name FROM $tags_table_name WHERE Tag_ID=" . $thumbnailTag->Tag_ID);
				$thumbnailTagsString .= $thumbnailTagInfo->Tag_Name . ", ";
			}
		}
		$thumbnailTagsString = trim($thumbnailTagsString, " ,");
		if($Display_Tags_In_Thumbnails == 'Yes' && $thumbnailTagsString != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-thumb-display-tags'>";
				$ProductString .= "<span class='upcp-display-tags-label'>" . __("Tags: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $thumbnailTagsString;
			$ProductString .= "</div>\n";
		}

		$ProductString .= AddCustomFields($Product_Object->Get_Item_ID(), "thumbs");
		$ProductString .= "</div>\n";
		$ProductString .= apply_filters('upcp_price_div', "<div id='prod-cat-price-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-price upcp-thumb-price'>" . $Item_Display_Price . "</div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Item_Price' => $Item_Price, 'Layout' => $format)) . "\n";
		if ($WooCommerce_Checkout == "Yes") {$ProductString .= "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-thumb-details-link upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span class='upcp-details-text'>" . $Add_To_Cart_Button_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>\n";}
		elseif ($Product_Inquiry_Cart == "Yes") {$ProductString .= "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-thumb-details-link upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span class='upcp-details-text'>" . $Inquire_Button_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>\n";}
		else {
			$ProductString .= "<a class='upcp-catalogue-link " . ($Lightbox_Mode == "Yes" ? "disableLink" : "") . "' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
			$ProductString .= apply_filters('upcp_details_link_div', "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-thumb-details-link'><span class='upcp-details-text'>" . $Details_Text . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Layout' => $format)) ."\n";
			$ProductString .= "</a>";
		}
	}
	//Create the listing for the list layout display
	if ($format == "List") {
		$ProductString .= "<div id='prod-cat-list-item-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-item upcp-list-item " . $Lightbox_Mode_Class . "' data-itemid='" . $Product_Object->Get_Item_ID() . "'>\n";
		if ($Catalog_Display_Reviews == "Yes") {$ProductString .= $ReviewsHTML;}
		$ProductString .= apply_filters('upcp_title_div', "<div id='prod-cat-title-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-title upcp-list-title upcp-list-action-" . $List_View_Click_Action . "' onclick='ToggleItem(" . $Product_Object->Get_Item_ID() . ");'>" . $Product_Object->Get_Field_Value('Item_Name') . "</div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Item_Title' => $Product_Object->Get_Field_Value('Item_Name'), 'Layout' => $format)) . "\n";
		$ProductString .= "<div id='prod-cat-price-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-price upcp-list-price' onclick='ToggleItem(" . $Product_Object->Get_Item_ID() . ");'>" . $Item_Display_Price. "</div>\n";
		$ProductString .= "<div id='prod-cat-details-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details upcp-list-details hidden-field'>\n";
		$ProductString .= "<div id='prod-cat-thumb-div-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-thumb-image-div upcp-list-image-div'>";
		if($Catalogue_Style == "contemporary" || $Catalogue_Style == "showcase"){
			$ProductString .= "<div class='prod-cat-contemporary-hover-div'>";
				if($WooCommerce_Checkout == "Yes"){
					$ProductString .= "<div class='prod-cat-contemporary-hover-button prod-cat-contemporary-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Add_To_Cart_Button_Label ."</div>";
				}
				elseif($Product_Inquiry_Cart == "Yes"){
					$ProductString .= "<div class='prod-cat-contemporary-hover-button prod-cat-contemporary-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Inquire_Button_Label ."</div>";
				}
				else{}
				$ProductString .= "<a class='prod-cat-contemporary-hover-button upcp-catalogue-link" . ( ($WooCommerce_Checkout != "Yes" && $Product_Inquiry_Cart != "Yes") ? " prod-cat-contemporary-hover-button-bigger-margin" : "" ) . "' href='" . $ItemLink . "'" . ($Links == "New" ? " target='_blank'" : "") . "><span>y</span>" . $Details_Text . "</a>";
			$ProductString .= "</div>";
		}
		if($Catalogue_Style == "main-minimalist"){
			$ProductString .= "<div class='prod-cat-minimalist-hover-div'>";
				if($WooCommerce_Checkout == "Yes"){
					$ProductString .= "<div class='prod-cat-minimalist-hover-button prod-cat-minimalist-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Add_To_Cart_Button_Label ."</div>";
				}
				elseif($Product_Inquiry_Cart == "Yes"){
					$ProductString .= "<div class='prod-cat-minimalist-hover-button prod-cat-minimalist-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Inquire_Button_Label ."</div>";
				}
				else{}
				$ProductString .= "<a class='prod-cat-minimalist-hover-button upcp-catalogue-link" . ( ($WooCommerce_Checkout != "Yes" && $Product_Inquiry_Cart != "Yes") ? " prod-cat-minimalist-hover-button-bigger-margin" : "" ) . "' href='" . $ItemLink . "'" . ($Links == "New" ? " target='_blank'" : "") . "><span>y</span>" . $Details_Text . "</a>";
			$ProductString .= "</div>";
		}
		if ($Product_Comparison == "Yes") {$ProductString .= "<div class='upcp-product-comparison-button' data-prodid='" . $Product_Object->Get_Item_ID() . "' data-prodname='" . $Product_Object->Get_Field_Value('Item_Name') ."'><span class='compareSpan'>" . $Compare_Label . "</span></div>";}
		if (($Sale_Mode == "All" and $Item_Price != $Item_Regular_Price) or ($Sale_Mode == "Individual" and $Product_Object->Get_Field_Value('Item_Sale_Mode') == "Yes")) {$ProductString .= "<div class='upcp-sale-flag'><span class='saleSpan'>" . $Sale_Label . "</span></div>";}
		$ProductString .= "<a class='upcp-catalogue-link' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
		$ProductString .= apply_filters('upcp_image_div', $PhotoCode, array('Item_ID' => $Product_Object->Get_Item_ID(), 'Image_URL' => $Product_Object->Get_Field_Value('Item_Photo_URL'), 'Layout' => $format));
		$ProductString .= "</a>";
		$ProductString .= "</div>\n";
		$ProductString .= "<div id='prod-cat-desc-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-desc upcp-list-desc'>" . $Description . "</div>\n";

		if($Display_Categories_In_Thumbnails == 'Yes' && $Product_Object->Get_Field_Value('Category_Name') != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-details-display-categories'>";
				$ProductString .= "<span class='upcp-display-category-label'>" . __("Category: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $Product_Object->Get_Field_Value('Category_Name');
			$ProductString .= "</div>\n";
		}
		if($Display_Categories_In_Thumbnails == 'Yes' && $Product_Object->Get_Field_Value('SubCategory_Name') != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-details-display-subcategories'>";
				$ProductString .= "<span class='upcp-display-subcategory-label'>" . __("Sub-Category: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $Product_Object->Get_Field_Value('SubCategory_Name');
			$ProductString .= "</div>\n";
		}
		$thumbnailTags = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $Product_Object->Get_Item_ID());
		if (is_array($thumbnailTags)) {
			foreach ($thumbnailTags as $thumbnailTag) {
				$thumbnailTagInfo = $wpdb->get_row("SELECT Tag_Name FROM $tags_table_name WHERE Tag_ID=" . $thumbnailTag->Tag_ID);
				$thumbnailTagsString .= $thumbnailTagInfo->Tag_Name . ", ";
			}
		}
		$thumbnailTagsString = trim($thumbnailTagsString, " ,");
		if($Display_Tags_In_Thumbnails == 'Yes' && $thumbnailTagsString != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-details-display-tags'>";
				$ProductString .= "<span class='upcp-display-tags-label'>" . __("Tags: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $thumbnailTagsString;
			$ProductString .= "</div>\n";
		}

		$ProductString .= AddCustomFields($Product_Object->Get_Item_ID(), "list");
		if ($WooCommerce_Checkout == "Yes") {$ProductString .= "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-list-details-link upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span class='upcp-details-text'>" . $Add_To_Cart_Button_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>\n";}
		elseif ($Product_Inquiry_Cart == "Yes") {$ProductString .= "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-list-details-link upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span class='upcp-details-text'>" . $Inquire_Button_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>\n";}
		else {
			$ProductString .= "<a class='upcp-catalogue-link' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
			$ProductString .= apply_filters('upcp_details_link_div', "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-list-details-link'><span class='upcp-details-text'>" . $More_Images_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Layout' => $format)) . "\n";
			$ProductString .= "</a>";
		}
		$ProductString .= "</div>";
	}
	//Create the listing for the detail layout display
	if ($format == "Detail") {
		$ProductString .= "<div id='prod-cat-detail-item-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-item upcp-detail-item " . $Lightbox_Mode_Class . "' data-itemid='" . $Product_Object->Get_Item_ID() . "'>\n";
		$ProductString .= "<div id='prod-cat-detail-div-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-thumb-image-div upcp-detail-image-div'>";
		if($Catalogue_Style == "contemporary" || $Catalogue_Style == "showcase"){
			$ProductString .= "<div class='prod-cat-contemporary-hover-div'>";
				if($WooCommerce_Checkout == "Yes"){
					$ProductString .= "<div class='prod-cat-contemporary-hover-button prod-cat-contemporary-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Add_To_Cart_Button_Label ."</div>";
				}
				elseif($Product_Inquiry_Cart == "Yes"){
					$ProductString .= "<div class='prod-cat-contemporary-hover-button prod-cat-contemporary-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Inquire_Button_Label ."</div>";
				}
				else{}
				$ProductString .= "<a class='prod-cat-contemporary-hover-button upcp-catalogue-link" . ( ($WooCommerce_Checkout != "Yes" && $Product_Inquiry_Cart != "Yes") ? " prod-cat-contemporary-hover-button-bigger-margin" : "" ) . "' href='" . $ItemLink . "'" . ($Links == "New" ? " target='_blank'" : "") . "><span>y</span>" . $Details_Text . "</a>";
			$ProductString .= "</div>";
		}
		if($Catalogue_Style == "main-minimalist"){
			$ProductString .= "<div class='prod-cat-minimalist-hover-div'>";
				if($WooCommerce_Checkout == "Yes"){
					$ProductString .= "<div class='prod-cat-minimalist-hover-button prod-cat-minimalist-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Add_To_Cart_Button_Label ."</div>";
				}
				elseif($Product_Inquiry_Cart == "Yes"){
					$ProductString .= "<div class='prod-cat-minimalist-hover-button prod-cat-minimalist-first-hover-button upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span>C</span>" . $Inquire_Button_Label ."</div>";
				}
				else{}
				$ProductString .= "<a class='prod-cat-minimalist-hover-button upcp-catalogue-link" . ( ($WooCommerce_Checkout != "Yes" && $Product_Inquiry_Cart != "Yes") ? " prod-cat-minimalist-hover-button-bigger-margin" : "" ) . "' href='" . $ItemLink . "'" . ($Links == "New" ? " target='_blank'" : "") . "><span>y</span>" . $Details_Text . "</a>";
			$ProductString .= "</div>";
		}
		if ($Product_Comparison == "Yes") {$ProductString .= "<div class='upcp-product-comparison-button' data-prodid='" . $Product_Object->Get_Item_ID() . "' data-prodname='" . $Product_Object->Get_Field_Value('Item_Name') ."'><span class='compareSpan'>" . $Compare_Label . "</span></div>";}
		if (($Sale_Mode == "All" and $Item_Price != $Item_Regular_Price) or ($Sale_Mode == "Individual" and $Product_Object->Get_Field_Value('Item_Sale_Mode') == "Yes")) {$ProductString .= "<div class='upcp-sale-flag'><span class='saleSpan'>" . $Sale_Label . "</span></div>";}
		$ProductString .= "<a class='upcp-catalogue-link' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
		$ProductString .= apply_filters('upcp_image_div', $PhotoCode, array('Item_ID' => $Product_Object->Get_Item_ID(), 'Image_URL' => $Product_Object->Get_Field_Value('Item_Photo_URL'), 'Layout' => $format));
		$ProductString .= "</a>";
		$ProductString .= "</div>\n";
		$ProductString .= "<div id='prod-cat-mid-div-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-mid-detail-div upcp-mid-detail-div'>";
		if ($Catalog_Display_Reviews == "Yes") {$ProductString .= $ReviewsHTML;}
		$ProductString .= "<a class='upcp-catalogue-link' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
		$ProductString .= apply_filters('upcp_title_div', "<div id='prod-cat-title-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-title upcp-detail-title'>" . $Product_Object->Get_Field_Value('Item_Name') . "</div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Item_Title' => $Product_Object->Get_Field_Value('Item_Name'), 'Layout' => $format)) . "\n";
		$ProductString .= "</a>";
		if ($ReadMore == "Yes") {$ProductString .= "<div id='prod-cat-desc-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-desc upcp-detail-desc'>" . strip_tags(substr($Description, 0, $Detail_Desc_Chars));}
		else {$ProductString .= "<div id='prod-cat-desc-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-desc upcp-detail-desc'>" . strip_tags($Description);}
		if ($ReadMore == "Yes") {
			if (strlen($Description) > $Detail_Desc_Chars) {
				$ProductString .= "... <a class='upcp-catalogue-link' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>" . $Read_More_Label . "</a>";
			}
		}

		if($Display_Categories_In_Thumbnails == 'Yes' && $Product_Object->Get_Field_Value('Category_Name') != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-list-display-categories'>";
				$ProductString .= "<span class='upcp-display-category-label'>" . __("Category: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $Product_Object->Get_Field_Value('Category_Name');
			$ProductString .= "</div>\n";
		}
		if($Display_Categories_In_Thumbnails == 'Yes' && $Product_Object->Get_Field_Value('SubCategory_Name') != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-list-display-subcategories'>";
				$ProductString .= "<span class='upcp-display-subcategory-label'>" . __("Sub-Category: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $Product_Object->Get_Field_Value('SubCategory_Name');
			$ProductString .= "</div>\n";
		}
		$thumbnailTags = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $Product_Object->Get_Item_ID());
		if (is_array($thumbnailTags)) {
			foreach ($thumbnailTags as $thumbnailTag) {
				$thumbnailTagInfo = $wpdb->get_row("SELECT Tag_Name FROM $tags_table_name WHERE Tag_ID=" . $thumbnailTag->Tag_ID);
				$thumbnailTagsString .= $thumbnailTagInfo->Tag_Name . ", ";
			}
		}
		$thumbnailTagsString = trim($thumbnailTagsString, " ,");
		if($Display_Tags_In_Thumbnails == 'Yes' && $thumbnailTagsString != ''){
			$ProductString .= "<div class='prod-cat-display-categories-tags upcp-list-display-tags'>";
				$ProductString .= "<span class='upcp-display-tags-label'>" . __("Tags: ", "ultimate-product-catalogue") . "</span>";
				$ProductString .= $thumbnailTagsString;
			$ProductString .= "</div>\n";
		}

		$ProductString .= AddCustomFields($Product_Object->Get_Item_ID(), "details");
		$ProductString .= "</div>\n";
		$ProductString .= "</div>";
		$ProductString .= "<div id='prod-cat-end-div-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-end-detail-div upcp-end-detail-div'>";
		$ProductString .= apply_filters('upcp_price_div', "<div id='prod-cat-price-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-price upcp-detail-price'>" . $Item_Display_Price . "</div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Item_Price' => $Item_Price, 'Layout' => $format)) . "\n";
		if ($WooCommerce_Checkout == "Yes") {$ProductString .= "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-detail-details-link upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span class='upcp-details-text'>" . $Add_To_Cart_Button_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>\n";}
		elseif ($Product_Inquiry_Cart == "Yes") {$ProductString .= "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-detail-details-link upcp-product-interest-button upcp-inquire-button' data-prodid='" . $Product_Object->Get_Item_ID() . "'><span class='upcp-details-text'>" . $Inquire_Button_Label . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>\n";}
		else {
			$ProductString .= "<a class='upcp-catalogue-link' " . $NewWindowCode . " href='" . $ItemLink . "' onclick='RecordView(" . $Product_Object->Get_Item_ID() . ");'>";
			$ProductString .= apply_filters('upcp_details_link_div', "<div id='prod-cat-details-link-" . $Product_Object->Get_Item_ID() . "' class='prod-cat-details-link upcp-detail-details-link'><span class='upcp-details-text'>" . $Details_Text . "</span><span class='upcp-details-icon'>" . $Details_Icon_Font_Selection . "</span></div>", array('Item_ID' => $Product_Object->Get_Item_ID(), 'Layout' => $format)) . "\n";
			$ProductString .= "</a>";
		}
		$ProductString .= "</div>";
	}

	$ProductString .= "</div>\n";

	return $ProductString;
}

function SingleProductPage() {
	global $wpdb, $items_table_name, $item_images_table_name, $fields_table_name, $fields_meta_table_name, $tagged_items_table_name, $tags_table_name, $tag_groups_table_name, $item_videos_table_name;
	global $link_base;
	global $UPCP_Options;

	$Currency_Symbol = $UPCP_Options->Get_Option("UPCP_Currency_Symbol");
	$Currency_Symbol_Location = $UPCP_Options->Get_Option("UPCP_Currency_Symbol_Location");
	$Pretty_Links = $UPCP_Options->Get_Option("UPCP_Pretty_Links");
	$Filter_Title = $UPCP_Options->Get_Option("UPCP_Filter_Title");
	$Extra_Elements_String = $UPCP_Options->Get_Option("UPCP_Extra_Elements");
	$Extra_Elements = explode(",", $Extra_Elements_String);
	$Single_Page_Price = $UPCP_Options->Get_Option("UPCP_Single_Page_Price");
	$Thumbnail_Support = $UPCP_Options->Get_Option("UPCP_Thumbnail_Support");
	$Custom_Product_Page = $UPCP_Options->Get_Option("UPCP_Custom_Product_Page");
	$Lightbox = $UPCP_Options->Get_Option("UPCP_Lightbox");
	$Product_Inquiry_Form = $UPCP_Options->Get_Option("UPCP_Product_Inquiry_Form");
	$Product_Reviews = $UPCP_Options->Get_Option("UPCP_Product_Reviews");
	$Related_Type = $UPCP_Options->Get_Option("UPCP_Related_Products");
	$Next_Previous = $UPCP_Options->Get_Option("UPCP_Next_Previous");
	$Product_Page_Serialized = $UPCP_Options->Get_Option("UPCP_Product_Page_Serialized");
	$Mobile_Product_Page_Serialized = $UPCP_Options->Get_Option("UPCP_Product_Page_Serialized_Mobile");
	$PP_Grid_Width = $UPCP_Options->Get_Option("UPCP_PP_Grid_Width");
	$PP_Grid_Height = $UPCP_Options->Get_Option("UPCP_PP_Grid_Height");
	$Top_Bottom_Padding = $UPCP_Options->Get_Option("UPCP_Top_Bottom_Padding");
	$Left_Right_Padding = $UPCP_Options->Get_Option("UPCP_Left_Right_Padding");
	$CF_Conversion = $UPCP_Options->Get_Option("UPCP_CF_Conversion");
	$Tabs_Array = $UPCP_Options->Get_Option("UPCP_Tabs_Array");
	$Starting_Tab = $UPCP_Options->Get_Option("UPCP_Starting_Tab");
	$Custom_Fields_Blank = $UPCP_Options->Get_Option("UPCP_Custom_Fields_Blank");

	$Permalink_Base = $UPCP_Options->Get_Option("UPCP_Permalink_Base");
	if ($Permalink_Base == "") {$Permalink_Base = "product";}
	$Permalink_Base_Length = strlen($Permalink_Base);

	$TagGroupName = "";
	$Additional_Info_Category_Label = $UPCP_Options->Get_Option("UPCP_Additional_Info_Category_Label");
	if($Additional_Info_Category_Label == ""){$Additional_Info_Category_Label = __("Category:", 'ultimate-product-catalogue');}
	$Additional_Info_SubCategory_Label = $UPCP_Options->Get_Option("UPCP_Additional_Info_SubCategory_Label");
	if($Additional_Info_SubCategory_Label == ""){$Additional_Info_SubCategory_Label = __("Sub-Category:", 'ultimate-product-catalogue');}
	$Additional_Info_Tags_Label = $UPCP_Options->Get_Option("UPCP_Additional_Info_Tags_Label");
	if($Additional_Info_Tags_Label == ""){$Additional_Info_Tags_Label = __("Tags:", 'ultimate-product-catalogue');}

	$Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

	if ($Pretty_Links == "Yes") {$Product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_Slug=%s", trim(get_query_var('single_product'), "/? ")));}
	else {$Product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_ID='%d'", $_GET['SingleProduct']));}
	$Item_Images = $wpdb->get_results("SELECT Item_Image_URL, Item_Image_ID FROM $item_images_table_name WHERE Item_ID=" . $Product->Item_ID . " ORDER BY Item_Image_Order");
	$Item_Videos = $wpdb->get_results("SELECT * FROM $item_videos_table_name WHERE Item_ID='" . $Product->Item_ID . "' ORDER BY Item_Video_Order ASC");

	$Product_Object = new UPCP_Product(array('ID' => $Product->Item_ID));
	$Item_Display_Price = $Product_Object->Get_Product_Price("Display");

	foreach ($Item_Images as $Image) {
		if ($Thumbnail_Support == "Yes") {
		    $Image_ID = UPCP_getIDfromGUID($Image->Item_Image_URL);
		    if ($Image_ID != "") {
		        $Product_Array = wp_get_attachment_image_src($Image_ID, "large");
		        $Image->Item_Image_URL = $Product_Array[0];
		        $Image->Title = UPCP_Get_Image_Title($Image_ID);
		        $Image->Caption = UPCP_Get_Image_Caption($Image_ID);
		    }
		}
	}

	$Links = $UPCP_Options->Get_Option("UPCP_Product_Links");
	if ($CF_Conversion != "No") {$Description = ConvertCustomFields($Product->Item_Description, $Product->Item_ID);}
	else {$Description = $Product->Item_Description;}
	$Description = apply_filters('upcp_product_page_description', str_replace("[upcp-price]", $Item_Display_Price, do_shortcode($Description)), array('Item_ID' => $Product->Item_ID));

	//Edit the title if that option has been selected
	if ($Filter_Title == "Yes") {
		add_action( 'init', 'UPCP_Filter_Title', 20, $Product->Item_Name);
	}

	//Create the tag string for filtering
	$TagsString = "";
	$PhotoCode = "";
	$Tags = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=" . $Product->Item_ID);
	if (is_array($Tags)) {
		foreach ($Tags as $Tag) {
			$TagInfo = $wpdb->get_row("SELECT Tag_Name FROM $tags_table_name WHERE Tag_ID=" . $Tag->Tag_ID);
			$TagsString .= $TagInfo->Tag_Name . ", ";
		}
	}
	$TagsString = trim($TagsString, " ,");
	$PhotoCodeMobile = "";

	if ($Product->Item_Photo_URL != "" and strlen($Product->Item_Photo_URL) > 7 and substr($Product->Item_Photo_URL, 0, 7) != "http://" and substr($Product->Item_Photo_URL, 0, 8) != "https://") {
		$PhotoCode = $Product->Item_Photo_URL;
		$PhotoCode = do_shortcode($PhotoCode);
	}
	elseif ($Product->Item_Photo_URL != "" and strlen($Product->Item_Photo_URL) > 7) {
		$PhotoURL = htmlspecialchars($Product->Item_Photo_URL, ENT_QUOTES);
		if ($Thumbnail_Support == "Yes") {
			$Post_ID = UPCP_getIDfromGUID($PhotoURL);
			if ($Post_ID != "") {
				$PhotoURL_Array = wp_get_attachment_image_src($Post_ID, "large");
				$PhotoURL = $PhotoURL_Array[0];
			}
		}
		$PhotoCode .= "<img src='" . $PhotoURL . "' alt='" . $Product->Item_Name . " Image' id='prod-cat-addt-details-main-" . $Product->Item_ID . "' class='prod-cat-addt-details-main' itemprop='image'>";
		$PhotoCodeMobile .= "<img src='" . $PhotoURL . "' alt='" . $Product->Item_Name . " Image' id='prod-cat-addt-details-main-mobile-" . $Product->Item_ID . "' class='prod-cat-addt-details-main'>";
	}
	else {
		$PhotoURL = plugins_url('ultimate-product-catalogue/images/No-Photo-Available.png');
		$PhotoCode .= "<img src='" . $PhotoURL . "' alt='" . $Product->Item_Name . " Image' id='prod-cat-addt-details-main-" . $Product->Item_ID . "' class='prod-cat-addt-details-main'>";
		$PhotoCodeMobile .= "<img src='" . $PhotoURL . "' alt='" . $Product->Item_Name . " Image' id='prod-cat-addt-details-main-mobile-" . $Product->Item_ID . "' class='prod-cat-addt-details-main'>";
	}

	if ($Lightbox == "Yes") {
		$Lightbox_Clicker_Class = "ewd-ulb-open-lightbox";
		$Lightbox_Class = "ewd-ulb-lightbox";
	}
	elseif ($Lightbox == "Main") {
		$Lightbox_Clicker_Class = "ewd-ulb-open-lightbox";
		$Lightbox_Class = "ewd-ulb-lightbox-noclick-image";
	}
	else {
		$Lightbox_Clicker_Class = "";
		$Lightbox_Class = "";
	}

	$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
	$SP_Perm_URL = $uri_parts[0] . "?" . $uri_parts[1];
	$Return_URL = $uri_parts[0];
	if ($link_base != "") {$Return_URL = $link_base;}
	elseif ($Pretty_Links == "Yes") {$Return_URL = substr($uri_parts[0], 0, strrpos($uri_parts[0], "/", -2)-$Permalink_Base_Length-1) . "/?" . $uri_parts[1];}
	elseif (strpos($uri_parts[1],  "page_id") !== false) {$Return_URL .= "?" . substr($uri_parts[1], 0, strpos($uri_parts[1], "&"));}

	if ($uri_parts[1] == "") {$SP_Perm_URL .= "Product_ID=" . $Product->Item_ID;}
	else {$SP_Perm_URL .= "&Product_ID=" . $Product->Item_ID;}
	$SP_Perm_URL_With_HTTP = "http://" . $_SERVER['HTTP_HOST'] . $SP_Perm_URL;

	$TagGroupNames = $wpdb->get_results("SELECT * FROM $tag_groups_table_name ORDER BY Tag_Group_Order ASC");
	$ProductVideos = $wpdb->get_results($wpdb->prepare("SELECT * FROM $item_videos_table_name WHERE Item_ID='%d' ORDER BY Item_Video_Order ASC", $Product->Item_ID));

	$upload_dir = wp_upload_dir();

	// Regular product page
	$Disable_Lightbox = "";
	$ProductString = "";
	if ($Custom_Product_Page == "No") {
		$ProductString .= "<div class='upcp-standard-product-page upcp-product-page'>";

		$ProductString .= UPCP_Get_Product_Page_Breadcrumbs($Product, $Return_URL);

		$ProductString .= "<div id='prod-cat-addt-details-" . $Product->Item_ID . "' class='prod-cat-addt-details'>";
		$ProductString .= "<div class='prod-cat-addt-details-title-and-price'><h2 class='prod-cat-addt-details-title'>" . apply_filters('upcp_product_page_title', $Product->Item_Name, array('Item_ID' => $Product->Item_ID, 'Item_Title' => $Product->Item_Name)) . "<img class='upcp-product-url-icon' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/ultimate-product-catalogue/images/insert_link.png' /></h2>";
		if ($Single_Page_Price == "Yes") {$ProductString .= "<h3 class='prod-cat-addt-details-price'>" . $Item_Display_Price . "</h3>";}
		$ProductString .= "</div>";
		$ProductString .= "<div class='upcp-clear'></div>";
		$ProductString .= "<div id='prod-cat-addt-details-main-images-" . $Product->Item_ID . "' class='prod-cat-addt-details-main-image-div'>";
			$ProductString .= "<div id='prod-cat-addt-details-thumbs-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-thumbs-div'>";
			$Slide_Counter = 0;
			if (isset($PhotoURL)) {$ProductString .= "<a class='" . $Lightbox_Class . "' href='" . $PhotoURL ."' data-ulbsource='" . $PhotoURL . "' data-ulbtitle='" . htmlspecialchars(UPCP_Get_Image_Title($PhotoURL), ENT_QUOTES) . "' data-ulbdescription='" . htmlspecialchars(UPCP_Get_Image_Caption($PhotoURL), ENT_QUOTES) . "'><img src='" . $PhotoURL . "' id='prod-cat-addt-details-thumb-P". $Product->Item_ID . "' class='prod-cat-addt-details-thumb' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"0\"); return false;'></a>";}
			foreach ($Item_Images as $Image) {$Slide_Counter++; $ProductString .= "<a class='upcp-thumb-anchor " . $Lightbox_Class . " href='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) ."' data-ulbsource='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' data-ulbtitle='" . htmlspecialchars($Image->Title, ENT_QUOTES) . "' data-ulbdescription='" . htmlspecialchars($Image->Caption, ENT_QUOTES) . "'><img src='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' id='prod-cat-addt-details-thumb-". $Image->Item_Image_ID . "' class='prod-cat-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"" . $Image->Item_Image_ID . "\"); return false;'></a>";}
			$ProductString .= "</div>";
			$ProductString .= "<div id='prod-cat-addt-details-main-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-main-div " . $Lightbox_Clicker_Class . "' data-ulbsource='" . $PhotoURL . "'>";
			$ProductString .= $PhotoCode;
			$ProductString .= "</div>";
		//$ProductString .= "</div>";

		//$ProductString .= "<div class='upcp-clear'></div>";


		$ProductString .= "<div id='prod-cat-addt-details-desc-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-desc-div'>";
		$ProductString .= UPCP_Add_Product_Page_Social_Media($Product, $SP_Perm_URL_With_HTTP);
		$ProductString .= $Description;

		if (is_array($Extra_Elements) and $Extra_Elements[0] != "Blank") {
		if (in_array("Category", $Extra_Elements)) {$ProductString .= "<div class='prod-category-container upcp-product-side-container'>\n<div class='upcp-side-title'>" . $Additional_Info_Category_Label . " </div>" . $Product->Category_Name . "</div>";}
			if (in_array("SubCategory", $Extra_Elements)) {$ProductString .= "<div class='prod-category-container upcp-product-side-container'>\n<div class='upcp-side-title'>" . $Additional_Info_SubCategory_Label . " </div>" . $Product->SubCategory_Name . "</div>";}
			if (in_array("Tags", $Extra_Elements)) {$ProductString .= "<div class='prod-tag-container upcp-product-side-container'>\n<div class='upcp-side-title'>" . $Additional_Info_Tags_Label . "</div>" . $TagsString . "</div>";}
			if (in_array("CustomFields", $Extra_Elements)) {
				$ProductString .= "<div class='prod-cf-container upcp-product-side-container'>";
				$Fields = $wpdb->get_results("SELECT Field_Name, Field_ID, Field_Type FROM $fields_table_name ORDER BY Field_Sidebar_Order");
				foreach ($Fields as $Field) {
					$Value = $wpdb->get_row("SELECT Meta_Value FROM $fields_meta_table_name WHERE Item_ID='" . $Product->Item_ID . "'and Field_ID='" . $Field->Field_ID ."'");
					if ($Custom_Fields_Blank != "Yes" or $Value->Meta_Value != "") {
						if (is_object($Value)) { $Meta_Value = UPCP_Decode_CF_Commas($Value->Meta_Value);}
						else {$Meta_Value = "";}
						if ($Field->Field_Type == "file") {
							$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div>";
							$ProductString .= "<a href='" . $upload_dir['baseurl'] . "/upcp-product-file-uploads/" . $Meta_Value . "' download>" . $Meta_Value . "</a><br>";
						}
						elseif ($Field->Field_Type == "checkbox") {$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div><span>" . str_replace(",", ", ", $Meta_Value) . "</span><br>";}
						elseif ($Field->Field_Type == "link") {$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div><span><a href='" . $Meta_Value . "'>" . $Meta_Value . "</a></span><br>";}
						else {$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div><span>" . do_shortcode($Meta_Value) . "</span><br>";}
					}
				}
				$ProductString .= "</div>";
			}
		}
		$ProductString .= "</div>\n";

		$ProductString .= "<div class='upcp-clear'></div>\n";
		$ProductString .= "</div>\n"; //desc-div
		//$ProductString .= "</div>\n";

		if (is_array($Extra_Elements) and $Extra_Elements[0] != "Blank") {
			// Display selected elements on the side of the page
			$ProductString .= "<div class='prod-details-right default-pp-related'>";

		if ($Related_Type == "Manual" or $Related_Type == "Auto") {$ProductString .= UPCP_Get_Related_Products($Product, $Related_Type);}
		if ($Next_Previous == "Manual" or $Next_Previous == "Auto") {$ProductString .= Get_Next_Previous($Product, $Next_Previous);}

		$ProductString .= "</div>\n";

			if (in_array("Videos", $Extra_Elements)) {
				$ProductString .= "<div class='prod-videos-container upcp-product-side-container'>";
				foreach ($Item_Videos as $Video) {
					$video_info = $Protocol . 'gdata.youtube.com/feeds/api/videos/' . $Video->Item_Video_URL;

					if($video_info != ""){
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $video_info);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

						$response = curl_exec($ch);
						curl_close($ch);

						if ($response and $response != "No longer available") {
							$xml   = new SimpleXMLElement($response);
							$ItemVideoDescription = (string) $xml->title;
						} else {
							$ItemVideoDescription = "No title available for this video";
						}
					} else{
						$ItemVideoDescription = $ItemVideoThumb;
					}
					$ProductString .= "<div class='upcp-side-title upcp-product-video'>" . $ItemVideoDescription . "</div>";
					$ProductString .= "<iframe width='300' height='225' src='" . $Protocol . "www.youtube.com/embed/" . $Video->Item_Video_URL . "?rel=0&fs=1' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
				}
				$ProductString .= "</div>";
			}
		}
		$ProductString .= "</div>";
		if ($Product_Inquiry_Form == "Yes" ) {
			$ProductString .= "<div class='upcp-clear'></div>";
			$ProductString .= Add_Product_Inquiry_Form($Product, $Product_Object);
		}

		$ProductString .= "</div>\n";

		$ProductString .= "<div class='upcp-standard-product-page-mobile  '>";

		$ProductString .= UPCP_Get_Product_Page_Breadcrumbs($Product, $Return_URL);

		$ProductString .= "<h2 class='prod-cat-addt-details-title'>" . apply_filters('upcp_product_page_title', $Product->Item_Name, array('Item_ID' => $Product->Item_ID, 'Item_Title' => $Product->Item_Name)) . "<img class='upcp-product-url-icon' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/ultimate-product-catalogue/images/insert_link.png' /></h2>";
		if ($Single_Page_Price == "Yes") {apply_filters('upcp_product_page_price', $ProductString .= "<h3 class='prod-cat-addt-details-price'>" . $Item_Display_Price . "</h3>", array('Item_ID' => $Product->Item_ID, 'Item_Price' => $Product->Item_Price));}
		$ProductString .= $PhotoCodeMobile;
		$ProductString .= "<div class='upcp-clear'></div>";

		$ProductString .= "<div id='prod-cat-addt-details-desc-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-desc-div'>";
		$ProductString .= $Description . "</div>";
		$ProductString .= "<div class='upcp-clear'></div>\n";

		$ProductString .= "<div id='prod-cat-addt-details-" . $Product->Item_ID . "' class='prod-cat-addt-details'>";
		$ProductString .= "<div id='prod-cat-addt-details-thumbs-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-thumbs-div'>";
		if (isset($PhotoURL)) {$ProductString .= "<img src='" . $PhotoURL . "' id='prod-cat-addt-details-thumb-P". $Product->Item_ID . "' class='prod-cat-addt-details-thumb' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"0\"); return false;'>";}
		foreach ($Item_Images as $Image) {$ProductString .= "<img src='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' id='prod-cat-addt-details-thumb-". $Image->Item_Image_ID . "' class='prod-cat-addt-details-thumb' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"" . $Image->Item_Image_ID . "\"); return false;'>";}
		$ProductString .= "<div class='upcp-clear'></div>";
		$ProductString .= "</div>";


		$ProductString .= "</div>\n";

		$ProductString .= "</div>\n";
	}
	elseif ($Custom_Product_Page == "Tabbed" || $Custom_Product_Page == "Shop_Style") {

		if ($UPCP_Options->Get_Option("UPCP_Product_Details_Label") != "") {$Product_Details_Label = $UPCP_Options->Get_Option("UPCP_Product_Details_Label");}
		else {$Product_Details_Label = __("<span class='upcp-tab-break'>". __('Product', 'ultimate-product-catalogue') . "</span> <span class='upcp-tab-break'>" . __('Details', 'ultimate-product-catalogue') . "</span>", 'ultimate-product-catalogue');}
		if ($UPCP_Options->Get_Option("UPCP_Additional_Info_Label") != "") {$Additional_Info_Label = $UPCP_Options->Get_Option("UPCP_Additional_Info_Label");}
		else {$Additional_Info_Label = __("<span class='upcp-tab-break'>" . __('Additional', 'ultimate-product-catalogue') . "</span> <span class='upcp-tab-break'>" . __('Information', 'ultimate-product-catalogue') . " </span>", 'ultimate-product-catalogue');}
		if ($UPCP_Options->Get_Option("UPCP_Contact_Us_Label") != "") {$Contact_Us_Label = $UPCP_Options->Get_Option("UPCP_Contact_Us_Label");}
		else {$Contact_Us_Label = __("<span class='upcp-tab-break'>" . __('Contact', 'ultimate-product-catalogue') . "</span> <span class='upcp-tab-break'>" . __('Us', 'ultimate-product-catalogue') . "</span>", 'ultimate-product-catalogue');}
		if ($UPCP_Options->Get_Option("UPCP_Customer_Reviews_Tab_Label") != "") {$Customer_Reviews_Tab_Label = $UPCP_Options->Get_Option("UPCP_Customer_Reviews_Tab_Label");}
		else {$Customer_Reviews_Tab_Label = __("<span class='upcp-tab-break'>" . __('Customer', 'ultimate-product-catalogue') . "</span> <span class='upcp-tab-break'>" . __('Reviews', 'ultimate-product-catalogue') . "</span>", 'ultimate-product-catalogue');}


		$ProductString .= "<div class='upcp-tabbed-product-page upcp-product-page' itemscope itemtype='http://schema.org/Product'>";

		$ProductString .= UPCP_Get_Product_Page_Breadcrumbs($Product, $Return_URL);

		$ProductString .= "<div class='upcp-tabbed-images-container'>";
		$ProductString .= "<div id='upcp-tabbed-main-image-div-" . $Product->Item_ID . "' class='upcp-tabbed-main-image-div'>";
		$ProductString .= "<div class='upcp-tabbed-main-image-inner'>";
		$ProductString .= "<div class='upcp-tabbed-image-container'>";
		$ProductString .= "<a href='" . $PhotoURL . "' class='prod-cat-addt-details-link-a prod-cat-pp-main-img-a " . $Lightbox_Clicker_Class . "' data-ulbsource='" . $PhotoURL . "'> ";
		$ProductString .= "  $PhotoCode " ;
		$ProductString .= "</a>";
		$ProductString .= "</div>";
		if (sizeOf($Item_Videos) > 0) {
			$ProductString .= "<div class='upcp-tabbed-video-container upcp-Hide-Item'>";
			$ProductString .= "<a href='#' class='prod-cat-addt-details-link-a'> ";
			$ProductString .= "<iframe width='420' height='315' class='upcp-main-video' src='" . $Protocol . "www.youtube.com/embed/" . $Item_Videos[0]->Item_Video_URL . "' frameborder='0' allowfullscreen></iframe>";
			$ProductString .= "</a>";
			$ProductString .= "</div>";
		}
		$ProductString .= "</div>";
		$ProductString .= "</div>";

		$ProductString .= "<div class='upcp-clear'></div>";
	  	/*Slider container*/
		$ProductString .= "<div id='upcp-tabbed-image-thumbs-div-" . $Product->Item_ID . "' class='upcp-tabbed-image-thumbs-div'>";
	  	/*Back button*/
	  	if ((sizeOf($Item_Videos) + sizeOf($Item_Images)) > 1) {
	  		$ProductString .= "<div class='upcp-tabbed-button-left-div upcp-tabbed-button-div'> ";
	  		$ProductString .= "<button class='upcp-tabbed-button-left'><</button>";
	  		$ProductString .= "</div>";
	  	}
	  	/*Images*/
	  	$ProductString .= "<div class='upcp-scroll-content'> ";
	  	$ProductString .= "<ul class='upcp-scroll-list'>";

		$Slide_Counter = 0;
		if (isset($PhotoURL)) {$ProductString .= "<li class='upcp-tabbed-addt-img-thumbs'><a class='upcp-thumb-anchor " . $Lightbox_Class . "' href='" . $PhotoURL ."' data-ulbsource='" . $PhotoURL . "' data-ulbtitle='" . htmlspecialchars(UPCP_Get_Image_Title($PhotoURL), ENT_QUOTES) . "' data-ulbdescription='" . htmlspecialchars(UPCP_Get_Image_Caption($PhotoURL), ENT_QUOTES) . "'><img src='" . $PhotoURL . "' id='prod-cat-addt-details-thumb-P". $Product->Item_ID . "' class='upcp-tabbed-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"0\"); return false;'></a></li>";}
		foreach ($Item_Images as $Image) {$Slide_Counter++; $ProductString .= "<li class='upcp-tabbed-addt-img-thumbs'><a class='upcp-thumb-anchor " . $Lightbox_Class . "' href='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' data-ulbsource='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' data-ulbtitle='" . htmlspecialchars($Image->Title, ENT_QUOTES) . "' data-ulbdescription='" . htmlspecialchars($Image->Caption, ENT_QUOTES) . "'><img src='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' id='prod-cat-addt-details-thumb-". $Image->Item_Image_ID . "' class='upcp-tabbed-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"" . $Image->Item_Image_ID . "\"); return false;' ></a></li>";}
		foreach ($Item_Videos as $Video) {$Slide_Counter++; $ProductString .= "<li class='upcp-tabbed-addt-img-thumbs'><a class='upcp-thumb-anchor " . $Lightbox_Class . " upcp-thumb-video' href='" . $Protocol . "img.youtube.com/vi/" . $Video->Item_Video_URL . "/default.jpg' data-videoid='" . $Video->Item_Video_URL . "' data-ulbsource='" . $Protocol . "www.youtube.com/embed/" . $Video->Item_Video_URL . "'><img src='" . $Protocol . "img.youtube.com/vi/" . $Video->Item_Video_URL . "/default.jpg' id='prod-cat-addt-details-thumb-". $Image->Item_Image_ID . "' class='upcp-tabbed-addt-details-thumb " . $Disable_Lightbox . "'></a></li>";}
		//foreach ($Item_Videos as $Video) {$ProductString .= "<iframe width='300' height='225' src='" . $Protocol . "www.youtube.com/embed/" . $Video->Item_Video_URL . "?rel=0&fs=1' webkitallowfullscreen mozallowfullscreen allowfullscreen onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"" . $Video->Video_ID . "\");'></iframe>";}

	  	/*Next button*/
	  	$ProductString .= "</ul>";
	  	$ProductString .= "</div>";
	  	if ((sizeOf($Item_Videos) + sizeOf($Item_Images)) > 1) {
	  		$ProductString .= "<div class='upcp-tabbed-button-right-div upcp-tabbed-button-div'> ";
	  		$ProductString .= "<button class='upcp-tabbed-button-right'>></button>";
			$ProductString .= "</div>";
		}
		$ProductString .= "</div>";
		$ProductString .= "</div>";

		if($Custom_Product_Page != "Shop_Style"){
			$ProductString .= "<div class='upcp-tabbed-main-product-container'>";
		}

		$ProductString .= "<div class='upcp-tabbed-main-product-details'>";
		$ProductString .= "<h2 class='upcp-tabbed-product-name'><span itemprop='name'>" . apply_filters('upcp_product_page_title', $Product->Item_Name, array('Item_ID' => $Product->Item_ID, 'Item_Title' => $Product->Item_Name)) . "</span></h2>";
		if ($Single_Page_Price == "Yes") {$ProductString .= apply_filters('upcp_product_page_price', "<h3 class='upcp-tabbed-product-price'>" . $Item_Display_Price . "</h3>", array('Item_ID' => $Product->Item_ID, 'Item_Price' => $Product->Item_Price));}

		$ProductString .= UPCP_Add_Product_Page_Social_Media($Product, $SP_Perm_URL_With_HTTP);
		$ProductString .= "</div>";

		if($Custom_Product_Page == "Shop_Style"){
			$ProductString .= "<div class='upcp-tabbed-main-product-container'>";
		}

		$ProductString .= "<div id='upcp-tabbed-tabs-holder-" . $Product->Item_ID . "' class='upcp-tabbed-tabs-holder'>";

		$ProductString .= "<div class='upcp-tabbed-tabs-menu'>";
		$ProductString .= "<ul id='upcp-tabs'>";
		$ProductString .= "<li class='upcp-tabbed-layout-tab upcp-tabbed-description-menu upcp-tab-slide " . (($Starting_Tab == 'details' or $Starting_Tab == '') ? '' : 'upcp-tab-layout-tab-unclicked') . "' id='upcp-tabbed-tab' data-class='upcp-tabbed-description'><a>" . $Product_Details_Label . " </a></li>";
		$ProductString .= "<li class='upcp-tabbed-layout-tab upcp-tabbed-addtl-info-menu upcp-tab-slide " . ($Starting_Tab == 'addtl-information' ? '' : 'upcp-tab-layout-tab-unclicked') . "' id='upcp-tabbed-tab' data-class='upcp-tabbed-addtl-info'><a>" . $Additional_Info_Label . " </a></li>";
		if ($Product_Inquiry_Form == "Yes" ) {$ProductString .= "<li class='upcp-tabbed-layout-tab upcp-tabbed-contact-form-menu upcp-tab-slide " . ($Starting_Tab == 'contact' ? '' : 'upcp-tab-layout-tab-unclicked') . "' id='upcp-tabbed-tab' data-class='upcp-tabbed-contact-form'><a>" . $Contact_Us_Label . "</a></li>";}
		if ($Product_Reviews == "Yes" ) {$ProductString .= "<li class='upcp-tabbed-layout-tab upcp-tabbed-reviews-menu upcp-tab-slide " . ($Starting_Tab == 'reviews' ? '' : 'upcp-tab-layout-tab-unclicked') . "' id='upcp-tabbed-tab' data-class='upcp-tabbed-reviews'><a> <span class='upcp-tab-break'>" . $Customer_Reviews_Tab_Label . "</span></a></li>";}
		if (is_array($Tabs_Array) and sizeof($Tabs_Array) > 0) {
			foreach ($Tabs_Array as $key => $Tab_Item ) {
				$ProductString .= "<li class='upcp-tabbed-layout-tab upcp-tabbed-" . $key . "-menu upcp-tab-slide " . ($Starting_Tab == sanitize_title($Tab_Item['Name'])? '' : 'upcp-tab-layout-tab-unclicked') . "' id='upcp-tabbed-tab' data-class='upcp-tabbed-" . $key . "'><a>" . ConvertCustomFields($Tab_Item['Name'], $Product->Item_ID, $Product->Item_Name) . " </a></li>";
			}
		}
		$ProductString .= "</ul>";
		$ProductString .= "</div>";

		$ProductString .= "<div id='upcp-tabbed-description-" . $Product->Item_ID . "' class='upcp-tabbed-description upcp-tabbed-tab " . (($Starting_Tab == 'details' or $Starting_Tab == '') ? '' : 'upcp-Hide-Item') . "'>";
		$ProductString .= "<div id='upcp-tabbed-content' itemprop='description'>";
		$ProductString .= $Description;
		$ProductString .= "</div>";
		$ProductString .= "</div>";

		$ProductString .= "<div id='upcp-tabbed-addtl-info-" . $Product->Item_ID . "' class='upcp-tabbed-addtl-info upcp-tabbed-tab " . ($Starting_Tab == 'addtl-information' ? '' : 'upcp-Hide-Item') . "'>";
			$ProductString .= "<div class='upcp-tabbed-details'>";
			$ProductString .= "<div id='upcp-tabbed-content'>";
			if (in_array("Category", $Extra_Elements)) {$ProductString .= "<div class='upcp-tabbed-category-container'>\n<div class='upcp-tab-title'>" . $Additional_Info_Category_Label . " </div>" . $Product->Category_Name . "</div>";}
			if (in_array("SubCategory", $Extra_Elements)) {$ProductString .= "<div class='upcp-tabbed-subcategory-container'>\n<div class='upcp-tab-title'>" . $Additional_Info_SubCategory_Label . " </div>" . $Product->SubCategory_Name . "</div>";}
			if (in_array("Tags", $Extra_Elements)) {$ProductString .= "<div class='upcp-tabbed-tag-container'>\n<div class='upcp-tab-title'>" . $Additional_Info_Tags_Label . "</div>" . $TagsString . "</div>";}
			if (in_array("CustomFields", $Extra_Elements)) {
				$ProductString .= "<div class='upcp-tabbed-cf-container'>";
				$Fields = $wpdb->get_results("SELECT Field_Name, Field_ID, Field_Type FROM $fields_table_name WHERE Field_Display_Tabbed='Yes' ORDER BY Field_Sidebar_Order");
				foreach ($Fields as $Field) {
					$Value = $wpdb->get_row("SELECT Meta_Value FROM $fields_meta_table_name WHERE Item_ID='" . $Product->Item_ID . "'and Field_ID='" . $Field->Field_ID ."'");
					if ($Custom_Fields_Blank != "Yes" or $Value->Meta_Value != "") {
						if (is_object($Value)) { $Meta_Value = UPCP_Decode_CF_Commas($Value->Meta_Value);}
						else {$Meta_Value = "";}
						if ($Field->Field_Type == "file") {
							$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div>";
							$ProductString .= "<a href='" . $upload_dir['baseurl'] . "/upcp-product-file-uploads/" .$Meta_Value . "' download>" . $Meta_Value . "</a><br>";
						}
						elseif ($Field->Field_Type == "checkbox") {$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div><span>" . str_replace(",", ", ", $Meta_Value) . "</span><br>";}
						elseif ($Field->Field_Type == "link") {$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div><span><a href='" . $Meta_Value . "'>" . $Meta_Value . "</a></span><br>";}
						else {$ProductString .= "<div class='upcp-tab-title'>" . $Field->Field_Name . ":</div><span>" . do_shortcode($Meta_Value) . "</span><br>";}
					}
				}
				$ProductString .= "</div>";
			}
		$ProductString .= "</div>";
		$ProductString .= "</div>";
		$ProductString .= "</div>";

		if ($Product_Inquiry_Form == "Yes" ) {
			$ProductString .= "<div id='upcp-tabbed-contact-form-" . $Product->Item_ID . "' class='upcp-tabbed-contact-form upcp-tabbed-tab " . ($Starting_Tab == 'contact' ? '' : 'upcp-Hide-Item') . "'>";
			$ProductString .= "<div id='upcp-tabbed-content'>";
			$ProductString .= Add_Product_Inquiry_Form($Product, $Product_Object);
			$ProductString .= "</div>";
			$ProductString .= "</div>";
		}

		if ($Product_Reviews == "Yes" ) {
			$ProductString .= "<div id='upcp-tabbed-reviews-" . $Product->Item_ID . "' class='upcp-tabbed-reviews upcp-tabbed-tab " . ($Starting_Tab == 'reviews' ? '' : 'upcp-Hide-Item') . "'>";
			$ProductString .= "<div id='upcp-tabbed-content'>";
			$ProductString .= UPCP_Add_Product_Reviews($Product);
			$ProductString .= "</div>";
			$ProductString .= "</div>";
		}
		if (is_array($Tabs_Array) and sizeof($Tabs_Array) > 0) {
			foreach ($Tabs_Array as $key => $Tab_Item ) {
				$ProductString .= "<div id='upcp-tabbed-" . $key . "-" . $Product->Item_ID . "' class='upcp-tabbed-" . $key . " upcp-tabbed-tab " . ($Starting_Tab == sanitize_title($Tab_Item['Name']) ? '' : 'upcp-Hide-Item') . "'>";
				$ProductString .= "<div id='upcp-tabbed-content'>";
				$ProductString .= do_shortcode(ConvertCustomFields($Tab_Item['Content'], $Product->Item_ID, $Product->Item_Name));
				$ProductString .= "</div>";
				$ProductString .= "</div>";
			}
		}
		$ProductString .= "</div>";
		$ProductString .= "</div>";
		$ProductString .= "</div>";

		$ProductString .= "<div id='upcp-tabbed-similar-products-div-" . $Product->Item_ID . "' class='upcp-tabbed-similar-products-div'>";
		if ($Related_Type == "Manual" or $Related_Type == "Auto") {$ProductString .= UPCP_Get_Related_Products($Product, $Related_Type);}
		if ($Next_Previous == "Manual" or $Next_Previous == "Auto") {$ProductString .= Get_Next_Previous($Product, $Next_Previous);}

		$ProductString .= "</div>";

	}
	else {
		if ($Custom_Product_Page == "Large" or $Mobile_Product_Page_Serialized != "") {$ProductString .= "<div class='upcp-custom-large-product-page upcp-product-page'>";}

		echo "<script language='JavaScript' type='text/javascript'>";
		echo "var pp_grid_width = " . $PP_Grid_Width . ";";
		echo "var pp_grid_height = " . $PP_Grid_Height . ";";
		echo "var pp_top_bottom_padding = " . $Top_Bottom_Padding . ";";
		echo "var pp_left_right_padding = " . $Left_Right_Padding . ";";
		echo "</script>";

		$Gridster = json_decode(stripslashes($Product_Page_Serialized));
		$ProductString .= "<div class='upcp-gridster-loading upcp-Hide-Item'>";
		$ProductString .= "<div class='gridster'>";
		$ProductString .= "<ul>";
		$ProductString .= BuildGridster($Gridster, $Product, $Item_Images, $Description, $PhotoURL, $SP_Perm_URL, $Return_URL, $TagsString, $Lightbox_Class, $Lightbox_Clicker_Class);
		$ProductString .= "</ul>";
		$ProductString .= "</div>";
		$ProductString .= "</div>";

		if ($Custom_Product_Page == "Large") {
			$ProductString .= "</div>";

			$ProductString .= "<div class='upcp-standard-product-page-mobile  '>";

			$ProductString .= UPCP_Get_Product_Page_Breadcrumbs($Product, $Return_URL);

			$ProductString .= "<h2 class='prod-cat-addt-details-title'>" . apply_filters('upcp_product_page_title', $Product->Item_Name, array('Item_ID' => $Product->Item_ID, 'Item_Title' => $Product->Item_Name)) . "<img class='upcp-product-url-icon' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/ultimate-product-catalogue/images/insert_link.png' /></h2>";
			if ($Single_Page_Price == "Yes") {$ProductString .= apply_filters('upcp_product_page_price', "<h3 class='prod-cat-addt-details-price'>" . $Item_Display_Price . "</h3>", array('Item_ID' => $Product->Item_ID, 'Item_Price' => $Product->Item_Price));}
			$ProductString .= $PhotoCodeMobile;
			$ProductString .= "<div class='upcp-clear'></div>";

			$ProductString .= "<div id='prod-cat-addt-details-" . $Product->Item_ID . "' class='prod-cat-addt-details'>";
			$ProductString .= "<div id='prod-cat-addt-details-thumbs-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-thumbs-div'>";
			$Slide_Counter = 0;
			if (isset($PhotoURL)) {$ProductString .= "<a href='" . $PhotoURL . "' class='" . $Lightbox_Class . " prod-cat-addt-details-link-a' data-ulbsource='" . $PhotoURL . "'><img src='" . $PhotoURL . "' id='prod-cat-addt-details-thumb-P1-". $Product->Item_ID . "' class='prod-cat-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"0\"); return false;'></a>";}
			foreach ($Item_Images as $Image) {$Slide_Counter++; $ProductString .= "<a href='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' class='" . $Lightbox_Class ." prod-cat-addt-details-link-a' data-src='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "'><img src='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' id='prod-cat-addt-details-thumb-". $Image->Item_Image_ID . "' class='prod-cat-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"" . $Image->Item_Image_ID . "\"); return false;'></a>";}
			$ProductString .= "<div class='upcp-clear'></div>";
			$ProductString .= "</div>";

			$ProductString .= "<div id='prod-cat-addt-details-desc-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-desc-div'>";
			$ProductString .= $Description . "</div>";
			$ProductString .= "<div class='upcp-clear'></div>\n";
			if ($Related_Type == "Manual" or $Related_Type == "Auto") {$ProductString .= UPCP_Get_Related_Products($Product, $Related_Type);}
			if ($Next_Previous == "Manual" or $Next_Previous == "Auto") {$ProductString .= Get_Next_Previous($Product, $Next_Previous);}
			$ProductString .= "</div>\n";

			$ProductString .= "</div>\n";
		}
		elseif ($Mobile_Product_Page_Serialized != "") {
			$ProductString .= "</div>";

			$ProductString .= "<div class='upcp-standard-product-page-mobile  '>";

			$Gridster = json_decode(stripslashes($Mobile_Product_Page_Serialized));
			$ProductString .= "<div class='upcp-gridster-loading upcp-Hide-Item'>";
			$ProductString .= "<div class='gridster-mobile'>";
			$ProductString .= "<ul>";
			$ProductString .= BuildGridster($Gridster, $Product, $Item_Images, $Description, $PhotoURL, $SP_Perm_URL, $Return_URL, $TagsString, $Lightbox_Class, $Lightbox_Clicker_Class);
			$ProductString .= "</ul>";
			$ProductString .= "</div>";
			$ProductString .= "</div>";

			$ProductString .= "</div>\n";
		}
	}

	return $ProductString;
}

function BuildSidebar($category, $subcategory, $tags, $prod_name) {
	global $wpdb, $Full_Version, $ProdCats, $ProdSubCats, $ProdTags, $ProdCustomFields, $ProdCatString, $ProdSubCatString, $ProdTagString, $ProdCustomFieldsString, $Max_Price_Product, $Min_Price_Product;
	global $categories_table_name, $subcategories_table_name, $tags_table_name, $fields_table_name;
	global $UPCP_Options;

	$Color = $UPCP_Options->Get_Option("UPCP_Color_Scheme");
	$Currency_Symbol = $UPCP_Options->Get_Option("UPCP_Currency_Symbol");
	$Currency_Symbol_Location = $UPCP_Options->Get_Option("UPCP_Currency_Symbol_Location");
	$Tag_Logic = $UPCP_Options->Get_Option("UPCP_Tag_Logic");
	$Price_Filter = $UPCP_Options->Get_Option("UPCP_Price_Filter");
	$Slider_Filter_Inputs = $UPCP_Options->Get_Option("UPCP_Slider_Filter_Inputs");
	$ProductSearch = $UPCP_Options->Get_Option("UPCP_Product_Search");
	$Display_Category_Image = $UPCP_Options->Get_Option("UPCP_Display_Category_Image");
	$Display_SubCategory_Image = $UPCP_Options->Get_Option("UPCP_Display_SubCategory_Image");
	$Product_Sort = $UPCP_Options->Get_Option("UPCP_Product_Sort");
	if (!is_array($Product_Sort)) {$Product_Sort = array();}
	$Sidebar_Order = $UPCP_Options->Get_Option("UPCP_Sidebar_Order");
	$Custom_Fields_Show_Hide = $UPCP_Options->Get_Option("UPCP_Custom_Fields_Show_Hide");
	$Clear_All = $UPCP_Options->Get_Option("UPCP_Clear_All");
	$Hidden_Drop_Down_Sidebar_On_Mobile = $UPCP_Options->Get_Option("UPCP_Hidden_Drop_Down_Sidebar_On_Mobile");

	$Sidebar_Title_Collapse = $UPCP_Options->Get_Option("UPCP_Sidebar_Title_Collapse");
	$Sidebar_Subcat_Collapse = $UPCP_Options->Get_Option("UPCP_Sidebar_Subcat_Collapse");
	$Sidebar_Start_Collapsed = $UPCP_Options->Get_Option("UPCP_Sidebar_Start_Collapsed");
	$Sidebar_Title_Hover = $UPCP_Options->Get_Option("UPCP_Sidebar_Title_Hover");
	$Sidebar_Checkbox_Style = $UPCP_Options->Get_Option("UPCP_Sidebar_Checkbox_Style");
	$Categories_Control_Type = $UPCP_Options->Get_Option("UPCP_Categories_Control_Type");
	$SubCategories_Control_Type = $UPCP_Options->Get_Option("UPCP_SubCategories_Control_Type");
	$Tags_Control_Type = $UPCP_Options->Get_Option("UPCP_Tags_Control_Type");
	$Sidebar_Items_Order = $UPCP_Options->Get_Option("UPCP_Sidebar_Items_Order");

	$Categories_Label = $UPCP_Options->Get_Option("UPCP_Categories_Label");
	$SubCategories_Label = $UPCP_Options->Get_Option("UPCP_SubCategories_Label");
	$Tags_Label = $UPCP_Options->Get_Option("UPCP_Tags_Label");
	$Show_All_Label = $UPCP_Options->Get_Option("UPCP_Show_All_Label");
	$Price_Filter_Label = $UPCP_Options->Get_Option("UPCP_Price_Filter_Label");
	$Sort_By_Label = $UPCP_Options->Get_Option("UPCP_Sort_By_Label");
	$Price_Ascending_Label = $UPCP_Options->Get_Option("UPCP_Price_Ascending_Label");
	$Price_Descending_Label = $UPCP_Options->Get_Option("UPCP_Price_Descending_Label");
	$Name_Ascending_Label = $UPCP_Options->Get_Option("UPCP_Name_Ascending_Label");
	$Name_Descending_Label = $UPCP_Options->Get_Option("UPCP_Name_Descending_Label");
	$Rating_Ascending_Label = $UPCP_Options->Get_Option("UPCP_Rating_Ascending_Label");
	$Rating_Descending_Label = $UPCP_Options->Get_Option("UPCP_Rating_Descending_Label");
	$Product_Name_Search_Label = $UPCP_Options->Get_Option("UPCP_Product_Name_Search_Label");
	$Product_Search_Text_Label = $UPCP_Options->Get_Option("UPCP_Product_Name_Text_Label");

	if ($Categories_Label != "") {$Categories_Text = $Categories_Label;}
	else {$Categories_Text = __("Categories:", 'ultimate-product-catalogue');}
	if ($SubCategories_Label != "") {$SubCategories_Text = $SubCategories_Label;}
	else {$SubCategories_Text = __("Sub-Categories:", 'ultimate-product-catalogue');}
	if ($Tags_Label != "") {$Tags_Text = $Tags_Label;}
	else {$Tags_Text = __("Tags:", 'ultimate-product-catalogue');}
	if ($Show_All_Label != "") {$Show_All_Text = $Show_All_Label;}
	else {$Show_All_Text = __("Show All", 'ultimate-product-catalogue');}
	if ($Price_Filter_Label != "") {$Price_Filter_Label = $Price_Filter_Label;}
	else {$Price_Filter_Label = __('Price:', 'ultimate-product-catalogue');}
	if ($Sort_By_Label != "") {$Sort_Text = $Sort_By_Label;}
	else {$Sort_Text = __('Sort By:', 'ultimate-product-catalogue');}
	if ($Price_Ascending_Label != "") {$Price_Ascending_Text = $Price_Ascending_Label;}
	else {$Price_Ascending_Text = __('Price (Ascending)', 'ultimate-product-catalogue');}
	if ($Price_Descending_Label != "") {$Price_Descending_Text = $Price_Descending_Label;}
	else {$Price_Descending_Text = __('Price (Descending)', 'ultimate-product-catalogue');}
	if ($Name_Ascending_Label != "") {$Name_Ascending_Text = $Name_Ascending_Label;}
	else {$Name_Ascending_Text = __('Name (Ascending)', 'ultimate-product-catalogue');}
	if ($Name_Descending_Label != "") {$Name_Descending_Text = $Name_Descending_Label;}
	else {$Name_Descending_Text = __('Name (Descending)', 'ultimate-product-catalogue');}
	if ($Rating_Ascending_Label != "") {$Rating_Ascending_Text = $Rating_Ascending_Label;}
	else {$Rating_Ascending_Text = __('Rating (Ascending)', 'ultimate-product-catalogue');}
	if ($Rating_Descending_Label != "") {$Rating_Descending_Text = $Rating_Descending_Label;}
	else {$Rating_Descending_Text = __('Rating (Descending)', 'ultimate-product-catalogue');}
	if ($Product_Name_Search_Label != "") {$SearchLabel = $Product_Name_Search_Label;}
	else {
		if ($ProductSearch == "namedesc" or $ProductSearch == "namedesccust") {$SearchLabel = __("Product Search:", 'ultimate-product-catalogue');}
		else {$SearchLabel = __("Product Name:", 'ultimate-product-catalogue');}
	}
	if ($prod_name != "") {$Product_Name_Text = $prod_name;}
	elseif ($Product_Search_Text_Label != "") {$Product_Name_Text = $Product_Search_Text_Label;
	}
	else {
		if ($ProductSearch == "namedesc" or $ProductSearch == "namedesccust") {$Product_Name_Text = __("Search...", 'ultimate-product-catalogue');}
		else {$Product_Name_Text = __("Name...", 'ultimate-product-catalogue');}
	}

	if ($Sidebar_Start_Collapsed == "yes") {$Sidebar_Start_Collapsed_HTML = "style='display:none;'";}
	else {$Sidebar_Start_Collapsed_HTML = "";}

	// Get the categories, sub-categories and tags that apply to the products in the catalog
	if ($ProdCatString != "") {$Categories = $wpdb->get_results("SELECT Category_ID, Category_Name, Category_Image FROM $categories_table_name WHERE Category_ID IN (" . $ProdCatString . ") ORDER BY Category_Sidebar_Order");}
	if ($ProdSubCatString != "") {$SubCategories = $wpdb->get_results("SELECT SubCategory_ID, SubCategory_Name, SubCategory_Image, Category_ID FROM $subcategories_table_name WHERE SubCategory_ID IN (" . $ProdSubCatString . ") ORDER BY SubCategory_Sidebar_Order");}
	if ($ProdTagString != "") {$Tags = $wpdb->get_results("SELECT Tag_ID, Tag_Name FROM $tags_table_name WHERE Tag_ID IN (" . $ProdTagString . ") ORDER BY Tag_Sidebar_Order");}
	else {$Tags = array();}
	if ($ProdCustomFieldsString != "") {$Custom_Fields = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Control_Type FROM $fields_table_name WHERE Field_ID IN (" . $ProdCustomFieldsString . ") AND Field_Searchable='Yes' ORDER BY Field_Sidebar_Order");}
	else {$Custom_Fields = array();}

	$SidebarString = "";
	if ($Hidden_Drop_Down_Sidebar_On_Mobile == "Yes") {
		$SidebarString .= "<div class='ewd-upcp-filtering-toggle ewd-upcp-filtering-toggle-downcaret'>";
		$SidebarString .= __("Filter", 'ultimate-product-catalogue');
		$SidebarString .= "</div>";

		$Sidebar_Mobile_Class = "prod-cat-sidebar-hidden";
	}
	else {$Sidebar_Mobile_Class = "";}
	$id = "";
	$SidebarString .= "<div id='prod-cat-sidebar-" . $id . "' class='prod-cat-sidebar " . $Sidebar_Mobile_Class . "'>\n";
	//$SidebarString .= "<form action='#' name='Product_Catalog_Sidebar_Form'>\n";
	$SidebarString .= "<form onsubmit='return false;' name='Product_Catalog_Sidebar_Form'>\n";
	
	if ($Clear_All == "Yes") {$SidebarString .= "<div class='upcp-filtering-clear-all upcp-Hide-Item'>" . __("Clear All", 'ultimate-product-catalogue') . "</div>";}

	foreach ($Sidebar_Items_Order as $Sidebar_Item) {
		
		//Create the 'Sort By' select box
		if ($Sidebar_Item == "Product Sort" and $Full_Version == "Yes" and !empty($Product_Sort)) {
			$SortString = "<div id='prod-cat-sort-by' class='prod-cat-sort-by'>";
			$SortString .= $Sort_Text . "<br>";
			$SortString .= "<div class='styled-select styled-input'>";
			$SortString .= "<select name='upcp-sort-by' id='upcp-sort-by' onchange='UPCP_Sort_By();'>";
			$SortString .= "<option value=''></option>";
			if (in_array("Price", $Product_Sort)) {
				$SortString .= "<option value='price_asc'>" . $Price_Ascending_Text . "</option>";
				$SortString .= "<option value='price_desc'>" . $Price_Descending_Text . "</option>";
			}
			if (in_array("Name", $Product_Sort)) {
				$SortString .= "<option value='name_asc'>" . $Name_Ascending_Text . "</option>";
				$SortString .= "<option value='name_desc'>" . $Name_Descending_Text . "</option>";
			}
			if (in_array("Rating", $Product_Sort)) {
				$SortString .= "<option value='rating_asc'>" . $Rating_Ascending_Text . "</option>";
				$SortString .= "<option value='rating_desc'>" . $Rating_Descending_Text . "</option>";
			}
			$SortString .= "</select>";
			$SortString .= "</div>";
			$SortString .= "</div>";
			$SidebarString .= apply_filters('upcp_sidebar_sort_div', $SortString);
		}

		// Create the text search box
		if ($Sidebar_Item == "Product Search" and $ProductSearch != "none") {
			$SearchString = "<div id='prod-cat-text-search' class='prod-cat-text-search'>\n";
			$SearchString .= $SearchLabel . "<br /><div class='styled-input'>";
			$SearchString .= "<input type='text' id='upcp-name-search' class='jquery-prod-name-text' name='Text_Search' value='" . $Product_Name_Text . "' onfocus='FieldFocus(this);' onblur='FieldBlur(this);' onkeyup='UPCP_DisplayPage(\"1\");'>\n";
			$SearchString .= "</div></div>\n";
			$SidebarString .= apply_filters('upcp_sidebar_search_div', $SearchString);
		}

		if ($Sidebar_Item == "Price Filter" and $Price_Filter == "Yes") {
			$Price_Filter_String = "<div id='prod-cat-price-filter' class='prod-cat-price-filter'>\n";
			$Price_Filter_String .= $Price_Filter_Label . "<br />";
			$Price_Filter_String .= "<div id='upcp-price-score-filter'></div>";
			$Price_Filter_String .= "<span id='upcp-price-range'>";
			$Price_Filter_String .= "<span id='upcp-price-slider-min-span'>";
			$Price_Filter_String .= ($Currency_Symbol_Location == "Before" ? "<span class='upcp-price-slider-currency-symbol'>" . $Currency_Symbol . "</span>" : "");
			$Price_Filter_String .= "<input type='text' value='" . $Min_Price_Product . "' class='upcp-price-slider-min " . ($Slider_Filter_Inputs != "Yes" ? "upcp-hidden-text-field' disabled" : "'") . " />";
			$Price_Filter_String .= ($Currency_Symbol_Location == "After" ? "<span class='upcp-price-slider-currency-symbol'>" . $Currency_Symbol . "</span>" : "");
			$Price_Filter_String .= "</span>";
			$Price_Filter_String .= "<span class='upcp-price-slider-divider'> - </span>";
			$Price_Filter_String .= "<span id='upcp-price-slider-max-span'>";
			$Price_Filter_String .= ($Currency_Symbol_Location == "Before" ? "<span class='upcp-price-slider-currency-symbol'>" . $Currency_Symbol . "</span>" : "");
			$Price_Filter_String .= "<input type='text' value='" . $Max_Price_Product . "' class='upcp-price-slider-max " . ($Slider_Filter_Inputs != "Yes" ? "upcp-hidden-text-field' disabled" : "'") . " />";
			$Price_Filter_String .= ($Currency_Symbol_Location == "After" ? "<span class='upcp-price-slider-currency-symbol'>" . $Currency_Symbol . "</span>" : "");
			$Price_Filter_String .= "</span>";
			$Price_Filter_String .= "</span>";
			$Price_Filter_String .= "</div>";
			$SidebarString .= apply_filters('upcp_sidebar_price_div', $Price_Filter_String);
		}

		// Create the categories checkboxes
		if ($Sidebar_Item == "Categories" and sizeof($Categories) > 0) {
			$CategoriesString = "<div id='prod-cat-sidebar-category-div-" . $id . "' class='prod-cat-sidebar-category-div'>\n";
			$CategoriesString .= "<div id='prod-cat-sidebar-category-title-" . $id . "' class='prod-cat-sidebar-cat-title prod-cat-sidebar-category-title prod-cat-sidebar-hover-"  . $Sidebar_Title_Hover . "' data-title='1'";
			if ($Sidebar_Title_Collapse == "yes") {$CategoriesString .= " onclick='UPCP_Show_Hide_Sidebar(this);'";}
			$CategoriesString .= "><h3>" . $Categories_Text . "</h3></div>\n";
			$CategoriesString .= "<div class='prod-cat-sidebar-content prod-cat-sidebar-category-content ";
			if (($Sidebar_Order == "Hierarchical") and ($Sidebar_Subcat_Collapse == "yes")) {
									$CategoriesString .= "prod-cat-subcat-collapsible";
								}
			$CategoriesString .= "' data-title='1' " . $Sidebar_Start_Collapsed_HTML . ">\n";
			if ($Categories_Control_Type == "Dropdown") {
				$CategoriesString .= "<select name='Category' onchange='UPCP_DisplayPage(\"1\");' class='upcp-jquery-cat-dropdown'>";
				$CategoriesString .= "<option value='All'>" . $Show_All_Label . "</option>";
			}
			foreach ($Categories as $Category) {
				if ($Categories_Control_Type == "Dropdown") {
					$CategoriesString .= "<option value='" . $Category->Category_ID . "' ";
					if (in_array($Category->Category_ID, $category)) {$CategoriesString .= "selected=selected";}
					$CategoriesString .= ">" . $Category->Category_Name . " <span>(" . $ProdCats[$Category->Category_ID] . ")</span></option>";
				}
				else {
					if ($Sidebar_Order == "Hierarchical") {
						$SubCategory_Count = 0;
						foreach ($SubCategories as $SubCategory) {
							if ($SubCategory->Category_ID == $Category->Category_ID) {
								$SubCategory_Count++;
							}
						}
					}
	
					$CategoriesString .= "<div id='prod-cat-sidebar-category-item-" . $Category->Category_ID . "' class='prod-cat-sidebar-category prod-sidebar-checkbox-" . $Sidebar_Checkbox_Style . " checkbox-color-" . "$Color";
					if (in_array($Category->Category_ID, $category)) {$CategoriesString .= " highlight" . $Color;}
					$CategoriesString .= "'>\n";
					if ($Display_Category_Image == "Sidebar" and $Category->Category_Image != "") {$CategoriesString .= "<div class='upcp-category-img-div'><img src='" . $Category->Category_Image . "' /></div>";}
					$CategoriesString .= "<input type='" . strtolower($Categories_Control_Type) . "' name='Category' value='" . $Category->Category_ID . "' onclick='UPCP_DisplayPage(\"1\"); UPCPHighlight(this, \"" . $Color . "\");' id='cat-". $Category->Category_ID ."' class='jquery-prod-cat-value'";
					if (in_array($Category->Category_ID, $category)) {$CategoriesString .= "checked=checked";}
					$CategoriesString .= "><label class='upcp-label' for='cat-". $Category->Category_ID ."'> <span>" . $Category->Category_Name . " <span>(" . $ProdCats[$Category->Category_ID] . ")</span></span>" ;
					$CategoriesString .= "</label>\n";
					if (($Sidebar_Order == "Hierarchical") and ($Sidebar_Subcat_Collapse == "yes") and $SubCategory_Count > 0) {
						$CategoriesString .= "<span class='cat-collapsible' onclick='UPCP_Show_Hide_Subcat(" . $Category->Category_ID . ")' id='cat-collapsible-" . $Category->Category_ID . "'>+</span>";
					}
					$CategoriesString .= "</div>\n";
	
					if ($Sidebar_Order == "Hierarchical" and $SubCategory_Count > 0) {
						if ($Sidebar_Subcat_Collapse == "yes") {
									$CategoriesString .= "<div id='subcat-collapsible-" . $Category->Category_ID . "' class='subcat-collapsible' style='display:none'>";
									}
						foreach ($SubCategories as $SubCategory) {
							if ($SubCategory->Category_ID == $Category->Category_ID) {
								$CategoriesString .= "<div id='prod-cat-sidebar-subcategory-item-" . $SubCategory->SubCategory_ID . "' class='prod-cat-sidebar-subcategory upcp-margin-left-6 upcp-margin-top-minus-2 prod-sidebar-checkbox-" . $Sidebar_Checkbox_Style . " checkbox-color-" . "$Color";
								if (in_array($SubCategory->SubCategory_ID, $subcategory)) {$CategoriesString .= " highlight" . $Color;}
								$CategoriesString .= "'>\n";
								if ($Display_SubCategory_Image == "Sidebar" and $SubCategory->SubCategory_Image != "") {$CategoriesString .= "<div class='upcp-subcategory-img-div'><img src='" . $SubCategory->SubCategory_Image . "' /></div>";}
								$CategoriesString .= "<input type='" . strtolower($SubCategories_Control_Type) . "' name='SubCategory' value='" . $SubCategory->SubCategory_ID . "'  onclick='UPCP_DisplayPage(\"1\"); UPCPHighlight(this, \"" . $Color . "\");' id='sub-" . $SubCategory->SubCategory_ID . "' class='jquery-prod-sub-cat-value' data-parent='" . $SubCategory->Category_ID . "' ";
								if (in_array($SubCategory->SubCategory_ID, $subcategory)) {$CategoriesString .= "checked=checked";}
								$CategoriesString .= "><label class='upcp-label' for='sub-". $SubCategory->SubCategory_ID ."'><span> " . $SubCategory->SubCategory_Name . " <span>(" . $ProdSubCats[$SubCategory->SubCategory_ID] . ")</span></span></label>\n";
								$CategoriesString .= "</div>\n";
							}
						}
						if ($Sidebar_Subcat_Collapse == "yes") {
									$CategoriesString .= "</div>";
									}
					}
				}
			}
			if ($Categories_Control_Type == "Dropdown") {$CategoriesString .= "</select>";}
			$CategoriesString .= "</div>\n</div>\n";
			$SidebarString .= apply_filters('upcp_sidebar_categories_div', $CategoriesString);
		}

		// Create the sub-categories checkboxes
		if ($Sidebar_Item == "Sub-Categories" and sizeof($SubCategories) > 0 and $Sidebar_Order != "Hierarchical") {
			$SubCategoriesString = "<div id='prod-cat-sidebar-subcategory-div-" . $id . "' class='prod-cat-sidebar-subcategory-div'>\n";
			$SubCategoriesString .= "<div id='prod-cat-sidebar-subcategory-title-" . $id . "' class='prod-cat-sidebar-cat-title prod-cat-sidebar-subcategory-title prod-cat-sidebar-hover-"  . $Sidebar_Title_Hover . "' data-title='2'";
			if ($Sidebar_Title_Collapse == "yes") {$SubCategoriesString .= "onclick='UPCP_Show_Hide_Sidebar(this);'";}
			$SubCategoriesString .= "><h3>" . $SubCategories_Text . "</h3></div>\n";
			$SubCategoriesString .= "<div class='prod-cat-sidebar-content prod-cat-sidebar-subcategory-content' data-title='2' " . $Sidebar_Start_Collapsed_HTML . ">\n";
			if ($SubCategories_Control_Type == "Dropdown") {
				$SubCategoriesString .= "<select name='SubCategory' onchange='UPCP_DisplayPage(\"1\");' class='upcp-jquery-subcat-dropdown'>";
				$SubCategoriesString .= "<option value='All'>" . $Show_All_Label . "</option>";
			}
			foreach ($SubCategories as $SubCategory) {
				if ($SubCategories_Control_Type == "Dropdown") {
					$SubCategoriesString .= "<option class='jquery-prod-sub-cat-value' value='" . $SubCategory->SubCategory_ID . "' data-parent='" . $SubCategory->Category_ID . "' ";
					if (in_array($SubCategory->SubCategory_ID, $subcategory)) {$SubCategoriesString .= "selected=selected";}
					$SubCategoriesString .= ">" . $SubCategory->SubCategory_Name . " <span>(" . $ProdSubCats[$SubCategory->SubCategory_ID] . ")</span></option>";}
				else {
					$SubCategoriesString .= "<div id='prod-cat-sidebar-subcategory-item-" . $SubCategory->SubCategory_ID . "' class='prod-cat-sidebar-subcategory prod-sidebar-checkbox-" . $Sidebar_Checkbox_Style . " checkbox-color-" . "$Color";
					if (in_array($SubCategory->SubCategory_ID, $subcategory)) {$SubCategoriesString .= " highlight" . $Color;}
					$SubCategoriesString .= "'>\n";
					if ($Display_SubCategory_Image == "Sidebar" and $SubCategory->SubCategory_Image != "") {$SubCategoriesString .= "<div class='upcp-subcategory-img-div'><img src='" . $SubCategory->SubCategory_Image . "' /></div>";}
					$SubCategoriesString .= "<input type='" . strtolower($SubCategories_Control_Type) . "' name='SubCategory' value='" . $SubCategory->SubCategory_ID . "'  onclick='UPCP_DisplayPage(\"1\"); UPCPHighlight(this, \"" . $Color . "\");' id='sub-" . $SubCategory->SubCategory_ID . "' class='jquery-prod-sub-cat-value' data-parent='" . $SubCategory->Category_ID . "' ";
					if (in_array($SubCategory->SubCategory_ID, $subcategory)) {$SubCategoriesString .= "checked=checked";}
					$SubCategoriesString .= "><label class='upcp-label' for='sub-". $SubCategory->SubCategory_ID ."'><span> " . $SubCategory->SubCategory_Name . " <span>(" . $ProdSubCats[$SubCategory->SubCategory_ID] . ")</span></span></label>\n";
					$SubCategoriesString .= "</div>\n";
				}
			}
			if ($SubCategories_Control_Type == "Dropdown") {$SubCategoriesString .= "</select>";}
			$SubCategoriesString .= "</div>\n</div>\n";
			$SidebarString .= apply_filters('upcp_sidebar_subcategories_div', $SubCategoriesString);
		}

		// Create the tags checkboxes
		if ($Sidebar_Item == "Tags" and sizeof($Tags) > 0) {
			$TagsString = "<div id='prod-cat-sidebar-tag-div-" . $id . "' class='prod-cat-sidebar-tag-div'>\n";
			$TagsString .= "<div id='prod-cat-sidebar-tag-title-" . $id . "' class='prod-cat-sidebar-cat-title prod-cat-sidebar-tag-title prod-cat-sidebar-hover-"  . $Sidebar_Title_Hover . "' data-title='3'";
			if ($Sidebar_Title_Collapse == "yes") {$TagsString .= "onclick='UPCP_Show_Hide_Sidebar(this);'";}
			$TagsString .= "><h3>" . $Tags_Text . "</h3></div>\n";
			$TagsString .= "<div class='prod-cat-sidebar-content prod-cat-sidebar-content-tag' data-title='3' " . $Sidebar_Start_Collapsed_HTML . ">\n";
			if ($Tags_Control_Type == "Dropdown") {
				$TagsString .= "<select name='Tags' onchange='UPCP_DisplayPage(\"1\");' class='upcp-jquery-tags-dropdown'>";
				$TagsString .= "<option value='All'>" . $Show_All_Label . "</option>";
			}
			foreach ($Tags as $Tag) {
				if ($Tags_Control_Type == "Dropdown") {
					$TagsString .= "<option value='" . $Tag->Tag_ID . "' ";
					if (in_array($Tag->Tag_ID, $tags)) {$TagsString .= "selected=selected";}
					$TagsString .= ">" . $Tag->Tag_Name . "</option>";}
				else {
					$TagsString .= "<div id='prod-cat-sidebar-tag-item-" . $Tag->Tag_ID . "' class='prod-cat-sidebar-tag prod-sidebar-checkbox-" . $Sidebar_Checkbox_Style . " checkbox-color-" . "$Color";
					if (in_array($Tag->Tag_ID, $tags)) {$TagsString .= " highlight" . $Color;}
					$TagsString .= "'>\n";
					$TagsString .= "<input type='" . strtolower($Tags_Control_Type) . "' name='Tags' value='" . $Tag->Tag_ID . "'  onclick='UPCP_DisplayPage(\"1\"); UPCPHighlight(this, \"" . $Color . "\");' id='tag-" . $Tag->Tag_ID . "' class='jquery-prod-tag-value'";
					if (in_array($Tag->Tag_ID, $tags)) {$TagsString .= "checked=checked";}
					$TagsString .= "><label class='upcp-label' for='tag-". $Tag->Tag_ID ."'><span> " . $Tag->Tag_Name . "</span></label>\n";
					$TagsString .= "</div>";
				}
			}
			if ($Tags_Control_Type == "Dropdown") {$TagsString .= "</select>";}
			$TagsString .= "</div>\n</div>\n";
			$SidebarString .= apply_filters('upcp_sidebar_tags_div', $TagsString);
		}
	
		if ($Sidebar_Item == "Custom Fields" and sizeOf($Custom_Fields) > 0) {
			$CustomFieldsString = "<div id='prod-cat-sidebar-cf-div-" . $id . "' class='prod-cat-sidebar-cf-div'>\n";
			$CustomFieldsString .= "<div class='prod-cat-sidebar-cf' data-title='4'>\n";
			foreach ($Custom_Fields as $Custom_Field) {
				if (is_array($ProdCustomFields[$Custom_Field->Field_ID])) {
					$CustomFieldsString .= "<div id='prod-cat-sidebar-cf-" . $Custom_Field->Field_ID . "' class='prod-cat-sidebar-cf' data-cfid='" . $Custom_Field->Field_ID . "'>\n";
					$CustomFieldsString .= "<div class='prod-cat-sidebar-cat-title prod-cat-sidebar-cf-title prod-cat-sidebar-hover-"  . $Sidebar_Title_Hover . "' data-cfid='" . $Custom_Field->Field_ID . "'";
					if ($Sidebar_Title_Collapse == "yes") {$CustomFieldsString .= "onclick='UPCP_Show_Hide_CF(this);'";}
					$CustomFieldsString .= "'><h3>" . $Custom_Field->Field_Name . ":</h3></div>";
					$CustomFieldsString .= "<div id='prod-cat-sidebar-cf-options-" . $Custom_Field->Field_ID . "' class='prod-cat-sidebar-content prod-cat-sidebar-cf-content upcp-cf-" . $Custom_Fields_Show_Hide . "' data-cfid='" . $Custom_Field->Field_ID . "' " . $Sidebar_Start_Collapsed_HTML . ">";
					ksort($ProdCustomFields[$Custom_Field->Field_ID]);
					if ($Custom_Field->Field_Control_Type == "Slider") {
						reset($ProdCustomFields[$Custom_Field->Field_ID]);
						foreach ($ProdCustomFields[$Custom_Field->Field_ID] as $key => $value) {
							$Min_Value = $key;
							if ($Min_Value != '') {break;}
						}
						end($ProdCustomFields[$Custom_Field->Field_ID]);
						$Max_Value = key($ProdCustomFields[$Custom_Field->Field_ID]);
						$CustomFieldsString .= "<div class='upcp-custom-field-slider-container'>";
						$CustomFieldsString .= "<div id='upcp-custom-field-" . $Custom_Field->Field_ID . "' class='upcp-custom-field-slider' data-fieldid='" . $Custom_Field->Field_ID . "' data-minvalue='" . $Min_Value . "' data-maxvalue='" . $Max_Value . "'></div>";
						$CustomFieldsString .= "<span class='upcp-custom-field-range' id='upcp-custom-field-range-" . $Custom_Field->Field_ID . "'>";
						$CustomFieldsString .= "<span class='upcp-custom-field-slider-min-span'>";
						$CustomFieldsString .= "<input type='text' value='" . $Min_Value . "' class='upcp-custom-field-slider-min " . ($Slider_Filter_Inputs != "Yes" ? "upcp-hidden-text-field' disabled" : "'") . " data-fieldid='" . $Custom_Field->Field_ID . "' />";
						$CustomFieldsString .= "</span>";
						$CustomFieldsString .= "<span class='upcp-price-slider-divider'> - </span>";
						$CustomFieldsString .= "<span class='upcp-custom-field-slider-max-span'>";
						$CustomFieldsString .= "<input type='text' value='" . $Max_Value . "' class='upcp-custom-field-slider-max " . ($Slider_Filter_Inputs != "Yes" ? "upcp-hidden-text-field' disabled" : "'") . " data-fieldid='" . $Custom_Field->Field_ID . "' />";
						$CustomFieldsString .= "</span>";
						$CustomFieldsString .= "</span>";
						$CustomFieldsString .= "</div>";
					}
					elseif ($Custom_Field->Field_Control_Type == "Dropdown") {
						$CustomFieldsString .= "<select name='Custom_Field_" . $Custom_Field->Field_ID . "' value='" . $Meta_Value . "'  onchange='UPCP_DisplayPage(\"1\");' id='cf-" . $Custom_Field->Field_ID . "' class='jquery-prod-cf-select' data-fieldid='" . $Custom_Field->Field_ID . "' /> ";
						$CustomFieldsString .= "<option value='All' id='cf-" . $Custom_Field->Field_ID . "-all' class='jquery-prod-cf-dropdown-value' />" . $Show_All_Label . "</option>";
						foreach ($ProdCustomFields[$Custom_Field->Field_ID]  as $Meta_Value => $Count) {
							if ($Meta_Value != '') {$CustomFieldsString .= "<option value='" . $Meta_Value . "' id='cf-" . $Custom_Field->Field_ID . "-" . $Meta_Value . "' class='jquery-prod-cf-dropdown-value' />" . $Meta_Value . " (" . $Count . ")</option>";}
						}
						$CustomFieldsString .= "</select>";
					}
					else {
						foreach ($ProdCustomFields[$Custom_Field->Field_ID]  as $Meta_Value => $Count) {
							if ($Meta_Value != '') {
								$CustomFieldsString .= "<div class='prod-cat-sidebar-cf-value-div prod-sidebar-checkbox-" . $Sidebar_Checkbox_Style . " checkbox-color-" . $Color . "'>";
								if ($Custom_Field->Field_Control_Type == "Radio") {$CustomFieldsString .= "<input type='radio' name='Custom_Field_" . $Custom_Field->Field_ID . "' value='" . $Meta_Value . "'  onclick='UPCP_DisplayPage(\"1\"); UPCPHighlight(this, \"" . $Color . "\");' id='cf-" . $Custom_Field->Field_ID . "-" . $Meta_Value . "' class='jquery-prod-cf-value' /> ";}
								elseif ($Custom_Field->Field_Control_Type != "Radio" and $Custom_Field->Field_Control_Type != "Slider") {$CustomFieldsString .= "<input type='checkbox' name='Custom_Field[]' value='" . $Meta_Value . "'  onclick='UPCP_DisplayPage(\"1\"); UPCPHighlight(this, \"" . $Color . "\");' id='cf-" . $Custom_Field->Field_ID . "-" . $Meta_Value . "' class='jquery-prod-cf-value' /> ";}
								$CustomFieldsString .= "<label class='upcp-label' for='cf-" . $Custom_Field->Field_ID . "-" . $Meta_Value . "' data-cf_value='" . $Meta_Value . "'><span>" . $Meta_Value . " <span>(" . $Count . ")</span></span></label>";
								$CustomFieldsString .= "</div>";
							}
						}
					}
					$CustomFieldsString .= "</div>";
					$CustomFieldsString .= "</div>\n";
				}
			}
			$CustomFieldsString .= "</div>\n</div>\n";
			$SidebarString .= apply_filters('upcp_sidebar_custom_fields_div', $CustomFieldsString);
		}

	}

	$SidebarString .= "</form>\n</div>\n";

	return $SidebarString;
}

function BuildGridster($Gridster, $Product, $Item_Images, $Description, $PhotoURL, $SP_Perm_URL, $Return_URL, $TagsString, $Lightbox_Class, $Lightbox_Clicker_Class) {
	global $wpdb, $fields_meta_table_name, $fields_table_name;
	global $UPCP_Options;

	$Disable_Lightbox = "";
	$Back_To_Catalogue_Label = $UPCP_Options->Get_Option("UPCP_Back_To_Catalogue_Label");
	if ($Back_To_Catalogue_Label != "") {$Back_To_Catalogue_Text = $Back_To_Catalogue_Label;}
	else {$Back_To_Catalogue_Text = __("Back to Catalog", 'ultimate-product-catalogue');}

	$Product_Object = new UPCP_Product(array('ID' => $Product->Item_ID));
	$Item_Display_Price = $Product_Object->Get_Product_Price("Display");
	$ProductString = "";
	$MaxCol = "";
	if (is_array($Gridster)) {
		foreach ($Gridster as $Element) {
			switch ($Element->element_class) {
				case "additional_images":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-addt-images-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= "<div id='prod-cat-addt-details-thumbs-div-" . $Product->Item_ID . "' class='prod-cat-addt-details-thumbs-div'>";
					$Slide_Counter = 0;
					$ProductString .= "<a href='" . $PhotoURL . "' class='" . $Lightbox_Class . "' data-ulbsource='" . $PhotoURL . "'><img src='" . $PhotoURL . "' id='prod-cat-addt-details-thumb-P". $Product->Item_ID . "' class='prod-cat-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"0\"); return false;'></a>";
					foreach ($Item_Images as $Image) {$Slide_Counter++; $ProductString .= "<a href='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' class='" . $Lightbox_Class . "' data-ulbsource='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' data-ulbtitle='" . htmlspecialchars($Image->Title, ENT_QUOTES) . "' data-ulbdescription='" . htmlspecialchars($Image->Caption, ENT_QUOTES) . "'><img src='" . htmlspecialchars($Image->Item_Image_URL, ENT_QUOTES) . "' id='prod-cat-addt-details-thumb-". $Image->Item_Image_ID . "' class='prod-cat-addt-details-thumb " . $Disable_Lightbox . "' onclick='ZoomImage(\"" . $Product->Item_ID . "\", \"" . $Image->Item_Image_ID . "\"); return false;'></a>";}
					$ProductString .= "</div>";
					break;
				case "back":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-back-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= "<a class='upcp-catalogue-link' href='" . $Return_URL . "'>&#171; " . $Back_To_Catalogue_Text . "</a>";
					break;
				case "blank":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-blank-div gs-w' style='display: list-item; position:absolute;'>";
					break;
				case "category":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-cat-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= $Product->Category_Name;
					break;
				case "category_label":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-cat-label-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= __("Category:", 'ultimate-product-catalogue') . " ";
					break;
				case "description":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-description-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= $Description;
					break;
				case "main_image":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-main-image-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= "<a href='" . $PhotoURL . "' class='prod-cat-addt-details-link-a " . $Lightbox_Clicker_Class . "' data-ulbsource='" . $PhotoURL . "' data-ulbtitle='" . htmlspecialchars(UPCP_Get_Image_Title($PhotoURL), ENT_QUOTES) . "' data-ulbdescription='" . htmlspecialchars(UPCP_Get_Image_Caption($PhotoURL), ENT_QUOTES) . "'>";
					$ProductString .= "<img src='" . $PhotoURL . "' alt='" . $Product->Item_Name . " Image' id='prod-cat-addt-details-main-" . $Product->Item_ID . "' class='prod-cat-addt-details-main' />";
					$ProductString .= "</a>";
					break;
				case "next_previous":
					$Next_Previous_Type = $UPCP_Options->Get_Option("UPCP_Next_Previous");
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-prod-name-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= Get_Next_Previous($Product, $Next_Previous_Type);
				case "price":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-price-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= apply_filters('upcp_product_page_price', "<h3 class='prod-cat-addt-details-price'>" . $Item_Display_Price . "</h3>", array('Item_ID' => $Product->Item_ID, 'Item_Price' => $Product->Item_Price));
					break;
				case "price_label":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-price-label-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= "Price: ";
					break;
				case "product_link":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-prod-link-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= "<a class='no-underline' href='http://" . $_SERVER['HTTP_HOST'] . $SP_Perm_URL . "'><img class='upcp-product-url-icon' src='" . get_bloginfo('wpurl') . "/wp-content/plugins/ultimate-product-catalogue/images/insert_link.png' /></a>";
					break;
				case "product_name":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-prod-name-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= "<h2 class='prod-cat-addt-details-title upcp-cpp-title'>" . apply_filters('upcp_product_page_title', $Product->Item_Name, array('Item_ID' => $Product->Item_ID, 'Item_Title' => $Product->Item_Name)) . "</h2>";
					break;
				case "related_products":
					$Related_Type = $UPCP_Options->Get_Option("UPCP_Related_Products");
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-prod-name-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= UPCP_Get_Related_Products($Product, $Related_Type);
					break;
				case "subcategory":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-sub-cat-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= $Product->SubCategory_Name;
					break;
				case "subcategory_label":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-sub-cat-label-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= __("Sub-Category:", 'ultimate-product-catalogue') . " ";
					break;
				case "tags":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-tags-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= $TagsString;
					break;
				case "tags_label":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-tags-label-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= __("Tags:", 'ultimate-product-catalogue') . " ";
					break;
				case "text":
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-tags-label-div gs-w' style='display: list-item; position:absolute;'>";
					$ProductString .= do_shortcode($Element->element_id);
					break;
				case "custom_field":
					$Field = $wpdb->get_row("SELECT Field_Name, Field_Type FROM $fields_table_name WHERE Field_ID='" . $Element->element_id ."'");
					$Field_Value = $wpdb->get_row("SELECT Meta_Value FROM $fields_meta_table_name WHERE Field_ID='" . $Element->element_id ."' AND Item_ID='" . $Product->Item_ID . "'");
					$Meta_Value = UPCP_Decode_CF_Commas($Field_Value->Meta_Value);
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-custom-field-div gs-w prod-page-custom-field-" . $Field->Field_Name . "' style='display: list-item; position:absolute;'>";
					if ($Field->Field_Type == "file") {
						$upload_dir = wp_upload_dir();
						$ProductString .= "<a href='" . $upload_dir['baseurl'] . "/upcp-product-file-uploads/" . $Meta_Value . "' download>" . $Meta_Value . "</a>";
					}
					elseif ($Field->Field_Type == "link") {$ProductString .= "<a href='" . $Meta_Value . "'>" . $Meta_Value . "</a>";}
					else {if(is_object($Field_Value)){$ProductString .= do_shortcode($Meta_Value);}}
					break;
				case "custom_label":
					$Field = $wpdb->get_row("SELECT Field_Name FROM $fields_table_name WHERE Field_ID='" . $Element->element_id ."'");
					$ProductString .= "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "' class='prod-page-div prod-page-front-end prod-page-custom-field-label-div gs-w prod-page-custom-field-label-" . $Field->Field_Name . "' style='display: list-item; position:absolute;'>";
					$ProductString .= $Field->Field_Name . ": ";
					break;
			}
			$MaxCol = max($MaxCol, $Element->col);
			$ProductString .= "</li>";
		}
	}

	return $ProductString;
}

function UPCP_Get_Product_Page_Breadcrumbs($Product, $Return_URL) {
	global $UPCP_Options;

	$Breadcrumbs = $UPCP_Options->Get_Option("UPCP_Breadcrumbs");

	$Back_To_Catalogue_Label = $UPCP_Options->Get_Option("UPCP_Back_To_Catalogue_Label");
	if ($Back_To_Catalogue_Label == "") {$Back_To_Catalogue_Label = __("Back to Catalog", 'ultimate-product-catalogue');}

	if ($Breadcrumbs == "None" or $Breadcrumbs == "") {
		$BreadcrumbsString .= "<div class='prod-cat-back-link'>";
		$BreadcrumbsString .= "<a class='upcp-catalogue-link' href='" . $Return_URL . "'>&#171; " . $Back_To_Catalogue_Label . "</a>";
		$BreadcrumbsString .= "</div>";
	}
	else {
		$Catalogue_Label = get_the_title();
		if ($Catalogue_Label == "") {$Catalogue_Label = __("Catalog", 'ultimate-product-catalogue');}

		$Return_URL = preg_replace("/sub-categories=(.*?)(&|$)/", "", $Return_URL);
		$Return_URL = preg_replace("/categories=(.*?)(&|$)/", "", $Return_URL);

		if (substr($Return_URL, -1) == "?") {$Category_URL = $Return_URL . "categories=" . $Product->Category_ID;}
		else {$Category_URL = $Return_URL . "?categories=" . $Product->Category_ID;}

		$SubCategories_URL = $Category_URL . "&sub-categories=" . $Product->SubCategory_ID;

		$BreadcrumbsString = "<div class='upcp-product-page-breadcrumbs'>";
		$BreadcrumbsString .= "<a href='" . $Return_URL . "' class='upcp-catalogue-link'><span>" . $Catalogue_Label . "</span></a>";
		if ($Breadcrumbs == "Categories" or $Breadcrumbs == "SubCategories") {$BreadcrumbsString .= " &#187; " . "<a href='" . $Category_URL . "' class='upcp-catalogue-link'><span>" . $Product->Category_Name . "</span></a>";}
		if ($Breadcrumbs == "SubCategories") {$BreadcrumbsString .= " &#187; " . "<a href='" . $SubCategories_URL . "' class='upcp-catalogue-link'><span>" . $Product->SubCategory_Name . "</span></a>";}
		$BreadcrumbsString .= "</div>";
	}

	return $BreadcrumbsString;
}

function UPCP_Add_Product_Page_Social_Media($Product, $Product_Permalink) {
	global $UPCP_Options;

	$ReturnString = "";
	$Socialmedia_String = $UPCP_Options->Get_Option("UPCP_Social_Media");
    $Socialmedia = explode(",", $Socialmedia_String);

	if ($Socialmedia[0] != "Blank" and $Socialmedia[0] != "") {
		$ReturnString .= "<div class='upcp-social-links'>";
		$ReturnString .= "<ul class='rrssb-buttons'>";
	}
	if(in_array("Facebook", $Socialmedia)) {$ReturnString .= UPCP_Add_Social_Media_Buttons("Facebook", $Product_Permalink, $Product->Item_Name);}
	if(in_array("Google", $Socialmedia)) {$ReturnString .= UPCP_Add_Social_Media_Buttons("Google", $Product_Permalink, $Product->Item_Name);}
	if(in_array("Twitter", $Socialmedia)) {$ReturnString .= UPCP_Add_Social_Media_Buttons("Twitter", $Product_Permalink, $Product->Item_Name);}
	if(in_array("Linkedin", $Socialmedia)) {$ReturnString .= UPCP_Add_Social_Media_Buttons("Linkedin", $Product_Permalink, $Product->Item_Name);}
	if(in_array("Pinterest", $Socialmedia)) {$ReturnString .= UPCP_Add_Social_Media_Buttons("Pinterest", $Product_Permalink, $Product->Item_Name);}
	if(in_array("Email", $Socialmedia)) {$ReturnString .= UPCP_Add_Social_Media_Buttons("Email", $Product_Permalink, $Product->Item_Name);}
	if ($Socialmedia[0] != "Blank" and $Socialmedia[0] != "") {
		$ReturnString .= "</ul>";
		$ReturnString .= "</div>";
	}

	return $ReturnString;
}


function Get_Next_Previous($Product, $Next_Previous_Type = "Manual") {
	global $wpdb, $items_table_name;
	global $UPCP_Options;

	$ProductString = "";

	$Next_Product_Label = $UPCP_Options->Get_Option("UPCP_Next_Product_Label");
	if ($Next_Product_Label != "") {$Next_Product_Text = $Next_Product_Label;}
	else {$Next_Product_Text = __("Next Product:", 'ultimate-product-catalogue');}
	$Previous_Product_Label = $UPCP_Options->Get_Option("UPCP_Previous_Product_Label");
	if ($Previous_Product_Label != "") {$Previous_Product_Text = $Previous_Product_Label;}
	else {$Previous_Product_Text = __("Previous Product:", 'ultimate-product-catalogue');}

	if ($Next_Previous_Type == "Manual") {
		$Next_Product_ID = substr($Product->Item_Next_Previous, 0, strpos($Product->Item_Next_Previous, ","));
		$Previous_Product_ID = substr($Product->Item_Next_Previous, strpos($Product->Item_Next_Previous, ",")+1);
	}
	elseif ($Next_Previous_Type == "Auto") {
		$Next_Product_ID = $wpdb->get_var("SELECT Item_ID FROM $items_table_name WHERE Item_ID>'" . $Product->Item_ID . "' ORDER BY Item_ID ASC LIMIT 1");
		$Previous_Product_ID = $wpdb->get_var("SELECT Item_ID FROM $items_table_name WHERE Item_ID<'" . $Product->Item_ID . "' ORDER BY Item_ID DESC LIMIT 1");
	}

	$Next_Product = $wpdb->get_row("SELECT * FROM $items_table_name WHERE Item_ID='" . $Next_Product_ID ."'");
	$Previous_Product = $wpdb->get_row("SELECT * FROM $items_table_name WHERE Item_ID='" . $Previous_Product_ID ."'");

	$ProductString .= "<div class='upcp-next-previous-products'>";
	$ProductString .= "<div class='upcp-next-product upcp-minimal-product-listing'>";
	$ProductString .= "<div class='upcp-next-product-title'>" . $Next_Product_Text . "</div>";
	$ProductString .= Build_Minimal_Product_Listing($Next_Product);
	$ProductString .= "<div class='upcp-clear'></div>";
	$ProductString .= "</div>";
	$ProductString .= "<div class='upcp-previous-product upcp-minimal-product-listing'>";
	$ProductString .= "<div class='upcp-previous-product-title'>" . $Previous_Product_Text . "</div>";
	$ProductString .= Build_Minimal_Product_Listing($Previous_Product);
	$ProductString .= "<div class='upcp-clear'></div>";
	$ProductString .= "</div>";
	$ProductString .= "<div class='upcp-clear'></div>";
	$ProductString .= "</div>";

	return apply_filters('upcp_next_previous_div', $ProductString, array('Item_ID' => $Product->Item_ID));
}

function UPCP_Get_Related_Products($Product, $Related_Type = "Auto") {
	global $wpdb, $items_table_name;
	global $UPCP_Options;

	$ID_String = "";
	$ProductString = "";

	if ($UPCP_Options->Get_Option("UPCP_Related_Products_Label") != "") {$Related_Products_Label = $UPCP_Options->Get_Option("UPCP_Related_Products_Label");}
	else {$Related_Products_Label = __("Related Products:", 'ultimate-product-catalogue');}

	if ($Related_Type == "Manual") {
		$Related_Products_IDs = explode(",", $Product->Item_Related_Products);
		foreach ($Related_Products_IDs as $Related_Product_ID) {$ID_String .= "'" . $Related_Product_ID . "',";}
		$ID_String = substr($ID_String, 0, -1);
		$Related_Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE Item_ID IN (" . $ID_String . ")");
	}

	elseif ($Related_Type == "Auto") {
		$Ordered_Sub_Cat_Products = array();
		$Ordered_Cat_Products = array();

		$Sub_Category_Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE SubCategory_ID='" . $Product->SubCategory_ID . "' AND Item_ID!='" . $Product->Item_ID . "' AND Item_Display_Status='Show'", ARRAY_A);
		if ($wpdb->num_rows < 5) {
			$Category_Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE Category_ID='" . $Product->Category_ID . "' AND SubCategory_ID!='" . $Product->SubCategory_ID . "' AND Item_ID!='" . $Product->Item_ID . "' AND Item_Display_Status='Show'", ARRAY_A);
		}

		$Ordered_Sub_Cat_Products = Order_Products($Selected_Product, $Sub_Category_Products);
		if (isset($Category_Products)) {$Ordered_Cat_Products = Order_Products($Selected_Product, $Category_Products);}

		$Related_Products = $Ordered_Sub_Cat_Products + $Ordered_Cat_Products;
		$Related_Products = array_splice($Related_Products, 0, 5);
	}

	$ProductString .= "<div class='upcp-related-products'>";
	$ProductString .= "<div class='upcp-related-products-title'>" . $Related_Products_Label . "</div>";
	$ProductString .= "<div class='upcp-clear'></div>";
	foreach ($Related_Products as $Related_Product) {
		$ProductString .= "<div class='upcp-related-product upcp-minimal-product-listing'>";
		$ProductString .= Build_Minimal_Product_Listing($Related_Product);
		$ProductString .= "<div class='upcp-clear'></div>";
		$ProductString .= "</div>";
	}
	$ProductString .= "</div>";
	$ProductString .= "<div class='upcp-clear'></div>";

	return apply_filters('upcp_related_product_div', $ProductString, array('Item_ID' => $Product->Item_ID));
}

function Add_Product_Inquiry_Form($Product) {
	global $wpdb;
	global $fields_table_name, $fields_meta_table_name;
	global $UPCP_Options;

	$ProductString = "";

	if ($UPCP_Options->Get_Option("UPCP_Product_Inquiry_Form_Title_Label") != "") {$Product_Inquiry_Form_Title_Label = $UPCP_Options->Get_Option("UPCP_Product_Inquiry_Form_Title_Label");}
	else {$Product_Inquiry_Form_Title_Label = __("Product Inquiry Form", 'ultimate-product-catalogue');}

	$Product_Object = new UPCP_Product(array('ID' => $Product->Item_ID));

	$plugin = "contact-form-7/wp-contact-form-7.php";
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$CF_7_Installed = is_plugin_active($plugin);

	if ($CF_7_Installed) {
		$UPCP_Contact_Form = get_page_by_path('upcp-product-inquiry-form', OBJECT, 'wpcf7_contact_form');

		$ProductString .= "<div class='upcp-contact-form-7-product-form'>";
		$ProductString .= "<h4>" . $Product_Inquiry_Form_Title_Label . "</h4>";
		$Search_Array = array('%PRODUCT_NAME%', '%PRODUCT_ID%', '%PRODUCT_PRICE%', '%PRODUCT_CATEGORY%', '%PRODUCT_SUBCATEGORY%', '%PRODUCT_TAGS%', '%PRODUCT_DESCRIPTION%');
		$Replace_Array = array($Product->Item_Name, $Product->Item_ID, $Product_Object->Get_Product_Price("Currency"), $Product->Category_Name, $Product->SubCategory_Name, $Product_Object->Get_Product_Tag_String(), $Product->Item_Description);

		$Fields = $wpdb->get_results("SELECT Field_ID, Field_Type, Field_Slug FROM $fields_table_name");
		foreach ($Fields as $Field) {
			$Value = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $fields_meta_table_name WHERE Item_ID=%d and Field_ID=%d", $Product->Item_ID, $Field->Field_ID));
			$Value = UPCP_Decode_CF_Commas($Value);
			if ($Field->Field_Type == "select" or $Field->Field_Type == "radio" or $Field->Field_Type == "checkbox") {
				$Values = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Value)));
				if (!is_array($Values)) {$Values = array();}
				for ($i=1; $i<=20; $i++) {$Search_Array[] = "%" . $Field->Field_Slug . "%" . $i . "%";}
				for ($i=0; $i<=19; $i++) {$Replace_Array[] = (array_key_exists($i, $Values) ? $Values[$i] : '');};
			}
			else {
				$Search_Array[] = "%" . $Field->Field_Slug . "%";
				$Replace_Array[] = do_shortcode($Value);
			}
		}

		$ProductString .= str_replace($Search_Array, $Replace_Array, do_shortcode('[contact-form-7 id="' . $UPCP_Contact_Form->ID . '" title="' . $UPCP_Contact_Form->post_title . '"]'));
		$ProductString .= "</div>";
	}

	return $ProductString;
}

function UPCP_Add_Product_Reviews($Product) {
	$ReturnString = do_shortcode("[ultimate-reviews product_name='" . htmlspecialchars($Product->Item_Name, ENT_QUOTES) . "' review_filtering='&lsqb;&rsqb;']");
	$ReturnString .= "<div class='ewd-urp-woocommerce-tab-divider'></div>";
	$ReturnString .= "<h2>" . __("Leave a review", 'EWD_URP') . "</h2>";
	$ReturnString .= "<style>.ewd-urp-form-header {display:none;}</style>";
	$ReturnString .= do_shortcode("[submit-review product_name='" . $Product->Item_Name . "']");
	return $ReturnString;
}

function UPCP_Get_Reviews_HTML($Product_Name) {
	global $wpdb;
	global $UPCP_Options;

	$Maximum_Score = $UPCP_Options->Get_Option("EWD_URP_Maximum_Score");

	$Filled_Class_Name = "dashicons dashicons-star-filled";
	$Half_Class_Name = "dashicons dashicons-star-half";
	$Empty_Class_Name = "dashicons dashicons-star-empty";

	$Post_IDs = "";

	$Adjustment_Factor = 5 / $Maximum_Score;

	$ReturnString = "";

    $Post_ID_Objects = $wpdb->get_results("
        SELECT $wpdb->posts.ID
        FROM $wpdb->posts
        INNER JOIN $wpdb->postmeta on $wpdb->posts.ID=$wpdb->postmeta.post_id
        WHERE $wpdb->postmeta.meta_key='EWD_URP_Product_Name'
        AND $wpdb->postmeta.meta_value='" . $Product_Name . "'
        AND $wpdb->posts.post_type = 'urp_review'
        ");

    foreach ($Post_ID_Objects as $Post_ID_Object) {$Post_IDs .= $Post_ID_Object->ID . ",";}
    if ($Post_IDs != "") {$Post_IDs = substr($Post_IDs, 0, -1);}

    if ($Post_IDs != "") {
    	$Average_Rating = $wpdb->get_var("
    		SELECT AVG(meta_value)
    		FROM $wpdb->postmeta
    		WHERE meta_key = 'EWD_URP_Overall_Score'
    		AND post_id IN (" . $Post_IDs . ")
    		");
    }
    else {
    	$Average_Rating = "";
    }

    if ($Average_Rating != "") {
    	$ReturnString .= "<span class='upcp-urp-review-score' title='" . __("Average Rating: ", 'ultimate-product-catalogue') . $Average_Rating . "'>";
    	for ($i = 1; $i <= 5; $i++) {
			if ($i <= (($Average_Rating * $Adjustment_Factor) + .25)) {$ReturnString .= "<span class='" . $Filled_Class_Name . "'></span>";}
			elseif ($i <= (($Average_Rating * $Adjustment_Factor) + .75)) {$ReturnString .= "<span class='" . $Half_Class_Name . "'></span>";}
			else {$ReturnString .= "<span class='" . $Empty_Class_Name . "'></span>";}
		}
    	$ReturnString .= "</span>";
    }
    else {
    	$ReturnString .= "<span class='upcp-urp-review-score' title='" . __("Average Rating: ", 'ultimate-product-catalogue') . "0'></span>";
    }

    return $ReturnString;
}

function Order_Products($Product, $Related_Products_Array) {
	global $wpdb, $tagged_items_table_name;

	$Product_Tags = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID='" . $Product['Item_ID'] . "'", ARRAY_A);

	foreach ($Related_Products_Array as $Related_Product) {
		$Related_Product_Tags = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID='" . $Related_Product['Item_ID'] . "'", ARRAY_A);
		$Intersect = array_intersect($Product_Tags, $Related_Product_Tags);
		$Related_Product['Score'] = sizeOf($Intersect);
		unset($Related_Product_Tags);
	}

	usort($Related_Products_Array, 'Score_Sort');

	return $Related_Products_Array;
}

function Score_Sort($a, $b) {
	return $a['Score'] == $b['Score'] ? 0 : ($a['Score'] > $b['Score']) ? 1 : -1;
}

function Build_Minimal_Product_Listing($Product, $Catalogue_URL = "") {
	global $wpdb, $items_table_name;
	global $UPCP_Options;

	$Links = $UPCP_Options->Get_Option("UPCP_Product_Links");

	$ProductString = "";

	$Currency_Symbol = $UPCP_Options->Get_Option("UPCP_Currency_Symbol");
	$Currency_Symbol_Location = $UPCP_Options->Get_Option("UPCP_Currency_Symbol_Location");
	$Thumbnail_Support = $UPCP_Options->Get_Option("UPCP_Thumbnail_Support");

	$Pretty_Links = $UPCP_Options->Get_Option("UPCP_Pretty_Links");
	$Permalink_Base = $UPCP_Options->Get_Option("UPCP_Permalink_Base");
	if ($Permalink_Base == "") {$Permalink_Base = "product";}

	if (is_array($Product)) {$Product = $wpdb->get_row("SELECT * FROM $items_table_name WHERE Item_ID='" . $Product['Item_ID'] . "'");}

	if (!is_object($Product)) {return;}

	if ($Product->Item_Sale_Mode == "Yes") {$Product->Item_Price  = $Product->Item_Sale_Price;}
	else {$Product->Item_Price  = $Product->Item_Price;}

	if ($Currency_Symbol_Location == "Before" and is_object($Product)) {$Product->Item_Price = $Currency_Symbol . $Product->Item_Price;}
	elseif (is_object($Product)) {$Product->Item_Price .= $Currency_Symbol;}

	$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
	if ($Catalogue_URL == "") {
		$Base = $uri_parts[0];
		if ($Pretty_Links == "Yes") {$Base = substr($Base, 0, strpos($Base, "/" . $Permalink_Base . "/")+1);}
	}
	else {$Base = $Catalogue_URL;}
	if (trim($Product->Item_Link) != "") {$ItemLink = $Product->Item_Link;}
	elseif ($Pretty_Links == "Yes") {$ItemLink = $Base . $Permalink_Base . "/" . $Product->Item_Slug . "/?" . $uri_parts[1];}
	elseif (strpos($uri_parts[1], "page_id") !== false) {$ItemLink = $Base . "?" . substr($uri_parts[1], 0, strpos($uri_parts[1], "&")) . "&SingleProduct=" . $Product->Item_ID;}
	else {$ItemLink = $Base . "?SingleProduct=" . $Product->Item_ID;}

	if ($Product->Item_Photo_URL != "") {
		$PhotoURL = htmlspecialchars($Product->Item_Photo_URL, ENT_QUOTES);
        if ($Thumbnail_Support == "Yes") {
            $Post_ID = UPCP_getIDfromGUID($PhotoURL);
            if ($Post_ID != "") {
                $PhotoURL_Array = wp_get_attachment_image_src($Post_ID,"medium");
                $PhotoURL = $PhotoURL_Array[0];
            }
        }
	}
	else {$PhotoURL = plugins_url('ultimate-product-catalogue/images/No-Photo-Available.png');}

	$ProductString .= "<a class='upcp-minimal-link' href='" . $ItemLink . "' " . ($Links == "New" ? "target='_blank'" : "") . ">";
	$ProductString .= "<div class='upcp-minimal-img-div'>";
	$ProductString .= "<img class='upcp-minimal-img' src='" . $PhotoURL . "' alt='Product Image' />";
	$ProductString .= "</div>";
	$ProductString .= "<div class='upcp-minimal-title'>" . $Product->Item_Name . "</div>";
	$ProductString .= "<div class='upcp-minimal-price'>" . $Product->Item_Price . "</div>";
	$ProductString .= "</a>";

	return $ProductString;
}

function UPCP_Product_Comparison($Products = array(), $omit_fields) {
	global $wpdb, $fields_table_name, $link_base;
	global $UPCP_Options;

	$Links = $UPCP_Options->Get_Option("UPCP_Product_Links");
	$Currency_Symbol = $UPCP_Options->Get_Option("UPCP_Currency_Symbol");
	$Currency_Symbol_Location = $UPCP_Options->Get_Option("UPCP_Currency_Symbol_Location");
	$Thumbnail_Support = $UPCP_Options->Get_Option("UPCP_Thumbnail_Support");
	$WooCommerce_Product_Page = $UPCP_Options->Get_Option("UPCP_WooCommerce_Product_Page");
	$Pretty_Links = $UPCP_Options->Get_Option("UPCP_Pretty_Links");
	$Permalink_Base = $UPCP_Options->Get_Option("UPCP_Permalink_Base");
	if ($Permalink_Base == "") {$Permalink_Base = "product";}

	$Categories_Label = $UPCP_Options->Get_Option("UPCP_Categories_Label");
	$SubCategories_Label = $UPCP_Options->Get_Option("UPCP_SubCategories_Label");
	$Tags_Label = $UPCP_Options->Get_Option("UPCP_Tags_Label");
	$Back_To_Catalogue_Label = $UPCP_Options->Get_Option("UPCP_Back_To_Catalogue_Label");

	if ($Categories_Label != "") {$Categories_Text = $Categories_Label;}
	else {$Categories_Text = __("Categories:", 'ultimate-product-catalogue');}
	if ($SubCategories_Label != "") {$SubCategories_Text = $SubCategories_Label;}
	else {$SubCategories_Text = __("Sub-Categories:", 'ultimate-product-catalogue');}
	if ($Tags_Label != "") {$Tags_Text = $Tags_Label;}
	else {$Tags_Text = __("Tags:", 'ultimate-product-catalogue');}
	if ($Back_To_Catalogue_Label != "") {$Back_To_Catalogue_Text = $Back_To_Catalogue_Label;}
	else {$Back_To_Catalogue_Text = __("Back to Catalog", 'ultimate-product-catalogue');}

	if(sizeOf($Products) <= 2){$Size_Class = "upcp-pc-half";}
	elseif(sizeOf($Products) == 3){$Size_Class = "upcp-pc-third";}
	else{$Size_Class = "upcp-pc-fourth";}

	if(sizeOf($Products) > 4){ 
		$prodCompWidth = sizeOf($Products) * 25;
		$prodCompWidthThird = sizeOf($Products) * (100 / 3);
		$prodCompWidthHalf = sizeOf($Products) * 50;
		$prodCompEachWidth = ( 100 / sizeOf($Products) ) - 2;
		$ReturnString .= '<style>';
			$ReturnString .= '.upcp-product-comparison-inner {';
				$ReturnString .= 'width: ' . $prodCompWidth . '%;';
			$ReturnString .= '}';
			$ReturnString .= '.upcp-pc-fourth {';
				$ReturnString .= 'width: ' . $prodCompEachWidth . '%;';
				$ReturnString .= 'margin: 32px 1%;';
			$ReturnString .= '}';
			$ReturnString .= '@media screen and (max-width: 1000px) {';
				$ReturnString .= '.upcp-product-comparison-inner {';
					$ReturnString .= 'width: ' . $prodCompWidthThird . '%;';
				$ReturnString .= '}';
				$ReturnString .= '.upcp-pc-fourth {';
					$ReturnString .= 'width: ' . $prodCompEachWidth . '%;';
					$ReturnString .= 'margin: 32px 1%;';
				$ReturnString .= '}';
			$ReturnString .= '}';
			$ReturnString .= '@media screen and (max-width: 768px) {';
				$ReturnString .= '.upcp-product-comparison-inner {';
					$ReturnString .= 'width: ' . $prodCompWidthHalf . '%;';
				$ReturnString .= '}';
				$ReturnString .= '.upcp-pc-fourth {';
					$ReturnString .= 'width: ' . $prodCompEachWidth . '%;';
					$ReturnString .= 'margin: 32px 1%;';
				$ReturnString .= '}';
			$ReturnString .= '}';
		$ReturnString .= '</style>';
	}


	$Omit_Fields_Array = explode(",", $omit_fields);
	if (!is_array($Omit_Fields_Array)) {$Omit_Fields_Array = array();}

	$Fields = $wpdb->get_results("SELECT Field_Name, Field_ID, Field_Type, Field_Display_Comparison FROM $fields_table_name");

	//$ReturnString = "<div class='upcp-product-comparison'>";
	//$ReturnString .= "</div class='upcp-product-comparison-back'>";
	$ReturnString .= "<a href='" . $_SERVER['REQUEST_URI'] . "'>" . $Back_To_Catalogue_Text . "</a>";
	$ReturnString .= "<div class='upcp-clear'></div>";
	$ReturnString .= "<div class='upcp-product-comparison-container'>";
	$ReturnString .= "<div class='upcp-product-comparison-inner'>";
	foreach ($Products as $Product_ID) {
		$Product = new UPCP_Product(array('ID' => $Product_ID));

		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$Base = $uri_parts[0];

		if (trim($Product->Get_Field_Value('Item_Link')) != "") {$ItemLink = $Product->Get_Field_Value('Item_Link');}
		elseif ($WooCommerce_Product_Page == "Yes") {$ItemLink = get_site_url() . "/product/" . $Product->Get_Field_Value('Item_Slug') . "/";}
		elseif ($link_base != "") {$ItemLink = $link_base . "?" . $uri_parts[1] . "&SingleProduct=" . $Product->Get_Item_ID();}
		elseif ($Pretty_Links == "Yes") {$ItemLink = $Base . $Permalink_Base . "/" . $Product->Get_Field_Value('Item_Slug') . "/?" . $uri_parts[1];}
		else {$ItemLink = $Base . "?" . $uri_parts[1] . "&SingleProduct=" . $Product->Get_Item_ID();}

		$PhotoURL = $Product->Get_Field_Value("Item_Photo_URL");

		if ($PhotoURL != "" and strlen($PhotoURL) > 7 and substr($PhotoURL, 0, 7) != "http://" and substr($PhotoURL, 0, 8) != "https://") {
			$PhotoCode = do_shortcode($PhotoURL);
		}
		elseif ($PhotoURL != "" and strlen($PhotoURL) > 7) {
			$PhotoURL = htmlspecialchars($PhotoURL, ENT_QUOTES);
			if ($Thumbnail_Support == "Yes") {
				$Post_ID = UPCP_getIDfromGUID($PhotoURL);
				if ($Post_ID != "") {$PhotoURL_Array = wp_get_attachment_image_src($Post_ID, "medium"); $PhotoURL = $PhotoURL_Array[0];}
			}
			$PhotoCode = "<img src='" . $PhotoURL . "' alt='" . $Product->Get_Product_Name() . " Image' id='prod-cat-thumb-" . $Product->Get_Item_ID() . "' class='prod-cat-thumb-image upcp-thumb-image'>";
		}
		else {
			$PhotoURL = plugins_url('ultimate-product-catalogue/images/No-Photo-Available.png');
			$PhotoCode = "<img src='" . $PhotoURL . "' alt='" . $Product->Get_Product_Name() . " Image' id='prod-cat-thumb-" . $Product->Get_Item_ID() . "' class='prod-cat-thumb-image upcp-thumb-image'>";
		}

		if ($Currency_Symbol_Location == "Before") {$Item_Price = $Currency_Symbol . $Product->Get_Field_Value("Item_Price");}
		else {$Item_Price = $Product->Get_Field_Value("Item_Price") . $Currency_Symbol;}

		$ReturnString .= "<div class='upcp-product-comparison-div " . $Size_Class . "' id='upcp-product-comparison-" . $Product->Get_Item_ID() . "'>";
		$ReturnString .= "<div class='upcp-product-comparison-title'>";
		$ReturnString .= "<a class='upcp-catalogue-link' href='" . $ItemLink . "' " . ($Links == "New" ? "target='_blank'" : "") . " onclick='RecordView(" . $Product->Get_Item_ID() . ");'>";
		$ReturnString .= $Product->Get_Product_Name();
		$ReturnString .= "</a>";
		$ReturnString .= "</div>";
		if (!in_array("Image", $Omit_Fields_Array)) {
			$ReturnString .= "<div class='upcp-product-comparison-image'>";
			$ReturnString .= $PhotoCode;
			$ReturnString .= "</div>";
		}
		if (!in_array("Price", $Omit_Fields_Array)) {
			$ReturnString .= "<div class='upcp-product-comparison-price upcp-pc-field'>";
			$ReturnString .= $Item_Price;
			$ReturnString .= "</div>";
		}
		if (!in_array("Categories", $Omit_Fields_Array)) {
			$ReturnString .= "<div class='upcp-product-comparison-category upcp-pc-field'>";
			$ReturnString .= "<div class='upcp-product-comparison-category-label upcp-pc-label'>" . $Categories_Text . "</div>";
			$ReturnString .= "<div class='upcp-product-comparison-category-value upcp-pc-value'>" . $Product->Get_Field_Value("Category_Name") . "</div>";
			$ReturnString .= "</div>";
		}
		if (!in_array("SubCategories", $Omit_Fields_Array)) {
			$ReturnString .= "<div class='upcp-product-comparison-sub-category upcp-pc-field'>";
			$ReturnString .= "<div class='upcp-product-comparison-subcategory-label upcp-pc-label'>" . $SubCategories_Text . "</div>";
			$ReturnString .= "<div class='upcp-product-comparison-subcategory-value upcp-pc-value'>" . $Product->Get_Field_Value("SubCategory_Name") . "</div>";
			$ReturnString .= "</div>";
		}
		if (!in_array("Tags", $Omit_Fields_Array)) {
			$ReturnString .= "<div class='upcp-product-comparison-tags upcp-pc-field'>";
			$ReturnString .= "<div class='upcp-product-comparison-tags-label upcp-pc-label'>" . $Tags_Text . "</div>";
			$ReturnString .= "<div class='upcp-product-comparison-tags-value upcp-pc-value'>" . $Product->Get_Product_Tag_String() . "</div>";
			$ReturnString .= "</div>";
		}
		foreach ($Fields as $Field) {
			if ($Field->Field_Display_Comparison != "No" and !in_array($Field->Field_Name, $Omit_Fields_Array)) {
				$ReturnString .= "<div class='upcp-product-comparison-custom-field upcp-pc-field' id='upcp-pc-cf-" . $Field->Field_ID . "'>";
				$ReturnString .= "<div class='upcp-product-comparison-custom-field-label upcp-pc-label'>" . $Field->Field_Name . ":</div>";
				if ($Field->Field_Type == "file") {$ReturnString .= "<div class='upcp-product-comparison-custom-field-value upcp-pc-value'><a href='" . $Product->Get_Custom_Field_By_ID($Field->Field_ID) . "'>" . $Product->Get_Custom_Field_By_ID($Field->Field_ID) . "</a></div>";}
				if ($Field->Field_Type == "link") {$ReturnString .= "<div class='upcp-product-comparison-custom-field-value upcp-pc-value'><a href='" . $Product->Get_Custom_Field_By_ID($Field->Field_ID) . "'>" . $Product->Get_Custom_Field_By_ID($Field->Field_ID) . "</a></div>";}
				else {$ReturnString .= "<div class='upcp-product-comparison-custom-field-value upcp-pc-value'>" . do_shortcode($Product->Get_Custom_Field_By_ID($Field->Field_ID)) . "</div>";}
				$ReturnString .= "</div>";
			}
		}
		$ReturnString .= "</div>";
	}
	$ReturnString .= "</div> <!-- upcp-product-comparison-inner -->";
	$ReturnString .= "</div> <!-- upcp-product-comparison-container -->";

	$ReturnString .= "</div>";

	return $ReturnString;
}

function UPCP_Get_Catalog_Overview($Catalogue_Items, $Overview_Type, $Category_ID = 0) {
	global $wpdb, $categories_table_name, $subcategories_table_name, $items_table_name;

	if ($Overview_Type == "Categories") {$ID_Name = "Category_ID";}
	else {$ID_Name = "SubCategory_ID";}
	if ($Overview_Type == "Categories") {$Paramter_Name = "categories";}
	else {$Paramter_Name = "sub-categories";}
	if ($Overview_Type == "Categories") {$Title_Name = "Category_Name";}
	else {$Title_Name = "SubCategory_Name";}
	if ($Overview_Type == "Categories") {$Image_Name = "Category_Image";}
	else {$Image_Name = "SubCategory_Image";}
	if ($Overview_Type == "Categories") {$Class_Added = "upcp-category";}
	else {$Class_Added = "upcp-subcategory";}

	$Item_IDs = array();
	foreach ($Catalogue_Items as $CatalogueItem) {
		if ($CatalogueItem->Item_ID != "" and $CatalogueItem->Item_ID != 0) {
			$Product = new UPCP_Product(array("ID" => $CatalogueItem->Item_ID));
			if ($Overview_Type == "Categories") {$Item_IDs[] = $Product->Get_Field_Value($ID_Name);}
			elseif ($Product->Get_Field_Value("Category_ID") == $Category_ID) {
				$Item_IDs[] = $Product->Get_Field_Value($ID_Name);
			}
		}
		elseif ($CatalogueItem->Category_ID != "" and $CatalogueItem->Category_ID != 0) {
			if ($Overview_Type == "Categories") {$Item_IDs[] = $CatalogueItem->Category_ID;}
			elseif ($Category_ID == $CatalogueItem->Category_ID) {
				$Products = $wpdb->get_results("SELECT Item_ID FROM $items_table_name WHERE Category_ID='" . $CatalogueItem->Category_ID . "'");
				foreach ($Products as $Product) {
					$Product = new UPCP_Product(array("ID" => $Product->Item_ID));
					$Item_IDs[] = $Product->Get_Field_Value($ID_Name);
				}
			}
		}
		elseif ($CatalogueItem->SubCategory_ID != "" and $CatalogueItem->SubCategory_ID != 0) {
			if ($Overview_Type == "Categories") {$Item_IDs[] = $wpdb->get_var("SELECT Category_ID FROM $subcategories_table_name WHERE SubCategory_ID='" . $CatalogueItem->SubCategory_ID . "'");}
			else {$Item_IDs[] = $CatalogueItem->SubCategory_ID;}
		}
	}

	$Item_IDs = array_filter($Item_IDs);
	if (empty($Item_IDs)) {return false;}

	$ID_String = implode(",", $Item_IDs);
	if ($Overview_Type == "Categories") {$Items = $wpdb->get_results("SELECT * FROM $categories_table_name WHERE Category_ID IN (" . $ID_String . ") ORDER BY Category_Sidebar_Order");}
	else {$Items = $wpdb->get_results("SELECT * FROM $subcategories_table_name WHERE SubCategory_ID IN (" . $ID_String . ") ORDER BY SubCategory_Sidebar_Order");}

	$ReturnString .= "<div class='upcp-overview-mode'>";
	foreach ($Items as $Item) { //The permalinks need to be fixed depending on the permalink mode being used
		$Permalink = UPCP_Add_Parameter_To_Permalink($Paramter_Name, $Item->$ID_Name);
		$ReturnString .= "<a class='upcp-overview-mode-link " . $Class_Added . "' href='" . $Permalink. "'>";
		$ReturnString .= "<div class='upcp-overview-mode-item " . $Class_Added . "'>";
		if ($Item->$Image_Name != "" and $Item->$Image_Name != "http://") {$ReturnString .= "<div class='upcp-overview-mode-image " . $Class_Added . "'><img src='" . $Item->$Image_Name . "' /></div>";}
		else {$ReturnString .= "<div class='upcp-overview-mode-image " . $Class_Added . "'><img src='" . plugins_url() . "/ultimate-product-catalogue/images/No-Photo-Available.png' /></div>";}
		$ReturnString .= "<div class='upcp-overview-mode-title " . $Class_Added . "'>" . $Item->$Title_Name . "</div>";
		
		$ReturnString .= "</div>";
		$ReturnString .= "</a>";
	}
	$ReturnString .= "</div>";

	return $ReturnString;
}

function UPCP_Add_Parameter_To_Permalink($Argument_Name, $Argument_Value) {
	if (strpos($_SERVER['REQUEST_URI'], "?") === false) {$Permalink = $_SERVER['REQUEST_URI'] . "?" . $Argument_Name . "=" . $Argument_Value;}
	else {$Permalink = $_SERVER['REQUEST_URI'] . "&" . $Argument_Name . "=" . $Argument_Value;}

	return $Permalink;
}

function FilterCount($Product, $Tags, $Custom_Fields) {
	global $Product_Attributes, $ProdCats, $ProdSubCats, $ProdTags, $ProdCustomFields;
	global $wpdb, $fields_table_name;

	// Increment the arrays keeping count of the number of products in each
	// category, sub-category and tag
	if (!array_key_exists($Product->Get_Field_Value('Category_ID'), $ProdCats)) {$ProdCats[$Product->Get_Field_Value('Category_ID')] = 0;}
	if (!array_key_exists($Product->Get_Field_Value('SubCategory_ID'), $ProdSubCats)) {$ProdSubCats[$Product->Get_Field_Value('SubCategory_ID')] = 0;}

	$ProdCats[$Product->Get_Field_Value('Category_ID')]++;
	$ProdSubCats[$Product->Get_Field_Value('SubCategory_ID')]++;
	foreach ($Tags as $Tag) {
		if(!array_key_exists($Tag->Tag_ID, $ProdTags)){$ProdTags[$Tag->Tag_ID] = 0;}
		$ProdTags[$Tag->Tag_ID]++;
		$Product_Values['Tags'][] = $Tag->Tag_ID;
	}
	if (is_array($Custom_Fields)) {
		foreach ($Custom_Fields as $Custom_Field) {
			$Custom_Field->Meta_Value = UPCP_Decode_CF_Commas($Custom_Field->Meta_Value);
			$Field_Type = $wpdb->get_var("SELECT Field_Type FROM $fields_table_name WHERE Field_ID='" . $Custom_Field->Field_ID . "'");
			if (!array_key_exists($Custom_Field->Field_ID, $ProdCustomFields)) {$ProdCustomFields[$Custom_Field->Field_ID] = array();}
			if ($Field_Type == "checkbox") {
				$Checkbox_Values = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Custom_Field->Meta_Value)));
				if (!is_array($Checkbox_Values)) {$Checkbox_Values = array();}
				foreach ($Checkbox_Values as $Individual_Value) {
					if (!array_key_exists($Individual_Value, $ProdCustomFields[$Custom_Field->Field_ID])) {$ProdCustomFields[$Custom_Field->Field_ID][$Individual_Value] = 0;}
					if ($Individual_Value != "") {$ProdCustomFields[$Custom_Field->Field_ID][$Individual_Value]++;}
					$Product_Values['CustomFields'][$Custom_Field->Field_ID][] = $Individual_Value;
				}
			}
			else {
				if (!array_key_exists($Custom_Field->Meta_Value, $ProdCustomFields[$Custom_Field->Field_ID])) {$ProdCustomFields[$Custom_Field->Field_ID][$Custom_Field->Meta_Value] = 0;}
				if ($Custom_Field->Meta_Value != "") {$ProdCustomFields[$Custom_Field->Field_ID][$Custom_Field->Meta_Value]++;}
				$Product_Values['CustomFields'][$Custom_Field->Field_ID] = $Custom_Field->Meta_Value;
			}
		}
	}

	$Product_Values['ID'] = $Product->Get_Item_ID();
	$Product_Values['Price'] = $Product->Get_Product_Price();
	$Product_Values['Category'] = $Product->Get_Field_Value('Category_ID');
	$Product_Values['SubCategory'] = $Product->Get_Field_Value('SubCategory_ID');
	if (!isset($Product_Values['Tags'])) {$Product_Values['Tags'] = array();}
	if (!isset($Product_Values['CustomFields'])) {$Product_Values['CustomFields'] = array();}

	$Product_Attributes[] = $Product_Values;
}

function SearchProductName($Item_ID, $ProductName, $ProductDescription, $SearchName, $CaseInsensitive, $SearchLocation) {
	global $wpdb;
	global $fields_meta_table_name;

	if ($CaseInsensitive == "Yes") {
		$ProductName = mb_strtolower($ProductName);
		$ProductDescription = mb_strtolower($ProductDescription);
		$SearchName = mb_strtolower($SearchName);
	}

	if ($SearchName == ""){$NameSearchMatch = "Yes";}
	elseif (mb_strpos($ProductName, $SearchName) !== false) {$NameSearchMatch = "Yes";}
	elseif (mb_strpos($ProductDescription, $SearchName) !== false) {
		if ($SearchLocation == "namedesc" or $SearchLocation == "namedesccust") {
			$NameSearchMatch = "Yes";
		}
	}

	if ($NameSearchMatch != "Yes" and $SearchLocation == "namedesccust") {
		$SearchName =  "%" .  $SearchName . "%";
		$Metas = $wpdb->get_results($wpdb->prepare("SELECT Meta_Value FROM $fields_meta_table_name WHERE Item_ID='" . $Item_ID . "' and Meta_Value LIKE %s", $SearchName));
		if (sizeOf($Metas) > 0) {$NameSearchMatch = "Yes";}
	}

	return $NameSearchMatch;
}

function Custom_Field_Check($Custom_Fields_Sql_String, $Custom_Field_Count, $Product_ID) {
	global $wpdb, $fields_meta_table_name;

	if ($Custom_Fields_Sql_String == "") {return "Yes";}

	$Fields = $wpdb->get_results("SELECT Field_ID FROM $fields_meta_table_name WHERE " . $Custom_Fields_Sql_String . " AND Item_ID='" . $Product_ID . "'");
	if ($wpdb->num_rows == $Custom_Field_Count) {return "Yes";}
	else {return "No";}
}

function CheckTags($tags, $ProdTag, $Tag_Logic) {
	if (sizeOf($tags) == 0) {return "Yes";}

	if ($Tag_Logic == "OR") {
		if (count(array_intersect($tags, $ProdTag)) > 0) {return "Yes";}
	}
	else {
		if (count(array_intersect($tags, $ProdTag)) == sizeOf($tags)) {return "Yes";}
	}

	return "No";
}

function UPCP_Max_Price($Max_Price, $Item_Price) {
	if ((strrpos($Item_Price, ",") == strlen($Item_Price) - 3 and strrpos($Item_Price, ",") !== false) or (strrpos($Item_Price, ".") == strlen($Item_Price) - 3 and strrpos($Item_Price, ".") !== false)) {
		$Escaped_Price = str_replace(array(",", "."), '', $Item_Price) / 100;
	}
	else {$Escaped_Price = $Item_Price;}

	$Max_Price = max($Max_Price, $Escaped_Price);
	return $Max_Price;
}

function UPCP_Min_Price($Min_Price, $Product_Price) {
	if ((strrpos($Item_Price, ",") == strlen($Item_Price) - 3 and strrpos($Item_Price, ",") !== false) or (strrpos($Item_Price, ".") == strlen($Item_Price) - 3 and strrpos($Item_Price, ".") !== false)) {
		$Escaped_Price = str_replace(array(",", "."), '', $Item_Price) / 100;
	}
	else {$Escaped_Price = $Item_Price;}

	$Min_Price = min($Min_Price, $Escaped_Price);

	return $Min_Price;
}

function UPCP_Price_Check($max_price, $min_price, $Item_Price) {
	if ((strrpos($Item_Price, ",") == strlen($Item_Price) - 3 and strrpos($Item_Price, ",") !== false) or (strrpos($Item_Price, ".") == strlen($Item_Price) - 3 and strrpos($Item_Price, ".") !== false)) {
		$Escaped_Price = str_replace(array(",", "."), '', $Item_Price) / 100;
	}
	else {$Escaped_Price = $Item_Price;}

	if ($min_price == 0 or $Escaped_Price >= $min_price) {
		if ($max_price == 10000000 or $Escaped_Price <= $max_price) {
			return true;
		}
	}

	return false;
}

function CheckPagination($Product_Count, $products_per_page, $current_page, $Filtered = "No") {
	if ($products_per_page >= 1000000) {return "OK";}
	if ($Product_Count >= ($products_per_page * ($current_page - 1))) {
		if ($Product_Count < ($products_per_page * $current_page)) {
			return "OK";
		}
		else {
			return "Over";
		}
	}

	if ($Filtered == "Yes") {return "Filtered";}
	else {return "Under";}
}

function ConvertCustomFields($Description, $Item_ID, $Item_Name = "") {
	global $wpdb;
	global $fields_table_name, $fields_meta_table_name;

	$upload_dir = wp_upload_dir();

	$Fields = $wpdb->get_results("SELECT Field_ID, Field_Slug, Field_Type FROM $fields_table_name");
	$Metas = $wpdb->get_results($wpdb->prepare("SELECT Field_ID, Meta_Value FROM $fields_meta_table_name WHERE Item_ID=%d", $Item_ID));

	if (is_array($Fields)) {
		if (is_array($Metas)) {
			$MetaArray = array();
			foreach ($Metas as $Meta) {
				$MetaArray[$Meta->Field_ID] = UPCP_Decode_CF_Commas($Meta->Meta_Value);
			}
		}
		foreach ($Fields as $Field) {
			if ($Field->Field_Type == "file") {
				$LinkString = "<a href='" . $upload_dir['baseurl'] . "/upcp-product-file-uploads/" . $MetaArray[$Field->Field_ID] . "' download>" . $MetaArray[$Field->Field_ID] . "</a>";
				$Description = str_replace("[" . $Field->Field_Slug . "]" , $LinkString, $Description);
			}
			elseif ($Field->Field_Type == "link") {
				$LinkString = "<a href='" . $MetaArray[$Field->Field_ID] . "'>" . $MetaArray[$Field->Field_ID] . "</a>";
				$Description = str_replace("[" . $Field->Field_Slug . "]" , $LinkString, $Description);
			}
			else {
				 if (!array_key_exists($Field->Field_ID, $MetaArray)) {$MetaArray[$Field->Field_ID] = 0;}
				$Description = do_shortcode(str_replace("[" . $Field->Field_Slug . "]" , $MetaArray[$Field->Field_ID], $Description));}
		}
	}

	if ($Item_Name != "") {
		$Description = str_replace("[product-name]" , $Item_Name, $Description);
	}

	return $Description;
}

function AddCustomFields($ProductID, $Layout) {
	global $wpdb;
	global $fields_table_name, $fields_meta_table_name;
	global $UPCP_Options;

	$CustomFieldString = "";

	$Custom_Fields_Blank = $UPCP_Options->Get_Option("UPCP_Custom_Fields_Blank");

	$upload_dir = wp_upload_dir();

	$Fields = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Type FROM $fields_table_name WHERE Field_Displays='" . $Layout . "' OR Field_Displays='both' ORDER BY Field_Sidebar_Order");
	if (is_array($Fields)) {
		$CustomFieldString .= "<div class='upcp-prod-desc-custom-fields upcp-custom-field-" . $Layout . "'>";
		if ($Layout == "details") {$AddBreak = "<br />";}
		if ($Layout == "list") {$AddBreak = " ";}
		else {$AddBreak = "";}
		foreach ($Fields as $Field) {
			$Meta = $wpdb->get_row("SELECT Meta_Value FROM $fields_meta_table_name WHERE Field_ID='" . $Field->Field_ID . "' AND Item_ID='" . $ProductID . "'");
			if (is_object($Meta)) {$Meta_Value = UPCP_Decode_CF_Commas($Meta->Meta_Value);}
			else {$Meta_Value = "";}
			if ($Meta_Value != "" or $Custom_Fields_Blank != "Yes") {
				if ($Field->Field_Type == "file") {
					$CustomFieldString .= $AddBreak . $Field->Field_Name . ": ";
					$CustomFieldString .= "<a href='" . $upload_dir['baseurl'] . "/upcp-product-file-uploads/" .$Meta_Value . "' download>" . $Meta_Value . "</a>";
				}
				else {$CustomFieldString .= $AddBreak . "<span class='upcp-cf-label'>" . $Field->Field_Name . ": </span><span class='upcp-cf-value'>" . str_replace(",", ", ", do_shortcode($Meta_Value) ) . "</span>";}
				$AddBreak = "<br />";
			}
		}
		$CustomFieldString .= "</div>";
	}

	return $CustomFieldString;
}

function UPCP_ObjectToArray($Obj) {
	$TagsArray = array();
	foreach ($Obj as $Tag) {
		$TagsArray[] = $Tag->Tag_ID;
	}

	return $TagsArray;
}

function UPCP_Filter_Title($ProductName) {
	echo $ProductName;
	add_filter('the_title', 'UPCP_Alter_Title', 20, $ProductName);
}

function UPCP_Alter_Title($Title, $ProductName) {
	$Title = $ProductName . " | " . $Title;
	return $Title;
}

function UPCP_getIDfromGUID($guid){
    global $wpdb;
    return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid=%s", $guid ) );
}


function UPCP_Return_PHP_Version() {
	$PHP_Version_Array = explode(".", phpversion());
	$PHP_Version_Number = $PHP_Version_Array[0] * 10000 + $PHP_Version_Array[1] * 100 + $PHP_Version_Array[2];

	return $PHP_Version_Number;
}

function UPCP_Add_WC_Cart_HTML() {
	global $UPCP_Options;

	$WooCommerce_Cart_Page = $UPCP_Options->Get_Option("UPCP_WooCommerce_Cart_Page");
	$WooCommerce_Show_Cart_Count = $UPCP_Options->Get_Option("UPCP_WooCommerce_Show_Cart_Count");

	$Cart_Items_Label = $UPCP_Options->Get_Option("UPCP_Cart_Items_Label");
	if($Cart_Items_Label == ""){$Cart_Items_Label = __('%s items in cart', 'ultimate-product-catalogue');}
	$Checkout_Label = $UPCP_Options->Get_Option("UPCP_Checkout_Label");
	if($Checkout_Label == ""){$Checkout_Label = __('Checkout!', 'ultimate-product-catalogue');}
	$Empty_Cart_Label = $UPCP_Options->Get_Option("UPCP_Empty_Cart_Label");
	if($Empty_Cart_Label == ""){$Empty_Cart_Label = __('or empty cart', 'ultimate-product-catalogue');}

	if ($WooCommerce_Cart_Page == "Cart") {$WooCommerce_Checkout_Page_ID = get_option('woocommerce_cart_page_id');}
	else {$WooCommerce_Checkout_Page_ID = $UPCP_Options->Get_Option("woocommerce_checkout_page_id");}

	if (isset($_COOKIE['upcp_cart_products'])) {
		$Products_Array = explode(",", $_COOKIE['upcp_cart_products']);
			if (is_array($Products_Array)) {$Cart_Item_Count = sizeof($Products_Array);}
			else {$Cart_Item_Count = 0;}
	}
	else {$Cart_Item_Count = 0;}

	$Cart_Item_Count_HTML = "<span class='upcp-cart-item-count'>" . $Cart_Item_Count . "</span>";

	$ReturnString = '<div class="upcp-wc-cart-div ';
	if (!isset($_COOKIE['upcp_cart_products'])) {$ReturnString .= 'upcp-Hide-Item';}
	$ReturnString .= '">';
	if($WooCommerce_Show_Cart_Count == 'Yes'){
		$ReturnString .= "<span class='upcp-cart-item-count-html'>" . sprintf($Cart_Items_Label, $Cart_Item_Count_HTML) . "</span>";
	}
	$ReturnString .= '<a class="upcp-submit-wc-cart">';
	$ReturnString .= '<form id="upcp-inquiry-form" action="' . get_permalink($WooCommerce_Checkout_Page_ID) . '" method="post">';
	$ReturnString .= '<input type="hidden" name="return_URL" value="' . get_permalink() . '" />';
	$ReturnString .= '<input type="submit" name="Submit_Inquiry" value="' . $Checkout_Label . '"/>';
	$ReturnString .= '</form>';
	$ReturnString .= '</a>';
	$ReturnString .= "<span class='upcp-clear-cart'>" . $Empty_Cart_Label . "</span>";
	$ReturnString .= '</div>';

	return $ReturnString;
}

function UPCP_Add_Inquiry_Cart_HTML() {
	global $UPCP_Options;

	$Cart_Items_Label = $UPCP_Options->Get_Option("UPCP_Cart_Items_Label");
	if($Cart_Items_Label == ""){$Cart_Items_Label = __('%s items in cart', 'ultimate-product-catalogue');}
	$Send_Inquiry_Label = $UPCP_Options->Get_Option("UPCP_Send_Inquiry_Label");
	if($Send_Inquiry_Label == ""){$Send_Inquiry_Label = __('Send Inquiry!', 'ultimate-product-catalogue');}
	$Empty_Cart_Label = $UPCP_Options->Get_Option("UPCP_Empty_Cart_Label");
	if($Empty_Cart_Label == ""){$Empty_Cart_Label = __('or empty cart', 'ultimate-product-catalogue');}

	if (!isset($_COOKIE['upcp_cart_products'])) {
		$Products_Array = explode(",", $_COOKIE['upcp_cart_products']);
			if (is_array($Products_Array)) {$Cart_Item_Count = sizeof($Products_Array);}
			else {$Cart_Item_Count = 0;}
	}
	else {$Cart_Item_Count = 0;}

	$Cart_Item_Count_HTML = "<span class='upcp-cart-item-count'>" . $Cart_Item_Count . "</span>";

	$ReturnString = '<div class="upcp-inquire-div ';
	if (!isset($_COOKIE['upcp_cart_products'])) {$ReturnString .= 'upcp-Hide-Item';}
	$ReturnString .= '">';
	$ReturnString .= "<span class='upcp-cart-item-count-html'>" . sprintf($Cart_Items_Label, $Cart_Item_Count_HTML) . "</span>";
	$ReturnString .= '<a class="upcp-submit-inquiry">';
	$ReturnString .= '<form id="upcp-inquiry-form" action="#" method="post">';
	$ReturnString .= '<input type="hidden" name="return_URL" value="' . get_permalink() . '" />';
	$ReturnString .= '<input type="submit" name="Submit_Inquiry" value="' . $Send_Inquiry_Label . '"/>';
	$ReturnString .= '</form>';
	$ReturnString .= '</a>';
	$ReturnString .= "<span class='upcp-clear-cart'>" . $Empty_Cart_Label . "</span>";
	$ReturnString .= '</div>';

	return $ReturnString;
}

function UPCP_Single_Page_Inquiry_Form() {
	global $wpdb;
	global $items_table_name;
	global $UPCP_Options;

	if ($UPCP_Options->Get_Option("UPCP_Product_Inquiry_Form_Title_Label") != "") {$Product_Inquiry_Form_Title_Label = $UPCP_Options->Get_Option("UPCP_Product_Inquiry_Form_Title_Label");}
	else {$Product_Inquiry_Form_Title_Label = __("Product Inquiry Form", 'ultimate-product-catalogue');}

	$plugin = "contact-form-7/wp-contact-form-7.php";
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$CF_7_Installed = is_plugin_active($plugin);

	if ($CF_7_Installed) {
		$UPCP_Contact_Form = get_page_by_path('upcp-product-inquiry-form', OBJECT, 'wpcf7_contact_form');
		$ReturnString .= "<div class='upcp-contact-form-7-product-form'>";
		$ReturnString .= "<h4>" . $Product_Inquiry_Form_Title_Label . "</h4>";
		$ReturnString .= "<div class='upcp-inquire-cart-explanation'>";
		if (isset($_POST['return_URL'])) {$ReturnString .= "<div class='upcp-inquire-cart-back-link'><a href='" . $_POST['return_URL'] . "' >" . __("Back to Catalog", 'ultimate-product-catalogue') . "</a></div>";}

		$ReturnString .= __("Please use the form below to enquire about the following products:", 'ultimate-product-catalogue') . "<br>";
		if (isset($_COOKIE['upcp_cart_products'])) {
			$Products_Array = explode(",", $_COOKIE['upcp_cart_products']);
			if (is_array($Products_Array)) {
				foreach ($Products_Array as $Product_ID) {
					$Product_Name = $wpdb->get_var($wpdb->prepare("SELECT Item_Name FROM $items_table_name WHERE Item_ID=%d", $Product_ID));
					$ReturnString .= $Product_Name . "<br>";
					$Product_Names_String .= $Product_Name . ", ";
				}
				$ReturnString .= "<br>";
				$Product_Names_String = substr($Product_Names_String, 0, -2);
			}
		}
		else {$ReturnString .= __("No products selected", 'ultimate-product-catalogue');}
		$ReturnString .= "</div>";

		$ReturnString .= str_replace('%PRODUCT_NAME%', $Product_Names_String, do_shortcode('[contact-form-7 id="' . $UPCP_Contact_Form->ID . '" title="' . $UPCP_Contact_Form->post_title . '"]'));
		$ReturnString .= "</div>";
	}
	else {
		$ReturnString = "Please install Contact Form 7 to correctly use the inquiry cart function.";
	}

	return $ReturnString;
}

add_action( 'wpcf7_mail_sent', 'UPCP_Clear_Inquire_Cart' );
function UPCP_Clear_Inquire_Cart($contact_form) {
	$UPCP_Contact_Form = get_page_by_path('upcp-product-inquiry-form', OBJECT, 'wpcf7_contact_form');

	if ($contact_form->title == $UPCP_Contact_Form->post_title) {
		UPCP_Clear_Cart();
	}
}

function UPCP_Clear_Cart() {
	setcookie('upcp_cart_products', "", time() - 3600, "/");
}

function UPCP_Get_Image_Title($Image_Handle) {
	if (is_numeric($Image_Handle)) {$Image_ID = $Image_Handle;}
	else {$Image_ID = UPCP_getIDfromGUID($Image_Handle);}

	if ($Image_ID != "") {return get_the_title($Image_ID);}
	else {return "";}
}

function UPCP_Get_Image_Caption($Image_Handle) {
	if (is_numeric($Image_Handle)) {$Image_ID = $Image_Handle;}
	else {$Image_ID = UPCP_getIDfromGUID($Image_Handle);}

	if ($Image_ID != "") {return get_the_excerpt($Image_ID);}
	else {return "";}
}

 ?>
