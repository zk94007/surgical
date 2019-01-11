<?php
/* Adds a small amount of sample data to the UPCP database for demonstration purposes */
function Initial_UPCP_Data() {
		global $wpdb;
		global $items_table_name, $categories_table_name, $catalogues_table_name;
		
		$myrows = $wpdb->get_results("SELECT * FROM $items_table_name LIMIT 0,3");
		$num_rows = $wpdb->num_rows; 
		
		if ($num_rows == 0) {
			  $wpdb->insert($items_table_name,
				array(
						'Item_Name' => __('Sample Item', 'ultimate-product-catalogue'),
						'Item_Description' => __('This is where your description of this product would go.', 'ultimate-product-catalogue'),
						'Item_Price' => '9.99',
						'Item_Photo_URL' => UPCP_CD_PLUGIN_URL . "images/sample_image.jpg",
						'Category_ID' => '1',
						'Category_Name' => __('Sample Category', 'ultimate-product-catalogue'),
						'Item_Date_Created' => date('d-m-Y h:i:s')
				));
		
				$wpdb->insert($categories_table_name,
				array(
						'Category_Name' => __('Sample Category', 'ultimate-product-catalogue'),
						'Category_Description' => __('This is where your description of this category would go.', 'ultimate-product-catalogue'),
						'Category_Item_Count' => '1',
						'Category_Date_Created' => date('d-m-Y h:i:s')
				));
		
				$wpdb->insert($catalogues_table_name,
				array(
						'Catalogue_Name' => __('Sample Catalogue', 'ultimate-product-catalogue'),
						'Catalogue_Description' => __('This is where your description of this catalogue would go.', 'ultimate-product-catalogue'),
						'Catalogue_Item_Count' => 0,
						'Catalogue_Date_Created' => date('d-m-Y h:i:s')
				));
		}
}
?>