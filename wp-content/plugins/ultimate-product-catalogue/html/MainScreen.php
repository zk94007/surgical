		<div class="UPCPMenu">
				 <h2 class="nav-tab-wrapper">
						 <a id="ewd-upcp-dash-mobile-menu-open" href="#" class="MenuTab nav-tab"><?php _e("MENU", 'ultimate-product-catalogue'); ?><span id="ewd-upcp-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-upcp-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
				 		 <a id="Dashboard_Menu" class="MenuTab nav-tab <?php if ($Display_Page == '' or $Display_Page == 'Dashboard') {echo 'nav-tab-active';}?>" onclick="ShowTab('Dashboard');">Dashboard</a>
				 		 <a id="Products_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Products') {echo 'nav-tab-active';}?>" onclick="ShowTab('Products');">Products</a>
				 		 <a id="Catalogues_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Catalogues') {echo 'nav-tab-active';}?>" onclick="ShowTab('Catalogues');">Catalogs</a>
						 <a id="Categories_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Categories') {echo 'nav-tab-active';}?>" onclick="ShowTab('Categories');">Categories</a>
				 		 <a id="SubCategories_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'SubCategories') {echo 'nav-tab-active';}?>" onclick="ShowTab('SubCategories');">Sub-Categories</a>
				 		 <a id="Tags_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Tags') {echo 'nav-tab-active';}?>" onclick="ShowTab('Tags');">Tags</a>
						 <a id="CustomFields_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'CustomFields') {echo 'nav-tab-active';}?>" onclick="ShowTab('CustomFields');">Custom Fields</a>
						 <a id="ProductPage_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'ProductPage') {echo 'nav-tab-active';}?>" onclick="ShowTab('ProductPage');">Product Page</a>
						 <a id="Options_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Options') {echo 'nav-tab-active';}?>" onclick="ShowTab('Options');">Options</a>
						 <a id="Styling_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Styling') {echo 'nav-tab-active';}?>" onclick="ShowTab('Styling');">Styling</a>
				 </h2>
		</div>
		
		<div class="clear"></div>
		
		<!-- Add the individual pages to the admin area, and create the active tab based on the selected page -->
		<div class="OptionTab <?php if ($Display_Page == "" or $Display_Page == 'Dashboard') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Dashboard">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/DashboardPage.php';?>
		</div>
		
		<div class="OptionTab <?php if ($Display_Page == 'Products' or $Display_Page == 'Product') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Products">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/ProductsPage.php';?>
		</div>
		
		<div class="OptionTab <?php if ($Display_Page == 'Categories' or $Display_Page == 'Category') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Categories">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/CategoriesPage.php';?>
		</div>
		
		<div class="OptionTab <?php if ($Display_Page == 'Catalogues' or $Display_Page == 'Catalogue') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Catalogues">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/CataloguesPage.php';?>
		</div>
		
		<div class="OptionTab <?php if ($Display_Page == 'SubCategories' or $Display_Page == 'SubCategory') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="SubCategories">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/SubCategoriesPage.php';?>
		</div>
		
		<div class="OptionTab <?php if ($Display_Page == 'Tags' or $Display_Page == 'Tag') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Tags">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/TagsPage.php';?>
		</div>	
		<div class="OptionTab <?php if ($Display_Page == 'CustomFields' or $Display_Page == 'CustomField') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="CustomFields">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/CustomFieldsPage.php';?>
		</div>
		<div class="OptionTab <?php if ($Display_Page == 'ProductPages' or $Display_Page == 'ProductPage') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="ProductPage">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/CustomProductPage.php';?>
		</div>
		<div class="OptionTab <?php if ($Display_Page == 'Options' or $Display_Page == 'Option') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Options">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/OptionsPage.php';?>
		</div>			
		<div class="OptionTab <?php if ($Display_Page == 'Stylings' or $Display_Page == 'Styling') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Styling">
				<?php include UPCP_CD_PLUGIN_PATH . '/html/StylingPage.php';?>
		</div>	