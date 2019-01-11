<?php $Tag = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tags_table_name WHERE Tag_ID ='%d'", $_GET['Tag_ID'])); ?>
		
		<div class="OptionTab ActiveTab" id="EditTag">
				
				<div id="col-right">
				<div class="col-wrap">
				<div id="add-page" class="postbox metabox-holder" >
				<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span><?php _e("Products in Tag", 'ultimate-product-catalogue') ?></span></h3>
				<div class="inside">
				<div id="posttype-page" class="posttypediv">

				<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">
				<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
				<?php $Tagged_Items = $wpdb->get_results($wpdb->prepare("SELECT Item_ID FROM $tagged_items_table_name WHERE Tag_ID='%d'", $_GET['Tag_ID']));
							foreach ($Tagged_Items as $Tagged_Item) {
									$Product = $wpdb->get_row("SELECT Item_ID, Item_Name FROM $items_table_name WHERE Item_ID=" . $Tagged_Item->Item_ID);
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
				<div class="form-wrap TagDetail">
						<a href="admin.php?page=UPCP-options&DisplayPage=Tags" class="NoUnderline">&#171; <?php _e("Back", 'ultimate-product-catalogue') ?></a>
						<h3>Edit  <?php echo $Tag->Tag_Name; echo"( ID:"; echo $Tag->Tag_ID; echo" )";?></h3>
						<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_EditTag&Update_Item=Tag&Tag_ID=<?php echo $Tag->Tag_ID; ?>" class="validate" enctype="multipart/form-data">
						<input type="hidden" name="action" value="Edit_Tag" />
						<input type="hidden" name="Tag_ID" value="<?php echo $Tag->Tag_ID; ?>" />
						<input type="hidden" name="WC_term_id" value="<?php echo $Tag->Tag_WC_ID; ?>" />
						<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
						<?php wp_referer_field(); ?>
						<div class='form-field'>
								<label for="Tag_Name"><?php _e("Name", 'ultimate-product-catalogue') ?></label>
								<input name="Tag_Name" id="Tag_Name" type="text" value="<?php echo $Tag->Tag_Name;?>" size="60" />
								<p><?php _e("The name of the tag your users will see and search for.", 'ultimate-product-catalogue') ?></p>
						</div>
						<div class='form-field'>
								<label for="Tag_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
								<textarea name="Tag_Description" id="Tag_Description" rows="5" cols="40"><?php echo $Tag->Tag_Description;?></textarea>
								<p><?php _e("The description of the tag. What products are included in this?", 'ultimate-product-catalogue') ?></p>
						</div>

						<div class='form-field'>
                        	<label for="Tag_Group"><?php _e("Tag Group:", 'ultimate-product-catalogue') ?></label>
                            <select name="Tag_Group_ID" id="Tag_Group_ID">
                            <option value="0">Uncategorized Tags</option>
                            <?php 
                            	if ($Tag->Tag_Group_ID != "") {
                                    $TagGroups = $wpdb->get_results("SELECT * FROM $tag_groups_table_name ORDER BY Tag_Group_Order");
                                    $TaggedItem = $wpdb->get_results("SELECT * FROM $tagged_item_table_name");
                                    	foreach ($TagGroups as $TagGroup) {
                                        	if($TagGroup->Tag_Group_ID != 0){
                                        	    echo "<option value='" . $TagGroup->Tag_Group_ID . "' ";
                                        	    if ($TagGroup->Tag_Group_ID == $Tag->Tag_Group_ID) {echo "selected='selected'";}
                                        	    echo " >" . $TagGroup->Tag_Group_Name . "</option>";
                                        	} 
                                    	}
                                } 
                            ?>
                            </select>
						</div>

						<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'ultimate-product-catalogue') ?>"  /></p>
						</form>
				</div>
				</div>
				</div>
		</div>