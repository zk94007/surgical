	<?php
	/* unserialize all saved option for  section 7 options */
    $option7=  unserialize(get_option('sfsi_plus_section7_options',false));
	
	/**
	 * Sanitize, escape and validate values
	 */
	$option7['sfsi_plus_popup_text'] 				=	(isset($option7['sfsi_plus_popup_text']))
															? sanitize_text_field($option7['sfsi_plus_popup_text'])
															: '';
	$option7['sfsi_plus_popup_background_color']	=	(isset($option7['sfsi_plus_popup_background_color']))
															? sfsi_plus_sanitize_hex_color($option7['sfsi_plus_popup_background_color'])
															: '';
	$option7['sfsi_plus_popup_border_color'] 		=	(isset($option7['sfsi_plus_popup_border_color']))
															? sfsi_plus_sanitize_hex_color($option7['sfsi_plus_popup_border_color'])
															: '';
	$option7['sfsi_plus_popup_border_thickness'] 	=	(isset($option7['sfsi_plus_popup_border_thickness']))
															? intval($option7['sfsi_plus_popup_border_thickness'])
															: '';
	$option7['sfsi_plus_popup_border_shadow'] 		=	(isset($option7['sfsi_plus_popup_border_shadow']))
															? sanitize_text_field($option7['sfsi_plus_popup_border_shadow'])
															: '';
	$option7['sfsi_plus_popup_font'] 				=	(isset($option7['sfsi_plus_popup_font']))
															? sanitize_text_field($option7['sfsi_plus_popup_font'])
															: '';
	$option7['sfsi_plus_popup_fontSize'] 			=	(isset($option7['sfsi_plus_popup_fontSize']))
															? intval($option7['sfsi_plus_popup_fontSize'])
															: '';
	$option7['sfsi_plus_popup_fontStyle'] 			=	(isset($option7['sfsi_plus_popup_fontStyle']))
															? sanitize_text_field($option7['sfsi_plus_popup_fontStyle'])
															: '';
	$option7['sfsi_plus_popup_fontColor'] 			=	(isset($option7['sfsi_plus_popup_fontColor']))
															? sfsi_plus_sanitize_hex_color($option7['sfsi_plus_popup_fontColor'])
															: '';
	$option7['sfsi_plus_Show_popupOn'] 				=	(isset($option7['sfsi_plus_Show_popupOn']))
															? sanitize_text_field($option7['sfsi_plus_Show_popupOn'])
															: '';
	$option7['sfsi_plus_Shown_pop'] 				=	(isset($option7['sfsi_plus_Shown_pop']))
															? sanitize_text_field($option7['sfsi_plus_Shown_pop'])
															: '';
	$option7['sfsi_plus_Shown_popupOnceTime'] 		=	(isset($option7['sfsi_plus_Shown_popupOnceTime']))
															? intval($option7['sfsi_plus_Shown_popupOnceTime'])
															: '';
    $option7['sfsi_plus_premium_popup_box'] 		=	(isset($option7['sfsi_plus_premium_popup_box']))
															? sanitize_text_field($option7['sfsi_plus_premium_popup_box'])
															: 'yes';
?>
<!-- Section 7 "Do you want to display a pop-up, asking people to subscribe?" main div Start -->
<div class="tab7">
	<p>
    	<?php  _e( 'You can increase chances that people share or follow you by displaying a pop-up asking them to. You can define the design and layout below:', SFSI_PLUS_DOMAIN  ); ?>
    </p>
<!-- icons preview section -->
<div class="like_pop_box">
	<div class="sfsi_plus_Popinner">
	<h2>
		<?php  _e( 'Enjoy this site? Please follow and like us!', SFSI_PLUS_DOMAIN ); ?>
	</h2>
	<ul class="like_icon plus_sfsi_sample_icons">
    	 <li class="sfsiplus_rss_section">
         	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/rss.png" alt="RSS" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_rss_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_email_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/<?php echo $email_image; ?>" alt="Email" class="icon_img" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_email_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_facebook_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/fb.png" alt="Facebook" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_facebook_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_google_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/google_plus.png" alt="Google Plus" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_google_countsDisplay">12k</span>
           	</div>
        </li>
        <li class="sfsiplus_twitter_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/twitter.png" alt="Twitter" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_twitter_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_youtube_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/youtube.png" alt="YouTube" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_youtube_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_pinterest_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/pinterest.png" alt="Pinterest" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_pinterest_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_linkedin_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/linked_in.png" alt="Linked In" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_linkedIn_countsDisplay">12k</span>
            </div>
        </li>
		<li class="sfsiplus_instagram_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/instagram.png" alt="Instagram" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_instagram_countsDisplay">12k</span>
            </div>
        </li>
        <li class="sfsiplus_houzz_section">
        	<div>
            	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/houzz.png" alt="Houzz" />
                <span class="sfsi_Cdisplay" id="sfsi_plus_houzz_countsDisplay">12k</span>
            </div>
        </li>
		<?php
		if(isset($icons) && !empty($icons))
		{
			if(is_array($icons))
			{
				foreach($icons as $icn =>$img)
				{
					echo '<li class="sfsiplus_custom_section sfsiICON_'.$icn.'"  element-id="'.$icn.'" ><div><img src="'.$img.'" alt="Custom Icon" class="sfcm" /><span class="sfsi_Cdisplay">12k</span></div></li>';
				}
			}
		}
		?>
	</ul>  
</div>
</div>
<!-- END icons preview section -->

<!-- icons controllers section -->
<div class="space">
	
    <h4><?php  _e( 'Text and Design', SFSI_PLUS_DOMAIN ); ?></h4>
	
    <div class="text_options">
		
        <h3><?php  _e( 'Text Options', SFSI_PLUS_DOMAIN ); ?></h3>
		
        <div class="sfsiplus_row_tab">
                    <label><?php  _e( 'Text:', SFSI_PLUS_DOMAIN ); ?></label>
                    <input class="mkPop" name="sfsi_plus_popup_text" type="text" value="<?php echo ($option7['sfsi_plus_popup_text']!='') ? __($option7['sfsi_plus_popup_text'], SFSI_PLUS_DOMAIN) : '' ;?>" />
		</div>
		<div class="sfsiplus_row_tab">
			<label><?php  _e( 'Font:', SFSI_PLUS_DOMAIN ); ?></label>
			<div class="field">
				<select name="sfsi_plus_popup_font" id="sfsi_plus_popup_font" class="styled">
					<option value="Arial, Helvetica, sans-serif" <?php echo ($option7['sfsi_plus_popup_font']=='Arial, Arial, Helvetica, sans-serif') ?  'selected="true"' : '' ;?>>
						Arial
					</option>
					<option value="Arial Black, Gadget, sans-serif" <?php echo ($option7['sfsi_plus_popup_font']=='Arial Black, Gadget, sans-serif') ?  'selected="true"' : '' ;?>>
						Arial Black
					</option>
					<option value="Calibri" <?php echo ($option7['sfsi_plus_popup_font']=='Calibri') ?  'selected="true"' : '' ;?>>
						Calibri
					</option>
					<option value="Comic Sans MS" <?php echo ($option7['sfsi_plus_popup_font']=='Comic Sans MS') ?  'selected="true"' : '' ;?>>
						Comic Sans MS
					</option>
					<option value="Courier New" <?php echo ($option7['sfsi_plus_popup_font']=='Courier New') ?  'selected="true"' : '' ;?>>
						Courier New
					</option>
					<option value="Georgia" <?php echo ($option7['sfsi_plus_popup_font']=='Georgia') ?  'selected="true"' : '' ;?>>
						Georgia
					</option>
					<option value="Helvetica,Arial,sans-serif" <?php echo ($option7['sfsi_plus_popup_font']=='Helvetica,Arial,sans-serif') ?  'selected="true"' : '' ;?>>
						Helvetica
					</option>
					<option value="Impact" <?php echo ($option7['sfsi_plus_popup_font']=='Impact') ?  'selected="true"' : '' ;?>>
						Impact
					</option>
					<option value="Lucida Console" <?php echo ($option7['sfsi_plus_popup_font']=='Lucida Console') ?  'selected="true"' : '' ;?>>
						Lucida Console
					</option>
					<option value="Tahoma,Geneva" <?php echo ($option7['sfsi_plus_popup_font']=='Tahoma,Geneva') ?  'selected="true"' : '' ;?>>
						Tahoma
					</option>
					<option value="Times New Roman" <?php echo ($option7['sfsi_plus_popup_font']=='Times New Roman') ?  'selected="true"' : '' ;?>>
						Times New Roman
					</option>
					<option value="Trebuchet MS" <?php echo ($option7['sfsi_plus_popup_font']=='Trebuchet MS') ?  'selected="true"' : '' ;?>>
						Trebuchet MS
					</option>
					<option value="Verdana" <?php echo ($option7['sfsi_plus_popup_font']=='Verdana') ?  'selected="true"' : '' ;?>>
						Verdana
					</option>
				</select>
			</div>
		</div>
		<div class="sfsiplus_row_tab">
			<label><?php  _e( 'Font style:', SFSI_PLUS_DOMAIN ); ?></label>
			<div class="field">
				<select name="sfsi_plus_popup_fontStyle" id="sfsi_plus_popup_fontStyle" class="styled">
					<option value="normal" <?php echo ($option7['sfsi_plus_popup_fontStyle']=='normal') ?  'selected="true"' : '' ;?>>
						Normal
					</option>
					<option value="inherit" <?php echo ($option7['sfsi_plus_popup_fontStyle']=='inherit') ?  'selected="true"' : '' ;?>>
						Inherit
					</option>
					<option value="oblique" <?php echo ($option7['sfsi_plus_popup_fontStyle']=='oblique') ?  'selected="true"' : '' ;?>>
						Oblique
					</option>
					<option value="italic" <?php echo ($option7['sfsi_plus_popup_fontStyle']=='italic') ?  'selected="true"' : '' ;?>>
						Italic
					</option>
				</select>
			</div>
		</div>
		<div class="sfsiplus_row_tab">
			<label><?php  _e( 'Font color:', SFSI_PLUS_DOMAIN ); ?></label>
            <input name="sfsi_plus_popup_fontColor" data-default-color="#b5b5b5" id="sfsi_plus_popup_fontColor" type="text" value="<?php echo ($option7['sfsi_plus_popup_fontColor']!='') ?  $option7['sfsi_plus_popup_fontColor'] : '' ;?>" />
		</div>
		<div class="sfsiplus_row_tab">
			<label>
            	<?php  _e( 'Font size:', SFSI_PLUS_DOMAIN ); ?>
            </label>
            <input name="sfsi_plus_popup_fontSize" type="text" value="<?php echo ($option7['sfsi_plus_popup_fontSize']!='') ?  $option7['sfsi_plus_popup_fontSize'] : '' ;?>" class="small" />
		</div>
	</div>
	<div class="text_options layout">
		<h3>
        	<?php  _e( 'Icon Box Layout', SFSI_PLUS_DOMAIN ); ?>
        </h3>
		<div class="sfsiplus_row_tab">
			<label>
            	<?php  _e( 'Background Color:', SFSI_PLUS_DOMAIN ); ?>
			</label>
            <input name="sfsi_plus_popup_background_color" data-default-color="#b5b5b5" id="sfsi_plus_popup_background_color" type="text" value="<?php echo ($option7['sfsi_plus_popup_background_color']!='') ?  $option7['sfsi_plus_popup_background_color'] : '' ;?>" />
		</div>
		<div class="sfsiplus_row_tab">
			<label class="border">
           		<?php  _e( 'Border Color:', SFSI_PLUS_DOMAIN ); ?>
            </label>
			<div class="field">
            	<input name="sfsi_plus_popup_border_color" data-default-color="#b5b5b5" id="sfsi_plus_popup_border_color" type="text" value="<?php echo ($option7['sfsi_plus_popup_border_color']!='') ?  $option7['sfsi_plus_popup_border_color'] : '' ;?>"  />
			</div>
		</div>
		<div class="sfsiplus_row_tab">
			<label>
            	<?php  _e( 'Border Thickness:', SFSI_PLUS_DOMAIN ); ?>
			</label>
			<div class="field">
            	<input name="sfsi_plus_popup_border_thickness" type="text" value="<?php echo ($option7['sfsi_plus_popup_border_thickness']!='') ?  $option7['sfsi_plus_popup_border_thickness'] : '' ;?>" class="small" />
			</div>
		</div>
		<div class="sfsiplus_row_tab">
			<label>
             	<?php  _e( 'Border Shadow:', SFSI_PLUS_DOMAIN ); ?>
            </label>
			<ul class="border_shadow">
  				<li>
                	<input name="sfsi_plus_popup_border_shadow" <?php echo ($option7['sfsi_plus_popup_border_shadow']=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
    				<label> 
						<?php  _e( 'On', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
    			<li>
                	<input name="sfsi_plus_popup_border_shadow" <?php echo ($option7['sfsi_plus_popup_border_shadow']=='no') ?  'checked="true"' : '' ;?>  type="radio" value="no" class="styled" />
                    <label>
                        <?php  _e( 'Off', SFSI_PLUS_DOMAIN ); ?>
                    </label>
                </li>
  			</ul>
		</div>
	</div>
</div>

<div class="row">
	<h4>
    	<?php  _e( 'Where shall the pop-up be shown?', SFSI_PLUS_DOMAIN ); ?>
    </h4>
	<div class="pop_up_show">
    	<input name="sfsi_plus_Show_popupOn" <?php echo ($option7['sfsi_plus_Show_popupOn']=='none') ?  'checked="true"' : '' ;?> type="radio" value="none" class="styled" />
        <label>
        	<?php  _e( 'Nowhere', SFSI_PLUS_DOMAIN ); ?>
        </label>
    </div>
	<div class="pop_up_show">
    	<input name="sfsi_plus_Show_popupOn" <?php echo ($option7['sfsi_plus_Show_popupOn']=='everypage') ?  'checked="true"' : '' ;?> type="radio" value="everypage" class="styled" />
        <label>
            <?php  _e( 'On every page', SFSI_PLUS_DOMAIN ); ?>
        </label>
    </div>
	<div class="pop_up_show">
    	<input name="sfsi_plus_Show_popupOn" <?php echo ($option7['sfsi_plus_Show_popupOn']=='blogpage') ?  'checked="true"' : '' ;?> type="radio" value="blogpage" class="styled"/>
        <label>
            <?php  _e( 'On blog posts only', SFSI_PLUS_DOMAIN ); ?>
        </label>
    </div>
	<div class="pop_up_show">
    	<input name="sfsi_plus_Show_popupOn" <?php echo ($option7['sfsi_plus_Show_popupOn']=='selectedpage') ?  'checked="true"' : '' ;?>  type="radio" value="selectedpage" class="styled"/>
        <label>
            <?php  _e( 'On selected pages only', SFSI_PLUS_DOMAIN ); ?>
        </label>
		<div class="field" style="width:50%">
        	<select multiple="multiple" name="sfsi_plus_Show_popupOn_PageIDs" id="sfsi_plus_Show_popupOn_PageIDs" style="width:60%;min-height: 150px;">
            <?php
			$select=  (isset($option7['sfsi_plus_Show_popupOn_PageIDs'])) ? unserialize($option7['sfsi_plus_Show_popupOn_PageIDs']) :array();
			$get_pages = get_pages( array( 
				'offset'=> 1,
				'hierarchical'=>1,     
				'sort_order' => 'DESC', 
				'sort_column' => 'post_date', 
				'posts_per_page' => 200, 
				'post_status' => 'publish' 
			)); 
			if( $get_pages )
			{
				
				foreach( $get_pages as $page )
				{
					if(!empty($select))
					{
						if( in_array( $page->ID, $select) )
						{
							$selected_box = 'selected="selected"';
							$class = 'class="sel-active"';
						}
						else
						{
							$selected_box = '';
							$class = '';
						}
					}
					else
					{
						$selected_box = '';
						$class = '';
					}
					echo '<option value="'.$page->ID.'" style="margin-bottom: 3px;" '.$selected_box.' '.$class.'>'.$page->post_title.'</option>';
				}
			   
			}
			?>   
            </select><br/>
            <?php  _e( 'Please hold CTRL key to select multiple pages', SFSI_PLUS_DOMAIN ); ?>.
        </div>
	</div>
</div>
<div class="row">
	<h4>
    	<?php  _e( 'When shall the pop-up be shown?', SFSI_PLUS_DOMAIN ); ?>
    </h4>
	<div class="pop_up_show">
    	<input name="sfsi_plus_Shown_pop" <?php echo ($option7['sfsi_plus_Shown_pop']=='once') ?  'checked="true"' : '' ;?> type="radio" value="once" class="styled" />
        <label>
            <?php  _e( 'Once', SFSI_PLUS_DOMAIN ); ?> 
            <input name="sfsi_plus_Shown_popupOnceTime" type="text" value="<?php echo ($option7['sfsi_plus_Shown_popupOnceTime']!='') ?  $option7['sfsi_plus_Shown_popupOnceTime'] : '' ;?>" class="seconds" /> 
                <?php  _e( 'seconds after the user arrived on the site', SFSI_PLUS_DOMAIN ); ?>
        </label>
    </div>
	<div class="pop_up_show">
    	<input name="sfsi_plus_Shown_pop" <?php echo ($option7['sfsi_plus_Shown_pop']=='ETscroll') ?  'checked="true"' : '' ;?> type="radio" value="ETscroll" class="styled"/>
        <label>
            <?php  _e( 'Every time user scrolls to the end of the page', SFSI_PLUS_DOMAIN ); ?>
        </label>
    </div> 
     <?php if($option7['sfsi_plus_premium_popup_box'] =='yes'){ ?> 
   
<!-- 	    <div class="sfsi_plus_prem_show">
	        <p class=sfsi_plus_prem_plu_desc>
				<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b>
	            <?php  _e( 'The Premium Plugin also allows you to show the pop-up when a user tries to leave your page . Also, you can limit how often the pop-up is shown to the same user (e.g. only once per day) ', SFSI_PLUS_DOMAIN ); ?>
	           <a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_popup_options&utm_medium=banner" target="_blank"> <?php  _e( 'Check it out', SFSI_PLUS_DOMAIN ); ?></a>
			</p>
	    </div>  -->

		<div class ="sfsi_plus_new_prmium_follw">

			<p>
				<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b>
				<?php  _e( 'The Premium Plugin also allows you to show the pop-up when a user tries to leave your page . Also, you can limit how often the pop-up is shown to the same user (e.g. only once per day) ', SFSI_PLUS_DOMAIN ); ?>
				<br>- &nbsp;&nbsp;<?php  _e( 'Show it when users try to leave your page', SFSI_PLUS_DOMAIN ); ?>
				<br>- &nbsp;&nbsp;<?php  _e( 'Limit how often the pop-up is shown to the same user (e.g. only once per day)', SFSI_PLUS_DOMAIN ); ?>
				<br>- &nbsp;&nbsp;<?php  _e( 'Select to show the subscription form in the pop-up (which you designed in question 8)', SFSI_PLUS_DOMAIN ); ?>
				<br>
				<a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_popup_options&utm_medium=banner" target="_blank"><?php  _e( 'See all features', SFSI_PLUS_DOMAIN ); ?></a>
			</p>	        	
		</div>

    <?php } ?>      
</div>

<?php sfsi_plus_ask_for_help(7); ?>

 <!-- SAVE BUTTON SECTION   --> 
<div class="save_button">
	<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
    <?php  $nonce = wp_create_nonce("update_plus_step7"); ?>
    <a href="javascript:;" id="sfsi_plus_save7" title="Save" data-nonce="<?php echo $nonce;?>">
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
<!-- END Section 7 "Do you want to display a pop-up, asking people to subscribe?" main div Start -->
