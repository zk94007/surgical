<?php 
  
/* show a pop on the as per user chose under section 7 */
function sfsi_plus_frontPopUp ()
{ 
     ob_start();
     echo sfsi_plus_FrontPopupDiv();        
     echo  $output=ob_get_clean();
}
/* check where to be pop-shown */
function sfsi_plus_check_PopUp($content)
{
     global $post; global $wpdb; 
     $sfsi_plus_section7_options=  unserialize(get_option('sfsi_plus_section7_options',false));
     if($sfsi_plus_section7_options['sfsi_plus_Show_popupOn']=="blogpage")
     {   
	   	if(!is_feed() && !is_home() && !is_page())
		{
		     $content=  sfsi_plus_frontPopUp ().$content;
	     }
     }
	 else if($sfsi_plus_section7_options['sfsi_plus_Show_popupOn']=="selectedpage")
     {
	 	if(!empty($post->ID) && !empty($sfsi_plus_section7_options['sfsi_plus_Show_popupOn_PageIDs']))
		{
			if(is_page() && in_array($post->ID,  unserialize($sfsi_plus_section7_options['sfsi_plus_Show_popupOn_PageIDs'])))
			{
				 $content=  sfsi_plus_frontPopUp ().$content;
			}
		}
     }
     else if($sfsi_plus_section7_options['sfsi_plus_Show_popupOn']=="everypage")
	 {
	 	$content= sfsi_plus_frontPopUp ().$content;
     }

     /* check for pop times */
     if($sfsi_plus_section7_options['sfsi_plus_Shown_pop']=="once")
     {
		$time_popUp = (int) $sfsi_plus_section7_options['sfsi_plus_Shown_popupOnceTime'];
		$time_popUp = $time_popUp*1000;
	 	ob_start();?>
        
     <script>
	    jQuery( document ).ready(function( $ )
		{
	    	setTimeout(
				function()
				{	
					jQuery('.sfsi_plus_outr_div').css({'z-index':'1000000',opacity:1});
					jQuery('.sfsi_plus_outr_div').fadeIn();
					jQuery('.sfsi_plus_FrntInner').fadeIn(200);
				}
				,<?php echo $time_popUp; ?>);
		});
	 </script>
     <?php 
     	echo ob_get_clean();
     	return $content;
     }
     
     if($sfsi_plus_section7_options['sfsi_plus_Shown_pop']=="ETscroll")
     {
		$time_popUp = (int) $sfsi_plus_section7_options['sfsi_plus_Shown_popupOnceTime'];
		$time_popUp = $time_popUp*1000;
	    ob_start();
		?>
     	<script>
	    jQuery( document ).scroll(function( $ )
		{
	    	var y = jQuery(this).scrollTop();
	      	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
			{	 
	       		if(jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()-100)
				{
				  jQuery('.sfsi_plus_outr_div').css({'z-index':'9996',opacity:1,top:jQuery(window).scrollTop()+"px",position:"absolute"});
				  jQuery('.sfsi_plus_outr_div').fadeIn(200);
				  jQuery('.sfsi_plus_FrntInner').fadeIn(200);
	       		}
	       		else
				{
				   jQuery('.sfsi_plus_outr_div').fadeOut();
				   jQuery('.sfsi_plus_FrntInner').fadeOut();
 			    }
	    	}
	  		else
			{
	       		if(jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()-3)
				{
			        jQuery('.sfsi_plus_outr_div').css({'z-index':'9996',opacity:1,top:jQuery(window).scrollTop()+200+"px",position:"absolute"});
	        		jQuery('.sfsi_plus_outr_div').fadeIn(200);
					jQuery('.sfsi_plus_FrntInner').fadeIn(200);
	    		}
	  			else
				{
				    jQuery('.sfsi_plus_outr_div').fadeOut();
	      			jQuery('.sfsi_plus_FrntInner').fadeOut();
	       		}
	 		} 
		});
     </script>
     <?php 
     	echo ob_get_clean();
     }

     if($sfsi_plus_section7_options['sfsi_plus_Shown_pop']=="LimitPopUp")
     {
	 	$time_popUp = (int) $sfsi_plus_section7_options['sfsi_plus_Shown_popuplimitPerUserTime'];
	 	$end_time   = (int) $_COOKIE['sfsi_socialPopUp']+($time_popUp*60); 
		$time_popUp = $time_popUp*1000;
     
	 	if(!empty($end_time))
		{
			 if($end_time<time())
			 {     
			 ?>
			 <script>
				jQuery( document ).ready(function( $ ) {
				   //SFSI('.sfsi_plus_outr_div').fadeIn();
			  		sfsi_plus_setCookie('sfsi_socialPopUp',<?php echo time(); ?>,32);
			  		setTimeout(function() {jQuery('.sfsi_plus_outr_div').css({'z-index':'1000000',opacity:1});jQuery('.sfsi_plus_outr_div').fadeIn();},<?php echo $time_popUp; ?>);
				});
				var SFSI = jQuery.noConflict();
			</script>
			<?php
			}
		 }
     	echo ob_get_clean();
     }    
	return $content;
}
/* make front end pop div */
function sfsi_plus_FrontPopupDiv()
{
    global $wpdb;
    /* get all settings for icons saved in admin */
    $sfsi_plus_section1_options = unserialize(get_option('sfsi_plus_section1_options',false));
    $custom_i = unserialize($sfsi_plus_section1_options['sfsi_custom_files']);
    if($sfsi_plus_section1_options['sfsi_plus_rss_display']=='no' &&  $sfsi_plus_section1_options['sfsi_plus_email_display']=='no' && $sfsi_plus_section1_options['sfsi_plus_facebook_display']=='no' && $sfsi_plus_section1_options['sfsi_plus_twitter_display']=='no' &&  $sfsi_plus_section1_options['sfsi_plus_google_display']=='no' && $sfsi_plus_section1_options['sfsi_plus_youtube_display']=='no' && $sfsi_plus_section1_options['sfsi_plus_pinterest_display']=='no' && $sfsi_plus_section1_options['sfsi_plus_linkedin_display']=='no' && empty($custom_i)) 
    {
     	$icons='';
		return $icons;
		exit;
    }
    $sfsi_plus_section7_options = unserialize(get_option('sfsi_plus_section7_options',false));
    $sfsi_section5 = unserialize(get_option('sfsi_plus_section5_options',false));
    $sfsi_section4 = unserialize(get_option('sfsi_plus_section4_options',false));
   
    /* calculate the width and icons display alignments */
    $heading_text = (isset($sfsi_plus_section7_options['sfsi_plus_popup_text'])) ? __($sfsi_plus_section7_options['sfsi_plus_popup_text'],SFSI_PLUS_DOMAIN): __('Enjoy this site? Please follow and like us!',SFSI_PLUS_DOMAIN);
    $div_bgColor		= (isset($sfsi_plus_section7_options['sfsi_plus_popup_background_color'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_background_color']: '#fff';
    $div_FontFamily 	= (isset($sfsi_plus_section7_options['sfsi_plus_popup_font'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_font']: 'Arial';
    $div_BorderColor	= (isset($sfsi_plus_section7_options['sfsi_plus_popup_border_color'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_border_color']: '#d3d3d3';
    $div_Fonttyle		= (isset($sfsi_plus_section7_options['sfsi_plus_popup_fontStyle'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_fontStyle']: 'normal';
    $div_FontColor		= (isset($sfsi_plus_section7_options['sfsi_plus_popup_fontColor'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_fontColor']: '#000';
    $div_FontSize		= (isset($sfsi_plus_section7_options['sfsi_plus_popup_fontSize'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_fontSize']: '26';
    $div_BorderTheekness= (isset($sfsi_plus_section7_options['sfsi_plus_popup_border_thickness'])) ? $sfsi_plus_section7_options['sfsi_plus_popup_border_thickness']: '1';
    $div_Shadow			= (isset($sfsi_plus_section7_options['sfsi_plus_popup_border_shadow']) && $sfsi_plus_section7_options['sfsi_plus_popup_border_shadow']=="yes") ?$sfsi_plus_section7_options['sfsi_plus_popup_border_thickness']: 'no'; 
    
    $style="background-color:".$div_bgColor.";border:".$div_BorderTheekness."px solid".$div_BorderColor."; font-style:".$div_Fonttyle.";color:".$div_FontColor;
    if($sfsi_plus_section7_options['sfsi_plus_popup_border_shadow']=="yes")
    {
       $style.=";box-shadow:12px 30px 18px #CCCCCC;";
    }    
    
	$h_style="font-family:".$div_FontFamily.";font-style:".$div_Fonttyle.";color:".$div_FontColor.";font-size:".$div_FontSize."px";
    /* get all icons including custom icons */
    $custom_icons_order = unserialize($sfsi_section5['sfsi_plus_CustomIcons_order']);
    $icons_order = array($sfsi_section5['sfsi_plus_rssIcon_order']	=>'rss',
                     $sfsi_section5['sfsi_plus_emailIcon_order']	=>'email',
                     $sfsi_section5['sfsi_plus_facebookIcon_order']	=>'facebook',
                     $sfsi_section5['sfsi_plus_googleIcon_order']	=>'google',
                     $sfsi_section5['sfsi_plus_twitterIcon_order']	=>'twitter',
                     $sfsi_section5['sfsi_plus_youtubeIcon_order']	=>'youtube',
                     $sfsi_section5['sfsi_plus_pinterestIcon_order']=>'pinterest',
                     $sfsi_section5['sfsi_plus_linkedinIcon_order']	=>'linkedin',
		     		 $sfsi_section5['sfsi_plus_instagramIcon_order']=>'instagram',
					 (isset($sfsi_section5['sfsi_plus_houzzIcon_order']))
						? $sfsi_section5['sfsi_plus_houzzIcon_order']
						: 11 => 'houzz'
					) ;
  $icons = array();
  $elements = array();
  $icons = unserialize($sfsi_plus_section1_options['sfsi_custom_files']);
  if(is_array($icons))  $elements=array_keys($icons);
  $cnt=0;
  $total=isset($custom_icons_order) && is_array($custom_icons_order)?count($custom_icons_order):0;
  if(!empty($icons) && is_array($icons))
  {
  	  foreach($icons as $cn=>$c_icons)
	  {    
		  if(is_array($custom_icons_order) ) :
			if(in_array($custom_icons_order[$cnt]['ele'],$elements)) :   
				$key = key($elements);
				unset($elements[$key]);
			 	$icons_order[$custom_icons_order[$cnt]['order']]=array('ele'=>$cn,'img'=>$c_icons);
			else :
				$icons_order[]=array('ele'=>$cn,'img'=>$c_icons);
		    endif;
		   	$cnt++;
		  else :
		  	$icons_order[]=array('ele'=>$cn,'img'=>$c_icons);
		  endif;
	  }
  }
  ksort($icons_order);/* short icons in order to display */
	
   $icons = '<div class="sfsi_plus_outr_div" > <div class="sfsi_plus_FrntInner" style="'.$style.'">';
   $icons.='<div class="sfsiclpupwpr" onclick="sfsiplushidemepopup();"><img src="'.SFSI_PLUS_PLUGURL.'images/close.png" /></div>';
	
	if(!empty($heading_text))
	{
		$icons.='<h2 style="'.$h_style.'">'.$heading_text.'</h2>';
	}
    
	$ulmargin="";
    if($sfsi_section4['sfsi_plus_display_counts']=="no")
    {
		$ulmargin="margin-bottom:0px";
    }
    
	/* make icons with all settings saved in admin  */
    $icons.='<ul style="'.$ulmargin.'">';
    foreach($icons_order  as $index=>$icn) :
        
    if(is_array($icn)) { $icon_arry=$icn; $icn="custom" ; } 
    switch ($icn) :     
    case 'rss' :
		if($sfsi_plus_section1_options['sfsi_plus_rss_display']=='yes')  $icons.= "<li>".sfsi_plus_prepairIcons('rss',1)."</li>";  
    break;
    case 'email' :
		if($sfsi_plus_section1_options['sfsi_plus_email_display']=='yes')   $icons.= "<li>".sfsi_plus_prepairIcons('email',1)."</li>"; 
    break;
    case 'facebook' :
		if($sfsi_plus_section1_options['sfsi_plus_facebook_display']=='yes') $icons.= "<li>".sfsi_plus_prepairIcons('facebook',1)."</li>";
    break;
    case 'google' :
		if($sfsi_plus_section1_options['sfsi_plus_google_display']=='yes')    $icons.= "<li>".sfsi_plus_prepairIcons('google',1)."</li>";
    break;
    case 'twitter' :
		if($sfsi_plus_section1_options['sfsi_plus_twitter_display']=='yes')    $icons.= "<li>".sfsi_plus_prepairIcons('twitter',1)."</li>"; 
    break;
    case 'youtube' :
		if($sfsi_plus_section1_options['sfsi_plus_youtube_display']=='yes')     $icons.= "<li>".sfsi_plus_prepairIcons('youtube',1)."</li>"; 
    break;
    case 'pinterest' :
		if($sfsi_plus_section1_options['sfsi_plus_pinterest_display']=='yes')     $icons.= "<li>".sfsi_plus_prepairIcons('pinterest',1)."</li>";
    break;
    case 'linkedin' :
		if($sfsi_plus_section1_options['sfsi_plus_linkedin_display']=='yes')    $icons.= "<li>".sfsi_plus_prepairIcons('linkedin',1)."</li>"; 
    break;
    case 'instagram' :
		if($sfsi_plus_section1_options['sfsi_plus_instagram_display']=='yes')    $icons.= "<li>".sfsi_plus_prepairIcons('instagram',1)."</li>"; 
    break;
	case 'houzz' :
		if(
			isset($sfsi_plus_section1_options['sfsi_plus_houzz_display']) &&
			$sfsi_plus_section1_options['sfsi_plus_houzz_display']=='yes'
		)
		{
			$icons.= "<li>".sfsi_plus_prepairIcons('houzz',1)."</li>";
		}
    break;
    case 'custom' :
		$icons.= "<li>". sfsi_plus_prepairIcons($icon_arry['ele'],1)."</li>"; 
    break;    
    endswitch;
    endforeach;    
    $icons.='</ul></div ></div >';
    
    return $icons;
}

?>