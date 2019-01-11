	<div class="OptionTab ActiveTab" id="EditProduct">
		<!-- add the ability to switch quickly between products -->

		<div class="form-wrap ItemDetail upcp-product-details">
			<a href="admin.php?page=UPCP-options&DisplayPage=Products" class="NoUnderline">&#171; <?php _e("Back", 'ultimate-product-catalogue') ?></a>
			<h3>Add New Product</h3>
			<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddProduct&DisplayPage=Product" class="validate" enctype="multipart/form-data">
				<input type="hidden" name="action" value="Add_Product" />
				<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
				<?php wp_referer_field(); ?>

				<div class="ewd-upcp-admin-edit-product-left">
					<table class="form-table ewd-upcp-admin-edit-product-table-no-th">
						<tr>
							<td><input name="Item_Name" id="Item_Name" type="text" placeholder="<?php _e('Name of Product', 'ultimate-product-catalogue') ?>" />
						</tr>
						<tr>
							<th><label for="Item_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label></th>
							<td><?php 
								$settings = array( //'wpautotop' => false,
												'textarea_rows' => 10);																						
								wp_editor('', "Item_Description", $settings); ?>
						</tr>
					</table>

					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box ewd-upcp-admin-edit-product-left-full-widget-box" id="ewd-upcp-admin-edit-product-details-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Product Details', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							<table class="form-table">
								<tr>
									<th><label for="Item_Slug"><?php _e("Slug", 'ultimate-product-catalogue') ?></label></th>
									<td><input name="Item_Slug" id="Item_Slug" type="text" size="60" />
									<p><?php _e("The slug for your product if you use pretty permalinks.", 'ultimate-product-catalogue') ?></p></td>
								</tr>
								<tr>
									<th><label for="Item_Price"><?php _e("Regular Price", 'ultimate-product-catalogue') ?></label></th>
									<td><input name="Item_Price" id="Item_Price" type="text" size="60" />
								</tr>
								<tr>
									<th><label for="Item_Sale_Price"><?php _e("Sale Price", 'ultimate-product-catalogue') ?></label></th>
									<td><input name="Item_Sale_Price" id="Item_Sale_Price" type="text" size="60" />
									<p><?php _e("What price should this product be on sale for? Only shown if the checkbox below is selected or 'Sale Mode' is selected in the 'Options' tab.", 'ultimate-product-catalogue') ?></p></td>
								</tr>
								<tr>
									<th><label for="Item_Sale_Mode"><?php _e("On Sale", 'ultimate-product-catalogue') ?></label></th>
									<td><input name="Item_Sale_Mode" id="Item_Sale_Mode" type="checkbox" />
									<p><?php _e("Should the sale price be displayed for this item?", 'ultimate-product-catalogue') ?></p></td>
								</tr>
								<tr>
									<th><label for="Item_SEO_Description"><?php _e("SEO Description", 'ultimate-product-catalogue') ?></label></th>
									<td><input name="Item_SEO_Description" id="Item_SEO_Description" type="text" size="60" />
									<p><?php _e("The description to use for this product in the SEO By Yoast meta description tag.", 'ultimate-product-catalogue') ?></p></td>
								</tr>
								<tr>
									<th><label for="Item_Link"><?php _e("Product Link", 'ultimate-product-catalogue') ?></label></th>
									<td><input name="Item_Link" id="Item_Link" type="text" size="60" />
									<p><?php _e("A link that will replace the default product page. Useful if you participate in affiliate programs.", 'ultimate-product-catalogue') ?></p></td>
								</tr>
								<tr>
									<th><label for="Item_Display_Status"><?php _e("Display Status", 'ultimate-product-catalogue') ?></label></th>
									<td><label title='Show'><input type='radio' name='Item_Display_Status' value='Show' checked /> <span>Show</span></label>
									<label title='Hide'><input type='radio' name='Item_Display_Status' value='Hide' /> <span>Hide</span></label>
									<p><?php _e("Should this item be displayed if it's added to a catalog?", 'ultimate-product-catalogue') ?></p></td>
								</tr>
							</table>
						</div>
					</div>

				</div> <!-- edit-product-left -->
				<div class="ewd-upcp-admin-edit-product-right">

					<p class="submit ewd-upcp-admin-edit-product-submit-p"><input type="submit" name="submit" id="submit" class="button-primary ewd-upcp-admin-edit-product-save-button" value="<?php _e('Create Product', 'ultimate-product-catalogue'); ?>"  /></p>

					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box" id="ewd-upcp-admin-edit-product-need-help-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Need Help?', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							 <div class='ewd-upcp-need-help-box'>
								<div class='ewd-upcp-need-help-text'>Visit our Support Center for documentation and tutorials</div>
								<a class='ewd-upcp-need-help-button' href='https://www.etoilewebdesign.com/support-center/?Plugin=UPCP' target='_blank'>GET SUPPORT</a>
							</div>
						</div>
					</div>

					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box" id="ewd-upcp-admin-edit-product-main-image-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Main Product Image', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							<table class="form-table">
								<tr>
									<th><label for="Item_Image"><?php _e("Image URL", 'ultimate-product-catalogue') ?></label></th>
									<td>
										<input id="Item_Image" type="text" size="36" name="Item_Image" /> 
										<input id="Item_Image_button" class="button" type="button" value="Upload Image" />
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box" id="ewd-upcp-admin-edit-product-categories-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Categories', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							<table class="form-table">
								<tr>
									<th><label for="Item_Category"><?php _e("Category", 'ultimate-product-catalogue') ?></label></th>
									<td><select name="Category_ID" id="Item_Category" onchange="UpdateSubCats();">
										<option value=""></option>
											<?php $Categories = $wpdb->get_results("SELECT * FROM $categories_table_name ORDER BY Category_Sidebar_Order, Category_Name"); ?>
											<?php foreach ($Categories as $Category) {
											 	echo "<option value='" . $Category->Category_ID . "' >" . $Category->Category_Name . "</option>";
											} ?>
										</select>
									</td>
								</tr>
								<tr>
									<th><label for="Item_SubCategory"><?php _e("Sub-Category", 'ultimate-product-catalogue') ?></label></th>
									<td><select name="SubCategory_ID" id="Item_SubCategory">
											<option value=""></option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box<?php echo ( empty($Tagged_Items) ? ' ewd-upcp-admin-widget-box-start-closed' : '' ); ?>" id="ewd-upcp-admin-edit-product-tags-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Tags', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							<table class="form-table">
								<tr>
									<th><label for="Item_Tags"><?php _e('Tags', 'ultimate-product-catalogue'); ?></label></th>
									<td>
										<?php $TagGroupNames = $wpdb->get_results("SELECT * FROM $tag_groups_table_name ORDER BY Tag_Group_ID ASC");
										$NoTag = new stdClass(); //Create an object for the tags that don't have a group
										$NoTag->Tag_Group_ID = 0;
										$NoTag->Tag_Group_Name = "Not Assigned";
										$NoTag->Tag_Group_Order = 9999;
										$NoTag->Display_Tag_Group = "Yes";
										$TagGroupNames[] = $NoTag;?>
						                <div class="Tag-Group-Holder" style="margin:10px auto;">
						                <?php foreach($TagGroupNames as $TagGroupName){
											$Tags = $wpdb->get_results("SELECT * FROM $tags_table_name WHERE Tag_Group_ID=" . $TagGroupName->Tag_Group_ID . " ORDER BY Tag_Name ASC" );
											if(!empty($Tags)){?>
						                    	<div class="ewd-upcp-admin-edit-product-tag-groups" id="Tag-Group-<?php echo $TagGroupName->Tag_Group_ID; ?>">
						                        <?php echo $TagGroupName->Tag_Group_Name."<br /><br />"; ?>
						                        <?php foreach ($Tags as $Tag) { ?>
						                                <input type="checkbox" class='upcp-tag-input' name="Tags[]" value="<?php echo $Tag->Tag_ID; ?>" id="Tag-<?php echo $Tag->Tag_Name; ?>" >
						                                <?php echo $Tag->Tag_Name; ?></br>
						                        <?php } ?>
						                        </div><!-- end #Tag-Group-<?php echo $TagGroupName->Tag_Group_ID; ?> --><?php } } ?>
						                </div><!-- end .Tag-Group-Holder -->
					 				</td>
					 			</tr>
							</table>
						</div>
					</div>

					<?php
					$Sql = "SELECT * FROM $fields_table_name ORDER BY Field_Sidebar_Order";
					$Fields = $wpdb->get_results($Sql);
					?>
					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box<?php echo ( empty($MetaValues) ? ' ewd-upcp-admin-widget-box-start-closed' : '' ); ?>" id="ewd-upcp-admin-edit-product-custom-fields-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Custom Fields', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							<table class="form-table">
								<?php
								$ReturnString = "";
								foreach ($Fields as $Field) {
									$ReturnString .= "<tr><th><label for='" . $Field->Field_Name . "'>" . $Field->Field_Name . "</label></th>";
									if ($Field->Field_Type == "text" or $Field->Field_Type == "mediumint") {
							  		  $ReturnString .= "<td><input name='" . $Field->Field_Name . "' id='upcp-input-" . $Field->Field_ID . "' class='upcp-text-input' type='text' />";
							  		  if ($Field->Field_Values != "") {$ReturnString .= "<br />" . __('Accepted values', 'ultimate-product-catalogue') . ": " . $Field->Field_Values;}
							  		  $ReturnString .= "</td>";
									}
									elseif ($Field->Field_Type == "textarea") {
										$ReturnString .= "<td><textarea name='" . $Field->Field_Name . "' id='upcp-input-" . $Field->Field_ID . "' class='upcp-textarea' cols='60' rows='6'></textarea>";
										if ($Field->Field_Values != "") {$ReturnString .= "<br />" . __('Accepted values', 'ultimate-product-catalogue') . ": " . $Field->Field_Values;}
							  		  $ReturnString .= "</td>";
									} 
									elseif ($Field->Field_Type == "select") { 
										$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
										$ReturnString .= "<td><select name='" . $Field->Field_Name . "' id='upcp-input-" . $Field->Field_ID . "' class='upcp-select'>";
					 					foreach ($Options as $Option) {
											$ReturnString .= "<option value='" . $Option . "' >" . UPCP_Decode_CF_Commas($Option) . "</option>";
										}
										$ReturnString .= "</select></td>";
									} 
									elseif ($Field->Field_Type == "radio") {
										$Counter = 0;
										$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
										$ReturnString .= "<td>";
										foreach ($Options as $Option) {
											if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
											$ReturnString .= "<input type='radio' name='" . $Field->Field_Name . "' value='" . $Option . "' class='upcp-radio' >" . UPCP_Decode_CF_Commas($Option);
											$Counter++;
										} 
										$ReturnString .= "</td>";
									} 
									elseif ($Field->Field_Type == "checkbox") {
										$Counter = 0;
										$Options = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Field->Field_Values)));
										$Values = UPCP_CF_Post_Explode(explode(",", UPCP_CF_Pre_Explode($Value)));
										$ReturnString .= "<td>";
										foreach ($Options as $Option) {
											if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
											$ReturnString .= "<input type='checkbox' name='" . $Field->Field_Name . "[]' value='" . $Option . "' class='upcp-checkbox' >" . UPCP_Decode_CF_Commas($Option) . "</br>";
											$Counter++;
										}
										$ReturnString .= "</td>";
									}
									elseif ($Field->Field_Type == "file") {
										$ReturnString .= "<td><input name='" . $Field->Field_Name . "' class='upcp-file-input' type='file' /><br/>";
									}
									elseif ($Field->Field_Type == "date") {
										$ReturnString .= "<td><input name='" . $Field->Field_Name . "' class='upcp-date-input' type='date' /></td>";
									} 
									elseif ($Field->Field_Type == "datetime") {
										$ReturnString .= "<td><input name='" . $Field->Field_Name . "' class='upcp-datetime-input' type='datetime-local' /></td>";
									}
								}
								echo $ReturnString;
								?>
							</table>
						</div>
					</div>

					<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box ewd-upcp-admin-widget-box-start-closed" id="ewd-upcp-admin-edit-product-other-products-widget-box">
						<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Other Products', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
						<div class="ewd-upcp-dashboard-new-widget-box-bottom">
							<table class="form-table">
								<?php $RelatedDisabled = ""; if ($Related_Products != "Manual") {$RelatedDisabled = "disabled";} ?>
								<tr>
									<th><label for="Item_Related_Products"><?php _e("Related Products", 'ultimate-product-catalogue') ?></label></th>
									<td>
									<label title='Product ID'></label><input type='text' name='Item_Related_Products_1' <?php echo $RelatedDisabled; ?>/><br />
									<label title='Product ID'></label><input type='text' name='Item_Related_Products_2' <?php echo $RelatedDisabled; ?>/><br />
									<label title='Product ID'></label><input type='text' name='Item_Related_Products_3' <?php echo $RelatedDisabled; ?>/><br />
									<label title='Product ID'></label><input type='text' name='Item_Related_Products_4' <?php echo $RelatedDisabled; ?>/><br />
									<label title='Product ID'></label><input type='text' name='Item_Related_Products_5' <?php echo $RelatedDisabled; ?>/><br />
									<p><?php _e("What products are related to this one if set to manual related products? (premium feature, input product IDs)", 'ultimate-product-catalogue') ?></p>
									</td>
								</tr>
								
								<?php if ($Next_Previous != "Manual") {$NextPreviousDisabled = "disabled";} ?>
								<tr>
									<th><label for="Item_Related_Products"><?php _e("Next/Previous Products", 'ultimate-product-catalogue') ?></label></th>
									<td>
									<label title='Product ID'>Next Product ID:</label><input type='text' name='Item_Next_Product' <?php echo $NextPreviousDisabled; ?>/><br />
									<label title='Product ID'>Previous Product ID:</label><input type='text' name='Item_Previous_Product' <?php echo $NextPreviousDisabled; ?>/><br />
									<p><?php _e("What products should be listed as the next/previous products? (premium feature, input product IDs)", 'ultimate-product-catalogue') ?></p>
									</td>
								</tr>
							</table>
						</div>
					</div>

				</div> <!-- edit-product-right -->
			</form>

			<div class="ewd-upcp-admin-edit-product-left">

				<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box ewd-upcp-admin-edit-product-left-full-widget-box<?php echo ( empty($Images) ? ' ewd-upcp-admin-widget-box-start-closed' : '' ); ?>" id="ewd-upcp-admin-edit-product-add-images-widget-box">
					<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Additional Product Images', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
					<div class="ewd-upcp-dashboard-new-widget-box-bottom">
						<?php if ($Full_Version == "Yes") { ?>
							<div>
								<?php _e("Save product first before adding additional images.", 'ultimate-product-catalogue'); ?>
							</div>
						<?php } else { ?>
							<div class="Explanation-Div">
								<h2><?php _e("Full Version Required!", 'ultimate-product-catalogue') ?></h2>
								<div class="upcp-full-version-explanation">
									<?php _e("The full version of the Ultimate Product Catalog Plugin is required to add additional product images.", 'ultimate-product-catalogue');?><a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/"><?php _e(" Please upgrade to unlock this page!", 'ultimate-product-catalogue'); ?></a>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

				<?php $ItemVideos = $wpdb->get_results($wpdb->prepare("SELECT * FROM $item_videos_table_name WHERE Item_ID='%d' ORDER BY Item_Video_Order ASC", $Product->Item_ID)); ?>
				<div class="ewd-upcp-dashboard-new-widget-box ewd-widget-box-full ewd-upcp-admin-closeable-widget-box ewd-upcp-admin-edit-product-left-full-widget-box<?php echo ( empty($ItemVideos) ? ' ewd-upcp-admin-widget-box-start-closed' : '' ); ?>" id="ewd-upcp-admin-edit-product-add-videos-widget-box">
					<div class="ewd-upcp-dashboard-new-widget-box-top"><?php _e('Add Product Videos', 'ultimate-product-catalogue'); ?><span class="ewd-upcp-admin-edit-product-down-caret">&nbsp;&nbsp;&#9660;</span><span class="ewd-upcp-admin-edit-product-up-caret">&nbsp;&nbsp;&#9650;</span></div>
					<div class="ewd-upcp-dashboard-new-widget-box-bottom">
						<?php if ($Full_Version == "Yes") { ?>
							<div>
								<?php _e("Save product first before adding videos.", 'ultimate-product-catalogue'); ?>
							</div>
							    
						<?php } else { ?>
							<div class="Explanation-Div">
								<h2><?php _e("Full Version Required!", 'ultimate-product-catalogue') ?></h2>
								<div class="upcp-full-version-explanation">
									<?php _e("The full version of the Ultimate Product Catalog Plugin is required to add additional product images.", 'ultimate-product-catalogue');?><a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/"><?php _e(" Please upgrade to unlock this page!", 'ultimate-product-catalogue'); ?></a>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

			</div> <!-- edit-product-left -->

		</div>



	</div>