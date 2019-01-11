<?php 
/*  instalation of javascript and css  */
function sfsiplus_plugin_back_enqueue_script()
{		
	if(isset($_GET['page']))
	{
		if($_GET['page'] == 'sfsi-plus-options')
		{
			wp_enqueue_style('thickbox');
			wp_enqueue_style("SFSIPLUSmainCss", SFSI_PLUS_PLUGURL . 'css/sfsi-style.css' );
			/* include CSS for backend */
			wp_enqueue_style("SFSIPLUSmainadminCss", SFSI_PLUS_PLUGURL . 'css/sfsi-admin-style.css' );
			
			wp_enqueue_style("SFSIPLUSJqueryCSS", SFSI_PLUS_PLUGURL . 'css/jquery-ui-1.10.4/jquery-ui-min.css' );
			wp_enqueue_style("wp-color-picker");
		}
	}
		
	if(isset($_GET['page']))
	{
		if($_GET['page'] == 'sfsi-plus-options')
		{
			wp_enqueue_script('jquery');
			wp_enqueue_script("jquery-migrate");
			
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox'); 
			
			wp_enqueue_script("jquery-ui-accordion");	
			wp_enqueue_script("wp-color-picker");
			wp_enqueue_script("jquery-effects-core");
			wp_enqueue_script("jquery-ui-sortable");
				
			
			wp_register_script('SFSIPLUSJqueryFRM', SFSI_PLUS_PLUGURL . 'js/jquery.form-min.js', '', '', true);
			wp_enqueue_script("SFSIPLUSJqueryFRM");
			
			wp_register_script('SFSIPLUSCustomFormJs', SFSI_PLUS_PLUGURL . 'js/custom-form-min.js', '', '', true);
			wp_enqueue_script("SFSIPLUSCustomFormJs");
			
			wp_register_script('SFSIPLUSCustomJs', SFSI_PLUS_PLUGURL . 'js/custom-admin.js', '', '', true);
			
			// Localize the script with new data
			$translation_array = array(
				'Re_ad'                 => __('Read more',SFSI_PLUS_DOMAIN),
				'Sa_ve'                 => __('Save',SFSI_PLUS_DOMAIN),
				'Sav_ing'               => __('Saving',SFSI_PLUS_DOMAIN),
				'Sa_ved'                => __('Saved',SFSI_PLUS_DOMAIN)
			);
			$translation_array1 = array(
				'Coll_apse'             => __('Collapse',SFSI_PLUS_DOMAIN),
				'Save_All_Settings'     => __('Save All Settings',SFSI_PLUS_DOMAIN),
				'Upload_a'    			=> __('Upload a custom icon if you have other accounts/websites you want to link to.',SFSI_PLUS_DOMAIN),
				'It_depends'     		=> __('It depends',SFSI_PLUS_DOMAIN)
			);
			
			wp_localize_script( 'SFSIPLUSCustomJs', 'object_name', $translation_array );
			wp_localize_script( 'SFSIPLUSCustomJs', 'object_name1', $translation_array1 );
			wp_enqueue_script("SFSIPLUSCustomJs");
			
			wp_register_script('SFSIPLUSCustomValidateJs', SFSI_PLUS_PLUGURL . 'js/customValidate-min.js', '', '', true);
			wp_enqueue_script("SFSIPLUSCustomValidateJs");
			/* end cusotm js */
			
			/* initilaize the ajax url in javascript */
			wp_localize_script( 'SFSIPLUSCustomJs', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			wp_localize_script( 'SFSIPLUSCustomValidateJs', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'plugin_url'=> SFSI_PLUS_PLUGURL) );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'sfsiplus_plugin_back_enqueue_script' );

function sfsiplus_plugin_front_enqueue_script()
{
		wp_enqueue_style("SFSIPLUSmainCss", SFSI_PLUS_PLUGURL . 'css/sfsi-style.css' );
		$option5=  unserialize(get_option('sfsi_plus_section5_options',false));
		if($option5['sfsi_plus_disable_floaticons'] == 'yes')
		{
			wp_enqueue_style("disable_sfsiplus", SFSI_PLUS_PLUGURL . 'css/disable_sfsi.css' );
		}
		
		wp_enqueue_script('jquery');
	 	wp_enqueue_script("jquery-migrate");
		wp_enqueue_script('jquery-ui-core');	
		
		wp_register_script('SFSIPLUSjqueryModernizr', SFSI_PLUS_PLUGURL . 'js/shuffle/modernizr.custom.min.js', '','',true);
		wp_enqueue_script("SFSIPLUSjqueryModernizr");
		
		wp_register_script('SFSIPLUSjqueryShuffle', SFSI_PLUS_PLUGURL . 'js/shuffle/jquery.shuffle.min.js', '','',true);
		wp_enqueue_script("SFSIPLUSjqueryShuffle");
		
		wp_register_script('SFSIPLUSjqueryrandom-shuffle', SFSI_PLUS_PLUGURL . 'js/shuffle/random-shuffle-min.js', '','',true);
		wp_enqueue_script("SFSIPLUSjqueryrandom-shuffle");
		
		wp_register_script('SFSIPLUSCustomJs', SFSI_PLUS_PLUGURL . 'js/custom.js', '', '', true);
		wp_enqueue_script("SFSIPLUSCustomJs");
		/* end cusotm js */
		
		/* initilaize the ajax url in javascript */
		wp_localize_script( 'SFSIPLUSCustomJs', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ),'plugin_url'=> SFSI_PLUS_PLUGURL) );
}
add_action( 'wp_enqueue_scripts', 'sfsiplus_plugin_front_enqueue_script' );		
?>