<?php $SubCategory = $wpdb->get_row($wpdb->prepare("SELECT * FROM $subcategories_table_name WHERE SubCategory_ID ='%d'", $_GET['SubCategory_ID'])); ?>
<?php
    if (!isset($_GET['Category_ID'])) { $_GET['Category_ID'] = "";}
	$ID_Matches = $wpdb->get_results($wpdb->prepare("SELECT term_id FROM $wpdb->termmeta  WHERE meta_key='upcp_ID' AND meta_value=%d", $_GET['Category_ID']));
	$WC_term_id = 0;
	foreach ($ID_Matches as $ID_Match) {
		$WC_term_id = $wpdb->get_var($wpdb->prepare("SELECT term_id FROM $wpdb->termmeta WHERE meta_key='upcp_equivalent' AND meta_value='SubCategory' AND term_id=%d", $ID_Match->term_id));
		if ($WC_term_id != "") {break;}
	}
?>
		
		<div class="OptionTab ActiveTab" id="EditSubCategory">
				
				<div id="col-right">
				<div class="col-wrap">
				<div id="add-page" class="postbox metabox-holder" >
				<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span><?php _e("Products in Sub-Category", 'ultimate-product-catalogue') ?></span></h3>
				<div class="inside">
				<div id="posttype-page" class="posttypediv">

				<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">
				<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
				<?php $Products = $wpdb->get_results($wpdb->prepare("SELECT Item_ID, Item_Name FROM $items_table_name WHERE SubCategory_ID='%d'", $_GET['SubCategory_ID']));
							foreach ($Products as $Product) {
									echo "<li><label class='menu-item-title'><a href='admin.php?page=UPCP-options&Action=UPCP_Item_Details&Selected=Product&Item_ID=" . $Product->Item_ID . "'>" . $Product->Item_Name . "</a></label></li>";
							}
				?>
				</ul>
				</div><!-- /.tabs-panel -->
				</div><!-- /.posttypediv -->
				</div>
				</div>
				</div>
				</div><!-- col-right -->
				
				<div id="col-left">
				<div class="col-wrap">
				<div class="form-wrap SubCategoryDetail">
					<a href="admin.php?page=UPCP-options&DisplayPage=SubCategories" class="NoUnderline">&#171; <?php _e("Back", 'ultimate-product-catalogue')?></a>
					<h3>Edit  <?php echo $SubCategory->SubCategory_Name; echo "( ID: "; echo $SubCategory->SubCategory_ID; echo " )"; ?></h3>
					<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_EditSubCategory&Update_Item=SubCategory&SubCategory_ID=<?php echo $SubCategory->SubCategory_ID ?>" class="validate" enctype="multipart/form-data">
					<input type="hidden" name="action" value="Edit_SubCategory" />
					<input type="hidden" name="SubCategory_ID" value="<?php echo $SubCategory->SubCategory_ID; ?>" />
					<input type="hidden" name="WC_term_id" value="<?php echo $SubCategory->SubCategory_WC_ID; ?>" />
					<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
					<?php wp_referer_field(); ?>
					<div class='form-field'>
						<label for="SubCategory_Name"><?php _e("Name", 'ultimate-product-catalogue') ?></label>
						<input name="SubCategory_Name" id="SubCategory_Name" type="text" value="<?php echo $SubCategory->SubCategory_Name;?>" size="60" />
						<p><?php _e("The name of the sub-category your users will see and search for.", 'ultimate-product-catalogue') ?></p>
					</div>
					<div class='form-field'>
						<label for="Item_Category"><?php _e("Category:", 'ultimate-product-catalogue') ?></label>
						<select name="Category_ID" id="Item_Category">
							<option value=""></option>
							<?php $Categories = $wpdb->get_results("SELECT * FROM $categories_table_name"); ?>
							<?php foreach ($Categories as $Category) {
							echo "<option value='" . $Category->Category_ID . "' ";
							if ($Category->Category_ID == $SubCategory->Category_ID) {echo "selected='selected'";}
							echo " >" . $Category->Category_Name . "</option>";
							} ?>
						</select>
						<p><?php _e("What category is this product in? Categories help to organize your product catalogs and help your customers to find what they're looking for.", 'ultimate-product-catalogue') ?></p>
					</div>
					<div class='form-field'>
						<label for="SubCategory_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
						<textarea name="SubCategory_Description" id="SubCategory_Description" rows="5" cols="40"><?php echo $SubCategory->SubCategory_Description;?></textarea>
						<p><?php _e("The description of the sub-category. What products are included in this?", 'ultimate-product-catalogue') ?></p>
					</div>
					<div class='form-field'>
						<label for="SubCategory_Image"><?php _e("Image", 'ultimate-product-catalogue') ?></label>
						<input id="SubCategory_Image" type="text" size="36" name="SubCategory_Image" value="<?php echo $SubCategory->SubCategory_Image;?>" /> 
						<input id="SubCategory_Image_Button" class="button" type="button" value="Upload Image" />
						<p><?php _e("An image that will be displayed in association with this sub-category, if that option is selected in the 'Options' tab. Current Image:", 'ultimate-product-catalogue') ?><br/><img class="PreviewImage" height="100" width="100" src="<?php echo $SubCategory->SubCategory_Image;?>" /></p>
						<div class='clear'></div>
					</div>

					<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'ultimate-product-catalogue') ?>"  /></p>
					</form>
				</div>
				</div>
				</div>
		</div>