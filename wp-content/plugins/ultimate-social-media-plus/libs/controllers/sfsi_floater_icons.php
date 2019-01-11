<?php
/* make icons float icons even widget is not active  */
function sfsi_plus_frontFloter ($content)
{
	$sfsi_section8=  unserialize(get_option('sfsi_plus_section8_options',false));
   	$sfsi_section8['sfsi_plus_float_on_page'];
   	if($sfsi_section8['sfsi_plus_float_on_page']=="yes") :
		ob_start();
    	/* call the all icons function under sfsi_plus_widget.php file */
     	echo sfsi_plus_check_visiblity(1);        
     	echo  $output=ob_get_clean();
     	$res=$content.$output;
    	return $res; exit;
    endif;
}

?>