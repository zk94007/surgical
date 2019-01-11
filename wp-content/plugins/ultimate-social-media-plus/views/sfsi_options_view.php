<!-- Loader Image section  -->
<div id="sfpluspageLoad" >
    
</div>
<!-- END Loader Image section  -->

<!-- javascript error loader  -->
<div class="error" id="sfsi_onload_errors" style="margin-left: 60px;display: none;">
    <p>
    	<?php  _e('We found errors in your javascript which may cause the plugin to not work properly. Please fix the error:',SFSI_PLUS_DOMAIN ); ?>
    </p><p id="sfsi_jerrors"></p>
</div>
<!-- END javascript error loader  -->

<!-- START Admin view for plugin-->
<div class="wapper sfsi_mainContainer">
	
    <?php sfsi_plus_language_notice();?>
    <?php sfsi_plus_addThis_removal_notice(); ?>
     <!-- Get notification bar-->
	 <?php if(get_option("sfsi_plus_show_notification") == "yes") { ?>

    <script type="text/javascript">
		jQuery(document).ready(function(e) {
            jQuery(".sfsi_plus_show_notification").click(function(){
				SFSI.ajax({
					url:ajax_object.ajax_url,
					type:"post",
					data: {action: "sfsiPlus_notification_read"},
					success:function(msg){
						if(msg == 'success')
						{
							jQuery(".sfsi_plus_show_notification").hide("fast");
						}
					}
				});
			});
        });
	</script>
    <style type="text/css">
	.sfsi_plus_show_notification {
		margin-bottom: 45px;
		padding: 12px 13px;
		width: 98%;
		background-image: url(<?php echo SFSI_PLUS_PLUGURL ?>images/notification-close.png);
		background-position: right 20px center;
    	background-repeat: no-repeat;
		cursor: pointer;
		text-align:center;
	}
	</style>
	<!-- <div class="sfsi_plus_show_notification" style="background-color: #38B54A; color: #fff; font-size: 18px;">
    	
        <?php  //_e( 'New: You can now also show a subscription form on your site, increasing sign-ups! (Question 8)', SFSI_PLUS_DOMAIN); ?>
        <p>
			(<?php  //_e('If question 8 gets displayed in a funny way then please reload the page by pressing Control+F5(PC) or Command+R(Mac)',SFSI_PLUS_DOMAIN); ?>)
        </p>
    </div> -->
	<?php } ?>
    <!-- Get notification bar-->
 
    <div class="sfsi_plus_notificationBannner"></div>
    
    <!-- Top content area of plugin -->
    <div class="main_contant">
        <h1>
            <?php  _e( 'Welcome to the Ultimate Social Media Icons PLUS plugin!', SFSI_PLUS_DOMAIN ); ?>
        </h1>
        
        <div class="welcometext">

            <p><?php  _e( 'Simply answer the questions below (at least the first 3) by clicking on them - that`s it!', SFSI_PLUS_DOMAIN ); ?></p>
           
            <p><a style="text-decoration: none;" href="javascript:void(0)"><?php _e( 'New:', SFSI_PLUS_DOMAIN ); ?> </a><?php _e('Our new Premium Plugin allows many more placement options, better sharing features (e.g. define which text &amp; images will get shared), optimization for mobile, more icon design styles, <a target="_blank" href="https://www.ultimatelysocial.com/animated-social-media-icons/">animated icons</a>, <a target="_blank" href="https://www.ultimatelysocial.com/themed-icons-search/">themed icons</a>, and much more.', SFSI_PLUS_DOMAIN ); ?> <a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&amp;utm_campaign=notification_banner&amp;utm_medium=banner" target="_blank"><?php _e('See all features', SFSI_PLUS_DOMAIN ); ?></a></p>


            <p><?php  _e( 'Please', SFSI_PLUS_DOMAIN ); ?> <a target="_blank" style="text-decoration: underline;" href="https://goo.gl/MU6pTN#no-topic-0"><?php  _e( 'give us feedback,', SFSI_PLUS_DOMAIN ); ?></a><?php  _e( ' and tell us how we can make the plugin better. Thank you!.', SFSI_PLUS_DOMAIN ); ?></p>

        </div>

        <div class="supportforum">
            <div class="support-container">
                <div class="have-questions">
                    <img src="<?php echo SFSI_PLUS_PLUGURL ?>images/question.png">
                    <p class="have-quest">Have questions?</p>
                    <!-- <p class="ask-question">Ask them in the...</p> -->
                </div>
                <div class="support-forum-green-div">
                    <a target="_blank" href="#" onclick="event.preventDefault();sfsi_plus_open_chat(event)" class="support-forum-green-bg">
                        <img src="<?php echo SFSI_PLUS_PLUGURL ?>images/support.png">
                        <p class="support-forum">Chat with us!</p>
                    </a>
                </div>
                <!-- <div class="respond-text">
                    <p>We'll try to respond ASAP!</p>
                </div> -->
            </div>
        </div>

    </div>
    <!-- END Top content area of plugin -->
      
    <!-- step 1 end  here -->
    <div id="accordion">
        <h3><span>1</span>
            <?php  _e( 'Which icons do you want to show on your site?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <!-- step 1 end  here -->
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view1.php'); ?>
        <!-- step 1 end here -->
        
        <!-- step 2 start here -->
        <h3><span>2</span>
            <?php  _e( 'What do you want the icons to do?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view2.php'); ?>
        <!-- step 2 END here -->
        
        <!-- step new 3 start here -->
        <h3><span>3</span>
            <?php  _e( 'Where shall they be displayed?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view8.php'); ?>
    <!-- step new3 end here -->
   	</div>
   	<h2 class="optional">
   		<?php  _e( 'Optional', SFSI_PLUS_DOMAIN ); ?>
   	</h2>
	<div id="accordion1">
	<!-- step old 3 start here -->
        <h3><span>4</span>
            <?php  _e( 'What design and animation do you want to give your icons?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view3.php'); ?>
        <!-- step old 3 END here -->
    
        <!-- step old 4 Start here -->
        <h3><span>5</span>
            <?php  _e( 'Do you want to display "counts" next to your main icons?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view4.php'); ?>
        <!-- step old 4 END here -->
    
        <!-- step old 5 Start here -->
        <h3><span>6</span>
            <?php  _e( 'Any other wishes for your main icons?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view5.php'); ?>
        <!-- step old 5 END here -->
    
        <!-- step old 6 Start here (this is older and newer is added as 8 at question 3) -->
        <!--<h3><span>7</span>Do you want to display icons at the end of every post?</h3>-->
         <?php //include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view6.php'); ?>
        <!-- step old 6 END here -->
    
        <!-- step old 7 Start here -->
        <h3><span>7</span>
            <?php  _e( 'Do you want to display a pop-up, asking people to subscribe?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view7.php'); ?>
        <!-- step old 7 END here -->
    
        <!-- step old 8 Start here -->
        <h3><span>8</span>
            <?php  _e( 'Do you want to show a subscription form (increases sign ups)?', SFSI_PLUS_DOMAIN ); ?>
        </h3>
        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_option_view9.php'); ?>
    <!-- step old 8 END here -->
    
    </div>
    <div class="tab10">
    	<div class="save_button">
		 	<img src="<?php echo SFSI_PLUS_PLUGURL; ?>images/ajax-loader.gif" class="loader-img" />
            <a href="javascript:;" id="save_plus_all_settings" title="Save All Settings">
                <?php  _e( 'Save All Settings', SFSI_PLUS_DOMAIN ); ?>
            </a>
	 </div>
        <p class="red_txt errorMsg" style="display:none"> </p>
        <p class="green_txt sucMsg" style="display:none"> </p>

        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_affiliate_banner.php'); ?>

        <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_section_for_premium.php'); ?>

        <p style="margin-top: 30px;clear: both;">
            <?php  _e('Like this plugin? Please do us a BIG favor and give us a 5 star rating here.', SFSI_PLUS_DOMAIN ); ?>
            <a href=" https://wordpress.org/support/plugin/ultimate-social-media-plus/reviews?rate=5#new-post" target="_new">
                <?php  _e( 'here', SFSI_PLUS_DOMAIN ); ?>
            </a>
         </p>
         
         <!--<p class="bldtxtmsg">
         	<?php  _e( 'Need top-notch Wordpress development work at a competitive price?', SFSI_PLUS_DOMAIN ); ?>
         	<a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmplus_settings_page&utm_campaign=footer_credit&utm_medium=banner">
        		<?php _e('Visit us on ultimatelysocial.com',SFSI_PLUS_DOMAIN); ?>
         	</a>
         </p>-->
         <?php
             /*$tra_lan = get_bloginfo( 'language' );
             if($tra_lan == "en-US" )
             {}
             else
             {
                 ?>
                 <p class="translatelilne">
                    <?php  _e( 'The plugin was translated by (your name). Need translation work to get done? Contact (your name) at (your email)', SFSI_PLUS_DOMAIN ); ?>
                 </p>
                <?php
            }*/
        ?>
        <p class="translatelilne">
            <?php  _e( 'Have questions? Need help? Ideas for new features? Please raise a ticket in the',SFSI_PLUS_DOMAIN ); ?>
                <a href="https://goo.gl/MU6pTN#no-topic-0" target="_new">
                    <?php  _e( 'Support Forum', SFSI_PLUS_DOMAIN ); ?>
                </a>            
             <?php  _e( ' . We\'ll try to answer asap!', SFSI_PLUS_DOMAIN ); ?>
        </p>
    </div>
 <!-- all pops of plugin under sfsi_pop_content.php file -->
 <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_pop_content.php'); ?>
</div>

<!-- START Admin view for plugin-->
<script type="text/javascript">
    var e = {
        action:"sfsiplusbannerOption"
    };

    jQuery.ajax({
        url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
        type:"post",
        data:e,
        success:function(e) {
            jQuery(".sfsi_plus_notificationBannner").html(e);
        }
    });
</script>
 <?php include(SFSI_PLUS_DOCROOT.'/views/sfsi_chat_on_admin_pannel.php'); ?>
