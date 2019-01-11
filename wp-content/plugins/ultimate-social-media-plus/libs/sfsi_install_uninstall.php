<?php
function sfsi_plus_update_plugin()
{
	if($feed_id = sanitize_text_field(get_option('sfsi_plus_feed_id')))
	{
		if(is_numeric($feed_id))
		{
			$sfsiId = SFSI_PLUS_updateFeedUrl();
			update_option('sfsi_plus_feed_id'		, sanitize_text_field($sfsiId->feed_id));
			update_option('sfsi_plus_redirect_url'	, sanitize_text_field($sfsiId->redirect_url));
		}
	}
	
	//Install version
	update_option("sfsi_plus_pluginVersion", "3.00");
	
	if(!get_option('sfsi_plus_serverphpVersionnotification'))
	{
		add_option("sfsi_plus_serverphpVersionnotification", "yes");
	}
	/* show notification on about mobile setting */
	if(!get_option('sfsi_plus_show_Setting_mobile_notification'))
	{
		add_option("sfsi_plus_show_Setting_mobile_notification", "yes");
	}
	/* show premium notification */
	if(!get_option('sfsi_plus_show_premium_notification'))
	{
		add_option("sfsi_plus_show_premium_notification", "yes");
	}
	if(!get_option('sfsi_plus_show_premium_cumulative_count_notification'))
	{
		add_option("sfsi_plus_show_premium_cumulative_count_notification", "yes");
	}	
	/*show notification*/
	if(!get_option('sfsi_plus_show_notification'))
	{
		add_option("sfsi_plus_show_notification", "yes");
	}
	/* show new notification*/
	if(!get_option('sfsi_plus_new_show_notification'))
	{
		add_option("sfsi_plus_new_show_notification", "no");
	}

	add_option('sfsi_plus_footer_sec','no');
	
	/* subscription form */
    $options9 = array('sfsi_plus_form_adjustment'=>'yes',
        'sfsi_plus_form_height'=>'180',
        'sfsi_plus_form_width' =>'230',
        'sfsi_plus_form_border'=>'yes',
        'sfsi_plus_form_border_thickness'=>'1',
        'sfsi_plus_form_border_color'=>'#b5b5b5',
        'sfsi_plus_form_background'=>'#ffffff',
		
        'sfsi_plus_form_heading_text'=>'Get new posts by email:',
        'sfsi_plus_form_heading_font'=>'Helvetica,Arial,sans-serif',
        'sfsi_plus_form_heading_fontstyle'=>'bold',
        'sfsi_plus_form_heading_fontcolor'=>'#000000',
        'sfsi_plus_form_heading_fontsize'=>'16',
        'sfsi_plus_form_heading_fontalign'=>'center',
		
		'sfsi_plus_form_field_text'=>'Enter your email',
        'sfsi_plus_form_field_font'=>'Helvetica,Arial,sans-serif',
        'sfsi_plus_form_field_fontstyle'=>'normal',
        'sfsi_plus_form_field_fontcolor'=>'#000000',
        'sfsi_plus_form_field_fontsize'=>'14',
        'sfsi_plus_form_field_fontalign'=>'center',
		
		'sfsi_plus_form_button_text'=>'Subscribe',
        'sfsi_plus_form_button_font'=>'Helvetica,Arial,sans-serif',
        'sfsi_plus_form_button_fontstyle'=>'bold',
        'sfsi_plus_form_button_fontcolor'=>'#000000',
        'sfsi_plus_form_button_fontsize'=>'16',
        'sfsi_plus_form_button_fontalign'=>'center',
        'sfsi_plus_form_button_background'=>'#dedede',
    );
	add_option('sfsi_plus_section9_options',  serialize($options9));
	
	/*Extra important options*/
	$sfsi_plus_instagram_sf_count = array(
		"date" => strtotime(date("Y-m-d")),
		"sfsi_plus_sf_count" => "",
		"sfsi_plus_instagram_count" => ""
	);
	add_option('sfsi_plus_instagram_sf_count',  serialize($sfsi_plus_instagram_sf_count));
	
	/*Float Icon setting*/
	$option8 = unserialize(get_option('sfsi_plus_section8_options',false));
	if(isset($option8) && !empty($option8) && !isset($option8['sfsi_plus_icons_floatMargin_top']))
	{
		$option8['sfsi_plus_icons_floatMargin_top'] = '';
		$option8['sfsi_plus_icons_floatMargin_bottom'] = '';
		$option8['sfsi_plus_icons_floatMargin_left'] = '';
		$option8['sfsi_plus_icons_floatMargin_right'] = '';
		update_option('sfsi_plus_section8_options', serialize($option8));
	}
	if(isset($option8) && !empty($option8))
	{
		if(!isset($option8['sfsi_plus_rectpinit']))
		{
			$option8['sfsi_plus_rectpinit'] = 'no';
		}
		if(!isset($option8['sfsi_plus_rectfbshare']))
		{
			$option8['sfsi_plus_rectfbshare'] = 'no';
		}
		update_option('sfsi_plus_section8_options', serialize($option8));
	}
	
	/*Language icons*/
	$option5 =  unserialize(get_option('sfsi_plus_section5_options',false));
	
	if(isset($option5) && !empty($option5))
	{
		if(!isset($option5['sfsi_plus_follow_icons_language'])){
			$option5['sfsi_plus_follow_icons_language']   = 'Follow_en_US';			
		}
		if(!isset($option5['sfsi_plus_facebook_icons_language'])){
			$option5['sfsi_plus_facebook_icons_language']   = 'Visit_us_en_US';			
		}
		if(!isset($option5['sfsi_plus_twitter_icons_language'])){
			$option5['sfsi_plus_twitter_icons_language']   = 'Visit_us_en_US';			
		}
		if(!isset($option5['sfsi_plus_google_icons_language'])){
			$option5['sfsi_plus_google_icons_language']   = 'Visit_us_en_US';			
		}
		if(!isset($option5['sfsi_plus_icons_language'])){
			$option5['sfsi_plus_icons_language']   = 'en_US';			
		}								

		if(!isset($option5['sfsi_plus_premium_size_box'])){
			$option5['sfsi_plus_premium_size_box'] = 'no';			
		}
		if(!isset($option5['sfsi_plus_custom_social_hide'])){
			$option5['sfsi_plus_custom_social_hide'] = 'no';			
		}

        if(!isset($option5['sfsi_icons_suppress_errors'])){
        	
        	$sup_errors = "no";
        	$sup_errors_banner_dismissed = true;

        	if(defined('WP_DEBUG') && false != WP_DEBUG){
            	$sup_errors = 'yes';
            	$sup_errors_banner_dismissed = false;
        	}

            $option5['sfsi_icons_suppress_errors'] = $sup_errors;
            update_option('sfsi_error_reporting_notice_dismissed',$sup_errors_banner_dismissed);            
        }				
		update_option('sfsi_plus_section5_options', serialize($option5));
	}
	
	/*Youtube Channelid settings*/
	$option4 = unserialize(get_option('sfsi_plus_section4_options',false));
	if(isset($option4) && !empty($option4) && !isset($option4['sfsi_plus_youtube_channelId']))
	{
		$option4['sfsi_plus_youtube_channelId'] = '';
		update_option('sfsi_plus_section4_options', serialize($option4));
	}
	/* section1 */
	$option1 = unserialize(get_option('sfsi_plus_section1_options',false));
	if(isset($option1) && !empty($option1) && !isset($option1['sfsi_plus_premium_icons_box']))
	{
		$option1['sfsi_plus_premium_icons_box'] = 'no';
		update_option('sfsi_plus_section1_options', serialize($option1));
	}
	/* section2 */
	$option2 = unserialize(get_option('sfsi_plus_section2_options',false));
	if(isset($option2) && !empty($option2) && !isset($option2['sfsi_plus_premium_email_box']))
	{
		$option2['sfsi_plus_premium_email_box'] = 'no';
		$option2['sfsi_plus_premium_facebook_box'] = 'no';
		$option2['sfsi_plus_premium_twitter_box'] = 'no';
		$option2['sfsi_plus_premium_google_box'] = 'no';
		update_option('sfsi_plus_section2_options', serialize($option2));
	}
	/* section3 */
	$option3 = unserialize(get_option('sfsi_plus_section3_options',false));
	if(isset($option3) && !empty($option3))
	{		
		if(!isset($option3['sfsi_plus_mouseover_effect_type'])){
			$option3['sfsi_plus_mouseover_effect_type'] = 'same_icons';			
		}
		if(!isset($option3['mouseover_other_icons_transition_effect'])){
			$option3['mouseover_other_icons_transition_effect'] = 'flip';			
		}

		if(!isset($option3['sfsi_plus_premium_icons_design_box'])){
			$option3['sfsi_plus_premium_icons_design_box'] = 'no';			
		}

		update_option('sfsi_plus_section3_options', serialize($option3));
	}
	/* section4 */
	$option4 = unserialize(get_option('sfsi_plus_section4_options',false));
	if(isset($option4) && !empty($option4) && !isset($option4['sfsi_plus_premium_count_box']))
	{
		$option4['sfsi_plus_premium_count_box'] = 'no';
		update_option('sfsi_plus_section4_options', serialize($option4));
	}
	/* section7 */
	$option7 = unserialize(get_option('sfsi_plus_section7_options',false));
	if(isset($option7) && !empty($option7) && !isset($option7['sfsi_plus_premium_popup_box']))
	{
		$option7['sfsi_plus_premium_popup_box'] = 'no';
		update_option('sfsi_plus_section7_options', serialize($option7));
	}
	/* section8 */
	$option8 = unserialize(get_option('sfsi_plus_section8_options',false));
	if(isset($option8) && !empty($option8) && !isset($option8['sfsi_plus_show_premium_placement_box']))
	{
		$option8['sfsi_plus_show_premium_placement_box'] = 'no';
		update_option('sfsi_plus_section8_options', serialize($option8));
	}
	$option4 = unserialize(get_option('sfsi_plus_section4_options',false));
	if(isset($option4) && !empty($option4) && !isset($option4['sfsi_plus_instagram_clientid']))
	{
		$option4['sfsi_plus_instagram_clientid'] = '';
		$option4['sfsi_plus_instagram_appurl'] 	 = '';
		$option4['sfsi_plus_instagram_token']    = '';
		update_option('sfsi_plus_section4_options', serialize($option4));
	}

    // Add this removed in version 2.9.3, removing values from section 1 & section 6 & setting notice display value
    sfsi_plus_was_displaying_addthis();
}
function sfsi_plus_activate_plugin()
{
    /* check for CURL enable at server */
    add_option('sfsi_plus_plugin_do_activation_redirect', true);
    sfsi_plus_curl_enable_notice();	
    
    if(!get_option('sfsi_plus_new_show_notification'))
	{
		add_option("sfsi_plus_new_show_notification", "yes");
	}
    
    if(!get_option('sfsi_plus_show_premium_cumulative_count_notification'))
	{
		add_option("sfsi_plus_show_premium_cumulative_count_notification", "yes");
	}    


    $options1=array('sfsi_plus_rss_display'=>'yes',
          'sfsi_plus_email_display'=>'yes',
          'sfsi_plus_facebook_display'=>'yes',
          'sfsi_plus_twitter_display'=>'yes',
          'sfsi_plus_google_display'=>'yes',
          'sfsi_plus_pinterest_display'=>'no',
	  	  'sfsi_plus_instagram_display'=>'no',
          'sfsi_plus_linkedin_display'=>'no',
          'sfsi_plus_youtube_display'=>'no',
		  'sfsi_plus_houzz_display'=>'no',
          'sfsi_custom_display'=>'',
          'sfsi_custom_files'=>'',
          'sfsi_plus_premium_icons_box' =>'yes',
          );
	add_option('sfsi_plus_section1_options',  serialize($options1));
    
	if(get_option('sfsi_plus_feed_id') && get_option('sfsi_plus_redirect_url'))
	{
		$sffeeds["feed_id"] 		= sanitize_text_field(get_option('sfsi_plus_feed_id'));
		$sffeeds["redirect_url"] 	= sanitize_text_field(get_option('sfsi_plus_redirect_url'));
		$sffeeds = (object)$sffeeds;
	}
    else
	{
		$sffeeds = SFSI_PLUS_getFeedUrl();
	}
	
    /* Links and icons  options */	 
    $options2=array('sfsi_plus_rss_url'=>sfsi_plus_get_bloginfo('rss2_url'),
        'sfsi_plus_rss_icons'=>'subscribe', 
        'sfsi_plus_email_url'=>$sffeeds->redirect_url,
        'sfsi_plus_facebookPage_option'=>'no',
        'sfsi_plus_facebookPage_url'=>'',
        'sfsi_plus_facebookLike_option'=>'yes',
        'sfsi_plus_facebookShare_option'=>'yes',
        'sfsi_plus_twitter_followme'=>'no',
        'sfsi_plus_twitter_followUserName'=>'',
        'sfsi_plus_twitter_aboutPage'=>'yes',
		'sfsi_plus_twitter_page'=>'no',
        'sfsi_plus_twitter_pageURL'=>'',
        'sfsi_plus_twitter_aboutPageText'=>'Hey, check out this cool site I found: www.yourname.com #Topic via@my_twitter_name',
        'sfsi_plus_google_page'=>'no',
        'sfsi_plus_google_pageURL'=>'',
        /*'sfsi_plus_googleLike_option'=>'yes',*/
        'sfsi_plus_googleShare_option'=>'yes',
        'sfsi_plus_youtube_pageUrl'=>'',
        'sfsi_plus_youtube_page'=>'no',
        'sfsi_plus_youtube_follow'=>'no',
		'sfsi_plus_youtubeusernameorid'=>'name',
		'sfsi_plus_ytube_chnlid'=>'',
		'sfsi_plus_ytube_user'=>'',
        'sfsi_plus_pinterest_page'=>'no',
        'sfsi_plus_pinterest_pageUrl'=>'',
        'sfsi_plus_pinterest_pingBlog'=>'',
	 	'sfsi_plus_instagram_page'=>'no',
        'sfsi_plus_instagram_pageUrl'=>'',
		'sfsi_plus_houzz_pageUrl'=>'',
		'sfsi_plus_linkedin_page'=>'no',
        'sfsi_plus_linkedin_pageURL'=>'',
        'sfsi_plus_linkedin_follow'=>'no',
        'sfsi_plus_linkedin_followCompany'=>'',
        'sfsi_plus_linkedin_SharePage'=>'yes',
        'sfsi_plus_linkedin_recommendBusines'=>'no',
        'sfsi_plus_linkedin_recommendCompany'=>'',
        'sfsi_plus_linkedin_recommendProductId'=>'',
        'sfsi_plus_CustomIcon_links'=>'',
        'sfsi_plus_premium_email_box'=>'yes',
        'sfsi_plus_premium_facebook_box'=>'yes',
        'sfsi_plus_premium_twitter_box'=>'yes',
        'sfsi_plus_premium_google_box'=>'yes',
        );
	add_option('sfsi_plus_section2_options',  serialize($options2));
    
	/* Design and animation option  */
	$options3= array(
		'sfsi_plus_mouseOver'				=>'no',
        'sfsi_plus_mouseOver_effect'		=>'fade_in',
		'sfsi_plus_mouseover_effect_type' 	=> 'same_icons',			
		'mouseover_other_icons_transition_effect' => 'flip',
        'sfsi_plus_shuffle_icons'			=>'no',
        'sfsi_plus_shuffle_Firstload'		=>'no',
        'sfsi_plus_shuffle_interval'		=>'no',
        'sfsi_plus_shuffle_intervalTime'	=>'',                              
        'sfsi_plus_actvite_theme'			=>'default',
        'sfsi_plus_premium_icons_design_box'=>'yes',        
        );

	add_option('sfsi_plus_section3_options',  serialize($options3));
	
	/* display counts options */         
    $options4=array('sfsi_plus_display_counts'=>'no',
        'sfsi_plus_email_countsDisplay'=>'no',
        'sfsi_plus_email_countsFrom'=>'source',
        'sfsi_plus_email_manualCounts'=>'20',
        'sfsi_plus_rss_countsDisplay'=>'no',
        'sfsi_plus_rss_manualCounts'=>'20',
        'sfsi_plus_facebook_PageLink'=>'',
        'sfsi_plus_facebook_countsDisplay'=>'no',
        'sfsi_plus_facebook_countsFrom'=>'manual',
        'sfsi_plus_facebook_manualCounts'=>'20',
        'sfsi_plus_twitter_countsDisplay'=>'no',
        'sfsi_plus_twitter_countsFrom'=>'manual',
        'sfsi_plus_twitter_manualCounts'=>'20',
        'sfsi_plus_google_api_key'=>'',   
        'sfsi_plus_google_countsDisplay'=>'no',
        'sfsi_plus_google_countsFrom'=>'manual',
        'sfsi_plus_google_manualCounts'=>'20',
        'sfsi_plus_linkedIn_countsDisplay'=>'no',
        'sfsi_plus_linkedIn_countsFrom'=>'manual',
        'sfsi_plus_linkedIn_manualCounts'=>'20',
        'sfsi_plus_ln_api_key'=>'',
        'sfsi_plus_ln_secret_key'=>'',
        'sfsi_plus_ln_oAuth_user_token'=>'',
        'sfsi_plus_ln_company'=>'',
		'sfsi_plus_youtube_user'=>'',
		'sfsi_plus_youtube_channelId'=>'',
		'sfsi_plus_youtube_countsDisplay'=>'no',
        'sfsi_plus_youtube_countsFrom'=>'manual',
        'sfsi_plus_youtube_manualCounts'=>'20',
        'sfsi_plus_pinterest_countsDisplay'=>'no',
        'sfsi_plus_pinterest_countsFrom'=>'manual',
        'sfsi_plus_pinterest_manualCounts'=>'20',
        'sfsi_plus_pinterest_user'=>'',
        'sfsi_plus_pinterest_board'=>'',
		'sfsi_plus_instagram_countsFrom'=>'manual',
		'sfsi_plus_instagram_countsDisplay'=>'no',
		'sfsi_plus_instagram_manualCounts'=>'20',
		'sfsi_plus_instagram_User'=>'',
		'sfsi_plus_instagram_clientid'=>'',
		'sfsi_plus_instagram_appurl'  =>'',
		'sfsi_plus_instagram_token'   =>'',
		'sfsi_plus_houzz_countsDisplay'=>'no',
        'sfsi_plus_houzz_countsFrom'=>'manual',
        'sfsi_plus_houzz_manualCounts'=>'20',
         'sfsi_plus_premium_count_box'=>'yes',
        );
	add_option('sfsi_plus_section4_options',  serialize($options4));
  
    $options5=array('sfsi_plus_icons_size'=>'40',
        'sfsi_plus_icons_spacing'=>'5',
        'sfsi_plus_icons_Alignment'=>'left',
        'sfsi_plus_icons_perRow'=>'5',
		'sfsi_plus_follow_icons_language'=>'Follow_en_US',
		'sfsi_plus_facebook_icons_language'=>'Visit_us_en_US',
		'sfsi_plus_twitter_icons_language'=>'Visit_us_en_US',
		'sfsi_plus_google_icons_language'=>'Visit_us_en_US',
		'sfsi_plus_icons_language'=>'en_US',
        'sfsi_plus_icons_ClickPageOpen'=>'yes',
        'sfsi_plus_icons_float'=>'no',
		'sfsi_plus_disable_floaticons'=>'no',
		'sfsi_plus_disable_viewport'=>'no',
        'sfsi_plus_icons_floatPosition'=>'center-right',
        'sfsi_plus_icons_stick'=>'no',
        'sfsi_plus_rssIcon_order'=>'1',
        'sfsi_plus_emailIcon_order'=>'2',
        'sfsi_plus_facebookIcon_order'=>'3',
        'sfsi_plus_googleIcon_order'=>'4',
        'sfsi_plus_twitterIcon_order'=>'5',
        'sfsi_plus_youtubeIcon_order'=>'7',
        'sfsi_plus_pinterestIcon_order'=>'8',
        'sfsi_plus_linkedinIcon_order'=>'9',
		'sfsi_plus_instagramIcon_order'=>'10',
		'sfsi_plus_houzzIcon_order'=>'11',
        'sfsi_plus_CustomIcons_order'=>'',
        'sfsi_plus_rss_MouseOverText'=>'RSS',
        'sfsi_plus_email_MouseOverText'=>'Follow by Email',
        'sfsi_plus_twitter_MouseOverText'=>'Twitter',
        'sfsi_plus_facebook_MouseOverText'=>'Facebook',
        'sfsi_plus_google_MouseOverText'=>'Google+',
        'sfsi_plus_linkedIn_MouseOverText'=>'LinkedIn',
        'sfsi_plus_pinterest_MouseOverText'=>'Pinterest',
		'sfsi_plus_instagram_MouseOverText'=>'Instagram',
		'sfsi_plus_houzz_MouseOverText'=>'Houzz',
        'sfsi_plus_youtube_MouseOverText'=>'YouTube',
        'sfsi_plus_custom_MouseOverTexts'=>'',
        'sfsi_plus_premium_size_box'=>'yes',
        'sfsi_plus_custom_social_hide'=>'no',
        'sfsi_pplus_icons_suppress_errors'=>'no',
    );
	add_option('sfsi_plus_section5_options',  serialize($options5));
    
	/* post options */	                
    $options6=array('sfsi_plus_show_Onposts'=>'no',
        'sfsi_plus_show_Onbottom'=>'no',
        'sfsi_plus_icons_postPositon'=>'source',
        'sfsi_plus_icons_alignment'=>'center-right',
        'sfsi_plus_rss_countsDisplay'=>'no',
        'sfsi_plus_textBefor_icons'=>'Please follow and like us:',
        'sfsi_plus_icons_DisplayCounts'=>'no');
	add_option('sfsi_plus_section6_options',  serialize($options6));       
    
	/* icons pop options */
    $options7=array('sfsi_plus_show_popup'=>'no',
        'sfsi_plus_popup_text'=>'Enjoy this blog? Please spread the word :)',
        'sfsi_plus_popup_background_color'=>'#eff7f7',
        'sfsi_plus_popup_border_color'=>'#f3faf2',
        'sfsi_plus_popup_border_thickness'=>'1',
        'sfsi_plus_popup_border_shadow'=>'yes',
        'sfsi_plus_popup_font'=>'Helvetica,Arial,sans-serif',
        'sfsi_plus_popup_fontSize'=>'30',
        'sfsi_plus_popup_fontStyle'=>'normal',
        'sfsi_plus_popup_fontColor'=>'#000000',
        'sfsi_plus_Show_popupOn'=>'none',
        'sfsi_plus_Show_popupOn_PageIDs'=>'',
        'sfsi_plus_Shown_pop'=>'ETscroll',
        'sfsi_plus_Shown_popupOnceTime'=>'',
        'sfsi_plus_Shown_popuplimitPerUserTime'=>'',
        'sfsi_plus_premium_popup_box' =>'yes',
        
        );
	add_option('sfsi_plus_section7_options',  serialize($options7));
	
	/*options that are added in the third question*/
	if(get_option('sfsi_plus_section4_options',false))
		$option4=  unserialize(get_option('sfsi_plus_section4_options',false));
	if(get_option('sfsi_plus_section5_options',false))	
		$option5=  unserialize(get_option('sfsi_plus_section5_options',false));
	if(get_option('sfsi_plus_section6_options',false))	
		$option6=  unserialize(get_option('sfsi_plus_section6_options',false));
	
	/*if($option6['sfsi_plus_show_Onposts'] == 'yes')
	{
		$sfsi_plus_display_button_type = 'standard_buttons';
	}
	else
	{
		$sfsi_plus_display_button_type = '';
	}*/
	
	$options8 = array(
		'sfsi_plus_show_via_widget'=>'no',
        'sfsi_plus_float_on_page'=> $option5['sfsi_plus_icons_float'],
        'sfsi_plus_float_page_position'=>$option5['sfsi_plus_icons_floatPosition'],
		'sfsi_plus_icons_floatMargin_top'=>'',
		'sfsi_plus_icons_floatMargin_bottom'=>'',
		'sfsi_plus_icons_floatMargin_left'=>'',
		'sfsi_plus_icons_floatMargin_right'=>'',
        'sfsi_plus_post_icons_size'=>$option5['sfsi_plus_icons_size'],
        'sfsi_plus_post_icons_spacing'=>$option5['sfsi_plus_icons_spacing'],
		'sfsi_plus_show_Onposts'=>$option6['sfsi_plus_show_Onposts'],
		'sfsi_plus_textBefor_icons'=>$option6['sfsi_plus_textBefor_icons'],
		'sfsi_plus_icons_alignment'=>$option6['sfsi_plus_icons_alignment'],
		'sfsi_plus_icons_DisplayCounts'=>$option6['sfsi_plus_icons_DisplayCounts'],
		'sfsi_plus_place_item_manually'=>'no',
        /*'sfsi_plus_show_item_onposts'=>'no',*/
		'sfsi_plus_show_item_onposts'=> $option6['sfsi_plus_show_Onposts'],
		'sfsi_plus_display_button_type'=> 'standard_buttons',
        'sfsi_plus_display_before_posts'=>'no',
		'sfsi_plus_display_after_posts'=>$option6['sfsi_plus_show_Onposts'],
		'sfsi_plus_display_on_postspage'=>'no',
		'sfsi_plus_display_on_homepage'=>'no',
		'sfsi_plus_display_before_blogposts'=>'no',
		'sfsi_plus_display_after_blogposts'=>'no',
		'sfsi_plus_rectsub'=>'yes',
		'sfsi_plus_rectfb'=>'yes',
		'sfsi_plus_rectgp'=>'yes',
		'sfsi_plus_recttwtr'=>'yes',
		'sfsi_plus_rectpinit'=>'yes',
		'sfsi_plus_rectfbshare'=>'yes',
	    'sfsi_plus_show_premium_placement_box'=>'yes');

	add_option('sfsi_plus_section8_options',  serialize($options8));		
	
	/*Some additional option added*/	
	update_option('sfsi_plus_feed_id'		, sanitize_text_field($sffeeds->feed_id));
	update_option('sfsi_plus_redirect_url'	, sanitize_text_field($sffeeds->redirect_url));
	
	add_option('sfsi_plus_installDate',date('Y-m-d h:i:s'));
	add_option('sfsi_plus_RatingDiv','no');
	update_option('sfsi_plus_activate', 1);
	
	/*Changes in option 2*/
	$get_option2 = unserialize(get_option('sfsi_plus_section2_options',false));
	$get_option2['sfsi_plus_email_url'] = $sffeeds->redirect_url;
	update_option('sfsi_plus_section2_options', serialize($get_option2));
	
	$addThisDismissed = get_option('sfsi_addThis_icon_removal_notice_dismissed',false);

    if(!isset($addThisDismissed)){
        update_option('sfsi_addThis_icon_removal_notice_dismissed',true);
    }

	/*Activation Setup for (specificfeed)*/
	sfsi_plus_setUpfeeds($sffeeds->feed_id);
	sfsi_plus_updateFeedPing('N',$sffeeds->feed_id);
	
	/*Extra important options*/
	$sfsi_plus_instagram_sf_count = array(
		"date" => strtotime(date("Y-m-d")),
		"sfsi_plus_sf_count" => "",
		"sfsi_plus_instagram_count" => ""
	);
	add_option('sfsi_plus_instagram_sf_count',  serialize($sfsi_plus_instagram_sf_count));
}
/* end function  */
/* deactivate plugin */
function sfsi_plus_deactivate_plugin()
{
     global $wpdb;
     sfsi_plus_updateFeedPing('Y',sanitize_text_field(get_option('sfsi_plus_feed_id')));
     
} /* end function  */
function sfsi_plus_updateFeedPing($status,$feed_id)
{
    $curl = curl_init();  
     
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://www.specificfeeds.com/wordpress/pingfeed',
        CURLOPT_USERAGENT => 'sf rss request',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'feed_id' => $feed_id,
            'status' => $status
        )
    ));
     // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $resp=json_decode($resp);
        curl_close($curl);
        
}
/* unistall plugin function */	
function sfsi_plus_Unistall_plugin()
{   global $wpdb;
    /* Delete option for which icons to display */
    delete_option('sfsi_plus_section1_options');
    delete_option('sfsi_plus_section2_options');
    delete_option('sfsi_plus_section3_options');
    delete_option('sfsi_plus_section4_options');
    delete_option('sfsi_plus_section5_options');
    delete_option('sfsi_plus_section6_options');
    delete_option('sfsi_plus_section7_options');
	delete_option('sfsi_plus_section8_options');
	delete_option('sfsi_plus_section9_options');
    delete_option('sfsi_plus_feed_id');
	delete_option('sfsi_plus_redirect_url');
    delete_option('sfsi_plus_footer_sec');
    delete_option('sfsi_plus_activate');
	delete_option("sfsi_plus_pluginVersion");
	delete_option("sfsi_plus_verificatiom_code");
	delete_option("sfsi_plus_curlErrorNotices");
	delete_option("sfsi_plus_curlErrorMessage");

	delete_option("adding_plustags");
	delete_option("sfsi_plus_installDate");
	delete_option("sfsi_plus_RatingDiv");
	delete_option("sfsi_plus_instagram_sf_count");
	delete_option("sfsi_plus_new_show_notification");
	delete_option("sfsi_plus_show_Setting_mobile_notification");
	delete_option("sfsi_plus_show_premium_notification");
	delete_option("sfsi_plus_show_notification");
	delete_option('sfsi_plus_serverphpVersionnotification');
	delete_option("sfsi_plus_show_premium_cumulative_count_notification");
    
    delete_option("sfsi_addThis_icon_removal_notice_dismissed");
    delete_option('widget_sfsi-plus-widget');
	delete_option('widget_sfsiplus_subscriber_widget');

	delete_option('fs_active_plugins');
	delete_option('fs_accounts');
	delete_option('fs_api_cache');
	delete_option('fs_debug_mode'); 	
}
/* end function */
/* check CUrl */
function sfsi_plus_curl_enable_notice(){
    if(!function_exists('curl_init')) {
	echo '<div class="error"><p> '.__('Error: It seems that CURL is disabled on your server. Please contact your server administrator to install / enable CURL.',SFSI_PLUS_DOMAIN).'</p></div>'; die;
    }
}
	
/* add admin menus */
function sfsi_plus_admin_menu() {
	add_menu_page(
		'Ultimate Social Media PLUS',
		'Ultimate Social Media PLUS',
		'administrator',
		'sfsi-plus-options',
		'sfsi_plus_options_page',
		plugins_url( 'images/logo.png' , dirname(__FILE__) )
	);
}
function sfsi_plus_options_page(){ include SFSI_PLUS_DOCROOT . '/views/sfsi_options_view.php';	} /* end function  */
function sfsi_plus_about_page(){ include SFSI_PLUS_DOCROOT . '/views/sfsi_aboutus.php';	} /* end function  */
if ( is_admin() ){
    add_action('admin_menu', 'sfsi_plus_admin_menu');
}
/* fetch rss url from specificfeeds */ 
function SFSI_PLUS_getFeedUrl()
{
    $curl = curl_init();  
     
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://www.specificfeeds.com/wordpress/plugin_setup',
        CURLOPT_USERAGENT => 'sf rss request',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'web_url'	=> get_bloginfo('url'),
            'feed_url'	=> sfsi_plus_get_bloginfo('rss2_url'),
            'email'		=> '',
			'subscriber_type' => 'PLWP'
        )
    ));
    // Send the request & save response to $resp
	$resp = curl_exec($curl);
	if(curl_errno($curl))
	{
		update_option("sfsi_plus_curlErrorNotices", "yes");
		update_option("sfsi_plus_curlErrorMessage", curl_errno($curl));
	}
	$resp = json_decode($resp);
	curl_close($curl);
		
	$feed_url = stripslashes_deep($resp->redirect_url);
	return $resp;exit;
}
/* fetch rss url from specificfeeds on */ 
function SFSI_PLUS_updateFeedUrl()
{
    $curl = curl_init();  
     
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://www.specificfeeds.com/wordpress/updateFeedPlugin',
        CURLOPT_USERAGENT => 'sf rss request',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
			'feed_id' 	=> sanitize_text_field(get_option('sfsi_plus_feed_id')),
            'web_url' 	=> get_bloginfo('url'),
            'feed_url' 	=> sfsi_plus_get_bloginfo('rss2_url'),
            'email'		=> ''
        )
    ));
 	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	$resp = json_decode($resp);
	curl_close($curl);
	
	$feed_url = stripslashes_deep($resp->redirect_url);
	return $resp;exit;
}
/* add sf tags */
function sfsi_plus_setUpfeeds($feed_id)
{
	$curl = curl_init();  
	curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https//www.specificfeeds.com/rssegtcrons/download_rssmorefeed_data_single/'.$feed_id."/Y",
        CURLOPT_USERAGENT => 'sf rss request',
        CURLOPT_POST => 0      
	));
	$resp = curl_exec($curl);
	curl_close($curl);	
}
/* admin notice if wp_head is missing in active theme */
function sfsi_plus_check_wp_head() {
	
	$template_directory = get_template_directory();
	$header = $template_directory . '/header.php';
	
	if (is_file($header)) {
		
	    $search_header = "wp_head";
	    $file_lines = @file($header);
	    $foind_header=0;
	    foreach ($file_lines as $line)
		{
		    $searchCount = substr_count($line, $search_header);
		    if ($searchCount > 0)
			{
			    return true;
		    }
		}
	    $path=pathinfo($_SERVER['REQUEST_URI']);
	    if($path['basename']=="themes.php" || $path['basename']=="theme-editor.php" || $path['basename']=="admin.php?page=sfsi-plus-options")
	    {
	    	$currentTheme = wp_get_theme();
	    		    	
	    	if(isset($currentTheme) && !empty($currentTheme) && $currentTheme->get( 'Name' ) != "Customizr"){

	    		echo "<div class=\"error\" ><p>". __( 'Error : Please fix your theme to make plugins work correctly. Go to the Theme Editor and insert the following string:', SFSI_PLUS_DOMAIN )." &lt;?php wp_head(); ?&gt; ".__('Please enter it just before the following line of your header.php file:',SFSI_PLUS_DOMAIN)." &lt;/head&gt; ".__('Go to your theme editor: ',SFSI_PLUS_DOMAIN)."<a href=\"theme-editor.php\">".__('click here', SFSI_PLUS_DOMAIN )."</a>.</p></div>";	    		
	    	}
			
		}		
	}
}
/* admin notice if wp_footer is missing in active theme */
function sfsi_plus_check_wp_footer() {
    $template_directory = get_template_directory();
    $footer = $template_directory . '/footer.php';
 
	if (is_file($footer)) {
		$search_string = "wp_footer";
		$file_lines = @file($footer);
		
		foreach ($file_lines as $line) {
			$searchCount = substr_count($line, $search_string);
			if ($searchCount > 0) {
				return true;
			}
		}
		$path=pathinfo($_SERVER['REQUEST_URI']);
		
		if($path['basename']=="themes.php" || $path['basename']=="theme-editor.php" || $path['basename']=="admin.php?page=sfsi-plus-options")
		{
			echo "<div class=\"error\" ><p>".	__("Error: Please fix your theme to make plugins work correctly. Go to the Theme Editor and insert the following string as the first line of your theme's footer.php file: ", SFSI_PLUS_DOMAIN)." &lt;?php wp_footer(); ?&gt; ".__("Go to your theme editor: ", SFSI_PLUS_DOMAIN)."<a href=\"theme-editor.php\">".__('click here', SFSI_PLUS_DOMAIN )."</a>.</p></div>";
		} 	    
	}
}
/* admin notice for first time installation */
function sfsi_plus_activation_msg()
{
	global $wp_version;
	
	if(get_option('sfsi_plus_activate',false)==1)
	{
		echo "<div class='updated'><p>".__("Thank you for installing the Ultimate Social Media PLUS plugin. Please go to the plugin's settings page to configure it: ",SFSI_PLUS_DOMAIN)."<b><a href='admin.php?page=sfsi-plus-options'>".__("Click here",SFSI_PLUS_DOMAIN)."</a></b></p></div>";
		update_option('sfsi_plus_activate',0);
	}
	
	$path=pathinfo($_SERVER['REQUEST_URI']);
	update_option('sfsi_plus_activate',0);		
	
	if($wp_version < 3.5 && $path['basename'] == "admin.php?page=sfsi-plus-options")
	{
		echo "<div class=\"update-nag\" ><p><b>".__('You`re using an old Wordpress version, which may cause several of your plugins to not work correctly. Please upgrade', SFSI_PLUS_DOMAIN)."</b></p></div>"; 
	}
}
/* admin notice for first time installation */
function sfsi_plus_rating_msg()
{
    global $wp_version;
    $install_date = get_option('sfsi_plus_installDate');
    $display_date = date('Y-m-d h:i:s');
	$datetime1 = new DateTime($install_date);
	$datetime2 = new DateTime($display_date);
	$diff_inrval = round(($datetime2->format('U') - $datetime1->format('U')) / (60*60*24));

	if($diff_inrval >= 30 && get_option('sfsi_plus_RatingDiv')=="no")
	{ ?>
		<style type="text/css">
        .sfsi_plus_plg-rating-dismiss:before {
            background: none;
            color: #72777c;
            content: "\f153";
            display: block;
            font: normal 16px/20px dashicons;
            speak: none;
            height: 20px;
            text-align: center;
            width: 20px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }      
        .sfsi_plus_plg-rating-dismiss{
            position: absolute;
            top: 45px;
            right: 15px;
            border: none;
            margin: 0;
            padding: 9px;
            background: none;
            color: #72777c;
            cursor: pointer;
        }
      </style>
	 <div class="sfsi_plus_sfwp_fivestar notice notice-success">
    	<p><?php echo __('We noticed you\'ve been using the Ultimate Social Media PLUS Plugin for more than 30 days. If you\'re happy with it, could you please do us a BIG favor and let us know ONE thing we can improve in it?', SFSI_PLUS_DOMAIN);?></p>
        <ul class="sfwp_fivestar_ul">
        	<li><a href="https://wordpress.org/support/plugin/ultimate-social-media-plus#new-topic-0" target="_new" title="<?php echo __('Yes, let me give feedback.',SFSI_PLUS_DOMAIN); ?>"><?php echo __('Yes, let me give feedback.', SFSI_PLUS_DOMAIN); ?></a></li>
            <li><a href="https://wordpress.org/support/plugin/ultimate-social-media-plus/reviews/?filter=5" target="_new" title="<?php echo __('No clue, let me give a 5-star rating instead',SFSI_PLUS_DOMAIN) ?>"><?php echo __('No clue, let me give a 5-star rating instead',SFSI_PLUS_DOMAIN) ?></a></li>
            <li><a href="javascript:void(0);" class="sfsiHideRating" title="<?php echo __('I already did', SFSI_PLUS_DOMAIN)?>"> <?php echo __('I already did (don\'t show this again)', SFSI_PLUS_DOMAIN); ?> </a></li>
        </ul>
        <button type="button" class="sfsi_plus_plg-rating-dismiss"><span class="screen-reader-text"><?php echo __('Dismiss this notice.',SFSI_PLUS_DOMAIN); ?></span></button>    
    </div>
    <script>
    jQuery( document ).ready(function( $ ) {
    	$('.sfsi_plus_plg-rating-dismiss').css({'top':$('.sfsi_plus_sfwp_fivestar')[0].offsetTop+'px'})
    	var sel1 = jQuery('.sfsiHideRating');
        var sel2 = jQuery('.sfsi_plus_plg-rating-dismiss');
		function sfsi_plus_hide_rating(element){
		    element.on('click',function(){
		        var data={'action':'plushideRating'};
		        jQuery.ajax({
		    
			        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
			        type: "post",
			        data: data,
			        dataType: "json",
			        async: !0,
			        success: function(e) {
			            if (e=="success") {
			               jQuery('.sfsi_plus_sfwp_fivestar').slideUp('slow');
			            }
			        }
		     	});
		    });
		}
		sfsi_plus_hide_rating(sel1);
        sfsi_plus_hide_rating(sel2);
    });
    </script>
    <?php
   }
}
add_action('wp_ajax_plushideRating','sfsi_plusHideRatingDiv');
function sfsi_plusHideRatingDiv()
{
    update_option('sfsi_plus_RatingDiv','yes');
    echo  json_encode(array("success")); exit;
}
/* add all admin message */
add_action('admin_notices', 'sfsi_plus_activation_msg');
add_action('admin_notices', 'sfsi_plus_rating_msg');
add_action('admin_notices', 'sfsi_plus_check_wp_head');
add_action('admin_notices', 'sfsi_plus_check_wp_footer');
function sfsi_plus_pingVendor( $post_id )
{
    global $wp,$wpdb;
	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) )
		return;
		
	$post_data=get_post($post_id,ARRAY_A);
	if($post_data['post_status']=='publish' && $post_data['post_type']=='post') : 
		
		$categories = wp_get_post_categories($post_data['ID']);
		$cats='';
		$total=count($categories);
		$count=1;
		foreach($categories as $c)
		{	
			$cat_data = get_category( $c );
			if($count==$total)
			{
				$cats.= $cat_data->name;
			}
			else
			{
				$cats.= $cat_data->name.',';	
			}
			$count++;	
		}
		$postto_array = array(
			'feed_id'	=> sanitize_text_field(get_option('sfsi_plus_feed_id')),
			'title'		=> $post_data['post_title'],
			'description' => $post_data['post_content'],
			'link'		=> $post_data['guid'],
			'author'	=> get_the_author_meta('user_login', $post_data['post_author']),
			'category' 	=> $cats,
			'pubDate'	=> $post_data['post_modified'],
			'rssurl'	=> sfsi_plus_get_bloginfo('rss2_url')
		);
		
		$curl = curl_init();  
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://www.specificfeeds.com/wordpress/addpostdata ',
			CURLOPT_USERAGENT => 'sf rss request',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $postto_array
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$resp=json_decode($resp);
		curl_close($curl);
		return true;
    endif;
}
add_action( 'save_post', 'sfsi_plus_pingVendor' );

function sfsi_plus_was_displaying_addthis(){

    $isDismissed   =  true;
    $sfsi_plus_section1 =  unserialize(get_option('sfsi_plus_section1_options',false));
    $sfsi_plus_section8 =  unserialize(get_option('sfsi_plus_section8_options',false));
    $sfsi_plus_addThiswasDisplayed_section1 = isset($sfsi_plus_section1['sfsi_plus_share_display']) && 'yes'== sanitize_text_field($sfsi_plus_section1['sfsi_plus_share_display']);

    $sfsi_plus_addThiswasDisplayed_section8 = isset($sfsi_plus_section8['sfsi_plus_rectshr']) && 'yes'== sanitize_text_field($sfsi_plus_section8['sfsi_plus_rectshr']);

    $isDisplayed = $sfsi_plus_addThiswasDisplayed_section1 || $sfsi_plus_addThiswasDisplayed_section8;

    // If icon was displayed
    $isDismissed = false != $isDisplayed ? false : true;

    update_option('sfsi_plus_addThis_icon_removal_notice_dismissed',$isDismissed);

    if($sfsi_plus_addThiswasDisplayed_section1){
        unset($sfsi_plus_section1['sfsi_plus_share_display']);
        update_option('sfsi_plus_section1_options', serialize($sfsi_plus_section1) );
    }

    if($sfsi_plus_addThiswasDisplayed_section8){
        unset($sfsi_plus_section8['sfsi_plus_rectshr']);
        update_option('sfsi_plus_section8_options', serialize($sfsi_plus_section8) );
    }
}

?>