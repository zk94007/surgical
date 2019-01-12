<?php
/* Prepare the data to add or edit a single product */
function Add_Edit_Product() {
	$Apply_Contents_Filter = get_option("UPCP_Apply_Contents_Filter");

	if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

	$Global_Item_ID = "";
	$Item_Special_Attr = "";
	$Related_Products = "";
	$Next_Previous = "";
	
	/* Process the $_POST data where neccessary before storage */
	$Item_ID = (isset($_POST['Item_ID']) ? $_POST['Item_ID'] : '');
	$Item_Name = (isset($_POST['Item_Name']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Name'])) : '');
	$Item_Slug = (isset($_POST['Item_Slug']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Slug'])) : '');
	$Item_Photo_URL = (isset($_POST['Item_Image']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Image'])) : '');
	$Item_Description = (isset($_POST['Item_Description']) ? stripslashes_deep($_POST['Item_Description']) : '');
	if ($Apply_Contents_Filter == "Yes") {$Item_Description = apply_filters('the_content', $Item_Description);}
	$Item_Price = (isset($_POST['Item_Price']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Price'])) : '');
	$Item_Sale_Price = (isset($_POST['Item_Sale_Price']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Sale_Price'])) : '');
	if (isset($_POST['Item_Sale_Mode']) and $_POST['Item_Sale_Mode']) {$Item_Sale_Mode = "Yes";}
	else {$Item_Sale_Mode = "No";}
	$Item_SEO_Description = (isset($_POST['Item_SEO_Description']) ? sanitize_text_field(stripslashes_deep($_POST['Item_SEO_Description'])) : '');
	$Item_Link = (isset($_POST['Item_Link']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Link'])) : '');
	$Item_Display_Status = (isset($_POST['Item_Display_Status']) ? sanitize_text_field(stripslashes_deep($_POST['Item_Display_Status'])) : '');
	$Category_ID = (isset($_POST['Category_ID']) ? sanitize_text_field(stripslashes_deep($_POST['Category_ID'])) : '');
	$Item_WC_ID = (isset($_POST['Item_WC_ID']) ? sanitize_text_field(stripslashes_deep($_POST['Item_WC_ID'])) : '');
	if (isset($_POST['Global_Item_ID'])) {$Global_Item_ID = $_POST['Global_Item_ID'];}
	if (isset($_POST['Item_Special_Attr'])) {$Item_Special_Attr = $_POST['Item_Special_Attr'];}
	if (isset($_POST['Tags'])) {$Tags = $_POST['Tags'];}
	else {$Tags = null;}
	if (isset($_POST['Item_Related_Products_1'])) {$Related_Products = $_POST['Item_Related_Products_1'] . "," . $_POST['Item_Related_Products_2'] . "," . $_POST['Item_Related_Products_3'] . "," . $_POST['Item_Related_Products_4'] . "," . $_POST['Item_Related_Products_5'];}
	if (isset($_POST['Item_Next_Product'])) {$Next_Previous = $_POST['Item_Next_Product'] . "," . $_POST['Item_Previous_Product'];}
	if ($Tags == "") {$Tags = array();}
	$SubCategory_ID = (isset($_POST['SubCategory_ID']) ? sanitize_text_field(stripslashes_deep($_POST['SubCategory_ID'])) : '');

	$Skip_Nonce = "No";

	if (!isset($error) or $error == __('No file was uploaded.', 'ultimate-product-catalogue')) {
			/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the product */
			if ($_POST['action'] == "Add_Product") {
				  $user_update = Add_UPCP_Product($Item_Name, $Item_Slug, $Item_Photo_URL, $Item_Description, $Item_Price, $Item_Sale_Price, $Item_Sale_Mode, $Item_SEO_Description, $Item_Link, $Item_Display_Status, $Category_ID, $Global_Item_ID, $Item_Special_Attr, $SubCategory_ID, $Tags, $Related_Products, $Next_Previous);
			}
			/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the product */
			else {
					$user_update = Edit_UPCP_Product($Item_ID, $Item_Name, $Item_Slug, $Item_Photo_URL, $Item_Description, $Item_Price, $Item_Sale_Price, $Item_Sale_Mode, $Item_SEO_Description, $Item_Link, $Item_Display_Status, $Category_ID, $Global_Item_ID, $Item_Special_Attr, $SubCategory_ID, $Tags, $Related_Products, $Next_Previous, $Skip_Nonce, $Item_WC_ID);
			}
			$user_update = array("Message_Type" => "Update", "Message" => $user_update);
			return $user_update;
	}
	/* Return any error that might have occurred */
	else {
			$output_error = array("Message_Type" => "Error", "Message" => $error);
			return $output_error;
	}
}
/* Prepare the data to add multiple products from a spreadsheet */
function Add_Products_From_Spreadsheet() {
		$Excel_File_Name = "";
		if (!is_user_logged_in()) {exit();}
		/* Test if there is an error with the uploaded spreadsheet and return that error if there is */

		if ( ! isset( $_POST['UPCP_Spreadsheet_Nonce'] ) ) {return;}

    	if ( ! wp_verify_nonce( $_POST['UPCP_Spreadsheet_Nonce'], 'UPCP_Spreadsheet_Nonce' ) ) {return;}

		if (!empty($_FILES['Products_Spreadsheet']['error']))
		{
				switch($_FILES['Products_Spreadsheet']['error'])
				{

				case '1':
						$error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'ultimate-product-catalogue');
						break;
				case '2':
						$error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'ultimate-product-catalogue');
						break;
				case '3':
						$error = __('The uploaded file was only partially uploaded', 'ultimate-product-catalogue');
						break;
				case '4':
						$error = __('No file was uploaded.', 'ultimate-product-catalogue');
						break;

				case '6':
						$error = __('Missing a temporary folder', 'ultimate-product-catalogue');
						break;
				case '7':
						$error = __('Failed to write file to disk', 'ultimate-product-catalogue');
						break;
				case '8':
						$error = __('File upload stopped by extension', 'ultimate-product-catalogue');
						break;
				case '999':
						default:
						$error = __('No error code avaiable', 'ultimate-product-catalogue');
				}
		}
		/* Make sure that the file exists */
		elseif (empty($_FILES['Products_Spreadsheet']['tmp_name']) || $_FILES['Products_Spreadsheet']['tmp_name'] == 'none') {
				$error = __('No file was uploaded here..', 'ultimate-product-catalogue');
		}
		/* Check that it is a .xls or .xlsx file */
		if(!preg_match("/\.(xls.?)$/", $_FILES['Products_Spreadsheet']['name']) and !preg_match("/\.(csv.?)$/", $_FILES['Products_Spreadsheet']['name'])) {
			$error = __('File must be .csv, .xls, .xlsx', 'ultimate-product-catalogue');
		}
		/* Move the file and store the URL to pass it onwards*/
		else {
						$msg .= $_FILES['Products_Spreadsheet']['name'];
						//for security reason, we force to remove all uploaded file
						$target_path = ABSPATH . 'wp-content/plugins/ultimate-product-catalogue/product-sheets/';

						$target_path = $target_path . basename( $_FILES['Products_Spreadsheet']['name']);

						if (!move_uploaded_file($_FILES['Products_Spreadsheet']['tmp_name'], $target_path)) {
						//if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
				 			  $error .= "There was an error uploading the file, please try again!";
						}
						else {
				 				$Excel_File_Name = basename( $_FILES['Products_Spreadsheet']['name']);
						}
		}

		/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the products */
		if (!isset($error)) {
				$user_update = Add_UPCP_Products_From_Spreadsheet($Excel_File_Name);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_Delete_Products() {
		$Products = $_POST['Products_Bulk'];

		if (is_array($Products)) {
				foreach ($Products as $Product) {
						if ($Product != "") {
								Delete_UPCP_Product($Product);
						}
				}
		}

		$update = __("Products have been successfully deleted.", 'ultimate-product-catalogue');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

function Delete_All_Products() {
		global $wpdb;
		global $items_table_name;
		$Products = $wpdb->get_results("SELECT Item_ID FROM $items_table_name");

		if (is_array($Products)) {
				foreach ($Products as $Product) {
						if ($Product->Item_ID != "") {
								Delete_UPCP_Product($Product->Item_ID);
						}
				}
		}

		$update = __("Products have been successfully deleted.", 'ultimate-product-catalogue');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

/* Prepares the data to add one or more videos URL or video ID */
function Prepare_Add_Product_Video() {
	if (!isset($_POST['Item_Video_Type'])){$_POST['Item_Video_Type'] = "";}
	$ItemVideoURLs = $_POST['Item_Video'];

	/* Process the $_POST data where neccessary before storage */
	$Item_ID = $_POST['Item_ID'];
	$Item_Video_Type = (isset($_POST['Item_Video_Type']) ? $_POST['Item_Video_Type'] : '');
	if($Item_Video_Type == ""){ $Item_Video_Type = "YouTube"; }

	/* Removing any empty objects from array */
	$ItemVideoURLs = (array_filter($ItemVideoURLs));

	/* Checking to see if any videos were added */
	if (empty($ItemVideoURLs)) {
		$user_update = "No videos were added.";
		$user_update = array("Message_Type" => "Update", "Message" => $user_update);
		return $user_update;
	}

	if(is_array($ItemVideoURLs)){
		foreach($ItemVideoURLs as $Item_Video_URL){
			if($Item_Video_URL != ""){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://gdata.youtube.com/feeds/api/videos/' . $Item_Video_URL);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				$response = curl_exec($ch);
				curl_close($ch);

				/* Checks to see if  YouTube video id is valid */
				if ($response == "Invalid id") {
					$video_update = "Video " . $Item_Video_URL . " does not seem to be a valid YouTube ID.<br />";
					$user_update = array("Message_Type" => "Update", "Message" => $video_update);
				}else{
					$user_update = Add_Product_Videos($Item_ID,$Item_Video_URL,$Item_Video_Type);
					$video_update = $Item_Video_URL . " video has been added.<br />";
					$user_update = array("Message_Type" => "Update", "Message" => $video_update);
				}
			}
		}
		return $user_update;
	}
}

/* Prepare the data to add a new image for a product */
function Prepare_Add_Product_Image() {
		/* Double check that everything worked correctly in moving the file */
		if ($_POST['Item_Image_Addt'] == "http://") {
			  $user_update = "No image was selected.";
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}

		$ImageURL = $_POST['Item_Image'];
		/* Process the $_POST data where neccessary before storage */
		$Item_ID = $_POST['Item_ID'];
		$Item_Image_Description = $_POST['Item_Image_Description'];

		/* Pass the data to the appropriate function in Update_Admin_Databases.php to add the link to the image */
		if (!isset($error) or $error == 'No file was uploaded.') {
      if(is_array($ImageURL)) {
        $ImageURL = explode(',', $ImageURL[0]);

        /* Process the $_POST data where neccessary before storage */
        $Item_ID = explode(',', $Item_ID);
        $Item_Image_Description = explode(',', $Item_Image_Description);



        $i = 0;
        foreach($ImageURL as $image) {
          $id = $Item_ID[$i];
          $desc = isset($Item_Image_Description[$i]) ? $Item_Image_Description[$i] : '';
          $user_update = Add_Product_Image($id, $image, $desc);
          $user_update = array("Message_Type" => "Update", "Message" => $image . ' - ' . $user_update);
        }
        return $user_update;
      } else {
        $user_update = Add_Product_Image($Item_ID, $ImageURL, $Item_Image_Description);
        $user_update = array("Message_Type" => "Update", "Message" => $user_update);
        return $user_update;
      }
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

/* Prepare the data to add a new image for the "Details" link */
function Prepare_Details_Image() {

		/* Double check that everything worked correctly in moving the file, return blank to erase the custom image or return the link */
		if (isset($_POST['Details_Image']) and ($_POST['Details_Image'] == "http://" or $_POST['Details_Image'] == "")) {
			  return;
		}
		else {
				return $_POST['Details_Image'];
		}

}

/* Prepare the data to add a new category */
function Add_Edit_Category() {
		if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    	if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

		/* Process the $_POST data where neccessary before storage */
		$Category_Name = (isset($_POST['Category_Name']) ? stripslashes_deep($_POST['Category_Name']) : '');
		$Category_Description = (isset($_POST['Category_Description']) ? stripslashes_deep($_POST['Category_Description']) : '');
		$Category_Image = (isset($_POST['Category_Image']) ? stripslashes_deep($_POST['Category_Image']) : '');
		$Category_ID = (isset($_POST['Category_ID']) ? stripslashes_deep($_POST['Category_ID']) : '');
		$WC_Update = "No";
		$WC_term_id = (isset($_POST['WC_term_id']) ? stripslashes_deep($_POST['WC_term_id']) : '');

		if (!isset($error)) {
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the category */
				if (isset($_POST['action']) and $_POST['action'] == "Add_Category") {
					  $user_update = Add_UPCP_Category($Category_Name, $Category_Description, $Category_Image);
				}
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the category */
				else {
						$user_update = Edit_UPCP_Category($Category_ID, $Category_Name, $Category_Description, $Category_Image, $WC_Update, $WC_term_id);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_Delete_Categories() {
		$Cats = $_POST['Cats_Bulk'];

		if (is_array($Cats)) {
				foreach ($Cats as $Cat) {
						if ($Cat != "") {
								Delete_UPCP_Category($Cat);
						}
				}
		}

		$update = __("Categories have been successfully deleted.", 'ultimate-product-catalogue');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

/* Prepare the data to add a new sub-category */
function Add_Edit_SubCategory() {
		if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    	if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

		/* Process the $_POST data where neccessary before storage */
		$SubCategory_Name = stripslashes_deep($_POST['SubCategory_Name']);
		$Category_ID = $_POST['Category_ID'];
		$SubCategory_Description = stripslashes_deep($_POST['SubCategory_Description']);
		$SubCategory_Image = stripslashes_deep($_POST['SubCategory_Image']);
		$SubCategory_ID = $_POST['SubCategory_ID'];
		$WC_Update = "No";
		$WC_term_id = $_POST['WC_term_id'];

		if (!isset($error)) {
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the sub-category */
				if ($_POST['action'] == "Add_SubCategory") {
					  $user_update = Add_UPCP_SubCategory($SubCategory_Name, $Category_ID, $SubCategory_Description, $SubCategory_Image);
				}
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the sub-category */
				else {
						$user_update = Edit_UPCP_SubCategory($SubCategory_ID, $SubCategory_Name, $Category_ID, $SubCategory_Description, $SubCategory_Image, $WC_Update, $WC_term_id);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_Delete_SubCategories() {
		$Subs = $_POST['Subs_Bulk'];

		if (is_array($Subs)) {
				foreach ($Subs as $Sub) {
						if ($Sub != "") {
								Delete_UPCP_SubCategory($Sub);
						}
				}
		}

		$update = __("Sub-Categories have been successfully deleted.", 'ultimate-product-catalogue');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

/* Prepare the data to add a new tag */
function Add_Edit_Tag() {
	if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

	/* Process the $_POST data where neccessary before storage */
	$Tag_Name = (isset($_POST['Tag_Name']) ? stripslashes_deep($_POST['Tag_Name']) : '');
	$Tag_Description = (isset($_POST['Tag_Description']) ? stripslashes_deep($_POST['Tag_Description']) : '');
	$Tag_ID = (isset($_POST['Tag_ID']) ? $_POST['Tag_ID'] : '');
	$Tag_Group_ID = (isset($_POST['Tag_Group_ID']) ? $_POST['Tag_Group_ID'] : '');
	$WC_Update = "No";
	$WC_term_id = (isset($_POST['WC_term_id']) ? $_POST['WC_term_id'] : '');

	if (!isset($error)) {
		/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the tag */
		if (isset($_POST['action']) and $_POST['action'] == "Add_Tag") {
			$user_update = Add_UPCP_Tag($Tag_Name, $Tag_Description, $Tag_Group_ID);
		}
		/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the tag */
		else {
			$user_update = Edit_UPCP_Tag($Tag_ID, $Tag_Name, $Tag_Description, $Tag_Group_ID, $WC_Update, $WC_term_id);
		}
		$user_update = array("Message_Type" => "Update", "Message" => $user_update);
		return $user_update;
	}
	else {
		$output_error = array("Message_Type" => "Error", "Message" => $error);
		return $output_error;
	}
}

function Mass_Delete_UPCP_Tags() {
	$Tag_ID = "";
	$Tags = $_POST['Tags_Bulk'];

	if (is_array($Tags)) {
		foreach ($Tags as $Tag) {
			if ($Tag != "") {
				Delete_UPCP_Tag($Tag);
				Delete_UPCP_Tag_Group($Tag_ID);
			}
		}
	}

	$update = __("Tag(s) have been successfully deleted.", 'ultimate-product-catalogue');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	return $user_update;
}

function Add_Edit_Tag_Group(){
	if ( ! isset( $_POST['UPCP_Tag_Group_Nonce'] ) ) {return;}

    if ( ! wp_verify_nonce( $_POST['UPCP_Tag_Group_Nonce'], 'UPCP_Tag_Group_Nonce' ) ) {return;}

	/* Process the $_POST data where neccessary before storage */
	$Tag_Group_Name = stripslashes_deep($_POST['Tag_Group_Name']);
	$Tag_Group_Description = stripslashes_deep($_POST['Tag_Group_Description']);
	$Tag_Group_ID = $_POST['Tag_Group_ID'];
	$Display_Tag_Group = $_POST['Display_Tag_Group'];

	if (!isset($error)) {
		/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the tag */
		if ($_POST['action'] == "Add_Tag_Group") {
			  $user_update = Add_UPCP_Tag_Group($Tag_Group_Name, $Tag_Group_Description, $Tag_Group_ID, $Display_Tag_Group);
		}
		/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the tag */
		else {
				$user_update = Edit_UPCP_Tag_Group($Tag_Group_Name,$Tag_Group_Description,$Tag_Group_ID, $Display_Tag_Group);
		}
		$user_update = array("Message_Type" => "Update", "Message" => $user_update);
		return $user_update;
	}
	else {
		$output_error = array("Message_Type" => "Error", "Message" => $error);
		return $output_error;
	}
}

function Add_Edit_Custom_Field() {
		if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    	if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

		if (!isset($_POST['Field_ID'])) { $_POST['Field_ID'] = ""; }
		/* Process the $_POST data where neccessary before storage */
		$Field_Name = stripslashes_deep($_POST['Field_Name']);
		$Field_Slug = stripslashes_deep($_POST['Field_Slug']);
		$Field_Type = stripslashes_deep($_POST['Field_Type']);
		$Field_Description = stripslashes_deep($_POST['Field_Description']);
		$Field_Values = stripslashes_deep($_POST['Field_Values']);
		$Field_Displays = stripslashes_deep($_POST['Field_Displays']);
		$Field_Searchable = stripslashes_deep($_POST['Field_Searchable']);
		$Field_Display_Tabbed = stripslashes_deep($_POST['Field_Display_Tabbed']);
		$Field_Control_Type = stripslashes_deep($_POST['Field_Control_Type']);
		$Field_Display_Comparison = stripslashes_deep($_POST['Field_Display_Comparison']);

		$Field_ID = (isset($_POST['Field_ID']) ? $_POST['Field_ID'] : '');

		if (!isset($error)) {
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the custom field */
				if ($_POST['action'] == "Add_Custom_Field") {
					  $user_update = Add_UPCP_Custom_Field($Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Displays, $Field_Searchable, $Field_Display_Tabbed, $Field_Control_Type, $Field_Display_Comparison);
				}
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the custom field */
				else {
						$user_update = Edit_UPCP_Custom_Field($Field_ID, $Field_Name, $Field_Slug, $Field_Type, $Field_Description, $Field_Values, $Field_Displays, $Field_Searchable, $Field_Display_Tabbed, $Field_Control_Type, $Field_Display_Comparison);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_Delete_UPCP_Custom_Fields() {
		$Fields = $_POST['Fields_Bulk'];

		if (is_array($Fields)) {
				foreach ($Fields as $Field) {
						if ($Field != "") {
								Delete_UPCP_Custom_Field($Field);
						}
				}
		}

		$update = __("Field(s) have been successfully deleted.", 'ultimate-product-catalogue');
		$user_update = array("Message_Type" => "Update", "Message" => $update);
		return $user_update;
}

/* Prepare the data to add a new catalogue */
function Add_Edit_Catalogue() {
		if ( ! isset( $_POST['UPCP_Element_Nonce'] ) ) {return;}

    	if ( ! wp_verify_nonce( $_POST['UPCP_Element_Nonce'], 'UPCP_Element_Nonce' ) ) {return;}

		/* Process the $_POST data where neccessary before storage */
		$Catalogue_Name = (isset($_POST['Catalogue_Name']) ? stripslashes_deep($_POST['Catalogue_Name']) : '');
		$Catalogue_Description = (isset($_POST['Catalogue_Description']) ? stripslashes_deep($_POST['Catalogue_Description']) : '');
		$Catalogue_Layout_Format = (isset($_POST['Catalogue_Layout_Format']) ? stripslashes_deep($_POST['Catalogue_Layout_Format']) : '');;
		$Catalogue_Custom_CSS = (isset($_POST['Catalogue_Custom_CSS']) ? stripslashes_deep($_POST['Catalogue_Custom_CSS']) : '');
		$Catalogue_ID = (isset($_POST['Catalogue_ID']) ? stripslashes_deep($_POST['Catalogue_ID']) : '');

		if (!isset($error)) {
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to create the catalogue */
				//if(!isset($_POST['action'])){$_POST['action'] = "";}
				if (isset($_POST['action']) and $_POST['action'] == "Add_Catalogue") {
					  $user_update = Add_UPCP_Catalogue($Catalogue_Name, $Catalogue_Description);
				}
				/* Pass the data to the appropriate function in Update_Admin_Databases.php to edit the catalogue */
				else {
						$user_update = Edit_UPCP_Catalogue($Catalogue_ID, $Catalogue_Name, $Catalogue_Description, $Catalogue_Layout_Format, $Catalogue_Custom_CSS);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}

function Mass_Delete_Catalogues() {
	$Catalogues = $_POST['Catalogues_Bulk'];

	if (is_array($Catalogues)) {
		foreach ($Catalogues as $Catalogue) {
			if ($Catalogue != "") {
				Delete_UPCP_Catalogue($Catalogue);
			}
		}
	}

	$update = __("Catalogues have been successfully deleted.", 'ultimate-product-catalogue');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	return $user_update;
}

function Mass_Delete_Catalogue_Items() {
	$Catalogue_Items = $_POST['Catalogue_Item_ID'];

	if (is_array($Catalogue_Items)) {
		foreach ($Catalogue_Items as $Catalogue_Item) {
			if ($Catalogue_Item != "") {
				Delete_Catalogue_Item($Catalogue_Item);
			}
		}
	}

	$update = __("Catalogue items have been successfully deleted.", 'ultimate-product-catalogue');
	$user_update = array("Message_Type" => "Update", "Message" => $update);
	return $user_update;
}

function UPCP_Handle_File_Upload($Field_Name) {
		if (!is_user_logged_in()) {exit();}

		/* Test if there is an error with the uploaded file and return that error if there is */
		if (!empty($_FILES[$Field_Name]['error']))
		{
				switch($_FILES[$Field_Name]['error'])
				{

				case '1':
						$error = __('The uploaded file exceeds the upload_max_filesize directive in php.ini', 'ultimate-product-catalogue');
						break;
				case '2':
						$error = __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', 'ultimate-product-catalogue');
						break;
				case '3':
						$error = __('The uploaded file was only partially uploaded', 'ultimate-product-catalogue');
						break;
				case '4':
						$error = __('No file was uploaded.', 'ultimate-product-catalogue');
						break;

				case '6':
						$error = __('Missing a temporary folder', 'ultimate-product-catalogue');
						break;
				case '7':
						$error = __('Failed to write file to disk', 'ultimate-product-catalogue');
						break;
				case '8':
						$error = __('File upload stopped by extension', 'ultimate-product-catalogue');
						break;
				case '999':
						default:
						$error = __('No error code avaiable', 'ultimate-product-catalogue');
				}
		}
		/* Make sure that the file exists */
		elseif (empty($_FILES[$Field_Name]['tmp_name']) || $_FILES[$Field_Name]['tmp_name'] == 'none') {
				$error = __('No file was uploaded here..', 'ultimate-product-catalogue');
		}
		/* Move the file and store the URL to pass it onwards*/
		else {
						$msg .= $_FILES[$Field_Name]['name'];
						//for security reason, we force to remove all uploaded file
						$target_path = ABSPATH . 'wp-content/uploads/upcp-product-file-uploads/';

						//create the uploads directory if it doesn't exist
						if (!file_exists($target_path)) {
							  mkdir($target_path, 0777, true);
						}

						$target_path = $target_path . basename( $_FILES[$Field_Name]['name']);

						if (!move_uploaded_file($_FILES[$Field_Name]['tmp_name'], $target_path)) {
						//if (!$upload = wp_upload_bits($_FILES["Item_Image"]["name"], null, file_get_contents($_FILES["Item_Image"]["tmp_name"]))) {
				 			  $error .= "There was an error uploading the file, please try again!";
						}
						else {
				 				$User_Upload_File_Name = basename( $_FILES[$Field_Name]['name']);
						}
		}

		/* Return the file name, or the error that was generated. */
		if (isset($error) and $error == __('No file was uploaded.', 'ultimate-product-catalogue')) {
			  $Return['Success'] = "N/A";
				$Return['Data'] = __('No file was uploaded.', 'ultimate-product-catalogue');
		}
		elseif (!isset($error)) {
				$Return['Success'] = "Yes";
				$Return['Data'] = $User_Upload_File_Name;
		}
		else {
				$Return['Success'] = "No";
				$Return['Data'] = $error;
		}
		return $Return;
}

function UPCP_Decode_CF_Commas($Value) {
	return str_replace("*,", ",", $Value);
}

function UPCP_CF_Pre_Explode($Value) {
	return str_replace("*,", "\%\%", $Value);
}

function UPCP_CF_Post_Explode($Value) {
	return str_replace("\%\%", "*,", $Value);
}
?>