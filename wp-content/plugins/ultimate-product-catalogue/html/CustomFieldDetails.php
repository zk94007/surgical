<?php $Field = $wpdb->get_row($wpdb->prepare("SELECT * FROM $fields_table_name WHERE Field_ID ='%d'", $_GET['Field_ID'])); ?>
		
		<div class="OptionTab ActiveTab" id="EditCustomField">
				
				<div id="col-left">
				<div class="col-wrap">
				<div class="form-wrap TagDetail">
						<a href="admin.php?page=UPCP-options&DisplayPage=CustomFields" class="NoUnderline">&#171; <?php _e("Back", 'ultimate-product-catalogue') ?></a>
						<h3>Edit <?php echo $Field->Field_Name; echo "( ID: "; echo $Field->Field_ID; echo" )"; ?></h3>
						<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_EditCustomField&DisplayPage=CustomFields" class="validate" enctype="multipart/form-data">
						<input type="hidden" name="action" value="Edit_Custom_Field" />
						<input type="hidden" name="Field_ID" value="<?php echo $Field->Field_ID; ?>" />
						<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
						<?php wp_referer_field(); ?>
						<div class="form-field form-required">
								<label for="Field_Name"><?php _e("Name", 'ultimate-product-catalogue') ?></label>
								<input name="Field_Name" id="Field_Name" type="text" value="<?php echo $Field->Field_Name;?>" size="60" />
								<p><?php _e("The name of the field you will see.", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field form-required">
								<label for="Field_Slug"><?php _e("Slug", 'ultimate-product-catalogue') ?></label>
								<input name="Field_Slug" id="Field_Slug" type="text" value="<?php echo $Field->Field_Slug;?>" size="60" />
								<p><?php _e("An all-lowercase name that will be used to insert the field.", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Type"><?php _e("Type", 'ultimate-product-catalogue') ?></label>
								<select name="Field_Type" id="Field_Type">
										<option value='text' <?php if ($Field->Field_Type == "text") {echo "selected=selected";} ?>><?php _e("Short Text", 'ultimate-product-catalogue') ?></option>
										<option value='mediumint' <?php if ($Field->Field_Type == "mediumint") {echo "selected=selected";} ?>><?php _e("Integer", 'ultimate-product-catalogue') ?></option>
										<option value='link'><?php _e("Link", 'ultimate-product-catalogue') ?></option>
										<option value='select' <?php if ($Field->Field_Type == "select") {echo "selected=selected";} ?>><?php _e("Select Box", 'ultimate-product-catalogue') ?></option>
										<option value='radio' <?php if ($Field->Field_Type == "radio") {echo "selected=selected";} ?>><?php _e("Radio Button", 'ultimate-product-catalogue') ?></option>
										<option value='checkbox' <?php if ($Field->Field_Type == "checkbox") {echo "selected=selected";} ?>><?php _e("Checkbox", 'ultimate-product-catalogue') ?></option>
										<option value='textarea' <?php if ($Field->Field_Type == "textarea") {echo "selected=selected";} ?>><?php _e("Text Area", 'ultimate-product-catalogue') ?></option>
										<option value='file' <?php if ($Field->Field_Type == "file") {echo "selected=selected";} ?>><?php _e("File", 'ultimate-product-catalogue') ?></option>
										<option value='date' <?php if ($Field->Field_Type == "date") {echo "selected=selected";} ?>><?php _e("Date", 'ultimate-product-catalogue') ?></option>
										<option value='datetime' <?php if ($Field->Field_Type == "datetime") {echo "selected=selected";} ?>><?php _e("Date/Time", 'ultimate-product-catalogue') ?></option>
								</select>
								<p><?php _e("The input method for the field and type of data that the field will hold.", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
								<textarea name="Field_Description" id="Field_Description" rows="2" cols="40"><?php echo $Field->Field_Description;?></textarea>
								<p><?php _e("The description of the field, which you will see as the instruction for the field.", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Values"><?php _e("Input Values", 'ultimate-product-catalogue') ?></label>
								<input name="Field_Values" id="Field_Values" type="text" value="<?php echo $Field->Field_Values;?>"  size="60" />
								<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs. All values will be accepted if left blank.", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
								<label for="Field_Displays"><?php _e("Display?", 'ultimate-product-catalogue') ?></label>
								<select name="Field_Displays" id="Field_Displays">
										<option value='none' <?php if ($Field->Field_Displays == "none") {echo "selected=selected";} ?>><?php _e("None", 'ultimate-product-catalogue') ?></option>
										<option value='thumbs' <?php if ($Field->Field_Displays == "thumbs") {echo "selected=selected";} ?>><?php _e("Thumbnail View", 'ultimate-product-catalogue') ?></option>
										<option value='list' <?php if ($Field->Field_Displays == "list") {echo "selected=selected";} ?>><?php _e("List View", 'ultimate-product-catalogue') ?></option>
										<option value='details' <?php if ($Field->Field_Displays == "details") {echo "selected=selected";} ?>><?php _e("Details View", 'ultimate-product-catalogue') ?></option>
										<option value='both' <?php if ($Field->Field_Displays == "both") {echo "selected=selected";} ?>><?php _e("All", 'ultimate-product-catalogue') ?></option>
								</select>
								<p><?php _e("Should this field be displayed in any of the main catalog pages?", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
							<label for="Field_Searchable"><?php _e("Searchable?", 'ultimate-product-catalogue') ?></label>
							<input type='radio' name='Field_Searchable' value='No' <?php if($Field->Field_Searchable == "No") {echo "checked='checked'";} ?> /><span><?php _e("No", 'ultimate-product-catalogue')?></span><br />	
							<input type='radio' name='Field_Searchable' value='Yes' <?php if($Field->Field_Searchable == "Yes") {echo "checked='checked'";} ?> /><span><?php _e("Yes", 'ultimate-product-catalogue')?></span><br />
							<p><?php _e("Should this field be searchable in your catalogs?", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field<?php echo ($Field->Field_Searchable != 'Yes' ? ' upcp-hidden' : ''); ?>" id="ewd-upcp-admin-cf-control-type">
							<label for="Field_Control_Type"><?php _e("Control Type", 'ultimate-product-catalogue') ?></label>
							<select name="Field_Control_Type" id="Field_Control_Type">
									<option value='Checkbox' <?php if ($Field->Field_Control_Type == "Checkbox") {echo "selected=selected";} ?>><?php _e("Checkbox", 'ultimate-product-catalogue') ?></option>
									<option value='Radio' <?php if ($Field->Field_Control_Type == "Radio") {echo "selected=selected";} ?>><?php _e("Radio", 'ultimate-product-catalogue') ?></option>
									<option value='Dropdown' <?php if ($Field->Field_Control_Type == "Dropdown") {echo "selected=selected";} ?>><?php _e("Dropdown", 'ultimate-product-catalogue') ?></option>
									<option value='Slider' <?php if ($Field->Field_Control_Type == "Slider") {echo "selected=selected";} ?>><?php _e("Slider (Only works for integer type fields)", 'ultimate-product-catalogue') ?></option>
							</select>
							<p><?php _e("What type of control should this field use in the sidebar if it's searchable?", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
							<label for="Field_Display_Tabbed"><?php _e("Display in Tabbed Layout?", 'ultimate-product-catalogue') ?></label>
							<input type='radio' name='Field_Display_Tabbed' value='No' <?php if($Field->Field_Display_Tabbed == "No") {echo "checked='checked'";} ?> /><span><?php _e("No", 'ultimate-product-catalogue')?></span><br />	
							<input type='radio' name='Field_Display_Tabbed' value='Yes' <?php if($Field->Field_Display_Tabbed == "Yes") {echo "checked='checked'";} ?> /><span><?php _e("Yes", 'ultimate-product-catalogue')?></span><br />
							<p><?php _e("Should this field be displayed in the 'Additional Information' area of the tabbed view?", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class="form-field">
							<label for="Field_Display_Comparison"><?php _e("Display in Product Comparison?", 'ultimate-product-catalogue') ?></label>
							<input type='radio' name='Field_Display_Comparison' value='No' <?php if($Field->Field_Display_Comparison == "No") {echo "checked='checked'";} ?> /><span><?php _e("No", 'ultimate-product-catalogue')?></span><br />	
							<input type='radio' name='Field_Display_Comparison' value='Yes' <?php if($Field->Field_Display_Comparison == "Yes") {echo "checked='checked'";} ?> /><span><?php _e("Yes", 'ultimate-product-catalogue')?></span><br />
							<p><?php _e("Should this field be displayed when visitors do a product comparison (in product comparison is enabled)?", 'ultimate-product-catalogue') ?></p>
						</div>

						<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'ultimate-product-catalogue') ?>"  /></p>
						</form>
				</div>
				</div>
				</div>
		</div>