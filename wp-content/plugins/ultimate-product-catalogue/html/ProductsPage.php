<div id="col-right" class="ewd-upcp-admin-products-table-full">
<div class="col-wrap">

<div class="ewd-upcp-admin-new-product-page-top-part">
	<div class="ewd-upcp-admin-new-product-page-top-part-left">
		<h3 class="ewd-upcp-admin-new-tab-headings"><?php _e('Add New Product', 'ultimate-product-catalogue'); ?></h3>	
		<div class="ewd-upcp-admin-add-new-product-buttons-area">
			<a href="admin.php?page=UPCP-options&Action=UPCP_Add_Product_Screen" class="button-primary ewd-upcp-admin-add-new-product-button" id="ewd-upcp-admin-manually-add-product-button"><?php _e('Manually', 'ultimate-product-catalogue'); ?></a>
			<div class="button-primary ewd-upcp-admin-add-new-product-button" id="ewd-upcp-admin-add-by-spreadsheet-button"><?php _e('From Spreadsheet', 'ultimate-product-catalogue'); ?></div>
		</div>
	</div>
	<div class="ewd-upcp-admin-new-product-page-top-part-right">
		<h3 class="ewd-upcp-admin-new-tab-headings"><?php _e('Export Products to Spreasheet', 'ultimate-product-catalogue'); ?></h3>	
		<div class="ewd-upcp-admin-export-buttons-area">
			<?php if($Full_Version == 'Yes'){ ?>
				<form method="post" action="admin.php?page=UPCP-options&Action=UPCP_ExportToExcel&FileType=CSV">
					<input type="submit" name="Export_Submit" class="button button-secondary ewd-upcp-admin-export-button" value="<?php _e('Export to CSV', 'ultimate-product-catalogue'); ?>"  />
				</form>
				<form method="post" action="admin.php?page=UPCP-options&Action=UPCP_ExportToExcel">
					<input type="submit" name="Export_Submit" class="button button-secondary ewd-upcp-admin-export-button" value="<?php _e('Export to Excel', 'ultimate-product-catalogue'); ?>"  />
				</form>
			<?php } else{
				_e("The full version of the Ultimate Product Catalog Plugin is required to export products.", 'ultimate-product-catalogue'); ?><br /><a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" target="_blank"><?php _e("Please upgrade to unlock this feature!", 'ultimate-product-catalogue'); ?></a>
			<?php } ?>
		</div>
	</div>
</div>

<!-- Display a list of the products which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php
	$user = get_current_user_id();
	$screen = get_current_screen();
	$screen_option = $screen->get_option('per_page', 'option');
	$per_page = get_user_meta($user, $screen_option, true);

	if (empty($per_page) or is_array($per_page) or $per_page < 1 ) {
		$per_page = $screen->get_option('per_page', 'default');
	}

			$Categories = $wpdb->get_results("SELECT * FROM $categories_table_name ORDER BY Category_Sidebar_Order, Category_Name");
			$SubCategories = $wpdb->get_results("SELECT * FROM $subcategories_table_name ORDER BY SubCategory_Sidebar_Order,SubCategory_Name");

			if (isset($_GET['Page']) and $_GET['DisplayPage'] == "Products") {$Page = $_GET['Page'];}
			else {$Page = 1;}
			if ($Page < 1 or !is_numeric($Page)) {$Page = 1;}
			$wpdb->show_errors();
			$Sql = "SELECT * FROM $items_table_name WHERE 1=1 ";
				if (isset($_REQUEST['ItemName'])) {$Sql .= "AND Item_Name LIKE '%" . sanitize_text_field($_REQUEST['ItemName']) . "%' ";}
				if (isset($_REQUEST['UPCP_Category_Filter']) and $_REQUEST['UPCP_Category_Filter'] != "All") {$Sql .= "AND Category_ID='" . sanitize_text_field($_REQUEST['UPCP_Category_Filter']) . "' ";}
				if (isset($_REQUEST['UPCP_SubCategory_Filter']) and $_REQUEST['UPCP_SubCategory_Filter'] != "All") {$Sql .= "AND SubCategory_ID='" . sanitize_text_field($_REQUEST['UPCP_SubCategory_Filter']) . "' ";}
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Products") {$Sql .= "ORDER BY " . sanitize_text_field($_GET['OrderBy']) . " ";}
				else {$Sql .= "ORDER BY Item_Date_Created ";}
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Products" and $_GET['OrderBy'] == "Item_Price") {$Sql .= "* 1 ";}
				if (isset($_GET['Order'])) {$Sql .= sanitize_text_field($_GET['Order']) . " ";}
				$Product_Count_Sql = $Sql;
				$Sql .= "LIMIT " . (($Page - 1) * $per_page) . "," . $per_page;
				$myrows = $wpdb->get_results($Sql);
				$TotalProducts = $wpdb->get_results($Product_Count_Sql);
				$num_rows = $wpdb->num_rows;
				$Number_of_Pages = ceil($num_rows/$per_page);
				$Current_Page = "admin.php?page=UPCP-options&DisplayPage=Products";
				if (isset($_REQUEST['ItemName'])) {$Current_Page_With_Name_Search = $Current_Page . "&ItemName=" . sanitize_text_field($_REQUEST['ItemName']);}
				else {$Current_Page_With_Name_Search = $Current_Page;}
				if (isset($_REQUEST['UPCP_Category_Filter']) and $_REQUEST['UPCP_Category_Filter'] != "All") {$Current_Page_With_Cats = $Current_Page_With_Name_Search . "&UPCP_Category_Filter=" . sanitize_text_field($_REQUEST['UPCP_Category_Filter']);}
				else {$Current_Page_With_Cats = $Current_Page_With_Name_Search;}
				if (isset($_REQUEST['UPCP_SubCategory_Filter']) and $_REQUEST['UPCP_SubCategory_Filter'] != "All") {$Current_Page_With_SubCats = $Current_Page_With_Cats . "&UPCP_SubCategory_Filter=" . sanitize_text_field($_REQUEST['UPCP_SubCategory_Filter']);}
				else {$Current_Page_With_SubCats = $Current_Page_With_Cats;}
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= $Current_Page_With_SubCats . "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . sanitize_text_field($_GET['Order']);}
				else {$Current_Page_With_Order_By = $Current_Page_With_SubCats;}
?>

<form action="<?php echo $Current_Page; ?>" method="post">
<p class="search-box">
	<label class="screen-reader-text" for="post-search-input">Search Products:</label>
	<input type="search" id="post-search-input" name="ItemName" value="">
	<input type="submit" name="" id="search-submit" class="button" value="Search Products">
</p>
</form>

<div class="alignleft actions">
			<form action="<?php echo $Current_Page_With_Name_Search; ?>" method="post">
				<select name='UPCP_Category_Filter'>
					<option value='All'><?php _e("All Categories", 'ultimate-product-catalogue'); ?></option>
					<?php
						if (!isset($_REQUEST['UPCP_Category_Filter'])){$_REQUEST['UPCP_Category_Filter'] = "";}
						foreach ($Categories as $Category) {
							echo "<option value='" . $Category->Category_ID . "' ";
							if ($_REQUEST['UPCP_Category_Filter'] == $Category->Category_ID) {echo "selected=selected";}
							echo ">" . $Category->Category_Name . "</option>";
						}
					?>
				</select>
				<select name='UPCP_SubCategory_Filter'>
					<option value='All'><?php _e("All Sub-Categories", 'ultimate-product-catalogue'); ?></option>
					<?php
						if (!isset($_REQUEST['UPCP_SubCategory_Filter'])){$_REQUEST['UPCP_SubCategory_Filter'] = "";}
						foreach ($SubCategories as $SubCategory) {
							echo "<option value='" . $SubCategory->SubCategory_ID . "' ";
							if ($_REQUEST['UPCP_SubCategory_Filter'] == $SubCategory->SubCategory_ID) {echo "selected=selected";}
							echo ">" . $SubCategory->SubCategory_Name . "</option>";
						}
					?>
				</select>
				<input type="submit" name="" id="search-submit" class="button-secondary action" value="<?php _e('Filter', 'ultimate-product-catalogue'); ?>">
			</form>
		</div>

<form action="admin.php?page=UPCP-options&Action=UPCP_MassDeleteProducts&DisplayPage=Products" method="post">
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-product-catalogue') ?></option>
						<option value='delete'><?php _e("Delete", 'ultimate-product-catalogue') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'ultimate-product-catalogue') ?>"  />
				<a class='confirm button-secondary action ewd-upcp-admin-delete-all-products-button' href='admin.php?page=UPCP-options&Action=UPCP_DeleteAllProducts&DisplayPage=Products'>Delete All Products</a>
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages <= 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'ultimate-product-catalogue') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'ultimate-product-catalogue') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
</div>

<table class="wp-list-table striped widefat fixed tags sorttable" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Item_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Item_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Item_Price" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Price&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Price&Order=ASC'>";} ?>
											  <span><?php _e("Price", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='users' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Category_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Category_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Category_Name&Order=ASC'>";} ?>
											  <span><?php _e("Category", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='enabled' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "SubCategory_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=SubCategory_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=SubCategory_Name&Order=ASC'>";} ?>
											  <span><?php _e("Sub-Category", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='enabled' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Item_Views" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Views&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Views&Order=ASC'>";} ?>
											  <span><?php _e("# of Views", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Item_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Item_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Item_Price" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Price&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Price&Order=ASC'>";} ?>
											  <span><?php _e("Price", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='users' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Category_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Category_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Category_Name&Order=ASC'>";} ?>
											  <span><?php _e("Category", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='enabled' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "SubCategory_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=SubCategory_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=SubCategory_Name&Order=ASC'>";} ?>
											  <span><?php _e("Sub-Category", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='enabled' class='manage-column column-users sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Item_Views" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Views&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Products&OrderBy=Item_Views&Order=ASC'>";} ?>
											  <span><?php _e("# of Views", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>

		 <?php
				if ($myrows) {
	  			  foreach ($myrows as $Item) {
								echo "<tr id='Item" . $Item->Item_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Products_Bulk[]' value='" . $Item->Item_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=UPCP-options&Action=UPCP_Item_Details&Selected=Product&Item_ID=" . $Item->Item_ID ."' title='Edit " . $Item->Item_Name . "'>" . $Item->Item_Name . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								/*echo "<span class='edit'>";
								echo "<a href='admin.php?page=UPCP-options&Action=UPCP_Item_Details&Selected=Product&Item_ID=" . $Item->Item_ID ."'>Edit</a>";
		 						echo " | </span>";*/
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=UPCP-options&Action=UPCP_DeleteProduct&DisplayPage=Products&Item_ID=" . $Item->Item_ID ."'>" . __("Delete", 'ultimate-product-catalogue') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Item->Item_ID ."'>";
								echo "<div class='name'>" . strip_tags($Item->Item_Name) . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-description'>" . strip_tags(substr($Item->Item_Description, 0, 60));
								if (strlen($Item->Item_Description) > 60) {echo "...";}
								echo "</td>";
								echo "<td class='description column-price'>" . $Item->Item_Price . "</td>";
								echo "<td class='users column-category'>" . strip_tags($Item->Category_Name) . "</td>";
								echo "<td class='users column-subcategory'>" . strip_tags($Item->SubCategory_Name) . "</td>";
								echo "<td class='users column-item-views'>" . $Item->Item_Views . "</td>";
								echo "<td class='column-duplicate-product'><a href='admin.php?page=UPCP-options&Action=UPCP_Duplicate_Product&Selected=Product&Item_ID=" . $Item->Item_ID ."'>" . __('Duplicate Product', 'ultimate-product-catalogue') . "</a></td>"; 
								echo "</tr>";
						}
				}
		?>

	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-product-catalogue') ?></option>
						<option value='delete'><?php _e("Delete", 'ultimate-product-catalogue') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'ultimate-product-catalogue') ?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages <= 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'ultimate-product-catalogue') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'ultimate-product-catalogue') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {echo "disabled";} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {echo "disabled";} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div> <!-- /col-right -->


<!-- Form to upload a list of new products from a spreadsheet -->
<div id="col-left" class="upcp-hidden">
<div class="col-wrap">

<div class="form-wrap">



<div id="ewd-upcp-admin-add-manually">

<!-- Form to create a new product -->
<h3><?php _e("Add Product Manually", 'ultimate-product-catalogue') ?></h3>
<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddProduct&DisplayPage=Product" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Product" />
<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Item_Name"><?php _e("Product Name", 'ultimate-product-catalogue') ?></label>
	<input name="Item_Name" id="Item_Name" type="text" value="" size="60" />
</div>
<div class="form-field">
	<label for="Item_Slug"><?php _e("Slug", 'ultimate-product-catalogue') ?></label>
	<input name="Item_Slug" id="Item_Slug" type="text" value="" size="60" />
	<p><?php _e("The slug for your product if you use pretty permalinks.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Item_Image"><?php _e("Main Product Image", 'ultimate-product-catalogue') ?></label>
	<input id="Item_Image" type="text" size="36" name="Item_Image" value="http://" />
	<input id="Item_Image_button" class="button button-primary" type="button" value="<?php _e("Upload Image", 'ultimate-product-catalogue') ?>" />
</div>
<div class="form-field">
	<label for="Item_Price"><?php _e("Regular Price", 'ultimate-product-catalogue') ?></label>
	<input name="Item_Price" id="Item_Price" type="text" value="" size="60" />
</div>
<div class="form-field">
	<label for="Item_Sale_Price"><?php _e("Sale Price", 'ultimate-product-catalogue') ?></label>
	<input name="Item_Sale_Price" id="Item_Sale_Price" type="text" value="" size="60" />
	<p><?php _e("Sale price is only shown if the checkbox below is selected or 'Sale Mode' is selected in the 'Options' tab.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Item_Sale_Mode"><?php _e("On Sale", 'ultimate-product-catalogue') ?></label>
	<input name="Item_Sale_Mode" id="Item_Sale_Mode" type="checkbox" value="Yes"/>
</div>
<div class="form-field-small-buttons">
	<label for="Item_Description"><?php _e("Product Description", 'ultimate-product-catalogue') ?></label>
	<?php $settings = array( //'wpautotop' => false,
												 	 'textarea_rows' => 6);
				wp_editor("", "Item_Description", $settings); ?>
</div>
<div class="form-field">
	<label for="Item_SEO_Description"><?php _e("SEO Description", 'ultimate-product-catalogue') ?></label>
	<input name="Item_SEO_Description" id="Item_SEO_Description" type="text" value="" size="60" />
	<p><?php _e("The description to use for this product in the SEO By Yoast meta description tag.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
		<label for="Item_Link"><?php _e("Product Link", 'ultimate-product-catalogue') ?></label>
		<input name="Item_Link" id="Item_Link" type="text"  size="60" />
		<p><?php _e("A link that will replace the default product page. Useful if you participate in affiliate programs.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Item_Category"><?php _e("Category:", 'ultimate-product-catalogue') ?></label>
	<select name="Category_ID" id="Item_Category" onchange="UpdateSubCats();">
	<option value=""></option>
	<?php foreach ($Categories as $Category) {
						echo "<option value='" . $Category->Category_ID . "' >" . $Category->Category_Name . "</option>";
				} ?>
	</select>
</div>
<div class="form-field">
	<label for="Item_SubCategory"><?php _e("Sub-Category:", 'ultimate-product-catalogue') ?></label>
	<select name="SubCategory_ID" id="Item_SubCategory">
	<option value=""></option>
	<?php if ($Product->Category_ID != "") {
					  $SubCategories = $wpdb->get_results("SELECT * FROM $subcategories_table_name WHERE Category_ID=" . $Product->Category_ID . " ORDER BY SubCategory_Name");
						foreach ($SubCategories as $SubCategory) {
								echo "<option value='" . $SubCategory->SubCategory_ID . "'>" . $SubCategory->SubCategory_Name . "</option>";
						}
				} ?>
	</select>
</div>
<div class="form-field">
	<label for="Item_Tags"><?php _e("Tags:", 'ultimate-product-catalogue') ?></label>
	<?php $TagGroupNames = $wpdb->get_results("SELECT * FROM $tag_groups_table_name ORDER BY Tag_Group_ID ASC");
	$NoTag = new stdClass(); //Create an object for the tags that don't have a group
	$NoTag->Tag_Group_ID = 0;
	$NoTag->Tag_Group_Name = "Not Assigned";
	$NoTag->Tag_Group_Order = 9999;
	$NoTag->Display_Tag_Group = "Yes";
	$TagGroupNames[] = $NoTag;?>
    <div class="Tag-Group-Holder" style="margin:10px auto;">
    <?php
    	foreach($TagGroupNames as $TagGroupName){
			$TagGroupID = $TagGroupName->Tag_Group_ID;
			$Tags = $wpdb->get_results("SELECT * FROM $tags_table_name WHERE Tag_Group_ID=" . $TagGroupID . " ORDER BY Tag_Name ASC");
			if(!empty($Tags)){ ?>
        	    <div style="padding:10px;" id="Tag-Group-<?php echo $TagGroupName->Tag_Group_ID; ?>">
				<?php
					echo $TagGroupName->Tag_Group_Name . "<br /><br />";
        	    	foreach ($Tags as $Tag) { ?>
						<input type="checkbox" class='upcp-tag-input' name="Tags[]" value="<?php echo $Tag->Tag_ID; ?>" id="Tag-<?php echo $Tag->Tag_Name; ?>">
						<?php echo $Tag->Tag_Name; ?></br>
        	        <?php } ?>
        	    </div><!-- end #Tag-Group-<?php echo $TagGroupName->Tag_Group_ID; ?> -->
        	<?php };
		} ?>
    </div><!-- end .Tag-Group-Holder -->
</div>

<?php
$Sql = "SELECT * FROM $fields_table_name ORDER BY Field_Sidebar_Order";
$Fields = $wpdb->get_results($Sql);
$Value = "";
$ReturnString = "";
foreach ($Fields as $Field) {
		$ReturnString .= "<div class='form-field'><label for='" . $Field->Field_Name . "'>" . $Field->Field_Name . ":</label>";
		if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
			$ReturnString .= "<input name='" . $Field->Field_Name . "' id='upcp-input-" . $Field->Field_ID . "' class='upcp-text-input' type='text' value='" . $Value . "' />";
			if ($Field->Field_Values != "") {$ReturnString .= "<br />" . __('Accepted values', 'ultimate-product-catalogue') . ": " . $Field->Field_Values;}
		}
		elseif ($Field->Field_Type == "textarea") {
			$ReturnString .= "<textarea name='" . $Field->Field_Name . "' id='upcp-input-" . $Field->Field_ID . "' class='upcp-textarea'>" . $Value . "</textarea>";
			if ($Field->Field_Values != "") {$ReturnString .= "<br />" . __('Accepted values', 'ultimate-product-catalogue') . ": " . $Field->Field_Values;}
		  	$ReturnString .= "</td>";
		}
		elseif ($Field->Field_Type == "select") {
				$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
				$ReturnString .= "<select name='" . $Field->Field_Name . "' id='upcp-input-" . $Field->Field_ID . "' class='upcp-select'>";
				foreach ($Options as $Option) {
						$ReturnString .= "<option value='" . $Option . "' ";
						if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
						$ReturnString .= ">" . UPCP_Decode_CF_Commas($Option) . "</option>";
				}
				$ReturnString .= "</select>";
		}
		elseif ($Field->Field_Type == "radio") {
				$Counter = 0;
				$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
				foreach ($Options as $Option) {
						if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
						$ReturnString .= "<input type='radio' name='" . $Field->Field_Name . "' value='" . $Option . "' class='upcp-radio' ";
						if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
						$ReturnString .= ">" . UPCP_Decode_CF_Commas($Option);
						$Counter++;
				}
		}
		elseif ($Field->Field_Type == "checkbox") {
  			$Counter = 0;
				$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
				$Values = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Value)));
				foreach ($Options as $Option) {
						if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
						$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Name . "[]' value='" . $Option . "' class='upcp-checkbox' ";
						if (in_array($Option, $Values)) {$ReturnString .= "checked";}
						$ReturnString .= ">" . UPCP_Decode_CF_Commas($Option) . "</br>";
						$Counter++;
				}
		}
		elseif ($Field->Field_Type == "file") {
				$ReturnString .= "<input name='" . $Field->Field_Name . "' class='upcp-file-input' type='file' value='' />";
		}
		elseif ($Field->Field_Type == "date") {
				$ReturnString .= "<input name='" . $Field->Field_Name . "' class='upcp-date-input' type='date' value='' />";
		}
		elseif ($Field->Field_Type == "datetime") {
				$ReturnString .= "<input name='" . $Field->Field_Name . "' class='upcp-datetime-input' type='datetime-local' value='' />";
  	}
		$ReturnString .= " </div>";
}
echo $ReturnString;

?>

<?php $RelatedDisabled = ""; if ($Related_Products != "Manual") {$RelatedDisabled = "disabled";} ?>
<div class="form-field">
	<label for="Item_Related_Products"><?php _e("Related Products", 'ultimate-product-catalogue') ?></label>
	<label title='Product ID'></label><input type='text' name='Item_Related_Products_1' value='' <?php echo $RelatedDisabled; ?>/><br />
	<label title='Product ID'></label><input type='text' name='Item_Related_Products_2' value='' <?php echo $RelatedDisabled; ?>/><br />
	<label title='Product ID'></label><input type='text' name='Item_Related_Products_3' value='' <?php echo $RelatedDisabled; ?>/><br />
	<label title='Product ID'></label><input type='text' name='Item_Related_Products_4' value='' <?php echo $RelatedDisabled; ?>/><br />
	<label title='Product ID'></label><input type='text' name='Item_Related_Products_5' value='' <?php echo $RelatedDisabled; ?>/><br />
	<p><?php _e("What products are related to this one? (premium feature, input product IDs)", 'ultimate-product-catalogue') ?></p>
</div>

<?php if ($Next_Previous != "Manual") {$NextPreviousDisabled = "disabled";} ?>
<div class="form-field">
	<label for="Item_Related_Products"><?php _e("Next/Previous Products", 'ultimate-product-catalogue') ?></label>
	<label title='Product ID'>Next Product ID:</label><input type='text' name='Item_Next_Product' value='' <?php echo $NextPreviousDisabled; ?>/><br />
	<label title='Product ID'>Previous Product ID:</label><input type='text' name='Item_Previous_Product' value='' <?php echo $NextPreviousDisabled; ?>/><br />
	<p><?php _e("What products should be listed as the next/previous products? (premium feature, input product IDs)", 'ultimate-product-catalogue') ?></p>
</div>

<div class="form-field">
	<label for="Item_Display_Status"><?php _e("Display Status", 'ultimate-product-catalogue') ?></label>
		<label title='Show'><input type='radio' class ='upcp-radio-input' name='Item_Display_Status' value='Show' checked='checked'/> <span>Show</span></label>
	<label title='Hide'><input type='radio' class ='upcp-radio-input' name='Item_Display_Status' value='Hide' /> <span>Hide</span></label>
	<p><?php _e("Should this item be displayed if it's added to a catalog?", 'ultimate-product-catalogue') ?></p>
</div>


<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Product', 'ultimate-product-catalogue') ?>"  /></p></form>

</div> <!-- ewd-upcp-admin-add-manually -->


<div id="ewd-upcp-admin-add-from-spreadsheet">
	<h3><?php _e("Add Products from Spreadsheet", 'ultimate-product-catalogue') ?></h3>
	<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddProductSpreadsheet&DisplayPage=Product" class="validate" enctype="multipart/form-data">
	<?php wp_nonce_field('UPCP_Spreadsheet_Nonce', 'UPCP_Spreadsheet_Nonce'); ?>
	<div class="form-field form-required">
			<label for="Products_Spreadsheet"><?php _e("Spreadsheet Containing Products", 'ultimate-product-catalogue') ?></label>
			<input name="Products_Spreadsheet" id="Products_Spreadsheet" type="file" value=""/>
			<p><?php _e("The spreadsheet containing all of the products you wish to add. Make sure that the column title names are the same as the field names for products (ex: Name, Price, etc.), and that any categories and sub-categories are written exactly the same as they are online.", 'ultimate-product-catalogue') ?></p>
			<p><a href='http://www.etoilewebdesign.com/Screenshots/Sample_UltimateProductCatalogue_Import.xls' download><?php _e("Download Sample Spreadsheet"); ?></a></p>
	</div>
	<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Products', 'ultimate-product-catalogue') ?>"  /></p>
	</form>
</div>


</div>



<div class='clear'></div>
</div>
</div><!-- /col-left -->
