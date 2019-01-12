<?php
if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) {require_once UPCP_CD_PLUGIN_PATH . 'PHPSpreadsheet/vendor/autoload.php';}
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
function UPCP_Export_To_Excel() {
	global $wpdb;
	global $categories_table_name, $subcategories_table_name, $items_table_name, $tagged_items_table_name, $tags_table_name, $fields_table_name, $fields_meta_table_name, $item_images_table_name;

	$FileType = $_GET['FileType'];
			
	// Instantiate a new PHPExcel object 
	$Spreadsheet = new Spreadsheet();  
	// Set the active Excel worksheet to sheet 0 
	$Spreadsheet->setActiveSheetIndex(0);  

	// Print out the regular order field labels
	$Spreadsheet->getActiveSheet()->setCellValue("A1", "Name");
	$Spreadsheet->getActiveSheet()->setCellValue("B1", "Slug");
	$Spreadsheet->getActiveSheet()->setCellValue("C1", "Description");
	$Spreadsheet->getActiveSheet()->setCellValue("D1", "Price");
	$Spreadsheet->getActiveSheet()->setCellValue("E1", "Sale Price");
	$Spreadsheet->getActiveSheet()->setCellValue("F1", "Image");
	$Spreadsheet->getActiveSheet()->setCellValue("G1", "Link");
	$Spreadsheet->getActiveSheet()->setCellValue("H1", "Category");
	$Spreadsheet->getActiveSheet()->setCellValue("I1", "Sub-Category");
	$Spreadsheet->getActiveSheet()->setCellValue("J1", "Tags");

	//start of printing column names as names of custom fields  
	$column = 'K';
	$Sql = "SELECT * FROM $fields_table_name WHERE Field_Type !='file'";
	$Custom_Fields = $wpdb->get_results($Sql);
	foreach ($Custom_Fields as $Custom_Field) {
    	$Spreadsheet->getActiveSheet()->setCellValue($column."1", $Custom_Field->Field_Name);
   		$column++;
	}

	for ($i=0; $i<5; $i++) {
		$Spreadsheet->getActiveSheet()->setCellValue($column."1", "Related Product");
   		$column++;
	}

	$Number_Names = array("One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten");
	foreach ($Number_Names as $Number) {
		$Spreadsheet->getActiveSheet()->setCellValue($column."1", "Additional Image " . $Number);
   		$column++;
	} 

	//start while loop to get data  
	$rowCount = 2;  
	$Products = $wpdb->get_results("SELECT * FROM $items_table_name");
	foreach ($Products as $Product)  
	{  
    	$Spreadsheet->getActiveSheet()->setCellValue("A" . $rowCount, $Product->Item_Name);
		$Spreadsheet->getActiveSheet()->setCellValue("B" . $rowCount, $Product->Item_Slug);
		$Spreadsheet->getActiveSheet()->setCellValue("C" . $rowCount, $Product->Item_Description);
		$Spreadsheet->getActiveSheet()->setCellValue("D" . $rowCount, $Product->Item_Price);
		$Spreadsheet->getActiveSheet()->setCellValue("E" . $rowCount, $Product->Item_Sale_Price);
		$Spreadsheet->getActiveSheet()->setCellValue("F" . $rowCount, $Product->Item_Photo_URL);
		$Spreadsheet->getActiveSheet()->setCellValue("G" . $rowCount, $Product->Item_Link);
		$Spreadsheet->getActiveSheet()->setCellValue("H" . $rowCount, $Product->Category_Name);
		$Spreadsheet->getActiveSheet()->setCellValue("I" . $rowCount, $Product->SubCategory_Name);
		
		$Tagged_Items = $wpdb->get_results($wpdb->prepare("SELECT Tag_ID FROM $tagged_items_table_name WHERE Item_ID=%d", $Product->Item_ID));
		foreach ($Tagged_Items as $Tag_Item) {
			$TagName = $wpdb->get_var("SELECT Tag_Name FROM $tags_table_name WHERE Tag_ID='" . $Tag_Item->Tag_ID . "'");
			$TagString .= $TagName . ",";
		}
		if (strlen($TagString) > 0) {$TagString = substr($TagString, 0, strlen($TagString)-1);}
		$Spreadsheet->getActiveSheet()->setCellValue("J" . $rowCount, $TagString);
				
		$column = 'K';
    	foreach ($Custom_Fields as $Custom_Field) {  
        	$MetaValue = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $fields_meta_table_name WHERE Item_ID=%d AND Field_ID=%d", $Product->Item_ID, $Custom_Field->Field_ID));

        	$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, $MetaValue);
        	$column++;
    	}

    	$Related_Products = explode(",", $Product->Item_Related_Products);
    	for ($i=0; $i<5; $i++) {
    		if (isset($Related_Products[$i])) {$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, $Related_Products[$i]);}
        	$column++;
    	}

    	$Image_Counter = 0;
    	$Addtl_Images = $wpdb->get_results($wpdb->prepare("SELECT * FROM $item_images_table_name WHERE Item_ID=%d", $Product->Item_ID));
    	foreach ($Addtl_Images as $Addtl_Image) {
    		if ($Image_Counter >= 10) {break;}

    		$Spreadsheet->getActiveSheet()->setCellValue($column.$rowCount, $Addtl_Image->Item_Image_URL);

    		$Image_Counter++;
    		$column++;
    	}
    	$rowCount++;
    	unset($TagString);
	}

	// Redirect output to a client’s web browser (Excel5) 
	if ($FileType == "CSV") {
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="Product_Export.csv"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = new Csv($Spreadsheet);
		$objWriter->save('php://output');
		die();
	}
	else {
		header('Content-Type: application/vnd.ms-excel'); 
		header('Content-Disposition: attachment;filename="Product_Export.xls"'); 
		header('Cache-Control: max-age=0'); 
		$objWriter = new Xls($Spreadsheet);
		$objWriter->save('php://output');
		die();
	}
}
?>