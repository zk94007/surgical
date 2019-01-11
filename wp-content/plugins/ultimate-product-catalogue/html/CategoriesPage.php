<div id="col-right">
<div class="col-wrap">


<!-- Display a list of the categories which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
			if (isset($_GET['Page']) and $_GET['DisplayPage'] == "Categories") {$Page = $_GET['Page'];}
			else {$Page = 1;}
			
			$Sql = "SELECT * FROM $categories_table_name ";
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Categories") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
				else {$Sql .= "ORDER BY Category_Sidebar_Order, Category_Name ";}
				$Sql .= "LIMIT " . ($Page - 1)*200 . ",200";
				$myrows = $wpdb->get_results($Sql);
				$TotalProducts = $wpdb->get_results("SELECT Category_ID FROM $categories_table_name");
				$num_rows = $wpdb->num_rows; 
				$Number_of_Pages = ceil($wpdb->num_rows/200);
				$Current_Page_With_Order_By = "admin.php?page=UPCP-options&DisplayPage=Categories";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=UPCP-options&Action=UPCP_MassDeleteCategories&DisplayPage=Categories" method="post">   
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-product-catalogue') ?></option>
						<option value='delete'>Delete</option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'ultimate-product-catalogue') ?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
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

<table class="wp-list-table striped widefat fixed tags sorttable categories-list" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Category_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Category_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Category_Item_Count" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Item_Count&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Item_Count&Order=ASC'>";} ?>
											  <span><?php _e("Products in Category", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Category_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Category_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Category_Item_Count" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Item_Count&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Categories&OrderBy=Category_Item_Count&Order=ASC'>";} ?>
											  <span><?php _e("Products in Category", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Category) {
								echo "<tr id='category-item-" . $Category->Category_ID ."' class='category-list-item'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Cats_Bulk[]' value='" . $Category->Category_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=UPCP-options&Action=UPCP_Category_Details&Selected=Category&Category_ID=" . $Category->Category_ID ."' title='Edit " . $Category->Category_Name . "'>" . strip_tags($Category->Category_Name) . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								/*echo "<span class='edit'>";
								echo "<a href='admin.php?page=UPCP-options&Action=UPCP_Category_Details&Selected=Category&Category_ID=" . $Category->Category_ID ."'>Edit</a>";
		 						echo " | </span>";*/
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=UPCP-options&Action=UPCP_DeleteCategory&DisplayPage=Categories&Category_ID=" . $Category->Category_ID ."'>" . __("Delete", 'ultimate-product-catalogue') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Category->Category_ID ."'>";
								echo "<div class='name'>" . strip_tags($Category->Category_Name) . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-description'>" . strip_tags($Category->Category_Description) . "</td>";
								echo "<td class='description column-items-count'>" . $Category->Category_Item_Count . "</td>";
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
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'ultimate-product-catalogue') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page < 2) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
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
</div>

<!-- Form to create a new category -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h3><?php _e("Add a New Category", 'ultimate-product-catalogue') ?></h3>
<form id="addcat" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddCategory&DisplayPage=Category" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Category" />
<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Category_Name"><?php _e("Name", 'ultimate-product-catalogue') ?></label>
	<input name="Category_Name" id="Category_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the category for your own purposes.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Category_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
	<textarea name="Category_Description" id="Category_Description" rows="5" cols="40"></textarea>
	<p><?php _e("The description of the category. What will it be used to display?", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Category_Image"><?php _e("Image", 'ultimate-product-catalogue') ?></label>
	<input id="Category_Image" type="text" size="36" name="Category_Image" value="http://" /> 
	<input id="Category_Image_Button" class="button" type="button" value="Upload Image" />
	<p><?php _e("An image that will be displayed in association with this category, if that option is selected in the 'Options' tab.", 'ultimate-product-catalogue') ?></p>
</div>

<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Category', 'ultimate-product-catalogue') ?>"  /></p></form></div>
<br class="clear" />
</div>
</div>


	<!--<form method="get" action=""><table style="display: none"><tbody id="inlineedit">
		<tr id="inline-edit" class="inline-edit-row" style="display: none"><td colspan="4" class="colspanchange">

			<fieldset><div class="inline-edit-col">
				<h4>Quick Edit</h4>

				<label>
					<span class="title">Name</span>
					<span class="input-text-wrap"><input type="text" name="name" class="ptitle" value="" /></span>
				</label>
					<label>
					<span class="title">Slug</span>
					<span class="input-text-wrap"><input type="text" name="slug" class="ptitle" value="" /></span>
				</label>
				</div></fieldset>
	
		<p class="inline-edit-save submit">
			<a accesskey="c" href="#inline-edit" title="Cancel" class="cancel button-secondary alignleft">Cancel</a>
						<a accesskey="s" href="#inline-edit" title="Update Level" class="save button-primary alignright">Update Level</a>
			<img class="waiting" style="display:none;" src="<?php echo ABSPATH . 'wp-admin/images/wpspin_light.gif'?>" alt="" />
			<span class="error" style="display:none;"></span>
			<input type="hidden" id="_inline_edit" name="_inline_edit" value="fb59c3f3d1" />			<input type="hidden" name="taxonomy" value="wmlevel" />
			<input type="hidden" name="post_type" value="post" />
			<br class="clear" />
		</p>
		</td></tr>
		</tbody></table></form>-->
		
<!--</div>-->
		