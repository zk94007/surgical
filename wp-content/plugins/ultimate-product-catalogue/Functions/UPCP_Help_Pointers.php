<?php

function UPCP_Return_Pointers() {
  $pointers = array();
  
  $pointers['tutorial-one'] = array(
    'title'     => "<h3>" . 'Ultimate Product Catalog Intro' . "</h3>",
    'content'   => "<div><p>Thanks for installing UPCP! These 6 slides will help get you started using the plugin.</p></div><div class='upcp-pointer-count'><p>1 of 6 - <span class='upcp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '.Header',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Products',
    'width'     => '320',
    'where'     => array( 'toplevel_page_UPCP-options') // <-- Please note this
  );
  
  $pointers['tutorial-two'] = array(
    'title'     => "<h3>" . 'Create Products' . "</h3>",
    'content'   => "<div><p>In the 'Products' tab, you can create products for your visitors to view. The only required field is 'Name', and creating new categories, tags and custom fields will automatically add fields to be filled in when you create a new product.</p></div><div class='upcp-pointer-count'><p>2 of 6 - <span class='upcp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#Products_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Categories',
    'width'     => '320',
    'where'     => array( 'toplevel_page_UPCP-options') // <-- Please note this
  );

  $pointers['tutorial-three'] = array(
    'title'     => "<h3>" . 'Set Up Categories' . "</h3>",
    'content'   => "<div><p>Categories help organize your products. You can assign products to categories, add categories descriptions which can optionally be shown, and rearrange the order of the categories in the catalog sidebar by dragging and dropping cateogies in the right-hand table.</p></div><div class='upcp-pointer-count'><p>3 of 6 - <span class='upcp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#Categories_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Catalogues',
    'width'     => '320',
    'where'     => array( 'toplevel_page_UPCP-options') // <-- Please note this
  );

  $pointers['tutorial-four'] = array(
    'title'     => "<h3>" . 'Arrange Catalogs' . "</h3>",
    'content'   => "<div><p>Catalogs are how your products get displayed. Create a catalog using the form on the left, or click on the sample catalog to add products or categories to it. You can arrange the order of products in your catalog by dragging and dropping them on the catalog details page (click a catalog to access it).</p></div><div class='upcp-pointer-count'><p>4 of 6 - <span class='upcp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#Catalogues_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Options',
    'width'     => '320',
    'where'     => array( 'toplevel_page_UPCP-options') // <-- Please note this
  );
  
  $pointers['tutorial-five'] = array(
    'title'     => "<h3>" . 'Customize Options' . "</h3>",
    'content'   => "<div><p>The 'Options' tab has options to help customize the plugin perfectly for your site, including:</p><ul><li>Choosing a catalog color</li><li>Showing or hiding category descriptions</li><li>Choosing product page elements and more!</li></ul><p>Hover over the question mark icon to find out what an option does.</p></div><div class='upcp-pointer-count'><p>5 of 6 - <span class='upcp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#Options_Menu',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Dashboard',
    'width'     => '320',
    'where'     => array( 'toplevel_page_UPCP-options') // <-- Please note this
  );

  $pointers['tutorial-six'] = array(
    'title'     => "<h3>" . 'Need More Help?' . "</h3>",
    'content'   => "<div><p><a href='https://wordpress.org/support/view/plugin-reviews/ultimate-product-catalogue?filter=5'>Help us spread the word with a 5 star rating!</a><br><br>We've got a number of videos on how to use the plugin:<br /><iframe width='560' height='315' src='https://www.youtube.com/embed/-AwTj0pfooo?list=PLEndQUuhlvSoTRGeY6nWXbxbhmgepTyLi' frameborder='0' allowfullscreen></iframe></p></div><div class='upcp-pointer-count'><p>6 of 6 - <span class='upcp-skip-all-tutorial-pop-ups'>Skip All</span></p></div>",
    'anchor_id' => '#wp-admin-bar-site-name',
    'edge'      => 'top',
    'align'     => 'left',
    'nextTab'   => 'Dashboard',
    'width'     => '600',
    'where'     => array( 'toplevel_page_UPCP-options') // <-- Please note this
  );
  
  return $pointers; 
}

?>