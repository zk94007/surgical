<?php
	/* Basic Options */
	$Color = get_option("UPCP_Color_Scheme");
	$Thumb_Auto_Adjust = get_option("UPCP_Thumb_Auto_Adjust");
	$Currency_Symbol = get_option("UPCP_Currency_Symbol");
	$Currency_Symbol_Location = get_option("UPCP_Currency_Symbol_Location");
	$Links = get_option("UPCP_Product_Links");
	$Tags = get_option("UPCP_Tag_Logic");
	$Price_Filter = get_option("UPCP_Price_Filter");
	$Slider_Filter_Inputs = get_option("UPCP_Slider_Filter_Inputs");
	$Sale_Mode = get_option("UPCP_Sale_Mode");
	$ReadMore = get_option("UPCP_Read_More");
	$Detail_Desc_Chars = get_option("UPCP_Desc_Chars");
	$Sidebar_Order = get_option("UPCP_Sidebar_Order");
	$Filter_Title = get_option("UPCP_Filter_Title");
	$Detail_Image = get_option("UPCP_Details_Image");
	$CaseInsensitiveSearch = get_option("UPCP_Case_Insensitive_Search");
	$Apply_Contents_Filter = get_option("UPCP_Apply_Contents_Filter");
	$Maintain_Filtering = get_option("UPCP_Maintain_Filtering");
	$Single_Page_Price = get_option("UPCP_Single_Page_Price");
	$Thumbnail_Support = get_option("UPCP_Thumbnail_Support");
	$Show_Category_Descriptions = get_option("UPCP_Show_Category_Descriptions");
	$Show_Catalogue_Information = get_option("UPCP_Show_Catalogue_Information");
	$Inner_Filter = get_option("UPCP_Inner_Filter");
	$Clear_All = get_option("UPCP_Clear_All");
    $Hide_Empty_Options = get_option("UPCP_Hide_Empty_Options");
	$Extra_Elements_Array = get_option("UPCP_Extra_Elements");
	$Extra_Elements = explode(",", $Extra_Elements_Array);
	$Display_Category_Image = get_option("UPCP_Display_Category_Image");
	$Display_SubCategory_Image = get_option("UPCP_Display_SubCategory_Image");
	$Overview_Mode = get_option("UPCP_Overview_Mode");
	$Breadcrumbs = get_option("UPCP_Breadcrumbs");
	$Socialmedia_String = get_option("UPCP_Social_Media");
    $Socialmedia = explode(",", $Socialmedia_String);
	$Display_Categories_In_Thumbnails = get_option("UPCP_Display_Categories_In_Thumbnails");
	$Display_Tags_In_Thumbnails = get_option("UPCP_Display_Tags_In_Thumbnails");
	
	/* Premium Options */
	$InstallVersion = get_option("UPCP_First_Install_Version");
	$Custom_Product_Page = get_option("UPCP_Custom_Product_Page");
	$Product_Comparison = get_option("UPCP_Product_Comparison");
	$Product_Inquiry_Form = get_option("UPCP_Product_Inquiry_Form");
	$Product_Inquiry_Cart = get_option("UPCP_Product_Inquiry_Cart");
	$Inquiry_Form_Email = get_option("UPCP_Inquiry_Form_Email");
	$Product_Reviews = get_option("UPCP_Product_Reviews");
	$Catalog_Display_Reviews = get_option("UPCP_Catalog_Display_Reviews");
	$Lightbox = get_option("UPCP_Lightbox");
	$Lightbox_Mode = get_option("UPCP_Lightbox_Mode");
	$Hidden_Drop_Down_Sidebar_On_Mobile = get_option("UPCP_Hidden_Drop_Down_Sidebar_On_Mobile");
	$Infinite_Scroll = get_option("UPCP_Infinite_Scroll");
	$Products_Per_Page = get_option("UPCP_Products_Per_Page");
	$Pagination_Location = get_option("UPCP_Pagination_Location");
	$Product_Search = get_option("UPCP_Product_Search");
	$Product_Sort = get_option("UPCP_Product_Sort");
	if (!is_array($Product_Sort)) {$Product_Sort = array();}
	$CF_Conversion = get_option("UPCP_CF_Conversion");
	$Related_Products = get_option("UPCP_Related_Products");
	$Next_Previous = get_option("UPCP_Next_Previous");
	$Access_Role = get_option("UPCP_Access_Role");
	$Custom_Fields_Blank = get_option("UPCP_Custom_Fields_Blank");

	/* WooCommerce */
	$WooCommerce_Sync = get_option("UPCP_WooCommerce_Sync");
	$WooCommerce_Show_Cart_Count = get_option("UPCP_WooCommerce_Show_Cart_Count");
	$WooCommerce_Checkout = get_option("UPCP_WooCommerce_Checkout");
	$WooCommerce_Cart_Page = get_option("UPCP_WooCommerce_Cart_Page");
	$WooCommerce_Product_Page = get_option("UPCP_WooCommerce_Product_Page");
	$WooCommerce_Back_Link = get_option("UPCP_WooCommerce_Back_Link");

	/* Labelling Options */
	$Categories_Label = get_option("UPCP_Categories_Label");
	$SubCategories_Label = get_option("UPCP_SubCategories_Label");
	$Tags_Label = get_option("UPCP_Tags_Label");
	$Custom_Fields_Label = get_option("UPCP_Custom_Fields_Label");
	$Show_All_Label = get_option("UPCP_Show_All_Label");
	$Details_Label = get_option("UPCP_Details_Label");
	$Sort_By_Label = get_option("UPCP_Sort_By_Label");
	$Price_Ascending_Label = get_option("UPCP_Price_Ascending_Label");
	$Price_Descending_Label = get_option("UPCP_Price_Descending_Label");
	$Name_Ascending_Label = get_option("UPCP_Name_Ascending_Label");
	$Name_Descending_Label = get_option("UPCP_Name_Descending_Label");
	$Product_Name_Search_Label = get_option("UPCP_Product_Name_Search_Label");
	$Product_Search_Text_Label = get_option("UPCP_Product_Name_Text_Label");
	$Back_To_Catalogue_Label = get_option("UPCP_Back_To_Catalogue_Label");
	$Updating_Results_Label = get_option("UPCP_Updating_Results_Label");
	$No_Results_Found_Label = get_option("UPCP_No_Results_Found_Label");
	$Products_Pagination_Label = get_option("UPCP_Products_Pagination_Label");
	$Read_More_Label = get_option("UPCP_Read_More_Label");
	$Product_Details_Label = get_option("UPCP_Product_Details_Label");
	$Additional_Info_Label = get_option("UPCP_Additional_Info_Label");
	$Contact_Us_Label = get_option("UPCP_Contact_Us_Label");
	$Product_Inquiry_Form_Title_Label = get_option("UPCP_Product_Inquiry_Form_Title_Label");
	$Customer_Reviews_Tab_Label = get_option("UPCP_Customer_Reviews_Tab_Label");
	$Related_Products_Label = get_option("UPCP_Related_Products_Label");
	$Next_Product_Label = get_option("UPCP_Next_Product_Label");
	$Previous_Product_Label = get_option("UPCP_Previous_Product_Label");
	$Of_Pagination_Label = get_option("UPCP_Of_Pagination_Label");
	$Compare_Label = get_option("UPCP_Compare_Label");
	$Sale_Label = get_option("UPCP_Sale_Label");
	$Side_By_Side_Label = get_option("UPCP_Side_By_Side_Label");
	$Inquire_Button_Label = get_option("UPCP_Inquire_Button_Label");
	$Add_To_Cart_Button_Label = get_option("UPCP_Add_To_Cart_Button_Label");
	$Send_Inquiry_Label = get_option("UPCP_Send_Inquiry_Label");
	$Checkout_Label = get_option("UPCP_Checkout_Label");
	$Empty_Cart_Label = get_option("UPCP_Empty_Cart_Label");
	$Additional_Info_Category_Label = get_option("UPCP_Additional_Info_Category_Label");
	$Additional_Info_SubCategory_Label = get_option("UPCP_Additional_Info_SubCategory_Label");
	$Additional_Info_Tags_Label = get_option("UPCP_Additional_Info_Tags_Label");

	$Price_Filter_Label = get_option("UPCP_Price_Filter_Label");
	$Product_Inquiry_Please_Use_Label = get_option("UPCP_Product_Inquiry_Please_Use_Label");

	/* SEO Options */
	$PrettyLinks = get_option("UPCP_Pretty_Links");
	$Permalink_Base = get_option("UPCP_Permalink_Base");
	$XML_Sitemap_URL = get_option("UPCP_XML_Sitemap_URL");
	$SEO_Option = get_option("UPCP_SEO_Option");
	$SEO_Integration = get_option("UPCP_SEO_Integration");
	$SEO_Title = get_option("UPCP_SEO_Title");
	$Update_Breadcrumbs = get_option("UPCP_Update_Breadcrumbs");

	if (isset($_POST['Display_Tab'])) {$Display_Tab = $_POST['Display_Tab'];}
	else {$Display_Tab = "";}
?>
<div class="wrap upcp-options-page-tabbed">
<div class="upcp-options-submenu-div">
	<ul class="upcp-options-submenu upcp-options-page-tabbed-nav">
		<li><a id="Basic_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == '' or $Display_Tab == 'Basic') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Basic');">Basic</a></li>
		<li><a id="Premium_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Premium') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Premium');">Premium</a></li>
		<li><a id="WooCommerce_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'WooCommerce') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('WooCommerce');">WooCommerce</a></li>
		<li><a id="SEO_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'SEO') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('SEO');">SEO</a></li>
		<li><a id="Labelling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Labelling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Labelling');">Labelling</a></li>
	</ul>
</div>

<div class="upcp-options-page-tabbed-content">
<form method="post" action="admin.php?page=UPCP-options&DisplayPage=Options&Action=UPCP_UpdateOptions">
<?php wp_nonce_field('UPCP_Element_Nonce', 'UPCP_Element_Nonce'); ?>

<input type='hidden' name='Display_Tab' value='<?php echo $Display_Tab; ?>' />

<div id='Basic' class='upcp-option-set<?php echo ( ($Display_Tab == '' or $Display_Tab == 'Basic') ? '' : ' upcp-hidden' ); ?>'>
<h2 id="basic-options" class="upcp-options-tab-title"><?php _e('Basic Options', 'ultimate-product-catalogue'); ?></h2>

<br />

<div class="ewd-upcp-admin-section-heading"><?php _e('General', 'ultimate-product-catalogue'); ?></div>

<table id='general-options-table' class="form-table upcp-options-table">
	<tr>
	<th scope="row"><?php _e("Currency Symbol", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td >
		<fieldset><legend class="screen-reader-text"><span><?php _e("Currency Symbol", 'ultimate-product-catalogue')?></span></legend>
		<label><input type='text' name='currency_symbol' value='<?php echo $Currency_Symbol; ?>'/></label>
		<p><?php _e("What currency symbol, if any, should be displayed before or after the price? Leave blank for none.", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Currency Symbol Location", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td >
		<fieldset><legend class="screen-reader-text"><span><?php _e("Currency Symbol Location", 'ultimate-product-catalogue')?></span></legend>
		<label title='Before' class='ewd-upcp-admin-input-container'><input type='radio' name='currency_symbol_location' value='Before' <?php if($Currency_Symbol_Location == "Before") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Before", 'ultimate-product-catalogue')?></span></label><br />
		<label title='After' class='ewd-upcp-admin-input-container'><input type='radio' name='currency_symbol_location' value='After' <?php if($Currency_Symbol_Location == "After") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("After", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Should the currency symbol, if selected, be displayed before or after the price?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Sale Mode", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Sale Mode", 'ultimate-product-catalogue')?></span></legend>
		<label title='All' class='ewd-upcp-admin-input-container'><input type='radio' name='sale_mode' value='All' <?php if($Sale_Mode == "All") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("All", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Individual' class='ewd-upcp-admin-input-container'><input type='radio' name='sale_mode' value='Individual' <?php if($Sale_Mode == "Individual") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Individual", 'ultimate-product-catalogue')?></span></label><br />
		<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='sale_mode' value='None' <?php if($Sale_Mode == "None") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Should all products be put on sale ('All'), no products be on sale ('None'), or sale prices be shown only for selected products ('Individual')?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Thumbnail Support", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Thumbnail Support", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='thumbnail_support' value='Yes' <?php if($Thumbnail_Support == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='thumbnail_support' value='No' <?php if($Thumbnail_Support == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="thumbnail_support" <?php if($Thumbnail_Support == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("If available, should thumbnail version of images be used on the main catalog pages?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Contents Filter", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Contents Filter", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='contents_filter' value='Yes' <?php if($Apply_Contents_Filter == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='contents_filter' value='No' <?php if($Apply_Contents_Filter == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="contents_filter" <?php if($Apply_Contents_Filter == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should the default WordPress contents filter be applied to product descriptions before they're saved in the database?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Maintain Filtering", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Maintain Filtering", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='maintain_filtering' value='Yes' <?php if($Maintain_Filtering == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='maintain_filtering' value='No' <?php if($Maintain_Filtering == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="maintain_filtering" <?php if($Maintain_Filtering == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should filtering be maintained after viewing a product page (may cause redirect to homepage issues)?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Social Media Options", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
	    <fieldset><legend class="screen-reader-text"><span><?php _e("Social Media Options", 'ultimate-product-catalogue')?> </span></legend>
	        <label title='Facebook' class='ewd-upcp-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Facebook' <?php if(in_array("Facebook", $Socialmedia)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span>Facebook</span></label><br />
	        <label title='Name' class='ewd-upcp-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Google'  <?php if(in_array("Google", $Socialmedia)) {echo "checked='checked'";} ?>  /><span class='ewd-upcp-admin-checkbox'></span> <span>Google</span></label><br />
	        <label title='Twitter' class='ewd-upcp-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Twitter' <?php if(in_array("Twitter", $Socialmedia)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span>Twitter</span></label><br />
	        <label title='Linkedin' class='ewd-upcp-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Linkedin' <?php if(in_array("Linkedin", $Socialmedia)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span>Linkedin</span></label><br />
	        <label title='Pinterest' class='ewd-upcp-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Pinterest' <?php if(in_array("Pinterest", $Socialmedia)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span>Pinterest</span></label><br />
	        <label title='Email' class='ewd-upcp-admin-input-container'><input type='checkbox' name='Socialmedia[]' value='Email' <?php if(in_array("Email", $Socialmedia)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span>Email</span></label><br />
	        <div style='display:none;'><label title='Blank'><input type='checkbox' name='Socialmedia[]' value='Blank' checked='checked'/> <span>Blank</span></label></div>
	    </fieldset>
			<p><?php _e("Which social media links should be displayed on the product page?", 'ultimate-product-catalogue')?></p>
	</td>
	</tr>
</table>

<br />

<div class="ewd-upcp-admin-section-heading"><?php _e('Catalog Page Display', 'ultimate-product-catalogue'); ?></div>

<table id='catalogue-page-display-options-table' class="form-table upcp-options-table">
	<tr>
	<th scope="row"><?php _e("Catalog Color", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td >
		<fieldset><legend class="screen-reader-text"><span><?php _e("Catalog Color", 'ultimate-product-catalogue')?></span></legend>
		<label title='Blue' class='ewd-upcp-admin-input-container'><input type='radio' name='color_scheme' value='Blue' <?php if($Color == "Blue") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Blue", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Black' class='ewd-upcp-admin-input-container'><input type='radio' name='color_scheme' value='Black' <?php if($Color == "Black") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Black", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Grey' class='ewd-upcp-admin-input-container'><input type='radio' name='color_scheme' value='Grey' <?php if($Color == "Grey") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Grey", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Set the color of the image and border elements", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Auto-Adjust Thumbnail Heights", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Auto-Adjust Thumbnail Heights", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='thumb_auto_adjust' value='Yes' <?php if($Thumb_Auto_Adjust == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='thumb_auto_adjust' value='No' <?php if($Thumb_Auto_Adjust == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="thumb_auto_adjust" <?php if($Thumb_Auto_Adjust == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should the heights of the product thumbnails auto-adjust to the height of the longest product? This prevents lines with odd numbers of products, products not starting on the left, etc.", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Sub-Category Style", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("How Should Sub-Categories be Displayed", 'ultimate-product-catalogue')?></span></legend>
		<label title='Normal' class='ewd-upcp-admin-input-container'><input type='radio' name='sidebar_order' value='Normal' <?php if($Sidebar_Order == "Normal") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Normal", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Hierarchical' class='ewd-upcp-admin-input-container'><input type='radio' name='sidebar_order' value='Hierarchical' <?php if($Sidebar_Order == "Hierarchical") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Hierarchical", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Should categories and sub-categories be arranged hierarchically or be grouped?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Read More", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("'Read More' for Details view", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='read_more' value='Yes' <?php if($ReadMore == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='read_more' value='No' <?php if($ReadMore == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="read_more" <?php if($ReadMore == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("In the 'Details' layout, should the product description be cutoff if it's long?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Characters in Details Description", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Characters in 'Details' Description", 'ultimate-product-catalogue')?></span></legend>
		<label><input type='text' name='desc_count' value='<?php echo $Detail_Desc_Chars; ?>'/></label>
		<p><?php _e("Set maximum number of characters in product description in the 'Details' layout", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Show Catalog Information", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Show Catalog Information", 'ultimate-product-catalogue')?></span></legend>
		<label title='Name' class='ewd-upcp-admin-input-container'><input type='radio' name='show_catalogue_information' value='Name' <?php if($Show_Catalogue_Information == "Name") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Name", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Description' class='ewd-upcp-admin-input-container'><input type='radio' name='show_catalogue_information' value='Description' <?php if($Show_Catalogue_Information == "Description") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Description", 'ultimate-product-catalogue')?></span></label><br />
		<label title='NameDescription' class='ewd-upcp-admin-input-container'><input type='radio' name='show_catalogue_information' value='NameDescription' <?php if($Show_Catalogue_Information == "NameDescription") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Both", 'ultimate-product-catalogue')?></span></label><br />
		<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='show_catalogue_information' value='None' <?php if($Show_Catalogue_Information == "None") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Should the name or description of the catalog be shown above the catalog?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Show Category Description", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Show Category Description", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='show_category_descriptions' value='Yes' <?php if($Show_Category_Descriptions == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='show_category_descriptions' value='No' <?php if($Show_Category_Descriptions == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="show_category_descriptions" <?php if($Show_Category_Descriptions == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should the descriptions of product categories be shown below them?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Display Category Image", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Display Category Image", 'ultimate-product-catalogue')?></span></legend>
		<label title='Sidebar' class='ewd-upcp-admin-input-container'><input type='radio' name='display_category_image' value='Sidebar' <?php if($Display_Category_Image == "Sidebar") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("In Sidebar", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Main' class='ewd-upcp-admin-input-container'><input type='radio' name='display_category_image' value='Main' <?php if($Display_Category_Image == "Main") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("In Main Catalog Area", 'ultimate-product-catalogue')?></span></label><br />
		<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='display_category_image' value='No' <?php if($Display_Category_Image == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Should the category image be displayed on the main catalog page?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Display Sub-Category Image", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Display Sub-Category Image", 'ultimate-product-catalogue')?></span></legend>
		<label title='Sidebar' class='ewd-upcp-admin-input-container'><input type='radio' name='display_subcategory_image' value='Sidebar' <?php if($Display_SubCategory_Image == "Sidebar") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("In Sidebar", 'ultimate-product-catalogue')?></span></label><br />
		<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='display_subcategory_image' value='No' <?php if($Display_SubCategory_Image == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
		</fieldset>
		<p><?php _e("Should the sub-category image be displayed on the main catalog page?", 'ultimate-product-catalogue')?></p>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Display Categories in Thumbnails", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='display_categories_in_thumbnails' value='Yes' <?php if($Display_Categories_In_Thumbnails == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='display_categories_in_thumbnails' value='No' <?php if($Display_Categories_In_Thumbnails == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="display_categories_in_thumbnails" <?php if($Display_Categories_In_Thumbnails == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should the category and sub-category associated with a product be displayed in the product listing on the catalog page?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Display Tags in Thumbnails", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='display_tags_in_thumbnails' value='Yes' <?php if($Display_Tags_In_Thumbnails == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='display_tags_in_thumbnails' value='No' <?php if($Display_Tags_In_Thumbnails == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="display_tags_in_thumbnails" <?php if($Display_Tags_In_Thumbnails == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should the tags associated with a product be displayed in the product listing on the catalog page?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
</table>

<br />

<div class="ewd-upcp-admin-section-heading"><?php _e('Catalog Page Functionality', 'ultimate-product-catalogue'); ?></div>

<table id='catalogue-page-functionality-options-table' class="form-table upcp-options-table">
	<tr>
	<th scope="row"><?php _e("Product Links", 'ultimate-product-catalogue')?> <br>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Product Links", 'ultimate-product-catalogue')?></span></legend>
		<label title='Same' class='ewd-upcp-admin-input-container'><input type='radio' name='product_links' value='Same' <?php if($Links == "Same") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Open in Same Window", 'ultimate-product-catalogue')?></span></label><br />
		<label title='New' class='ewd-upcp-admin-input-container'><input type='radio' name='product_links' value='New' <?php if($Links == "New") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Open in New Window", 'ultimate-product-catalogue')?></span></label><br />
		<!--<label title='External'><input type='radio' name='product_links' value='External' <?php if($Links == "External") {echo "checked='checked'";} ?> /> <span><?php _e("Open External Links Only in New Window", 'ultimate-product-catalogue')?></span></label><br />-->
		<p><?php _e("Should external product links open in a new window?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Tag Logic", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Logic", 'ultimate-product-catalogue')?></span></legend>
		<label title='AND' class='ewd-upcp-admin-input-container'><input type='radio' name='tag_logic' value='AND' <?php if($Tags == "AND") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Selected Tags use 'AND'", 'ultimate-product-catalogue')?></span></label><br />
		<label title='OR' class='ewd-upcp-admin-input-container'><input type='radio' name='tag_logic' value='OR' <?php if($Tags == "OR") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Selected Tags use 'OR'", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Gives users the option to use multiple tags at the same time in filtering ('OR' option)", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Allow Price Filtering", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Allow Price Filtering", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='price_filter' value='Yes' <?php if($Price_Filter == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='price_filter' value='No' <?php if($Price_Filter == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="price_filter" <?php if($Price_Filter == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should a price slider be added so that visitors can filter by price?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Slider Filter Text Inputs", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Allow Price Filtering", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='slider_filter_inputs' value='Yes' <?php if($Slider_Filter_Inputs == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='slider_filter_inputs' value='No' <?php if($Slider_Filter_Inputs == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="slider_filter_inputs" <?php if($Slider_Filter_Inputs == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should slider filters have text inputs where users can adjust the min/max values?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Catalog Overview Mode", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Catalog Overview Mode", 'ultimate-product-catalogue')?></span></legend>
		<label title='Full' class='ewd-upcp-admin-input-container'><input type='radio' name='overview_mode' value='Full' <?php if($Overview_Mode == "Full") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Categories and Sub-Categories", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Cats' class='ewd-upcp-admin-input-container'><input type='radio' name='overview_mode' value='Cats' <?php if($Overview_Mode == "Cats") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Categories Only", 'ultimate-product-catalogue')?></span></label><br />
		<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='overview_mode' value='None' <?php if($Overview_Mode == "None") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Should visitors see an overview of the categories instead of all products when the page first loads?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Product Search", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Product Search", 'ultimate-product-catalogue')?></span></legend>
		<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='product_search' value='none' <?php if($Product_Search == "none") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Name' class='ewd-upcp-admin-input-container'><input type='radio' name='product_search' value='name' <?php if($Product_Search == "name") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Name Only", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Name-and-Desc' class='ewd-upcp-admin-input-container'><input type='radio' name='product_search' value='namedesc' <?php if($Product_Search == "namedesc") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Name and Description", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Name-Desc-and-Cust' class='ewd-upcp-admin-input-container'><input type='radio' name='product_search' value='namedesccust' <?php if($Product_Search == "namedesccust") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Name, Description and Custom Fields", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Set the 'Product Search' text box to search either product name, product name and description or product name, description and custom fields (slowest option)", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Case Insensitive Search (AJAX Only)", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td >
		<fieldset><legend class="screen-reader-text"><span><?php _e("Compare only the letters and not their case in AJAX search", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Javascript' class='ewd-upcp-admin-input-container'><input type='radio' name='case_insensitive_search' value='Yes' <?php if($CaseInsensitiveSearch == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='AJAX' class='ewd-upcp-admin-input-container'><input type='radio' name='case_insensitive_search' value='No' <?php if($CaseInsensitiveSearch == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="case_insensitive_search" <?php if($CaseInsensitiveSearch == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Compare only the letters and not their case in AJAX search", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Results Filtering", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Results Filtering", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='inner_filter' value='Yes' <?php if($Inner_Filter == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='inner_filter' value='No' <?php if($Inner_Filter == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="inner_filter" <?php if($Inner_Filter == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should filtering results be passed through the default content filter?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("'Clear All' Option", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("'Clear All' Option", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='clear_all' value='Yes' <?php if($Clear_All == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='clear_all' value='No' <?php if($Clear_All == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="clear_all" <?php if($Clear_All == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should an option be added to the top of sidebar to clear all filtering options?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Hide Empty Filtering Options", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Hide Empty Filtering Options", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='hide_empty_options' value='Yes' <?php if($Hide_Empty_Options == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='hide_empty_options' value='No' <?php if($Hide_Empty_Options == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="hide_empty_options" <?php if($Hide_Empty_Options == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should filtering options that would no longer display any results be hidden?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
</table>

<br />

<div class="ewd-upcp-admin-section-heading"><?php _e('Product Page', 'ultimate-product-catalogue'); ?></div>

<table id='product-page-options-table' class="form-table upcp-options-table">
	<tr>
	<th scope="row"><?php _e("Breadcrumbs", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Breadcrumbs", 'ultimate-product-catalogue')?></span></legend>
		<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='breadcrumbs' value='None' <?php if($Breadcrumbs == "None") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Catalogue' class='ewd-upcp-admin-input-container'><input type='radio' name='breadcrumbs' value='Catalogue' <?php if($Breadcrumbs == "Catalogue") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Catalog", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Categories' class='ewd-upcp-admin-input-container'><input type='radio' name='breadcrumbs' value='Categories' <?php if($Breadcrumbs == "Categories") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Categories", 'ultimate-product-catalogue')?></span></label><br />
		<label title='SubCategories' class='ewd-upcp-admin-input-container'><input type='radio' name='breadcrumbs' value='SubCategories' <?php if($Breadcrumbs == "SubCategories") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Sub-Categories", 'ultimate-product-catalogue')?></span></label><br />
		<p><?php _e("Which breadcrumbs, if any, should display on the product page?", 'ultimate-product-catalogue')?></fieldset></p>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Product Page Elements (Additional Info)", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Extra Product Page Elements", 'ultimate-product-catalogue')?></span></legend>
		<label title='Category' class='ewd-upcp-admin-input-container'><input type='checkbox' name='extra_elements[]' value='Category' <?php if(in_array("Category", $Extra_Elements)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Category Name", 'ultimate-product-catalogue')?></span></label><br />
		<label title='SubCategory' class='ewd-upcp-admin-input-container'><input type='checkbox' name='extra_elements[]' value='SubCategory' <?php if(in_array("SubCategory", $Extra_Elements)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("SubCategory Name", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Tags' class='ewd-upcp-admin-input-container'><input type='checkbox' name='extra_elements[]' value='Tags' <?php if(in_array("Tags", $Extra_Elements)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Tags", 'ultimate-product-catalogue')?></span></label><br />
		<label title='CustomFields' class='ewd-upcp-admin-input-container'><input type='checkbox' name='extra_elements[]' value='CustomFields' <?php if(in_array("CustomFields", $Extra_Elements)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Custom Fields", 'ultimate-product-catalogue')?></span></label><br />
		<label title='Videos' class='ewd-upcp-admin-input-container'><input type='checkbox' name='extra_elements[]' value='Videos' <?php if(in_array("Videos", $Extra_Elements)) {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Videos", 'ultimate-product-catalogue')?></span></label><br />
		<div style='display:none;'><label title='Blank'><input type='checkbox' name='extra_elements[]' value='Blank' checked='checked' /> <span>Blank</span></label></div>
		<p><?php _e("Select elements to be displayed on each product page.", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
	<tr>
	<th scope="row"><?php _e("Display Product Page Price", 'ultimate-product-catalogue')?> <br/>
	</th>
	<td>
		<fieldset><legend class="screen-reader-text"><span><?php _e("Put Prices on the Default Product Pages", 'ultimate-product-catalogue')?></span></legend>
			<div class="ewd-upcp-admin-hide-radios">
				<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='single_page_price' value='Yes' <?php if($Single_Page_Price == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
				<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='single_page_price' value='No' <?php if($Single_Page_Price == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			</div>
			<label class="ewd-upcp-admin-switch">
				<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="single_page_price" <?php if($Single_Page_Price == "Yes") {echo "checked='checked'";} ?>>
				<span class="ewd-upcp-admin-switch-slider round"></span>
			</label>		
			<p><?php _e("Should a product's price be displayed on the product pages?", 'ultimate-product-catalogue')?></p>
		</fieldset>
	</td>
	</tr>
</table>
</div>

<div id='Premium' class='upcp-option-set<?php echo ( $Display_Tab == 'Premium' ? '' : ' upcp-hidden' ); ?>'>
	<h2 id="premium-options" class="upcp-options-tab-title">Premium Options</h2>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Product Page', 'ultimate-product-catalogue'); ?></div>

	<table id='premium-options-product-page' class="form-table upcp-options-table<?php echo ( ( $Full_Version != 'Yes' or get_option('UPCP_Trial_Happening') == 'Yes' ) ? ' ewd-upcp-premium-options-table' : '' ); ?>">
		<tr>
		<th scope="row"><?php _e("Product Page Type", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Use your custom designed page (Product Page tab) instead of the default?", 'ultimate-product-catalogue')?></span></legend>
			<label title='Tabbed' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_product_page' value='Tabbed' <?php if($Custom_Product_Page == "Tabbed") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Tabbed Product Page", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Shop Style' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_product_page' value='Shop_Style' <?php if($Custom_Product_Page == "Shop_Style") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Shop Style Product Page", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_product_page' value='Yes' <?php if($Custom_Product_Page == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Custom Product Page", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Large' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_product_page' value='Large' <?php if($Custom_Product_Page == "Large") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Custom Page - Large Screen Only", 'ultimate-product-catalogue')?></span></label><br />
			<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_product_page' value='No' <?php if($Custom_Product_Page == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Default", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("Should the layout created on the 'Product Pages' tab be used instead of the default plugin layout?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Lightbox", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should a lightbox pop-up on the product page when an image is clicked?", 'ultimate-product-catalogue')?></span></legend>
			<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='lightbox' value='Yes' <?php if($Lightbox == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Main' class='ewd-upcp-admin-input-container'><input type='radio' name='lightbox' value='Main' <?php if($Lightbox == "Main") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Main Image Only", 'ultimate-product-catalogue')?></span></label><br />
			<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='lightbox' value='No' <?php if($Lightbox == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("Should a lightbox pop-up on the product page when an image is clicked?", 'ultimate-product-catalogue')?><br />
			<?php _e("Want to customize this lightbox? Install the <a href='https://wordpress.org/plugins/ultimate-lightbox/' target='_blank'>Ultimate Lightbox</a> plugin and you can switch the lightbox colors, controls, behaviour and more!", 'ultimate-product-catalogue'); ?> </p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Related Products", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should related products be created automatically, manually, or not at all?", 'ultimate-product-catalogue')?></span></legend>
			<label title='Auto' class='ewd-upcp-admin-input-container'><input type='radio' name='related_products' value='Auto' <?php if($Related_Products == "Auto") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Automatic", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Manual' class='ewd-upcp-admin-input-container'><input type='radio' name='related_products' value='Manual' <?php if($Related_Products == "Manual") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Manual", 'ultimate-product-catalogue')?></span></label><br />
			<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='related_products' value='None' <?php if($Related_Products == "None") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("Should related products be created automatically, manually, or not at all?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Next/Previous Products", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should next and previous products be displayed?", 'ultimate-product-catalogue')?></span></legend>
			<label title='Auto' class='ewd-upcp-admin-input-container'><input type='radio' name='next_previous' value='Auto' <?php if($Next_Previous == "Auto") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Automatic", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Manual' class='ewd-upcp-admin-input-container'><input type='radio' name='next_previous' value='Manual' <?php if($Next_Previous == "Manual") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Manual", 'ultimate-product-catalogue')?></span></label><br />
			<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='next_previous' value='None' <?php if($Next_Previous == "None") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("None", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("Should next and previous products be displayed? Automatic takes the products with the next and previous IDs, if they exist.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<?php if ($Full_Version != "Yes") { ?>
			<tr class="ewd-upcp-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-upcp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Catalog Page', 'ultimate-product-catalogue'); ?></div>

	<table id='premium-options-catalogue-page' class="form-table upcp-options-table<?php echo ( ( $Full_Version != 'Yes' or get_option('UPCP_Trial_Happening') == 'Yes' ) ? ' ewd-upcp-premium-options-table' : '' ); ?>">
		<tr>
		<th scope="row"><?php _e("Lightbox Mode", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Lightbox Mode", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='lightbox_mode' value='Yes' <?php if($Lightbox_Mode == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='lightbox_mode' value='No' <?php if($Lightbox_Mode == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="lightbox_mode" <?php if($Lightbox_Mode == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should a lightbox pop-up to display more information about products when they're clicked on?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Infinite Scroll", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Infinite Scroll", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='infinite_scroll' value='Yes' <?php if($Infinite_Scroll == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='infinite_scroll' value='No' <?php if($Infinite_Scroll == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="infinite_scroll" <?php if($Infinite_Scroll == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should products load as a user scrolls down the page, instead of using the pagination system?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Products per Page", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("How many products should be displayed on each page of the catalog?", 'ultimate-product-catalogue')?></span></legend>
			<label><input type='text' name='products_per_page' value='<?php echo $Products_Per_Page; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/></label>
			<p><?php _e("Set the maximum number of products per page for your catalogs", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Pagination Location", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Where should the pagination controls be located?", 'ultimate-product-catalogue')?></span></legend>
			<label title='Top' class='ewd-upcp-admin-input-container'><input type='radio' name='pagination_location' value='Top' <?php if($Pagination_Location == "Top") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Top", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Bottom' class='ewd-upcp-admin-input-container'><input type='radio' name='pagination_location' value='Bottom' <?php if($Pagination_Location == "Bottom") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Bottom", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Both' class='ewd-upcp-admin-input-container'><input type='radio' name='pagination_location' value='Both' <?php if($Pagination_Location == "Both") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Top and Bottom", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("Set the location of pagination controls for your catalogs", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Product Sorting", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Available Sorting Options", 'ultimate-product-catalogue')?></span></legend>
			<label title='Price' class='ewd-upcp-admin-input-container'><input type='checkbox' name='product_sort[]' value='Price' <?php if(in_array("Price", $Product_Sort)) {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Price", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Name' class='ewd-upcp-admin-input-container'><input type='checkbox' name='product_sort[]' value='Name' <?php if(in_array("Name", $Product_Sort)) {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Name", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Rating' class='ewd-upcp-admin-input-container'><input type='checkbox' name='product_sort[]' value='Rating' <?php if(in_array("Rating", $Product_Sort)) {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-checkbox'></span> <span><?php _e("Review Ratings", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("Select which sorting options are available in the 'Sort By' box ('Review Rating' requires 'Ultimate Reviews' to be installed)", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Hidden Drop Down Sidebar on Mobile", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Hidden Drop-Down Sidebar on Mobile", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='hidden_drop_down_sidebar_on_mobile' value='Yes' <?php if($Hidden_Drop_Down_Sidebar_On_Mobile == "Yes") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='hidden_drop_down_sidebar_on_mobile' value='No' <?php if($Hidden_Drop_Down_Sidebar_On_Mobile == "No") {echo "checked='checked'";} ?> /><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="hidden_drop_down_sidebar_on_mobile" <?php if($Hidden_Drop_Down_Sidebar_On_Mobile == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Will make it so that, on mobile devices, the sidebar is hidden by default. A 'Filter' button will display allowing the user to open the sidebar.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<?php if ($Full_Version != "Yes") { ?>
			<tr class="ewd-upcp-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-upcp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Features', 'ultimate-product-catalogue'); ?></div>

	<table id='premium-options-features' class="form-table upcp-options-table<?php echo ( ( $Full_Version != 'Yes' or get_option('UPCP_Trial_Happening') == 'Yes' ) ? ' ewd-upcp-premium-options-table' : '' ); ?>">
		<tr>
		<th scope="row"><?php _e("Product Inquiry Form", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should a form be added to inquire about products on the product page (requires plugin 'Contact Form 7')?", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='product_inquiry_form' value='Yes' <?php if($Product_Inquiry_Form == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?><?php _e(" (requires plugin 'Contact Form 7')", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='product_inquiry_form' value='No' <?php if($Product_Inquiry_Form == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="product_inquiry_form" <?php if($Product_Inquiry_Form == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should a form be added to inquire about products on the product page (requires plugin 'Contact Form 7')?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Product Inquiry Cart", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should users be able to inquire about multiple products at once from the main catalog page (requires plugin 'Contact Form 7')?", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='product_inquiry_cart' value='Yes' <?php if($Product_Inquiry_Cart == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?><?php _e(" (requires plugin 'Contact Form 7')", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='product_inquiry_cart' value='No' <?php if($Product_Inquiry_Cart == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="product_inquiry_cart" <?php if($Product_Inquiry_Cart == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should users be able to inquire about multiple products at once from the main catalog page (requires plugin 'Contact Form 7')?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row">Inquiry Form Submitted Thank You E-mail</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Inquiry Form Submitted Thank You E-mail</span></legend>
				<?php 
					$plugin = "ultimate-wp-mail/Main.php";
					$UWPM_Installed = is_plugin_active($plugin);
					if ($UWPM_Installed) {
						$UWPM_Emails = get_posts(array('post_type' => 'uwpm_mail_template', 'posts_per_page' => -1));
						echo "<label>";
						echo "<select name='inquiry_form_email'>";
						echo "<option value='0'>" . __("None", 'ultimate-faqs') . "</option>";
						foreach ($UWPM_Emails as $Email) {
							echo "<option value='" . $Email->ID . "' " . ($Inquiry_Form_Email == $Email->ID ? 'selected' : '') . ">" . $Email->post_title . "</option>";
						}
						echo "</select>";
						echo "</label>";
						echo "<p>What email should be sent out when an inquiry form is submitted?</p>";
					}
					else {
						echo "<p>You can use the <a href='https://wordpress.org/plugins/ultimate-wp-mail/' target='_blank'>Ultimate WP Mail plugin</a> to create a custom email that is sent whenever an inquiry form or cart is submitted.</p>";
					}
				?>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Product Reviews", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should reviews be displayed for products on the Tabbed or Shop Style layout product page (requires Ultimate Reviews plugin)?", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='product_reviews' value='Yes' <?php if($Product_Reviews == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?><?php _e(" (requires plugin 'Ultimate Reviews')", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='product_reviews' value='No' <?php if($Product_Reviews == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="product_reviews" <?php if($Product_Reviews == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should reviews be displayed for products on the 'Tabbed Layout' product page (requires plugin 'Ultimate Reviews')?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Reviews in Main Catalog", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Reviews in Main Catalog", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='catalog_display_reviews' value='Yes' <?php if($Catalog_Display_Reviews == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?><?php _e(" (requires plugin 'Ultimate Reviews')", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='catalog_display_reviews' value='No' <?php if($Catalog_Display_Reviews == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="catalog_display_reviews" <?php if($Catalog_Display_Reviews == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should a product's review rating be displayed on the main catalog page? (requires plugin '<a href='https://wordpress.org/plugins/ultimate-reviews/'>Ultimate Reviews</a>')?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Allow Product Comparison", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Allow Product Comparison", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='product_comparison' value='Yes' <?php if($Product_Comparison == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='product_comparison' value='No' <?php if($Product_Comparison == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="product_comparison" <?php if($Product_Comparison == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should visitors be able to compare products side by side by clicking on the comparison link?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Hide Blank Custom Fields", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should custom fields be hidden when they are empty?", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_fields_blank' value='Yes' <?php if($Custom_Fields_Blank == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='custom_fields_blank' value='No' <?php if($Custom_Fields_Blank == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="custom_fields_blank" <?php if($Custom_Fields_Blank == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should custom fields be hidden when they are empty?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Custom Slugs Conversion", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Are custom field slugs being used in the product descriptions?", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='cf_converion' value='Yes' <?php if($CF_Conversion == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='cf_converion' value='No' <?php if($CF_Conversion == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="cf_converion" <?php if($CF_Conversion == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Are custom field slugs being used in the product descriptions?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Set Access Role", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span>Set Access Role</span></legend>
			<label title='Access Role'>
				<select name='access_role' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>>
					<option value="administrator"<?php if($Access_Role == "administrator") {echo " selected=selected";} ?>>Administrator</option>
					<option value="delete_others_pages"<?php if($Access_Role == "delete_others_pages") {echo " selected=selected";} ?>>Editor</option>
					<option value="delete_published_posts"<?php if($Access_Role == "delete_published_posts") {echo " selected=selected";} ?>>Author</option>
					<option value="delete_posts"<?php if($Access_Role == "delete_posts") {echo " selected=selected";} ?>>Contributor</option>
					<option value="read"<?php if($Access_Role == "read") {echo " selected=selected";} ?>>Subscriber</option>
				</select>
			</label>
			<p><?php _e("Which level of user should have access to UPCP?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<?php if ($Full_Version != "Yes") { ?>
			<tr class="ewd-upcp-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-upcp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>

</div>

<div id='WooCommerce' class='upcp-option-set<?php echo ( $Display_Tab == 'WooCommerce' ? '' : ' upcp-hidden' ); ?>'>
	<h2 id="woocommerce-options" class="upcp-options-tab-title">WooCommerce Options</h2>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Settings', 'ultimate-product-catalogue'); ?></div>

	<table id='woocommerce-options' class="form-table upcp-options-table ewd-upcp-premium-options-table <?php echo $Full_Version; ?>">
		<tr>
		<th scope="row"><?php _e("WooCommerce Sync", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should UPCP products be exported to WooCommerce, and WooCommerce products imported into UPCP? Products edited in one plugin will also be edited in the other while this is enabled.", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_sync' value='Yes' <?php if($WooCommerce_Sync == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_sync' value='No' <?php if($WooCommerce_Sync == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="woocommerce_sync" <?php if($WooCommerce_Sync == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should UPCP products be exported to WooCommerce, and WooCommerce products imported into UPCP? Products edited in one plugin will also be edited in the other while this is enabled.", 'ultimate-product-catalogue')?><br />
				<?php _e("Using WooCommerce attributes or UPCP custom fields and want those to sync as well? Check out our blog post on how to <a href='http://www.etoilewebdesign.com/product-catalog-woocommerce-sync-tips/'>get the best syncing results for attributes</a>.", 'ultimate-product-catalogue'); ?></p>
			</fieldset>
		</td>
		</tr>
		<tr class="ewd-upcp-admin-conditional-wc-options<?php echo ($WooCommerce_Sync != 'Yes' ? ' upcp-hidden' : ''); ?>">
		<th scope="row"><?php _e("Show Cart Item Count", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Show Cart Item Count", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_show_cart_count' value='Yes' <?php if($WooCommerce_Show_Cart_Count == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_show_cart_count' value='No' <?php if($WooCommerce_Show_Cart_Count == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="woocommerce_show_cart_count" <?php if($WooCommerce_Show_Cart_Count == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should the number of items in a visitors shopping cart be displayed?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr class="ewd-upcp-admin-conditional-wc-options<?php echo ($WooCommerce_Sync != 'Yes' ? ' upcp-hidden' : ''); ?>">
		<th scope="row"><?php _e("WooCommerce Checkout", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should checkout be allowed, using the standard WooCommerce checkout? WARNING: WooCommerce sync must be enabled.", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_checkout' value='Yes' <?php if($WooCommerce_Checkout == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?><?php _e(" (requires plugin 'WooCommerce')", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_checkout' value='No' <?php if($WooCommerce_Checkout == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="woocommerce_checkout" <?php if($WooCommerce_Checkout == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should checkout be allowed, using the standard WooCommerce checkout? WARNING: WooCommerce sync must be enabled.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr class="ewd-upcp-admin-conditional-wc-options<?php echo ($WooCommerce_Sync != 'Yes' ? ' upcp-hidden' : ''); ?>">
		<th scope="row"><?php _e("WooCommerce Cart Page", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("WooCommerce Cart Page", 'ultimate-product-catalogue')?></span></legend>
				<label title='Cart' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_cart_page' value='Cart' <?php if($WooCommerce_Cart_Page == "Cart") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Cart", 'ultimate-product-catalogue')?></span></label><br />
				<label title='Checkout' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_cart_page' value='Checkout' <?php if($WooCommerce_Cart_Page == "Checkout") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Checkout", 'ultimate-product-catalogue')?></span></label><br />
				<p><?php _e("What WooCommerce page should visitors be sent to when they click the 'Checkout' cart button? WARNING: WooCommerce sync must be enabled.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>

		<tr class="ewd-upcp-admin-conditional-wc-options<?php echo ($WooCommerce_Sync != 'Yes' ? ' upcp-hidden' : ''); ?>">
		<th scope="row"><?php _e("WooCommerce Product Page", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("WooCommerce Product Page", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_product_page' value='Yes' <?php if($WooCommerce_Product_Page == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_product_page' value='No' <?php if($WooCommerce_Product_Page == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="woocommerce_product_page" <?php if($WooCommerce_Product_Page == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should visitors be redirected to WooCommerce product pages instead of UPCP product pages when clicking on a product? WARNING: WooCommerce sync must be enabled.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>

		<tr class="ewd-upcp-admin-conditional-wc-options<?php echo ($WooCommerce_Sync != 'Yes' ? ' upcp-hidden' : ''); ?>">
		<th scope="row"><?php _e("WooCommerce Back Link", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("WooCommerce Back Link", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_back_link' value='Yes' <?php if($WooCommerce_Back_Link == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='woocommerce_back_link' value='No' <?php if($WooCommerce_Back_Link == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="woocommerce_back_link" <?php if($WooCommerce_Back_Link == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should the WooCommerce product page breadcrumbs be replaced with a 'Back to Catalog' link when coming directly from the catalog page? WARNING: 'Maintain Filtering' (in the 'Basic' options tab) must be set to 'Yes'.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<?php if ($Full_Version != "Yes") { ?>
			<tr class="ewd-upcp-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-upcp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>
</div>

<div id='SEO' class='upcp-option-set<?php echo ( $Display_Tab == 'SEO' ? '' : ' upcp-hidden' ); ?>'>
	<h2 id="seo-options" class="upcp-options-tab-title">SEO Options</h2>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Settings', 'ultimate-product-catalogue'); ?></div>

	<table id='seo-options' class="form-table upcp-options-table<?php echo ( ( $Full_Version != 'Yes' or get_option('UPCP_Trial_Happening') == 'Yes' ) ? ' ewd-upcp-premium-options-table' : '' ); ?>">
		<tr>
		<th scope="row"><?php _e("Pretty Permalinks", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Use Pretty Permalinks for Product Pages", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yes' class='ewd-upcp-admin-input-container'><input type='radio' name='pretty_links' value='Yes' <?php if($PrettyLinks == "Yes") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='No' class='ewd-upcp-admin-input-container'><input type='radio' name='pretty_links' value='No' <?php if($PrettyLinks == "No") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="pretty_links" <?php if($PrettyLinks == "Yes") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should the plugin create SEO-friendly product page URLs? (Make sure product slugs have been filled in)", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("Permalink Base", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("What URL should be used at the base of the products sitemap?", 'ultimate-product-catalogue')?></span></legend>
			<label><input type='text' name='permalink_base' value='<?php echo $Permalink_Base; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/></label>
			<p><?php _e("Set the permalink base for your product pages, if you want something other than 'product' as a permalink base. You may need to re-save your permalink structure for this to take effect.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("XML Sitemap URL", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("What URL should be used at the base of the products sitemap?", 'ultimate-product-catalogue')?></span></legend>
			<label><input type='text' name='xml_sitemap_url' value='<?php echo $XML_Sitemap_URL; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/></label>
			<p><?php _e('Set the base URL path of XML sitemap that the plugin creates of all products (e.g. if you set a different permalink base above). You can find the sitemap in the root folder of the plugin (i.e. "/wp-content/plugins/ultimate-product-catalogue/upcp-site-map.xml").', 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr>
		<th scope="row"><?php _e("SEO By Yoast Integration", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should product descriptions and titled be added using SEO By Yoast for product pages?", 'ultimate-product-catalogue')?></span></legend>
				<div class="ewd-upcp-admin-hide-radios">
					<label title='Yoast' class='ewd-upcp-admin-input-container'><input type='radio' name='seo_option' value='Yoast' <?php if($SEO_Option == "Yoast") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Yes", 'ultimate-product-catalogue')?></span></label><br />
					<label title='None' class='ewd-upcp-admin-input-container'><input type='radio' name='seo_option' value='None' <?php if($SEO_Option == "None") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("No", 'ultimate-product-catalogue')?></span></label><br />
				</div>
				<label class="ewd-upcp-admin-switch">
					<input type="checkbox" class="ewd-upcp-admin-option-toggle" data-inputname="seo_option" <?php if($SEO_Option == "Yoast") {echo "checked='checked'";} ?>>
					<span class="ewd-upcp-admin-switch-slider round"></span>
				</label>		
				<p><?php _e("Should descriptions and titles for product pages be added using Yoast?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<tr id="ewd-upcp-admin-yoast-description-handling"<?php echo ($SEO_Option != 'Yoast' ? ' class="upcp-hidden"' : ''); ?>>
		<th scope="row"><?php _e("Description Handling", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Should the page description be added to or replaced?", 'ultimate-product-catalogue')?></span></legend>
			<label title='Add' class='ewd-upcp-admin-input-container'><input type='radio' name='seo_integration' value='Add' <?php if($SEO_Integration == "Add") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Add", 'ultimate-product-catalogue')?></span></label><br />
			<label title='Replace' class='ewd-upcp-admin-input-container'><input type='radio' name='seo_integration' value='Replace' <?php if($SEO_Integration == "Replace") {echo "checked='checked'";} ?> <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/><span class='ewd-upcp-admin-radio-button'></span> <span><?php _e("Replace", 'ultimate-product-catalogue')?></span></label><br />
			<p><?php _e("If using Yoast, should the page description be added to or replaced?", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<th scope="row"><?php _e("SEO Title", 'ultimate-product-catalogue')?> <br/>
		</th>
		<td>
			<fieldset><legend class="screen-reader-text"><span><?php _e("What should the page title be set to? Can use [page-title], [product-name], [category-name], [subcategory_name] to substitute those in the title.", 'ultimate-product-catalogue')?></span></legend>
			<label><input type='text' name='seo_title' value='<?php echo $SEO_Title; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/></label>
			<p><?php _e("What should the page title be set to? Can use [page-title], [product-name], [category-name], [subcategory_name] to substitute those in the title.", 'ultimate-product-catalogue')?></p>
			</fieldset>
		</td>
		</tr>
		<?php if ($Full_Version != "Yes") { ?>
			<tr class="ewd-upcp-premium-options-table-overlay">
				<th colspan="2">
					<div class="ewd-upcp-unlock-premium">
						<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
						<p>Access this section by by upgrading to premium</p>
						<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
					</div>
				</th>
			</tr>
		<?php } ?>
	</table>
</div>

<div id='Labelling' class='upcp-option-set<?php echo ( $Display_Tab == 'Labelling' ? '' : ' upcp-hidden' ); ?>'>
	<h2 id="labelling-options" class="upcp-options-tab-title">Labelling Options</h2>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Sidebar', 'ultimate-product-catalogue'); ?></div>

	<div class="ewd-upcp-admin-styling-section">
		<div class="ewd-upcp-admin-styling-subsection">
			<p>Replace the default text in the sidebar</p>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Categories Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='categories_label' value='<?php echo $Categories_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Sub-Categories Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='subcategories_label' value='<?php echo $SubCategories_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Tags Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='tags_label' value='<?php echo $Tags_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Custom Fields Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='custom_fields_label' value='<?php echo $Custom_Fields_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Show All Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='show_all_label' value='<?php echo $Show_All_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Sort By Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='sort_by_label' value='<?php echo $Sort_By_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Price (Ascending) Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='price_ascending_label' value='<?php echo $Price_Ascending_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Price (Descending) Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='price_descending_label' value='<?php echo $Price_Descending_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Name (Ascending) Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='name_ascending_label' value='<?php echo $Name_Ascending_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Name (Descending) Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='name_descending_label' value='<?php echo $Name_Descending_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Product Search (Product Name) Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='product_name_search_label' value='<?php echo $Product_Name_Search_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Search Placeholder Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='product_name_text_label' value='<?php echo $Product_Search_Text_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Price Filter/Slider Label", 'ultimate-product-catalogue')?></p>
					<input type='text' name='price_filter_label' value='<?php echo $Price_Filter_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($Full_Version != "Yes") { ?>
			<div class="ewd-upcp-premium-options-table-overlay">
				<div class="ewd-upcp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Catalog', 'ultimate-product-catalogue'); ?></div>

	<div class="ewd-upcp-admin-styling-section">
		<div class="ewd-upcp-admin-styling-subsection">
			<p>Replace the default text on the catalog page</p>
			<div class="ewd-admin-labelling-section">
				<label>
					<p><?php _e("Details Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='details_label' value='<?php echo $Details_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Updating Results Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='updating_results_label' value='<?php echo $Updating_Results_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("No Products Found Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='no_results_found_label' value='<?php echo $No_Results_Found_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Products Pagination Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='products_pagination_label' value='<?php echo $Products_Pagination_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("'Of' Pagination Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='of_pagination_label' value='<?php echo $Of_Pagination_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Read More Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='read_more_label' value='<?php echo $Read_More_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Compare Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='compare_label' value='<?php echo $Compare_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Side by side Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='side_by_side_label' value='<?php echo $Side_By_Side_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Sale Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='sale_label' value='<?php echo $Sale_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Inquire Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='inquire_button_label' value='<?php echo $Inquire_Button_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Add to Cart Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='add_to_cart_button_label' value='<?php echo $Add_To_Cart_Button_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Send Inquiry! Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='send_inquiry_label' value='<?php echo $Send_Inquiry_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Checkout! Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='checkout_label' value='<?php echo $Checkout_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("Empty cart Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='empty_cart_label' value='<?php echo $Empty_Cart_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
					<p><?php _e("'%s items in cart' Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='cart_items_label' value='<?php echo $Cart_Items_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($Full_Version != "Yes") { ?>
			<div class="ewd-upcp-premium-options-table-overlay">
				<div class="ewd-upcp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Product Page', 'ultimate-product-catalogue'); ?></div>

	<div class="ewd-upcp-admin-styling-section">
		<div class="ewd-upcp-admin-styling-subsection">
			<p>Replace the default text on the product page</p>
			<div class="ewd-admin-labelling-section halfs">
				<label>
					<p><?php _e("Back to Catalog Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='back_to_catalogue' value='<?php echo $Back_To_Catalogue_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Product Details Tab Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='product_details_label' value='<?php echo $Product_Details_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Additional Information Tab Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='additional_info_label' value='<?php echo $Additional_Info_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Contact Us Tab Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='contact_us_label' value='<?php echo $Contact_Us_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Product Inquiry Form Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='product_inquiry_form_title_label' value='<?php echo $Product_Inquiry_Form_Title_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Customer Reviews Tab Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='customer_reviews_tab_label' value='<?php echo $Customer_Reviews_Tab_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Related Products Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='related_products_label' value='<?php echo $Related_Products_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Next Product Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='next_product_label' value='<?php echo $Next_Product_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Previous Product Label", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='previous_product_label' value='<?php echo $Previous_Product_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Category Label (Additional Information tab)", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='additional_info_category_label' value='<?php echo $Additional_Info_Category_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Sub-category Label (Additional Information tab)", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='additional_info_subcategory_label' value='<?php echo $Additional_Info_SubCategory_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
				<label>
 					<p><?php _e("Tags Label (Additional Information tab)", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='additional_info_tags_label'value='<?php echo $Additional_Info_Tags_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($Full_Version != "Yes") { ?>
			<div class="ewd-upcp-premium-options-table-overlay">
				<div class="ewd-upcp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>

	<br />

	<div class="ewd-upcp-admin-section-heading"><?php _e('Other', 'ultimate-product-catalogue'); ?></div>

	<div class="ewd-upcp-admin-styling-section <?php echo $Full_Version; ?>">
		<div class="ewd-upcp-admin-styling-subsection">
			<div class="ewd-admin-labelling-section halfs">
				<label>
					<p><?php _e("'Please use...' Label in Product Inquiry", 'ultimate-product-catalogue')?></p>				
					<input type='text' name='product_inquiry_please_use_label' value='<?php echo $Product_Inquiry_Please_Use_Label; ?>' <?php if ($Full_Version != "Yes") {echo "disabled";} ?>/>
				</label>
			</div>
		</div>
		<?php if ($Full_Version != "Yes") { ?>
			<div class="ewd-upcp-premium-options-table-overlay">
				<div class="ewd-upcp-unlock-premium">
					<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate Product Catalog Premium">
					<p>Access this section by by upgrading to premium</p>
					<a href="https://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" class="ewd-upcp-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
				</div>
			</div>
		<?php } ?>
	</div>


</div>

<p class="submit"><input type="submit" name="Options_Submit" class="button button-primary" value='<?php _e("Save Changes", 'ultimate-product-catalogue')?>'/></p></form>

<div class='clear'></div>
</div></div>
