<?php
	/* unserialize all saved option for second section options */
	$option4=  unserialize(get_option('sfsi_plus_section4_options',false));
	$option2=  unserialize(get_option('sfsi_plus_section2_options',false));
	
	/*
	 * Sanitize, escape and validate values
	 */
	$option2['sfsi_plus_rss_url'] 				=	(isset($option2['sfsi_plus_rss_url']))
														? esc_url($option2['sfsi_plus_rss_url'])
														: '';
	$option2['sfsi_plus_rss_icons'] 			=	(isset($option2['sfsi_plus_rss_icons']))
														? sanitize_text_field($option2['sfsi_plus_rss_icons'])
														: '';
	$option2['sfsi_plus_email_url']				=	(isset($option2['sfsi_plus_email_url']))
														? sanitize_text_field(	$option2['sfsi_plus_email_url'])
														: '';

	$option2['sfsi_plus_facebookPage_option']	=	(isset($option2['sfsi_plus_facebookPage_option']))
														? sanitize_text_field($option2['sfsi_plus_facebookPage_option'])
														: '';
	$option2['sfsi_plus_facebookPage_url'] 		=	(isset($option2['sfsi_plus_facebookPage_url']))
														? esc_url($option2['sfsi_plus_facebookPage_url'])
														: '';
	$option2['sfsi_plus_facebookLike_option']	=	(isset($option2['sfsi_plus_facebookLike_option']))
														? sanitize_text_field($option2['sfsi_plus_facebookLike_option'])
														: ' ';
	$option2['sfsi_plus_facebookShare_option'] 	=	(isset($option2['sfsi_plus_facebookShare_option']))
														? sanitize_text_field($option2['sfsi_plus_facebookShare_option'])
														: '';
	
	$option2['sfsi_plus_twitter_followme'] 		=	(isset($option2['sfsi_plus_twitter_followme']))
														? sanitize_text_field($option2['sfsi_plus_twitter_followme'])
														: '';
	$option2['sfsi_plus_twitter_followUserName']=	(isset($option2['sfsi_plus_twitter_followUserName']))
														? sanitize_text_field($option2['sfsi_plus_twitter_followUserName'])
														: '';
	$option2['sfsi_plus_twitter_aboutPage'] 	=	(isset($option2['sfsi_plus_twitter_aboutPage']))
														? sanitize_text_field($option2['sfsi_plus_twitter_aboutPage'])
														: '';
	$option2['sfsi_plus_twitter_page'] 			=	(isset($option2['sfsi_plus_twitter_page']))
														? sanitize_text_field($option2['sfsi_plus_twitter_page'])
														: '';
	$option2['sfsi_plus_twitter_pageURL'] 		=	(isset($option2['sfsi_plus_twitter_pageURL']))
														? esc_url($option2['sfsi_plus_twitter_pageURL'])
														: '';
	$option2['sfsi_plus_twitter_aboutPageText'] =	(isset($option2['sfsi_plus_twitter_aboutPageText']))
														? sanitize_text_field($option2['sfsi_plus_twitter_aboutPageText'])
														: '';
	
	$option2['sfsi_plus_google_page'] 			=	(isset($option2['sfsi_plus_google_page']))
														? sanitize_text_field($option2['sfsi_plus_google_page'])
														: '';
	$option2['sfsi_plus_google_pageURL'] 		=	(isset($option2['sfsi_plus_google_pageURL']))
														? esc_url($option2['sfsi_plus_google_pageURL'])
														: '';
	// $option2['sfsi_plus_googleLike_option'] 	=	(isset($option2['sfsi_plus_googleLike_option']))
	// 													? sanitize_text_field($option2['sfsi_plus_googleLike_option'])
	// 													: '';
	$option2['sfsi_plus_googleShare_option'] 	=	(isset($option2['sfsi_plus_googleShare_option']))
														? sanitize_text_field($option2['sfsi_plus_googleShare_option'])
														: '';
	
	$option2['sfsi_plus_youtube_pageUrl'] 		=	(isset($option2['sfsi_plus_youtube_pageUrl']))
														? esc_url($option2['sfsi_plus_youtube_pageUrl'])
														: '';
	$option2['sfsi_plus_youtube_page'] 			=	(isset($option2['sfsi_plus_youtube_page']))
														? sanitize_text_field($option2['sfsi_plus_youtube_page'])
														: '';
	$option2['sfsi_plus_youtube_follow'] 		=	(isset($option2['sfsi_plus_youtube_follow']))
														? sanitize_text_field($option2['sfsi_plus_youtube_follow'])
														: '';
	$option2['sfsi_plus_ytube_user'] 			=	(isset($option2['sfsi_plus_ytube_user']))
														? sanitize_text_field($option2['sfsi_plus_ytube_user'])
														: '';
	
	$option2['sfsi_plus_pinterest_page'] 		=	(isset($option2['sfsi_plus_pinterest_page']))
														? sanitize_text_field($option2['sfsi_plus_pinterest_page'])
														: '';
	$option2['sfsi_plus_pinterest_pageUrl']		=	(isset($option2['sfsi_plus_pinterest_pageUrl']))
														? esc_url($option2['sfsi_plus_pinterest_pageUrl'])
														: '';
	$option2['sfsi_plus_pinterest_pingBlog'] 	=	(isset($option2['sfsi_plus_pinterest_pingBlog']))
														? sanitize_text_field($option2['sfsi_plus_pinterest_pingBlog'])
														: '';
	
	$option2['sfsi_plus_instagram_pageUrl']		=	(isset($option2['sfsi_plus_instagram_pageUrl']))
														? esc_url($option2['sfsi_plus_instagram_pageUrl'])
														: '';
	
	$option2['sfsi_plus_linkedin_page'] 		=	(isset($option2['sfsi_plus_linkedin_page']))
														? sanitize_text_field($option2['sfsi_plus_linkedin_page'])
														: '';
	$option2['sfsi_plus_linkedin_pageURL'] 		=	(isset($option2['sfsi_plus_linkedin_pageURL']))
														? esc_url($option2['sfsi_plus_linkedin_pageURL'])
														: '';
	$option2['sfsi_plus_linkedin_follow'] 		= 	(isset($option2['sfsi_plus_linkedin_follow']))
														? sanitize_text_field($option2['sfsi_plus_linkedin_follow'])
														: '';
	$option2['sfsi_plus_linkedin_followCompany']=	(isset($option2['sfsi_plus_linkedin_followCompany']))
														? intval($option2['sfsi_plus_linkedin_followCompany'])
														: '';
	$option2['sfsi_plus_linkedin_SharePage'] 	= 	(isset($option2['sfsi_plus_linkedin_SharePage']))
														? sanitize_text_field($option2['sfsi_plus_linkedin_SharePage'])
														: '';
	$option2['sfsi_plus_linkedin_recommendBusines']		= 	(isset($option2['sfsi_plus_linkedin_recommendBusines']))
																? sanitize_text_field($option2['sfsi_plus_linkedin_recommendBusines'])
																: '';
	$option2['sfsi_plus_linkedin_recommendCompany'] 	= 	(isset($option2['sfsi_plus_linkedin_recommendCompany']))
																? sanitize_text_field($option2['sfsi_plus_linkedin_recommendCompany'])
																: '';
	$option2['sfsi_plus_linkedin_recommendProductId'] 	= 	(isset($option2['sfsi_plus_linkedin_recommendProductId']))
																? intval($option2['sfsi_plus_linkedin_recommendProductId'])
																: '';
	
	$option2['sfsi_plus_houzz_pageUrl'] 		= 	(isset($option2['sfsi_plus_houzz_pageUrl']))
														? esc_url($option2['sfsi_plus_houzz_pageUrl'])
														: '';
	$option4['sfsi_plus_youtubeusernameorid'] 	= 	(isset($option4['sfsi_plus_youtubeusernameorid'])) 
														? sanitize_text_field($option4['sfsi_plus_youtubeusernameorid'])
														: '';
	$option4['sfsi_plus_ytube_chnlid'] 			= 	(isset($option4['sfsi_plus_ytube_chnlid']))
														? strip_tags(trim($option4['sfsi_plus_ytube_chnlid']))
														: '';
	$option2['sfsi_plus_premium_email_box'] 	= 	(isset($option2['sfsi_plus_premium_email_box'])) 
														? sanitize_text_field($option2['sfsi_plus_premium_email_box'])
														: 'yes';
	$option2['sfsi_plus_premium_facebook_box'] 	= 	(isset($option2['sfsi_plus_premium_facebook_box'])) 
														? sanitize_text_field($option2['sfsi_plus_premium_facebook_box'])
														: 'yes';
	$option2['sfsi_plus_premium_twitter_box'] 	= 	(isset($option2['sfsi_plus_premium_twitter_box'])) 
														? sanitize_text_field($option2['sfsi_plus_premium_twitter_box'])
														: 'yes';
																																								
	$option2['sfsi_plus_premium_google_box'] 	= 	(isset($option2['sfsi_plus_premium_google_box'])) 
														? sanitize_text_field($option2['sfsi_plus_premium_google_box'])
														: 'yes';
		
?>
<!-- Section 2 "What do you want the icons to do?" main div Start -->
<div class="tab2">
    <!-- RSS ICON -->
    <div class="row bdr_top sfsiplus_rss_section">
    	<h2 class="sfsicls_rs_s">
        	RSS
        </h2>
        <div class="inr_cont">
            <p>
            	<?php  _e( 'When clicked on, users can subscribe via RSS', SFSI_PLUS_DOMAIN); ?>
            </p>
            <div class="rss_url_row">
                <h4>
               		RSS URL
                </h4>
                <input name="sfsi_plus_rss_url"  id="sfsi_plus_rss_url" class="add" type="url" value="<?php echo ($option2['sfsi_plus_rss_url']!='') ?  $option2['sfsi_plus_rss_url'] : '' ;?>" placeholder="E.g http://www.yoursite.com/feed" />
                <span class="sfrsTxt" >
                	<?php  _e( 'For most blogs it’s http://blogname.com/feed', SFSI_PLUS_DOMAIN); ?>  
                </span>
            </div>
        </div>    
    </div>
    <!-- END RSS ICON -->
    
    <!-- EMAIL ICON -->
    <?php
		$feedId 		= sanitize_text_field(get_option('sfsi_plus_feed_id',false));
		$connectToFeed 	= "https://www.specificfeeds.com/?".base64_encode("userprofile=wordpress&feed_id=".$feedId);
		
	?>
    <div class="row sfsiplus_email_section">
        <h2 class="sfsicls_email">
        	Email
        </h2>
        
        <?php sfsi_plus_curl_error_notification(); ?>
        
        <div class="inr_cont">
			<p class="sfsi_plus_specificfeedlink">
				<?php _e('Allows your visitors to subscribe to your site (on ', SFSI_PLUS_DOMAIN ); ?><a href="https://www.specificfeeds.com/widgets/emailSubscribeEncFeed/<?php echo $feedId; ?>/<?php echo base64_encode(8); ?>" target="_new"><?php  _e( 'this screen', SFSI_PLUS_DOMAIN); ?></a><?php  _e(") and receive new posts automatically by email.", SFSI_PLUS_DOMAIN); ?>
			</p>
           	<p><?php _e( 'Please pick which icon type you want to use:', SFSI_PLUS_DOMAIN); ?></p>
            <ul class="tab_2_email_sec">
                <li>
					<div class="sfsiplusicnsdvwrp">
						<input name="sfsi_plus_rss_icons" <?php echo ($option2['sfsi_plus_rss_icons']=='email') ?  'checked="true"' : '' ;?> type="radio" value="email" class="styled" /><span class="email_icn"></span>
					</div>
					<label>
                    	<?php  _e( 'Email icon', SFSI_PLUS_DOMAIN); ?>
                    </label>
                </li>
				<li>
					<div class="sfsiplusicnsdvwrp">
						<input name="sfsi_plus_rss_icons" <?php echo ($option2['sfsi_plus_rss_icons']=='subscribe') ?  'checked="true"' : '' ;?> type="radio" value="subscribe" class="styled" /><span class="subscribe_icn"></span>
					</div>
					<label>
                    	<?php  _e( 'Follow icon', SFSI_PLUS_DOMAIN); ?>
                    	<span class="sfplsdesc"> 
                    		(<?php  _e( 'increases sign-ups', SFSI_PLUS_DOMAIN); ?>)
                    	</span>
                    </label>
                </li>
				<li>
					<div class="sfsiplusicnsdvwrp">
						<input name="sfsi_plus_rss_icons" <?php echo ($option2['sfsi_plus_rss_icons']=='sfsi') ?  'checked="true"' : '' ;?> type="radio" value="sfsi" class="styled"  /><span class="sf_arow"></span>
					</div>
					<label>
                    	<?php _e( 'SpecificFeeds icon', SFSI_PLUS_DOMAIN); ?>
                    	<span class="sfplsdesc"> 
                    		(<?php _e( 'provider of the service', SFSI_PLUS_DOMAIN); ?>)
                    	</span>
                    </label>
                </li>
            </ul>
            <p><?php _e( 'The service offers many (more) advantages:', SFSI_PLUS_DOMAIN); ?></p>  
            <div class='sfsi_plus_service_row'>
            	<div class='sfsi_plus_service_column'>
            		<ul>
            			<li><span><?php _e( 'More people come back', SFSI_PLUS_DOMAIN); ?></span><?php _e( ' to your site', SFSI_PLUS_DOMAIN); ?></li>
            			<li><?php _e( 'See your ', SFSI_PLUS_DOMAIN); ?><span><?php _e( 'subscribers’ emails', SFSI_PLUS_DOMAIN); ?></span><?php _e( ' & ', SFSI_PLUS_DOMAIN); ?><span><?php _e( 'interesting statistics', SFSI_PLUS_DOMAIN); ?></span></li>
            			<li><?php _e( 'Automatically post on ', SFSI_PLUS_DOMAIN); ?><span><?php _e( 'Facebook & Twitter', SFSI_PLUS_DOMAIN); ?></span></li>
	            	</ul>
            	</div>
                <div class='sfsi_plus_service_column'>
                	<ul>
		                <li><span><?php _e( 'Get more traffic', SFSI_PLUS_DOMAIN); ?></span><?php _e( ' by being listed in the SF directory', SFSI_PLUS_DOMAIN); ?></li>
		                <li><span><?php _e( 'Get alerts', SFSI_PLUS_DOMAIN); ?></span><?php _e( ' when people subscribe or unsubscribe', SFSI_PLUS_DOMAIN); ?></li>
		                <li><span><?php _e( 'Tailor the sender name & subject line', SFSI_PLUS_DOMAIN); ?></span><?php _e( ' of the emails', SFSI_PLUS_DOMAIN); ?></li>
	                </ul> 
	            </div>   
               
            </div>

            <form id="calimingOptimizationForm" method="get" action="https://www.specificfeeds.com/wpclaimfeeds/getFullAccess" target="_blank">
	            <div class="sfsi_plus_inputbtn">
	            	<input type="hidden" name="feed_id" value="<?php echo sanitize_text_field(get_option('sfsi_plus_feed_id',false)); ?>" />
	            	<input type="email" name="email" value="<?php echo bloginfo('admin_email'); ?>"  />
	            </div>
	           	<div class='sfsi_plus_more_services_link'>
	                <a class="pop-up" href="javascript:" id="getMeFullAccess" title="Give me access">
						<?php  _e('Click here to benefit from all advantages >', SFSI_PLUS_DOMAIN ); ?>
					</a> 
	            </div>
      		</form>

            <p class='sfsi_plus_email_last_paragraph'>
            	<?php _e( 'This will create your FREE account on SpecificFeeds, using above email. ', SFSI_PLUS_DOMAIN); ?><br>
            	<?php _e( 'All data will be treated highly confidentially, see the', SFSI_PLUS_DOMAIN); ?>
				<a href="https://www.specificfeeds.com/page/privacy-policy" target="_new">
					<?php  _e('Privacy Policy.', SFSI_PLUS_DOMAIN ); ?>
				</a>
			</p>
           <?php if($option2['sfsi_plus_premium_email_box'] =='yes') { ?>
            <div class ="sfsi_plus_new_prmium_follw">
				<p>	
					<b><?php _e( 'New:', SFSI_PLUS_DOMAIN); ?></b><?php _e( ' In our Premium Plugin you can now give your email icon other functions too, e.g. contact you (email), share by email, and link to a certain page (e.g. your contact form or newsletter sign-up site). ', SFSI_PLUS_DOMAIN); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=more_functions_email_icon&utm_medium=banner" target="_blank"><?php _e( 'See all features.', SFSI_PLUS_DOMAIN); ?></a>
				</p>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- END EMAIL ICON -->
    
    <!-- FACEBOOK ICON -->
    <div class="row sfsiplus_facebook_section">
    	<h2 class="sfsicls_facebook">
        	Facebook
        </h2>
        <div class="inr_cont">
            <p>
            	<?php _e( 'The facebook icon can perform several actions. Pick below which ones it should perform. If you select several options, then users can select what they want to do', SFSI_PLUS_DOMAIN); ?>
            	<a class="rit_link pop-up" href="javascript:;"  data-id="fbex-s2">
	                (<?php  _e( 'see an example', SFSI_PLUS_DOMAIN); ?>).
            	</a>
            </p>
            <p>
            	<?php  _e( 'The facebook icon should allow users to...', SFSI_PLUS_DOMAIN); ?>
            </p> 
            
            <p class="radio_section fb_url">
			<input name="sfsi_plus_facebookPage_option" <?php echo ($option2['sfsi_plus_facebookPage_option']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
            
            <label>
            	<?php  _e( 'Visit my Facebook page at:', SFSI_PLUS_DOMAIN); ?>
            </label>
            
            <input class="add" name="sfsi_plus_facebookPage_url" type="url" value="<?php echo ($option2['sfsi_plus_facebookPage_url']!='') ?  $option2['sfsi_plus_facebookPage_url'] : '' ;?>" placeholder="E.g https://www.facebook.com/your_page_name" /></p>
            
            <p class="radio_section fb_url extra_sp">
            	<input name="sfsi_plus_facebookLike_option" <?php echo ($option2['sfsi_plus_facebookLike_option']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
            	<label>
            		<?php  _e( 'Like my blog on Facebook (+1)', SFSI_PLUS_DOMAIN); ?>
            	</label>
            </p>
            
            <p class="radio_section fb_url extra_sp">
            	<input name="sfsi_plus_facebookShare_option" <?php echo ($option2['sfsi_plus_facebookShare_option']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
                
                <label>
            		<?php  _e( 'Share my blog with friends (on Facebook)', SFSI_PLUS_DOMAIN); ?> 
            	</label>
            </p>
            <?php if($option2['sfsi_plus_premium_facebook_box'] =='yes') { ?>
            <div class="sfsi_plus_new_prmium_follw">
				<p>
					<b><?php  _e( 'New:', SFSI_PLUS_DOMAIN); ?></b>	<?php  _e( ' In our Premium Plugin you can also allow users to follow you on Facebook directly from your site (without leaving your page, increasing followers). ', SFSI_PLUS_DOMAIN); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=direct_follow_facebook&utm_medium=banner" target="_blank"> 	<?php  _e( 'See all features.', SFSI_PLUS_DOMAIN); ?> </a>					
				</p>
            </div>
            <?php } ?>
            
        </div>
    </div>
    <!-- END FACEBOOK ICON -->
    
    <!-- TWITTER ICON -->
    <div class="row sfsiplus_twitter_section">
    	<h2 class="sfsicls_twt">
        	Twitter
        </h2>
        <div class="inr_cont twt_tab_2">
             <p>
              <?php
              	_e( 'The Twitter icon can perform several actions. Pick below which ones it should perform. If you select several options, then users can select what they want to do', SFSI_PLUS_DOMAIN);
				?>
             	<a class="rit_link pop-up" href="javascript:;"  data-id="twex-s2">
             		(<?php  _e( 'see an example', SFSI_PLUS_DOMAIN); ?>).
             	</a>
             </p> 
             <p>
             	<?php  _e( 'The Twitter icon should allow users to...', SFSI_PLUS_DOMAIN); ?>
             </p> 
         	 <p class="radio_section fb_url">
             	<input name="sfsi_plus_twitter_page" <?php echo ($option2['sfsi_plus_twitter_page']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	<label>
            		<?php  _e( 'Visit me on Twitter:', SFSI_PLUS_DOMAIN); ?> 
            	</label>
                <input name="sfsi_plus_twitter_pageURL" type="url" placeholder="http://" value="<?php echo ($option2['sfsi_plus_twitter_pageURL']!='') ?  $option2['sfsi_plus_twitter_pageURL'] : '' ;?>" class="add" />
             </p>
             
             <div class="radio_section fb_url twt_fld">
             	<input name="sfsi_plus_twitter_followme"  <?php echo ($option2['sfsi_plus_twitter_followme']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
             	
                <label>
              		<?php  _e( 'Follow me on Twitter:', SFSI_PLUS_DOMAIN); ?> 
             	</label>
                
                <input name="sfsi_plus_twitter_followUserName" type="text" value="<?php echo ($option2['sfsi_plus_twitter_followUserName']!='') ?  $option2['sfsi_plus_twitter_followUserName'] : '' ;?>" placeholder="my_twitter_name" class="add" />
             </div>
             <div class="radio_section fb_url twt_fld_2">
             	<input name="sfsi_plus_twitter_aboutPage" <?php echo ($option2['sfsi_plus_twitter_aboutPage']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
             	<label>
             		<?php  _e( 'Tweet about my page:', SFSI_PLUS_DOMAIN ); ?>
             	</label>
                <textarea name="sfsi_plus_twitter_aboutPageText" id="sfsi_plus_twitter_aboutPageText" type="text" class="add_txt" placeholder="<?php _e( 'Hey check out this cool site I found', SFSI_PLUS_DOMAIN ) ;?>: www.yourname.com #Topic via@my_twitter_name" /><?php echo ($option2['sfsi_plus_twitter_aboutPageText']!='') ?  stripslashes($option2['sfsi_plus_twitter_aboutPageText']) : _e( 'Hey check out this cool site I found', SFSI_PLUS_DOMAIN ) ;?></textarea>
             </div>
            <?php if($option2['sfsi_plus_premium_twitter_box'] =='yes') { ?>
            <div class= "sfsi_plus_new_prmium_follw">
				<p>
					<b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e(  "Tweeting becomes really fun in the Premium Plugin – you can insert tags to automatically pull the title of the story & link to the story, attach pictures & snippets to the Tweets ( 'Twitter cards') and user Url-shorteners, all leading to more Tweets and traffic for your site!. ", SFSI_PLUS_DOMAIN ); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=better_tweets&utm_medium=banner" target="_blank"><?php  _e( 'See all features', SFSI_PLUS_DOMAIN ); ?></a>
			    </p>
			</div>
            <?php } ?>
        </div>
    </div>
    <!-- END TWITTER ICON -->
    
    <!-- GOOGLE ICON -->
    <div class="row sfsiplus_google_section">
    	<h2 class="sfsicls_ggle_pls">Google+</h2>
        <div class="inr_cont google_in">
            <p>
            	<?php  _e( 'The Google+ icon can perform several actions. Pick below which ones it should perform. If you select several options, then users can select what they want to do', SFSI_PLUS_DOMAIN ); ?>
            	<a class="rit_link pop-up" href="javascript:;"  data-id="googlex-s2">
                	(<?php  _e( 'see an example', SFSI_PLUS_DOMAIN ); ?>).
                </a>
			</p>
            <p>
            	<?php  _e( 'The Google+ icon should allow users to...', SFSI_PLUS_DOMAIN ); ?>
            </p> 
            <p class="radio_section fb_url">
            	<input name="sfsi_plus_google_page" <?php echo ($option2['sfsi_plus_google_page']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	
                <label>
            		<?php  _e( 'Visit my Google+ page at:', SFSI_PLUS_DOMAIN ); ?>
            	</label>
            	
                <input name="sfsi_plus_google_pageURL" type="url" placeholder="http://" value="<?php echo ($option2['sfsi_plus_google_pageURL']!='') ?  $option2['sfsi_plus_google_pageURL'] : '' ;?>" class="add" />
            
            </p>

            <!--<p class="radio_section fb_url">
            	<input name="sfsi_plus_googleLike_option" <?php //echo ($option2['sfsi_plus_googleLike_option']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	<label>
            		<?php  //_e( 'Like my blog on Google+ (+1)', SFSI_PLUS_DOMAIN ); ?>
            	</label>
            </p>--> 

            <p class="radio_section fb_url">
            	<input name="sfsi_plus_googleShare_option" <?php echo ($option2['sfsi_plus_googleShare_option']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	
                <label>
            		<?php  _e( 'Share my blog with friends (on Google+)', SFSI_PLUS_DOMAIN ); ?>
            	</label>
            </p>
            <?php if($option2['sfsi_plus_premium_google_box'] =='yes') { ?>
            <div class ="sfsi_plus_new_prmium_follw" >
				<p>
				   <b><?php  _e( 'New: ', SFSI_PLUS_DOMAIN ); ?></b><?php  _e( 'In our Premium Plugin you can also allow users to follow you on Google+ directly from your site (without leaving your page, increasing followers). ', SFSI_PLUS_DOMAIN ); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=direct_follow_google&utm_medium=banner" target="_blank"><?php  _e( 'See all features', SFSI_PLUS_DOMAIN ); ?></a>
				</p>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- END GOOGLE ICON -->
    
    <!-- YOUTUBE ICON -->
    <div class="row sfsiplus_youtube_section">
    	<h2 class="sfsicls_utube">
        	Youtube
        </h2>
        <div class="inr_cont utube_inn">
            <p>
            	<?php  _e( 'The Youtube icon can perform several actions. Pick below which ones it should perform. If you select several options, then users can select what they want to do', SFSI_PLUS_DOMAIN ); ?>
            	<a class="rit_link pop-up" href="javascript:;"  data-id="ytex-s2">
            		(<?php  _e( 'see an example', SFSI_PLUS_DOMAIN ); ?>).
            	</a>
            </p> 
            <p>
            	<?php  _e( 'The youtube icon should allow users to...', SFSI_PLUS_DOMAIN ); ?>
            </p> 
            <p class="radio_section fb_url"><input name="sfsi_plus_youtube_page" <?php echo ($option2['sfsi_plus_youtube_page']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	<label>
            		<?php  _e( 'Visit my Youtube page at:', SFSI_PLUS_DOMAIN ); ?>
            	</label>
                <input name="sfsi_plus_youtube_pageUrl" type="url" placeholder="http://" value="<?php echo ($option2['sfsi_plus_youtube_pageUrl']!='') ?  $option2['sfsi_plus_youtube_pageUrl'] : '' ;?>" class="add" />
            </p>
            <p class="radio_section fb_url"><input name="sfsi_plus_youtube_follow" <?php echo ($option2['sfsi_plus_youtube_follow']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	<label>
            		<?php  _e( 'Subscribe to me on Youtube', SFSI_PLUS_DOMAIN ); ?>
            		<span>
            			<?php  _e( '(allows people to subscribe to you directly, without leaving your blog)', SFSI_PLUS_DOMAIN ); ?>
            		</span>
                </label>
            </p>
        	<!--Adding Code for Channel Id and Channel Name-->
        	<?php
				if(!isset($option2['sfsi_plus_youtubeusernameorid']))
				{
					$sfsi_plus_youtubeusernameorid = '';
				}
				else
				{
					$sfsi_plus_youtubeusernameorid = $option2['sfsi_plus_youtubeusernameorid'];
				}
			?>
       	 
         <div class="cstmutbewpr">
            <ul class="enough_waffling">
               <li onclick="showhideutube(this);"><input name="sfsi_plus_youtubeusernameorid" <?php echo ($sfsi_plus_youtubeusernameorid=='name') ?  'checked="true"' : '' ;?> type="radio" value="name" class="styled"  />
               <label>
               		<?php  _e( 'User Name', SFSI_PLUS_DOMAIN ); ?>
               </label>
               </li>
               <li onclick="showhideutube(this);"><input name="sfsi_plus_youtubeusernameorid" <?php echo ($sfsi_plus_youtubeusernameorid=='id') ?  'checked="true"' : '' ;?> type="radio" value="id" class="styled"  />
               <label>
               		<?php  _e( 'Channel Id', SFSI_PLUS_DOMAIN ); ?>
               </label></li>
            </ul>
            <div class="cstmutbtxtwpr">
            	<div class="cstmutbchnlnmewpr" <?php if($sfsi_plus_youtubeusernameorid != 'id'){echo 'style="display: block;"';}?>>
                	<p class="extra_pp">
                    	<label><?php  _e( 'UserName:', SFSI_PLUS_DOMAIN ); ?></label>
                        <input name="sfsi_plus_ytube_user" type="url" value="<?php echo (isset($option2['sfsi_plus_ytube_user']) && $option2['sfsi_plus_ytube_user']!='') ?  $option2['sfsi_plus_ytube_user'] : '' ;?>" placeholder="Youtube username" class="add" />
                    </p>
                    <div class="utbe_instruction">
                    	<?php _e( 'To find your User ID/Channel ID, login to your YouTube account, click the user icon at the top right corner and select "Settings", then click "Advanced" under "Name" and you will find both your "Channel ID" and "User ID" under "Account Information".', SFSI_PLUS_DOMAIN ); ?>
                    </div>
                </div>
                <div class="cstmutbchnlidwpr" <?php if($sfsi_plus_youtubeusernameorid == 'id'){echo 'style="display: block"';}?>>
                	<p class="extra_pp">
                    	<label>
                       		<?php  _e( 'Channel Id:', SFSI_PLUS_DOMAIN ); ?>
                        </label>
                        <input name="sfsi_plus_ytube_chnlid" type="url" value="<?php echo (isset($option2['sfsi_plus_ytube_chnlid']) && $option2['sfsi_plus_ytube_chnlid']!='') ?  $option2['sfsi_plus_ytube_chnlid'] : '' ;?>" placeholder="youtube_channel_id" class="add" />
                    </p>
                    <div class="utbe_instruction">
                    	<?php  _e( 'To find your User ID/Channel ID, login to your YouTube account, click the user icon at the top right corner and select "Settings", then click "Advanced" under "Name" and you will find both your "Channel ID" and "User ID" under "Account Information".', SFSI_PLUS_DOMAIN ); ?>
                    </div>
                </div>
            </div>
        </div>
        
        </div>
    </div>
    <!-- END YOUTUBE ICON -->
    
    <!-- PINTEREST ICON -->
    <div class="row sfsiplus_pinterest_section">
    	<h2 class="sfsicls_pinterest">Pinterest</h2>
        <div class="inr_cont">
            <p>
            	<?php  _e( 'The Pinterest icon can perform several actions. Pick below which ones it should perform. If you select several options, then users can select what they want to do', SFSI_PLUS_DOMAIN ); ?>
				<a class="rit_link pop-up" href="javascript:;"  data-id="pinex-s2">
            		(<?php  _e( 'see an example', SFSI_PLUS_DOMAIN ); ?>).
            	</a>
            </p> 
            <p>
            	<?php  _e( 'The Pinterest icon should allow users to...', SFSI_PLUS_DOMAIN ); ?>
            </p> 
            <p class="radio_section fb_url">
            	<input name="sfsi_plus_pinterest_page" <?php echo ($option2['sfsi_plus_pinterest_page']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
                <label>
            		<?php  _e( 'Visit my Pinterest page at:', SFSI_PLUS_DOMAIN ); ?>
            	</label>
                <input name="sfsi_plus_pinterest_pageUrl" type="url" placeholder="http://"  value="<?php echo ($option2['sfsi_plus_pinterest_pageUrl']!='') ?  $option2['sfsi_plus_pinterest_pageUrl'] : '' ;?>" class="add" />
            </p>
            <div class="pint_url">
            	<p class="radio_section fb_url">
                	<input name="sfsi_plus_pinterest_pingBlog" <?php echo ($option2['sfsi_plus_pinterest_pingBlog']=='yes') ?  'checked="true"' : '' ;?>  type="checkbox" value="yes" class="styled"  />
            		<label>
           				<?php  _e( 'Pin my blog on Pinterest (+1)', SFSI_PLUS_DOMAIN); ?>
            		</label>
            	</p>
            </div>
        </div>
    </div>
    <!-- END PINTEREST ICON -->
    
    <!-- INSTAGRAM ICON -->
    <div class="row sfsiplus_instagram_section">
    	<h2 class="sfsicls_instagram">
        	Instagram
        </h2>
        <div class="inr_cont">
            <p>
            	<?php  _e( 'When clicked on, users will get directed to your Instagram page', SFSI_PLUS_DOMAIN ); ?>.
            </p> 
            <p class="radio_section fb_url  cus_link instagram_space" >
            	<label>
            		URL
            	</label>
                <input name="sfsi_plus_instagram_pageUrl" type="text" value="<?php echo (isset($option2['sfsi_plus_instagram_pageUrl']) && $option2['sfsi_plus_instagram_pageUrl']!='') ?  $option2['sfsi_plus_instagram_pageUrl'] : '' ;?>" placeholder="http://" class="add"  />
            </p>
        </div>
    </div>
    <!-- END INSTAGRAM ICON -->
    
    <!-- LINKEDIN ICON -->
    <div class="row sfsiplus_linkedin_section">
    	<h2 class="sfsicls_linkdin">
        	LinkedIn
        </h2>
        <div class="inr_cont linked_tab_2 link_in">
            <p>
              	<?php  _e( 'The LinkedIn icon can perform several actions. Pick below which ones it should perform. If you select several options, then users can select what they want to do', SFSI_PLUS_DOMAIN ); ?>
            	<a class="rit_link pop-up" href="javascript:;"  data-id="linkex-s2">
	            	(<?php  _e( 'see an example', SFSI_PLUS_DOMAIN); ?>).
            	</a>
            </p> 
            <p>
            	<?php  _e( 'You find your ID in the link of your profile page, e.g. https://www.linkedin.com/profile/view?id=<b>8539887</b>&trk=nav_responsive_tab_profile_pic', SFSI_PLUS_DOMAIN ); ?>
           </p>
            <p>
            	 <?php  _e( 'The LinkedIn icon should allow users to...', SFSI_PLUS_DOMAIN ); ?>
            </p> 
            <div class="radio_section fb_url link_1">
            	<input name="sfsi_plus_linkedin_page" <?php echo ($option2['sfsi_plus_linkedin_page']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	<label>
              		<?php _e( 'Visit my Linkedin page at:', SFSI_PLUS_DOMAIN ); ?>
            	</label>
                <input name="sfsi_plus_linkedin_pageURL" type="text" placeholder="http://" value="<?php echo ($option2['sfsi_plus_linkedin_pageURL']!='') ?  $option2['sfsi_plus_linkedin_pageURL'] : '' ;?>" class="add" />
            </div>
            
            <div class="radio_section fb_url link_2">
            	<input name="sfsi_plus_linkedin_follow" <?php echo ($option2['sfsi_plus_linkedin_follow']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	
                <label>
           			<?php  _e( 'Follow me on Linkedin:', SFSI_PLUS_DOMAIN ); ?>
            	</label>
                
                <input name="sfsi_plus_linkedin_followCompany" type="text" value="<?php echo ($option2['sfsi_plus_linkedin_followCompany']!='') ?  $option2['sfsi_plus_linkedin_followCompany'] : '' ;?>" class="add" placeholder="Enter company ID, e.g. 123456" />
            </div>
            
            <div class="radio_section fb_url link_3">
            	<input name="sfsi_plus_linkedin_SharePage" <?php echo ($option2['sfsi_plus_linkedin_SharePage']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
            	<label>
            		<?php  _e( 'Share my page on LinkedIn', SFSI_PLUS_DOMAIN ); ?>
            	</label>
            </div>
            
            <div class="radio_section fb_url link_4">
            	<input name="sfsi_plus_linkedin_recommendBusines" <?php echo ($option2['sfsi_plus_linkedin_recommendBusines']=='yes') ?  'checked="true"' : '' ;?> type="checkbox" value="yes" class="styled"  />
                <label class="anthr_labl">
            		<?php  _e( 'Recommend my business or product on Linkedin', SFSI_PLUS_DOMAIN ); ?>
            	</label>
                <input name="sfsi_plus_linkedin_recommendProductId" type="text" value="<?php echo ($option2['sfsi_plus_linkedin_recommendProductId']!='') ?  $option2['sfsi_plus_linkedin_recommendProductId'] : '' ;?>" class="add link_dbl" placeholder="Enter Product ID, e.g. 1441" /> <input name="sfsi_plus_linkedin_recommendCompany" type="text" value="<?php echo ($option2['sfsi_plus_linkedin_recommendCompany']!='') ?  $option2['sfsi_plus_linkedin_recommendCompany'] : '' ;?>" class="add" placeholder="Enter company name, e.g. Google”" />
            </div>
            <div class="lnkdin_instruction">
                <?php  _e( 'To find your Product or Company ID, you can use their ID lookup tool at', SFSI_PLUS_DOMAIN ); ?>
                <a target="_blank" href="https://developer.linkedin.com/apply-getting-started#company-lookup">
                	https://developer.linkedin.com/apply-getting-started#company-lookup
                </a>
                . <?php  _e( 'You need to be logged in to Linkedin to be able to use it.', SFSI_PLUS_DOMAIN ); ?>
            </div>
        </div>
    </div>
    <!-- END LINKEDIN ICON -->
    
    <!-- HOUZZ ICON -->
    <div class="row sfsiplus_houzz_section">
    	<h2 class="sfsicls_houzz">
        	Houzz
        </h2>
        <div class="inr_cont">
            <p>
            	<?php  _e( 'Please provide the url to your Houzz profile (e.g. http://www.houzz.com/user/your_username).', SFSI_PLUS_DOMAIN ); ?>  
            </p> 
            <p class="radio_section fb_url  cus_link instagram_space" >
            	<label>
            	    URL
                </label>
                <input name="sfsi_plus_houzz_pageUrl" type="text" value="<?php echo (isset($option2['sfsi_plus_houzz_pageUrl']) && $option2['sfsi_plus_houzz_pageUrl']!='') ?  $option2['sfsi_plus_houzz_pageUrl'] : '' ;?>" placeholder="http://" class="add" />
            </p>        
        </div>
    </div>
    <!-- HOUZZ INSTAGRAM ICON -->
    
	    <!-- Custom icon section start here -->
	    <div class="plus_custom-links sfsiplus_custom_section">
		<?php 
		  	$costom_links = unserialize($option2['sfsi_plus_CustomIcon_links']);

		  	$bannerDisplay= "display:none;";
		  	$count = 1;
			for($i = $first_key; $i <= $endkey; $i++) :
			if(!empty( $icons[$i])) :
				
				$bannerDisplay = "display:block;";
				?>
	           	<div class="row  sfsiICON_<?php echo $i; ?> cm_lnk">
	               	<h2 class="custom">
	               		<span class="customstep2-img">
	                    	<img src="<?php echo (!empty($icons[$i])) ?  esc_url($icons[$i]) : SFSI_PLUS_PLUGURL.'images/custom.png';?>" id="CImg_<?php echo $new_element; ?>" style="border-radius:48%"  />
	                    </span>
	                    <span class="sfsiCtxt">
	               			<?php  _e( 'Custom', SFSI_PLUS_DOMAIN ); ?>
				   			<?php echo $count; ?>
	                    </span>
	                </h2>
	               	<div class="inr_cont ">
	                   	<p>
	                	   <?php  _e( 'Where do you want this icon to link to?', SFSI_PLUS_DOMAIN ); ?>
	                   	</p> 
	                   	<p class="radio_section fb_url sfsiplus_custom_section cus_link " >
	                   		<label>
	                   			<?php  _e( 'Link:', SFSI_PLUS_DOMAIN ); ?>
	                   		</label>
	                        <input name="sfsi_plus_CustomIcon_links[]" type="text" value="<?php echo (isset($costom_links[$i]) && $costom_links[$i]!='') ?  esc_url($costom_links[$i]) : '' ;?>" placeholder="http://" class="add" file-id="<?php echo $i; ?>" />
	                    </p>
	        		</div>
	           	</div>
		 		<?php
				$count++;
			endif; endfor;
		?>
	    </div>

    	<div class="banner_custom_icon sfsi_plus_new_prmium_follw" style="<?php echo $bannerDisplay;?>">
			<p><b><?php  _e( 'New:', SFSI_PLUS_DOMAIN); ?></b>	<?php  _e( ' In the Premium Plugin you can also give custom icons the feature that
when people click on it, they can call you, or send you an SMS). ', SFSI_PLUS_DOMAIN); ?><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=call_or_sms_feature_custom_icons&utm_medium=banner" target="_blank"><?php  _e( 'See all features.', SFSI_PLUS_DOMAIN); ?> </a>					
			</p>
    	</div>

    <!-- END Custom icon section here -->

	
	<?php sfsi_plus_ask_for_help(2); ?>


    <!-- SAVE BUTTON SECTION   --> 
    <div class="save_button tab_2_sav">
        <img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/ajax-loader.gif" class="loader-img" />
        
		<?php  $nonce = wp_create_nonce("update_plus_step2"); ?>
        
        <a href="javascript:;" id="sfsi_plus_save2" title="Save" data-nonce="<?php echo $nonce;?>">
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

</div>
<!-- END Section 2 "What do you want the icons to do?" main div -->
