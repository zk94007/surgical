<?php
/* Add any update or error notices to the top of the admin page */
function UPCP_Error_Notices(){
    global $upcp_message;
	if (isset($upcp_message)) {
		if (isset($upcp_message['Message_Type']) and $upcp_message['Message_Type'] == "Update") {echo "<div class='updated'><p>" . $upcp_message['Message'] . "</p></div>";}
		if (isset($upcp_message['Message_Type']) and $upcp_message['Message_Type'] == "Error") {echo "<div class='error'><p>" . $upcp_message['Message'] . "</p></div>";}
	}

	if( get_transient( 'upcp-admin-install-notice' ) ){ ?>
		<div class="updated notice is-dismissible">
            <p>Head over to the <a href="admin.php?page=UPCP-options">Ultimate Product Catalog Dashboard</a> to get started using the plugin!</p>
        </div>

        <?php
        delete_transient( 'upcp-admin-install-notice' );
	}

	$Ask_Review_Date = get_option('UPCP_Ask_Review_Date');
	if ($Ask_Review_Date == "") {$Ask_Review_Date = get_option("UPCP_Install_Time") + 3600*24*4;}

	if ($Ask_Review_Date < time() and get_option("UPCP_Install_Time") < time() - 3600*24*4) { ?>

		<div class='notice notice-info is-dismissible ewd-upcp-main-dashboard-review-ask' style='display:none'>
			<div class='ewd-upcp-review-ask-plugin-icon'></div>
			<div class='ewd-upcp-review-ask-text'>
				<p class='ewd-upcp-review-ask-starting-text'>Enjoying using the Ultimate Product Catalog plugin?</p>
				<p class='ewd-upcp-review-ask-feedback-text upcp-hidden'>Help us make the plugin better! Please take a minute to rate the plugin. Thanks!</p>
				<p class='ewd-upcp-review-ask-review-text upcp-hidden'>Please let us know what we could do to make the plugin better!<br /><span>(If you would like a response, please include your email address.)</span></p>
				<p class='ewd-upcp-review-ask-thank-you-text upcp-hidden'>Thank you for taking the time to help us!</p>
			</div>
			<div class='ewd-upcp-review-ask-actions'>
				<div class='ewd-upcp-review-ask-action ewd-upcp-review-ask-not-really ewd-upcp-review-ask-white'>Not Really</div>
				<div class='ewd-upcp-review-ask-action ewd-upcp-review-ask-yes ewd-upcp-review-ask-green'>Yes!</div>
				<div class='ewd-upcp-review-ask-action ewd-upcp-review-ask-no-thanks ewd-upcp-review-ask-white upcp-hidden'>No Thanks</div>
				<a href='https://wordpress.org/support/plugin/ultimate-product-catalogue/reviews/?filter=5' target='_blank'>
					<div class='ewd-upcp-review-ask-action ewd-upcp-review-ask-review ewd-upcp-review-ask-green upcp-hidden'>OK, Sure</div>
				</a>
			</div>
			<div class='ewd-upcp-review-ask-feedback-form upcp-hidden'>
				<div class='ewd-upcp-review-ask-feedback-explanation'>
					<textarea></textarea>
				</div>
				<div class='ewd-upcp-review-ask-send-feedback ewd-upcp-review-ask-action ewd-upcp-review-ask-green'>Send Feedback</div>
			</div>
			<div class='ewd-upcp-clear'></div>
		</div>

		<?php
	}

}

