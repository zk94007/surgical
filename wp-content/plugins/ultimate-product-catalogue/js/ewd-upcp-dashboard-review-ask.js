jQuery(document).ready(function($) {
	jQuery('.ewd-upcp-main-dashboard-review-ask').css('display', 'block');

	jQuery('.ewd-upcp-main-dashboard-review-ask').on('click', function(event) {
		if (jQuery(event.srcElement).hasClass('notice-dismiss')) {
			var data = 'Ask_Review_Date=3&action=ewd_upcp_hide_review_ask';
        	jQuery.post(ajaxurl, data, function() {});
        }
	});

	jQuery('.ewd-upcp-review-ask-yes').on('click', function() {
		jQuery('.ewd-upcp-review-ask-feedback-text').removeClass('upcp-hidden');
		jQuery('.ewd-upcp-review-ask-starting-text').addClass('upcp-hidden');

		jQuery('.ewd-upcp-review-ask-no-thanks').removeClass('upcp-hidden');
		jQuery('.ewd-upcp-review-ask-review').removeClass('upcp-hidden');

		jQuery('.ewd-upcp-review-ask-not-really').addClass('upcp-hidden');
		jQuery('.ewd-upcp-review-ask-yes').addClass('upcp-hidden');

		var data = 'Ask_Review_Date=7&action=ewd_upcp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-upcp-review-ask-not-really').on('click', function() {
		jQuery('.ewd-upcp-review-ask-review-text').removeClass('upcp-hidden');
		jQuery('.ewd-upcp-review-ask-starting-text').addClass('upcp-hidden');

		jQuery('.ewd-upcp-review-ask-feedback-form').removeClass('upcp-hidden');
		jQuery('.ewd-upcp-review-ask-actions').addClass('upcp-hidden');

		var data = 'Ask_Review_Date=7&action=ewd_upcp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-upcp-review-ask-no-thanks').on('click', function() {
		var data = 'Ask_Review_Date=1000&action=ewd_upcp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-upcp-main-dashboard-review-ask').css('display', 'none');
	});

	jQuery('.ewd-upcp-review-ask-review').on('click', function() {
		jQuery('.ewd-upcp-review-ask-feedback-text').addClass('upcp-hidden');
		jQuery('.ewd-upcp-review-ask-thank-you-text').removeClass('upcp-hidden');

		var data = 'Ask_Review_Date=1000&action=ewd_upcp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
	});

	jQuery('.ewd-upcp-review-ask-send-feedback').on('click', function() {
		var Feedback = jQuery('.ewd-upcp-review-ask-feedback-explanation textarea').val();
		var data = 'Feedback=' + Feedback + '&action=ewd_upcp_send_feedback';
        jQuery.post(ajaxurl, data, function() {});

        var data = 'Ask_Review_Date=1000&action=ewd_upcp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});

        jQuery('.ewd-upcp-review-ask-feedback-form').addClass('upcp-hidden');
        jQuery('.ewd-upcp-review-ask-review-text').addClass('upcp-hidden');
        jQuery('.ewd-upcp-review-ask-thank-you-text').removeClass('upcp-hidden');
	});
});