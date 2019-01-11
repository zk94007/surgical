<?php
     /* unserialize all saved option for Eight options */
    $option8=  unserialize(get_option('sfsi_plus_section8_options',false));
	if(!isset($option8['sfsi_plus_rectsub']))
	{
		$option8['sfsi_plus_rectsub'] = 'no';
	}
	if(!isset($option8['sfsi_plus_rectfb']))
	{
		$option8['sfsi_plus_rectfb'] = 'yes';
	}
	if(!isset($option8['sfsi_plus_rectgp']))
	{
		$option8['sfsi_plus_rectgp'] = 'yes';
	}
	if(!isset($option8['sfsi_plus_recttwtr']))
	{
		$option8['sfsi_plus_recttwtr'] = 'no';
	}
	if(!isset($option8['sfsi_plus_rectpinit']))
	{
		$option8['sfsi_plus_rectpinit'] = 'no';
	}
	if(!isset($option8['sfsi_plus_rectfbshare']))
	{
		$option8['sfsi_plus_rectfbshare'] = 'no';
	}
	
	/**
	 * Sanitize, escape and validate values
	 */
	$option8['sfsi_plus_show_via_widget'] 			= 	(isset($option8['sfsi_plus_show_via_widget']))
															? sanitize_text_field($option8['sfsi_plus_show_via_widget'])
															: '';
	$option8['sfsi_plus_float_on_page'] 			= 	(isset($option8['sfsi_plus_float_on_page']))
															? sanitize_text_field($option8['sfsi_plus_float_on_page'])
															: '';
	$option8['sfsi_plus_float_page_position'] 		= 	(isset($option8['sfsi_plus_float_page_position']))
															? sanitize_text_field($option8['sfsi_plus_float_page_position'])
															: '';
	$option8['sfsi_plus_icons_floatMargin_top'] 	= 	(isset($option8['sfsi_plus_icons_floatMargin_top']))
															? intval($option8['sfsi_plus_icons_floatMargin_top'])
															: '';
	$option8['sfsi_plus_icons_floatMargin_bottom'] 	= 	(isset($option8['sfsi_plus_icons_floatMargin_bottom']))
															? intval($option8['sfsi_plus_icons_floatMargin_bottom'])
															: '';
	$option8['sfsi_plus_icons_floatMargin_left'] 	= 	(isset($option8['sfsi_plus_icons_floatMargin_left']))
															? intval($option8['sfsi_plus_icons_floatMargin_left'])
															: '';
	$option8['sfsi_plus_icons_floatMargin_right'] 	= 	(isset($option8['sfsi_plus_icons_floatMargin_right']))
															? intval($option8['sfsi_plus_icons_floatMargin_right'])
															: '';														
	$option8['sfsi_plus_place_item_manually'] 		= 	(isset($option8['sfsi_plus_place_item_manually']))
															? sanitize_text_field($option8['sfsi_plus_place_item_manually'])
															: '';
	$option8['sfsi_plus_place_item_gutenberg'] 		= 	(isset($option8['sfsi_plus_place_item_gutenberg']))
															? sanitize_text_field($option8['sfsi_plus_place_item_gutenberg'])
															: 'no';
	$option8['sfsi_plus_display_button_type'] 		= 	(isset($option8['sfsi_plus_display_button_type']))
															? sanitize_text_field($option8['sfsi_plus_display_button_type'])
															: '';
	$option8['sfsi_plus_post_icons_size'] 			= 	(isset($option8['sfsi_plus_post_icons_size']))
															? intval($option8['sfsi_plus_post_icons_size'])
															: '';
	$option8['sfsi_plus_post_icons_spacing'] 		= 	(isset($option8['sfsi_plus_post_icons_spacing']))
															? intval($option8['sfsi_plus_post_icons_spacing'])
															: '';
															
	$option8['sfsi_plus_show_item_onposts'] 		= 	(isset($option8['sfsi_plus_show_item_onposts']))
															? sanitize_text_field($option8['sfsi_plus_show_item_onposts'])
															: '';
	$option8['sfsi_plus_icons_alignment'] 			= 	(isset($option8['sfsi_plus_icons_alignment']))
															? sanitize_text_field($option8['sfsi_plus_icons_alignment'])
															: '';
	$option8['sfsi_plus_textBefor_icons'] 			= 	(isset($option8['sfsi_plus_textBefor_icons']))
															? sanitize_text_field($option8['sfsi_plus_textBefor_icons'])
															: '';
	$option8['sfsi_plus_icons_DisplayCounts']		= 	(isset($option8['sfsi_plus_icons_DisplayCounts']))
															? sanitize_text_field($option8['sfsi_plus_icons_DisplayCounts'])
															: '';
	$option8['sfsi_plus_rectsub'] 					= 	(isset($option8['sfsi_plus_rectsub']))
															? sanitize_text_field($option8['sfsi_plus_rectsub'])
															: '';
	$option8['sfsi_plus_rectfb'] 					= 	(isset($option8['sfsi_plus_rectfb']))
															? sanitize_text_field($option8['sfsi_plus_rectfb'])
															: '';
	$option8['sfsi_plus_rectgp'] 					= 	(isset($option8['sfsi_plus_rectgp']))
															? sanitize_text_field($option8['sfsi_plus_rectgp'])
															: '';
	$option8['sfsi_plus_recttwtr'] 					= 	(isset($option8['sfsi_plus_recttwtr']))
															? sanitize_text_field($option8['sfsi_plus_recttwtr'])
															: '';
	$option8['sfsi_plus_rectpinit'] 				= 	(isset($option8['sfsi_plus_rectpinit']))
															? sanitize_text_field($option8['sfsi_plus_rectpinit'])
															: '';
	$option8['sfsi_plus_rectfbshare'] 				= 	(isset($option8['sfsi_plus_rectfbshare']))
															? sanitize_text_field($option8['sfsi_plus_rectfbshare'])
															: '';														
    $option8['sfsi_plus_show_premium_placement_box'] = 	(isset($option8['sfsi_plus_show_premium_placement_box']))
															? sanitize_text_field($option8['sfsi_plus_show_premium_placement_box'])
															: 'yes';
?>
<div class="tab8">
	<ul class="sfsiplus_icn_listing8">
    	<!--First Section-->
		<li class="">
			<div class="radio_section tb_4_ck" onclick="checkforinfoslction(this);"><input name="sfsi_plus_show_via_widget" <?php echo ($option8['sfsi_plus_show_via_widget']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_show_via_widget" type="checkbox" value="yes" class="styled"  /></div>
			<div class="sfsiplus_right_info">
				<p>
					<span class="sfsiplus_toglepstpgspn">
                    	<?php  _e( 'Show them via a widget', SFSI_PLUS_DOMAIN ); ?>
                    </span><br>
                    <?php
                    if($option8['sfsi_plus_show_via_widget']=='yes')
					{
						$label_style = 'style="display:block; font-size: 16px;"';
					}
					else
					{
						$label_style = 'style="font-size: 16px;"';
					}
					?>
					<label class="sfsiplus_sub-subtitle ckckslctn" <?php echo $label_style;?>>
                    	<?php  _e( 'Go to the widget area and drag & drop it where you want to have it!' , SFSI_PLUS_DOMAIN ); ?>
                    	<a href="<?php echo admin_url('widgets.php');?>">
                    		<?php  _e( 'Click here', SFSI_PLUS_DOMAIN ); ?>
                    	</a> 
                    </label>
				</p>
			</div>
		</li>
        
        <!--Second Section-->
		<li class="">
            <div class="radio_section tb_4_ck cstmfltonpgstck" onclick="sfsiplus_toggleflotpage(this);">
                <input name="sfsi_plus_float_on_page" <?php echo ($option8['sfsi_plus_float_on_page']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_float_on_page" type="checkbox" value="yes" class="styled" />
            </div>
			<div class="sfsiplus_right_info">
				<p>
					<span class="sfsiplus_toglepstpgspn">
                    	<?php  _e( 'Float them on the page', SFSI_PLUS_DOMAIN ); ?>
                    </span>
				</p>
                <?php
                if($option8['sfsi_plus_float_on_page'] == "yes")
				{
					$style = 'display: block;';
				}
				else
				{
					$style ="display: none;";
				}
				?>
                <div class="sfsiplus_tab_3_icns"  <?php echo 'style="'.$style.'"';?>>
					<ul class="sfsiplus_tab_3_icns flthmonpg">
                        <li>
                            <input name="sfsi_plus_float_page_position" <?php echo ( $option8['sfsi_plus_float_page_position']=='top-left') ?  'checked="true"' : '' ;?> type="radio" value="top-left" class="styled"  />
                            <span class="sfsi_flicnsoptn3 sfsioptntl">
                           		<?php  _e( 'Top left', SFSI_PLUS_DOMAIN ); ?>
                            </span>
                            <label><img src="<?php echo SFSI_PLUS_PLUGURL;?>images/top_left.png" /></label>
                        </li>
                        <li>
                            <input name="sfsi_plus_float_page_position" <?php echo ( $option8['sfsi_plus_float_page_position']=='top-right') ?  'checked="true"' : '' ;?> type="radio" value="top-right" class="styled"  />
                            <span class="sfsi_flicnsoptn3 sfsioptntr">
                            	<?php  _e( 'Top right', SFSI_PLUS_DOMAIN ); ?>
                            </span>
                            <label><img src="<?php echo SFSI_PLUS_PLUGURL;?>images/top_right.png" /></label>
                        </li>
                        <li>
                            <input name="sfsi_plus_float_page_position" <?php echo ( $option8['sfsi_plus_float_page_position']=='center-left') ?  'checked="true"' : '' ;?> type="radio" value="center-left" class="styled"  />
                            <span class="sfsi_flicnsoptn3 sfsioptncl">
                            	<?php  _e( 'Center left', SFSI_PLUS_DOMAIN ); ?>
                            </span>
                            <label><img src="<?php echo SFSI_PLUS_PLUGURL;?>images/center_left.png" /></label>
                        </li>
                        <li>
                            <input name="sfsi_plus_float_page_position" <?php echo ( $option8['sfsi_plus_float_page_position']=='center-right') ?  'checked="true"' : '' ;?> type="radio" value="center-right" class="styled"  />
                            <span class="sfsi_flicnsoptn3 sfsioptncr">
                            	<?php  _e( 'Center right', SFSI_PLUS_DOMAIN ); ?>
                            </span>
                            <label><img src="<?php echo SFSI_PLUS_PLUGURL;?>images/center_right.png" /></label>
                        </li>
                        <li>
                            <input name="sfsi_plus_float_page_position" <?php echo ( $option8['sfsi_plus_float_page_position']=='bottom-left') ?  'checked="true"' : '' ;?> type="radio" value="bottom-left" class="styled"  />
                            <span class="sfsi_flicnsoptn3 sfsioptnbl">
                            	<?php  _e( 'Bottom left', SFSI_PLUS_DOMAIN ); ?>
                            </span>
                            <label><img src="<?php echo SFSI_PLUS_PLUGURL;?>images/bottom_left.png" /></label>
                        </li>
                        <li>
                            <input name="sfsi_plus_float_page_position" <?php echo ( $option8['sfsi_plus_float_page_position']=='bottom-right') ?  'checked="true"' : '' ;?> type="radio" value="bottom-right" class="styled"  />
                            <span class="sfsi_flicnsoptn3 sfsioptnbr">
                            	<?php  _e( 'Bottom right', SFSI_PLUS_DOMAIN ); ?>
                            </span>
                            <label><img src="<?php echo SFSI_PLUS_PLUGURL;?>images/bottom_right.png" /></label>
                        </li>
                    </ul>
                    <div style="width: 88%; float: left; margin:25px 0 0 47px">
                    	<h4>
                       		<?php  _e( 'Margin From:', SFSI_PLUS_DOMAIN ); ?> 
                        </h4>
                        <ul class="sfsi_plus_floaticon_margin_sec">
                            <li>
                                <label>
                                	<?php  _e( 'Top:', SFSI_PLUS_DOMAIN ); ?> 
                                </label>
                                <input name="sfsi_plus_icons_floatMargin_top" type="text" value="<?php echo ($option8['sfsi_plus_icons_floatMargin_top']!='') ?  $option8['sfsi_plus_icons_floatMargin_top'] : '' ;?>" />
                                <ins>
                                	<?php  _e( 'Pixels', SFSI_PLUS_DOMAIN ); ?>
                                </ins>
                            </li>
                            <li>
                                <label>
                                	<?php  _e( 'Bottom:', SFSI_PLUS_DOMAIN ); ?> 
                                </label>
                                <input name="sfsi_plus_icons_floatMargin_bottom" type="text" value="<?php echo ($option8['sfsi_plus_icons_floatMargin_bottom'] != '') ?  $option8['sfsi_plus_icons_floatMargin_bottom'] : '' ;?>" />
                                <ins>
                                	<?php  _e( 'Pixels', SFSI_PLUS_DOMAIN ); ?>
                                </ins>
                            </li>
                            <li>
                                <label>
                             		<?php  _e( 'Left:', SFSI_PLUS_DOMAIN ); ?> 
                                </label>
                                <input name="sfsi_plus_icons_floatMargin_left" type="text" value="<?php echo ($option8['sfsi_plus_icons_floatMargin_left']!='') ?  $option8['sfsi_plus_icons_floatMargin_left'] : '' ;?>" />
                                <ins>
                              		<?php  _e( 'Pixels', SFSI_PLUS_DOMAIN ); ?>
                                </ins>
                            </li>
                            <li>
                                <label>
                                	<?php  _e( 'Right:', SFSI_PLUS_DOMAIN ); ?> 
                                </label>
                                <input name="sfsi_plus_icons_floatMargin_right" type="text" value="<?php echo ($option8['sfsi_plus_icons_floatMargin_right']!='') ?  $option8['sfsi_plus_icons_floatMargin_right'] : '' ;?>" />
                                <ins>
                                	<?php  _e( 'Pixels', SFSI_PLUS_DOMAIN ); ?>
                                </ins>
                            </li>
                        </ul>
                    </div>
                </div>
			</div>
		</li>
        
        <!--Third Section-->
		<li class="sfsiplusplacethemanulywpr">
			<div class="radio_section tb_4_ck" onclick="checkforinfoslction(this);"><input name="sfsi_plus_place_item_manually" <?php echo ($option8['sfsi_plus_place_item_manually']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_place_item_manually" type="checkbox" value="yes" class="styled"  /></div>
			<div class="sfsiplus_right_info">
				<p>
					<span class="sfsiplus_toglepstpgspn">
                    	<?php  _e( 'Place them manually', SFSI_PLUS_DOMAIN ); ?>
                    </span><br>
                    <?php
                    if($option8['sfsi_plus_place_item_manually']=='yes')
					{
						$label_style = 'style="display:block; font-size: 15px;"';
					}
					else
					{
						$label_style = 'style="font-size: 15px;"';
					}
					?>
					<label class="sfsiplus_sub-subtitle ckckslctn" <?php echo $label_style;?>>
                    	<?php _e('Place the following string into your theme codes: ',SFSI_PLUS_DOMAIN);?> 
						
                        &lt;?php echo DISPLAY_ULTIMATE_PLUS(); ?&gt;
                        
						<?php _e('Or use the shortcode [DISPLAY_ULTIMATE_PLUS] to display them wherever you want.',SFSI_PLUS_DOMAIN); ?>

						<?php _e('Need help with that? Ask us! <a style="color:#5a6570 !important;" target="_blank" href="https://wordpress.org/support/plugin/ultimate-social-media-plus#no-topic-0"><b>Click here</b></a>',SFSI_PLUS_DOMAIN); ?>

                    </label>
				</p>
			</div>
		</li>
        
        <!--Fourth Section-->
		<li class="sfsiplusbeforeafterpostselector">
			<div class="radio_section tb_4_ck" onclick="sfsiplus_toggleflotpage(this);"><input name="sfsi_plus_show_item_onposts" <?php echo ($option8['sfsi_plus_show_item_onposts']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_show_item_onposts" type="checkbox" value="yes" class="styled"  /></div>
			<div class="sfsiplus_right_info">
				<p>
					<span class="sfsiplus_toglepstpgspn">
                    	<?php  _e( 'Show them before or after posts', SFSI_PLUS_DOMAIN ); ?>
                    </span>
                    <br>
                    <?php
					if($option8['sfsi_plus_show_item_onposts'] != "yes")
					{
						$style_float = "style='font-size: 15px; display: none;'";
					}
					else
					{
						$style_float = "style='font-size: 15px;'";
					}
					?>
                    <label class="sfsiplus_sub-subtitle sfsiplus_toglpstpgsbttl" <?php echo $style_float;?>>
                    	<?php  _e( 'Here you have two options:', SFSI_PLUS_DOMAIN ); ?>
                    </label>
				</p>
				
				<ul class="sfsiplus_tab_3_icns sfsiplus_shwthmbfraftr" <?php echo ($option8['sfsi_plus_show_item_onposts'] != "yes")? 'style="display: none";' : '' ;?>>
					<li onclick="sfsiplus_togglbtmsection('sfsiplus_toggleonlystndrshrng', 'sfsiplus_toggledsplyitemslctn', this);" class="clckbltglcls">
						<input name="sfsi_plus_display_button_type" <?php echo ( $option8['sfsi_plus_display_button_type']=='standard_buttons') ?  'checked="true"' : '' ;?> type="radio" value="standard_buttons" class="styled"  />
						<label class="labelhdng4">
                        	<?php  _e( 'Display rectangle icons', SFSI_PLUS_DOMAIN ); ?>
                        </label>
                    </li>
                    <li onclick="sfsiplus_togglbtmsection('sfsiplus_toggledsplyitemslctn', 'sfsiplus_toggleonlystndrshrng', this);" class="clckbltglcls">
						<input name="sfsi_plus_display_button_type" <?php echo ( $option8['sfsi_plus_display_button_type']=='normal_button') ?  'checked="true"' : '' ;?> type="radio" value="normal_button" class="styled"  />
						<label class="labelhdng4">
                        	<?php  _e( 'Display the icons I selected above', SFSI_PLUS_DOMAIN ); ?>
                        </label>
                    </li>
					<li class="sfsiplus_toggleonlystndrshrng">
                    	<?php if ($option8['sfsi_plus_display_button_type']=='standard_buttons'): $display = "display:block"; else:  $display = "display:none"; endif;?>
						<div class="radiodisplaysection" style="<?php echo $display; ?>">

                            <p class="cstmdisplaysharingtxt cstmdisextrpdng">
                            	<?php  _e( 'Rectangle icons spell out the «call to action» which increases chances that visitors do it.', SFSI_PLUS_DOMAIN ); ?>
                            </p>
							<p class="cstmdisplaysharingtxt">
                            	<?php  _e( 'Select the icons you want to show:', SFSI_PLUS_DOMAIN ); ?>
                            </p>
                            <div class="social_icon_like1 cstmdsplyulwpr">
                                <ul>
                                    <li>
										<div class="radio_section tb_4_ck"><input name="sfsi_plus_rectsub" <?php echo ($option8['sfsi_plus_rectsub']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_rectsub" type="checkbox" value="yes" class="styled"  /></div>
                                        <a href="#" title="Subscribe Follow" class="cstmdsplsub">
                                            <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/follow_subscribe.png" alt="Subscribe Follow" /><span style="display: none;">18k</span>
                                        </a>
                                    </li>
									<li>
										<div class="radio_section tb_4_ck"><input name="sfsi_plus_rectfb" <?php echo ($option8['sfsi_plus_rectfb']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_rectfb" type="checkbox" value="yes" class="styled"  /></div>
                                        <a href="#" title="Facebook Like" class="cstmdspllke">
                                            <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/like.jpg" alt="Facebook Like" /><span style="display: none;">18k</span>
                                        </a>
                                    </li>
									<li>
										<div class="radio_section tb_4_ck"><input name="sfsi_plus_rectfbshare" <?php echo ($option8['sfsi_plus_rectfbshare']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_rectfbshare" type="checkbox" value="yes" class="styled"  /></div>
                                        <a href="#" title="Facebook Share" class="cstmdsplfbshare">
                                            <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/fbshare.png" alt="Facebook Share" /><span style="display: none;">18k</span>
                                        </a>
                                    </li>
                                    <li>
										<div class="radio_section tb_4_ck"><input name="sfsi_plus_recttwtr" <?php echo ($option8['sfsi_plus_recttwtr']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_recttwtr" type="checkbox" value="yes" class="styled"  /></div>
                                        <a href="#" title="twitter" class="cstmdspltwtr">
                                            <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/twiiter.png" alt="Twitter like" /><span style="display: none;">18k</span>
                                        </a>
                                    </li>
									<li>
										<div class="radio_section tb_4_ck"><input name="sfsi_plus_rectpinit" <?php echo ($option8['sfsi_plus_rectpinit']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_rectpinit" type="checkbox" value="yes" class="styled"  /></div>
                                        <a href="#" title="Pinit" class="cstmdsplpinit">
                                            <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/pinit.png" alt="Pinit" /><span style="display: none;">18k</span>
                                        </a>
                                    </li>
									<li>
										<div class="radio_section tb_4_ck"><input name="sfsi_plus_rectgp" <?php echo ($option8['sfsi_plus_rectgp']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_rectgp" type="checkbox" value="yes" class="styled"  /></div>
                                        <a href="#" title="Google Plus" class="cstmdsplggpls">
                                            <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/google_plus1.jpg" alt="Google Plus" /><span style="display: none;">18k</span>
                                        </a>
                                    </li>
                                    
								</ul>	
                            </div>
                             <?php if($option8['sfsi_plus_show_premium_placement_box'] == 'yes'){ ?>
						    <p class ="sfsi_plus_prem_plu_desc">	
								<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( 'We also added a Linkedin share-icon in the Premium Plugin.', SFSI_PLUS_DOMAIN ); ?> <a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=linkedin_icon&utm_medium=banner" target="_blank"><?php  _e( 'Check it out.', SFSI_PLUS_DOMAIN ); ?></a>
							</p>
                            <?php } ?>
                            <!--<p class="clear">Those are usually all you need: </p>
                            <ul class="usually" style="color:#5a6570">
                                <li>1. Facebook is No.1 in liking, so it’s a must have</li>
                                <li>2. Google+ is also important due to SEO reasons, so important to have as well</li>
                                <li>3. Share-button covers all other platforms for sharing</li>
                            </ul>-->
                            <div class="options">
                                <label>
                                	<?php  _e( 'Do you want to display the counts?', SFSI_PLUS_DOMAIN ); ?>
                                </label><div class="field">
                                <select name="sfsi_plus_icons_DisplayCounts" id="sfsi_plus_icons_DisplayCounts" class="styled"><option value="yes" <?php echo ($option8['sfsi_plus_icons_DisplayCounts']=='yes') ?  'selected="true"' : '' ;?>>
                                	<?php  _e( 'YES', SFSI_PLUS_DOMAIN ); ?>
                                </option><option value="no" <?php echo ($option8['sfsi_plus_icons_DisplayCounts']=='no') ?  'selected="true"' : '' ;?>>
                                	<?php  _e( 'NO', SFSI_PLUS_DOMAIN ); ?>
                                </option></select></div>
                            </div>
					  </div>
                    </li>
					
					<li class="sfsiplus_toggledsplyitemslctn">
                    	<?php if ($option8['sfsi_plus_display_button_type']=='normal_button'): $display = "display:block"; else:  $display = "display:none"; endif;?>
						<div class="row radiodisplaysection" style="<?php echo $display; ?>">
							<h4>
                            	<?php  _e( 'Size and spacing of your icons', SFSI_PLUS_DOMAIN ); ?>
                            </h4>
							<div class="icons_size">
                            <span>
                            	<?php  _e( 'Size:', SFSI_PLUS_DOMAIN ); ?>
                            </span><input name="sfsi_plus_post_icons_size" value="<?php echo ($option8['sfsi_plus_post_icons_size']!='') ?  $option8['sfsi_plus_post_icons_size'] : '' ;?>" type="text" /><ins>
                           		<?php  _e( 'pixels wide and tall', SFSI_PLUS_DOMAIN ); ?>
                            </ins> <span class="last">
                            	<?php  _e( 'Spacing between icons:', SFSI_PLUS_DOMAIN ); ?>
                            </span><input name="sfsi_plus_post_icons_spacing" type="text" value="<?php echo ($option8['sfsi_plus_post_icons_spacing']!='') ?  $option8['sfsi_plus_post_icons_spacing'] : '' ;?>" /><ins>
                            	<?php  _e( 'Pixels', SFSI_PLUS_DOMAIN ); ?>
                            </ins></div>
						</div>
                    </li>
                      
                  <li class="row sfsiplus_PostsSettings_section">
                    <!--<h4 class="labelhdng4">Options:</h4>-->
                    
                    <!--Display them options-->
                    <div class="options sfsipluspstvwpr">
                        <label class="first chcklbl">
                        	<?php  _e( 'Display them:', SFSI_PLUS_DOMAIN ); ?>
                        </label>
                        <label class="seconds chcklbl labelhdng4">
                        	<?php  _e( 'On Post Pages', SFSI_PLUS_DOMAIN ); ?>
                        </label>
                        <div class="chckwpr">
                            <div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_before_posts" <?php echo ($option8['sfsi_plus_display_before_posts']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_before_posts" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">
                                	<?php  _e( 'Before posts', SFSI_PLUS_DOMAIN ); ?>
                                </div>
                            </div>
                            <div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_after_posts" <?php echo ($option8['sfsi_plus_display_after_posts']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_after_posts" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">
                                	<?php  _e( 'After posts', SFSI_PLUS_DOMAIN ); ?>
                                </div>
                            </div>
                            <!--<div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_on_postspage" <?php //echo ($option8['sfsi_plus_display_on_postspage']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_on_postspage" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">On posts pages</div>
                            </div>
                            <div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_on_homepage" <?php //echo ($option8['sfsi_plus_display_on_homepage']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_on_homepage" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">On homepage</div>
                            </div>-->
                        </div>
                    </div>
                    
                    
                    <div class="options sfsipluspstvwpr">
                        <label class="seconds chcklbl labelhdng4">
                        	<?php  _e( 'On Homepage', SFSI_PLUS_DOMAIN ); ?>
                        </label>
                        <div class="chckwpr">
                            <div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_before_blogposts" <?php echo ($option8['sfsi_plus_display_before_blogposts']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_before_blogposts" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">
                                	<?php  _e( 'Before posts', SFSI_PLUS_DOMAIN ); ?>
                                </div>
                            </div>
                            <div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_after_blogposts" <?php echo ($option8['sfsi_plus_display_after_blogposts']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_after_blogposts" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">
                                	<?php  _e( 'After posts', SFSI_PLUS_DOMAIN ); ?>
                                </div>
                            </div>
                            <!--<div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_on_postspage" <?php //echo ($option8['sfsi_plus_display_on_postspage']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_on_postspage" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">On posts pages</div>
                            </div>
                            <div class="snglchckcntr">
                                <div class="radio_section tb_4_ck"><input name="sfsi_plus_display_on_homepage" <?php //echo ($option8['sfsi_plus_display_on_homepage']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_display_on_homepage" type="checkbox" value="yes" class="styled"  /></div>
                                <div class="sfsiplus_right_info">On homepage</div>
                            </div>-->
                        </div>
                    </div>
                    
                    <!--Display them options-->
                    
                    
                    <div class="options shareicontextfld">
                        <label class="first">
                        	<?php  _e( 'Text to appear before the sharing icons:', SFSI_PLUS_DOMAIN ); ?>
                        </label><input name="sfsi_plus_textBefor_icons" type="text" value="<?php echo ($option8['sfsi_plus_textBefor_icons']!='') ?  $option8['sfsi_plus_textBefor_icons'] : '' ; ?>" />
                         <?php if($option8['sfsi_plus_show_premium_placement_box'] == 'yes'){ ?>
                        <p class ="sfsi_plus_prem_plu_desc_define">	
							<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( ' In the Premium Plugin you can now also define the font size, type, and the margins below/above the icons. ', SFSI_PLUS_DOMAIN ); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_placement_options&utm_medium=banner" target="_blank"><?php  _e( 'Check it out.', SFSI_PLUS_DOMAIN ); ?></a>
					    </p>
					    <?php } ?>
                    </div>
                    
                    <div class="options">
                        <label>
                         	<?php  _e( 'Alignment of share icons:', SFSI_PLUS_DOMAIN ); ?>
                        </label><div class="field">
                        <select name="sfsi_plus_icons_alignment" id="sfsi_plus_icons_alignment" class="styled">
                        	<option value="left" <?php echo ($option8['sfsi_plus_icons_alignment']=='left') ?  'selected="selected"' : '' ;?>>
                        		<?php  _e( 'Left', SFSI_PLUS_DOMAIN ); ?>
                        	</option>
                            <option value="right" <?php echo ($option8['sfsi_plus_icons_alignment']=='right') ?  'selected="selected"' : '' ;?>>
                        		<?php  _e( 'Right', SFSI_PLUS_DOMAIN ); ?>
                        	</option>
                            <option value="center" <?php echo ($option8['sfsi_plus_icons_alignment']=='center') ?  'selected="selected"' : '' ;?>>
                        		<?php  _e( 'Center', SFSI_PLUS_DOMAIN ); ?>
                        	</option>
                        </select></div>
                    </div>
                    <!--<div class="options">
                        <label>Do you want to display the counts?</label><div class="field"><select name="sfsi_plus_icons_DisplayCounts" id="sfsi_plus_icons_DisplayCounts" class="styled"><option value="yes" <?php //echo ($option8['sfsi_plus_icons_DisplayCounts']=='yes') ?  'selected="true"' : '' ;?>>YES</option><option value="no" <?php //echo ($option8['sfsi_plus_icons_DisplayCounts']=='no') ?  'selected="true"' : '' ;?>>NO</option></select></div>
                    </div>-->	
                    
                  </li>
                  
				</ul>	
			</div>
		</li>
		
		 <!--Fifth Section-->
		<li class="sfsiplusplaceusinggutenberg">
			<div class="radio_section tb_4_ck" onclick="checkforinfoslction(this);"><input name="sfsi_plus_place_item_gutenberg" <?php echo ($option8['sfsi_plus_place_item_gutenberg']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_place_item_gutenberg" type="checkbox" value="yes" class="styled"  /></div>
			<div class="sfsiplus_right_info">
				<p>
					<span class="sfsiplus_toglepstpgspn">
                    	<?php  _e( 'Show them in the Gutenberg editor', SFSI_PLUS_DOMAIN ); ?>
                    </span><br>
                    <?php
                    if($option8['sfsi_plus_place_item_gutenberg']=='yes')
					{
						$label_style = 'style="display:block; font-size: 15px;"';
					}
					else
					{
						$label_style = 'style="font-size: 15px;"';
					}
					?>
					<label class="sfsiplus_sub-subtitle ckckslctn" <?php echo $label_style;?>>
                    	<?php _e('Look for this sign',SFSI_PLUS_DOMAIN); ?> <img style="margin-bottom:-4px" width="20" src="<?php echo SFSI_PLUS_PLUGURL ?>images/sfsi_block_icon.jpg"> <?php _e(' in your Gutenberg editor and click on it. Then a new block with the icons will be added.',SFSI_PLUS_DOMAIN);?> 

                    </label>
				</p>
			</div> 
		</li>
		<!-- pinterest on image over icon -->
        <li class="row sfsiplus_show_via_onhover  disabled_checkbox">
	
			<div class="radio_section tb_4_ck">
				<span class="checkbox" style="background-position:0px 0px!important;width:31px"></span>
				<input name="" type="checkbox" disable value="" class="hide" style="display:none;"  /></div>
			
			<div class="sfsiplus_right_info">
				
                <p style="display:block">
					<span class="sfsiplus_toglepstpgspn" style="width:50%;display:inline-block" >Show a Pinterest icon over images on mouse-over </span> <span><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmi_settings_page&utm_campaign=pinterest_icon_mouse_over&utm_medium=link" target="_blank" style="font-weight:800;color:#777">Premium feature</a></span>
				</p>
				
			</div>
		</li>
	</ul>
	<?php if($option8['sfsi_plus_show_premium_placement_box'] == 'yes'){ ?>
	<div class ="sfsi_plus_new_prmium_follw">
		<p>
			<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( 'In our Premium Plugin you have many more placement options, e.g. place the icons statically on the page, optimize placement for mobile, don’t show them on certain pages, show them while user is scrolling down the page (or not) etc. ', SFSI_PLUS_DOMAIN ); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_placement_options&utm_medium=banner" target="_blank"><?php  _e( 'See all features', SFSI_PLUS_DOMAIN ); ?></a>
			</p>
    </div>
    <?php } ?>
    
	<?php sfsi_plus_ask_for_help(8); ?>

	<!-- SAVE BUTTON SECTION   --> 
	<div class="save_button">
       <img src="<?php echo SFSI_PLUS_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
       <?php  $nonce = wp_create_nonce("update_plus_step8"); ?>
        <a  href="javascript:;" id="sfsi_plus_save8" title="Save" data-nonce="<?php echo $nonce;?>">
        	<?php  _e( 'Save', SFSI_PLUS_DOMAIN ); ?>
        </a>
  	</div>
    <!-- END SAVE BUTTON SECTION   -->
	
    <a class="sfsiColbtn closeSec" href="javascript:;">
    	<?php  _e( 'Collapse area', SFSI_PLUS_DOMAIN ); ?>
    </a>
	<label class="closeSec"></label>
    
	<!-- ERROR AND SUCCESS MESSAGE AREA-->
	<p class="red_txt errorMsg" style="display:none"> </p>
	<p class="green_txt sucMsg" style="display:none"> </p>
	<div class="clear"></div>
	
</div>
