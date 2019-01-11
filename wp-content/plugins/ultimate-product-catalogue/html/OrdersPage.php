<div id="col-right">
<div class="col-wrap">


<!-- Display a list of the categories which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
	$params = array(
		'posts_per_page' => -1, 
		'post_type' => 'upcp-order',
		'orderby' => 'title'
	);
	if (isset($_GET['OrderBy']) and $_GET['DisplayPage'] == "Orders") {
		$params['orderby'] = $_GET['OrderBy'];
		$params['order'] = $_GET['Order'];
	}
	$Orders = get_posts($params);
?>

<form action="admin.php?page=UPCP-options&Action=UPCP_MassOrdersAction&DisplayPage=Orders" method="post">   
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'ultimate-product-catalogue') ?></option>
						<option value='delete'><?php _e("Delete", 'ultimate-product-catalogue') ?></option>
						<option value='hide'><?php _e("Hide", 'ultimate-product-catalogue') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'ultimate-product-catalogue') ?>"  />
		</div>
</div>

<table class="wp-list-table widefat fixed tags sorttable orders-list" cellspacing="0">
	<thead>
		<tr>
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "title" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=title&Order=DESC'>";}
				 	else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=title&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-date  desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "post_date" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=post_date&Order=DESC'>";}
				 	else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=post_date&Order=ASC'>";} 
				?>
				<span><?php _e("Order Date", 'ultimate-product-catalogue') ?></span>
			</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "title" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=title&Order=DESC'>";}
				 	else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=title&Order=ASC'>";} 
				?>
					<span><?php _e("Name", 'ultimate-product-catalogue') ?></span>
					<span class="sorting-indicator"></span>
				</a>
			</th>
			<th scope='col' id='description' class='manage-column column-date  desc'  style="">
				<?php 
					if ($_GET['OrderBy'] == "post_date" and $_GET['Order'] == "ASC") { echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=post_date&Order=DESC'>";}
				 	else {echo "<a href='admin.php?page=UPCP-options&DisplayPage=Orders&OrderBy=post_date&Order=ASC'>";} 
				?>
				<span><?php _e("Order Date", 'ultimate-product-catalogue') ?></span>
			</th>
		</tr>
	</tfoot>

	<tbody id="the-list" class='list:tag'>
		
	<?php
		if ($Orders) { 
	  		foreach ($Orders as $Order) {
				echo "<tr id='order-item-" . $Order->ID ."' class='order-list-item'>";
				echo "<th scope='row' class='check-column'>";
				echo "<input type='checkbox' name='Orders_Bulk[]' value='" . $Order->ID ."' />";
				echo "</th>";
				echo "<td class='name column-name'>";
				echo "<strong>";
				echo "<a class='row-title' href='admin.php?page=UPCP-options&Action=UPCP_OrderDetails&Selected=Order&Order_ID=" . $Order->ID ."' title='Edit " . $Order->post_title . "'>" . $Order->post_title . "</a></strong>";
				echo "<br />";
				echo "<div class='row-actions'>";
				/*echo "<span class='edit'>";
				echo "<a href='admin.php?page=UPCP-options&Action=UPCP_Category_Details&Selected=Category&Category_ID=" . $Category->Category_ID ."'>Edit</a>";
	 			echo " | </span>";*/
				echo "<span class='delete'>";
				echo "<a class='delete-tag' href='admin.php?page=UPCP-options&Action=UPCP_DeleteOrder&DisplayPage=Orders&Order_ID=" . $Order->ID ."'>" . __("Delete", 'ultimate-product-catalogue') . "</a>";
	 			echo "</span>";
				echo "</div>";
				echo "<div class='hidden' id='inline_" . $Order->ID ."'>";
				echo "<div class='name'>" . $Order->post_title . "</div>";
				echo "</div>";
				echo "</td>";
				echo "<td class='description column-date'>" . $Order->post_date . "</td>";
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
						<option value='hide'><?php _e("Hide", 'ultimate-product-catalogue') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div>

<!-- Form to create a new location -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h3><?php _e("Add a New Order", 'ultimate-product-catalogue') ?></h3>
<form id="addcat" method="post" action="admin.php?page=UPCP-options&Action=UPCP_AddOrder&DisplayPage=Orders" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Order" />
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Order_Name"><?php _e("Name", 'ultimate-product-catalogue') ?></label>
	<input name="Order_Name" id="Order_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the order that will be displayed.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field">
	<label for="Order_Description"><?php _e("Description", 'ultimate-product-catalogue') ?></label>
	<textarea name="Order_Description" id="Order_Description" rows="5" cols="40"></textarea>
	<p><?php _e("The description of the order, to help with processing it.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field form-required">
	<label for="Order_Items"><?php _e("Items", 'ultimate-product-catalogue') ?></label>
	<input name="Order_Items" id="Order_Items" type="text" value="" size="60" />
	<p><?php _e("The items that were purchased in the order.", 'ultimate-product-catalogue') ?></p>
</div>
<div class="form-field form-required">
	<label for="Order_Sales_Boolean"><?php _e("Sale?", 'ultimate-product-catalogue') ?></label>
	<input name="Order_Sales_Boolean" id="Order_Sales_Boolean" type="radio" value="Yes"/>Yes<br/>
	<input name="Order_Sales_Boolean" id="Order_Sales_Boolean" type="radio" value="No"/>No
	<p><?php _e("The items that were purchased in the order.", 'ultimate-product-catalogue') ?></p>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Order', 'ultimate-product-catalogue') ?>"  /></p></form></div>
<br class="clear" />
</div>
</div>