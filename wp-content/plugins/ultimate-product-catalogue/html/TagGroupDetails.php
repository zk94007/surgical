<?php $Tag_Group = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tag_groups_table_name WHERE Tag_Group_ID ='%d'", $_GET['Tag_Group_ID'])); ?>

		<div class="OptionTab ActiveTab" id="EditTag">
			<div id="col-right">
				<div class="col-wrap">
					<div id="add-page" class="postbox metabox-holder" >
					<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span><?php _e("Tags in Tag Group", 'ultimate-product-catalogue') ?></span></h3>
						<div class="inside">
							<div id="posttype-page" class="posttypediv">

								<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">
									<ul id="pagechecklist-most-recent" class="categorychecklist form-no-clear">
									<?php 
										$Tags = $wpdb->get_results($wpdb->prepare("SELECT * FROM $tags_table_name WHERE Tag_Group_ID='%d'", $_GET['Tag_Group_ID']));
										foreach ($Tags as $Tag) {
											echo "<li><label class='tag-title'><a href='admin.php?page=UPCP-options&Action=UPCP_Tag_Details&Selected=Tag&Tag_ID=" . $Tag->Tag_ID . "'>" . $Tag->Tag_Name . "</a></label></li>";
										}
									?>
									</ul>
								</div><!-- /.tabs-panel -->
							</div><!-- /.posttypediv -->
						</div>
					</div>
			</div>
		</div><!-- col-right -->

		<div class="form-wrap TagGroupDetail">
        	<a href="admin.php?page=UPCP-options&DisplayPage=Tags" class="NoUnderline">&#171; <?php _e("Back", 'ultimate-product-catalogue') ?></a>
			<h3>Edit  <?php echo $Tag_Group->Tag_Group_Name; echo"( ID:"; echo $Tag_Group->Tag_Group_ID; echo" )";?></h3>
			<form id="edittaggroup" method="post" action="admin.php?page=UPCP-options&Action=UPCP_EditTagGroup&Update_Item=Tag_Group&Tag_Group_ID=<?php echo $Tag_Group->Tag_Group_ID; ?>" class="validate" enctype="multipart/form-data">
			<input type="hidden" name="action" value="Edit_Tag_Group" />
			<input type="hidden" name="Tag_Group_ID" value="<?php echo $Tag_Group->Tag_Group_ID; ?>" />
 			<?php wp_nonce_field('UPCP_Tag_Group_Nonce', 'UPCP_Tag_Group_Nonce'); ?>
 			<?php wp_referer_field(); ?>

 			<div class='form-field'>
				<label for="Tag_Group_Name"><?php _e("Tag Group Name", 'ultimate-product-catalogue') ?></label>
				<input name="Tag_Group_Name" id="Tag_Group_Name" type="text" value="<?php echo $Tag_Group->Tag_Group_Name;?>" size="60" />
				<p><?php _e("The name of the group of tags that have similar properties.", 'ultimate-product-catalogue') ?></p>
			</div>

			<div class='form-field'>
				<label for="Tag_Group_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
				<textarea name="Tag_Group_Description" id="Tag_Group_Description" rows="5" cols="40"><?php echo $Tag_Group->Tag_Group_Description;?></textarea>
				<p><?php _e("The description of the tag group. What tags should be included in this group?", 'ultimate-product-catalogue') ?></p>
 			</div>

 			<label for="Tag_Group_Display_Status"><?php _e("Display Tag Group", 'ultimate-product-catalogue') ?></label>
            <label title='Yes'><input type='radio' name='Display_Tag_Group' value='Yes' <?php if($Tag_Group->Display_Tag_Group == "Yes") {echo "checked='checked'";} ?> /> <span>Show</span></label>
            <label title='No'><input type='radio' name='Display_Tag_Group' value='No' <?php if($Tag_Group->Display_Tag_Group == "No") {echo "checked='checked'";} ?> /> <span>Hide</span></label>
            <p><?php _e("Should this tag group be displayed on the page?", 'ultimate-product-catalogue') ?></p>
            <br />
 			<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'ultimate-product-catalogue') ?>"  /></p>
 			</form>
 		</div>
