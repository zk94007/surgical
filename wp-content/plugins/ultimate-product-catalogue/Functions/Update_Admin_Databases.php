<?php
/* The file contains all of the functions which make changes to the UPCP tables */

/* Adds a single new category to the UPCP database */
function Add_UPCP_Category($Category_Name, $Category_Description = "", $Category_Image = "", $WC_Update = "No", $WC_term_id = 0) {
		global $wpdb;
		global $categories_table_name;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		$wpdb->insert($categories_table_name,
				array( 'Category_Name' => $Category_Name,
						'Category_Description' => $Category_Description,
						'Category_Image' => $Category_Image,
						'Category_Item_Count' => 0,
						'Category_WC_ID' => $WC_term_id)
		);

		if ($WooCommerce_Sync == "Yes" and $WC_term_id != 0) {update_term_meta($WC_term_id, "upcp_ID", $wpdb->insert_id);}
		if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Add_Category_To_WC($wpdb->get_row("SELECT * FROM $categories_table_name WHERE Category_ID=%d", $wpdb->insert_id));}

		$update = __("Category has been successfully created.", 'ultimate-product-catalogue');
		return $update;
}

/* Edits a single category with a given ID in the UPCP database */
function Edit_UPCP_Category($Category_ID, $Category_Name, $Category_Description = "", $Category_Image = "", $WC_Update = "No", $WC_term_id = 0) {
		global $wpdb;
		global $categories_table_name;
		global $items_table_name;
		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		$wpdb->update(
						$categories_table_name,
						array( 'Category_Name' => $Category_Name,
								'Category_Description' => $Category_Description,
								'Category_Image' => $Category_Image,
								'Category_WC_ID' => $WC_term_id),
						array( 'Category_ID' => $Category_ID)
		);

		$wpdb->update(
			$items_table_name,
			array('Category_Name' => $Category_Name),
			array('Category_ID' => $Category_ID)
		);

		if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Edit_Category_To_WC($wpdb->get_row($wpdb->prepare("SELECT * FROM $categories_table_name WHERE Category_ID=%d", $Category_ID)));}

		$update = __("Category has been successfully edited.", 'ultimate-product-catalogue');
		return $update;
}

/* Deletes a single category with a given ID in the UPCP database */
function Delete_UPCP_Category($Cat) {
		global $wpdb;
		global $categories_table_name;
		global $items_table_name;
		global $catalogue_items_table_name;

		$wpdb->delete(
						$categories_table_name,
						array('Category_ID' => $Cat)
					);

		$Catalogue_IDs = $wpdb->get_results($wpdb->prepare("SELECT Catalogue_ID FROM $catalogue_items_table_name WHERE Category_ID=%d", $Cat));

        $wpdb->delete(
            $catalogue_items_table_name,
            array('Category_ID' => $Cat)
        );

        foreach ($Catalogue_IDs as $Catalogue_ID) {
        	Update_Catalogue_Item_Count($Catalogue_ID->Catalogue_ID);
        }

		$Products = $wpdb->get_results("SELECT Item_ID FROM $items_table_name WHERE Category_ID='" . $Cat . "'");
		foreach ($Products as $Product) {
				$wpdb->update(
								$items_table_name,
								array(
										'Category_ID' => 0,
										'Category_Name' => ''),
								array( 'Item_ID' => $Product->Item_ID)
				);
		}

		$update = __("Category has been successfully deleted.", 'ultimate-product-catalogue');
		return $update;
}

/* Adds a single new sub-category to the UPCP database */
function Add_UPCP_SubCategory($SubCategory_Name, $Category_ID, $SubCategory_Description, $SubCategory_Image = "", $WC_Update = "No", $WC_term_id = 0) {
		global $wpdb;
		global $subcategories_table_name;
		global $categories_table_name;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		if ($Category_ID != "") {$Category = $wpdb->get_row("SELECT * FROM $categories_table_name WHERE Category_ID =" . $Category_ID); $Category_Name = $Category->Category_Name;}

		$wpdb->insert($subcategories_table_name,
				array( 'SubCategory_Name' => $SubCategory_Name,
						'Category_ID' => $Category_ID,
						'Category_Name' => $Category_Name,
						'SubCategory_Description' => $SubCategory_Description,
						'SubCategory_Image' => $SubCategory_Image,
						'SubCategory_Item_Count' => 0,
						'SubCategory_WC_ID' => $WC_term_id)
		);

		if ($WooCommerce_Sync == "Yes" and $WC_term_id != 0) {update_term_meta($WC_term_id, "upcp_ID", $wpdb->insert_id);}
		if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Add_SubCategory_To_WC($wpdb->get_row("SELECT * FROM $subcategories_table_name WHERE SubCategory_ID=%d", $wpdb->insert_id));}

		$update = __("Sub-Category has been successfully created.", 'ultimate-product-catalogue');
		return $update;
}

/* Edits a single sub-category with a given ID in the UPCP database */
function Edit_UPCP_SubCategory($SubCategory_ID, $SubCategory_Name, $Category_ID, $SubCategory_Description, $SubCategory_Image = "", $WC_Update = "No", $WC_term_id = 0) {
		global $wpdb;
		global $subcategories_table_name;
		global $categories_table_name;
		global $items_table_name;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		if ($Category_ID != "") {$Category = $wpdb->get_row("SELECT * FROM $categories_table_name WHERE Category_ID =" . $Category_ID); $Category_Name = $Category->Category_Name;}

		$wpdb->update(
						$subcategories_table_name,
						array( 'SubCategory_Name' => $SubCategory_Name,
								'Category_ID' => $Category_ID,
								'Category_Name' => $Category_Name,
							 	'SubCategory_Description' => $SubCategory_Description,
							 	'SubCategory_Image' => $SubCategory_Image,
								'SubCategory_WC_ID' => $WC_term_id),
						array( 'SubCategory_ID' => $SubCategory_ID)
		);
		$wpdb->update(
						$items_table_name,
						array( 'SubCategory_Name' => $SubCategory_Name,
									 'Category_ID' => $Category_ID,
									 'Category_Name' => $Category_Name),
						array( 'SubCategory_ID' => $SubCategory_ID)
		);

		if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Edit_SubCategory_To_WC($wpdb->get_row($wpdb->prepare("SELECT * FROM $subcategories_table_name WHERE SubCategory_ID=%d", $SubCategory_ID)));}

		$update = __("Sub-Category has been successfully edited.", 'ultimate-product-catalogue');
		return $update;
}

/* Deletes a single sub-category with a given ID in the UPCP database */
function Delete_UPCP_SubCategory($Sub_ID) {
		global $wpdb;
		global $subcategories_table_name;
		global $items_table_name;

		$wpdb->delete(
						$subcategories_table_name,
						array('SubCategory_ID' => $Sub_ID)
					);

		$Products = $wpdb->get_results("SELECT Item_ID FROM $items_table_name WHERE SubCategory_ID='" . $Sub_ID . "'");
		foreach ($Products as $Product) {
				$wpdb->update(
								$items_table_name,
								array(
										'SubCategory_ID' => 0,
										'SubCategory_Name' => ''),
								array('Item_ID' => $Product->Item_ID)
				);
		}

		$update = __("Sub-Category has been successfully deleted.", 'ultimate-product-catalogue');
		return $update;
}

/* Adds a single new tag to the UPCP database */
function Add_UPCP_Tag($Tag_Name, $Tag_Description, $Tag_Group_ID, $WC_Update = "No", $WC_term_id = 0) {
		global $wpdb;
		global $tags_table_name;
		global $Full_Version;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		if ($Full_Version != "Yes") {exit();}
		$wpdb->insert($tags_table_name,
			array(
				'Tag_Name' => $Tag_Name,
				'Tag_Description' => $Tag_Description,
				'Tag_Group_ID' => $Tag_Group_ID,
				'Tag_Item_Count' => 0,
				'Tag_WC_ID' => $WC_term_id)
		);

		if ($WooCommerce_Sync == "Yes" and $WC_term_id != 0) {update_term_meta($WC_term_id, "upcp_ID", $wpdb->insert_id);}
		if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Add_Tag_To_WC($wpdb->get_row($wpdb->prepare("SELECT * FROM $tags_table_name WHERE Tag_ID=%d", $wpdb->insert_id)));}

		$update = __("Tag has been successfully created.", 'ultimate-product-catalogue');
		return $update;
}

/* Edits a single tag with a given ID in the UPCP database */
function Edit_UPCP_Tag($Tag_ID, $Tag_Name, $Tag_Description, $Tag_Group_ID, $WC_Update = "No", $WC_term_id = 0) {
		global $wpdb;
		global $tags_table_name;
		global $Full_Version;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		if ($Full_Version != "Yes") {exit();}
		$wpdb->update(
			$tags_table_name,
			array(
				'Tag_Name' => $Tag_Name,
				'Tag_Description' => $Tag_Description,
				'Tag_Group_ID' => $Tag_Group_ID,
				'Tag_WC_ID' => $WC_term_id),
			array( 'Tag_ID' => $Tag_ID)
		);

		if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Edit_Tag_To_WC($wpdb->get_row($wpdb->prepare("SELECT * FROM $tags_table_name WHERE Tag_ID=%d", $Tag_ID)));}

		$update = __("Tag has been successfully edited.", 'ultimate-product-catalogue');
		return $update;
}

/* Deletes a single tag with a given ID in the UPCP database, and then eliminates
*  all of the occurrences of that tag from the tagged items table.  */
function Delete_UPCP_Tag($Tag_ID) {
		global $wpdb;
		global $tags_table_name;
		global $tagged_items_table_name;
		global $Full_Version;

		if ($Full_Version != "Yes") {exit();}
		$wpdb->delete(
			$tags_table_name,
			array('Tag_ID' => $Tag_ID)
		);

		$wpdb->delete(
			$tagged_items_table_name,
			array('Tag_ID' => $Tag_ID)
		);

		$update = __("Tag has been successfully deleted.", 'ultimate-product-catalogue');
		return $update;
}

/* Deletes a single tagged item with a given ID in the UPCP database */
function Delete_Products_Tags() {
		global $wpdb;
		global $tagged_items_table_name;
		global $Full_Version;

		if ($Full_Version != "Yes") {exit();}
		$wpdb->delete(
			$tagged_items_table_name,
			array('Tagged_Item_ID' => $_GET['Tagged_Item_ID'])
		);

		$update = __("Tag has been successfully deleted from product.", 'ultimate-product-catalogue');
		return $update;
}

/* Adds a single new group tag to the UPCP database */
function Add_UPCP_Tag_Group($Tag_Group_Name,$Tag_Group_Description,$Tag_Group_ID,$Display_Tag_Group){
	global $wpdb;
	global $tag_groups_table_name;
	global $Full_Version;

	if ($Full_Version != "Yes") {exit();}
	$wpdb->insert($tag_groups_table_name,
		array(
			'Tag_Group_Name' => $Tag_Group_Name,
			'Tag_Group_Description' => $Tag_Group_Description,
			'Tag_Group_ID' => $Tag_Group_ID,
			'Display_Tag_Group' => $Display_Tag_Group
		)
	);
	$update = __("Tag Group has been successfully created.", 'ultimate-product-catalogue');
	return $update;
}

/* Edtis a single tag group with a given ID in the UPCP database */
function Edit_UPCP_Tag_Group($Tag_Group_Name,$Tag_Group_Description,$Tag_Group_ID,$Display_Tag_Group){
	global $wpdb;
	global $tag_groups_table_name;
	global $Full_Version;

	if ($Full_Version != "Yes") {exit();}
	$wpdb->update($tag_groups_table_name,
		array(
			'Tag_Group_Name' => $Tag_Group_Name,
			'Tag_Group_Description' => $Tag_Group_Description,
			'Display_Tag_Group' => $Display_Tag_Group),
		array('Tag_Group_ID' => $Tag_Group_ID)

	);
	$update = __("Tag Group has been successfully edited.", 'ultimate-product-catalogue');
	return $update;
}
/* Deletes a single tag group with a given ID in the UPCP database, and then changes all occurances of the tag group back to uncatagorized tags.  */
function Delete_UPCP_Tag_Group($Tag_Group_ID){
	global $wpdb;
	global $tag_groups_table_name;
	global $tags_table_name;
	global $Full_Version;

	if ($Full_Version != "Yes") {exit();}
	$wpdb->delete(
		$tag_groups_table_name,
		array(
			'Tag_Group_ID' => $Tag_Group_ID
		)
	);
	$wpdb->update(
		$tags_table_name,
		array(
			'Tag_Group_ID' => "0"
		),
		array('Tag_Group_ID' => $Tag_Group_ID)
	);
}

/* Adds one or multiple videos to database */
function Add_Product_Videos($Item_ID, $Item_Video_URL, $Item_Video_Type) {
	global $wpdb;
	global $item_videos_table_name;

	$wpdb->query($wpdb->prepare("INSERT INTO $item_videos_table_name (Item_ID, Item_Video_URL, Item_Video_Type) VALUES (%d, %s, %s)", $Item_ID, $Item_Video_URL, $Item_Video_Type));

	$update = __("video has been successfully added to the product.", 'ultimate-product-catalogue');
	return $update;
}
/* Deletes video from UPCP database and removes it from the product */
function Delete_Product_Video() {
	global $wpdb;
	global $item_videos_table_name;

	$wpdb->delete(
		$item_videos_table_name,
		array(
			'Item_Video_ID' => $_GET['Item_Video_ID']
		)
	);
	$update = "Your video has been successfully deleted.";
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	return $user_update;
}

/* Adds a single new custom field to the UPCP database */
function Add_UPCP_Custom_Field($Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Displays, $Field_Searchable, $Field_Display_Tabbed, $Field_Control_Type, $Field_Display_Comparison, $WC_Update = "No", $WC_term_id = 0, $Term_ID_For_Value = array()) {
	global $wpdb;
	global $fields_table_name;
	global $Full_Version;

	$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

	$Date = date("Y-m-d H:i:s");

	if ($Full_Version != "Yes") {exit();}
	$wpdb->insert($fields_table_name,
		array(
			'Field_Name' => $Field_Name,
			'Field_Slug' => $Field_Slug,
			'Field_Type' => $Field_Type,
			'Field_Description' => $Field_Description,
			'Field_Values' => $Field_Values,
			'Field_Displays' => $Field_Displays,
			'Field_Searchable' => $Field_Searchable,
			'Field_Display_Tabbed' => $Field_Display_Tabbed,
			'Field_Control_Type' => $Field_Control_Type,
			'Field_Display_Comparison' => $Field_Display_Comparison,
			'Field_Date_Created' => $Date,
			'Field_WC_ID' => $WC_term_id
		)
	);
	$Field_ID = $wpdb->insert_id;

	if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Add_Custom_Field_To_WC($wpdb->get_row($wpdb->prepare("SELECT * FROM $fields_table_name WHERE Field_ID=%d", $wpdb->insert_id)));}
	elseif ($WooCommerce_Sync == "Yes") {
		foreach ($Term_ID_For_Value as $Term_ID => $Value) {
			update_term_meta($Term_ID, 'upcp_term_value', $Value);
			update_term_meta($Term_ID, 'upcp_term_CF_ID', $Field_ID);
		}
	}


	$update = __("Field has been successfully created.", 'ultimate-product-catalogue');
	return $update;
}

/* Edits a single custom field with a given ID in the UPCP database */
function  Edit_UPCP_Custom_Field($Field_ID, $Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Displays, $Field_Searchable, $Field_Display_Tabbed, $Field_Control_Type, $Field_Display_Comparison, $WC_Update = "No", $WC_term_id = 0, $Term_ID_For_Value = array(), $Replace_Values = array()) {
	global $wpdb;
	global $fields_table_name;
	global $fields_meta_table_name;
	global $Full_Version;

	$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");
	$Current_Values = $wpdb->get_var($wpdb->prepare("SELECT Field_Values FROM $fields_table_name WHERE Field_ID=%d", $Field_ID));

	if ($Full_Version != "Yes") {exit();}
	$wpdb->update(
		$fields_table_name,
		array(
			'Field_Name' => $Field_Name,
			'Field_Slug' => $Field_Slug,
			'Field_Type' => $Field_Type,
			'Field_Description' => $Field_Description,
			'Field_Values' => $Field_Values,
			'Field_Displays' => $Field_Displays,
			'Field_Searchable' => $Field_Searchable,
			'Field_Display_Tabbed' => $Field_Display_Tabbed,
			'Field_Control_Type' => $Field_Control_Type,
			'Field_Display_Comparison' => $Field_Display_Comparison),
		array( 'Field_ID' => $Field_ID)
	);

	if ($WooCommerce_Sync == "Yes" and $WC_Update != "Yes") {UPCP_Edit_Custom_Field_To_WC($wpdb->get_row($wpdb->prepare("SELECT * FROM $fields_table_name WHERE Field_ID=%d", $Field_ID)), $Current_Values);}
	elseif ($WooCommerce_Sync == "Yes" and !empty($Replace_Values)) {
		foreach ($Replace_Values as $Current => $Term_ID) {
			$Term_Value = $wpdb->query($wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id=%d", $Term_ID));
			$wpdb->query($wpdb->prepare("UPDATE $fields_meta_table_name SET Meta_Value=(Meta_Value, %s, %s) WHERE (Meta_Value LIKE '%s' OR Meta_Value LIKE '%s,%' OR Meta_Value LIKE '%,%s,%' OR Meta_Value LIKE '%,%s')", $Current, $Term_Value, $Current, $Current, $Current, $Current));
		}
	}
	elseif ($WooCommerce_Sync == "Yes") {
		foreach ($Term_ID_For_Value as $Term_ID => $Value) {
			update_term_meta($Term_ID, 'upcp_term_value', $Value);
			update_term_meta($Term_ID, 'upcp_term_CF_ID', $Field_ID);
		}
	}

	$update = __("Field has been successfully edited.", 'ultimate-product-catalogue');
	return $update;
}

/* Deletes a single tag with a given ID in the UPCP database, and then eliminates
*  all of the occurrences of that tag from the tagged items table.  */
function Delete_UPCP_Custom_Field($Field_ID) {
	global $wpdb;
	global $fields_table_name;
	global $Full_Version;

	if ($Full_Version != "Yes") {exit();}
	$wpdb->delete(
		$fields_table_name,
		array('Field_ID' => $Field_ID)
	);

	$update = __("Field has been successfully deleted.", 'ultimate-product-catalogue');
	return $update;
}

/* Adds a single new catalogue to the UPCP database */
function Add_UPCP_Catalogue($Catalogue_Name, $Catalogue_Description) {
		global $wpdb;
		global $catalogues_table_name;

		$wpdb->insert($catalogues_table_name,
				array( 'Catalogue_Name' => $Catalogue_Name,
							 'Catalogue_Description' => $Catalogue_Description,
							 'Catalogue_Item_Count' => 0)
		);
		$update = __("Catalogue has been successfully created.", 'ultimate-product-catalogue');
		return $update;
}

/* Edits a single catalogue with a given ID in the UPCP database */
function Edit_UPCP_Catalogue($Catalogue_ID, $Catalogue_Name, $Catalogue_Description, $Catalogue_Layout_Format = "", $Catalogue_Custom_CSS = "") {
		global $wpdb;
		global $catalogues_table_name;

		$wpdb->update(
						$catalogues_table_name,
						array( 'Catalogue_Name' => $Catalogue_Name,
							 		 'Catalogue_Description' => $Catalogue_Description,
									 'Catalogue_Layout_Format' => $Catalogue_Layout_Format,
									 'Catalogue_Custom_CSS' => $Catalogue_Custom_CSS),
						array( 'Catalogue_ID' => $Catalogue_ID)
		);
		$update = __("Catalogue has been successfully edited.", 'ultimate-product-catalogue');
		return $update;
}

/* Adds one or multiple new products to to a single catalogue in the UPCP database */
function Add_Products_Catalogue() {
		global $wpdb;
		global $catalogues_table_name;
		global $catalogue_items_table_name;

		$Catalogue_ID = $_GET['Catalogue_ID'];
		foreach ($_POST['products'] as $Item_ID) {
				$MaxPos = $wpdb->get_var($wpdb->prepare("SELECT MAX(Position) FROM $catalogue_items_table_name WHERE Catalogue_ID='%d'", $Catalogue_ID));
				$Position = $MaxPos + 1;
				$wpdb->insert($catalogue_items_table_name,
				array( 'Catalogue_ID' => $Catalogue_ID,
							 'Item_ID' => $Item_ID,
							 'Position' => $Position)
				);
		}

		Update_Catalogue_Item_Count($Catalogue_ID);

		$update = __("Products have been successfully added to the catalogue.", 'ultimate-product-catalogue');
		return $update;
}
/* Adds one or multiple new categories to to a single catalogue in the UPCP database */
function Add_Categories_Catalogue() {
		global $wpdb;
		global $catalogues_table_name;
		global $catalogue_items_table_name;

		$Catalogue_ID = $_GET['Catalogue_ID'];
		foreach ($_POST['categories'] as $Category_ID) {
				$MaxPos = $wpdb->get_var($wpdb->prepare("SELECT MAX(Position) FROM $catalogue_items_table_name WHERE Catalogue_ID='%d'", $Catalogue_ID));
				$Position = $MaxPos + 1;
				$wpdb->insert($catalogue_items_table_name,
				array( 'Catalogue_ID' => $Catalogue_ID,
							 'Category_ID' => $Category_ID,
							 'Position' => $Position)
				);
		}

		Update_Catalogue_Item_Count($Catalogue_ID);

		$update = __("Categories have been successfully added to the catalogue.", 'ultimate-product-catalogue');
		return $update;
}

function Update_Catalogue_Item_Count($Catalogue_ID) {
		global $wpdb;
		global $catalogues_table_name;
		global $catalogue_items_table_name;
		global $subcategories_table_name;
		global $categories_table_name;
		global $items_table_name;

		$Individual_Products = $wpdb->get_results($wpdb->prepare("SELECT Catalogue_Item_ID FROM $catalogue_items_table_name WHERE Catalogue_ID='%d' AND Item_ID!='NULL' AND Item_ID!='0'", $Catalogue_ID));
		$Total_Products = $wpdb->num_rows;

		$Categories = $wpdb->get_results($wpdb->prepare("SELECT Category_ID FROM $catalogue_items_table_name WHERE Catalogue_ID='%d' AND Category_ID!='NULL' AND Category_ID!='0'", $Catalogue_ID));
		foreach ($Categories as $Category) {
				$Individual_Products = $wpdb->get_results("SELECT Item_ID FROM $items_table_name WHERE Category_ID='" . $Category->Category_ID . "'");
				$Total_Products += $wpdb->num_rows;
		}

		$SubCategories = $wpdb->get_results($wpdb->prepare("SELECT SubCategory_ID FROM $catalogue_items_table_name WHERE Catalogue_ID='%d' AND SubCategory_ID!='NULL' AND SubCategory_ID!='0'", $Catalogue_ID));
		foreach ($SubCategories as $SubCategory) {
				$Individual_Products = $wpdb->get_results("SELECT Item_ID FROM $items_table_name WHERE SubCategory_ID='" . $SubCategory->SubCategory_ID . "'");
				$Total_Products += $wpdb->num_rows;
		}

		$Result = $wpdb->query($wpdb->prepare("UPDATE $catalogues_table_name SET Catalogue_Item_Count='" . $Total_Products . "' WHERE Catalogue_ID='%d'", $Catalogue_ID));
}

/* Deletes a single catalogue with a given ID in the UPCP database */
function Delete_UPCP_Catalogue($Catalogue_ID) {
		global $wpdb;
		global $catalogues_table_name;
		global $catalogue_items_table_name;

		$wpdb->delete(
						$catalogues_table_name,
						array('Catalogue_ID' => $Catalogue_ID)
					);
		$wpdb->delete(
				$catalogue_items_table_name,
				array('Catalogue_ID' => $Catalogue_ID)
		);

		$update = __("Catalogue has been successfully deleted.", 'ultimate-product-catalogue');
		return $update;
}

/* Deletes a single product with a given ID from a catalogue in the UPCP database */
function Delete_Catalogue_Item($Catalogue_Item_ID) {
		global $wpdb;
		global $catalogues_table_name;
		global $catalogue_items_table_name;

		$Catalogue_ID = $wpdb->get_var($wpdb->prepare("SELECT Catalogue_ID FROM $catalogue_items_table_name WHERE Catalogue_Item_ID='%d'", $Catalogue_Item_ID));

		$wpdb->delete(
						$catalogue_items_table_name,
						array('Catalogue_Item_ID' => $Catalogue_Item_ID)
					);

		Update_Catalogue_Item_Count($Catalogue_ID);

		$update = __("Product has been successfully deleted from catalogue.", 'ultimate-product-catalogue');
		return $update;
}

/* Adds a single new product inputted via the form on the left-hand side of the
*  products' page to the UPCP database */
function Add_UPCP_Product($Item_Name, $Item_Slug, $Item_Photo_URL, $Item_Description, $Item_Price, $Item_Sale_Price, $Item_Sale_Mode, $Item_SEO_Description, $Item_Link, $Item_Display_Status = "", $Category_ID = "", $Global_Item_ID = "", $Item_Special_Attr = "", $SubCategory_ID = "", $Tags = array(), $Related_Products = "", $Next_Previous = "", $Skip_Nonce = "No", $WC_ID = 0, $WC_Update = "No") {
		global $wpdb;
		global $items_table_name;
		global $categories_table_name;
		global $subcategories_table_name;
		global $tagged_items_table_name;
		global $tags_table_name;
		global $fields_table_name;
		global $fields_meta_table_name;
		global $Full_Version;
		global $WC_Item_ID;
		


		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		$Prod_Count = $wpdb->get_var("SELECT COUNT(*) FROM " . $items_table_name);


		if ($Prod_Count >= 100 and $Full_Version != "Yes") {
			  $update = __("Maximum number of products (100) has been reached for free version. Upgrade to the premium version to continue.", 'ultimate-product-catalogue');
				return $update;
		}

		//Find the category and sub-category names, since only the ID's are passed in via the form
		if ($Category_ID != "") {$Category = $wpdb->get_row("SELECT * FROM $categories_table_name WHERE Category_ID =" . $Category_ID); $Category_Name = $Category->Category_Name;}
		else {$Category_Name = null;}
		if ($SubCategory_ID != "") {$SubCategory = $wpdb->get_row("SELECT * FROM $subcategories_table_name WHERE SubCategory_ID =" . $SubCategory_ID); $SubCategory_Name = $SubCategory->SubCategory_Name;}
		else {$SubCategory_Name = null;}
		$Today = date("Y-m-d H:i:s");

		$wpdb->insert($items_table_name,
				array(
						'Item_Name' => $Item_Name,
						'Item_Slug' => $Item_Slug,
						'Item_Description' => $Item_Description,
						'Item_Price' => $Item_Price,
						'Item_Sale_Price' => $Item_Sale_Price,
						'Item_Sale_Mode' => $Item_Sale_Mode,
						'Item_Link' => $Item_Link,
						'Item_Photo_URL' => $Item_Photo_URL,
						'Item_Display_Status' => $Item_Display_Status,
						'Category_ID' => $Category_ID,
						'Category_Name' => $Category_Name,
						'Global_Item_ID' => $Global_Item_ID,
						'Item_Special_Attr' => $Item_Special_Attr,
						'SubCategory_ID' => $SubCategory_ID,
						'SubCategory_Name' => $SubCategory_Name,
						'Item_Related_Products' => $Related_Products,
						'Item_Next_Previous' => $Next_Previous,
						'Item_SEO_Description' => $Item_SEO_Description,
						'Item_WC_ID' => $WC_ID,
						'Item_Date_Created' => $Today)
		);

		// Increase the Item_Count column for the category and sub-category tables in the database
		if ($Category_ID != "") {$wpdb->query("UPDATE $categories_table_name SET Category_Item_Count=Category_Item_Count + 1 WHERE Category_ID =" . $Category_ID);}
		if ($SubCategory_ID != "") {$wpdb->query("UPDATE $subcategories_table_name SET SubCategory_Item_Count=SubCategory_Item_Count + 1 WHERE SubCategory_ID =" . $SubCategory_ID);}

		// Create the tagged item in the tagged items table for each "tag" checkbox
		// and update the Item_Count column in the tags table in the database
		$_GET['Item_ID'] = $Item_ID = $wpdb->insert_id;
		foreach ($Tags as $Tag) {
				$wpdb->insert($tagged_items_table_name,
								array('Tag_ID' => $Tag,
											'Item_ID' => $Item_ID)
				);
				$wpdb->query("UPDATE $tags_table_name SET Tag_Item_Count=Tag_Item_Count + 1 WHERE Tag_ID =" . $Tag);
		}

		//Add the custom fields to the meta table
		$Fields = $wpdb->get_results("SELECT Field_ID, Field_Type, Field_Name, Field_Values FROM $fields_table_name");
		if (is_array($Fields)) {
			  foreach ($Fields as $Field) {
						$FieldName = str_replace(" ", "_", $Field->Field_Name);
						if (isset($_POST[$FieldName]) or isset($_FILES[$FieldName])) {
							  // If it's a file, pass back to Prepare_Data_For_Insertion.php to upload the file and get the name
								if ($Field->Field_Type == "file") {
										$File_Upload_Return = UPCP_Handle_File_Upload($FieldName);
										if ($File_Upload_Return['Success'] == "No") {return $File_Upload_Return['Data'];}
										elseif ($File_Upload_Return['Success'] == "N/A" and isset($_POST['Delete_' . $Field->Field_Name])) {$NoFile = "Delete";}
										elseif ($File_Upload_Return['Success'] == "N/A") {$NoFile = "Yes";}
										else {$Value = $File_Upload_Return['Data'];}
								}
								elseif ($Field->Field_Type == "checkbox") {
									$Value = "";
									foreach ($_POST[$FieldName] as $SingleValue) {$Value .= trim($SingleValue) . ",";}
									$Value = substr($Value, 0, strlen($Value)-1);
								}
								else {
									  $Value = stripslashes_deep(trim($_POST[$FieldName]));
										$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
										if (sizeOf($Options) > 0 and $Options[0] != "") {
									  	 	array_walk($Options, create_function('&$val', '$val = trim($val);'));
											$InArray = in_array($Value, $Options);
										}
								}
								if (!isset($InArray) or $InArray) {
									  if (!(isset($NoFile)) or ($NoFile != "Yes" and $NoFile != "Delete")) {
										$wpdb->insert($fields_meta_table_name,
															array( 'Field_ID' => $Field->Field_ID,
																	'Item_ID' => $Item_ID,
																	'Meta_Value' => $Value)
												);
										}
										elseif (isset($NoFile) and $NoFile == "Delete") {
											$wpdb->query($wpdb->prepare("DELETE FROM $fields_meta_table_name WHERE Field_ID=%d AND Item_ID=%d", $Field->Field_ID, $Item_ID));
										}
								}
								elseif ($InArray == false) {$CustomFieldError = __(" One or more custom field values were incorrect.", 'ultimate-product-catalogue');}
								unset($Value);
								unset($InArray);
								unset($NoFile);
								unset($CombinedValue);
								unset($FieldName);
						}
				}
		}

		UPCP_Create_XML_Sitemap();

		if ($WooCommerce_Sync == "Yes" and get_option("UPCP_Product_Import") == "None" and $WC_Update != "Yes") {
			$UPCP_Product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_ID=%d", $Item_ID));
			update_option("UPCP_Product_Import", 'ultimate-product-catalogue');
			UPCP_Create_Linked_WC_Product($UPCP_Product);
			$WC_Item_ID = $Item_ID;
		}
		elseif ($WooCommerce_Sync == "Yes") {
			$WC_Item_ID = $Item_ID;
		}

		$update = __("Product has been successfully created.", 'ultimate-product-catalogue');
		if (isset($CustomFieldError)) {$update .= $CustomFieldError;}
		return $update;
}

/* Edits a single product in the UPCP database */
function Edit_UPCP_Product($Item_ID, $Item_Name, $Item_Slug, $Item_Photo_URL, $Item_Description, $Item_Price, $Item_Sale_Price, $Item_Sale_Mode, $Item_SEO_Description, $Item_Link, $Item_Display_Status = "", $Category_ID = "", $Global_Item_ID = "", $Item_Special_Attr = "", $SubCategory_ID = "", $Tags = array(), $Related_Products = "", $Next_Previous = "", $Skip_Nonce = "No", $Item_WC_ID = 0, $WC_Update = "No") {
		global $wpdb;
		global $items_table_name;
		global $categories_table_name;
		global $subcategories_table_name;
		global $tagged_items_table_name;
		global $tags_table_name;
		global $fields_table_name;
		global $fields_meta_table_name;

		$File_Field_IDs = "";
		$CustomFieldError = "";
		$SubCategory_Name = "";  
		
		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		// Delete the tagged item in the tagged items table for the given Item_ID
		// and update the Item_Count column in the tags table in the database
		$Tagged_Items = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID='" . $Item_ID ."'");
		foreach ($Tagged_Items as $Tagged_Item) {
				$wpdb->query("UPDATE $tags_table_name SET Tag_Item_Count=Tag_Item_Count - 1 WHERE Tag_ID =" . $Tagged_Item->Tag_ID);
		}
		$wpdb->delete(
				$tagged_items_table_name,
				array('Item_ID' => $Item_ID)
		);

		// Delete the custom field values for the given Item_ID but save the Meta_Value's for "file" field types
		$File_Fields = $wpdb->get_results("SELECT Field_ID FROM $fields_table_name WHERE Field_Type='file'");
		foreach ($File_Fields as $File_Field) {$File_Field_IDs .= $File_Field->Field_ID . ",";}
		$Sql = "DELETE FROM $fields_meta_table_name WHERE Item_ID='" . $Item_ID . "'";
			if (strlen($File_Field_IDs) > 0) {$Sql .= " AND Field_ID NOT IN (" . substr($File_Field_IDs, 0, -1) . ")";}
		$wpdb->query($Sql);

		// Decrease the Item_Count column for the category and sub-category tables in the database
		$Current_Product = $wpdb->get_row("SELECT Category_ID, SubCategory_ID, Item_WC_ID FROM $items_table_name WHERE Item_ID='" . $Item_ID ."'");
		if ($Current_Product->Category_ID != 0) {$wpdb->query("UPDATE $categories_table_name SET Category_Item_Count=Category_Item_Count - 1 WHERE Category_ID =" . $Current_Product->Category_ID);}
		if ($Current_Product->SubCategory_ID != 0) {$wpdb->query("UPDATE $subcategories_table_name SET SubCategory_Item_Count=SubCategory_Item_Count - 1 WHERE SubCategory_ID =" . $Current_Product->SubCategory_ID);}

		//Find the category and sub-category names, since only the ID's are passed in via the form
		if ($Category_ID != "") {$Category = $wpdb->get_row("SELECT * FROM $categories_table_name WHERE Category_ID =" . $Category_ID); $Category_Name = $Category->Category_Name;}
		if ($SubCategory_ID != "") {$SubCategory = $wpdb->get_row("SELECT * FROM $subcategories_table_name WHERE SubCategory_ID =" . $SubCategory_ID); $SubCategory_Name = $SubCategory->SubCategory_Name;}

		$wpdb->update(
						$items_table_name,
						array(
						'Item_Name' => $Item_Name,
						'Item_Slug' => $Item_Slug,
						'Item_Description' => $Item_Description,
						'Item_Price' => $Item_Price,
						'Item_Sale_Price' => $Item_Sale_Price,
						'Item_Sale_Mode' => $Item_Sale_Mode,
						'Item_Link' => $Item_Link,
						'Item_Photo_URL' => $Item_Photo_URL,
						'Item_Display_Status' => $Item_Display_Status,
						'Category_ID' => $Category_ID,
						'Category_Name' => $Category_Name,
						'Global_Item_ID' => $Global_Item_ID,
						'Item_Special_Attr' => $Item_Special_Attr,
						'SubCategory_ID' => $SubCategory_ID,
						'SubCategory_Name' => $SubCategory_Name,
						'Item_Related_Products' => $Related_Products,
						'Item_Next_Previous' => $Next_Previous,
						'Item_SEO_Description' => $Item_SEO_Description,
						'Item_WC_ID' => $Item_WC_ID),
						array( 'Item_ID' => $Item_ID)
		);

		// Create the tagged item in the tagged items table for each "tag" checkbox
		// and update the Item_Count column in the tags table in the database
		foreach ($Tags as $Tag) {
				$wpdb->insert($tagged_items_table_name,
								array('Tag_ID' => $Tag,
											'Item_ID' => $Item_ID)
				);
				$wpdb->query("UPDATE $tags_table_name SET Tag_Item_Count=Tag_Item_Count + 1 WHERE Tag_ID =" . $Tag);
		}

		//Add the custom fields to the meta table

		$Fields = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Values, Field_Type FROM $fields_table_name");
		if (is_array($Fields) and $WC_Update == "No") {
			  foreach ($Fields as $Field) {
						$FieldName = str_replace(" ", "_", $Field->Field_Name);
						if (isset($_POST[$FieldName]) or isset($_FILES[$FieldName])) {
							  // If it's a file, pass back to Prepare_Data_For_Insertion.php to upload the file and get the name
								if ($Field->Field_Type == "file") {
										if ($_FILES[$FieldName]['name'] != "") {
											$wpdb->delete($fields_meta_table_name, array('Item_ID' => $Item_ID, 'Field_ID' => $Field->Field_ID));
											$File_Upload_Return = UPCP_Handle_File_Upload($FieldName);
											if ($File_Upload_Return['Success'] == "No") {return $File_Upload_Return['Data'];}
											elseif ($File_Upload_Return['Success'] == "N/A" and isset($_POST['Delete_' . $FieldName])) {$NoFile = "Delete";}
											elseif ($File_Upload_Return['Success'] == "N/A") {$NoFile = "Yes";}
											else {$Value = $File_Upload_Return['Data'];}
										}
										elseif (isset($_POST['Delete_' . $FieldName])) {$NoFile = "Delete";}
										else {$NoFile = "Yes";}
								}
								elseif ($Field->Field_Type == "checkbox") {
										$Value = "";
										foreach ($_POST[$FieldName] as $SingleValue) {$Value .= trim($SingleValue) . ",";}
										$Value = substr($Value, 0, strlen($Value)-1);
								}
								else {
									  $Value = stripslashes_deep(trim($_POST[$FieldName]));
										$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
										if (sizeOf($Options) > 0 and $Options[0] != "") {
									  		array_walk($Options, create_function('&$val', '$val = trim($val);'));
											$InArray = in_array($Value, $Options);
										}
								}

								if (!isset($InArray) or $InArray) {
									  if ((!isset($NoFile)) OR ($NoFile != "Yes" and $NoFile != "Delete")) {
											  $wpdb->insert($fields_meta_table_name,
															array( 'Field_ID' => $Field->Field_ID,
																	'Item_ID' => $Item_ID,
																	'Meta_Value' => $Value)
												);
										}
								}
								elseif ($InArray == false) {$CustomFieldError = __(" One or more custom field values were incorrect.", 'ultimate-product-catalogue');}
								
								if ($NoFile == "Delete") {$wpdb->query($wpdb->prepare("DELETE FROM $fields_meta_table_name WHERE Item_ID=%d AND Field_ID=%d", $Item_ID, $Field->Field_ID));}

								unset($Value);
								unset($InArray);
								unset($NoFile);
								unset($CombinedValue);
								unset($FieldName);
						}
				}
		}

		// Increase the Item_Count column for the category and sub-category tables in the database
		if ($Category_ID != "") {$wpdb->query("UPDATE $categories_table_name SET Category_Item_Count=Category_Item_Count + 1 WHERE Category_ID =" . $Category_ID);}
		if ($SubCategory_ID != "") {$wpdb->query("UPDATE $subcategories_table_name SET SubCategory_Item_Count=SubCategory_Item_Count + 1 WHERE SubCategory_ID =" . $SubCategory_ID);}

		UPCP_Create_XML_Sitemap();

		if ($WooCommerce_Sync == "Yes" and get_option("UPCP_Product_Import") == "None" and $WC_Update != "Yes") {
			$UPCP_Product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_ID=%d", $Item_ID));
			update_option("UPCP_Product_Import", 'ultimate-product-catalogue');
			UPCP_Create_Linked_WC_Product($UPCP_Product);
		}

		$update = __("Product has been successfully edited." . $CustomFieldError, 'ultimate-product-catalogue');
		return $update;
}

function Duplicate_UPCP_Product($Item_ID) {
	global $wpdb;
	global $items_table_name;
	global $item_images_table_name;
	global $item_videos_table_name;
	global $categories_table_name;
	global $subcategories_table_name;
	global $tagged_items_table_name;
	global $fields_meta_table_name;
	global $Full_Version;

	$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

	$Old_Item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_ID=%d", $Item_ID));

	$Today = date("Y-m-d H:i:s");

	$wpdb->insert($items_table_name,
		array(
			'Item_Name' => $Old_Item->Item_Name . " - copy",
			'Item_Slug' => $Old_Item->Item_Slug . "-copy",
			'Item_Description' => $Old_Item->Item_Description,
			'Item_Price' => $Old_Item->Item_Price,
			'Item_Sale_Price' => $Old_Item->Item_Sale_Price,
			'Item_Sale_Mode' => $Old_Item->Item_Sale_Mode,
			'Item_Link' => $Old_Item->Item_Link,
			'Item_Photo_URL' => $Old_Item->Item_Photo_URL,
			'Item_Display_Status' => $Old_Item->Item_Display_Status,
			'Category_ID' => $Old_Item->Category_ID,
			'Category_Name' => $Old_Item->Category_Name,
			'Global_Item_ID' => $Old_Item->Global_Item_ID,
			'Item_Special_Attr' => $Old_Item->Item_Special_Attr,
			'SubCategory_ID' => $Old_Item->SubCategory_ID,
			'SubCategory_Name' => $Old_Item->SubCategory_Name,
			'Item_Related_Products' => $Old_Item->Related_Products,
			'Item_Next_Previous' => $Old_Item->Next_Previous,
			'Item_SEO_Description' => $Old_Item->Item_SEO_Description,
			'Item_Date_Created' => $Today
		)
	);

	$New_Item_ID = $wpdb->insert_id;
	$_GET['Item_ID'] = $New_Item_ID;

	if ($Old_Item->Category_ID) {$wpdb->query("UPDATE $categories_table_name SET Category_Item_Count=Category_Item_Count + 1 WHERE Category_ID =" . $Old_Item->Category_ID);}
	if ($Old_Item->SubCategory_ID) {$wpdb->query("UPDATE $subcategories_table_name SET SubCategory_Item_Count=SubCategory_Item_Count + 1 WHERE SubCategory_ID =" . $Old_Item->SubCategory_ID);}

	$Field_Values = $wpdb->get_results($wpdb->prepare("SELECT * FROM $fields_meta_table_name WHERE Item_ID=%d", $Old_Item->Item_ID));
	foreach ($Field_Values as $Field_Value) {
		$wpdb->insert($fields_meta_table_name,
			array(
				'Field_ID' => $Field_Value->Field_ID,
				'Item_ID' => $New_Item_ID,
				'Meta_Value' => $Field_Value->Meta_Value
			)
		);
	}

	$Tagged_Items = $wpdb->get_results("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID='" . $Old_Item->Item_ID ."'");
	foreach ($Tagged_Items as $Tagged_Item) {
		$wpdb->insert($tagged_items_table_name,
			array(
				'Tag_ID' => $Tagged_Item->Tag_ID,
				'Item_ID' => $New_Item_ID
			)
		);
	}
	
	$Item_Images = $wpdb->get_results("SELECT * FROM $item_images_table_name WHERE Item_ID='" . $Old_Item->Item_ID ."'");
	foreach ($Item_Images as $Item_Image) {
		$wpdb->insert($item_images_table_name,
			array(
				'Item_ID' => $New_Item_ID,
				'Item_Image_URL' => $Item_Image->Item_Image_URL,
				'Item_Image_Description' => $Item_Image->Item_Image_Description,
				'Item_Image_Order' => $Item_Image->Item_Image_Order
			)
		);
	}

	$Item_Videos = $wpdb->get_results("SELECT * FROM $item_videos_table_name WHERE Item_ID='" . $Old_Item->Item_ID ."'");
	foreach ($Item_Videos as $Item_Video) {
		$wpdb->insert($item_videos_table_name,
			array(
				'Item_ID' => $New_Item_ID,
				'Item_Video_URL' => $Item_Video->Item_Video_URL,
				'Item_Video_Type' => $Item_Video->Item_Video_Type,
				'Item_Video_Order' => $Item_Video->Item_Video_Order
			)
		);
	}

	UPCP_Create_XML_Sitemap();

	if ($WooCommerce_Sync == "Yes") {
		$UPCP_Product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $items_table_name WHERE Item_ID=%d", $New_Item_ID));
		update_option("UPCP_Product_Import", 'ultimate-product-catalogue');
		UPCP_Create_Linked_WC_Product($UPCP_Product);
	}
}

/* Adds multiple new products inputted via a spreadsheet uploaded to the top form
*  on the left-hand side of the products' page to the UPCP database */
if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once UPCP_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
function Add_UPCP_Products_From_Spreadsheet($Excel_File_Name) {
		global $wpdb;
		global $items_table_name;
		global $categories_table_name;
		global $subcategories_table_name;
		global $tags_table_name;
		global $tagged_items_table_name;
		global $fields_table_name;
		global $fields_meta_table_name;
		global $catalogue_items_table_name;
		global $catalogues_table_name;
		global $Full_Version;
//$wpdb->show_errors();
		
		$Excel_URL = UPCP_CD_PLUGIN_PATH . 'product-sheets/' . $Excel_File_Name;

		// Build the workbook object out of the uploaded spredsheet
		$objWorkBook = \PhpOffice\PhpSpreadsheet\IOFactory::load($Excel_URL);

		// Create a worksheet object out of the product sheet in the workbook
		$sheet = $objWorkBook->getActiveSheet();

		//List of fields that can be accepted via upload
		$Allowed_Fields = array ("Name" => "Item_Name", "Slug" => "Item_Slug", "Description" => "Item_Description", "Price" => "Item_Price", "Sale Price" => "Item_Sale_Price", "Image" => "Item_Photo_URL", "Link" => "Item_Link", "Category" => "Category_Name", "Sub-Category" => "SubCategory_Name", "Tags" => "Tags_Names_String", "SEO Description" => "Item_SEO_Description", "Display" => "Item_Display_Status", "Catalogue ID" => "Catalogue_ID");
		$Custom_Fields_From_DB = $wpdb->get_results("SELECT Field_ID, Field_Name, Field_Values, Field_Type FROM $fields_table_name");
		if (is_array($Custom_Fields_From_DB)) {
			  foreach ($Custom_Fields_From_DB as $Custom_Field_From_DB) {
						$Allowable_Custom_Fields[$Custom_Field_From_DB->Field_Name] = $Custom_Field_From_DB->Field_Name;
						$Field_IDs[$Custom_Field_From_DB->Field_Name] = $Custom_Field_From_DB->Field_ID;
				}
		}
		if (!is_array($Allowable_Custom_Fields)) {$Allowable_Custom_Fields = array();}

		// Get column names
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
		for ($column = 1; $column <= $highestColumnIndex; $column++) {
				$Titles[$column] = trim($sheet->getCellByColumnAndRow($column, 1)->getValue());
		}

		// Make sure all columns are acceptable based on the acceptable fields above
		$Custom_Fields = array();
		$Additional_Images_Cols = array();
		$Video_IDs_Cols = array();
		$Related_Product_ID_Cols = array();
		foreach ($Titles as $key => $Title) {
				if ($Title != "" and !array_key_exists($Title, $Allowed_Fields) and !array_key_exists($Title, $Allowable_Custom_Fields) and strpos($Title, "Additional Image") === FALSE and strpos($Title, "Video ID") === FALSE and strpos($Title, "Related Product") === FALSE) {
					$Error = __("You have a column which is not recognized: ", 'ultimate-product-catalogue') . $Title . __(". <br>Please make sure that the column names match the product field labels exactly.", 'ultimate-product-catalogue');
					$user_update = array("Message_Type" => "Error", "Message" => $Error);
					return $user_update;
				}
				if ($Title == "") {
					$Error = __("You have a blank column that has been edited.<br>Please delete that column and re-upload your spreadsheet.", 'ultimate-product-catalogue');
					$user_update = array("Message_Type" => "Error", "Message" => $Error);
					return $user_update;
				}
				if (is_array($Allowable_Custom_Fields)) {
					if (array_key_exists($Title, $Allowable_Custom_Fields)) {
					  	$Custom_Fields[$key] = $Title;
						unset($Titles[$key]);
					}
				}
				if (strpos($Title, "Additional Image") !== FALSE) {
					$Additional_Images_Cols[] = $key;
				}
				if (strpos($Title, "Video ID") !== FALSE) {
					$Video_IDs_Cols[] = $key;
				}
				if (strpos($Title, "Related Product") !== FALSE) {
					$Related_Product_ID_Cols[] = $key;
				}
		}

		// Put the spreadsheet data into a multi-dimensional array to facilitate processing
		$highestRow = $sheet->getHighestRow();
		for ($row = 2; $row <= $highestRow; $row++) {
				for ($column = 1; $column <= $highestColumnIndex; $column++) {
						$Data[$row][$column] = $sheet->getCellByColumnAndRow($column, $row)->getValue();
				}
		}

		$Prod_Count = $wpdb->get_var("SELECT COUNT(*) FROM " . $items_table_name);

		$New_Product_Count = $Prod_Count + sizeOf($Data);

		if ($New_Product_Count > 100 and $Full_Version != "Yes") {
			  $Error = __("Maximum number of products (100) for the free version would be exceeded with spreadhseet products. Upgrade to the premium version to continue.", 'ultimate-product-catalogue');
				$user_update = array("Message_Type" => "Error", "Message" => $Error);
				return $user_update;
		}

		// Create an array of the categories currently in the UPCP database,
		// with Category_Name as the key and Category_ID as the value
		$Categories_From_DB = $wpdb->get_results("SELECT * FROM $categories_table_name");
		foreach ($Categories_From_DB as $Category) {
				$Categories[$Category->Category_Name] = $Category->Category_ID;
		}

		// Create an array of the sub-categories currently in the UPCP database,
		// with SubCategory_Name as the key and SubCategory_ID as the value
		$SubCategories_From_DB = $wpdb->get_results("SELECT * FROM $subcategories_table_name");
		foreach ($SubCategories_From_DB as $SubCategory) {
				$SubCategories[$SubCategory->SubCategory_Name] = $SubCategory->SubCategory_ID;
		}

		// Create an array of the tags currently in the UPCP database,
		// with Tag_Name as the key and Tag_ID as the value
		$Tags_From_DB = $wpdb->get_results("SELECT * FROM $tags_table_name");
		foreach ($Tags_From_DB as $Tag) {
				$Tags[$Tag->Tag_Name] = $Tag->Tag_ID;
		}

		// Creates an array of the field names which are going to be inserted into the database
		// and then turns that array into a string so that it can be used in the query
		for ($column = 1; $column <= $highestColumnIndex; $column++) {
				if ($Allowed_Fields[$Titles[$column]] != "Tags_Names_String" and $Allowed_Fields[$Titles[$column]] != "Catalogue_ID" and !array_key_exists($column, $Custom_Fields) and !in_array($column, $Additional_Images_Cols) and !in_array($column, $Video_IDs_Cols) and !in_array($column, $Related_Product_ID_Cols)) {$Fields[] = $Allowed_Fields[$Titles[$column]];}
				if ($Allowed_Fields[$Titles[$column]] == "Category_Name") {$Category_Column = $column; $Fields[] = "Category_ID";}
				if ($Allowed_Fields[$Titles[$column]] == "SubCategory_Name") {$SubCategory_Column = $column; $Fields[] = "SubCategory_ID";}
				if ($Allowed_Fields[$Titles[$column]] == "Tags_Names_String") {$Tags_Column = $column;}
				if ($Allowed_Fields[$Titles[$column]] == "Catalogue_ID") {$Cat_ID_Column = $column;}
		}
		$FieldsString = implode(",", $Fields);
		
		$ShowStatus = "Show";
		$Today = date("Y-m-d H:i:s");
		$wpdb->show_errors();
		// Create the query to insert the products one at a time into the database and then run it
		foreach ($Data as $Product) {

				// Create an array of the values that are being inserted for each product,
				// add in the values for Category_ID and SubCategory_ID, and increment
				// the category and sub-category counts when neccessary
				$Related_Product_IDs = array();

				foreach ($Product as $Col_Index => $Value) {
						if ((!isset($Tags_Column) or $Tags_Column != $Col_Index) and (!isset($Cat_ID_Column) or $Cat_ID_Column != $Col_Index) and !array_key_exists($Col_Index, $Custom_Fields) and !in_array($Col_Index, $Additional_Images_Cols) and !in_array($Col_Index, $Video_IDs_Cols) and !in_array($Col_Index, $Related_Product_ID_Cols)) {$Values[] = esc_sql($Value);}
						if (isset($Category_Column) and $Category_Column == $Col_Index) {
							$Values[] = $Categories[$Value];
							$wpdb->query("UPDATE $categories_table_name SET Category_Item_Count=Category_Item_Count+1 WHERE Category_ID='" . $Categories[$Value] . "'");
						}
						if (isset($SubCategory_Column) and $SubCategory_Column == $Col_Index) {
							$Values[] = $SubCategories[$Value];
							$wpdb->query("UPDATE $subcategories_table_name SET SubCategory_Item_Count=SubCategory_Item_Count+1 WHERE SubCategory_ID='" . $SubCategories[$Value] . "'");
						}
						if (isset($Tags_Column) and $Tags_Column == $Col_Index) {
							$Tags_Names_Array = explode(",", esc_sql($Value));
						}
						if (array_key_exists($Col_Index, $Custom_Fields)) {
							$Custom_Fields_To_Insert[$Custom_Fields[$Col_Index]] = $Value;
						}
						if (isset($Cat_ID_Column) and $Cat_ID_Column == $Col_Index and $Value != "") {
							$Cat_IDs = $Value;
						}
						if (in_array($Col_Index, $Additional_Images_Cols) and $Value != "") {
							$Additional_Images[] = $Value;
						}
						if (in_array($Col_Index, $Video_IDs_Cols) and $Value != "") {
							$Video_IDs[] = $Value;
						}
						if (in_array($Col_Index, $Related_Product_ID_Cols) and $Value != "") {
							$Related_Product_IDs[] = $Value;
						}
				}

				$ValuesString = implode("','", $Values);
				$Related_Product_IDs_String = implode(",", $Related_Product_IDs);
				$wpdb->query(
					$wpdb->prepare("INSERT INTO $items_table_name (" . $FieldsString . ", Item_Related_Products, Item_Display_Status, Item_Date_Created) VALUES ('" . $ValuesString . "','%s', '%s', '%s')", $Related_Product_IDs_String, $ShowStatus, $Today)
				);

				$Item_ID = $wpdb->insert_id;
				if (is_array($Tags_Names_Array)) {
					foreach ($Tags_Names_Array as $Tag_Name) {
						$Trimmed_Name = trim($Tag_Name);
						$Tag_ID = $Tags[$Trimmed_Name];
						$wpdb->query($wpdb->prepare("INSERT INTO $tagged_items_table_name (Tag_ID, Item_ID) VALUES (%d, %d)", $Tag_ID, $Item_ID));
						$wpdb->query($wpdb->prepare("UPDATE $tags_table_name SET Tag_Item_Count=Tag_Item_Count WHERE Tag_ID=%d", $Tag_ID));
					}
				}

				if (isset($Cat_IDs)) {
					$Cat_ID_Array = explode(",", $Cat_IDs);
					foreach ($Cat_ID_Array as $Cat_ID) {
						$wpdb->query(
							$wpdb->prepare("INSERT INTO $catalogue_items_table_name (Catalogue_ID, Item_ID) VALUES ('%d','%d')", $Cat_ID, $Item_ID)
						);
					}
				}

				if (is_array($Custom_Fields_To_Insert)) {
						foreach ($Custom_Fields_To_Insert as $Field => $Value) {
								$Trimmed_Field = trim($Field);
								$Field_ID = $Field_IDs[$Trimmed_Field];
								$wpdb->query($wpdb->prepare("INSERT INTO $fields_meta_table_name (Field_ID, Item_ID, Meta_Value) VALUES (%d, %d, %s)", $Field_ID, $Item_ID, $Value));
						}
				}

				if (is_array($Additional_Images)) {
					foreach ($Additional_Images as $Image) {
						if ($Image != "") {Add_Product_Image($Item_ID, $Image);}
					}
				}

				if (is_array($Video_IDs)) {
					foreach ($Video_IDs as $Video_ID) {
						if ($Video_ID != "") {Add_Product_Videos($Item_ID, $Video_ID, "YouTube");}
					}
				}

				unset($Values);
				unset($Item_ID);
				unset($ValuesString);
				unset($Tags_Name_Array);
				unset($Custom_Fields_To_Insert);
				unset($Cat_IDs);
				unset($Additional_Images);
				unset($Video_IDs);
				unset($Related_Product_IDs);
		}

		$Catalogues = $wpdb->get_results("SELECT Catalogue_ID FROM $catalogues_table_name");
		foreach ($Catalogues as $Catalogue) {Update_Catalogue_Item_Count($Catalogue->Catalogue_ID);}

		UPCP_Create_XML_Sitemap();

		return __("Products added successfully.", 'ultimate-product-catalogue');
}

/* Deletes a single product with a given ID from the UPCP database */
function Delete_UPCP_Product($Item_ID) {
		global $wpdb;
		global $items_table_name;
		global $item_images_table_name;
		global $categories_table_name;
		global $subcategories_table_name;
		global $tags_table_name;
		global $tagged_items_table_name;
        global $catalogue_items_table_name;

        $WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

        if ($WooCommerce_Sync == "Yes") {
        	$WC_ID = $wpdb->get_var($wpdb->prepare("SELECT Item_WC_ID FROM $items_table_name WHERE Item_ID=%d", $Item_ID));
        	if ($WC_ID != "") {UPCP_Delete_WC_Product($WC_ID);}
        }

		// Delete the tagged item in the tagged items table for the given Item_ID
		// and update the Item_Count column in the tags table in the database
		$Tagged_Items = $wpdb->get_results($wpdb->prepare("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=%d", $Item_ID));
		$Catalogue_IDs = $wpdb->get_results($wpdb->prepare("SELECT Catalogue_ID FROM $catalogue_items_table_name WHERE Item_ID=%d", $Item_ID));
		foreach ($Tagged_Items as $Tagged_Item) {
				$wpdb->query("UPDATE $tags_table_name SET Tag_Item_Count=Tag_Item_Count - 1 WHERE Tag_ID =" . $Tagged_Item->Tag_ID);
		}
		$wpdb->delete(
				$tagged_items_table_name,
				array('Item_ID' => $Item_ID)
		);

        $wpdb->delete(
            $catalogue_items_table_name,
            array('Item_ID' => $Item_ID)
        );

        foreach ($Catalogue_IDs as $Catalogue_ID) {
        	Update_Catalogue_Item_Count($Catalogue_ID->Catalogue_ID);
        }

		// Decrease the Item_Count column for the category and sub-category tables in the database
		$Current_Product = $wpdb->get_row("SELECT Category_ID, SubCategory_ID FROM $items_table_name WHERE Item_ID='" . $Item_ID ."'");
		if ($Current_Product->Category_ID != 0) {$wpdb->query("UPDATE $categories_table_name SET Category_Item_Count=Category_Item_Count - 1 WHERE Category_ID =" . $Current_Product->Category_ID);}
		if ($Current_Product->SubCategory_ID != 0) {$wpdb->query("UPDATE $subcategories_table_name SET SubCategory_Item_Count=SubCategory_Item_Count - 1 WHERE SubCategory_ID =" . $Current_Product->SubCategory_ID);}

		$wpdb->delete(
						$items_table_name,
						array('Item_ID' => $Item_ID)
					);

		$wpdb->delete(
						$item_images_table_name,
						array('Item_ID' => $Item_ID)
					);

		UPCP_Create_XML_Sitemap();

		$update = __("Product has been successfully deleted.", 'ultimate-product-catalogue');
		return $update;
}

/* Adds a new product image to for a specified product to the UPCP database */
function Add_Product_Image($Item_ID, $Image_URL, $Image_Description = "") {
		global $wpdb;
		global $item_images_table_name;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		$wpdb->query(
							$wpdb->prepare("INSERT INTO $item_images_table_name (Item_ID, Item_Image_URL, Item_Image_Description) VALUES (%d, %s, %s)", $Item_ID, $Image_URL, $Item_Image_Description)
				);

		$Item_Image = $wpdb->get_row($wpdb->prepare("SELECT * FROM $item_images_table_name WHERE Item_Image_ID=%d", $wpdb->insert_id));
		if ($WooCommerce_Sync == "Yes") {UPCP_Add_WC_Image($Item_Image);}

		$update = __("Image has been successfully added to the product.", 'ultimate-product-catalogue');
		return $update;
}

/* Deletes a single image with a given Item_Image_ID from the UPCP database */
function Delete_Product_Image() {
		global $wpdb;
		global $item_images_table_name;

		$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");

		$Item_Image = $wpdb->get_row($wpdb->prepare("SELECT * FROM $item_images_table_name WHERE Item_Image_ID=%d", $_GET['Item_Image_ID']));

		$wpdb->delete(
						$item_images_table_name,
						array('Item_Image_ID' => $_GET['Item_Image_ID'])
					);

		if ($WooCommerce_Sync == "Yes") {UPCP_Remove_WC_Image($Item_Image);}

		$update = __("Image has been successfully removed.", 'ultimate-product-catalogue');
		return $update;
}

/* Updates the main plugin options in the WordPress database */
function Update_UPCP_Options() {
	global $Full_Version;

	if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

	$Social_Media = "";
	$InstallVersion = get_option("UPCP_First_Install_Version");

	if (!current_user_can(get_option("UPCP_Access_Role"))) {return;}

	if (isset($_POST['product_inquiry_form']) and $_POST['product_inquiry_form'] == "Yes" and get_option("UPCP_Product_Inquiry_Form") == "No") {UPCP_Product_Inquiry_Form();}
	if (isset($_POST['woocommerce_sync']) and $_POST['woocommerce_sync'] == "Yes" and get_option("UPCP_WooCommerce_Sync") == "No") {$Run_WC_Sync = "Yes";}
	else {$Run_WC_Sync = "No";}

	if (isset($_POST['color_scheme'])) {update_option('UPCP_Color_Scheme', $_POST['color_scheme']);}
	if (isset($_POST['thumb_auto_adjust'])) {update_option('UPCP_Thumb_Auto_Adjust', $_POST['thumb_auto_adjust']);}
	if (isset($_POST['currency_symbol'])) {update_option('UPCP_Currency_Symbol', $_POST['currency_symbol']);}
	if (isset($_POST['currency_code'])) {update_option('UPCP_Currency_Code', $_POST['currency_code']);}
	if (isset($_POST['currency_symbol_location'])) {update_option('UPCP_Currency_Symbol_Location', $_POST['currency_symbol_location']);}
	if (isset($_POST['product_links'])) {update_option('UPCP_Product_Links', $_POST['product_links']);}
	if (isset($_POST['tag_logic'])) {update_option('UPCP_Tag_Logic', $_POST['tag_logic']);}
	if (isset($_POST['filter_type'])) {update_option('UPCP_Filter_Type', $_POST['filter_type']);}
	if (isset($_POST['price_filter'])) {update_option('UPCP_Price_Filter', $_POST['price_filter']);}
	if (isset($_POST['slider_filter_inputs'])) {update_option('UPCP_Slider_Filter_Inputs', $_POST['slider_filter_inputs']);}
	if (isset($_POST['sale_mode'])) {update_option('UPCP_Sale_Mode', $_POST['sale_mode']);}
	if (isset($_POST['read_more'])) {update_option("UPCP_Read_More", $_POST['read_more']);}
	if (isset($_POST['desc_count'])) {update_option("UPCP_Desc_Chars", $_POST['desc_count']);}
	if (isset($_POST['sidebar_order'])) {update_option("UPCP_Sidebar_Order", $_POST['sidebar_order']);}
	if (isset($_POST['product_search'])) {update_option("UPCP_Product_Search", $_POST['product_search']);}
	$DetailsImageLink = Prepare_Details_Image();
	if (isset($_POST['Details_Image'])) {update_option("UPCP_Details_Image", $DetailsImageLink);}
	if (isset($_POST['single_page_price'])) {update_option("UPCP_Single_Page_Price", $_POST['single_page_price']);}
	if (isset($_POST['case_insensitive_search'])) {update_option("UPCP_Case_Insensitive_Search", $_POST['case_insensitive_search']);}
	if (isset($_POST['contents_filter'])) {update_option("UPCP_Apply_Contents_Filter", $_POST['contents_filter']);}
	if (isset($_POST['maintain_filtering'])) {update_option("UPCP_Maintain_Filtering", $_POST['maintain_filtering']);}
	if (isset($_POST['thumbnail_support'])) {update_option("UPCP_Thumbnail_Support", $_POST['thumbnail_support']);}
	if (isset($_POST['show_category_descriptions'])) {update_option("UPCP_Show_Category_Descriptions", $_POST['show_category_descriptions']);}
	if (isset($_POST['show_catalogue_information'])) {update_option("UPCP_Show_Catalogue_Information", $_POST['show_catalogue_information']);}
	if (isset($_POST['display_category_image'])) {update_option("UPCP_Display_Category_Image", $_POST['display_category_image']);}
	if (isset($_POST['display_subcategory_image'])) {update_option("UPCP_Display_SubCategory_Image", $_POST['display_subcategory_image']);}
	if (isset($_POST['display_categories_in_thumbnails'])) {update_option("UPCP_Display_Categories_In_Thumbnails", $_POST['display_categories_in_thumbnails']);}
	if (isset($_POST['display_tags_in_thumbnails'])) {update_option("UPCP_Display_Tags_In_Thumbnails", $_POST['display_tags_in_thumbnails']);}
	if (isset($_POST['overview_mode'])) {update_option("UPCP_Overview_Mode", $_POST['overview_mode']);}
	if (isset($_POST['inner_filter'])) {update_option("UPCP_Inner_Filter", $_POST['inner_filter']);}
	if (isset($_POST['clear_all'])) {update_option("UPCP_Clear_All", $_POST['clear_all']);}
	if (isset($_POST['hide_empty_options'])) {update_option("UPCP_Hide_Empty_Options", $_POST['hide_empty_options']);}
	if (isset($_POST['breadcrumbs'])) {update_option("UPCP_Breadcrumbs", $_POST['breadcrumbs']);}
	if (isset($_POST['extra_elements'])) {$Extra_Elements_Array = $_POST['extra_elements'];}
	else {$Extra_Elements_Array = array();}
	if (!is_array($Extra_Elements_Array)) {$Extra_Elements_Array = array();}
	$Extra_Elements = implode(",", $Extra_Elements_Array);
	if (isset($_POST['extra_elements'])) {update_option("UPCP_Extra_Elements", $Extra_Elements);}
	if (isset($_POST['Socialmedia'])) {$Social_Media_Array = $_POST['Socialmedia'];}
	else {$Social_Media_Array = array();}
    if (is_array($Social_Media_Array)) {$Social_Media = implode(",", $Social_Media_Array);}
    if (isset($_POST['Socialmedia'])) {update_option("UPCP_Social_Media", $Social_Media);}

	if ($Full_Version == "Yes" and isset($_POST['filter_title'])) {update_option("UPCP_Filter_Title", $_POST['filter_title']);}
	if ($Full_Version == "Yes" and isset($_POST['custom_product_page'])) {update_option("UPCP_Custom_Product_Page", $_POST['custom_product_page']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison'])) {update_option("UPCP_Product_Comparison", $_POST['product_comparison']);}
	if ($Full_Version == "Yes" and isset($_POST['product_inquiry_form'])) {update_option("UPCP_Product_Inquiry_Form", $_POST['product_inquiry_form']);}
	if ($Full_Version == "Yes" and isset($_POST['product_inquiry_cart'])) {update_option("UPCP_Product_Inquiry_Cart", $_POST['product_inquiry_cart']);}
	if ($Full_Version == "Yes" and isset($_POST['inquiry_form_email'])) {update_option("UPCP_Inquiry_Form_Email", $_POST['inquiry_form_email']);}
	if ($Full_Version == "Yes" and isset($_POST['product_reviews'])) {update_option("UPCP_Product_Reviews", $_POST['product_reviews']);}
	if ($Full_Version == "Yes" and isset($_POST['catalog_display_reviews'])) {update_option("UPCP_Catalog_Display_Reviews", $_POST['catalog_display_reviews']);}
	if ($Full_Version == "Yes" and isset($_POST['lightbox'])) {update_option("UPCP_Lightbox", $_POST['lightbox']);}
	if ($Full_Version == "Yes" and isset($_POST['lightbox_mode'])) {update_option("UPCP_Lightbox_Mode", $_POST['lightbox_mode']);}
	if ($Full_Version == "Yes" and isset($_POST['hidden_drop_down_sidebar_on_mobile'])) {update_option("UPCP_Hidden_Drop_Down_Sidebar_On_Mobile", $_POST['hidden_drop_down_sidebar_on_mobile']);}
	if ($Full_Version == "Yes" and isset($_POST['infinite_scroll'])) {update_option("UPCP_Infinite_Scroll", $_POST['infinite_scroll']);}
	if ($Full_Version == "Yes" and isset($_POST['products_per_page'])) {update_option("UPCP_Products_Per_Page", $_POST['products_per_page']);}
	if ($Full_Version == "Yes" and isset($_POST['pagination_location'])) {update_option("UPCP_Pagination_Location", $_POST['pagination_location']);}
	if ($Full_Version == "Yes" and isset($_POST['Options_Submit'])) {update_option("UPCP_Product_Sort", $_POST['product_sort']);}
	if ($Full_Version == "Yes" and isset($_POST['cf_converion'])) {update_option("UPCP_CF_Conversion", $_POST['cf_converion']);}
	if ($Full_Version == "Yes" and isset($_POST['related_products'])) {update_option("UPCP_Related_Products", $_POST['related_products']);}
	if ($Full_Version == "Yes" and isset($_POST['next_previous'])) {update_option("UPCP_Next_Previous", $_POST['next_previous']);}
	if ($Full_Version == "Yes" and isset($_POST['access_role'])) {update_option("UPCP_Access_Role", $_POST['access_role']);}
	if ($Full_Version == "Yes" and isset($_POST['custom_fields_show_hide'])) {update_option("UPCP_Custom_Fields_Show_Hide", $_POST['custom_fields_show_hide']);}
	if ($Full_Version == "Yes" and isset($_POST['custom_fields_blank'])) {update_option("UPCP_Custom_Fields_Blank", $_POST['custom_fields_blank']);}
	if ($Full_Version == "Yes" and isset($_POST['pp_grid_width'])) {update_option("UPCP_PP_Grid_Width", $_POST['pp_grid_width']);}
	if ($Full_Version == "Yes" and isset($_POST['pp_grid_height'])) {update_option("UPCP_PP_Grid_Height", $_POST['pp_grid_height']);}
	if ($Full_Version == "Yes" and isset($_POST['pp_top_bottom_padding'])) {update_option("UPCP_Top_Bottom_Padding", $_POST['pp_top_bottom_padding']);}
	if ($Full_Version == "Yes" and isset($_POST['pp_left_right_padding'])) {update_option("UPCP_Left_Right_Padding", $_POST['pp_left_right_padding']);}

	if ($Full_Version == "Yes" and isset($_POST['woocommerce_sync'])) {update_option("UPCP_WooCommerce_Sync", $_POST['woocommerce_sync']);}
	if ($Full_Version == "Yes" and isset($_POST['woocommerce_show_cart_count'])) {update_option("UPCP_WooCommerce_Show_Cart_Count", $_POST['woocommerce_show_cart_count']);}
	if ($Full_Version == "Yes" and isset($_POST['woocommerce_checkout'])) {update_option("UPCP_WooCommerce_Checkout", $_POST['woocommerce_checkout']);}
	if ($Full_Version == "Yes" and isset($_POST['woocommerce_cart_page'])) {update_option("UPCP_WooCommerce_Cart_Page", $_POST['woocommerce_cart_page']);}
	if ($Full_Version == "Yes" and isset($_POST['woocommerce_product_page'])) {update_option("UPCP_WooCommerce_Product_Page", $_POST['woocommerce_product_page']);}
	if ($Full_Version == "Yes" and isset($_POST['woocommerce_back_link'])) {update_option("UPCP_WooCommerce_Back_Link", $_POST['woocommerce_back_link']);}

	if ($Full_Version == "Yes" and isset($_POST['categories_label'])) {update_option("UPCP_Categories_Label", $_POST['categories_label']);}
	if ($Full_Version == "Yes" and isset($_POST['subcategories_label'])) {update_option("UPCP_SubCategories_Label", $_POST['subcategories_label']);}
	if ($Full_Version == "Yes" and isset($_POST['tags_label'])) {update_option("UPCP_Tags_Label", $_POST['tags_label']);}
	if ($Full_Version == "Yes" and isset($_POST['custom_fields_label'])) {update_option("UPCP_Custom_Fields_Label", $_POST['custom_fields_label']);}
	if ($Full_Version == "Yes" and isset($_POST['show_all_label'])) {update_option("UPCP_Show_All_Label", $_POST['show_all_label']);}
	if ($Full_Version == "Yes" and isset($_POST['details_label'])) {update_option("UPCP_Details_Label", $_POST['details_label']);}
	if ($Full_Version == "Yes" and isset($_POST['sort_by_label'])) {update_option("UPCP_Sort_By_Label", $_POST['sort_by_label']);}
	if ($Full_Version == "Yes" and isset($_POST['price_ascending_label'])) {update_option("UPCP_Price_Ascending_Label", $_POST['price_ascending_label']);}
	if ($Full_Version == "Yes" and isset($_POST['price_descending_label'])) {update_option("UPCP_Price_Descending_Label", $_POST['price_descending_label']);}
	if ($Full_Version == "Yes" and isset($_POST['name_ascending_label'])) {update_option("UPCP_Name_Ascending_Label", $_POST['name_ascending_label']);}
	if ($Full_Version == "Yes" and isset($_POST['name_descending_label'])) {update_option("UPCP_Name_Descending_Label", $_POST['name_descending_label']);}
	if ($Full_Version == "Yes" and isset($_POST['product_name_search_label'])) {update_option("UPCP_Product_Name_Search_Label", $_POST['product_name_search_label']);}
	if ($Full_Version == "Yes" and isset($_POST['product_name_text_label'])) {update_option("UPCP_Product_Name_Text_Label", $_POST['product_name_text_label']);}
	if ($Full_Version == "Yes" and isset($_POST['back_to_catalogue'])) {update_option("UPCP_Back_To_Catalogue_Label", $_POST['back_to_catalogue']);}
	if ($Full_Version == "Yes" and isset($_POST['updating_results_label'])) {update_option("UPCP_Updating_Results_Label", $_POST['updating_results_label']);}
	if ($Full_Version == "Yes" and isset($_POST['no_results_found_label'])) {update_option("UPCP_No_Results_Found_Label", $_POST['no_results_found_label']);}
	if ($Full_Version == "Yes" and isset($_POST['products_pagination_label'])) {update_option("UPCP_Products_Pagination_Label", $_POST['products_pagination_label']);}
	if ($Full_Version == "Yes" and isset($_POST['read_more_label'])) {update_option("UPCP_Read_More_Label", $_POST['read_more_label']);}
	if ($Full_Version == "Yes" and isset($_POST['product_details_label'])) {update_option("UPCP_Product_Details_Label", $_POST['product_details_label']);}
	if ($Full_Version == "Yes" and isset($_POST['additional_info_label'])) {update_option("UPCP_Additional_Info_Label", $_POST['additional_info_label']);}
	if ($Full_Version == "Yes" and isset($_POST['contact_us_label'])) {update_option("UPCP_Contact_Us_Label", $_POST['contact_us_label']);}
	if ($Full_Version == "Yes" and isset($_POST['product_inquiry_form_title_label'])) {update_option("UPCP_Product_Inquiry_Form_Title_Label", $_POST['product_inquiry_form_title_label']);}
	if ($Full_Version == "Yes" and isset($_POST['customer_reviews_tab_label'])) {update_option("UPCP_Customer_Reviews_Tab_Label", $_POST['customer_reviews_tab_label']);}
	if ($Full_Version == "Yes" and isset($_POST['related_products_label'])) {update_option("UPCP_Related_Products_Label", $_POST['related_products_label']);}
	if ($Full_Version == "Yes" and isset($_POST['next_product_label'])) {update_option("UPCP_Next_Product_Label", $_POST['next_product_label']);}
	if ($Full_Version == "Yes" and isset($_POST['previous_product_label'])) {update_option("UPCP_Previous_Product_Label", $_POST['previous_product_label']);}
	if ($Full_Version == "Yes" and isset($_POST['of_pagination_label'])) {update_option("UPCP_Of_Pagination_Label", $_POST['of_pagination_label']);}
	if ($Full_Version == "Yes" and isset($_POST['compare_label'])) {update_option("UPCP_Compare_Label", $_POST['compare_label']);}
	if ($Full_Version == "Yes" and isset($_POST['sale_label'])) {update_option("UPCP_Sale_Label", $_POST['sale_label']);}
	if ($Full_Version == "Yes" and isset($_POST['side_by_side_label'])) {update_option("UPCP_Side_By_Side_Label", $_POST['side_by_side_label']);}
	if ($Full_Version == "Yes" and isset($_POST['inquire_button_label'])) {update_option("UPCP_Inquire_Button_Label", $_POST['inquire_button_label']);}
	if ($Full_Version == "Yes" and isset($_POST['add_to_cart_button_label'])) {update_option("UPCP_Add_To_Cart_Button_Label", $_POST['add_to_cart_button_label']);}
	if ($Full_Version == "Yes" and isset($_POST['send_inquiry_label'])) {update_option("UPCP_Send_Inquiry_Label", $_POST['send_inquiry_label']);}
	if ($Full_Version == "Yes" and isset($_POST['checkout_label'])) {update_option("UPCP_Checkout_Label", $_POST['checkout_label']);}
	if ($Full_Version == "Yes" and isset($_POST['empty_cart_label'])) {update_option("UPCP_Empty_Cart_Label", $_POST['empty_cart_label']);}
	if ($Full_Version == "Yes" and isset($_POST['cart_items_label'])) {update_option("UPCP_Cart_Items_Label", $_POST['cart_items_label']);}
	if ($Full_Version == "Yes" and isset($_POST['additional_info_category_label'])) {update_option("UPCP_Additional_Info_Category_Label", $_POST['additional_info_category_label']);}
	if ($Full_Version == "Yes" and isset($_POST['additional_info_subcategory_label'])) {update_option("UPCP_Additional_Info_SubCategory_Label", $_POST['additional_info_subcategory_label']);}
	if ($Full_Version == "Yes" and isset($_POST['additional_info_tags_label'])) {update_option("UPCP_Additional_Info_Tags_Label", $_POST['additional_info_tags_label']);}
	if ($Full_Version == "Yes" and isset($_POST['price_filter_label'])) {update_option("UPCP_Price_Filter_Label", $_POST['price_filter_label']);}
	if ($Full_Version == "Yes" and isset($_POST['product_inquiry_please_use_label'])) {update_option("UPCP_Product_Inquiry_Please_Use_Label", $_POST['product_inquiry_please_use_label']);}

	if ($Full_Version == "Yes" and isset($_POST['pretty_links'])) {update_option("UPCP_Pretty_Links", $_POST['pretty_links']);}
	if ($Full_Version == "Yes" and isset($_POST['permalink_base'])) {update_option("UPCP_Permalink_Base", $_POST['permalink_base']);}
	if ($Full_Version == "Yes" and isset($_POST['xml_sitemap_url'])) {update_option("UPCP_XML_Sitemap_URL", $_POST['xml_sitemap_url']);}
	if ($Full_Version == "Yes" and isset($_POST['seo_option'])) {update_option("UPCP_SEO_Option", $_POST['seo_option']);}
	if ($Full_Version == "Yes" and isset($_POST['seo_integration'])) {update_option("UPCP_SEO_Integration", $_POST['seo_integration']);}
	if ($Full_Version == "Yes" and isset($_POST['seo_title'])) {update_option("UPCP_SEO_Title", $_POST['seo_title']);}
	if ($Full_Version == "Yes" and isset($_POST['update_breadcrumbs'])) {update_option("UPCP_Update_Breadcrumbs", $_POST['update_breadcrumbs']);}

	if ($Full_Version == "Yes" and isset($_POST['catalogue_style'])) {update_option("UPCP_Catalogue_Style", $_POST['catalogue_style']);}
	if ($Full_Version == "Yes" and isset($_POST['category_heading_style'])) {update_option("UPCP_Category_Heading_Style", $_POST['category_heading_style']);}
	if ($Full_Version == "Yes" and isset($_POST['compare_button_background_color'])) {update_option("UPCP_Compare_Button_Background_Color", $_POST['compare_button_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['compare_button_text_color'])) {update_option("UPCP_Compare_Button_Text_Color", $_POST['compare_button_text_color']); }
	if ($Full_Version == "Yes" and isset($_POST['compare_button_font_size'])) {update_option("UPCP_Compare_Button_Font_Size", $_POST['compare_button_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['compare_button_clicked_background_color'])) {update_option("UPCP_Compare_Button_Clicked_Background_Color", $_POST['compare_button_clicked_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['compare_button_clicked_text_color'])) {update_option("UPCP_Compare_Button_Clicked_Text_Color", $_POST['compare_button_clicked_text_color']); }
	if ($Full_Version == "Yes" and isset($_POST['sale_button_background_color'])) {update_option("UPCP_Sale_Button_Background_Color", $_POST['sale_button_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['sale_button_text_color'])) {update_option("UPCP_Sale_Button_Text_Color", $_POST['sale_button_text_color']); }
	if ($Full_Version == "Yes" and isset($_POST['sale_button_font_size'])) {update_option("UPCP_Sale_Button_Font_Size", $_POST['sale_button_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['details_icon_type'])) {update_option("UPCP_Details_Icon_Type", $_POST['details_icon_type']);}
	if ($Full_Version == "Yes" and isset($_POST['Details_Image'])) {update_option("UPCP_Details_Image", $DetailsImageLink);}
	if ($Full_Version == "Yes" and isset($_POST['details_icon_color'])) {update_option("UPCP_Details_Icon_Color", $_POST['details_icon_color']);}
	if ($Full_Version == "Yes" and isset($_POST['details_icon_font_size'])) {update_option("UPCP_Details_Icon_Font_Size", $_POST['details_icon_font_size']);}
	if ($Full_Version == "Yes" and isset($_POST['details_icon_font_selection'])) {update_option("UPCP_Details_Icon_Font_Selection", $_POST['details_icon_font_selection']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison_columns'])) {update_option("UPCP_Product_Comparison_Columns", $_POST['product_comparison_columns']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison_title_font_size'])) {update_option("UPCP_Product_Comparison_Title_Font_Size", $_POST['product_comparison_title_font_size']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison_title_font_color'])) {update_option("UPCP_Product_Comparison_Title_Font_Color", $_POST['product_comparison_title_font_color']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison_price_font_size'])) {update_option("UPCP_Product_Comparison_Price_Font_Size", $_POST['product_comparison_price_font_size']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison_price_font_color'])) {update_option("UPCP_Product_Comparison_Price_Font_Color", $_POST['product_comparison_price_font_color']);}
	if ($Full_Version == "Yes" and isset($_POST['product_comparison_price_background_color'])) {update_option("UPCP_Product_Comparison_Price_Background_Color", $_POST['product_comparison_price_background_color']);}

	if ($Full_Version == "Yes" and isset($_POST['sidebar_style'])) {update_option("UPCP_Sidebar_Style", $_POST['sidebar_style']);}
	if ($Full_Version == "Yes" and isset($_POST['pagination_background'])) {update_option("UPCP_Pagination_Background", $_POST['pagination_background']);}
	if ($Full_Version == "Yes" and isset($_POST['pagination_border'])) {update_option("UPCP_Pagination_Border", $_POST['pagination_border']);}
	if ($Full_Version == "Yes" and isset($_POST['pagination_shadow'])) {update_option("UPCP_Pagination_Shadow", $_POST['pagination_shadow']);}
	if ($Full_Version == "Yes" and isset($_POST['pagination_gradient'])) {update_option("UPCP_Pagination_Gradient", $_POST['pagination_gradient']);}
	if ($Full_Version == "Yes" and isset($_POST['pagination_font'])) {update_option("UPCP_Pagination_Font", $_POST['pagination_font']);}
	if ($Full_Version == "Yes" and isset($_POST['sidebar_title_collapse'])) {update_option("UPCP_Sidebar_Title_Collapse", $_POST['sidebar_title_collapse']);}
	if ($Full_Version == "Yes" and isset($_POST['sidebar_subcat_collapse'])) {update_option("UPCP_Sidebar_Subcat_Collapse", $_POST['sidebar_subcat_collapse']);}
	if ($Full_Version == "Yes" and isset($_POST['sidebar_start_collapsed'])) {update_option("UPCP_Sidebar_Start_Collapsed", $_POST['sidebar_start_collapsed']);}
	if ($Full_Version == "Yes" and isset($_POST['sidebar_title_hover'])) {update_option("UPCP_Sidebar_Title_Hover", $_POST['sidebar_title_hover']);}
	if ($Full_Version == "Yes" and isset($_POST['sidebar_checkbox_style'])) {update_option("UPCP_Sidebar_Checkbox_Style", $_POST['sidebar_checkbox_style']);}

	/* Thumbnail View Options */
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_hover_fade'])) {update_option("UPCP_Thumbnail_View_Image_Hover_Fade", $_POST['thumbnail_view_image_hover_fade']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_mouseover_zoom'])) {update_option("UPCP_Thumbnail_View_Mouseover_Zoom", $_POST['thumbnail_view_mouseover_zoom']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_height'])) {update_option("UPCP_Thumbnail_View_Image_Height", $_POST['thumbnail_view_image_height']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_width'])) {update_option("UPCP_Thumbnail_View_Image_Width", $_POST['thumbnail_view_image_width']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_holder_height'])) {update_option("UPCP_Thumbnail_View_Image_Holder_Height", $_POST['thumbnail_view_image_holder_height']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_holder_width'])) {update_option("UPCP_Thumbnail_View_Image_Holder_Width", $_POST['thumbnail_view_image_holder_width']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_border'])) {update_option("UPCP_Thumbnail_View_Image_Border", $_POST['thumbnail_view_image_border']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_image_border_color'])) {update_option("UPCP_Thumbnail_View_Image_Border_Color", $_POST['thumbnail_view_image_border_color']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_box_width'])) {update_option("UPCP_Thumbnail_View_Box_Width", $_POST['thumbnail_view_box_width']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_box_min_height'])) {update_option("UPCP_Thumbnail_View_Box_Min_Height", $_POST['thumbnail_view_box_min_height']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_box_max_height'])) {update_option("UPCP_Thumbnail_View_Box_Max_Height", $_POST['thumbnail_view_box_max_height']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_box_padding'])) {update_option("UPCP_Thumbnail_View_Box_Padding", $_POST['thumbnail_view_box_padding']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_box_margin'])) {update_option("UPCP_Thumbnail_View_Box_Margin", $_POST['thumbnail_view_box_margin']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_box_border'])) {update_option("UPCP_Thumbnail_View_Box_Border", $_POST['thumbnail_view_box_border']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_border_color'])) {update_option("UPCP_Thumbnail_View_Border_Color", $_POST['thumbnail_view_border_color']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_title_font_size'])) {update_option("UPCP_Thumbnail_View_Title_Font_Size", $_POST['thumbnail_view_title_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_title_color'])) {update_option("UPCP_Thumbnail_View_Title_Color", $_POST['thumbnail_view_title_color']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_price_font'])) {update_option("UPCP_Thumbnail_View_Price_Font", $_POST['thumbnail_view_price_font']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_price_font_size'])) {update_option("UPCP_Thumbnail_View_Price_Font_Size", $_POST['thumbnail_view_price_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_price_color'])) {update_option("UPCP_Thumbnail_View_Price_Color", $_POST['thumbnail_view_price_color']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_background_color'])) {update_option("UPCP_Thumbnail_View_Background_Color", $_POST['thumbnail_view_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_separator_line'])) {update_option("UPCP_Thumbnail_View_Separator_Line", $_POST['thumbnail_view_separator_line']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_details_arrow'])) {update_option("UPCP_Thumbnail_View_Details_Arrow", $_POST['thumbnail_view_details_arrow']); }
	if ($Full_Version == "Yes" and isset($_POST['thumbnail_view_custom_details_arrow'])) {update_option("UPCP_Thumbnail_View_Custom_Details_Arrow", $_POST['thumbnail_view_custom_details_arrow']); }

	/* List View Options */
	if ($Full_Version == "Yes" and isset($_POST['list_view_click_action'])) {update_option("UPCP_List_View_Click_Action", $_POST['list_view_click_action']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_hover_fade'])) {update_option("UPCP_List_View_Image_Hover_Fade", $_POST['list_view_image_hover_fade']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_mouseover_zoom'])) {update_option("UPCP_List_View_Mouseover_Zoom", $_POST['list_view_mouseover_zoom']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_height'])) {update_option("UPCP_List_View_Image_Height", $_POST['list_view_image_height']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_width'])) {update_option("UPCP_List_View_Image_Width", $_POST['list_view_image_width']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_holder_height'])) {update_option("UPCP_List_View_Image_Holder_Height", $_POST['list_view_image_holder_height']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_border'])) {update_option("UPCP_List_View_Image_Border", $_POST['list_view_image_border']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_border_color'])) {update_option("UPCP_List_View_Image_Border_Color", $_POST['list_view_image_border_color']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_image_background_color'])) {update_option("UPCP_List_View_Image_Background_Color", $_POST['list_view_image_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_item_margin_left'])) {update_option("UPCP_List_View_Item_Margin_Left", $_POST['list_view_item_margin_left']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_item_margin_top'])) {update_option("UPCP_List_View_Item_Margin_Top", $_POST['list_view_item_margin_top']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_item_padding'])) {update_option("UPCP_List_View_Item_Padding", $_POST['list_view_item_padding']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_item_min_height'])) {update_option("UPCP_List_View_Item_Min_Height", $_POST['list_view_item_min_height']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_item_max_height'])) {update_option("UPCP_List_View_Item_Max_Height", $_POST['list_view_item_max_height']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_item_color'])) {update_option("UPCP_List_View_Item_Color", $_POST['list_view_item_color']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_title_font_size'])) {update_option("UPCP_List_View_Title_Font_Size", $_POST['list_view_title_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_title_color'])) {update_option("UPCP_List_View_Title_Color", $_POST['list_view_title_color']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_title_font'])) {update_option("UPCP_List_View_Title_Font", $_POST['list_view_title_font']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_price_font_size'])) {update_option("UPCP_List_View_Price_Font_Size", $_POST['list_view_price_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_price_color'])) {update_option("UPCP_List_View_Price_Color", $_POST['list_view_price_color']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_price_font'])) {update_option("UPCP_List_View_Price_Font", $_POST['list_view_price_font']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_background_color'])) {update_option("UPCP_List_View_Background_Color", $_POST['list_view_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_details_arrow'])) {update_option("UPCP_List_View_Details_Arrow", $_POST['list_view_details_arrow']); }
	if ($Full_Version == "Yes" and isset($_POST['list_view_custom_details_arrow'])) {update_option("UPCP_List_View_Custom_Details_Arrow", $_POST['list_view_custom_details_arrow']); }

	/* Detail View Options */
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_hover_fade'])) {update_option("UPCP_Detail_View_Image_Hover_Fade", $_POST['detail_view_image_hover_fade']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_mouseover_zoom'])) {update_option("UPCP_Detail_View_Mouseover_Zoom", $_POST['detail_view_mouseover_zoom']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_height'])) {update_option("UPCP_Detail_View_Image_Height", $_POST['detail_view_image_height']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_width'])) {update_option("UPCP_Detail_View_Image_Width", $_POST['detail_view_image_width']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_holder_height'])) {update_option("UPCP_Detail_View_Image_Holder_Height", $_POST['detail_view_image_holder_height']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_holder_width'])) {update_option("UPCP_Detail_View_Image_Holder_Width", $_POST['detail_view_image_holder_width']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_border'])) {update_option("UPCP_Detail_View_Image_Border", $_POST['detail_view_image_border']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_border_color'])) {update_option("UPCP_Detail_View_Image_Border_Color", $_POST['detail_view_image_border_color']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_image_background_color'])) {update_option("UPCP_Detail_View_Image_Background_Color", $_POST['detail_view_image_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_box_width'])) {update_option("UPCP_Detail_View_Box_Width", $_POST['detail_view_box_width']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_box_min_height'])) {update_option("UPCP_Detail_View_Box_Min_Height", $_POST['detail_view_box_min_height']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_box_padding'])) {update_option("UPCP_Detail_View_Box_Padding", $_POST['detail_view_box_padding']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_box_margin'])) {update_option("UPCP_Detail_View_Box_Margin", $_POST['detail_view_box_margin']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_box_border'])) {update_option("UPCP_Detail_View_Box_Border", $_POST['detail_view_box_border']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_border_color'])) {update_option("UPCP_Detail_View_Border_Color", $_POST['detail_view_border_color']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_title_font_size'])) {update_option("UPCP_Detail_View_Title_Font_Size", $_POST['detail_view_title_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_title_color'])) {update_option("UPCP_Detail_View_Title_Color", $_POST['detail_view_title_color']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_title_font'])) {update_option("UPCP_Detail_View_Title_Font", $_POST['detail_view_title_font']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_price_font_size'])) {update_option("UPCP_Detail_View_Price_Font_Size", $_POST['detail_view_price_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_price_color'])) {update_option("UPCP_Detail_View_Price_Color", $_POST['detail_view_price_color']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_price_font'])) {update_option("UPCP_Detail_View_Price_Font", $_POST['detail_view_price_font']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_background_color'])) {update_option("UPCP_Detail_View_Background_Color", $_POST['detail_view_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_separator_line'])) {update_option("UPCP_Detail_View_Separator_Line", $_POST['detail_view_separator_line']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_details_arrow'])) {update_option("UPCP_Detail_View_Details_Arrow", $_POST['detail_view_details_arrow']); }
	if ($Full_Version == "Yes" and isset($_POST['detail_view_custom_details_arrow'])) {update_option("UPCP_Detail_View_Custom_Details_Arrow", $_POST['detail_view_custom_details_arrow']);}

	/* Sidebar */
	if ($Full_Version == "Yes" and isset($_POST['sidebar_header_font'])) {update_option("UPCP_Sidebar_Header_Font", $_POST['sidebar_header_font']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_header_font_size'])) {update_option("UPCP_Sidebar_Header_Font_Size", $_POST['sidebar_header_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_header_font_weight'])) {update_option("UPCP_Sidebar_Header_Font_Weight", $_POST['sidebar_header_font_weight']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_header_color'])) {update_option("UPCP_Sidebar_Header_Color", $_POST['sidebar_header_color']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_subheader_font'])) {update_option("UPCP_Sidebar_Subheader_Font", $_POST['sidebar_subheader_font']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_subheader_font_size'])) {update_option("UPCP_Sidebar_Subheader_Font_Size", $_POST['sidebar_subheader_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_subheader_font_weight'])) {update_option("UPCP_Sidebar_Subheader_Font_Weight", $_POST['sidebar_subheader_font_weight']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_subheader_color'])) {update_option("UPCP_Sidebar_Subheader_Color", $_POST['sidebar_subheader_color']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_checkbox_font'])) {update_option("UPCP_Sidebar_Checkbox_Font", $_POST['sidebar_checkbox_font']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_checkbox_font_size'])) {update_option("UPCP_Sidebar_Checkbox_Font_Size", $_POST['sidebar_checkbox_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_checkbox_font_weight'])) {update_option("UPCP_Sidebar_Checkbox_Font_Weight", $_POST['sidebar_checkbox_font_weight']); }
	if ($Full_Version == "Yes" and isset($_POST['sidebar_checkbox_color'])) {update_option("UPCP_Sidebar_Checkbox_Color", $_POST['sidebar_checkbox_color']); }
	if ($Full_Version == "Yes" and isset($_POST['categories_control_type'])) {update_option("UPCP_Categories_Control_Type", $_POST['categories_control_type']); }
	if ($Full_Version == "Yes" and isset($_POST['subcategories_control_type'])) {update_option("UPCP_SubCategories_Control_Type", $_POST['subcategories_control_type']); }
	if ($Full_Version == "Yes" and isset($_POST['tags_control_type'])) {update_option("UPCP_Tags_Control_Type", $_POST['tags_control_type']); }

	/* Product Page Styling */
	if ($Full_Version == "Yes" and isset($_POST['breadcrumbs_font_color'])) {update_option("UPCP_Breadcrumbs_Font_Color", $_POST['breadcrumbs_font_color']); }
	if ($Full_Version == "Yes" and isset($_POST['breadcrumbs_font_hover_color'])) {update_option("UPCP_Breadcrumbs_Font_Hover_Color", $_POST['breadcrumbs_font_hover_color']); }
	if ($Full_Version == "Yes" and isset($_POST['breadcrumbs_font_size'])) {update_option("UPCP_Breadcrumbs_Font_Size", $_POST['breadcrumbs_font_size']); }
	if ($Full_Version == "Yes" and isset($_POST['breadcrumbs_font_family'])) {update_option("UPCP_Breadcrumbs_Font_Family", $_POST['breadcrumbs_font_family']); }

	/* New Pagination Stuff */
	if ($Full_Version == "Yes" and isset($_POST['pagination_border_enable'])) {update_option("UPCP_Pagination_Border_Enable", $_POST['pagination_border_enable']); }
	if ($Full_Version == "Yes" and isset($_POST['pagination_border_color'])) {update_option("UPCP_Pagination_Border_Color", $_POST['pagination_border_color']); }
	if ($Full_Version == "Yes" and isset($_POST['pagination_border_color_hover'])) {update_option("UPCP_Pagination_Border_Color_Hover", $_POST['pagination_border_color_hover']); }
	if ($Full_Version == "Yes" and isset($_POST['pagination_background_color'])) {update_option("UPCP_Pagination_Background_Color", $_POST['pagination_background_color']); }
	if ($Full_Version == "Yes" and isset($_POST['pagination_background_color_hover'])) {update_option("UPCP_Pagination_Background_Color_Hover", $_POST['pagination_background_color_hover']); }
	if ($Full_Version == "Yes" and isset($_POST['pagination_font_color'])) {update_option("UPCP_Pagination_Font_Color", $_POST['pagination_font_color']); }
	if ($Full_Version == "Yes" and isset($_POST['pagination_font_color_hover'])) {update_option("UPCP_Pagination_Font_Color_Hover", $_POST['pagination_font_color_hover']); }

	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Product_Sort']] = "Product Sort";
	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Product_Search']] = "Product Search";
	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Price_Filter']] = "Price Filter";
	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Categories']] = "Categories";
	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Sub-Categories']] = "Sub-Categories";
	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Tags']] = "Tags";
	$Sidebar_Items_Order[$_POST['Sidebar_Items_Order_Custom_Fields']] = "Custom Fields";
	ksort($Sidebar_Items_Order);
	if ($Full_Version == "Yes" and isset($_POST['Sidebar_Items_Order_Product_Sort'])) {update_option('UPCP_Sidebar_Items_Order', $Sidebar_Items_Order);}

	if ((!isset($_POST['Pretty_Links'])) OR $_POST['Pretty_Links'] == "Yes") {
		 update_option("UPCP_Update_RR_Rules", "Yes");
	}

	if ($Run_WC_Sync == "Yes") {UPCP_Initial_WC_Sync();}

	UPCP_Create_XML_Sitemap();

	$update = __("Options have been succesfully updated.", 'ultimate-product-catalogue');
	return $update;
}

function UPCP_Save_Additional_Tabs() {
	if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}
    
	$Counter = 0;
	while ($Counter < 30) {
		if (isset($_POST['Tab_' . $Counter . '_Name'])) {
			$Prefix = 'Tab_' . $Counter;

			$Tab_Item['Name'] = stripslashes_deep(urldecode($_POST[$Prefix . '_Name']));
			$Tab_Item['Content'] = stripslashes_deep(urldecode($_POST[$Prefix . '_Content']));

			$Tabs[] = $Tab_Item;
			unset($Tab_Item);
		}
		$Counter++;
	}

	if (isset($_POST['starting_tab'])) {update_option("UPCP_Starting_Tab", $_POST['starting_tab']);}

	if (isset($_POST['upcp_tabs_confirmation'])) {update_option("UPCP_Tabs_Array", $Tabs);}
}

function Restore_Default_PP_Layout() {
		$Product_Page = '[{"element_type":"Product Description<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"description","element_id":"","col":3,"row":9,"size_x":5,"size_y":4},{"element_type":"Back Link<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"back","element_id":"","col":1,"row":1,"size_x":2,"size_y":1},{"element_type":"Additional Images<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"additional_images","element_id":"","col":1,"row":2,"size_x":2,"size_y":9},{"element_type":"Main Image<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"main_image","element_id":"","col":3,"row":3,"size_x":4,"size_y":6},{"element_type":"Permalink<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"product_link","element_id":"","col":6,"row":2,"size_x":1,"size_y":1},{"element_type":"Product Name<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"product_name","element_id":"","col":3,"row":2,"size_x":3,"size_y":1},{"element_type":"Blank<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"blank","element_id":"","col":7,"row":2,"size_x":1,"size_y":7},{"element_type":"Blank<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"blank","element_id":"","col":3,"row":1,"size_x":5,"size_y":1}]';

		update_option("UPCP_Product_Page_Serialized", $Product_Page);
		update_option("UPCP_PP_Grid_Width", 90);
		update_option("UPCP_PP_Grid_Height", 35);
		update_option("UPCP_Top_Bottom_Padding", 10);
		update_option("UPCP_Left_Right_Padding", 10);
}

function Restore_Default_PP_Layout_Mobile() {
		$Product_Page = '[{"element_type":"Product Description<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"description","element_id":"","col":3,"row":9,"size_x":5,"size_y":4},{"element_type":"Back Link<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"back","element_id":"","col":1,"row":1,"size_x":2,"size_y":1},{"element_type":"Additional Images<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"additional_images","element_id":"","col":1,"row":2,"size_x":2,"size_y":9},{"element_type":"Main Image<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"main_image","element_id":"","col":3,"row":3,"size_x":4,"size_y":6},{"element_type":"Permalink<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"product_link","element_id":"","col":6,"row":2,"size_x":1,"size_y":1},{"element_type":"Product Name<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"product_name","element_id":"","col":3,"row":2,"size_x":3,"size_y":1},{"element_type":"Blank<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"blank","element_id":"","col":7,"row":2,"size_x":1,"size_y":7},{"element_type":"Blank<div class=\"gs-delete-handle\" onclick=\"remove_element(this);\"></div><span class=\"gs-resize-handle gs-resize-handle-both\"></span>","element_class":"blank","element_id":"","col":3,"row":1,"size_x":5,"size_y":1}]';

		update_option("UPCP_Product_Page_Serialized_Mobile", $Product_Page);
}
?>
