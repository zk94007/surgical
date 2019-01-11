var Filtering_Running = "No";

jQuery(document).ready(function(){
	jQuery('.ewd-upcp-filtering-toggle').click(function(){
		if(jQuery('.ewd-upcp-filtering-toggle').hasClass('ewd-upcp-filtering-toggle-downcaret')){
			jQuery('.ewd-upcp-filtering-toggle').removeClass('ewd-upcp-filtering-toggle-downcaret');
			jQuery('.ewd-upcp-filtering-toggle').addClass('ewd-upcp-filtering-toggle-upcaret');
			jQuery('.prod-cat-sidebar').removeClass('prod-cat-sidebar-hidden');
		}
		else{
			jQuery('.ewd-upcp-filtering-toggle').addClass('ewd-upcp-filtering-toggle-downcaret');
			jQuery('.ewd-upcp-filtering-toggle').removeClass('ewd-upcp-filtering-toggle-upcaret');
			jQuery('.prod-cat-sidebar').addClass('prod-cat-sidebar-hidden');
		}
	});

	var thumbContainerWidth = 0,thumbContainerHeight = 0,thumbHolderWidth = 0,thumbImageWidth = 0,thumbImageHeight = 0,numberOfImages = 0;
	var thumbnailHolderContainer,thumbnailControls;

	jQuery(".jquery-prod-cat-value").change(function(){
		var CatValues = [];
		jQuery('.jquery-prod-cat-value').each(function() {if (jQuery(this).prop('checked')) {CatValues.push(jQuery(this).val());}});
		jQuery('#upcp-selected-categories').val(CatValues);
		UPCP_Dynamic_Disabling(CatValues);
	});
	jQuery(".upcp-jquery-cat-dropdown").change(function() {
		var CatValues = [];
		if (jQuery(this).val() != 'All') {CatValues.push(jQuery(this).val());}
		jQuery('#upcp-selected-categories').val(CatValues);
		UPCP_Dynamic_Disabling(CatValues);
	});
	jQuery(".jquery-prod-sub-cat-value").change(function(){
		var SubCatValues = [];
		jQuery('.jquery-prod-sub-cat-value').each(function() {if (jQuery(this).prop('checked')) {SubCatValues.push(jQuery(this).val());}});
		jQuery('#upcp-selected-subcategories').val(SubCatValues);
	});
	jQuery(".jquery-prod-tag-value").change(function(){
		var TagValues = [];
		jQuery('.jquery-prod-tag-value').each(function() {if (jQuery(this).prop('checked')) {TagValues.push(jQuery(this).val());}});
		jQuery('#upcp-selected-tags').val(TagValues);
	});
	jQuery(".jquery-prod-name-text").keyup(function(){
		var prod_name = jQuery(this).val();
		jQuery('#upcp-selected-prod-name').val(prod_name);
	});

	screenshotThumbHolderWidth();
	jQuery('.upcp-catalogue-link ').hover(
		function(){jQuery(this).children('.upcp-prod-desc-custom-fields').fadeIn(400);},
		function(){jQuery(this).children('.upcp-prod-desc-custom-fields').fadeOut(400);}
	);
	jQuery('.upcp-minimal-img-div').hover(
		function(){jQuery(this).children('.upcp-prod-desc-custom-fields').fadeIn(400);},
		function(){jQuery(this).children('.upcp-prod-desc-custom-fields').fadeOut(400);}
	);

	var heights = jQuery('.upcp-minimal-product-listing').map(function ()
	{
	    return jQuery(this).height();
	}).get(),
	maxWidgetHeight = Math.max.apply(null, heights);

	jQuery('.upcp-minimal-product-listing').each(function (index, value) {
	jQuery(this).height(maxWidgetHeight);
	});

	jQuery('.upcp-tab-slide').on('click', function(event) {
		jQuery('.upcp-tabbed-tab').each(function() {jQuery(this).addClass('upcp-Hide-Item');});
		jQuery('.upcp-tabbed-layout-tab').each(function() {jQuery(this).addClass('upcp-tab-layout-tab-unclicked');});
		var TabClass = jQuery(this).data('class');
		jQuery('.'+TabClass).removeClass('upcp-Hide-Item');
		jQuery('.'+TabClass+'-menu').removeClass('upcp-tab-layout-tab-unclicked');
		event.preventDefault;
	});

	jQuery('.upcp-tabbed-button-left').on('click', function() {
		jQuery('.upcp-scroll-list li:first').before(jQuery('.upcp-scroll-list li:last'));
		jQuery('.upcp-scroll-list').animate({left:'-=117px'}, 0);
		jQuery('.upcp-scroll-list').animate({left:'+=117px'}, 600);
	});
	jQuery('.upcp-tabbed-button-right').on('click', function() {
		jQuery('.upcp-scroll-list').animate({left:'-=117px'}, 600, function() {
			jQuery('.upcp-scroll-list li:last').after(jQuery('.upcp-scroll-list li:first'));
			jQuery('.upcp-scroll-list').animate({left:'+=117px'}, 0);
		});
	});

	jQuery('.upcp-filtering-clear-all').on('click', function() {clearAllFilteringSelections();});

	jQuery('#upcp-name-search').on('keyup', function() {jQuery('.upcp-filtering-clear-all').removeClass('upcp-Hide-Item');});
	jQuery('.jquery-prod-cat-value, .jquery-prod-sub-cat-value, .jquery-prod-tag-value, .jquery-prod-cf-value').on('change', function() {jQuery('.upcp-filtering-clear-all').removeClass('upcp-Hide-Item');});
	jQuery('.upcp-jquery-cat-dropdown, .upcp-jquery-subcat-dropdown, .upcp-jquery-tags-dropdown, .jquery-prod-cf-select').on('change', function() {jQuery('.upcp-filtering-clear-all').removeClass('upcp-Hide-Item');});
	

	jQuery(window).resize(function() {adjustCatalogueHeight();});

	UPCP_Infinite_Scroll();
	addClickHandlers();
	addLightboxHandlers();
	addProductcomparisonClickHandlers();
	UPCP_Setup_Price_Slider();
	adjustCatalogueHeight();
	adjustThumbnailHeights();
	addInquiryAndCartHandlers();
});

function UPCP_Dynamic_Disabling(CatValues) {
	if (CatValues.length === 0) {jQuery('.jquery-prod-sub-cat-value').prop('disabled', false);}
	else {
		jQuery('.jquery-prod-sub-cat-value').prop('disabled', true);
		jQuery('.jquery-prod-sub-cat-value').each(function() {
			if (jQuery.inArray(jQuery(this).data('parent') + "", CatValues) !== -1) {jQuery(this).prop('disabled', false);}
			else {jQuery(this).parent().removeClass('highlightBlack');}
		});
		jQuery('.jquery-prod-sub-cat-value').each(function() {
			if (jQuery(this).prop('disabled')) {jQuery(this).prop('checked', false).trigger('change');}
		});
		UPCP_Ajax_Filter();
	}
}

function UPCP_Infinite_Scroll() {
	if (jQuery('.prod-cat-inner').hasClass('upcp-infinite-scroll')) {
		jQuery(window).scroll(function(){
			var InfinitePos = jQuery('.upcp-infinite-scroll-content-area').position();
			if (InfinitePos != undefined && jQuery('#upcp-max-page').html() != parseInt(jQuery('#upcp-current-page').html())) {
				if  ((jQuery(window).height() + jQuery(window).scrollTop() > InfinitePos.top) && Filtering_Running == "No"){
					jQuery('#upcp-current-page').html(Math.min(jQuery('#upcp-max-page').html(), parseInt(jQuery('#upcp-current-page').html())+1));
					Filtering_Running = "Yes";
					var AddResults = "Yes";
					UPCP_Ajax_Filter(AddResults);
				}
			}
		});
	}
}

function addLightboxHandlers() {
	jQuery('.prod-cat-item.upcp-lightbox-mode').on('click', function(event) {
		var Item_ID = jQuery(this).data('itemid');
		var Product_Item = jQuery('#prod-cat-list-item-'+Item_ID);

		if (jQuery(event.target).hasClass('upcp-list-title')) {return;}

		jQuery('#upcp-lightbox-div').css('display', 'inline');
		jQuery('#upcp-lightbox-background-div').css('display', 'inline');
		jQuery('#upcp-lightbox-div-img').attr('src', jQuery(Product_Item).find('.prod-cat-thumb-image').attr('src'));
		jQuery('#upcp-lightbox-title-div').html(jQuery(Product_Item).find('.prod-cat-title').html());
		jQuery('#upcp-lightbox-price-div').html(jQuery(Product_Item).find('.prod-cat-price').html());
		jQuery('#upcp-lightbox-description-div').html(jQuery(Product_Item).find('.prod-cat-desc').html());
		jQuery('#upcp-lightbox-link-container-div a').attr('href', jQuery(Product_Item).find('.upcp-catalogue-link').attr('href'));
	});

	jQuery('#upcp-lightbox-background-div').on('click.closeLightboxMode', function() {
		jQuery('#upcp-lightbox-div').css('display', 'none');
		jQuery('#upcp-lightbox-background-div').css('display', 'none');
	});
}

function screenshotThumbHolderWidth(){
	var screenshotImage = jQuery('.prod-cat-addt-details-thumbs-div img:first-child');
	var thumbnailHolderContainer = jQuery('.game-thumbnail-holder');

	thumbImageWidth = screenshotImage.width();
	thumbImageHeight = screenshotImage.height();
	numberOfImages = jQuery('.prod-cat-addt-details-thumb').length;
	thumbContainerWidth = (thumbImageWidth+20)*numberOfImages;
	thumbnailHolderContainerW = thumbnailHolderContainer.width();
	thumbnailControls = jQuery('.thumbnail-control');
	//jQuery('.prod-cat-addt-details-thumbs-div').css({width:thumbContainerWidth,height:thumbImageHeight+20,position:"absolute",top:0,left:0});
	//jQuery(thumbnailHolderContainer).css({minHeight:thumbImageHeight+20,width:thumbContainerWidth});

	if(thumbContainerWidth > thumbnailHolderContainerW){
		thumbnailControls.show();
		var tnScrollerW = jQuery(".thumbnail-scroller").width();
		var tnHolderDiv = jQuery(".prod-cat-addt-details-thumbs-div").width();
		var tnScrollLimit = -tnHolderDiv + tnScrollerW + thumbImageWidth;
		jQuery('.thumbnail-nav-left').click(function(){
			var tnContainerPos = thumbnailHolderContainer.position();
			var tnContainerXPos = tnContainerPos.left;
			if(tnContainerXPos >= tnScrollLimit){
				var scrollThumbnails = tnContainerXPos - (thumbImageWidth+20);
				jQuery(thumbnailHolderContainer).animate({left:scrollThumbnails});
				jQuery('.thumbnail-nav-right').show();
			}else if(tnContainerXPos <= tnScrollLimit){
				jQuery(this).hide();
			};
		});
		jQuery('.thumbnail-nav-right').click(function(){
			var tnContainerPos = thumbnailHolderContainer.position();
			var tnContainerXPos = tnContainerPos.left;
			if(tnContainerXPos != 0){
				var scrollThumbnails = tnContainerXPos + (thumbImageWidth+20);
				jQuery(thumbnailHolderContainer).animate({left:scrollThumbnails});
				jQuery('.thumbnail-nav-left').show();
			}else if(tnContainerXPos == 0){
				jQuery(this).hide();
			}
		});
	};
};

function additionalThemeJS() {
	try{
		upcp_style_hover();
	}
	catch(e) {
	}
}

function addClickHandlers() {
	if (typeof maintain_filtering === 'undefined' || maintain_filtering === null) {maintain_filtering = "Yes";}

	if (maintain_filtering != "No") {
		jQuery(".upcp-catalogue-link").click(function(event){
			event.preventDefault();
    		var link = jQuery(this).attr('href');
    		jQuery("#upcp-hidden-filtering-form").attr('action', link);

    		if (jQuery('.upcp-lightbox-mode').length) {return;}

    		jQuery("#upcp-hidden-filtering-form").submit();
		});
	}
	additionalThemeJS();
}

function FieldFocus (Field) {
		if (Field.value == Field.defaultValue){
			  Field.value = '';
		}
}

function FieldBlur(Field) {
		if (Field.value == '') {
			  Field.value = Field.defaultValue;
		}
}

function UPCPHighlight(Field, Color) {
	var inputType = jQuery(Field).attr('name');
	jQuery('input[name="' + inputType + '"][type="radio"]').each(function(){jQuery(this).parent().removeClass('highlight' + Color)});

	if (jQuery(Field.parentNode).hasClass('highlight'+Color)) {
		  jQuery(Field.parentNode).removeClass('highlight'+Color);
	}
	else {
			jQuery(Field.parentNode).addClass('highlight'+Color);
	}
}

function UPCP_DisplayPage(PageNum) {
	jQuery('#upcp-selected-current-page').val(PageNum);
	jQuery('#upcp-current-page').html(PageNum);
	UPCP_Ajax_Filter();
}

function UPCP_Show_Hide_CF(cf_title) {
	var CFID = jQuery(cf_title).data('cfid');

	jQuery('.prod-cat-sidebar-cf-content').each(function() {
		if (jQuery(this).data('cfid') == CFID) {
			jQuery(this).slideToggle('1000', 'swing');
		}
	});
}

function UPCP_Show_Hide_Sidebar(sidebar_title) {
	var TITLE = jQuery(sidebar_title).data('title');

	jQuery('.prod-cat-sidebar-content').each(function() {
	if(jQuery(this).data('title') == TITLE) {
		jQuery(this).slideToggle('1000', 'swing');
	}
	});
}

function UPCP_Show_Hide_Subcat(sidebar_category) {
	jQuery('#subcat-collapsible-'+sidebar_category).slideToggle('1000', 'swing');
	  jQuery('#cat-collapsible-'+sidebar_category).toggleClass("clicked");
        if ( jQuery('#cat-collapsible-'+sidebar_category).hasClass("clicked") ) {
            jQuery('#cat-collapsible-'+sidebar_category).text("-");
        }
        else {
            jQuery('#cat-collapsible-'+sidebar_category).text("+");
        }
}

var RequestCount = 0;
function UPCP_Ajax_Filter(AddResults) {
	var CatValues = [];
	var SubCatValues = [];
	var TagBoxValues = [];
	var CFBoxValues = [];

	var id = jQuery('#upcp-catalogue-id').html();
	var sidebar = jQuery('#upcp-catalogue-sidebar').html();
	var start_layout = jQuery('#upcp-starting-layout').html();
	var current_layout = jQuery('#upcp-current-layout').html();
	var excluded_layouts = jQuery('#upcp-excluded-layouts').html();
	var current_page = jQuery('#upcp-current-page').html();
	var products_per_page = jQuery('#upcp-products-per-page').html();
	var base_url = jQuery('#upcp-base-url').html();
	var default_search_text = jQuery('#upcp-default-search-text').html();

	var values = jQuery('#upcp-price-score-filter').slider("option", "values");
	var min_price = values[0];
	var max_price = values[1];
	if (min_price == undefined) {min_price = 0;}
	if (max_price == undefined) {max_price = 10000000;}

	jQuery('.jquery-prod-cat-value').each(function() {if (jQuery(this).prop('checked')) {CatValues.push(jQuery(this).val());}});
	jQuery('.upcp-jquery-cat-dropdown').each(function() {if (jQuery(this).val() != "All") {CatValues.push(jQuery(this).val());}});
	jQuery('.jquery-prod-sub-cat-value').each(function() {if (jQuery(this).prop('checked')) {SubCatValues.push(jQuery(this).val());}});
	jQuery('.upcp-jquery-subcat-dropdown').each(function() {if (jQuery(this).val() != "All") {SubCatValues.push(jQuery(this).val());}});
	jQuery('.jquery-prod-tag-value').each(function() {if (jQuery(this).prop('checked')) {TagBoxValues.push(jQuery(this).val());}});
	jQuery('.upcp-jquery-tags-dropdown').each(function() {if (jQuery(this).val() != "All") {TagBoxValues.push(jQuery(this).val());}});
	jQuery('.jquery-prod-cf-value').each(function() {if (jQuery(this).prop('checked')) {
		Array_Value = jQuery(this).parent().parent().data('cfid') + "=" + jQuery(this).val();
		CFBoxValues.push(Array_Value);
	}});
	jQuery('.jquery-prod-cf-select').each(function() {if (jQuery(this).val() != "All") {
		Array_Value = jQuery(this).data('fieldid') + "=" + jQuery(this).val();
		CFBoxValues.push(Array_Value);
	}});
	jQuery('.jquery-prod-cf-select').each(function() {if (jQuery(this).val() != "All") {
		Array_Value = jQuery(this).data('fieldid') + "=" + jQuery(this).val();
		CFBoxValues.push(Array_Value);
	}});
	jQuery('.jquery-prod-cf-select').each(function() {if (jQuery(this).val() != "All") {
		Array_Value = jQuery(this).data('fieldid') + "=" + jQuery(this).val();
		CFBoxValues.push(Array_Value);
	}});
	jQuery('.upcp-custom-field-slider').each(function() {
    	var Field_ID = jQuery(this).data("fieldid");

    	var Array_Value = Field_ID + "=" + jQuery("#upcp-custom-field-"+Field_ID).slider("values", 0);
    	CFBoxValues.push(Array_Value);
    	var Array_Value = Field_ID + "=" + jQuery("#upcp-custom-field-"+Field_ID).slider("values", 1);
    	CFBoxValues.push(Array_Value);
    });

	if (jQuery('.prod-cat-sidebar').css('display') == "none") {var SelectedProdName = jQuery('#upcp-mobile-search').val();}
	else {var SelectedProdName = jQuery('#upcp-name-search').val();}

	if (SelectedProdName == undefined) {SelectedProdName = default_search_text;}

	if (AddResults == "Yes") {jQuery('.upcp-infinite-scroll-content-area').html('<h3>'+ajax_translations.updating_results_label+'</h3>');}
	else {jQuery('.prod-cat-inner').html('<h3>'+ajax_translations.updating_results_label+'</h3>');}
	RequestCount = RequestCount + 1;
	var data = 'id=' + id + '&sidebar=' + sidebar + '&start_layout=' + current_layout + '&excluded_layouts=' + excluded_layouts + '&ajax_url=' + base_url + '&current_page=' + current_page + '&products_per_page=' + products_per_page + '&default_search_text=' + default_search_text + '&ajax_reload=Yes' + '&Prod_Name=' + SelectedProdName + '&max_price=' + max_price + '&min_price=' + min_price + '&Category=' + CatValues + '&SubCategory=' + SubCatValues + '&Tags=' + TagBoxValues + '&Custom_Fields=' + encodeURIComponent(CFBoxValues) + '&request_count=' + RequestCount + '&action=update_catalogue';
	jQuery.post(ajaxurl, data, function(response) {
		var parsed_response = jQuery.parseJSON(response);
		if (parsed_response.request_count == RequestCount) {

			if (AddResults == "Yes") {jQuery('.upcp-infinite-scroll-content-area').replaceWith(parsed_response.message);}
			else {jQuery('.prod-cat-inner').html(parsed_response.message);}
			if (CatValues.length == 0 && SubCatValues.length == 0 && TagBoxValues.length == 0 && CFBoxValues.length == 0) {jQuery('.prod-cat-category-label').each(function() {jQuery(this).removeClass('Hide-Item');});}
			if (jQuery('#upcp-sort-by').val() != "" && jQuery('#upcp-sort-by').val() != undefined) {UPCP_Sort_By();}
			adjustCatalogueHeight();
			adjustThumbnailHeights();
			addClickHandlers();
			addLightboxHandlers();
			addProductcomparisonClickHandlers();
			addInquiryAndCartHandlers();
			UPCP_Infinite_Scroll();
			UPCP_Adjust_Sidebar_Counts(min_price, max_price, CatValues, SubCatValues, TagBoxValues, CFBoxValues);
			Filtering_Running = "No";
		}
	});
}

function clearAllFilteringSelections() {
	jQuery('.upcp-filtering-clear-all').addClass('upcp-Hide-Item');

	jQuery('#upcp-name-search').val('');
	jQuery("#upcp-price-score-filter").slider("values", 0, min_price);
	jQuery("#upcp-price-score-filter").slider("values", 1, max_price);
	jQuery('.jquery-prod-cat-value, .jquery-prod-sub-cat-value, .jquery-prod-tag-value, .jquery-prod-cf-value').prop('checked', false).parent().removeClass('highlightBlack').removeClass('highlightBlue').removeClass('highlightGrey');
	jQuery('.upcp-jquery-cat-dropdown, .upcp-jquery-subcat-dropdown, .upcp-jquery-tags-dropdown, .jquery-prod-cf-select').val('All');
	jQuery('.upcp-custom-field-slider').each(function() {
		var Field_ID = jQuery(this).data('fieldid');
		max_value_int = parseInt(window['max_'+Field_ID]); 
		min_value_int = parseInt(window['min_'+Field_ID]);
		jQuery("#upcp-custom-field-"+Field_ID).slider("values", [min_value_int, max_value_int]);
	});

	UPCP_Ajax_Filter();
}

function addProductcomparisonClickHandlers() {
	jQuery('.upcp-product-comparison-button').on('click', function() {
		var thisComparisonButton = jQuery(this);
		var Prod_ID = jQuery(this).data('prodid');
		var Prod_Name = jQuery(this).data('prodname');

		var input = jQuery('#upcp-product-comparison-form').find('input#upcp-pc-id'+Prod_ID);
		if (!thisComparisonButton.hasClass('comparisonClicked')) {
			thisComparisonButton.addClass('comparisonClicked');
			if (input.length == 0) {
				jQuery('<input>').attr({
				    type: 'hidden',
				    id: 'upcp-pc-id'+Prod_ID,
				    name: 'Comparison_Product_ID[]',
				    value: Prod_ID
				}).data('prodname', Prod_Name).appendTo('#upcp-product-comparison-form');
			}
		}
		else {
			thisComparisonButton.removeClass('comparisonClicked');
			jQuery(input.selector).remove();
			jQuery('#upcp-product-comparison-form .upcp-prod-comp-submit-instructions').remove();
		}

		if (jQuery('#upcp-product-comparison-form').find('input').length >= 2) {
			jQuery('.upcp-prod-comp-submit-instructions').remove();
			var Product_Name_String = "";
			jQuery('#upcp-product-comparison-form input').each(function(index, el) {
				Product_Name_String += jQuery(this).data('prodname') + ", ";
			});
			Product_Name_String = Product_Name_String.slice(0, -2);
			var replacement = " and";
			Product_Name_String = Product_Name_String.replace(/,([^,]*)$/,replacement+'$1');
			jQuery('#upcp-product-comparison-form').append('<div class="upcp-prod-comp-submit-instructions">' + ajax_translations.compare_label + ' ' + Product_Name_String + ' ' + ajax_translations.side_by_side_label + '!<input type="submit" value="' + ajax_translations.compare_label + '" /></div>');

			adjustCatalogueHeight();
		}


		if (jQuery('#upcp-product-comparison-form').find('input').length == 3) {
			window.scrollTo(window.scrollX, jQuery('.upcp-prod-comp-submit-instructions').offset().top - 40);
		}
	})
}

function UPCP_Setup_Price_Slider() {
	if (typeof max_price === 'undefined' || max_price === null) {max_price = 10000000;}
	if (typeof min_price === 'undefined' || min_price === null) {min_price = 0;}
	if (typeof currency_symbol === 'undefined' || currency_symbol === null) {currency_symbol = '';}
	if (typeof symbol_position === 'undefined' || symbol_position === null) {symbol_position = 'Before';}

	max_price_int = parseInt(max_price);
	min_price_int = parseInt(min_price);

	jQuery("#upcp-price-score-filter").slider({
    	range: true,
    	min: min_price_int,
    	max: max_price_int,
    	values: [ min_price_int, max_price_int ],
        change: function( event, ui ) {
        	jQuery('.upcp-filtering-clear-all').removeClass('upcp-Hide-Item');
        	jQuery('#upcp-current-page').html("1");
        	jQuery(".upcp-price-slider-min").val(ui.values[ 0 ]);
        	jQuery(".upcp-price-slider-max").val(ui.values[ 1 ]);
        	UPCP_Ajax_Filter();
        }
    });

    jQuery('.upcp-price-slider-min').on('keyup', function() {
    	jQuery("#upcp-price-score-filter").slider('values', 0, jQuery(this).val());
    });

    jQuery('.upcp-price-slider-max').on('keyup', function() {
    	jQuery("#upcp-price-score-filter").slider('values', 1, jQuery(this).val());
    });

    jQuery('.upcp-custom-field-slider').each(function() {
    	var Field_ID = jQuery(this).data("fieldid");

    	max_value_int = parseInt(jQuery(this).data('maxvalue'));
		min_value_int = parseInt(jQuery(this).data('minvalue'));

    	jQuery("#upcp-custom-field-"+Field_ID).slider({
    		range: true,
    		min: min_value_int,
    		max: max_value_int,
    		values: [ min_value_int, max_value_int ],
    	    change: function( event, ui ) {
    	       jQuery('.upcp-filtering-clear-all').removeClass('upcp-Hide-Item');
    	       jQuery(".upcp-custom-field-slider-min[data-fieldid='"+Field_ID+"']").val(ui.values[ 0 ]);
    	       jQuery(".upcp-custom-field-slider-max[data-fieldid='"+Field_ID+"']").val(ui.values[ 1 ]);
    	       UPCP_Ajax_Filter();
    	    }
    	});
    });

    jQuery(".upcp-custom-field-slider-min").on('keyup', function() {
    	var Field_ID = jQuery(this).data('fieldid');
    	jQuery(".upcp-custom-field-slider[data-fieldid='"+Field_ID+"']").slider('values', 0, jQuery(this).val());
    });

    jQuery(".upcp-custom-field-slider-max").on('keyup', function() {
    	var Field_ID = jQuery(this).data('fieldid');
    	jQuery(".upcp-custom-field-slider[data-fieldid='"+Field_ID+"']").slider('values', 1, jQuery(this).val());
    });
}

/* Used in the bare-list layout to show or hide extra product details */
function ToggleItem(Item_ID) {
	if (jQuery('#prod-cat-title-'+Item_ID+'.upcp-list-title').hasClass('upcp-list-action-Product')) {
		if (jQuery('.upcp-lightbox-mode').length) {return;}

		var product_page = jQuery('#prod-cat-details-'+Item_ID).find('.upcp-catalogue-link').attr('href');
		window.location.href = product_page;
		return;
	}

	if (jQuery('#prod-cat-details-'+Item_ID).css('display') == "none") {
		jQuery('#prod-cat-details-'+Item_ID).removeClass('hidden-field');
		adjustCatalogueHeight();
	}
	else {
		jQuery('#prod-cat-details-'+Item_ID).addClass('hidden-field');
		adjustCatalogueHeight();
	}
}

/* Used to track the number of times that a product is clicked in all catalogues */
function RecordView(Item_ID) {
		var data = 'Item_ID=' + Item_ID + '&action=record_view';
		jQuery.post(ajaxurl, data, function(response) {});
}

function ToggleView(DisplayType) {

		if (DisplayType == "Thumbnail" && jQuery('.thumb-display').hasClass('hidden-field')) {
			  jQuery('.list-display').animate({opacity: 0}, 500);
				jQuery('.detail-display').animate({opacity: 0}, 500);
				setTimeout(function(){jQuery('.thumb-display').animate({opacity: 1}, 500);})
				jQuery('.thumb-display').removeClass('hidden-field');
				jQuery('#upcp-current-layout').html('Thumbnail');
				setTimeout(function(){jQuery('.list-display').addClass('hidden-field');})
				setTimeout(function(){jQuery('.detail-display').addClass('hidden-field');})
		}
		if (DisplayType == "List" && jQuery('.list-display').hasClass('hidden-field')) {
			  jQuery('.thumb-display').animate({opacity: 0}, 500);
				jQuery('.detail-display').animate({opacity: 0}, 500);
				setTimeout(function(){jQuery('.list-display').animate({opacity: 1}, 500);})
				jQuery('.list-display').removeClass('hidden-field');
				jQuery('#upcp-current-layout').html('List');
				setTimeout(function(){jQuery('.thumb-display').addClass('hidden-field');})
				setTimeout(function(){jQuery('.detail-display').addClass('hidden-field');})
		}
		if (DisplayType == "Detail" && jQuery('.detail-display').hasClass('hidden-field')) {
			  jQuery('.list-display').animate({opacity: 0}, 500);
				jQuery('.thumb-display').animate({opacity: 0}, 500);
				setTimeout(function(){jQuery('.detail-display').animate({opacity: 1}, 500);})
				jQuery('.detail-display').removeClass('hidden-field');
				jQuery('#upcp-current-layout').html('Detail');
				setTimeout(function(){jQuery('.list-display').addClass('hidden-field');})
				setTimeout(function(){jQuery('.thumb-display').addClass('hidden-field');})
		}

		setTimeout(function(){adjustCatalogueHeight();})

		return false;
}

function ZoomImage(ProdID, ItemID) {
	jQuery('.upcp-tabbed-video-container').addClass('upcp-Hide-Item');
	jQuery('.upcp-tabbed-image-container').removeClass('upcp-Hide-Item');
	if (ItemID == 0) {
	  PhotoSRC = jQuery('#prod-cat-addt-details-thumb-P'+ProdID).attr('src');
	}
	else {
		PhotoSRC = jQuery('#prod-cat-addt-details-thumb-'+ItemID).attr('src');
	}
	jQuery('.prod-cat-addt-details-main').each(function() {jQuery(this).attr('src', PhotoSRC)});
	jQuery('.prod-cat-addt-details-main').each(function() {jQuery(this).data('ulbsource', PhotoSRC)});
	jQuery('.prod-cat-addt-details-link-a').each(function() {jQuery(this).attr('href', PhotoSRC)});
	jQuery('.prod-cat-addt-details-link-a').each(function() {jQuery(this).data('ulbsource', PhotoSRC)});
}

jQuery(document).ready(function() {
	jQuery('.upcp-thumb-video').on('click', function(event){
		var videoID = jQuery(this).data('videoid');
		jQuery('.upcp-main-video').attr('src', 'http://www.youtube.com/embed/'+videoID);
		jQuery('.upcp-tabbed-image-container').addClass('upcp-Hide-Item');
		jQuery('.upcp-tabbed-video-container').removeClass('upcp-Hide-Item');
		if (!jQuery(this).hasClass('ewd-ulb-lightbox')) {event.preventDefault();}
	});
});

function adjustCatalogueHeight() {
 	var objHeight = 0;

    var thumbOuterHeight = 0;
    var listOuterHeight = 0;
    var detailOuterHeight = 0;
    jQuery('.prod-cat.thumb-display').each(function() {thumbOuterHeight += jQuery(this).outerHeight();});
	jQuery('.prod-cat.list-display').each(function() {listOuterHeight += jQuery(this).outerHeight();});
	jQuery('.prod-cat.detail-display').each(function() {detailOuterHeight += jQuery(this).outerHeight();});
	objHeight = Math.max(thumbOuterHeight, listOuterHeight, detailOuterHeight);

	objHeight = objHeight + 120;
    jQuery('.prod-cat-inner').height(objHeight);

    if (jQuery(window).width() <= 715) {
    	objHeight = jQuery('.prod-cat-inner').height() + jQuery('.prod-cat-sidebar').height();
    	jQuery('.prod-cat-container').height(objHeight);
	}
	else {
		objHeight = Math.max(jQuery('.prod-cat-inner').height(), jQuery('.prod-cat-sidebar').height());
		jQuery('.prod-cat-container').height(objHeight);
	}
}

function adjustThumbnailHeights() {
	var maxHeight = Math.max.apply(null, jQuery(".upcp-thumb-item.upcp-thumb-adjust-height").map(function ()
	{
	    return jQuery(this).height();
	}).get());

	jQuery('.upcp-thumb-item.upcp-thumb-adjust-height').css('height', maxHeight);
}

function addInquiryAndCartHandlers() {
	if (jQuery('.upcp-product-interest-button').length) {
		jQuery('.upcp-product-interest-button').off('click');
		jQuery('.upcp-product-interest-button').on('click', function() {
			var prod_ID = jQuery(this).data('prodid');

			jQuery('.upcp-wc-cart-div').removeClass('upcp-Hide-Item');
			jQuery('.upcp-inquire-div').removeClass('upcp-Hide-Item');

			var Item_Count = parseInt(jQuery('.upcp-cart-item-count').html());
			jQuery('.upcp-cart-item-count').html(Item_Count + 1);

			var data = 'prod_ID=' + prod_ID + '&action=upcp_add_to_cart';
    		jQuery.post(ajaxurl, data, function(response) {});
		});

		jQuery('.upcp-clear-cart').off('click');
		jQuery('.upcp-clear-cart').on('click', function() {
			jQuery('.upcp-wc-cart-div').addClass('upcp-Hide-Item');
			jQuery('.upcp-inquire-div').addClass('upcp-Hide-Item');

			jQuery('.upcp-cart-item-count').html('0');

			var data = '&action=upcp_clear_cart';
    		jQuery.post(ajaxurl, data, function(response) {});
		})
	}
}

function UPCP_Adjust_Sidebar_Counts(min_price, max_price, CatValues, SubCatValues, TagBoxValues, CFBoxValues) {
	var Decoded_Products = jQuery.parseJSON(filtering_values);

	var Selected_CustomFields = [];
	jQuery(CFBoxValues).each(function(index, el) {
		var CF_ID = el.substring(0, el.indexOf('='));
		var CF_Value = el.substring(el.indexOf('=') + 1);

		if (Selected_CustomFields[CF_ID] === undefined) {Selected_CustomFields[CF_ID] = [];}
		
		Selected_CustomFields[CF_ID].push(CF_Value);
	});
	jQuery('.upcp-custom-field-slider').each(function(index, el) {
		var CF_ID = jQuery(this).data('fieldid');
		var Min = Math.min.apply(Math, Selected_CustomFields[CF_ID]);
		var Max = Math.max.apply(Math, Selected_CustomFields[CF_ID]);
		for (i=Min+1; i<Max; i++) {Selected_CustomFields[CF_ID].push(""+i);}
	});

	var Sidebar_Counts = {"Categories" : {}, 'SubCategories' : {}, 'Tags' : {},  'CustomFields' : {}};
	jQuery(Decoded_Products).each(function(index, el) {
		if (el.Price < min_price || el.Price > max_price) {return;}

		var Missing = '';
		if (CatValues.length != 0 && jQuery.inArray(el.Category, CatValues) == -1) {Missing = (Missing == '' ? 'Category' : 'Mismatch');}
		if (SubCatValues.length != 0 && jQuery.inArray(el.SubCategory, SubCatValues) == -1) {Missing = (Missing == '' ? 'SubCategory' : 'Mismatch');}
		if (TagBoxValues.length != 0 && !el.Tags.sort().compare(TagBoxValues.sort())) {Missing = (Missing == '' ? 'Tags' : 'Mismatch');}
		if (Selected_CustomFields.length != 0){
			for (var CF_ID in Selected_CustomFields) {
				if (Selected_CustomFields[CF_ID] == undefined || !jQuery.isArray(Selected_CustomFields[CF_ID])) {continue;}
				if (jQuery.inArray(el.CustomFields[CF_ID], Selected_CustomFields[CF_ID]) == -1) {Missing = (Missing == '' ? 'CustomField_' + CF_ID : 'Mismatch');}
			}
		}
		
		if (Missing != 'Mismatch') {
			if (Missing == '' || Missing == 'Category') {
				if (Sidebar_Counts['Categories'][el.Category] === undefined) {Sidebar_Counts['Categories'][el.Category] = 1;}
				else {Sidebar_Counts['Categories'][el.Category] = Sidebar_Counts['Categories'][el.Category] + 1;}
			}
			if (Missing == '' || Missing == 'SubCategory') {
				if (Sidebar_Counts['SubCategories'][el.SubCategory] === undefined) {Sidebar_Counts['SubCategories'][el.SubCategory] = 1;}
				else {Sidebar_Counts['SubCategories'][el.SubCategory] = Sidebar_Counts['SubCategories'][el.SubCategory] + 1;}
			}
			if (Missing == '' || Missing == 'Tags') {
				jQuery(el.Tags).each(function(index, tag) {
					if (Sidebar_Counts['Tags'][tag] === undefined) {Sidebar_Counts['Tags'][tag] = 1;}
					else {Sidebar_Counts['Tags'][tag] = Sidebar_Counts['Tags'][tag] + 1;}
				});
			}
			if (Missing == '' || Missing.indexOf('CustomField') == 0) {
				if (Missing != '') {var CF_ID = Missing.substring(12);}

				for (var index in el.CustomFields) {
					if (Missing == '' || index == CF_ID) {
						if (Sidebar_Counts['CustomFields'][index] === undefined) {Sidebar_Counts['CustomFields'][index] = [];}

						if (Sidebar_Counts['CustomFields'][index][el.CustomFields[index]] === undefined) {Sidebar_Counts['CustomFields'][index][el.CustomFields[index]] = 1;}
						else {Sidebar_Counts['CustomFields'][index][el.CustomFields[index]] = Sidebar_Counts['CustomFields'][index][el.CustomFields[index]] + 1;}
					}
				};
			}
		}
	});

	jQuery('.prod-cat-sidebar-category label').each(function(index, el) {
		var ID = jQuery(this).attr('for').substring(4);
		if (Sidebar_Counts['Categories'][ID] === undefined) {
			jQuery(this).find('span span').html('(0)');
			if (ajax_translations.hide_empty == "Yes") {jQuery(this).parent().css('display', 'none');}
		}
		else {jQuery(this).parent().css('display', 'block').find('span span').html('(' + Sidebar_Counts['Categories'][ID] + ')');}
	});

	jQuery('.prod-cat-sidebar-subcategory label').each(function(index, el) {
		var ID = jQuery(this).attr('for').substring(4);
		if (Sidebar_Counts['SubCategories'][ID] === undefined) {
			jQuery(this).find('span span').html('(0)');
			if (ajax_translations.hide_empty == "Yes") {jQuery(this).parent().css('display', 'none');}
		}
		else {jQuery(this).parent().css('display', 'block').find('span span').html('(' + Sidebar_Counts['SubCategories'][ID] + ')');}
	});

	jQuery('.prod-cat-sidebar-cf-content').each(function(index, el) {
		var CF_ID = jQuery(this).data('cfid');
		if (jQuery(this).find('select').length == 0) {
			jQuery(this).find('label').each(function() {
				var CF_Value = jQuery(this).data('cf_value');
				if (Sidebar_Counts['CustomFields'][CF_ID] !== undefined && CF_Value in Sidebar_Counts['CustomFields'][CF_ID]) {jQuery(this).parent().css('display', 'block').find('span span').html('(' + Sidebar_Counts['CustomFields'][CF_ID][CF_Value] + ')');}
				else {
					jQuery(this).find('span span').html('(0)');
					if (ajax_translations.hide_empty == "Yes") {jQuery(this).parent().css('display', 'none');}
				}
			});
		}
		else {
			jQuery(this).find('option').each(function() {
				var CF_Value = jQuery(this).val(); 
				if (CF_Value != 'All' && Sidebar_Counts['CustomFields'][CF_ID] !== undefined && CF_Value in Sidebar_Counts['CustomFields'][CF_ID]) {
					var Option_Text = jQuery(this).html();
					jQuery(this).html(Option_Text.substring(0, Option_Text.indexOf('(')) + '(' + Sidebar_Counts['CustomFields'][CF_ID][CF_Value] + ')').css('display', 'inline-block');
				}
				else if (CF_Value != 'All') {
					var Option_Text = jQuery(this).html();
					jQuery(this).html(Option_Text.substring(0, Option_Text.indexOf('(')) + '(0)');
					if (ajax_translations.hide_empty == "Yes") {jQuery(this).css('display', 'none');}
				}
			});
		}
	});
}

/* Sort by price or by name */
jQuery.fn.sortElements = (function(){

    var sort = [].sort;

    return function(comparator, getSortable) {

        getSortable = getSortable || function(){return this;};

        var placements = this.map(function(){

            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,

                // Since the element itself will change position, we have
                // to have some way of storing its original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );

            return function() {

                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }

                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);

            };

        });

        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });

    };

})();

function UPCP_Sort_By() {
		jQuery('.prod-cat-category-label').each(function() {jQuery(this).addClass('Hide-Item');});
		var SortBy = jQuery('#upcp-sort-by').val();
		if (SortBy == "name_asc") {SortByNameASC();}
		else if (SortBy == "name_desc") {SortByNameDESC();}
		else if (SortBy == "price_asc") {SortByPriceASC();}
		else if (SortBy == "price_desc") {SortByPriceDESC();}
		else if (SortBy == "rating_asc") {SortByRatingASC();}
		else {SortByRatingDESC();}
}

function SortByNameASC() {
        jQuery('.thumb-display div .prod-cat-title').sortElements(function(a, b){
						return jQuery(a).text() > jQuery(b).text() ? 1 : -1;
        }, function() {
						return this.parentNode; //here
				});
				jQuery('.list-display div .prod-cat-title').sortElements(function(a, b){
						return jQuery(a).text() > jQuery(b).text() ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.detail-display div .prod-cat-title').sortElements(function(a, b){
						return jQuery(a).text() > jQuery(b).text() ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode.parentNode; //here
				});
}

function SortByNameDESC() {
        jQuery('.thumb-display div .prod-cat-title').sortElements(function(a, b){
						return jQuery(a).text() < jQuery(b).text() ? 1 : -1;
        }, function() {
						return this.parentNode; //here
				});
				jQuery('.list-display div .prod-cat-title').sortElements(function(a, b){
						return jQuery(a).text() < jQuery(b).text() ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.detail-display div .prod-cat-title').sortElements(function(a, b){
						return jQuery(a).text() < jQuery(b).text() ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode.parentNode; //here
				});
}

function SortByPriceASC() {
        var first;
				var second;
				jQuery('.thumb-display div .prod-cat-price').sortElements(function(a, b){
						first = jQuery(a).text().replace(/\D/g,'');
						second = jQuery(b).text().replace(/\D/g,'');
						return Number(first) > Number(second) ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.list-display div .prod-cat-price').sortElements(function(a, b){
						first = jQuery(a).text().replace(/\D/g,'');
						second = jQuery(b).text().replace(/\D/g,'');
						return Number(first) > Number(second) ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.detail-display div .prod-cat-price').sortElements(function(a, b){
						first = jQuery(a).text().replace(/\D/g,'');
						second = jQuery(b).text().replace(/\D/g,'');
						return Number(first) > Number(second) ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode;
				});
}

function SortByPriceDESC() {
				var first;
				var second;
				jQuery('.thumb-display div .prod-cat-price').sortElements(function(a, b){
						first = jQuery(a).text().replace(/\D/g,'');
						second = jQuery(b).text().replace(/\D/g,'');
						return Number(first) < Number(second) ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.list-display div .prod-cat-price').sortElements(function(a, b){
						first = jQuery(a).text().replace(/\D/g,'');
						second = jQuery(b).text().replace(/\D/g,'');
						return Number(first) < Number(second) ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.detail-display div .prod-cat-price').sortElements(function(a, b){
						first = jQuery(a).text().replace(/\D/g,'');
						second = jQuery(b).text().replace(/\D/g,'');
						return Number(first) < Number(second) ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode;
				});
}

function SortByRatingASC() {
	jQuery('.thumb-display div .prod-cat-title .upcp-urp-review-score').sortElements(function(a, b){
						return jQuery(a).attr('title') > jQuery(b).attr('title') ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode; //here
				});
				jQuery('.list-display div .upcp-urp-review-score').sortElements(function(a, b){
						return jQuery(a).attr('title') > jQuery(b).attr('title') ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.detail-display div div .upcp-urp-review-score').sortElements(function(a, b){
						return jQuery(a).attr('title') > jQuery(b).attr('title') ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode; //here
				});
}

function SortByRatingDESC() {
        jQuery('.thumb-display div .prod-cat-title .upcp-urp-review-score').sortElements(function(a, b){
						return jQuery(a).attr('title') < jQuery(b).attr('title') ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode; //here
				});
				jQuery('.list-display div .upcp-urp-review-score').sortElements(function(a, b){
						return jQuery(a).attr('title') < jQuery(b).attr('title') ? 1 : -1;
        }, function() {
						return this.parentNode;
				});
				jQuery('.detail-display div div .upcp-urp-review-score').sortElements(function(a, b){
						return jQuery(a).attr('title') < jQuery(b).attr('title') ? 1 : -1;
        }, function() {
						return this.parentNode.parentNode; //here
				});
}

Array.prototype.compare = function(testArr) {
    if (this.length != testArr.length) return false;
    for (var i = 0; i < testArr.length; i++) {
        if (this[i].compare) { //To test values in nested arrays
            if (!this[i].compare(testArr[i])) return false;
        }
        else if (this[i] !== testArr[i]) return false;
    }
    return true;
}