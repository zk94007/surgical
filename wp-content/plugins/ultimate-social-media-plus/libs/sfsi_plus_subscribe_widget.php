<?php
//Add Subscriber form css
add_action("wp_head", "sfsi_plus_addStyleFunction");
function sfsi_plus_addStyleFunction()
{
	$option9 			= unserialize(get_option('sfsi_plus_section9_options',false));
	$sfsi_plus_feediid 	= sanitize_text_field(get_option('sfsi_plus_feed_id'));
	$url 				= "https://www.specificfeeds.com/widgets/subscribeWidget/";
	
	echo $return = '';
	?>
    	<script>
			jQuery(document).ready(function(e) {
                jQuery("body").addClass("sfsi_plus_<?php echo get_option("sfsi_plus_pluginVersion");?>")
            });
			function sfsi_plus_processfurther(ref) {
				var feed_id = '<?php echo $sfsi_plus_feediid?>';
				var feedtype = 8;
				var email = jQuery(ref).find('input[name="data[Widget][email]"]').val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if ((email != "Enter your email") && (filter.test(email))) {
					if (feedtype == "8") {
						var url = "<?php echo $url; ?>"+feed_id+"/"+feedtype;
						window.open(url, "popupwindow", "scrollbars=yes,width=1080,height=760");
						return true;
					}
				} else {
					alert("Please enter email address");
					jQuery(ref).find('input[name="data[Widget][email]"]').focus();
					return false;
				}
			}
		</script>
    	<style type="text/css" aria-selected="true">
			.sfsi_plus_subscribe_Popinner
			{
				<?php if($option9['sfsi_plus_form_adjustment'] == 'yes') : ?>
				width: 100% !important;
				height: auto !important;
				<?php else: ?>
				width: <?php echo $option9['sfsi_plus_form_width'] ?>px !important;
				height: <?php echo $option9['sfsi_plus_form_height'] ?>px !important;
				<?php endif;?>
				<?php if($option9['sfsi_plus_form_border'] == 'yes') : ?>
				border: <?php echo $option9['sfsi_plus_form_border_thickness']."px solid ".$option9['sfsi_plus_form_border_color'];?> !important;
				<?php endif;?>
				padding: 18px 0px !important;
				background-color: <?php echo $option9['sfsi_plus_form_background'] ?> !important;
			}
			.sfsi_plus_subscribe_Popinner form
			{
				margin: 0 20px !important;
			}
			.sfsi_plus_subscribe_Popinner h5
			{
				font-family: <?php echo $option9['sfsi_plus_form_heading_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_heading_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_heading_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_heading_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_heading_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_heading_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_heading_fontalign'] ?> !important;
				margin: 0 0 10px !important;
    			padding: 0 !important;
			}
			.sfsi_plus_subscription_form_field {
				margin: 5px 0 !important;
				width: 100% !important;
				display: inline-flex;
				display: -webkit-inline-flex;
			}
			.sfsi_plus_subscription_form_field input {
				width: 100% !important;
				padding: 10px 0px !important;
			}
			.sfsi_plus_subscribe_Popinner input[type=email]
			{
				font-family: <?php echo $option9['sfsi_plus_form_field_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_field_fontalign'] ?> !important;
			}
			.sfsi_plus_subscribe_Popinner input[type=email]::-webkit-input-placeholder {
			   font-family: <?php echo $option9['sfsi_plus_form_field_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_field_fontalign'] ?> !important;
			}
			
			.sfsi_plus_subscribe_Popinner input[type=email]:-moz-placeholder { /* Firefox 18- */
			    font-family: <?php echo $option9['sfsi_plus_form_field_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_field_fontalign'] ?> !important;
			}
			
			.sfsi_plus_subscribe_Popinner input[type=email]::-moz-placeholder {  /* Firefox 19+ */
			    font-family: <?php echo $option9['sfsi_plus_form_field_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_field_fontalign'] ?> !important;
			}
			
			.sfsi_plus_subscribe_Popinner input[type=email]:-ms-input-placeholder {  
			  	font-family: <?php echo $option9['sfsi_plus_form_field_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_field_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_field_fontstyle'] ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_field_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_field_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_field_fontalign'] ?> !important;
			}
			.sfsi_plus_subscribe_Popinner input[type=submit]
			{
				font-family: <?php echo $option9['sfsi_plus_form_button_font'] ?> !important;
				<?php if($option9['sfsi_plus_form_button_fontstyle'] != 'bold') {?>
				font-style: <?php echo $option9['sfsi_plus_form_button_fontstyle']; ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo $option9['sfsi_plus_form_button_fontstyle']; ?> !important;
				<?php }?>
				color: <?php echo $option9['sfsi_plus_form_button_fontcolor'] ?> !important;
				font-size: <?php echo $option9['sfsi_plus_form_button_fontsize']."px" ?> !important;
				text-align: <?php echo $option9['sfsi_plus_form_button_fontalign'] ?> !important;
				background-color: <?php echo $option9['sfsi_plus_form_button_background'] ?> !important;
			}
		</style>
	<?php
}
// Creating the widget 
class sfsiPlus_subscriber_widget extends WP_Widget {

	function __construct()
	{
		parent::__construct(
			// Base ID of your widget
			'sfsiPlus_subscriber_widget', 
	
			// Widget name will appear in UI
			'Ultimate Social Plus Subscribe Form', 
	
			// Widget description
			array( 'description' => 'Ultimate Social Plus Subscribe Form') 
		);
	}

	public function widget( $args, $instance )
	{
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];

		if ( ! empty( $title ) )
		{
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Call subscriber form
		echo do_shortcode("[USM_plus_form]");
		
		echo $args['after_widget'];
	}
		
	// Widget Backend 
	public function form( $instance )
	{
		if ( isset( $instance[ 'title' ] ))
		{
			$title = $instance[ 'title' ];
		}
		else
		{
			$title = '';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $newInstance, $oldInstance )
	{
		$instance = array();
		$instance['title'] = ( ! empty( $newInstance['title'] ) ) ? strip_tags( $newInstance['title'] ) : '';
		return $instance;
	}
}
// Class wpb_widget ends here

// Register and load the widget
function sfsiPlus_subscriber_load_widget()
{
	register_widget( 'sfsiPlus_subscriber_widget' );
}
add_action( 'widgets_init', 'sfsiPlus_subscriber_load_widget' );
?>
<?php
add_shortcode("USM_plus_form", "sfsi_plus_get_subscriberForm");
function sfsi_plus_get_subscriberForm()
{
	$option9 			= unserialize(get_option('sfsi_plus_section9_options',false));
	$sfsi_plus_feediid 	= sanitize_text_field(get_option('sfsi_plus_feed_id'));
	$url = "https://www.specificfeeds.com/widgets/subscribeWidget/";
	
	$return = '';
	$url = $url.$sfsi_plus_feediid.'/8/';	
	$return .= '<div class="sfsi_plus_subscribe_Popinner">
					<form method="post" onsubmit="return sfsi_plus_processfurther(this);" target="popupwindow" action="'.$url.'">
						<h5>'.__(trim($option9['sfsi_plus_form_heading_text']),SFSI_PLUS_DOMAIN).'</h5>
						<div class="sfsi_plus_subscription_form_field">
							<input type="email" name="data[Widget][email]" value="" placeholder="'.trim($option9['sfsi_plus_form_field_text']).'"/>
						</div>
						<div class="sfsi_plus_subscription_form_field">
							<input type="hidden" name="data[Widget][feed_id]" value="'.$sfsi_plus_feediid.'">
							<input type="hidden" name="data[Widget][feedtype]" value="8">
							<input type="submit" name="subscribe" value="'.__($option9['sfsi_plus_form_button_text'],SFSI_PLUS_DOMAIN).'" />
						</div>
					</form>
				</div>';
	return $return;			
}
?>