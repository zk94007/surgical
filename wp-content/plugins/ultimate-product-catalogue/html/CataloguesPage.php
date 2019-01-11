<div id="col-right">
<div class="col-wrap">

<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<!-- Display a list of the catalogues which have already been created -->
<?php 
			if (isset($_GET['Page']) and $_GET['DisplayPage'] == "Catalogues") {$Page = $_GET['Page'];}
			else {$Page = 1;}
			
			$Sql = "SELECT * FROM $catalogues_table_name ";
				if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Catalogues") {$Sql .= "ORDER BY " . $_GET['OrderBy'] . " " . $_GET['Order'] . " ";}
				else {$Sql .= "ORDER BY Catalogue_Name ";}
				$Sql .= "LIMIT " . ($Page - 1)*20 . ",20";
				$myrows = $wpdb->get_results($Sql);
				$TotalCatalogues = $wpdb->get_results("SELECT Catalogue_ID FROM $catalogues_table_name");
				$num_rows = $wpdb->num_rows; 
				$Number_of_Pages = ceil($wpdb->num_rows/20);
				$Current_Page_With_Order_By = "admin.php?page=UPCP-options&DisplayPage=Catalogues";
				if (isset($_GET['OrderBy'])) {$Current_Page_With_Order_By .= "&OrderBy=" .$_GET['OrderBy'] . "&Order=" . $_GET['Order'];}?>

<form action="admin.php?page=UPCP-options&Action=UPCP_MassDeleteCatalogues&DisplayPage=Catalogues" method="post">    
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-product-catalogue') ?></option>
						<option value='delete'><?php _e("Delete", 'ultimate-product-catalogue') ?></option>
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

<table class="wp-list-table striped widefat fixed tags sorttable" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Catalogue_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='shortcode' class='manage-column column-shortcode'  style="">
											  <span><?php _e("Shortcode", 'ultimate-product-catalogue') ?></span>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Catalogue_Item_Count" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Item_Count&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Item_Count&Order=ASC'>";} ?>
											  <span><?php _e("Products in Catalog", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Catalogue_Name" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Name&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Name&Order=ASC'>";} ?>
											  <span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						<th scope='col' id='shortcode' class='manage-column column-shortcode'  style="">
											  <span><?php _e("Shortcode", 'ultimate-product-catalogue') ?></span>
						</th>
						<th scope='col' id='requirements' class='manage-column column-requirements sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Catalogue_Item_Count" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Item_Count&Order=DESC'>";}
										 			else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Catalogues&OrderBy=Catalogue_Item_Count&Order=ASC'>";} ?>
											  <span><?php _e("Products in Catalog", 'ultimate-product-catalogue') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($myrows) { 
	  			  foreach ($myrows as $Catalogue) {
								echo "<tr id='Item" . $Catalogue->Catalogue_ID ."'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Catalogues_Bulk[]' value='" . $Catalogue->Catalogue_ID ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='admin.php?page=UPCP-options&Action=UPCP_Catalogue_Details&Selected=Catalogue&Catalogue_ID=" . $Catalogue->Catalogue_ID ."' title='Edit " . $Catalogue->Catalogue_Name . "'>" . ($Catalogue->Catalogue_Name != '' ? $Catalogue->Catalogue_Name : 'untitled')  . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								/*echo "<span class='edit'>";
								echo "<a href='admin.php?page=UPCP-options&Action=UPCP_Catalogue_Details&Selected=Catalogue&Catalogue_ID=" . $Catalogue->Catalogue_ID ."'>Edit</a>";
		 						echo " | </span>";*/
								echo "<span class='delete'>";
								echo "<a class='delete-tag confirm-delete' href='admin.php?page=UPCP-options&Action=UPCP_DeleteCatalogue&DisplayPage=Catalogues&Catalogue_ID=" . $Catalogue->Catalogue_ID ."'>" . __("Delete", 'ultimate-product-catalogue') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Catalogue->Catalogue_ID ."'>";
								echo "<div class='name'>" . $Catalogue->Catalogue_Name . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-description'>[product-catalogue id='" . $Catalogue->Catalogue_ID . "']</td>";
								echo "<td class='description column-items-count'>" . $Catalogue->Catalogue_Item_Count . "</td>";
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
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div>

<!-- Form to create a new catalogue -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h3><?php _e("Add a New Catalog", 'ultimate-product-catalogue') ?></h3>
<form id="addtag" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddCatalogue&DisplayPage=Catalogue" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Catalogue" />
<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Catalogue_Name"><?php _e("Name", 'ultimate-product-catalogue') ?></label>
	<input name="Catalogue_Name" id="Catalogue_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the catalog. This is for your own internal use, and to insert the catalog into a page or post.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Catalogue_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
	<textarea name="Catalogue_Description" id="Catalogue_Description" rows="5" cols="40"></textarea>
	<p><?php _e("The description of the catalog. What will it be used to display?", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Catalogue_Custom_CSS"><?php _e("Custom CSS", 'ultimate-product-catalogue') ?></label>
	<textarea name="Catalogue_Custom_CSS" id="Catalogue_Custom_CSS" rows="5" cols="40"></textarea>
	<p><?php _e("Custom CSS styles that should be applied to this catalog.", 'ultimate-product-catalogue') ?></p>
</div>

<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Catalog', 'ultimate-product-catalogue') ?>"  /></p></form></div>
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
		