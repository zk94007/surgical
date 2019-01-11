<?php if ($Full_Version == "Yes") {

function UPCP_Sort_Gridster($a, $b) {
	if ($a->row != $b->row) {
		return   $a->row  - $b->row;
	}
	else {
		return $a->col - $b->col;
	}
}
if (!isset($_GET['CPP_Mobile'])) { $_GET['CPP_Mobile'] = ""; }
if ($_GET['CPP_Mobile'] == "Tabbed" or $_GET['CPP_Mobile'] == "") {
	$Product_Inquiry_Form = get_option("UPCP_Product_Inquiry_Form");
	$Product_Reviews = get_option("UPCP_Product_Reviews");

	$Tabs_Array = get_option("UPCP_Tabs_Array");
	$Starting_Tab = get_option("UPCP_Starting_Tab");
	?>
	<div class="wrap">
		<div id="side-sortables" class="meta-box-sortables">
			<div id='pp-select' class='pp-select'>
				<h3>Selected Layout:</h3>
				<select name='PP-type-select' id='PP-type-select' onchange='Reload_PP_Page()'>
						<option value='Tabbed' <?php if (($_GET['CPP_Mobile'] == "Tabbed")) {echo "selected=selected";} ?>>Add Tabs</option>
						<option value='regular' <?php if (($_GET['CPP_Mobile'] == "regular")) {echo "selected=selected";} ?>>Custom Page - Large Screen</option>
						<option value='mobile' <?php if (($_GET['CPP_Mobile'] == "mobile")) {echo "selected=selected";} ?>>Custom Page - Mobile</option>
				</select>
			</div>
		</div>

		<form method="post" action="admin.php?page=UPCP-options&DisplayPage=ProductPage&CPP_Mobile=Tabbed&Action=UPCP_UpdateTabs" class="upcp-option-set">
			<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
			<input type='hidden' name='upcp_tabs_confirmation' value='Confirm' />

			<table class="form-table">
				<tr>
					<th scope="row" class="ewd-upcp-admin-no-info-button">Starting Tab</th>
					<td>
						<select name='starting_tab'>
							<option value='details' <?php echo ($Starting_Tab == 'details' ? 'selected' : ''); ?>>Product Details</option>
							<option value='addtl-information' <?php echo ($Starting_Tab == 'addtl-information' ? 'selected' : ''); ?>>Additional Information</option>
							<?php if ($Product_Inquiry_Form == "Yes") { ?><option value='contact' <?php echo ($Starting_Tab == 'contact' ? 'selected' : ''); ?>>Contact Us</option><?php } ?>
							<?php if ($Product_Reviews == "Yes") { ?><option value='reviews' <?php echo ($Starting_Tab == 'reviews' ? 'selected' : ''); ?>>Customer Reviews</option><?php } ?>
							<?php foreach ($Tabs_Array as $Tab_Item) {?>
								<option value="<?php echo sanitize_title($Tab_Item['Name']); ?>" <?php echo ($Starting_Tab == sanitize_title($Tab_Item['Name']) ? 'selected' : ''); ?>><?php echo $Tab_Item['Name']; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Additional Tabs</th>
					<td>
						<fieldset><legend class="screen-reader-text"><span>Additional Tabs</span></legend>
							<table id='upcp-tabs-table'>
								<tr>
									<th class="ewd-upcp-admin-no-info-button ewd-upcp-admin-no-top-padding">Tab Name</th>
									<th class="ewd-upcp-admin-no-info-button ewd-upcp-admin-no-top-padding">Content</th>
									<th class="ewd-upcp-admin-no-info-button ewd-upcp-admin-no-top-padding"></th>
								</tr>
								<?php 
									$Counter = 0;
									if (!is_array($Tabs_Array)) {$Tabs_Array = array();}
									foreach ($Tabs_Array as $Tab_Item) { 
										echo "<tr id='upcp-tab-" . $Counter . "'>";
											echo "<td class='ewd-upcp-admin-no-top-padding'><input class='upcp-array-text-input' type='text' name='Tab_" . $Counter . "_Name' value='" . $Tab_Item['Name']. "'/></td>";
											echo "<td class='ewd-upcp-admin-no-top-padding'><textarea class='upcp-array-textarea' name='Tab_" . $Counter . "_Content'>" . $Tab_Item['Content'] . "</textarea></td>";
											echo "<td class='ewd-upcp-admin-no-top-padding'><a class='upcp-delete-tab' data-tabnumber='" . $Counter . "'>Delete</a></td>";
										echo "</tr>";
										$Counter++;
									} 
									echo "<tr><td colspan='2'><a class='upcp-add-tab' id='upcp-add-tab' data-nextid='" . $Counter . "'>&plus; ADD</a></td><td></td></tr>";
								?>
							</table>
							<p>You can add additional tabs to the tabbed layout using the form above, and include the product name using [product-name] or custom fields using [custom-field-slug].</p>
						</fieldset>
					</td>
				</tr>
			</table>
			
			<p class="submit"><input type="submit" name="Tabs_Submit" class="button button-primary" value='<?php _e("Save Tabs", 'ultimate-product-catalogue')?>'/></p>
		</form>
	</div> <!-- wrap -->

<?php }

//end of tabbed product if
else {
	$PP_Grid_Width = get_option("UPCP_PP_Grid_Width");
	$PP_Grid_Height = get_option("UPCP_PP_Grid_Height");
	$Top_Bottom_Padding = get_option("UPCP_Top_Bottom_Padding");
	$Left_Right_Padding = get_option("UPCP_Left_Right_Padding");
	
	echo "<script language='JavaScript' type='text/javascript'>";
	echo "var pp_grid_width = " . $PP_Grid_Width . ";";
	echo "var pp_grid_height = " . $PP_Grid_Height . ";";
	echo "var pp_top_bottom_padding = " . $Top_Bottom_Padding . ";";
	echo "var pp_left_right_padding = " . $Left_Right_Padding . ";";
	
	if ($_GET['CPP_Mobile'] == "mobile") {echo "var grid_type = 'mobile';";}
	else {echo "var grid_type = 'regular';";}
	echo "</script>";
	?>		
		<div id="side-sortables" class="metabox-holder ">
			<div id="cpp-message" class="postbox " >
				<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span><?php _e("Feature Update", 'ultimate-product-catalogue') ?></span></h3>
				<div class="inside">
						<?php _e("Some users have reported problems using the admin area functions of this feature with FireFox and IE browsers. No issues reported yet with Chrome, or with any browser on the visitor's side.", 'ultimate-product-catalogue'); ?>
				</div>
			</div>
		</div>
		
		<!-- Create the form to edit the basic catalogue details -->
		<div id="">
		<div id="" class="metabox-holder">
			<div id="side-sortables" class="meta-box-sortables">
			<div id='pp-select' class='pp-select'>
				<h3>Selected Layout:</h3>
				<select name='PP-type-select' id='PP-type-select' onchange='Reload_PP_Page()'>
						<option value='Tabbed' <?php if ($_GET['CPP_Mobile'] == "Tabbed") {echo "selected=selected";} ?>>Add Tabs</option>
						<option value='regular' <?php if ($_GET['CPP_Mobile'] == "regular") {echo "selected=selected";} ?>>Custom Page - Regular</option>
						<option value='mobile' <?php if ($_GET['CPP_Mobile'] == "mobile") {echo "selected=selected";} ?>>Custom Page - Mobile</option>
				</select>
			</div>
				
	<!-- Create a box with a form that users can add products to the catalogue with -->
	<div id="add-page" class="postbox " >
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span><?php _e("Basic Elements", 'ultimate-product-catalogue') ?></span></h3>
	<div class="inside">
		<div id="posttype-page" class="posttypediv">
	
			<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">
				<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
					<?php $BasicElements =  array( array('name' => "Additional Images",'class' => 'additional_images', 'id'=> '', 'x-size' => 2,'y-size' => 8),
								 					array('name' => "Back", 'class' => 'back', 'id'=> '','x-size' => 2,'y-size' => 1),
													array('name' => "Blank", 'class' => 'blank', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Category", 'class' => 'category', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Category Label", 'class' => 'category_label', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Description", 'class' => 'description', 'id'=> '','x-size' => 5,'y-size' => 4),
													array('name' => "Main Image",'class' => 'main_image', 'id'=> '','x-size' => 4,'y-size' => 6),
													array('name' => "Next/Previous", 'class' => 'next_previous', 'id'=> '','x-size' => 2,'y-size' => 3),
													array('name' => "Price", 'class' => 'price', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Price Label", 'class' => 'price_label', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Product Link", 'class' => 'product_link', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Product Name", 'class' => 'product_name', 'id'=> '','x-size' => 3,'y-size' => 1),
													array('name' => "Related Products", 'class' => 'related_products', 'id'=> '','x-size' => 5,'y-size' => 3),
													array('name' => "Sub-Category", 'class' => 'subcategory', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Sub-Category Label", 'class' => 'subcategory_label', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Tags", 'class' => 'tags', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Tags Label", 'class' => 'tags_label', 'id'=> '','x-size' => 1,'y-size' => 1),
													array('name' => "Text", 'class' => 'text', 'id'=> '','x-size' => 2,'y-size' => 2));
							foreach ($BasicElements as $Element) {
								echo "<li><a href='#' onclick='add_element(\"" . $Element['name'] . "\",\"" . $Element['class'] . "\",\"" . $Element['id'] . "\", " . $Element['x-size'] . ", " . $Element['y-size'] . "); return false;'>" . $Element['name'] . "</a></li>";
							}
					?>
				</ul>
			</div><!-- /.tabs-panel -->
	
		</div><!-- /.posttypediv -->
	</div>
	
	<!-- Create a box with a form that users can add categories to the catalogue with -->
	<div id="add-page" class="postbox " >
	<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span><?php _e("Custom Fields", 'ultimate-product-catalogue') ?></span></h3>
	<div class="inside">
		<div id="posttype-page" class="posttypediv">
	
			<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">
				<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
					<?php $Fields = $wpdb->get_results("SELECT * FROM $fields_table_name ORDER BY Field_Name"); 
							foreach ($Fields as $Field) {
								echo "<li><a href='#' onclick='add_element(\"" . $Field->Field_Name . "\",\"custom_field\",\"" . $Field->Field_ID . "\", 1, 1); return false;'>" . $Field->Field_Name . "</a></li>";
								echo "<li><a href='#' onclick='add_element(\"" . $Field->Field_Name . " Label\",\"custom_label\",\"" . $Field->Field_ID . "\", 1, 1); return false;'>" . $Field->Field_Name . " Label</a></li>";
							}
					?>
				</ul>
			</div><!-- /.tabs-panel -->
	
		</div><!-- /.posttypediv -->
		</div>
	</div>
	</div>
	</div>
	<?php if ($_GET['CPP_Mobile'] == "mobile") { ?>
	<button value='Save Grid' id='gridster-button-mobile'>Save Layout</button>
	<a class='confirm-restore' href='admin.php?page=UPCP-options&Action=UPCP_RestoreDefaultPPLayoutMobile&DisplayPage=ProductPage'><button id='gridster-reset'>Restore Default</button></a>
	<?php } else { ?>
	<button value='Save Grid' id='gridster-button'>Save Layout</button>
	<a class='confirm-restore' href='admin.php?page=UPCP-options&Action=UPCP_RestoreDefaultPPLayout&DisplayPage=ProductPage'><button id='gridster-reset-mobile'>Restore Default</button></a>
	<?php } ?>
	</div><!-- /#menu-settings-column -->
				
	<!-- Show the products and categories currently in the catalogue, give the user the
	     option of deleting them or switching the order around -->
	<?php $Max_Column = "";
	$Max_Row = ""; ?>
	<?php if ($_GET['CPP_Mobile'] == "mobile") {$UPCP_Product_Page_Serialized = get_option("UPCP_Product_Page_Serialized_Mobile");}
					else {$UPCP_Product_Page_Serialized = get_option("UPCP_Product_Page_Serialized");}
					if (strpos($UPCP_Product_Page_Serialized, "class=\\\\") !== FALSE){$Gridster = json_decode(stripslashes($UPCP_Product_Page_Serialized));}
					else {$Gridster = json_decode($UPCP_Product_Page_Serialized);}
					if (is_array($Gridster)) {
						//echo "<pre>" . print_r($Gridster, true) . "</pre>";
						usort($Gridster, 'UPCP_Sort_Gridster');
						foreach ($Gridster as $Grid_Element) {
							$Max_Column = max($Grid_Element->col, $Max_Column);
							$Max_Row = max($Grid_Element->row, $Max_Row);
						}
					}
		?>
	<div id='upcp-gridster-initial-data' data-maxcol='<?php echo $Max_Column; ?>' data-maxrow='<?php echo $Max_Row; ?>' ></div>

	  <div class="wrapper gridster">
	      <ul>
	        <?php 	if (is_array($Gridster)) {	
	        			foreach ($Gridster as $Element) {
							echo "<li data-col='" . $Element->col . "' data-row='" . $Element->row . "' data-sizex='" . $Element->size_x . "' data-sizey='" . $Element->size_y . "'  data-elementclass='" . $Element->element_class . "' data-elementid='" . $Element->element_id . "' class='prod-page-div gs-w' style='display: list-item; position:absolute;'>";
							echo substr($Element->element_type, 0, strpos($Element->element_type, '<'));
							echo "<div class='gs-delete-handle' onclick='remove_element(this);'></div>";
							if ($Element->element_class == "text") {echo "<textarea onkeyup='UPCP_Page_Builder_UpdateID(this);' class='upcp-pb-textarea'>" . $Element->element_id . "</textarea>";}
							/*echo "<div>Col: " . $Element->col . "<br />";
							echo "Row: " . $Element->row . "<br />";
							echo "Size X: " . $Element->size_x . "<br />";
							echo "Size Y: " . $Element->size_y . "<br />";
							echo "Class: " . $Element->element_class . "<br />";
							echo "ID: " . $Element->element_id . "<br /></div>";*/
							echo "</li>";
						}
					}
			?>
	      </ul>
	  </div>
	</div>

<?php } //end of Tabbed product else ?>
				
<?php } else { ?>
<div class="Info-Div">
	<h2><?php _e("Full Version Required!", 'ultimate-product-catalogue') ?></h2>
	<div class="upcp-full-version-explanation">
		<?php _e("The full version of the Ultimate Product Catalog Plugin is required to use tags.", 'ultimate-product-catalogue');?><a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/"><?php _e(" Please upgrade to unlock this page!", 'ultimate-product-catalogue'); ?></a>
	</div>
</div>

<div id="side-sortables" class="metabox-holder ">
	<div id="cpp-message" class="postbox " >
		<div class="handlediv" title="Click to toggle"></div><h3 class='hndle'><span><?php _e("Feature Update", 'ultimate-product-catalogue') ?></span></h3>
		<div class="inside">
			<?php _e("Some users have reported problems using this feature with FireFox and IE browsers. No issues reported yet with Chrome.", 'ultimate-product-catalogue'); ?>
		</div>
	</div>
</div>
<?php } ?> 