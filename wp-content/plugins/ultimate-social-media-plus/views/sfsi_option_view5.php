<?php
	
	/* unserialize all saved option for  section 5 options */
    $icons = ($option1['sfsi_custom_files']) ? unserialize($option1['sfsi_custom_files']) : array() ;
	
	$option3 =  unserialize(get_option('sfsi_plus_section3_options',false));
	
	$option5 =  unserialize(get_option('sfsi_plus_section5_options',false));

	$custom_icons_order = unserialize($option5['sfsi_plus_CustomIcons_order']);
	$icons_order = array(
			$option5['sfsi_plus_rssIcon_order']			=>'rss',
			$option5['sfsi_plus_emailIcon_order']		=>'email',
			$option5['sfsi_plus_facebookIcon_order']	=>'facebook',
			$option5['sfsi_plus_googleIcon_order']		=>'google',
			$option5['sfsi_plus_twitterIcon_order']		=>'twitter',
			$option5['sfsi_plus_youtubeIcon_order']		=>'youtube',
			$option5['sfsi_plus_pinterestIcon_order']	=>'pinterest',
			$option5['sfsi_plus_linkedinIcon_order']	=>'linkedin',
			$option5['sfsi_plus_instagramIcon_order']	=>'instagram',
			(isset($option5['sfsi_plus_houzzIcon_order']))
			? $option5['sfsi_plus_houzzIcon_order']
			: 11 => 'houzz'
	);
	
	/*
	 * Sanitize, escape and validate values
	 */
	$option5['sfsi_plus_icons_size'] 			= 	(isset($option5['sfsi_plus_icons_size']))
														? intval($option5['sfsi_plus_icons_size'])
														: '';
	$option5['sfsi_plus_icons_spacing'] 		= 	(isset($option5['sfsi_plus_icons_spacing']))
														? intval($option5['sfsi_plus_icons_spacing'])
														: '';
	$option5['sfsi_plus_icons_Alignment'] 		= 	(isset($option5['sfsi_plus_icons_Alignment']))
														? sanitize_text_field($option5['sfsi_plus_icons_Alignment'])
														: '';
	$option5['sfsi_plus_icons_perRow'] 			= 	(isset($option5['sfsi_plus_icons_perRow']))
														? intval($option5['sfsi_plus_icons_perRow'])
														: '';
	$option5['sfsi_plus_follow_icons_language'] = 	(isset($option5['sfsi_plus_follow_icons_language']))
														? sanitize_text_field($option5['sfsi_plus_follow_icons_language'])
														: '';
	$option5['sfsi_plus_facebook_icons_language']= 	(isset($option5['sfsi_plus_facebook_icons_language']))
														? sanitize_text_field($option5['sfsi_plus_facebook_icons_language'])
														: '';
	$option5['sfsi_plus_twitter_icons_language']= 	(isset($option5['sfsi_plus_twitter_icons_language']))
														? sanitize_text_field($option5['sfsi_plus_twitter_icons_language'])
														: '';
	$option5['sfsi_plus_google_icons_language'] = 	(isset($option5['sfsi_plus_google_icons_language']))
														? sanitize_text_field($option5['sfsi_plus_google_icons_language'])
														: '';
	$option5['sfsi_plus_icons_ClickPageOpen']	= 	(isset($option5['sfsi_plus_icons_ClickPageOpen']))
														? sanitize_text_field($option5['sfsi_plus_icons_ClickPageOpen'])
														: '';
	$option5['sfsi_plus_disable_floaticons'] 	= 	(isset($option5['sfsi_plus_disable_floaticons']))
														? sanitize_text_field($option5['sfsi_plus_disable_floaticons'])
														: '';
	$option5['sfsi_plus_icons_stick'] 			= 	(isset($option5['sfsi_plus_icons_stick']))
														? sanitize_text_field($option5['sfsi_plus_icons_stick'])
														: '';
														
	$option5['sfsi_plus_rss_MouseOverText'] 	= 	(isset($option5['sfsi_plus_rss_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_rss_MouseOverText'])
														: '';
	$option5['sfsi_plus_email_MouseOverText'] 	= 	(isset($option5['sfsi_plus_email_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_email_MouseOverText'])
														: '';
	$option5['sfsi_plus_twitter_MouseOverText'] = 	(isset($option5['sfsi_plus_twitter_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_twitter_MouseOverText'])
														: '';
	$option5['sfsi_plus_facebook_MouseOverText']= 	(isset($option5['sfsi_plus_facebook_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_facebook_MouseOverText'])
														: '';
	$option5['sfsi_plus_google_MouseOverText'] 	= 	(isset($option5['sfsi_plus_google_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_google_MouseOverText'])
														: '';
	$option5['sfsi_plus_linkedIn_MouseOverText']= 	(isset($option5['sfsi_plus_linkedIn_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_linkedIn_MouseOverText'])
														: '';
	$option5['sfsi_plus_pinterest_MouseOverText']= 	(isset($option5['sfsi_plus_pinterest_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_pinterest_MouseOverText'])
														: '';
	$option5['sfsi_plus_youtube_MouseOverText'] = 	(isset($option5['sfsi_plus_youtube_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_youtube_MouseOverText'])
														: '';
	$option5['sfsi_plus_instagram_MouseOverText']= 	(isset($option5['sfsi_plus_instagram_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_instagram_MouseOverText'])
														: '';
	$option5['sfsi_plus_houzz_MouseOverText']	= 	(isset($option5['sfsi_plus_houzz_MouseOverText']))
														? sanitize_text_field($option5['sfsi_plus_houzz_MouseOverText'])
														: '';
    $option5['sfsi_plus_premium_size_box']		= 	(isset($option5['sfsi_plus_premium_size_box']))
														? sanitize_text_field($option5['sfsi_plus_premium_size_box'])
														: 'yes';

	$sfsi_icons_suppress_errors 				=   (isset($option5['sfsi_pplus_icons_suppress_errors']))
														? sanitize_text_field($option5['sfsi_pplus_icons_suppress_errors'])
														: 'no';
				
	$visit_iconsUrl = SFSI_PLUS_PLUGURL."images/visit_icons/";
  	if(is_array($custom_icons_order) ) 
	{
		foreach($custom_icons_order as $data)
		{
			$icons_order[$data['order']] = $data;
		}
	}
	ksort($icons_order);
	
	if(isset($option5['sfsi_plus_disable_viewport']))
	{
		$sfsi_plus_disable_viewport = $option5['sfsi_plus_disable_viewport'];	 
	}
	else
	{
		$sfsi_plus_disable_viewport = 'no';
	}
  
	function selectoption($name, $follow, $visitme)
	{	
		$visit_iconsUrl = SFSI_PLUS_PLUGURL."images/visit_icons/"; 
		if($name == "sfsi_plus_follow_icons_language")
		{
			$visit_icon = $visit_iconsUrl."Follow";
		}
		elseif($name == "sfsi_plus_facebook_icons_language")
		{
			$visit_icon = $visit_iconsUrl."Visit_us_fb";
		}
		elseif($name == "sfsi_plus_twitter_icons_language")
		{
			$visit_icon = $visit_iconsUrl."Visit_us_twitter";
		}
		elseif($name == "sfsi_plus_google_icons_language")
		{
			$visit_icon = $visit_iconsUrl."Visit_us_google";
		}
					
		$option5 =  unserialize(get_option('sfsi_plus_section5_options',false));
		
		?>
		<select name="<?php echo $name; ?>" id="<?php echo $name; ?>" data-iconUrl="<?php echo $visit_icon; ?>" class="<?php echo $name; ?>-preview lanOnchange">
			<option value="<?php echo $follow; ?>_ar" <?php echo ($option5[$name]== $follow.'_ar') ?  'selected="selected"' : '' ; ?>>
				العربية<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_ar" <?php echo ($option5[$name]== $visitme.'_ar') ?  'selected="selected"' : '' ; ?>>
				العربية<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_bg_BG" <?php echo ($option5[$name]== $follow.'_bg_BG') ?  'selected="selected"' : '' ; ?>>
				Български<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_bg_BG" <?php echo ($option5[$name]== $visitme.'_bg_BG') ?  'selected="selected"' : '' ; ?>>
				Български<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_zh_CN" <?php echo ($option5[$name]== $follow.'_zh_CN') ?  'selected="selected"' : '' ; ?>>
				简体中文<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_zh_CN" <?php echo ($option5[$name]== $visitme.'_zh_CN') ?  'selected="selected"' : '' ; ?>>
				简体中文<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_cs_CZ" <?php echo ($option5[$name]== $follow.'_cs_CZ') ?  'selected="selected"' : '' ; ?>>
				Čeština‎<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_cs_CZ" <?php echo ($option5[$name]== $visitme.'_cs_CZ') ?  'selected="selected"' : '' ; ?>>
				Čeština‎<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_da_DK" <?php echo ($option5[$name]== $follow.'_da_DK') ?  'selected="selected"' : '' ; ?>>
				Dansk<span> - << </span><span><?php echo $follow ?></span><span> >> </span>	
			</option>
			<option value="<?php echo $visitme; ?>_da_DK" <?php echo ($option5[$name]== $visitme.'_da_DK') ?  'selected="selected"' : '' ; ?>>
				Dansk<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_nl_NL" <?php echo ($option5[$name]== $follow.'_nl_NL') ?  'selected="selected"' : '' ; ?>>
				Nederlands<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_nl_NL" <?php echo ($option5[$name]== $visitme.'_nl_NL') ?  'selected="selected"' : '' ; ?>>
				Nederlands<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_fi" <?php echo ($option5[$name]== $follow.'_fi') ?  'selected="selected"' : '' ; ?>>
				Suomi<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_fi" <?php echo ($option5[$name]== $visitme.'_fi') ?  'selected="selected"' : '' ; ?>>
				Suomi<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_fr_FR" <?php echo ($option5[$name]== $follow.'_fr_FR') ?  'selected="selected"' : '' ; ?>>
				Français<span> - << </span><span><?php echo $follow ?></span><span> >> </span>	
			</option>
			<option value="<?php echo $visitme; ?>_fr_FR" <?php echo ($option5[$name]== $visitme.'_fr_FR') ?  'selected="selected"' : '' ; ?>>
				Français<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_de_DE" <?php echo ($option5[$name]== $follow.'_de_DE') ?  'selected="selected"' : '' ; ?>>
				Deutsch<span> - << </span><span><?php echo $follow ?></span><span> >> </span>	
			</option>
			<option value="<?php echo $visitme; ?>_de_DE" <?php echo ($option5[$name]== $visitme.'_de_DE') ?  'selected="selected"' : '' ; ?>>
				Deutsch<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_en_US" <?php echo ($option5[$name]== $follow.'_en_US') ? 'selected="selected"' : '' ; ?>>
				English<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_en_US" <?php echo ($option5[$name]== $visitme.'_en_US') ?  'selected="selected"' : '' ; ?>>
				English<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>	
			</option>
			
			<option value="<?php echo $follow; ?>_el" <?php echo ($option5[$name]== $follow.'_el') ?  'selected="selected"' : '' ; ?>>
				Ελληνικά<span> - << </span><span><?php echo $follow ?></span><span> >> </span>	
			</option>
			<option value="<?php echo $visitme; ?>_el" <?php echo ($option5[$name]== $visitme.'_el') ?  'selected="selected"' : '' ; ?>>
				Ελληνικά<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_hu_HU" <?php echo ($option5[$name]==$follow.'_hu_HU') ?  'selected="selected"' : '' ; ?>>
				Magyar<span> - << </span><span><?php echo $follow ?></span><span> >> </span>	
			</option>
			<option value="<?php echo $visitme; ?>_hu_HU" <?php echo ($option5[$name]== $visitme.'_hu_HU') ?  'selected="selected"' : '' ; ?>>
				Magyar<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_id_ID" <?php echo ($option5[$name]== $follow.'_id_ID') ?  'selected="selected"' : '' ; ?>>
				Bahasa Indonesia<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_id_ID" <?php echo ($option5[$name]== $visitme.'_id_ID') ?  'selected="selected"' : '' ; ?>>
				Bahasa Indonesia<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_it_IT" <?php echo ($option5[$name]== $follow.'_it_IT') ?  'selected="selected"' : '' ; ?>>
				Italiano<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_it_IT" <?php echo ($option5[$name]== $visitme.'_it_IT') ?  'selected="selected"' : '' ; ?>>
				Italiano<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_ja" <?php echo ($option5[$name]== $follow.'_ja') ?  'selected="selected"' : '' ; ?>>
				日本語<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_ja" <?php echo ($option5[$name]== $visitme.'_ja') ?  'selected="selected"' : '' ; ?>>
				日本語<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_ko_KR" <?php echo ($option5[$name]== $follow.'_ko_KR') ?  'selected="selected"' : '' ; ?>>
				한국어<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_ko_KR" <?php echo ($option5[$name]== $visitme.'_ko_KR') ?  'selected="selected"' : '' ; ?>>
				한국어<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_nb_NO" <?php echo ($option5[$name]== $follow.'_nb_NO') ?  'selected="selected"' : '' ; ?>>
				Norsk bokmål<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_nb_NO" <?php echo ($option5[$name]== $visitme.'_nb_NO') ?  'selected="selected"' : '' ; ?>>
				Norsk bokmål<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_fa_IR" <?php echo ($option5[$name]== $follow.'_fa_IR') ?  'selected="selected"' : '' ; ?>>
				فارسی<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_fa_IR" <?php echo ($option5[$name]== $visitme.'_fa_IR') ?  'selected="selected"' : '' ; ?>>
				فارسی<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_pl_PL" <?php echo ($option5[$name]== $follow.'_pl_PL') ?  'selected="selected"' : '' ; ?>>
				Polski<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_pl_PL" <?php echo ($option5[$name]== $visitme.'_pl_PL') ?  'selected="selected"' : '' ; ?>>
				Polski<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_pt_PT" <?php echo ($option5[$name]== $follow.'_pt_PT') ?  'selected="selected"' : '' ; ?>>
				Português<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_pt_PT" <?php echo ($option5[$name]== $visitme.'_pt_PT') ?  'selected="selected"' : '' ; ?>>
				Português<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_ro_RO" <?php echo ($option5[$name]== $follow.'_ro_RO') ?  'selected="selected"' : '' ; ?>>
				Română<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_ro_RO" <?php echo ($option5[$name]== $visitme.'_ro_RO') ?  'selected="selected"' : '' ; ?>>
				Română<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_ru_RU" <?php echo ($option5[$name]== $follow.'_ru_RU') ?  'selected="selected"' : '' ; ?>>
				Русский<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_ru_RU" <?php echo ($option5[$name]== $visitme.'_ru_RU') ?  'selected="selected"' : '' ; ?>>
				Русский<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_sk_SK" <?php echo ($option5[$name]== $follow.'_sk_SK') ?  'selected="selected"' : '' ; ?>>
				Slovenčina<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_sk_SK" <?php echo ($option5[$name]== $visitme.'_sk_SK') ?  'selected="selected"' : '' ; ?>>
				Slovenčina<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_es_ES" <?php echo ($option5[$name]== $follow.'_es_ES') ?  'selected="selected"' : '' ; ?>>
				Español<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_es_ES" <?php echo ($option5[$name]== $visitme.'_es_ES') ?  'selected="selected"' : '' ; ?>>
				Español<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_sv_SE" <?php echo ($option5[$name]== $follow.'_sv_SE') ?  'selected="selected"' : '' ; ?>>
				Svenska<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_sv_SE" <?php echo ($option5[$name]== $visitme.'_sv_SE') ?  'selected="selected"' : '' ; ?>>
				Svenska<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_th" <?php echo ($option5[$name]== $follow.'_th') ?  'selected="selected"' : '' ; ?>>
				ไทย<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_th" <?php echo ($option5[$name]== $visitme.'_th') ?  'selected="selected"' : '' ; ?>>
				ไทย<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_tr_TR" <?php echo ($option5[$name]== $follow.'_tr_TR') ?  'selected="selected"' : '' ; ?>>
				Türkçe<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_tr_TR" <?php echo ($option5[$name]== $visitme.'_tr_TR') ?  'selected="selected"' : '' ; ?>>
				Türkçe<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
			
			<option value="<?php echo $follow; ?>_vi" <?php echo ($option5[$name]== $follow.'_vi') ?  'selected="selected"' : '' ; ?>>
				Tiếng Việt<span> - << </span><span><?php echo $follow ?></span><span> >> </span>
			</option>
			<option value="<?php echo $visitme; ?>_vi" <?php echo ($option5[$name]== $visitme.'_vi') ?  'selected="selected"' : '' ; ?>>
				Tiếng Việt<span> - << </span><span><?php echo $visitme ?></span><span> >> </span>
			</option>
		</select>
	<?php
	}	
?>


<!-- Section 5 "Any other wishes for your main icons?" main div Start -->
<div class="tab5">
	<h4>
		<?php  _e( 'Order of your icons', SFSI_PLUS_DOMAIN ); ?>
    </h4>


    <!-- icon drag drop  section start here -->	
    <ul class="plus_share_icon_order" >
     <?php 
	 	$ctn = 0;
	 	foreach($icons_order as $index=>$icn) :
          
		  switch ($icn) : 
          case 'rss' :?>
            	 <li class="sfsiplus_rss_section" data-index="<?php echo $index; ?>" id="sfsi_plus_rssIcon_order">
                	<a href="#" title="RSS"><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/rss.png" alt="RSS" /></a>
                 </li>
          <?php break; ?>
          
		  <?php case 'email' :?>
          		<li class="sfsiplus_email_section " data-index="<?php echo $index; ?>" id="sfsi_plus_emailIcon_order">
                	<a href="#" title="Email"><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/<?php echo $email_image; ?>" alt="Email" class="icon_img" /></a>
                </li>
          <?php break; ?>
          
		  <?php case 'facebook' :?>
          		<li class="sfsiplus_facebook_section " data-index="<?php echo $index; ?>" id="sfsi_plus_facebookIcon_order">
                	<a href="#" title="Facebook"><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/fb.png" alt="Facebook" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'google' :?>
          		<li class="sfsiplus_google_section " data-index="<?php echo $index; ?>" id="sfsi_plus_googleIcon_order">
                	<a href="#" title="Google Plus" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/google_plus.png" alt="Google Plus" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'twitter' :?>
          		<li class="sfsiplus_twitter_section " data-index="<?php echo $index; ?>" id="sfsi_plus_twitterIcon_order">
                	<a href="#" title="Twitter" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/twitter.png" alt="Twitter" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'youtube' :?>
          		<li class="sfsiplus_youtube_section " data-index="<?php echo $index; ?>" id="sfsi_plus_youtubeIcon_order">
                	<a href="#" title="YouTube" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/youtube.png" alt="YouTube" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'pinterest' :?>
          		<li class="sfsiplus_pinterest_section " data-index="<?php echo $index; ?>" id="sfsi_plus_pinterestIcon_order">
                	<a href="#" title="Pinterest" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/pinterest.png" alt="Pinterest" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'linkedin' :?>
          		<li class="sfsiplus_linkedin_section " data-index="<?php echo $index; ?>" id="sfsi_plus_linkedinIcon_order">
                	<a href="#" title="Linked In" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/linked_in.png" alt="Linked In" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'instagram' :?>
          		<li class="sfsiplus_instagram_section " data-index="<?php echo $index; ?>" id="sfsi_plus_instagramIcon_order">
                	<a href="#" title="Instagram" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/instagram.png" alt="Instagram" /></a>
                </li>
          <?php break; ?>
          
          <?php case 'houzz' :?>
          		<li class="sfsiplus_houzz_section " data-index="<?php echo $index; ?>" id="sfsi_plus_houzzIcon_order">
                	<a href="#" title="Houzz" ><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/houzz.png" alt="Houzz" /></a>
                </li>
          <?php break; ?>
                  
          <?php default   :?>
          		<?php if(isset($icons[$icn['ele']]) && !empty($icons[$icn['ele']]) && filter_var($icons[$icn['ele']], FILTER_VALIDATE_URL) ): ?>
          		<li class="sfsiplus_custom_iconOrder sfsiICON_<?php echo $icn['ele']; ?>" data-index="<?php echo $index; ?>" element-id="<?php echo $icn['ele']; ?>" >
                	<a href="#" title="Custom Icon" ><img src="<?php echo $icons[$icn['ele']]; ?>" alt="Linked In" class="sfcm" /></a>
                </li> 
                <?php endif; ?>
          <?php break; ?>
            
         <?php  endswitch; ?>   
    <?php endforeach; ?> 
     
    </ul> <!-- END icon drag drop section start here -->
    
    <span class="drag_drp">
    	(<?php  _e( 'Drag and Drop', SFSI_PLUS_DOMAIN); ?>)
    </span>
    <!-- icon's size and spacing section start here -->	
    <div class="row">
        <h4>
        	<?php  _e( 'Size and spacing of your icons', SFSI_PLUS_DOMAIN ); ?>
        </h4>
        <div class="icons_size">
        	<span>
        		<?php  _e( 'Size:', SFSI_PLUS_DOMAIN ); ?>
        	</span>
            <input name="sfsi_plus_icons_size" value="<?php echo ($option5['sfsi_plus_icons_size']!='') ?  $option5['sfsi_plus_icons_size'] : '' ;?>" type="text" />
        	<ins>
        		<?php  _e( 'pixels wide and tall', SFSI_PLUS_DOMAIN ); ?>
        	</ins>
         	<span class="last">
         		<?php  _e( 'Spacing between icons:', SFSI_PLUS_DOMAIN ); ?>
         	</span>
            <input name="sfsi_plus_icons_spacing" type="text" value="<?php echo ($option5['sfsi_plus_icons_spacing']!='') ?  $option5['sfsi_plus_icons_spacing'] : '' ;?>" />
         	<ins>
         		<?php  _e( 'Pixels', SFSI_PLUS_DOMAIN ); ?>
         	</ins>
    	</div>
    	
    	<?php if($option5['sfsi_plus_premium_size_box'] == 'yes') { ?>

<!--     	<div class="sfsi_plus_icons_prem_disc">
            <p class="sfsi_plus_prem_plu_desc">
				<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( 'The Premium Plugin also allows you to define the vertical distance between the icons (and set this differently for mobile vs. desktop): ', SFSI_PLUS_DOMAIN ); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_spacings&utm_medium=banner" target="_blank"><?php  _e( 'Check it out', SFSI_PLUS_DOMAIN ); ?></a>
			</p>
        </div> -->

		<div class="sfsi_plus_new_prmium_follw">
            <p>
				<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( 'The Premium Plugin also allows you to define the vertical distance between the icons (and set this differently for mobile vs. desktop): ', SFSI_PLUS_DOMAIN ); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_spacings&utm_medium=banner" target="_blank"><?php  _e( 'See all features', SFSI_PLUS_DOMAIN ); ?></a>
			</p>
		</div>

        <?php } ?>
    </div>
    
    <div class="row">
        <h4>
        	<?php  _e( 'Alignments', SFSI_PLUS_DOMAIN ); ?>
        </h4>
        <div class="icons_size">
        	<div style="width: 210px;float: left;position: relative;">
	        	<span>
	        		<?php  _e( 'Alignment of icons:', SFSI_PLUS_DOMAIN ); ?>
	        	</span>
	        	<ins class="sfsi_plus_icons_align_other" style="position: absolute;bottom: -22px;left: 0;width: 200px;color: rgb(128,136,145);">
	        		<?php  _e( '(with respect to each other)', SFSI_PLUS_DOMAIN ); ?>
	        	</ins>
	        </div>
        	<div class="field">
                <select name="sfsi_plus_icons_Alignment" id="sfsi_plus_icons_Alignment" class="styled">
                    <option value="center" <?php echo ($option5['sfsi_plus_icons_Alignment']=='center') ?  'selected="selected"' : '' ;?>>
                        <?php  _e( 'Centered', SFSI_PLUS_DOMAIN ); ?>
                    </option>
                    <option value="right" <?php echo ($option5['sfsi_plus_icons_Alignment']=='right') ?  'selected="selected"' : '' ;?>>
                    	<?php  _e( 'Right', SFSI_PLUS_DOMAIN ); ?>
                    </option>
                    <option value="left" <?php echo ($option5['sfsi_plus_icons_Alignment']=='left') ?  'selected="selected"' : '' ;?>>
                    	<?php  _e( 'Left', SFSI_PLUS_DOMAIN ); ?>
                    </option>
                </select>
       		</div> 
        	<span>
        		<?php  _e( 'Icons per row:', SFSI_PLUS_DOMAIN ); ?>
        	</span>
        	<input name="sfsi_plus_icons_perRow" type="text" value="<?php echo ($option5['sfsi_plus_icons_perRow']!='') ?  $option5['sfsi_plus_icons_perRow'] : '' ;?>" />
        	<ins>
        		<?php  _e( 'Leave empty if you dont want to define this', SFSI_PLUS_DOMAIN ); ?>
        	</ins>
        </div>
        <?php if($option5['sfsi_plus_premium_size_box'] == 'yes') { ?>
		<div class ="sfsi_plus_new_prmium_follw">
			<p>
				<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( 'The Premium Plugin gives several more alignment options:', SFSI_PLUS_DOMAIN ); ?><br>- &nbsp;&nbsp;<?php  _e( ' Show icons vertically', SFSI_PLUS_DOMAIN ); ?><br>- &nbsp;&nbsp;<?php  _e( ' Align icons within a widget (left, right, centered)', SFSI_PLUS_DOMAIN ); ?><br>- &nbsp;&nbsp;<?php  _e( ' Align icons within the «container» where you place them via shortcode (left, right, centered)  ', SFSI_PLUS_DOMAIN ); ?>
				<br>
				<a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_alignment_options&utm_medium=banner" target="_blank"><?php  _e( 'See all features', SFSI_PLUS_DOMAIN ); ?></a>
			</p>
		</div>
		<?php } ?>
    </div>

<!--*******************************************************  Sharing texts & pictures section STARTS *********************************************************************-->

<div class="row sfsi_custom_social_data_setting" id="custom_social_data_setting">

		<h4><?php _e("Sharing texts & pictures?",SFSI_PLUS_DOMAIN); ?></h4>
		<p><?php _e("On the pages where you edit your posts / pages you’ll see a (new) section where you can define which pictures & text should be shared. This extra section is displayed on the following:",SFSI_PLUS_DOMAIN); ?></p>		

			<?php 
				$checkedS   = (isset($option5['sfsi_plus_custom_social_hide']) && $option5['sfsi_plus_custom_social_hide']=="yes") ? 'checked="checked"': '';	
				$checked    = (isset($option5['sfsi_plus_custom_social_hide']) && $option5['sfsi_plus_custom_social_hide']=="yes") ? '': 'checked="checked"';
				$checkedVal = (isset($option5['sfsi_plus_custom_social_hide'])) ? $option5['sfsi_plus_custom_social_hide']: 'no';				
			?>
		<div class="social_data_post_types">
                <ul class="socialPostTypesUl">
                	<li>
						<div class="radio_section tb_4_ck">
							<input type="checkbox" <?php echo $checked; ?> value="page" class="styled"  />
							<label class="cstmdsplsub"><?php _e("Page",SFSI_PLUS_DOMAIN); ?></label>
						</div>
					</li>
                	<li>
						<div class="radio_section tb_4_ck">
							<input type="checkbox" <?php echo $checked; ?> value="post" class="styled"  />
							<label class="cstmdsplsub"><?php _e("Post",SFSI_PLUS_DOMAIN); ?></label>
						</div>
					</li>						
                </ul>

                <ul class="sfsi_show_hide_section">
               		<li>
						<div class="radio_section tb_4_ck">
							<input name="sfsi_plus_custom_social_hide" type="checkbox" <?php echo $checkedS; ?> value="<?php echo $checkedVal; ?>" class="styled"  />
							<label class="cstmdsplsub"><?php _e("Hide section for all",SFSI_PLUS_DOMAIN); ?></label>
						</div>
					</li>
                </ul>
 		</div>

		<div class="sfsi_plus_new_prmium_follw sfsi_social_sharing" style="margin-bottom: 15px;">
			<p><?php _e("Note: This feature is currently only available in the Premium Plugin.",SFSI_PLUS_DOMAIN); ?> <a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=define_pic_and_text&utm_medium=banner" target="_blank"><?php _e("See all features",SFSI_PLUS_DOMAIN); ?></a>
			</p>
		</div> 		
</div>

<!--*************************************  Sharing texts & pictures section CLOSES *******************************************************************-->

	<!-- icon's select language optins start here -->
    <div class="row">
		<h4>
    	    <?php  _e( 'Language & Button-text', SFSI_PLUS_DOMAIN ); ?>
    	</h4>
		<!-- Follow button start here -->
		<div class="icons_size">
        	<div class="follows-btn">
				<span><?php  _e( 'Follow-button:', SFSI_PLUS_DOMAIN ); ?></span>
        	</div>
			<div class="field language-field">
				 <?php selectoption("sfsi_plus_follow_icons_language" , "Follow" , "Subscribe"); ?>
			</div>
			<div class="preview-btn">
        		<span><?php  _e( 'Preview:', SFSI_PLUS_DOMAIN ); ?></span>
			</div>
			<?php
				$follow_icons = $option5['sfsi_plus_follow_icons_language'];
				$visit_icon = SFSI_PLUS_PLUGURL."images/visit_icons/Follow/icon_".$follow_icons.".png";
				if(isset($follow_icons) && !empty($follow_icons))
				{
					?>
					<div class="social-img-link"><img src="<?php echo $visit_icon; ?>" alt=""  /></div>
			<?php } ?>
		</div>
		
		<!-- Facebook «Visit»-icon start here -->
		<div class="icons_size">
        	<div class="follows-btn">
        		<span><?php  _e( 'Facebook «Visit»-icon:', SFSI_PLUS_DOMAIN ); ?></span>
			</div>
			<div class="field language-field">
				<?php selectoption("sfsi_plus_facebook_icons_language" , "Visit_us" , "Visit_me"); ?>
			</div>
			<div class="preview-btn">
        		<span><?php  _e( 'Preview:', SFSI_PLUS_DOMAIN ); ?></span>
        	</div>
			<?php
				$facebook_icons_lang = $option5['sfsi_plus_facebook_icons_language'];
				$visit_icon = $visit_iconsUrl."Visit_us_fb/icon_".$facebook_icons_lang.".png";
				if(isset($facebook_icons_lang) && !empty($facebook_icons_lang))
				{
					?>
					<div class="social-img-link"><img src="<?php echo $visit_icon; ?>" alt=""  /></div>
			<?php } ?>			
		</div>
		
		<!-- Twitter «Visit»-icon start here -->
		<div class="icons_size">
        	<div class="follows-btn">
        		<span><?php  _e( 'Twitter «Visit»-icon:', SFSI_PLUS_DOMAIN ); ?></span>
        	</div>
			<div class="field language-field">
				 <?php selectoption("sfsi_plus_twitter_icons_language" , "Visit_us" , "Visit_me"); ?>
			</div>
			<div class="preview-btn">
        		<span><?php  _e( 'Preview:', SFSI_PLUS_DOMAIN ); ?></span>
        	</div>
			<?php
				$twitter_icons_lang = $option5['sfsi_plus_twitter_icons_language'];
				$visit_icon = $visit_iconsUrl."Visit_us_twitter/icon_".$twitter_icons_lang.".png";
				if(isset($twitter_icons_lang) && !empty($twitter_icons_lang))
				{
					?>					
					<div class="social-img-link"><img src="<?php echo $visit_icon; ?>" alt=""  /></div>
			<?php } ?>
		</div>
		
		<!-- Google+ «Visit»-icon start here -->
		<div class="icons_size">
        	<div class="follows-btn">
        		<span><?php  _e( 'Google+ «Visit»-icon:', SFSI_PLUS_DOMAIN ); ?></span>
        	</div>
			<div class="field language-field">
				<?php selectoption("sfsi_plus_google_icons_language" , "Visit_us" , "Visit_me"); ?>
			</div>
			<div class="preview-btn">
        		<span><?php  _e( 'Preview:', SFSI_PLUS_DOMAIN ); ?></span>
        	</div>
			<?php
				$google_icons_lang = $option5['sfsi_plus_google_icons_language'];
				$visit_icon = $visit_iconsUrl."Visit_us_google/icon_".$google_icons_lang.".png";
				if(isset($google_icons_lang) && !empty($google_icons_lang))
				{
					?>					
					<div class="social-img-link"><img src="<?php echo $visit_icon; ?>" alt=""  /></div>
			<?php } ?>
		</div>

		<!-- Like & Share buttons (Facebook, Twitter, Google+) start here -->
		<div class="icons_size">
        	<span>
        		<?php  _e( 'Language for Like & Share buttons (Facebook, Twitter, Google+):', SFSI_PLUS_DOMAIN ); ?>
        	</span>
			<div class="language_field">
				<select name="sfsi_plus_icons_language" id="sfsi_plus_icons_language" class="language">
					<option value="ar_AR" <?php echo ($option5['sfsi_plus_icons_language']=='ar_AR') ?  'selected="selected"' : '' ;?>>
						العربية 
					</option>
					<option value="az_AZ" <?php echo ($option5['sfsi_plus_icons_language']=='az_AZ') ?  'selected="selected"' : '' ;?>>
						Azərbaycan dili
					</option>
					<option value="af_ZA" <?php echo ($option5['sfsi_plus_icons_language']=='af_ZA') ?  'selected="selected"' : '' ;?>>
						Afrikaans
					<option value="bg_BG" <?php echo ($option5['sfsi_plus_icons_language']=='bg_BG') ?  'selected="selected"' : '' ;?>>
						Български
					</option>
					<option value="ms_MY" <?php echo ($option5['sfsi_plus_icons_language']=='ms_MY') ?  'selected="selected"' : '' ;?>>
						Bahasa Melayu‎
					</option>
					<option value="bn_IN" <?php echo ($option5['sfsi_plus_icons_language']=='bn_IN') ?  'selected="selected"' : '' ;?>>
						বাংলা
					</option>
					<option value="bs_BA" <?php echo ($option5['sfsi_plus_icons_language']=='bs_BA') ?  'selected="selected"' : '' ;?>>
						Bosanski
					</option>
					<option value="ca_ES" <?php echo ($option5['sfsi_plus_icons_language']=='ca_ES') ?  'selected="selected"' : '' ;?>>
						Català
					</option>
					<option value="cy_GB" <?php echo ($option5['sfsi_plus_icons_language']=='cy_GB') ?  'selected="selected"' : '' ;?>>
						Cymraeg
					</option>
					<option value="da_DK" <?php echo ($option5['sfsi_plus_icons_language']=='da_DK') ?  'selected="selected"' : '' ;?>>
						Dansk
					</option>
					<option value="de_DE" <?php echo ($option5['sfsi_plus_icons_language']=='de_DE') ?  'selected="selected"' : '' ;?>>
						Deutsch
					</option>
					<option value="en_US" <?php echo ($option5['sfsi_plus_icons_language']=='en_US') ?  'selected="selected"' : '' ;?>>
						English (United States)
					</option>
					<option value="el_GR" <?php echo ($option5['sfsi_plus_icons_language']=='el_GR') ?  'selected="selected"' : '' ;?>>
						Ελληνικά
					</option>
					<option value="eo_EO" <?php echo ($option5['sfsi_plus_icons_language']=='eo_EO') ?  'selected="selected"' : '' ;?>>
						Esperanto
					</option>
					<option value="es_ES" <?php echo ($option5['sfsi_plus_icons_language']=='es_ES') ?  'selected="selected"' : '' ;?>>
						Español
					</option>
					<option value="et_EE" <?php echo ($option5['sfsi_plus_icons_language']=='et_EE') ?  'selected="selected"' : '' ;?>>
						Eesti
					</option>
					<option value="eu_ES" <?php echo ($option5['sfsi_plus_icons_language']=='eu_ES') ?  'selected="selected"' : '' ;?>>
						Euskara
					</option>
					<option value="fa_IR" <?php echo ($option5['sfsi_plus_icons_language']=='fa_IR') ?  'selected="selected"' : '' ;?>>
						فارسی
					</option>
					<option value="fi_FI" <?php echo ($option5['sfsi_plus_icons_language']=='fi_FI') ?  'selected="selected"' : '' ;?>>
						Suomi
					</option>
					<option value="fr_FR" <?php echo ($option5['sfsi_plus_icons_language']=='fr_FR') ?  'selected="selected"' : '' ;?>>
						Français
					</option>
					<option value="gl_ES" <?php echo ($option5['sfsi_plus_icons_language']=='gl_ES') ?  'selected="selected"' : '' ;?>>
						Galego
					</option>
					<option value="he_IL" <?php echo ($option5['sfsi_plus_icons_language']=='he_IL') ?  'selected="selected"' : '' ;?>>
						עִבְרִית
					</option>
					<option value="hi_IN" <?php echo ($option5['sfsi_plus_icons_language']=='hi_IN') ?  'selected="selected"' : '' ;?>>
						हिन्दी
					</option>
					<option value="hr_HR" <?php echo ($option5['sfsi_plus_icons_language']=='hr_HR') ?  'selected="selected"' : '' ;?>>
						Hrvatski
					</option>
					<option value="hu_HU" <?php echo ($option5['sfsi_plus_icons_language']=='hu_HU') ?  'selected="selected"' : '' ;?>>
						Magyar
					</option>
					<option value="hy_AM" <?php echo ($option5['sfsi_plus_icons_language']=='hy_AM') ?  'selected="selected"' : '' ;?>>
						Հայերեն
					</option>
					<option value="id_ID" <?php echo ($option5['sfsi_plus_icons_language']=='id_ID') ?  'selected="selected"' : '' ;?>>
						Bahasa Indonesia
					</option>
					<option value="is_IS" <?php echo ($option5['sfsi_plus_icons_language']=='is_IS') ?  'selected="selected"' : '' ;?>>
						Íslenska
					</option>
					<option value="it_IT" <?php echo ($option5['sfsi_plus_icons_language']=='it_IT') ?  'selected="selected"' : '' ;?>>
						Italiano
					</option>
					<option value="ja_JP" <?php echo ($option5['sfsi_plus_icons_language']=='ja_JP') ?  'selected="selected"' : '' ;?>>
						日本語
					</option>
					<option value="ko_KR" <?php echo ($option5['sfsi_plus_icons_language']=='ko_KR') ?  'selected="selected"' : '' ;?>>
						한국어
					</option>
					<option value="lt_LT" <?php echo ($option5['sfsi_plus_icons_language']=='lt_LT') ?  'selected="selected"' : '' ;?>>
						Lietuvių kalba
					</option>
					<option value="my_MM" <?php echo ($option5['sfsi_plus_icons_language']=='my_MM') ?  'selected="selected"' : '' ;?>>
						ဗမာစာ
					</option>
					<option value="nl_NL" <?php echo ($option5['sfsi_plus_icons_language']=='nl_NL') ?  'selected="selected"' : '' ;?>>
						Nederlands
					</option>
					<option value="nn_NO" <?php echo ($option5['sfsi_plus_icons_language']=='nn_NO') ?  'selected="selected"' : '' ;?>>
						Norsk nynorsk
					</option>
					<option value="pl_PL" <?php echo ($option5['sfsi_plus_icons_language']=='pl_PL') ?  'selected="selected"' : '' ;?>>
						Polski
					</option>
					<option value="ps_AF" <?php echo ($option5['sfsi_plus_icons_language']=='ps_AF') ?  'selected="selected"' : '' ;?>>
						پښتو
					</option>
					<option value="pt_BR" <?php echo ($option5['sfsi_plus_icons_language']=='pt_BR') ?  'selected="selected"' : '' ;?>>
						Português do Brasil
					</option>
					<option value="ro_RO" <?php echo ($option5['sfsi_plus_icons_language']=='ro_RO') ?  'selected="selected"' : '' ;?>>
						Română
					</option>
					<option value="ru_RU" <?php echo ($option5['sfsi_plus_icons_language']=='ru_RU') ?  'selected="selected"' : '' ;?>>
						Русский
					</option>
					<option value="sk_SK" <?php echo ($option5['sfsi_plus_icons_language']=='sk_SK') ?  'selected="selected"' : '' ;?>>
						Slovenčina
					</option>
					<option value="sl_SI" <?php echo ($option5['sfsi_plus_icons_language']=='sl_SI') ?  'selected="selected"' : '' ;?>>
						Slovenščina
					</option>
					<option value="sq_AL" <?php echo ($option5['sfsi_plus_icons_language']=='sq_AL') ?  'selected="selected"' : '' ;?>>
						Shqip
					</option>
					<option value="sr_RS" <?php echo ($option5['sfsi_plus_icons_language']=='sr_RS') ?  'selected="selected"' : '' ;?>>
						Српски језик
					</option>
					<option value="sv_SE" <?php echo ($option5['sfsi_plus_icons_language']=='sv_SE') ?  'selected="selected"' : '' ;?>>
						Svenska
					</option>
					<option value="th_TH" <?php echo ($option5['sfsi_plus_icons_language']=='th_TH') ?  'selected="selected"' : '' ;?>>
						ไทย
					</option>
					<option value="tl_PH" <?php echo ($option5['sfsi_plus_icons_language']=='tl_PH') ?  'selected="selected"' : '' ;?>>
						Tagalog
					</option>
					<option value="tr_TR" <?php echo ($option5['sfsi_plus_icons_language']=='tr_TR') ?  'selected="selected"' : '' ;?>>
						Türkçe
					</option>
					<option value="ug_CN" <?php echo ($option5['sfsi_plus_icons_language']=='ug_CN') ?  'selected="selected"' : '' ;?>>
						Uyƣurqə
					</option>
					<option value="uk_UA" <?php echo ($option5['sfsi_plus_icons_language']=='uk_UA') ?  'selected="selected"' : '' ;?>>
						Українська
					</option>
					<option value="vi_VN" <?php echo ($option5['sfsi_plus_icons_language']=='vi_VN') ?  'selected="selected"' : '' ;?>>
						Tiếng Việt
					</option>
					<option value="zh_CN" <?php echo ($option5['sfsi_plus_icons_language']=='zh_CN') ?  'selected="selected"' : '' ;?>>
						简体中文
					</option>
					<option value="cs_CZ" <?php echo ($option5['sfsi_plus_icons_language']=='cs_CZ') ?  'selected="selected"' : '' ;?>>
						Čeština
					</option>
					<option value="ur_PK" <?php echo ($option5['sfsi_plus_icons_language']=='ur_PK') ?  'selected="selected"' : '' ;?>>
						اردو‎
					</option>
				</select>
			</div>
		</div>
	</div>
    <div class="row new_wind">
        <h4>
			<?php  _e( 'New window', SFSI_PLUS_DOMAIN ); ?>
        </h4>
        <div class="sfsiplus_row_onl">
        	<p>
				<?php
					_e( 'If user clicks on your icons, do you want to open the page in a new window?',SFSI_PLUS_DOMAIN ); ?>
        	</p>
            <ul class="enough_waffling">
                <li>
                    <input name="sfsi_plus_icons_ClickPageOpen" <?php echo ($option5['sfsi_plus_icons_ClickPageOpen']=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
                    <label>
                    	<?php  _e( 'Yes', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
                <li>
                    <input name="sfsi_plus_icons_ClickPageOpen" <?php echo ($option5['sfsi_plus_icons_ClickPageOpen']=='no') ?  'checked="true"' : '' ;?> type="radio" value="no" class="styled" />
                    <label>
                    	<?php  _e( 'No', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
            </ul>
      	</div>
    </div>
   <!-- END icon's size and spacing section -->
   
     <!-- icon's floating and stick section start here -->	
    <div class="row sticking">
    	<h4>
            <?php  _e( 'Sticking & Disable on mobile', SFSI_PLUS_DOMAIN ); ?>
        </h4>
        <p>
            <?php  _e( 'If you decided to show your icons via a widget, you can add the effect that when the user scrolls down, the icons will stick at the  top of the screen so that they are still displayed even if the user scrolled all the way down. Do you want to do that?', SFSI_PLUS_DOMAIN ); ?>
        </p>
		<div class="space">
        	<!--<p class="list">Make icons stick?</p>-->	
            <ul class="enough_waffling">
            	<li>
                	<input name="sfsi_plus_icons_stick" <?php echo ($option5['sfsi_plus_icons_stick']=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
                    <label>
                    	<?php  _e( 'Yes', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
                <li>
                	<input name="sfsi_plus_icons_stick" <?php echo ($option5['sfsi_plus_icons_stick']=='no') ?  'checked="true"' : '' ;?>  type="radio" value="no" class="styled" />
                    <label>
                    	<?php  _e( 'No', SFSI_PLUS_DOMAIN ); ?>
                    </label>
               	</li>
            </ul>
    	</div>
  	
    	<!--disable float icons-->
  		<div class="space disblfltonmbl">
            <p class="list">
            	<?php  _e( 'Disable float icons on mobile devices', SFSI_PLUS_DOMAIN ); ?>
            </p>	
            <ul class="enough_waffling">
                <li>
                	<input name="sfsi_plus_disable_floaticons" <?php echo ($option5['sfsi_plus_disable_floaticons']=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
                    <label>
                    	<?php  _e( 'Yes', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
                <li>
                    <input name="sfsi_plus_disable_floaticons" <?php echo ($option5['sfsi_plus_disable_floaticons']=='no') ?  'checked="true"' : '' ;?>  type="radio" value="no" class="styled" />
                    <label>
                    	<?php  _e( 'No', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
            </ul>
  		</div>
  		<!--disable float icons-->
  	
    	<!--disabling view port meta tag-->
  		<div class="space disblfltonmbl">
            <p class="list">
                <?php  _e( 'Disable auto-scaling feature for mobile devices ("viewport" meta tag)', SFSI_PLUS_DOMAIN ); ?>
            </p>	
            <ul class="enough_waffling">
            	<li>
                    <input name="sfsi_plus_disable_viewport" <?php echo ($sfsi_plus_disable_viewport=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
                    <label>
                    	<?php  _e( 'Yes', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
                <li>
                    <input name="sfsi_plus_disable_viewport" <?php echo ($sfsi_plus_disable_viewport=='no') ?  'checked="true"' : '' ;?>  type="radio" value="no" class="styled" />
                    <label>
                    	<?php  _e( 'No', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
            </ul>
  		</div>
  		<!--disabling view port meta tag-->
	</div>
	<!-- END icon's floating and stick section -->
 
	<!-- mouse over text section start here -->
	<div class="row mouse_txt">
        <h4>
            <?php  _e( 'Mouseover text', SFSI_PLUS_DOMAIN ); ?>
        </h4>
        <p>
            <?php  _e('If you’ve given your icon only one function (i.e. no pop-up where user can perform different actions) then you can define here what text will be displayed if a user moves his mouse over the icon:', SFSI_PLUS_DOMAIN ); ?>
        </p>
		
        <div class="space">
			<div class="clear"></div>
			<div class="mouseover_field sfsiplus_rss_section">
                <label>
                    RSS:
                </label>
            	<input name="sfsi_plus_rss_MouseOverText" value="<?php echo ($option5['sfsi_plus_rss_MouseOverText']!='') ?  $option5['sfsi_plus_rss_MouseOverText'] : '' ;?>" type="text" />
			</div>
            <div class="mouseover_field sfsiplus_email_section">
                <label>
                   Email:
                </label>
                <input name="sfsi_plus_email_MouseOverText" value="<?php echo ($option5['sfsi_plus_email_MouseOverText']!='') ?  $option5['sfsi_plus_email_MouseOverText'] : '' ;?>" type="text" />
            </div>
            <div class="clear">
            	<div class="mouseover_field sfsiplus_twitter_section">
                	<label>
                        Twitter:
                    </label>
                    <input name="sfsi_plus_twitter_MouseOverText" value="<?php echo ($option5['sfsi_plus_twitter_MouseOverText']!='') ?  $option5['sfsi_plus_twitter_MouseOverText'] : '' ;?>" type="text" />
                </div>
                <div class="mouseover_field sfsiplus_facebook_section">
                    <label>
                        Facebook:
                    </label>
                    <input name="sfsi_plus_facebook_MouseOverText" value="<?php echo ($option5['sfsi_plus_facebook_MouseOverText']!='') ?  $option5['sfsi_plus_facebook_MouseOverText'] : '' ;?>" type="text" />
                </div>
            </div>
        
			<div class="clear">
                <div class="mouseover_field sfsiplus_google_section">
                    <label>
                        Google:
                    </label>
                    <input name="sfsi_plus_google_MouseOverText" value="<?php echo ($option5['sfsi_plus_google_MouseOverText']!='') ?  $option5['sfsi_plus_google_MouseOverText'] : '' ;?>"  type="text" />
                </div>
                <div class="mouseover_field sfsiplus_linkedin_section">
                    <label>
                        LinkedIn:
                    </label>
                    <input name="sfsi_plus_linkedIn_MouseOverText" value="<?php echo ($option5['sfsi_plus_linkedIn_MouseOverText']!='') ?  $option5['sfsi_plus_linkedIn_MouseOverText'] : '' ;?>"  type="text" />
                </div>
			</div>
		
        	<div class="clear">
                <div class="mouseover_field sfsiplus_pinterest_section">
                    <label>
                        Pinterest:
                    </label>
                    <input name="sfsi_plus_pinterest_MouseOverText" value="<?php echo ($option5['sfsi_plus_pinterest_MouseOverText']!='') ?  $option5['sfsi_plus_pinterest_MouseOverText'] : '' ;?>" type="text" />
                </div>
                <div class="mouseover_field sfsiplus_youtube_section">
                    <label>
                        Youtube:
                    </label>
                    <input name="sfsi_plus_youtube_MouseOverText" value="<?php echo ($option5['sfsi_plus_youtube_MouseOverText']!='') ?  $option5['sfsi_plus_youtube_MouseOverText'] : '' ;?>" type="text" />
                </div>
			</div>
		
        	<div class="clear">
                <div class="mouseover_field sfsiplus_instagram_section">
                    <label>
                        Instagram:
                    </label>
                    <input name="sfsi_plus_instagram_MouseOverText" value="<?php echo ($option5['sfsi_plus_instagram_MouseOverText']!='') ?  $option5['sfsi_plus_instagram_MouseOverText'] : '' ;?>" type="text" />
                </div>
                <div class="mouseover_field sfsiplus_houzz_section">
                    <label>
                        Houzz:
                    </label>
                    <input name="sfsi_plus_houzz_MouseOverText" value="<?php echo (isset($option5['sfsi_plus_houzz_MouseOverText']) && $option5['sfsi_plus_houzz_MouseOverText']!='') ?  $option5['sfsi_plus_houzz_MouseOverText'] : 'Houzz' ;?>" type="text" />
                </div>
			</div>
        
        	<div class="clear"> </div>
        	<div class="plus_custom_m">
				<?php 
                    $sfsiMouseOverTexts =  unserialize($option5['sfsi_plus_custom_MouseOverTexts']);
                    $count=1; for($i=$first_key; $i<=$endkey; $i++) :
                ?> 
            	<?php if(!empty( $icons[$i])) : ?>
                    
                    <div class="mouseover_field sfsiplus_custom_section sfsiICON_<?php echo $i; ?>">
                        <label>
                            <?php  _e( 'Custom', SFSI_PLUS_DOMAIN ); ?>
                            <?php echo $count; ?>:
                        </label>
                        <input name="sfsi_plus_custom_MouseOverTexts[]" value="<?php echo (isset($sfsiMouseOverTexts[$i]) && $sfsiMouseOverTexts[$i]!='') ?  sanitize_text_field($sfsiMouseOverTexts[$i]) : '' ;?>" type="text" file-id="<?php echo $i; ?>" />
                    </div>
                	<?php if($count%2==0): ?>
                		<div class="clear"></div>  
					<?php endif; ?>
            		<?php $count++; 
				endif; endfor; ?>
			</div>
		</div>
		
	</div>
    <!-- END mouse over text section -->

    <div class="row new_wind">
		<h4>Error reporting</h4>
		<div class="row_onl"><p>Suppress error messages?</p>
			<ul class="enough_waffling ulSuppressErrors">
		    	<li>
		    		<input name="sfsi_pplus_icons_suppress_errors" <?php echo ($sfsi_icons_suppress_errors=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
		    		<label>Yes</label>
		    	</li>
				<li>
					<input name="sfsi_pplus_icons_suppress_errors" <?php echo ($sfsi_icons_suppress_errors=='no') ?  'checked="true"' : '' ;?> type="radio" value="no" class="styled" />
					<label>No</label>
				</li>
	      	</ul>
      	</div>
    </div>
    
	<?php sfsi_plus_ask_for_help(5); ?>


    <!-- SAVE BUTTON SECTION   --> 
    <div class="save_button">
        <img src="<?php echo SFSI_PLUS_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
        <?php  $nonce = wp_create_nonce("update_plus_step5"); ?>
        <a href="javascript:;" id="sfsi_plus_save5" title="Save" data-nonce="<?php echo $nonce;?>"><?php  _e( 'Save', SFSI_PLUS_DOMAIN ); ?></a>
    </div>
    <!-- END SAVE BUTTON SECTION   -->
    
    <a class="sfsiColbtn closeSec" href="javascript:;" >
  		<?php  _e( 'Collapse area', SFSI_PLUS_DOMAIN ); ?>
    </a>
    <label class="closeSec"></label>
    
    <!-- ERROR AND SUCCESS MESSAGE AREA-->
    <p class="red_txt errorMsg" style="display:none"> </p>
    <p class="green_txt sucMsg" style="display:none"> </p>
    <div class="clear"></div>
</div>
<!-- END Section 5 "Any other wishes for your main icons?"-->
