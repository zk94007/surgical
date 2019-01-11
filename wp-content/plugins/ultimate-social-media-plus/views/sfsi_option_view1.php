<?php
	/* unserialize all saved option for first options */
	$option1=  unserialize(get_option('sfsi_plus_section1_options',false));
	
	/**
	 * Sanitize, escape and validate values
	 */
	$option1['sfsi_plus_rss_display'] 		=	(isset($option1['sfsi_plus_rss_display']))
													? sanitize_text_field($option1['sfsi_plus_rss_display'])
													: '';
	$option1['sfsi_plus_email_display']		=	(isset($option1['sfsi_plus_email_display']))
													? sanitize_text_field($option1['sfsi_plus_email_display'])
													: '';
	$option1['sfsi_plus_facebook_display'] 	=	(isset($option1['sfsi_plus_facebook_display']))
													? sanitize_text_field($option1['sfsi_plus_facebook_display'])
													: '';
	$option1['sfsi_plus_twitter_display'] 	=	(isset($option1['sfsi_plus_twitter_display']))
													? sanitize_text_field($option1['sfsi_plus_twitter_display'])
													: '';
	$option1['sfsi_plus_google_display'] 	=	(isset($option1['sfsi_plus_google_display']))
													? sanitize_text_field($option1['sfsi_plus_google_display'])
													: '';
	$option1['sfsi_plus_youtube_display'] 	=	(isset($option1['sfsi_plus_youtube_display']))
													? sanitize_text_field($option1['sfsi_plus_youtube_display'])
													: '';
	$option1['sfsi_plus_pinterest_display'] =	(isset($option1['sfsi_plus_pinterest_display']))
													? sanitize_text_field($option1['sfsi_plus_pinterest_display'])
													: '';
	$option1['sfsi_plus_linkedin_display'] 	=	(isset($option1['sfsi_plus_linkedin_display']))
													? sanitize_text_field($option1['sfsi_plus_linkedin_display'])
													: '';
	$option1['sfsi_plus_instagram_display'] =	(isset($option1['sfsi_plus_instagram_display']))
													? sanitize_text_field($option1['sfsi_plus_instagram_display'])
													: '';
	$option1['sfsi_plus_houzz_display'] 	=	(isset($option1['sfsi_plus_houzz_display']))
													? sanitize_text_field($option1['sfsi_plus_houzz_display'])
													: '';
    $option1['sfsi_plus_premium_icons_box'] =	(isset($option1['sfsi_plus_premium_icons_box']))
													? sanitize_text_field($option1['sfsi_plus_premium_icons_box'])
													: 'yes';

?>

<!-- Section 1 "Which icons do you want to show on your site? " main div Start -->
<div class="tab1" >
	<p class="top_txt">
    	<?php
			_e( 'In general, the more icons you offer the better because people have different preferences, and more options means that there’s something for everybody, increasing the chances that you get followed and/or shared.', SFSI_PLUS_DOMAIN);
		?>
    </p> 
 	<ul class="plus_icn_listing">
        <!-- RSS ICON -->
        <li class="gary_bg">
        	<div class="radio_section tb_4_ck">
        		<input name="sfsi_plus_rss_display" <?php echo ($option1['sfsi_plus_rss_display']=='yes') ?  'checked="true"' : '' ;?>  id="sfsi_plus_rss_display" type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_rs_s">
            	RSS
            </span> 
            <div class="sfsiplus_right_info">
                <p>
                    <span>
                        <?php  _e( 'Strongly recommended:', SFSI_PLUS_DOMAIN); ?> 
                    </span> 
                    
                    <?php  _e( 'RSS is still popular, esp. among the tech-savvy crowd.', SFSI_PLUS_DOMAIN); ?>
                    
                    <label class="expanded-area" >
                        <?php  _e( 'RSS stands for Really Simply Syndication and is an easy way for people to read your content. ', SFSI_PLUS_DOMAIN); ?> 
                    	<a href="http://en.wikipedia.org/wiki/RSS" target="_new" title="Syndication">
                            <?php  _e( 'Learn more about RSS', SFSI_PLUS_DOMAIN); ?> 
                        </a>.
                    </label>
                </p>
                <a href="javascript:;" class="expand-area" ><?php  _e( 'Read more', SFSI_PLUS_DOMAIN); ?></a>
            </div>
        </li>
        <!-- END RSS ICON -->
        
        <!-- EMAIL ICON -->
        <li class="gary_bg">
        	<div class="radio_section tb_4_ck">
        		<input name="sfsi_plus_email_display" <?php echo ($option1['sfsi_plus_email_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_email_display" type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_email">
            	Email
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
                	<span>
            			<?php  _e( 'Strongly recommended:', SFSI_PLUS_DOMAIN); ?>
            		</span> 
            		
					<?php  _e( 'Email is the most effective tool to build up a followership.', SFSI_PLUS_DOMAIN); ?>
            
            		<span style="float: right;margin-right: 13px; margin-top: -3px;">
						<?php if(get_option('sfsi_plus_footer_sec')=="yes") { $nonce = wp_create_nonce("remove_plusfooter"); ?> <a style="font-size:13px;margin-left:30px;color:#777777;" href="javascript:;" class="sfsiplus_removeFooter" data-nonce="<?php echo $nonce;?>"><?php  _e( 'Remove credit link', SFSI_PLUS_DOMAIN); ?></a>
                     	<?php } ?>
                   </span>
                	<label class="expanded-area">
                		<?php  _e( 'Everybody uses email – that’s why it’s much more effective than social media to make people follow you', SFSI_PLUS_DOMAIN); ?> 
                		(<a href="http://www.entrepreneur.com/article/230949" target="_new">
                			<?php  _e( 'learn more', SFSI_PLUS_DOMAIN); ?>
                		</a>)
                		<?php  _e( 'Not offering an email subscription option means losing out on future traffic to your site.', SFSI_PLUS_DOMAIN); ?>
                	</label>
            	</p>
             	<a href="javascript:;" class="expand-area"><?php  _e( 'Read more', SFSI_PLUS_DOMAIN); ?></a>	 
            </div>
        </li>
        <!-- EMAIL ICON -->
        
        <!-- FACEBOOK ICON -->
        <li class="gary_bg">
        	<div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_facebook_display" <?php echo ($option1['sfsi_plus_facebook_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_facebook_display" type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_facebook">
            	Facebook
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
            		<span><?php  _e( 'Strongly recommended:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php  _e( 'Facebook is crucial, esp. for sharing.', SFSI_PLUS_DOMAIN); ?>
  
                    <label class="expanded-area" >
  				    	<?php  _e( 'Facebook is the giant in the social media world, and even if you don’t have a Facebook account yourself you should display this icon, so that Facebook users can share your site on Facebook.', SFSI_PLUS_DOMAIN); ?>
            		</label>
            	</p>
            	<a href="javascript:;" class="expand-area"><?php  _e( 'Read more', SFSI_PLUS_DOMAIN); ?></a>
            </div>
        </li>
        <!-- END FACEBOOK ICON -->
        
        <!-- TWITTER ICON -->
        <li class="gary_bg">
        	<div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_twitter_display" <?php echo ($option1['sfsi_plus_twitter_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_twitter_display" type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_twt">
            	Twitter
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
                	<span><?php  _e( 'Strongly recommended:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php  _e( 'Can have a strong promotional effect.', SFSI_PLUS_DOMAIN); ?>
            		
                    <label class="expanded-area" >
            			<?php  _e( 'If you have a Twitter-account then adding this icon is a no-brainer. However, similar as with facebook, even if you don’t have one you should still show this icon so that Twitter-users can share your site.', SFSI_PLUS_DOMAIN); ?>
            		</label>
            	</p>
            	
                <a href="javascript:;" class="expand-area" ><?php  _e( 'Read more', SFSI_PLUS_DOMAIN); ?></a>
            </div>
        </li>
        <!-- END TWITTER ICON -->
       
        <!-- GOOGLE ICON -->
        <li class="gary_bg">
            <div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_google_display" <?php echo ($option1['sfsi_plus_google_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_google_display" type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_ggle_pls">
            	Google+
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
                	<span><?php  _e( 'Strongly recommended:', SFSI_PLUS_DOMAIN); ?></span>
					<?php  _e( 'Increasingly important and beneficial for SEO.', SFSI_PLUS_DOMAIN); ?>
                	<label class="expanded-area" ></label>
            	</p>
            </div>
        </li>
        <!-- END GOOGLE ICON -->
    
        <!-- YOUTUBE ICON -->
        <li>
            <div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_youtube_display" <?php echo ($option1['sfsi_plus_youtube_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_youtube_display" type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_utube">
           		Youtube
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
                	<span><?php _e( 'It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php _e( 'Show this icon if you have a youtube account (and you should set up one if you have video content – that can increase your traffic significantly).', SFSI_PLUS_DOMAIN); ?>
            	</p>
            </div>
       </li>
        <!-- END YOUTUBE ICON -->
       
        <!-- LINKEDIN ICON -->
        <li>
            <div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_linkedin_display" <?php echo ($option1['sfsi_plus_linkedin_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_linkedin_display" type="checkbox" value="yes" class="styled" />
            </div>
            <span class="sfsicls_linkdin">
            	LinkedIn
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
					<span><?php	_e( 'It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php	_e( 'No.1 network for business purposes. Use this icon if you’re a LinkedInner.', SFSI_PLUS_DOMAIN); ?>
            	</p>
            </div>
       	</li>
       	<!-- END LINKEDIN ICON -->
       
       	<!-- PINTEREST ICON -->
       	<li>
       		<div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_pinterest_display" <?php echo ($option1['sfsi_plus_pinterest_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_pinterest_display"  type="checkbox" value="yes" class="styled"  />
            </div>
        	<span class="sfsicls_pinterest">
        		Pinterest
        	</span> 
        	<div class="sfsiplus_right_info">
            	<p>
                	<span><?php  _e( 'It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php _e('Show this icon if you have a Pinterest account (and you should set up one if you publish new pictures regularly – that can increase your traffic significantly).', SFSI_PLUS_DOMAIN); ?>
            	</p>
        	</div>
       	</li>
        <!-- END PINTEREST ICON -->
       
        <!-- INSTAGRAM ICON -->
        <li>
            <div class="radio_section tb_4_ck"><input name="sfsi_plus_instagram_display" <?php echo ($option1['sfsi_plus_instagram_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_instagram_display"  type="checkbox" value="yes" class="styled"  /></div>
            <span class="sfsicls_instagram">
        	    Instagram
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
                	<span><?php  _e( 'It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php _e('Show this icon if you have a Instagram account.', SFSI_PLUS_DOMAIN); ?>
            	</p>
            </div>
        </li>
        <!-- END INSTAGRAM ICON -->
       
       <!-- Houzz ICON -->
       <li>
            <div class="radio_section tb_4_ck">
            	<input name="sfsi_plus_houzz_display" <?php echo (isset($option1['sfsi_plus_houzz_display']) && $option1['sfsi_plus_houzz_display']=='yes') ?  'checked="true"' : '' ;?> id="sfsi_plus_houzz_display"  type="checkbox" value="yes" class="styled"  />
            </div>
            <span class="sfsicls_houzz">
            	Houzz
            </span> 
            <div class="sfsiplus_right_info">
            	<p>
                	<span><?php  _e( 'It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php _e('Show this icon if you have a Houzz account.', SFSI_PLUS_DOMAIN); ?>
					 
            <?php  _e( 'Houzz is the No.1 site & community in the world of architecture and interior design.', SFSI_PLUS_DOMAIN); ?>
			<a href="http://www.houzz.com/" target="_blank">
						<?php _e('Visit Houzz',SFSI_PLUS_DOMAIN); ?>
                    </a>
            	</p>
            </div>
       	</li>
       	<!-- END Houzz ICON -->
         
       	<!-- Custom icon section start here -->
       	<?php
			$icons= ($option1['sfsi_custom_files']) ? unserialize($option1['sfsi_custom_files']) : array() ;
			$total_icons=count($icons);
			end($icons);
			$endkey=key($icons);
			$endkey = (isset($endkey)) ? $endkey :0;
			reset($icons);
			$first_key = key($icons);  
			$first_key = (isset($first_key)) ? $first_key :0;
			$new_element=0;
			
			if($total_icons>0)
			{
				$new_element=$endkey+1;
			}     
       	?>
       	<!-- Display all custom icons  -->
       	<?php $count=1; for($i=$first_key; $i<=$endkey; $i++) : ?> 
       	<?php if(!empty( $icons[$i])) : ?>
            <li id="plus_c<?php echo $i; ?>" class="plus_custom">
                <div class="radio_section tb_4_ck">
					<input name="plussfsiICON_<?php echo $i; ?>"  checked="true" type="checkbox" value="yes" class="styled" element-type="sfsiplus-cusotm-icon"  />
                </div>
                <span class="plus_custom-img">
					<img class="plus_sfcm" src="<?php echo (!empty($icons[$i]))? esc_url($icons[$i]) : SFSI_PLUS_PLUGURL.'images/custom.png';?>" id="plus_CImg_<?php echo $i;?>"/>
                </span> 
                <span class="custom sfsiplus_custom-txt">
                    <?php  _e( 'Custom', SFSI_PLUS_DOMAIN); ?>  
                    <?php echo $count;?> 
                </span> 
                <div class="sfsiplus_right_info">
                    <p>
					<span><?php  _e('It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php  _e('Upload a custom icon if you have other accounts/websites you want to link to.', SFSI_PLUS_DOMAIN); ?>
                   </p>
                </div>
            </li>
        <?php $count++; endif; endfor; ?>
        
        <!-- Create a custom icon if total uploaded icons are less than 5 -->
        <?php if($count <=5) : ?>
        <li id="plus_c<?php echo $new_element; ?>" class="plus_custom bdr_btm_non">
            <div class="radio_section tb_4_ck">
                <input name="plussfsiICON_<?php echo $new_element;?>"  type="checkbox" value="yes" class="styled" element-type="sfsiplus-cusotm-icon" ele-type='new'/>
            </div>
            
            <span class="plus_custom-img">
                <img src="<?php echo SFSI_PLUS_PLUGURL.'images/custom.png';?>" id="plus_CImg_<?php echo $new_element; ?>"  />
            </span> 
            
            <span class="custom sfsiplus_custom-txt">
            	<?php  _e( 'Custom', SFSI_PLUS_DOMAIN); ?>
				<?php echo $count; ?>
            </span> 
            
            <div class="sfsiplus_right_info">
                <p>
                	<span><?php	_e('It depends:', SFSI_PLUS_DOMAIN); ?></span> 
					<?php	_e('Upload a custom icon if you have other accounts/websites you want to link to.', SFSI_PLUS_DOMAIN); ?>
                </p>
            </div>
        </li>
        <?php endif; ?>
        <!-- END Custom icon section here -->
    </ul>
    <ul>
        <li class="sfsi_plus_premium_brdr_box">
            <div class="sfsi_plus_prem_icons_added">
                <div class="sf_si_plus_prmium_head"><h2><?php  _e( 'New: ', SFSI_PLUS_DOMAIN); ?><span> <?php  _e( 'In our Premium Plugin we added icons for:', SFSI_PLUS_DOMAIN); ?></span></h2></div>
                <div class="sfsi_plus_premium_row">
                    <div class = "sfsi_plus_prem_cmn_rowlisting">
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/snapchat.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Snapchat', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting">
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/whatsapp.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'WhatsApp or Phone', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                        
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/yummly.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Yummly', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/yelp.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Yelp', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                     <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/print.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Print', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                </div>
                <div class="sfsi_plus_premium_row">
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/soundcloud.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Soundcloud', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/skype.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Skype', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/flickr.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Flickr', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/vk.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'VK', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/angieslist.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Angie’s List', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                </div>
                <div class="sfsi_plus_premium_row">
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/reddit.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Reddit', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/vimeo.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Vimeo', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/tumblr.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Tumblr', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/buffer.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Buffer', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/blogger.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Blogger', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                </div>
                <div class="sfsi_plus_premium_row">
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/telegram.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Telegram', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/steam.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Steam', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/xing.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Xing', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/amazon.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Amazon', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                    <div class = "sfsi_plus_prem_cmn_rowlisting" >  
                        <span>
                            <img src="<?php  echo SFSI_PLUS_PLUGURL.'images/twitch.png';?>" id="CImg" />
                        </span>
                        <span class="sfsicls_plus_prem_text"><?php  _e( 'Twitch', SFSI_PLUS_DOMAIN); ?></span>
                    </div>
                </div>
                <div class="sfsi_plus_need_another_one_link">
<!--                     <p><?php  _e('Need another one?', SFSI_PLUS_DOMAIN); ?><a href="mailto:biz@ultimatelysocial.com" target="_blank"> <?php  _e( 'Tell us', SFSI_PLUS_DOMAIN); ?></a></p> -->
                </div>
                <div class="sfsi_plus_need_another_tell_us">
                    <a href="https://www.ultimatelysocial.com/all-platforms/" target="_blank"><?php  _e( '...and many more! See them here', SFSI_PLUS_DOMAIN); ?></a>               
<!--                     <a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_platforms&utm_medium=banner" target="_blank"><?php  _e( 'See all features Premium Plugin', SFSI_PLUS_DOMAIN); ?></a>
 -->                </div>
            </div>
        </li>
    </ul>
    <input type="hidden" value="<?php echo SFSI_PLUS_PLUGURL ?>" id="plugin_url" />
 	<input type="hidden" value=""  id="upload_id" />
  	
    <?php sfsi_plus_ask_for_help(1); ?>

    <!-- SAVE BUTTON SECTION   -->
 	<div class="save_button tab_1_sav">
   		<img src="<?php echo SFSI_PLUS_PLUGURL ?>images/ajax-loader.gif" class="loader-img" />
   		<?php  $nonce = wp_create_nonce("update_plus_step1"); ?>
   		<a href="javascript:;" id="sfsi_plus_save1" title="Save" data-nonce="<?php echo $nonce;?>">
    		<?php  _e( 'Save', SFSI_PLUS_DOMAIN); ?>
        </a>
 	</div>
    <!-- END SAVE BUTTON SECTION   -->
 	
    <a class="sfsiColbtn closeSec" href="javascript:;" >
    	<?php _e( 'Collapse area', SFSI_PLUS_DOMAIN); ?>
    </a>
 	
    <!-- ERROR AND SUCCESS MESSAGE AREA-->
 	<p class="red_txt errorMsg" style="display:none"> </p>
 	<p class="green_txt sucMsg" style="display:none"> </p>
    
</div>
<!-- END Section 1 "Which icons do you want to show on your site? " main div-->
