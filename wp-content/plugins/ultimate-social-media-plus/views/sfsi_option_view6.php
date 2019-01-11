<?php
	/* unserialize all saved option for  section 6 options */
    $option6=  unserialize(get_option('sfsi_plus_section6_options',false));
	/*
	 * Sanitize, escape and validate values
	 */
	$option6['sfsi_plus_show_Onposts'] 			= 	(isset($option6['sfsi_plus_show_Onposts']))
														? sanitize_text_field($option6['sfsi_plus_show_Onposts'])
														: '';
	$option6['sfsi_plus_icons_postPositon'] 	= 	(isset($option6['sfsi_plus_icons_postPositon']))
														? sanitize_text_field($option6['sfsi_plus_icons_postPositon'])
														: '';
	$option6['sfsi_plus_icons_alignment'] 		= 	(isset($option6['sfsi_plus_icons_alignment']))
														? sanitize_text_field($option6['sfsi_plus_icons_alignment'])
														: '';
	$option6['sfsi_plus_textBefor_icons'] 		= 	(isset($option6['sfsi_plus_textBefor_icons']))
														? sanitize_text_field($option6['sfsi_plus_textBefor_icons'])
														: '';
	$option6['sfsi_plus_icons_DisplayCounts'] 	= 	(isset($option6['sfsi_plus_icons_DisplayCounts']))
														? sanitize_text_field($option6['sfsi_plus_icons_DisplayCounts'])
														: '';
   
?>
<!-- Section 6 "Do you want to display icons at the end of every post?" main div Start -->
<div class="tab6">
	<p>
    	<?php  _e('The selections you made so far were to display the subscriptions/ social media icons for your site in general (in a widget on the sidebar). You can also display icons at the end of every post, encouraging users to subscribe/like/share after they’ve read it. The following buttons will be added:', SFSI_PLUS_DOMAIN ); ?> 
    </p>
	<!-- icons example  section -->	
	<div class="social_icon_like1">
	<ul>
		<li>
        	<a href="#" title="Facebook Like"><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/like.jpg" alt="Facebook Like" /><span>18k</span></a>
        </li>
		<li>
        	<a href="#" title="Google Plus"><img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/google_plus1.jpg" alt="Google Plus" /><span>18k</span></a>
        </li>
	</ul>	
	</div><!-- icons position section -->
	
	<p class="clear">
    	<?php _e( 'Those are usually all you need:', SFSI_PLUS_DOMAIN ); ?>
    </p>
	<ul class="usually">
		<li>
        	1. <?php _e( 'Facebook is No.1 in liking, so it’s a must have', SFSI_PLUS_DOMAIN ); ?>
        </li>
		<li>
        	2. <?php _e( 'Google+ is also important due to SEO reasons, so important to have as well', SFSI_PLUS_DOMAIN ); ?>
        </li>
		<li>
        	3. <?php _e( 'Share-button covers all other platforms for sharing', SFSI_PLUS_DOMAIN ); ?>
        </li>
	</ul>
	<!-- icons display section -->
	<h4>
    	<?php _e( 'So: do you want to display those at the end of every post?', SFSI_PLUS_DOMAIN ); ?>
    </h4>
	<ul class="enough_waffling">
		<li>
        	<input name="sfsi_plus_show_Onposts" <?php echo ($option6['sfsi_plus_show_Onposts']=='yes') ?  'checked="true"' : '' ;?> type="radio" value="yes" class="styled"  />
        	<label>
        		<?php  _e( 'Yes', SFSI_PLUS_DOMAIN ); ?>
        	</label>
       	</li>
		<li>
        	<input name="sfsi_plus_show_Onposts" <?php echo ($option6['sfsi_plus_show_Onposts']=='no') ?  'checked="true"' : '' ;?> type="radio" value="no" class="styled" />
        	<label>
        		<?php  _e( 'No', SFSI_PLUS_DOMAIN ); ?>
        	</label>
        </li>
    </ul><!-- icons display section -->
	
  	<!-- icons position section -->	
  	<div class="row sfsiplus_PostsSettings_section">
  		<h4>
    		<?php  _e( 'Options:', SFSI_PLUS_DOMAIN ); ?>
    	</h4>
		<div class="options">
            <label class="first">
            	<?php  _e( 'Text to appear before the sharing icons:', SFSI_PLUS_DOMAIN ); ?>
            </label><input name="sfsi_plus_textBefor_icons" type="text" value="<?php echo ($option6['sfsi_plus_textBefor_icons']!='') ?  $option6['sfsi_plus_textBefor_icons'] : '' ; ?>" />
		</div>
		<div class="options">
            <label>
            	<?php  _e( 'Alignment of share icons:', SFSI_PLUS_DOMAIN ); ?>
            </label>
            <div class="field"><select name="sfsi_plus_icons_alignment" id="sfsi_plus_icons_alignment" class="styled"><option value="left" <?php echo ($option6['sfsi_plus_icons_alignment']=='left') ?  'selected="selected"' : '' ;?>>
            	<?php  _e( 'Left', SFSI_PLUS_DOMAIN ); ?>
            </option><!--<option value="center" <?php //echo ($option6['sfsi_plus_icons_alignment']=='center') ?  'selected="selected"' : '' ;?>>Center</option>--><option value="right" <?php echo ($option6['sfsi_plus_icons_alignment']=='right') ?  'selected="selected"' : '' ;?>>
            	<?php  _e( 'Right', SFSI_PLUS_DOMAIN ); ?>
            </option></select></div>
	</div>
	<div class="options">
            <label>
            	<?php  _e( 'Do you want to display the counts?', SFSI_PLUS_DOMAIN ); ?>
            </label><div class="field"><select name="sfsi_plus_icons_DisplayCounts" id="sfsi_plus_icons_DisplayCounts" class="styled"><option value="yes" <?php echo ($option6['sfsi_plus_icons_DisplayCounts']=='yes') ?  'selected="true"' : '' ;?>>
            	<?php  _e( 'YES', SFSI_PLUS_DOMAIN ); ?>
            </option><option value="no" <?php echo ($option6['sfsi_plus_icons_DisplayCounts']=='no') ?  'selected="true"' : '' ;?>>
            	<?php  _e( 'NO', SFSI_PLUS_DOMAIN ); ?>
            </option></select></div>
	</div>
	
  </div><!-- END icons position section -->
  
  <?php sfsi_plus_ask_for_help(6); ?>

     <!-- SAVE BUTTON SECTION   --> 
  <div class="save_button">
       <img src="<?php echo SFSI_PLUS_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
       <?php  $nonce = wp_create_nonce("update_plus_step6"); ?>
        <a  href="javascript:;" id="sfsi_plus_save6" title="Save" data-nonce="<?php echo $nonce;?>">
        	<?php  _e( 'Save', SFSI_PLUS_DOMAIN ); ?>
        </a>
  
  </div>  <!-- END SAVE BUTTON SECTION   -->
  <a class="sfsiColbtn closeSec" href="javascript:;">
  	<?php  _e( 'Collapse area', SFSI_PLUS_DOMAIN ); ?>
  </a>
  <label class="closeSec"></label>
  <!-- ERROR AND SUCCESS MESSAGE AREA-->
  <p class="red_txt errorMsg" style="display:none"> </p>
  <p class="green_txt sucMsg" style="display:none"> </p>
  <div class="clear"></div>
</div><!-- END Section 6 "Do you want to display icons at the end of every post?" -->