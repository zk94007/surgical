<?php
function Add_Edit_Products() {
global $msg, $error;
		if (!empty($_FILES['Item_Image']['error']))
		{
				switch($_FILES['Item_Image']['error'])
				{

				case '1':
						$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
						break;
				case '2':
						$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
						break;
				case '3':
						$error = 'The uploaded file was only partially uploaded';
						break;
				case '4':
						$error = 'No file was uploaded.';
						break;

				case '6':
						$error = 'Missing a temporary folder';
						break;
				case '7':
						$error = 'Failed to write file to disk';
						break;
				case '8':
						$error = 'File upload stopped by extension';
						break;
				case '999':
						default:
						$error = 'No error code avaiable';
				}
		} 	
		elseif (empty($_FILES['Item_Image']['tmp_name']) || $_FILES['Item_Image']['tmp_name'] == 'none') {
				$error = 'No file was uploaded here..';
		} 	
		else {
				if (($_FILES["Item_Image"]["type"] == "image/gif")
				|| ($_FILES["Item_Image"]["type"] == "image/jpeg")
				|| ($_FILES["Item_Image"]["type"] == "image/pjpeg")
				|| ($_FILES["Item_Image"]["type"] == "image/png")) {
				 
				 	  $msg .= $_FILES['Item_Image']['name'];
						//for security reason, we force to remove all uploaded file
						$target_path = ABSPATH . 'wp-content/plugins/ultimate-product-catalogue/images/';

						$target_path = $target_path . basename( $_FILES['Item_Image']['name']); 

						if (!move_uploaded_file($_FILES['Item_Image']['tmp_name'], $target_path)) {
				 			  $error .= "There was an error uploading the file, please try again!";
						}
						else {
				 				$ImageURL = get_bloginfo('url') . '/wp-content/plugins/ultimate-product-catalogue/images/' . basename( $_FILES['Item_Image']['name']);
						}
				}			
		}
		
		$Item_ID = $_POST['Item_ID'];
		$Item_Name = $_POST['Item_Name'];
		$Item_Photo_URL = $ImageURL;
		$Item_Description = $_POST['Item_Description'];
		$Item_Price = $_POST['Item_Price'];
		$Category_ID = $_POST['Item_Category_ID'];
		$Global_Item_ID = $_POST['Global_Item_ID'];
		$Item_Special_Attr = $_POST['Item_Special_Attr'];
		$SubCategory_ID = $_POST['Item_SubCategory_ID'];

		if (!isset($error)) {
				if ($_POST['action'] == "Add_Product") {
					  $user_update = AddUPCPProduct($Item_Name, $Item_Photo_URL, $Item_Description, $Item_Price, $Category_ID, $Global_Item_ID, $Item_Special_Attr, $SubCategory_ID);
				}
				else {
						$user_update = EditUPCPProduct($Item_ID, $Item_Name, $Item_Photo_URL, $Item_Description, $Item_Price, $Category_ID, $Global_Item_ID, $Item_Special_Attr, $SubCategory_ID);
				}
				$user_update = array("Message_Type" => "Update", "Message" => $user_update);
				return $user_update;
		}
		else {
				$output_error = array("Message_Type" => "Error", "Message" => $error);
				return $output_error;
		}
}
?>
