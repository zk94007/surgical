<?php
$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");
if ($WooCommerce_Sync == "Yes") {
	add_action("woocommerce_cart_emptied", "UPCP_AJAX_Clear_Cart");
}


function UPCP_Initial_WC_Sync() {
	UPCP_Import_WC_Categories_Tags_And_Attributes();
	UPCP_Add_Categories_Tags_And_Attributes_To_WC();
	UPCP_Import_WC_Products();
	UPCP_Add_Products_To_WC();
}

function UPCP_Import_WC_Categories_Tags_And_Attributes() {
	global $wpdb;
	global $categories_table_name;
	global $subcategories_table_name;
	global $tags_table_name;

	$WC_Categories = get_terms('product_cat', array('hide_empty' => false));
    if ($WC_Categories) {
        foreach ($WC_Categories as $Category) {
            if ($Category->parent == 0) {
            	UPCP_Import_WC_Category($Category);
            }
        }
    }

    if ($WC_Categories) {
        foreach ($WC_Categories as $Category) {
            if ($Category->parent != 0) {
            	UPCP_Import_WC_SubCategory($Category);
            }
        }
    }

    $WC_Tags = get_terms('product_tag', array('hide_empty' => false));
    if ($WC_Tags) {
        foreach ($WC_Tags as $Tag) {
            UPCP_Import_WC_Tag($Tag);
        }
    }

    $wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    $WC_Attributes = $wpdb->get_results("SELECT * FROM $wc_attribute_table_name");
   	
    foreach ($WC_Attributes as $Attribute) {
    	UPCP_Import_WC_Custom_Field($Attribute);
    }
}

function UPCP_Add_Categories_Tags_And_Attributes_To_WC() {
	global $wpdb;
	global $categories_table_name;
	global $subcategories_table_name;
	global $tags_table_name;
	global $fields_table_name;

	$UPCP_Categories = $wpdb->get_results("SELECT * FROM $categories_table_name");
    if ($UPCP_Categories) {
        foreach ($UPCP_Categories as $Category) {
           	UPCP_Add_Category_To_WC($Category);
        }
    }

    $UPCP_SubCategories = $wpdb->get_results("SELECT * FROM $subcategories_table_name");
    if ($UPCP_SubCategories) {
        foreach ($UPCP_SubCategories as $SubCategory) {
            	UPCP_Add_SubCategory_To_WC($SubCategory);
        }
    }

    $UPCP_Tags = $wpdb->get_results("SELECT * FROM $tags_table_name");
    if ($UPCP_Tags) {
        foreach ($UPCP_Tags as $Tag) {
            UPCP_Add_Tag_To_WC($Tag);
        }
    }

    $UPCP_Custom_Fields = $wpdb->get_results("SELECT * FROM $fields_table_name");
    
    foreach ($UPCP_Custom_Fields as $Custom_Field) {
    	UPCP_Add_Custom_Field_To_WC($Custom_Field);
    }
}

function UPCP_Import_WC_Products() {
	global $wpdb;
	global $items_table_name;

	$WC_Products = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='product' AND (post_status='publish' OR post_status='draft')");

	if (sizeOf($WC_Products) > 0) {
		foreach ($WC_Products as $Product) {
			UPCP_Create_Product_From_WC($Product);
		}
	}
}

function UPCP_Add_Products_To_WC() {
	global $wpdb;
	global $items_table_name;

	$Products = $wpdb->get_results("SELECT * FROM $items_table_name WHERE Item_WC_ID=0");
	if (sizeOf($Products) > 0) {
		foreach ($Products as $Product) {
			UPCP_Create_Linked_WC_Product($Product);
		}
	}
}

add_action('transition_post_status', 'UPCP_Add_Product_From_WC', 10, 3);
function UPCP_Add_Product_From_WC($new_status, $old_status, $post) {
	global $wpdb;
	global $items_table_name;

	$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");
	if ($WooCommerce_Sync != "Yes") {return;}

	if ($new_status == 'publish' and !empty($post->ID) and $post->post_type == "product" and get_option("UPCP_Product_Import") == "None") {
		update_option("UPCP_Product_Import", "WC");
		UPCP_Create_Product_From_WC($post);
	}
}

add_action( 'save_post', 'UPCP_Update_WC_Imported_Product' );
function UPCP_Update_WC_Imported_Product($post_id) {
	global $wpdb;

	$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");
	if ($WooCommerce_Sync != "Yes") {return;}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'product' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	if (get_option("UPCP_Product_Import") == "None" or get_option("UPCP_Product_Import") == "WC") {
		$WC_Product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID=%d", $post_id));
		update_option("UPCP_Product_Import", "WC");
		UPCP_Create_Product_From_WC($WC_Product, "Yes");
	}
}

add_action("edited_product_cat", "UPCP_Edit_WC_Imported_Category", 10, 1);
function UPCP_Edit_WC_Imported_Category($term_id) {
	$Category = get_term_by("id", $term_id, "product_cat");
	if ($Category->parent == 0) {UPCP_Import_WC_Category($Category, "Yes");}
	else {UPCP_Import_WC_SubCategory($Category, "Yes");}
}

add_action("edited_product_tag", "UPCP_Edit_WC_Imported_Tag", 10, 1);
function UPCP_Edit_WC_Imported_Tag($term_id) {
	$Tag = get_term_by("id", $term_id, "product_tag");
	UPCP_Import_WC_Tag($Tag, "Yes");
}

function UPCP_Import_WC_Category($Category, $Update = "No") {
	global $wpdb;
	global $categories_table_name;

	$Category_Name = $Category->name;
    $Category_Description = $Category->description;
    $Category_Image = get_term_meta($Category->term_id, "thumbnail_id", true);

    $Category_ID = $wpdb->get_var($wpdb->prepare("SELECT Category_ID FROM $categories_table_name WHERE Category_WC_ID=%s", $Category->term_id));
    $WC_Update = "Yes";
    if ($Category_ID == "") {Add_UPCP_Category($Category_Name, $Category_Description, $Category_Image, $WC_Update, $Category->term_id);}
    elseif ($Update == "Yes") {Edit_UPCP_Category($Category_ID, $Category_Name, $Category_Description, $Category_Image, $WC_Update, $Category->term_id);}
}

function UPCP_Import_WC_SubCategory($Category, $Update = "No") {
	global $wpdb;
	global $categories_table_name;
	global $subcategories_table_name;

	$WC_Parent_Category = get_term_by("id", $Category->parent, "product_cat");

    if ($WC_Parent_Category) {
    	$Category_ID = $wpdb->get_var($wpdb->prepare("SELECT Category_ID FROM $categories_table_name WHERE Category_WC_ID=%s", $WC_Parent_Category->term_id));

    	if ($Category_ID != "") {
    		$SubCategory_Name = $Category->name;
    		$SubCategory_Description = $Category->description;
    		$SubCategory_Image = get_term_meta($Category->term_id, "thumbnail_id", true);
		
	   		$SubCategory_ID = $wpdb->get_var($wpdb->prepare("SELECT SubCategory_ID FROM $subcategories_table_name WHERE SubCategory_WC_ID=%s", $Category->term_id));
    		$WC_Update = "Yes";
    		if ($SubCategory_ID == "") {Add_UPCP_SubCategory($SubCategory_Name, $Category_ID, $SubCategory_Description, $SubCategory_Image, $WC_Update, $Category->term_id);}
    		elseif ($Update == "Yes") {Edit_UPCP_SubCategory($SubCategory_ID, $SubCategory_Name, $Category_ID, $SubCategory_Description, $SubCategory_Image, $WC_Update, $Category->term_id);}
    	}
    }
}

function UPCP_Import_WC_Tag($Tag, $Update = "No") {
	global $wpdb;
	global $tags_table_name;

    $Tag_ID = $wpdb->get_var($wpdb->prepare("SELECT Tag_ID FROM $tags_table_name WHERE Tag_WC_ID=%s", $Tag->term_id));
    $WC_Update = "Yes";
    $Tag_Group = 0;
    if ($Tag_ID == "") {Add_UPCP_Tag($Tag->name, $Tag_Description = $Tag->description, $Tag_Group, $WC_Update, $Tag->term_id);}
    elseif ($Update == "Yes") {Edit_UPCP_Tag($Tag_ID, $Tag->name, $Tag_Description = $Tag->description, $Tag_Group, $WC_Update, $Tag->term_id);}
}

function UPCP_Import_WC_Custom_Field($Attribute, $Update = "No") {
	global $wpdb;
	global $fields_table_name;

	$Term_IDs = $wpdb->get_results($wpdb->prepare("SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy=%s", "pa_" . $Attribute->attribute_name));
	$Attribute_Terms = "";
	foreach ($Term_IDs as $Term_Object) {
		$Attribute_Name = $wpdb->get_var($wpdb->prepare("SELECT name FROM $wpdb->terms WHERE term_id=%d", $Term_Object->term_id));
		$Attribute_Terms .= $Attribute_Name . ",";
		$Current_Value = get_term_meta($Term_Object->term_id, 'upcp_term_value', true);
		$Replace_Values[$Current_Value] = $Term_Object->term_id;
		$Term_ID_For_Value[$Term_Object->term_id] = $Attribute_Name;
	}
	$Attribute_Terms = trim($Attribute_Terms, ",");
	
	$Field_ID = $wpdb->get_var($wpdb->prepare("SELECT Field_ID FROM $fields_table_name WHERE Field_WC_ID=%d", $Attribute->attribute_id));
	
	$WC_Update = "Yes";
	if ($Field_ID == "") {Add_UPCP_Custom_Field($Attribute->attribute_label, $Attribute->attribute_name, $Attribute->attribute_type, "", $Attribute_Terms, "none", "No", "No", "Checkbox", "Yes", $WC_Update, $Attribute->attribute_id, $Term_ID_For_Value);}
	elseif ($Update == "Yes") {Edit_UPCP_Custom_Field($Field_ID, $Attribute->attribute_label, $Attribute->attribute_name, $Attribute->attribute_type, "", $Attribute_Terms, "none", "No", "No", "Checkbox", "Yes", $WC_Update, $Attribute->attribute_id, $Term_ID_For_Value, $Replace_Values);}
}

function UPCP_Add_Category_To_WC($Category) {
	global $wpdb;
	global $categories_table_name;
	
	$WC_Category = get_term_by("id", $Category->Category_WC_ID, "product_cat");
    if (!$WC_Category or $WC_Category->parent != 0) {
    	$args = array('description' => $Category->Category_Description);
    	$Return_Array = wp_insert_term($Category->Category_Name, 'product_cat', $args);

    	if (is_array($Return_Array) and isset($Return_Array['term_id']) and is_numeric($Return_Array['term_id'])) {
    		update_term_meta($Return_Array['term_id'], "thumbnail_id", $Category->Category_Image);
    		update_term_meta($Return_Array['term_id'], "upcp_equivalent", "Category");
    		update_term_meta($Return_Array['term_id'], "upcp_ID", $Category->Category_ID);
    		$wpdb->query($wpdb->prepare("UPDATE $categories_table_name SET Category_WC_ID=%d WHERE Category_ID=%d", $Return_Array['term_id'], $Category->Category_ID));
    	}
    }
}

function UPCP_Edit_Category_To_WC($Category) {
	if (!is_object($Category)){ $Category = (object)array();}
	$WC_Category = get_term_by("id", $Category->Category_WC_ID, "product_cat");
    if ($WC_Category and $WC_Category->parent == 0) {
    	$args = array('name' => $Category->Category_Name, 'description' => $Category->Category_Description);
    	$Return_Array = wp_update_term($WC_Category->term_id, 'product_cat', $args);

    	if (is_array($Return_Array) and isset($Return_Array['term_id']) and is_numeric($Return_Array['term_id'])) {
    		update_term_meta($Return_Array['term_id'], "thumbnail_id", $Category->Category_Image);
    	}
    }
}

function UPCP_Add_SubCategory_To_WC($SubCategory) {
	global $wpdb;
	global $categories_table_name;
	global $subcategories_table_name;

	$WC_SubCategory = get_term_by("id", $SubCategory->SubCategory_WC_ID, "product_cat");

    if (!$WC_SubCategory or $WC_SubCategory->parent == 0) {
	   	$UPCP_Parent_WC_ID = $wpdb->get_var($wpdb->prepare("SELECT Category_WC_ID FROM $categories_table_name WHERE Category_ID=%d", $SubCategory->Category_ID));
	   	$WC_Parent_Category = get_term_by("id", $UPCP_Parent_WC_ID, "product_cat");
	
	    if ($WC_Parent_Category) {
	    	$args = array('description' => $SubCategory->SubCategory_Description, 'parent' => $WC_Parent_Category->term_id);
	    	$Return_Array = wp_insert_term($SubCategory->SubCategory_Name, 'product_cat', $args);
	
	    	if (is_array($Return_Array) and isset($Return_Array['term_id']) and is_numeric($Return_Array['term_id'])) {
	    		update_term_meta($Return_Array['term_id'], "thumbnail_id", $SubCategory->SubCategory_Image);
	    		update_term_meta($Return_Array['term_id'], "upcp_equivalent", "SubCategory");
    			update_term_meta($Return_Array['term_id'], "upcp_ID", $SubCategory->SubCategory_ID);
    			$wpdb->query($wpdb->prepare("UPDATE $subcategories_table_name SET SubCategory_WC_ID=%d WHERE SubCategory_ID=%d", $Return_Array['term_id'], $SubCategory->SubCategory_ID));
	    	}
	    }
    }
}

function UPCP_Edit_SubCategory_To_WC($SubCategory) {
	global $wpdb;
	global $categories_table_name;

	$WC_SubCategory = get_term_by("id", $SubCategory->SubCategory_WC_ID, "product_cat");

    if ($WC_SubCategory and $WC_SubCategory->parent != 0) {
	   	$UPCP_Parent_WC_ID = $wpdb->get_var($wpdb->prepare("SELECT Category_WC_ID FROM $categories_table_name WHERE Category_ID=%d", $SubCategory->Category_ID));
	   	$WC_Parent_Category = get_term_by("id", $UPCP_Parent_WC_ID, "product_cat");
		
	    if ($WC_Parent_Category) {
	    	$args = array('name' => $SubCategory->SubCategory_Name, 'description' => $SubCategory->SubCategory_Description, 'parent' => $WC_Parent_Category->term_id);
	    	$Return_Array = wp_update_term($WC_SubCategory->term_id, 'product_cat', $args);
		
	    	if (is_array($Return_Array) and isset($Return_Array['term_id']) and is_numeric($Return_Array['term_id'])) {
	    		update_term_meta($Return_Array['term_id'], "thumbnail_id", $SubCategory->SubCategory_Image);
	    	}
	    }
    }
}



function UPCP_Add_Tag_To_WC($Tag) {
	global $wpdb;
	global $tags_table_name;
	
	if (!is_object($Tag)) {return;}

	$WC_Tag = get_term_by("id", $Tag->Tag_WC_ID, "product_tag");

    if (!$WC_Tag) {
    	$args = array('description' => $Tag->Tag_Description);
    	$Return_Array = wp_insert_term($Tag->Tag_Name, 'product_tag', $args);

    	if (is_array($Return_Array) and isset($Return_Array['term_id']) and is_numeric($Return_Array['term_id'])) {
    		update_term_meta($Return_Array['term_id'], "upcp_equivalent", "Tag");
    		update_term_meta($Return_Array['term_id'], "upcp_ID", $Tag->Tag_ID);
    		$wpdb->query($wpdb->prepare("UPDATE $tags_table_name SET Tag_WC_ID=%d WHERE Tag_ID=%d", $Return_Array['term_id'], $Tag->Tag_ID));
    	}
    }
}

function UPCP_Edit_Tag_To_WC($Tag) {
	if (!is_object($Tag)) {return;}

	$WC_Tag = get_term_by("id", $Tag->Tag_WC_ID, "product_tag");

    if ($WC_Tag) {
    	$args = array('name' => $Tag->Tag_Name, 'description' => $Tag->Tag_Description);
    	$Return_Array = wp_update_term($WC_Tag->term_id, 'product_tag', $args);
    }
}

function UPCP_Add_Custom_Field_To_WC($Custom_Field) {
	global $wpdb;
	global $fields_table_name;

	$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
	$WC_Attribute = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wc_attribute_table_name WHERE attribute_id=%d", $Custom_Field->Field_WC_ID));

    if (empty($WC_Attribute)) {
    	if ($Custom_Field->Field_Type == "select") {$Field_Type = "select";}
    	else {$Field_Type = "text";}
    	if ($Custom_Field->Field_Slug != "") {$Field_Slug = $Custom_Field->Field_Slug;}
    	else {$Field_Slug = sanitize_title_with_dashes($Custom_Field->Field_Name);}
    	$wpdb->query($wpdb->prepare("INSERT INTO $wc_attribute_table_name (attribute_name, attribute_label, attribute_type, attribute_orderby, attribute_public) VALUES (%s, %s, %s, %s, %d)", $Field_Slug, $Custom_Field->Field_Name, $Field_Type, "menu_order", 0));

    	if ($wpdb->insert_id) {
    		$wpdb->query($wpdb->prepare("UPDATE $fields_table_name SET Field_WC_ID=%d WHERE Field_ID=%d", $wpdb->insert_id, $Custom_Field->Field_ID));

    		$Attribute_Values = explode(",", $Custom_Field->Field_Values);
    		foreach ($Attribute_Values as $Value) {
    			if ($Value != "") {
    				$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->terms (name, slug) VALUES (%s, %s)", $Value, sanitize_title_with_dashes($Value)));
    				if ($wpdb->insert_id) {
    					$Term_ID = $wpdb->insert_id;
    					$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->term_taxonomy (term_id, taxonomy) VALUES (%d, %s)", $Term_ID, "pa_" . $Field_Slug));
    					update_term_meta($Term_ID, "upcp_term_value", $Value);
    					update_term_meta($Term_ID, "upcp_term_CF_ID", $Custom_Field->Field_ID);
    				}
    			}
    		}
    	}

    	$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    	$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM $wc_attribute_table_name order by attribute_name ASC;" );
		set_transient( 'wc_attribute_taxonomies', $attribute_taxonomies );
    }
}

function UPCP_Edit_Custom_Field_To_WC($Custom_Field, $Current_Values_String) {
	global $wpdb;
	global $fields_table_name;

	$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
	$WC_Attribute = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wc_attribute_table_name WHERE attribute_id=%d", $Custom_Field->Field_WC_ID));

    if (!empty($WC_Attribute)) {
    	$wpdb->query($wpdb->prepare("UPDATE $wpdb->term_taxonomy SET taxonomy=%s WHERE taxonomy=%s", "pa_" . $Custom_Field->Field_Slug , $WC_Attribute->attribute_name));
    	$wpdb->query($wpdb->prepare("UPDATE $wc_attribute_table_name SET attribute_name=%s, attribute_label=%s WHERE attribute_id=%d", $Custom_Field->Field_Slug, $Custom_Field->Field_Name, $WC_Attribute->attribute_id));
    	
    	$Attribute_Values = explode(",", $Custom_Field->Field_Values);
    	$Current_Values = explode(",", $Current_Values_String);
    	foreach ($Attribute_Values as $Key => $Value) {
    		if ($Value != "") {
    			$term_id = $wpdb->get_var($wpdb->prepare("SELECT term_id FROM $wpdb->termmeta WHERE meta_key=%s AND meta_value=%s", 'upcp_term_value', $Current_Values[$Key]));
    			if ($term_id) {$wpdb->query($wpdb->prepare("UPDATE $wpdb->terms SET name=%s WHERE term_id=%d", $Value, $term_id));}
    			else {
    				$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->terms (name, slug) VALUES (%s, %s)", $Value, sanitize_title_with_dashes($Value)));
    				if ($wpdb->insert_id) {$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->term_taxonomy (term_id, taxonomy) VALUES (%d, %s)", $wpdb->insert_id, "pa_" . $WC_Attribute->attribute_name));}
    			}
    			update_term_meta($term_id, "upcp_term_value", $Value);
    		}
    	}
    }
}

function UPCP_Create_Product_From_WC($Product, $Update = "No") {
	global $wpdb;
	global $items_table_name;
	global $item_images_table_name;
	global $fields_table_name;
	global $fields_meta_table_name;
	global $WC_Item_ID;
	
	$Item_ID = $wpdb->get_var($wpdb->prepare("SELECT Item_ID FROM $items_table_name WHERE Item_WC_ID=%d", $Product->ID));
	if ($Item_ID != "" and $Update == "No") {return;}
	elseif ($Item_ID == "" and $Update == "Yes") {return;}
	
	$Item_Link = "";
	$Item_SEO_Description = "";

	$WC_ID = $Product->ID;
	$Item_Slug = $Product->post_name;
	$Item_Name = $Product->post_title;
	$Item_Description = $Product->post_content;
	$Item_Price = get_post_meta($Product->ID, "_regular_price", true);
	$Item_Sale_Price = get_post_meta($Product->ID, "_sale_price", true);
	$Item_Date_Created = min($Product->post_date, date("Y-m-d H:i:s"));

	$Item_Photo_URL = wp_get_attachment_url(get_post_thumbnail_id($Product->ID));

	if (get_post_meta($Product->ID, "_price", true) == $Item_Sale_Price) {$Item_Sale_Mode = "Yes";}
	else {$Item_Sale_Mode = "No";}

	if ($Product->post_status == "publish") {$Item_Display_Status = "Show";}
	else {$Item_Display_Status = "Hide";}

	$Category_Name = "";
	$Category_ID = 0;
	$SubCategory_Name = "";
	$SubCategory_ID = 0;

	$Categories = wp_get_post_terms($Product->ID, "product_cat");
	
	foreach ($Categories as $Category) {update_option("UPCP_WC_Debugging", "Category");
		if ($Category->parent == 0) {update_option("UPCP_WC_Debugging", "No Parent Category");
			 $Category_Name = $Category->name; update_option("UPCP_WC_Debugging", "Name: " . $Category->name);
			 $Category_ID = get_term_meta( $Category->term_id, "upcp_ID", true); update_option("UPCP_WC_Debugging", "ID: " . get_term_meta( $Category->term_id, "upcp_ID", true));
			 $Category_Term_ID = $Category->term_id;
			 break;
		}
	}

	if ($Category_Name != "") {
		foreach ($Categories as $Category) {
			if ($Category->parent == $Category_Term_ID) {
				 $SubCategory_ID = get_term_meta( $Category->term_id, "upcp_ID", true);
				 $SubCategory_Name = $Category->name;
				 break;
			}
		}
	}

	$WC_Tags = wp_get_post_terms($Product->ID, "product_tag");
	$Tags = array();
	foreach ($WC_Tags as $WC_Tag) {
		$Tags[] = get_term_meta($WC_Tag->term_id, "upcp_ID", true);
	}

	$Skip_Nonce = "Yes";
	$WC_Update = "Yes"; 
	if ($Update == "Yes") {Edit_UPCP_Product($Item_ID, $Item_Name, $Item_Slug, $Item_Photo_URL, $Item_Description, $Item_Price, $Item_Sale_Price, $Item_Sale_Mode, $Item_SEO_Description, $Item_Link, $Item_Display_Status, $Category_ID, "", "", $SubCategory_ID, $Tags, "", "", $Skip_Nonce, $WC_ID, $WC_Update);} 
	else {Add_UPCP_Product($Item_Name, $Item_Slug, $Item_Photo_URL, $Item_Description, $Item_Price, $Item_Sale_Price, $Item_Sale_Mode, $Item_SEO_Description, $Item_Link, $Item_Display_Status, $Category_ID, "", "", $SubCategory_ID, $Tags, "", "", $Skip_Nonce, $WC_ID, $WC_Update);}

	if ($Update == "No") {$Item_ID = $WC_Item_ID;}

	$WC_Image_IDs_String = get_post_meta($Product->ID, "_product_image_gallery", true);
	$WC_Image_IDs = explode(",", $WC_Image_IDs_String);
	$Current_Images = $wpdb->get_results($wpdb->prepare("SELECT * FROM $item_images_table_name WHERE Item_ID=%d", $Item_ID));

	foreach ($WC_Image_IDs as $Image_ID) {
		$Image_URL = wp_get_attachment_url($Image_ID);
		$Match = "No";
		foreach ($Current_Images as $Current_Image) {if ($Current_Image->Item_Image_URL == $Image_URL) {$Match = "Yes";}}
		if ($Match == "No" and $Image_URL != "") {Add_Product_Image($Item_ID, $Image_URL);}
	}

	$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
	$Attributes = $wpdb->get_results("SELECT * FROM $wc_attribute_table_name");
	foreach ($Attributes as $Attribute) {
		$Terms = wp_get_object_terms($Product->ID, "pa_" . $Attribute->attribute_name);
		if (is_array($Terms)) {
			foreach ($Terms as $Term) {
				$Value = get_term_meta($Term->term_id, "upcp_term_value", true); 
				$Field_ID = get_term_meta($Term->term_id, "upcp_term_CF_ID", true); 
				$Test_Current = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $fields_meta_table_name WHERE Field_ID=%d AND Item_ID=%d", $Field_ID, $Item_ID));
				if ($Test_Current) {$wpdb->query($wpdb->prepare("UPDATE $fields_meta_table_name SET Meta_Value=%s WHERE Item_ID=%d AND Field_ID=%d", $Test_Current . "," . $Value, $Item_ID, $Field_ID));}
				else {$wpdb->query($wpdb->prepare("INSERT INTO $fields_meta_table_name (Field_ID, Item_ID, Meta_Value) VALUES (%d, %d, %s)", $Field_ID, $Item_ID, $Value));}
			}
		}
	}
}

function UPCP_Create_Linked_WC_Product($Product) {
	global $wpdb;
	global $items_table_name;
	global $categories_table_name;
	global $subcategories_table_name;
	global $tags_table_name;
	global $tagged_items_table_name;
	global $item_images_table_name;
	global $fields_table_name;
	global $fields_meta_table_name;

	$WC_Product = array(
		'post_type' => 'product',
		'post_name' => $Product->Item_Slug,
		'post_title' => $Product->Item_Name,
		'post_content' => $Product->Item_Description,
		'post_date' => min($Product->Item_Date_Created, date("Y-m-d H:i:s"))
	);

	if ($Product->Item_Display_Status == "Show") {$WC_Product['post_status'] = "publish";}
	else {$WC_Product['post_status'] = "draft";}

	if ($Product->Item_WC_ID != 0) {$WC_Product['ID'] = $Product->Item_WC_ID;}

	$WC_Post_ID = wp_insert_post($WC_Product);

	if ($WC_Post_ID != 0) {
		update_post_meta($WC_Post_ID, "_regular_price", preg_replace("/[^0-9.]/", "", $Product->Item_Price));
		update_post_meta($WC_Post_ID, "_sale_price", preg_replace("/[^0-9.]/", "", $Product->Item_Sale_Price));
		update_post_meta($WC_Post_ID, "_visibility", "visible");
		update_post_meta($WC_Post_ID, "_stock_status", "instock");
		update_post_meta($WC_Post_ID, "_downloadable", "no");
		update_post_meta($WC_Post_ID, "_virtual", "no");

		$Attachment_ID = UPCP_get_attachment_id_from_src($Product->Item_Photo_URL);
		if ($Attachment_ID != "") {
			set_post_thumbnail($WC_Post_ID, $Attachment_ID);
			update_post_meta($WC_Post_ID, "_thumbnail_id", $Attachment_ID);
		}
	
		if ($Product->Item_Sale_Mode == "Yes") {update_post_meta($WC_Post_ID, "_price", preg_replace("/[^0-9.]/", "", $Product->Item_Sale_Price));}
		else {update_post_meta($WC_Post_ID, "_price", preg_replace("/[^0-9.]/", "", $Product->Item_Price));}
	
		if ($Product->Item_WC_ID == 0) {$wpdb->query($wpdb->prepare("UPDATE $items_table_name SET Item_WC_ID=%d WHERE Item_ID=%d", $WC_Post_ID, $Product->Item_ID));}

		$Category_Objects = wp_get_post_terms($WC_Post_ID, 'product_cat');
		$Categories = array();
		foreach ($Category_Objects as $Category_Object) {$Categories[] = $Category_Object->term_id;}
		$Tag_Objects = wp_get_post_terms($WC_Post_ID, 'product_tag');
		$Tags = array();
		foreach ($Tag_Objects as $Tag_Object) {$Tags[] = $Tag_Object->term_id;}

		if (!empty($Categories)) {wp_remove_object_terms($WC_Post_ID, $Categories, 'product_cat');}
		if (!empty($Tags)) {wp_remove_object_terms($WC_Post_ID, $Tags, 'product_tag');}

		$WC_Category_ID = $wpdb->get_var($wpdb->prepare("SELECT Category_WC_ID from $categories_table_name WHERE Category_ID=%d", $Product->Category_ID));
		$WC_SubCategory_ID = $wpdb->get_var($wpdb->prepare("SELECT SubCategory_WC_ID from $subcategories_table_name WHERE SubCategory_ID=%d", $Product->SubCategory_ID));
		$WC_Category = get_term_by("id", $WC_Category_ID, "product_cat");
		$WC_SubCategory = get_term_by("id", $WC_SubCategory_ID, "product_cat");

		if (is_object($WC_Category)) {$WC_Category_Term_ID = $WC_Category->term_id;}
		else {$WC_Category_Term_ID = 0;}
		if (is_object($WC_SubCategory)) {$WC_SubCategory_Term_ID = $WC_Category->term_id;}
		else {$WC_SubCategory_Term_ID = 0;}

		wp_set_post_terms($WC_Post_ID, array($WC_Category_Term_ID, $WC_SubCategory_Term_ID), "product_cat");
		$Insert_Tags = "";
		$Tags = $wpdb->get_results($wpdb->prepare("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=%d", $Product->Item_ID));

		$WC_Tags = array();

		if (is_array($Tags)) {
			foreach ($Tags as $Tag) {
				$WC_Tags[] = $wpdb->get_var($wpdb->prepare("SELECT Tag_WC_ID FROM $tags_table_name WHERE Tag_ID=%d", $Tag->Tag_ID));
			}
		}
		foreach ($WC_Tags as $Tag) {
			$Tag_Object = get_term_by("id", $Tag, "product_tag");
			$Insert_Tags[] = $Tag_Object->name;
		}

		wp_set_post_terms($WC_Post_ID, $Insert_Tags, "product_tag");

		$Current_Images = $wpdb->get_results($wpdb->prepare("SELECT * FROM $item_images_table_name WHERE Item_ID=%d", $Product->Item_ID));
		$Image_Post_IDs = array();
		foreach ($Current_Images as $Current_Image) {
			$Attachment_ID = UPCP_get_attachment_id_from_src($Current_Image->Item_Image_URL);
			if ($Attachment_ID) {$Image_Post_IDs[] = $Attachment_ID;}
		}
		$Image_Post_ID_String = implode(",",$Image_Post_IDs);
		update_post_meta($WC_Post_ID, "_product_image_gallery", $Image_Post_ID_String);

		$Fields = $wpdb->get_results("SELECT * FROM $fields_table_name");
		foreach ($Fields as $Field) {
			$Meta_Value = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $fields_meta_table_name WHERE Field_ID=%d AND Item_ID=%d", $Field->Field_ID, $Product->Item_ID));
			$Values = explode(",", $Meta_Value);
			foreach ($Values as $Value) {
				if ($Value != "") {
					$term_ids = $wpdb->get_results($wpdb->prepare("SELECT term_id FROM $wpdb->termmeta WHERE meta_key=%s AND meta_value=%s", 'upcp_term_value', $Value));
					foreach ($term_ids as $term_id) {
						if ($Field->Field_ID == get_term_meta($term_id->term_id, 'upcp_term_CF_ID', true)) {
							$taxonomy = $wpdb->get_var($wpdb->prepare("SELECT taxonomy FROM $wpdb->term_taxonomy WHERE term_id=%d", $term_id->term_id));
							$Term_ID = (int) $term_id->term_id;
							wp_set_object_terms($WC_Post_ID, $Term_ID, $taxonomy, true);
							$Current_Attributes = get_post_meta($WC_Post_ID, '_product_attributes', true);
							if (!is_array($Current_Attributes)) {$Current_Attributes = array();}
							$Current_Attributes[$taxonomy] = array(
								'name' => $taxonomy,
								'value' => $Value,
								'is_visible' => '1',
								'is_variation' => '0',
								'is_taxonomy' => '1'
								);
							update_post_meta($WC_Post_ID, '_product_attributes', $Current_Attributes);
						}
					}
				}
			}
		}
	}
}

function UPCP_Delete_WC_Product($WC_ID) {
	wp_delete_post($WC_ID, true);
}

function UPCP_Add_WC_Image($Item_Image) {
	global $wpdb;
	global $items_table_name;

	$Attachment_ID = UPCP_get_attachment_id_from_src($Item_Image->Item_Image_URL);
	if ($Attachment_ID) {
		$WC_Post_ID = $wpdb->get_var($wpdb->prepare("SELECT Item_WC_ID FROM $items_table_name WHERE Item_ID=%d", $Item_Image->Item_ID));
		$Image_Post_ID_String = get_post_meta($WC_Post_ID, "_product_image_gallery", true);
		if (strlen($Image_Post_ID_String) > 0) {$Image_Post_ID_String .= ",";}
		$Image_Post_ID_String .= $Attachment_ID;
		update_post_meta($WC_Post_ID, "_product_image_gallery", $Image_Post_ID_String);
	}
}

function UPCP_Remove_WC_Image($Item_Image) {
	global $wpdb;
	global $items_table_name;

	$Attachment_ID = UPCP_get_attachment_id_from_src($Item_Image->Item_Image_URL);
	if ($Attachment_ID) {
		$WC_Post_ID = $wpdb->get_var($wpdb->prepare("SELECT Item_WC_ID FROM $items_table_name WHERE Item_ID=%d", $Item_Image->Item_ID));
		
		$Image_Post_ID_String = get_post_meta($WC_Post_ID, "_product_image_gallery", true);
		$Image_Post_Array = explode(",", $Image_Post_ID_String);
		$New_Image_Post_Array = array();
		foreach ($Image_Post_Array as $Image_Post) {
			if ($Image_Post != $Attachment_ID) {$New_Image_Post_Array[] = $Image_Post;} 
		}
		$New_Image_Post_ID_String = implode(",", $New_Image_Post_Array);
		update_post_meta($WC_Post_ID, "_product_image_gallery", $New_Image_Post_ID_String);
	}
}

function UPCP_get_attachment_id_from_src ($image_src) {
	global $wpdb;
	
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	return $id;
}

add_action("shutdown", "UPCP_Reset_WC_Product_Option");
function UPCP_Reset_WC_Product_Option() {
	update_option("UPCP_Product_Import", "None");
}

add_action("woocommerce_before_single_product", "UPCP_Add_Back_To_Catalogue_Link");
function UPCP_Add_Back_To_Catalogue_Link() {
	$WooCommerce_Back_Link = get_option("UPCP_WooCommerce_Back_Link");
	$Back_To_Catalogue_Label = get_option("UPCP_Back_To_Catalogue_Label");
	if ($Back_To_Catalogue_Label == "") {$Back_To_Catalogue_Label = "Back to Catalogue";}

	if ($WooCommerce_Back_Link != "Yes" or !isset($_POST['current_url'])) {return;}

	echo "<style>.woocommerce-breadcrumb {display:none;}</style>";
	echo "<a class='upcp-catalogue-link' href='" . $_POST['current_url'] . "'>&#171; " . $Back_To_Catalogue_Label . "</a>";

	$HeaderBar = "<form id='upcp-hidden-filtering-form' method='post' target='" . $Target . "'>";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-categories' name='categories' value='" . $_POST['categories'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-subcategories' name='sub-categories' value='" . $_POST['sub-categories'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-tags' name='tags' value='" . $_POST['tags'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-prod-name' name='prod_name' value='" . $_POST['prod_name'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-current-page' name='current_page' value='" . $_POST['current_page'] . "' />";
	$HeaderBar .= "<input type='hidden' id='upcp-selected-current-url' name='current_url' value='" . get_permalink() . "' />";
	$HeaderBar .= "</form>";
	echo $HeaderBar;
}