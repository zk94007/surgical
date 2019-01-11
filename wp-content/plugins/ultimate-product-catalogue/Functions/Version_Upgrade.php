<?php 
function UPCP_TransferOutBeforeUpgrade() {echo "File Path: " . UPCP_CD_PLUGIN_PATH . "upcp-site-map.xml" . "<Br><br>";
	if (file_exists(UPCP_CD_PLUGIN_PATH . "upcp-site-map.xml")) {
		$to = UPCP_CD_PLUGIN_PATH."../upcp-site-map.xml"; 
		$from = UPCP_CD_PLUGIN_PATH . "upcp-site-map.xml";
		copy($from, $to);
	}
}

function UPCP_TransferInAfterUpgrade() {
	if (file_exists(UPCP_CD_PLUGIN_PATH . "../upcp-site-map.xml")) {
		$from = UPCP_CD_PLUGIN_PATH."../upcp-site-map.xml"; 
		$to = UPCP_CD_PLUGIN_PATH . "upcp-site-map.xml";
		copy($from, $to);
	}
}

function UPCP_SetUpdateOption() {
	update_option('UPCP_Update_Flag', "Yes");
	update_option("UPCP_Mobile_SS", "No");
}

add_filter('upgrader_pre_install', 'UPCP_SetUpdateOption', 10, 2);
add_filter('upgrader_pre_install', 'TransferOutBeforeUpgrade', 10, 2); 
add_filter('upgrader_post_install', 'TransferInAfterUpgrade', 10, 2);
 ?>