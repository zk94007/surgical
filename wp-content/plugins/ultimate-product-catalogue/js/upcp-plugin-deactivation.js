jQuery(function($){
	var $deactivateLink = $('#the-list').find('[data-slug="ultimate-product-catalogue"] span.deactivate a'),
		$overlay        = $('#upcp-deactivate-survey-ultimate-faqs'),
		$form           = $overlay.find('form'),
		formOpen        = false;
	// Plugin listing table deactivate link.
	$deactivateLink.on('click', function(event) {
		event.preventDefault();
		$overlay.css('display', 'table');
		formOpen = true;
		$form.find('.upcp-deactivate-survey-option:first-of-type input[type=radio]').focus();
	});
	// Survey radio option selected.
	$form.on('change', 'input[type=radio]', function(event) {
		event.preventDefault();
		$form.find('input[type=text], .error').hide();
		$form.find('.upcp-deactivate-survey-option').removeClass('selected');
		$(this).closest('.upcp-deactivate-survey-option').addClass('selected').find('input[type=text]').show();
	});
	// Survey Skip & Deactivate.
	$form.on('click', '.upcp-deactivate-survey-deactivate', function(event) {
		event.preventDefault();
		location.href = $deactivateLink.attr('href');
	});
	// Survey submit.
	$form.submit(function(event) {
		event.preventDefault();
		if (! $form.find('input[type=radio]:checked').val()) {
			$form.find('.upcp-deactivate-survey-footer').prepend('<span class="error">Please select an option below</span>');
			return;
		}
		var data = {
			code: $form.find('.selected input[type=radio]').val(),
			reason: $form.find('.selected .upcp-deactivate-survey-option-reason').text(),
			details: $form.find('.selected input[type=text]').val(),
			site: upcp_deactivation_data.site_url,
			plugin: 'Ultimate Product Catalog'
		}
		var submitSurvey = $.post('https://www.etoilewebdesign.com/UPCP-Key-Check/Deactivation_Surveys.php', data);
		submitSurvey.always(function() {
			location.href = $deactivateLink.attr('href');
		});
	});
	// Exit key closes survey when open.
	$(document).keyup(function(event) {
		if (27 === event.keyCode && formOpen) {
			$overlay.hide();
			formOpen = false;
			$deactivateLink.focus();
		}
	});
});