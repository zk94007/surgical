<?php if ($Full_Version == "Yes") { ?>
<div id="col-right">
<div class="col-wrap">

<!-- Display a list of the tags which have already been created -->
<?php wp_referer_field(); ?>

<?php 
	global $wpdb,$TagGroups,$TagGroupName;

	if (isset($_GET['Page']) and $_GET['DisplayPage'] == "Tags") {$Page = $_GET['Page'];}
	else {$Page = 1;}
	
	$Sql = "SELECT * FROM $tags_table_name ";
	if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Tags") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
	else {$Sql .= "ORDER BY Tag_Sidebar_Order,Tag_Name ";}
	$Sql .= "LIMIT " . ($Page - 1)*200 . ",200";
	$myrows = $wpdb->get_results($Sql);
	$TotalProducts = $wpdb->get_results("SELECT Tag_ID FROM $tags_table_name");
	$num_rows = $wpdb->num_rows; 
	$Number_of_Pages = ceil($wpdb->num_rows/200);
	$Current_Page_With_Order_By = "admin.php?page=UPCP-options&DisplayPage=Tags";
	if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}
?>

<form action="admin.php?page=UPCP-options&Action=UPCP_MassDeleteTags&DisplayPage=Tags" method="post"> 
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-product-catalogue')?></option>
						<option value='delete'><?php _e("Delete", 'ultimate-product-catalogue') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
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

<table class="wp-list-table striped widefat fixed tags sorttable tags-list" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Tag_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Tag_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Tag_Item_Count" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Item_Count&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Item_Count&Order=ASC'>";} ?>
											  <span><?php _e("Products Tagged", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='groups' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Tag_Group_ID" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Group_ID&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Group_ID&Order=ASC'>";} ?>
											  <span><?php _e("Tag Group", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Tag_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Tag_Description" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Description&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Tag_Item_Count" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Item_Count&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Item_Count&Order=ASC'>";} ?>
											  <span><?php _e("Products Tagged", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='groups' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Tag_Group_ID" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Group_ID&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Tags&OrderBy=Tag_Group_ID&Order=ASC'>";} ?>
											  <span><?php _e("Tag Group", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($myrows) {
	  			  foreach ($myrows as $Tag) {
								echo "<tr id='tag-list-item-" . $Tag->Tag_ID ."' class='tag-list-item'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Tags_Bulk[]' value='" . $Tag->Tag_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=UPCP-options&Action=UPCP_Tag_Details&Selected=Tag&Tag_ID=" . $Tag->Tag_ID ."' title='Edit " . $Tag->Tag_Name . "'>" . $Tag->Tag_Name . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								/*echo "<span class='edit'>";
								echo "<a href='admin.php?page=UPCP-options&Action=UPCP_Tag_Details&Selected=Tag&Tag_ID=" . $Tag->Tag_ID ."'>Edit</a>";
		 						echo " | </span>";*/
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='admin.php?page=UPCP-options&Action=UPCP_DeleteTag&DisplayPage=Tags&Tag_ID=" . $Tag->Tag_ID ."'>" . __("Delete", 'ultimate-product-catalogue') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Tag->Tag_ID ."'>";
								echo "<div class='name'>" . $Tag->Tag_Name . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-description'>" . $Tag->Tag_Description . "</td>";
								echo "<td class='description column-items-count'>" . $Tag->Tag_Item_Count . "</td>";
								if ($Tag->Tag_Group_ID != 0) {
									$TagGroupName = $wpdb->get_row("SELECT * FROM $tag_groups_table_name WHERE Tag_Group_ID='".$Tag->Tag_Group_ID."'");
									echo "<td class='description column-group'>" . $TagGroupName->Tag_Group_Name . "</td>";
								} else {
									echo "<td class='description column-group'>Not assigned a group</td>";
								};
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
						<option value='MassDelete'><?php _e("Delete", 'ultimate-product-catalogue') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'ultimate-product-catalogue')?>"  />
		</div>
		<div class='tablenav-pages <?php if ($Number_of_Pages == 1) {echo "one-page";} ?>'>
				<span class="displaying-num"><?php echo $wpdb->num_rows; ?> <?php _e("items", 'ultimate-product-catalogue') ?></span>
				<span class='pagination-links'>
						<a class='first-page <?php if ($Page == 1) {echo "disabled";} ?>' title='Go to the first page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=1'>&laquo;</a>
						<a class='prev-page <?php if ($Page <= 1) {echo "disabled";} ?>' title='Go to the previous page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page-1;?>'>&lsaquo;</a>
						<span class="paging-input"><?php echo $Page; ?> <?php _e("of", 'ultimate-product-catalogue') ?> <span class='total-pages'><?php echo $Number_of_Pages; ?></span></span>
						<a class='next-page <?php if ($Page >= $Number_of_Pages) {_e("disabled", 'ultimate-product-catalogue');} ?>' title='Go to the next page' href='<?php echo $Current_Page_With_Order_By; ?>&Page=<?php echo $Page+1;?>'>&rsaquo;</a>
						<a class='last-page <?php if ($Page == $Number_of_Pages) {_e("disabled", 'ultimate-product-catalogue');} ?>' title='Go to the last page' href='<?php echo $Current_Page_With_Order_By . "&Page=" . $Number_of_Pages; ?>'>&raquo;</a>
				</span>
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div>

<!-- Form to create a new tag -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h3><?php _e("Add a New Tag", 'ultimate-product-catalogue') ?></h3>
<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddTag&DisplayPage=Tag" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Tag" />
<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Tag_Name"><?php _e("Name", 'ultimate-product-catalogue')?></label>
	<input name="Tag_Name" id="Tag_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the tag for your own purposes.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Tag_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
	<textarea name="Tag_Description" id="Tag_Description" rows="5" cols="40"></textarea>
	<p><?php _e("The description of the tag. What will it be used to display?", 'ultimate-product-catalogue') ?></p>
</div>

<div>
	<label for="Tag_Group"><?php _e("Tag Group:", 'ultimate-product-catalogue') ?></label>
	<select name="Tag_Group_ID" id="Tag_Group_ID">
	<option value="0">Uncategorized Tags</option>
	<?php 
		$TagGroups = $wpdb->get_results("SELECT * FROM $tag_groups_table_name ORDER BY Tag_Group_Order");
		$TaggedItem = $wpdb->get_results("SELECT * FROM $tagged_items_table_name");
		foreach ($TagGroups as $TagGroup) {
			if($TagGroup->Tag_Group_ID != 0){
				echo "<option value='" . $TagGroup->Tag_Group_ID . "' ";
				echo ">" . $TagGroup->Tag_Group_Name . "</option>";
			} 
		}
	?>
	</select>
    <p><?php _e("Assign the tag to a group",'ultimate-product-catalogue') ?></p>
</div>

<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Tag', 'ultimate-product-catalogue') ?>"  /></p></form></div>
<br class="clear" />
</div>
</div>

<!-- Form to create new tag group -->
<div id="col-left">
<div class="col-wrap">
 
<div class="form-wrap">
<h3><?php _e("Add a New Tag Group", 'ultimate-product-catalogue') ?></h3>
<form id="addtaggroup" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddTagGroup&DisplayPage=Tag" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Tag_Group" />
<?php wp_nonce_field('UPCP_Tag_Group_Nonce', 'UPCP_Tag_Group_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Tag_Group_Name"><?php _e("New Tag Group",'ultimate-product-catalogue') ?></label>
    <input name="Tag_Group_Name" id="Tag_Group_Name" type="text" value="" size="60" />
    <p><?php _e("Create a name for the new tag group",'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Tag_Group_Description"><?php _e("Tag Group Description", 'ultimate-product-catalogue') ?></label>
	<textarea name="Tag_Group_Description" id="Tag_Group_Description" rows="5" cols="40"></textarea>
	<p><?php _e("What tags should belong to this group?", 'ultimate-product-catalogue') ?></p>
</div>
<label for="Tag_Group_Display_Status"><?php _e("Display Tag Group", 'ultimate-product-catalogue') ?></label>
<label title='Yes'><input type='radio' name='Display_Tag_Group' value='Yes' checked='checked' /> <span>Show</span></label>
<label title='No'><input type='radio' name='Display_Tag_Group' value='No' /> <span>Hide</span></label>
<p><?php _e("Should this tag group be displayed on the page?", 'ultimate-product-catalogue') ?></p>
<br />
<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Tag Group', 'ultimate-product-catalogue') ?>"  /></p></form></div>
<br class="clear" />
</div>
</div>

<!-- Form to edit tag group -->
<div id="col-left">
    <div class="col-wrap">
        <div class="form-wrap">
			<?php $EditTagGroups = $wpdb->get_results("SELECT * FROM $tag_groups_table_name ORDER BY Tag_Group_Order");
            ?>
        	<h3><?php _e("Edit Tag Group", 'ultimate-product-catalogue') ?></h3>
        		<label for="Edit_Tag_Group"><?php _e("Edit Tag Group:", 'ultimate-product-catalogue') ?></label>
                <table class="wp-list-table widefat tags sorttable tag-group-list" style="width:100%;">
            <thead>
                <tr>
                    <th><?php _e("Edit/Delete", 'ultimate-product-catalogue') ?></th>
                    <th><?php _e("Tag Group Name", 'ultimate-product-catalogue') ?></th>
                    <th><?php _e("Tag Group Description", 'ultimate-product-catalogue') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($EditTagGroups as $EditTagGroup){
				$TagGroupID = $EditTagGroup->Tag_Group_ID;
				$TagGroupName = $EditTagGroup->Tag_Group_Name;
				$TagGroupDescription = $EditTagGroup->Tag_Group_Description;
				if($TagGroupID != 0){?>
                    <tr id="list-item-<?php echo $TagGroupID; ?>" class="list-item-tag-group">
                        <td class="tag-group-edit-delete"><a href="admin.php?page=UPCP-options&Action=UPCP_Tag_Groups&Selected=Tag_Group&Tag_Group_ID=<?php echo $TagGroupID; ?>"><?php _e("Edit", 'ultimate-product-catalogue') ?></a>&nbsp;|&nbsp;<a href="admin.php?page=UPCP-options&Action=UPCP_DeleteTagGroup&DisplayPage=Tags&Tag_Group_ID=<?php echo $TagGroupID; ?>" class="confirm-delete"><?php _e("Delete", 'ultimate-product-catalogue') ?></a></td>
                        <td class="tag-group-name"><p><?php echo $TagGroupName; ?></p></td>
                        <td class="tag-group-description" style="width:35%;"><p><?php echo $TagGroupDescription; ?></p></td>
						</tr>
                <?php }
				}
			?>
            </tbody>
            <tfoot>
                <tr>
                    <th><?php _e("Edit/Delete", 'ultimate-product-catalogue') ?></th>
                    <th><?php _e("Tag Group Name", 'ultimate-product-catalogue') ?></th>
                    <th><?php _e("Tag Group Description", 'ultimate-product-catalogue') ?></th>
                </tr>
            </tfoot>
    	</table>
        </div>
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
<?php } else { ?>
<div class="Info-Div">
		<h2><?php _e("Full Version Required!", 'ultimate-product-catalogue') ?></h2>
		<div class="upcp-full-version-explanation">
				<?php _e("The full version of the Ultimate Product Catalog Plugin is required to use tags.", 'ultimate-product-catalogue');?><a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/"><?php _e(" Please upgrade to unlock this page!", 'ultimate-product-catalogue'); ?></a>
		</div>
</div>
<?php } ?>	