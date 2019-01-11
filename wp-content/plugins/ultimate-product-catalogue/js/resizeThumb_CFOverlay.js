function customFieldOverlay () {

	 jQuery('.upcp-thumb-item').each(function (index, value) { 
	jQuery(this).find('.upcp-custom-field-thumbs').appendTo(jQuery(this).find('.upcp-thumb-image-div'));
	jQuery(this).find('.upcp-thumb-price').appendTo(jQuery(this).find('.upcp-custom-field-thumbs'));
	});

	jQuery('.upcp-detail-item').each(function (index, value) { 
	jQuery(this).find('.upcp-custom-field-details').appendTo(jQuery(this).find('.upcp-detail-image-div'));
	jQuery(this).find('.upcp-detail-price').appendTo(jQuery(this).find('.upcp-custom-field-details'));
	jQuery(this).find('.prod-cat-end-detail-div').remove();
	});
	jQuery('.upcp-list-item').each(function (index, value) { 
	jQuery(this).find('.upcp-custom-field-list').appendTo(jQuery(this).find('.upcp-list-image-div'));
	});

	jQuery('.upcp-prod-desc-custom-fields').hover(
		function(){jQuery(this).addClass('upcp-hover-visible');}, 
		function(){jQuery(this).removeClass('upcp-hover-visible');});

	jQuery('.upcp-thumb-item').hover(
		function(){jQuery(this).find('.upcp-thumb-title').addClass('upcp-hover-visible');}, 
		function(){jQuery(this).find('.upcp-thumb-title').removeClass('upcp-hover-visible');});

	jQuery(window).resize(function() { resizeThumbOverlay(); });
};
