<?php 
function UPCP_Upgrade_To_Full() {
		global $upcp_message, $Full_Version;
		
		$Key = trim($_POST['Key']);

		if ($Key == "EWD Trial" and !get_option("UPCP_Trial_Happening")) {
			$upcp_message = array("Message_Type" => "Update", "Message" => __("Trial successfully started!", 'ultimate-product-catalogue'));
	
			update_option("UPCP_Trial_Expiry_Time", time() + (7*24*60*60));
			update_option("UPCP_Trial_Happening", "Yes");
			update_option("UPCP_Full_Version", "Yes");
			update_option("UPCP_Catalogue_Style", "contemporary");
			update_option("UPCP_Custom_Product_Page", "Tabbed");
			$Full_Version = get_option("UPCP_Full_Version");

			$Admin_Email = get_option('admin_email');

			$opts = array('http'=>array('method'=>"GET"));
			$context = stream_context_create($opts);
			$Response = unserialize(file_get_contents("http://www.etoilewebdesign.com/UPCP-Key-Check/Register_Trial.php?Plugin=UPCP&Admin_Email=" . $Admin_Email . "&Site=" . get_bloginfo('wpurl'), false, $context));

			$upcp_message = array("Message_Type" => "Update", "Message" => __("Trial successfully started.", 'ultimate-product-catalogue'));
		}
		elseif ($Key != "EWD Trial") {
			$opts = array('http'=>array('method'=>"GET"));
			$context = stream_context_create($opts);
			$Response = unserialize(file_get_contents("http://www.etoilewebdesign.com/UPCP-Key-Check/KeyCheck.php?Key=" . $Key . "&Site=" . get_bloginfo('wpurl'), false, $context));
			//$Response = file_get_contents("http://www.etoilewebdesign.com/UPCP-Key-Check/KeyCheck.php?Key=" . $Key);
			
			if ($Response['Message_Type'] == "Error") {
				  $upcp_message = array("Message_Type" => "Error", "Message" => $Response['Message']);
			}
			else {
					$upcp_message = array("Message_Type" => "Update", "Message" => $Response['Message']);
					update_option("UPCP_Trial_Happening", "No");
					delete_option("UPCP_Trial_Expiry_Time");
					update_option("UPCP_Full_Version", "Yes");
					update_option("UPCP_Product_Page_Serialized", $Response['ProductPage']);
					$Full_Version = get_option("UPCP_Full_Version");
			}
		}
}

 ?>
