/* Used to show and hide the admin tabs for UPCP */
jQuery(document).ready(function() {
	jQuery(".upcp-option-tab").on('click', function() {
		var Label_ID = jQuery(this).attr('id');
		var Table_ID = Label_ID.substring(6);

		if (jQuery('#'+Table_ID).hasClass('upcp-hidden')) {
			jQuery('#'+Table_ID).removeClass('upcp-hidden');
			jQuery('#'+Label_ID).addClass('upcp-selected-options');
		}
		else {
			jQuery('#'+Table_ID).addClass('upcp-hidden');
			jQuery('#'+Label_ID).removeClass('upcp-selected-options');
		}
	});
});

function ShowTab(TabName) {
	jQuery(".OptionTab").each(function() {
		jQuery(this).addClass("HiddenTab");
		jQuery(this).removeClass("ActiveTab");
	});
	jQuery("#"+TabName).removeClass("HiddenTab");
	jQuery("#"+TabName).addClass("ActiveTab");
	
	jQuery(".nav-tab").each(function() {
		jQuery(this).removeClass("nav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("nav-tab-active");
}

function ShowOptionTab(TabName) {
	jQuery(".upcp-option-set").each(function() {
		jQuery(this).addClass("upcp-hidden");
	});
	jQuery("#"+TabName).removeClass("upcp-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".upcp-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".upcp-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
	jQuery('input[name="Display_Tab"]').val(TabName);
}

function ShowStylingTab(TabName) {
	jQuery(".upcp-styling-set").each(function() {
		jQuery(this).addClass("upcp-hidden");
	});
	jQuery("#"+TabName).removeClass("upcp-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".upcp-styling-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	

	jQuery(".styling-subnav-tab").each(function() {
		jQuery(this).removeClass("styling-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("styling-subnav-tab-active");
	jQuery('input[name="Styles_Display_Tab"]').val(TabName);
}

function Reload_PP_Page(Value) {
	var Layout = jQuery('#PP-type-select').val();
	window.location.href = "admin.php?page=UPCP-options&DisplayPage=ProductPage&CPP_Mobile=" + Layout;
}

function ShowToolTip(ToolTipID) {
	jQuery('#'+ToolTipID).css('display', 'block');
}

function HideToolTip(ToolTipID) {
	jQuery('#'+ToolTipID).css('display', 'none');
}

jQuery(document).ready(function() {
	SetTabDeleteHandlers();

	jQuery('.upcp-add-tab').on('click', function(event) {
		var ID = jQuery(this).data('nextid');

		var HTML = "<tr id='upcp-tab-" + ID + "'>";
		HTML += "<td><input type='text' name='Tab_" + ID + "_Name'></td>";
		HTML += "<td><textarea name='Tab_" + ID + "_Content'></textarea></td>";
		HTML += "<td><a class='upcp-delete-tab' data-tabnumber='" + ID + "'>Delete</a></td>";
		HTML += "</tr>";

		//jQuery('table > tr#ewd-uasp-add-reminder').before(HTML);
		jQuery('#upcp-tabs-table tr:last').before(HTML);

		ID++;
		jQuery(this).data('nextid', ID); //updates but doesn't show in DOM

		SetTabDeleteHandlers();

		event.preventDefault();
	});
});

function SetTabDeleteHandlers() {
	jQuery('.upcp-delete-tab').on('click', function(event) {
		var ID = jQuery(this).data('tabnumber');
		var tr = jQuery('#upcp-tab-'+ID);

		tr.fadeOut(400, function(){
            tr.remove();
        });

		event.preventDefault();
	});
}

jQuery(document).ready(function() {
	jQuery('.ewd-dashboard-h3').on('click', function() {
		if (jQuery(this).parent().css('height') == '45px') {jQuery(this).parent().css('height', 'auto');}
		else {jQuery(this).parent().css('height', 45);}
	});
});

jQuery(document).ready(function() {
	jQuery('.upcp-catalogue-select-all').on('click', function() {
		if (jQuery(this).hasClass('upcp-select-products')) {jQuery('input[name="products[]"]').prop('checked', true)}
		if (jQuery(this).hasClass('upcp-select-categories')) {jQuery('input[name="categories[]"]').prop('checked', true)}
	});
});

jQuery(document).ready(function() {
	jQuery('.upcp-catalogue-sort-az').on('click', function() {UPCPSortTable("AZ", jQuery(this).data('table'), jQuery(this).data('action'))});
	jQuery('.upcp-catalogue-sort-za').on('click', function() {UPCPSortTable("ZA", jQuery(this).data('table'), jQuery(this).data('action'))});
});

function UPCPSortTable(Direction, Table, Action) {
	var rows = jQuery('.wp-list-table.' + Table + ' tbody tr').get();

 	rows.sort(function(a, b) {
	 	if (Table == 'catalogue-list') {
	 		var A = jQuery(a).children('td').eq(1).text().toUpperCase();
	 		var B = jQuery(b).children('td').eq(1).text().toUpperCase();
	 	}
	 	else {
	 		var A = jQuery(a).children('td').eq(0).children('a').eq(0).text().toUpperCase();
	 		var B = jQuery(b).children('td').eq(0).children('a').eq(0).text().toUpperCase();
	 	}
		
	 	if (A < B) {
			if (Direction == "AZ") {return -1;}
			else {return 1;}
		}
	
		if(A > B) {
			if (Direction == "AZ") {return 1;}
			else {return -1;}
		}
	
		return 0;
	});

	jQuery.each(rows, function(index, row) {
		jQuery('.wp-list-table.' + Table).children('tbody').append(row);
	});

	var order = jQuery('.wp-list-table.' + Table).sortable('serialize') + '&action=' + Action;
	jQuery.post(ajaxurl, order, function(response) {});
}

jQuery(document).ready(function() {
	jQuery('input#Item_Name').on('focusout', function() {
		if (jQuery('input#Item_Slug').val() == "") {
			var Name = jQuery(this).val();
			var Name2 = Name.replace(/ /g, '-');
			var Name3 = Name2.toLowerCase();
			var Slug = Name3.replace(/[\/\\\[\]|&;$%@"<>()+,^#*{}'!=:?]/g, "");
			jQuery('input#Item_Slug').val(Slug);
		}
	})
});

jQuery(document).ready(function() {
	jQuery('.upcp-upload-style-button').on('click', function() {console.log("called");
		jQuery('#upcp-styling-form').attr('action', 'admin.php?page=UPCP-options&DisplayPage=Styling&Action=UPCP_AddNewCatalogueStyle');
		console.log(jQuery('#upcp-styling-form'));
		document.getElementById("upcp-styling-form").submit()
	});
});

jQuery(document).ready(function() {
	jQuery('.ewd-upcp-spectrum').spectrum({
		showInput: true,
		showInitial: true,
		preferredFormat: "hex",
		allowEmpty: true
	});

	jQuery('.ewd-upcp-spectrum').css('display', 'inline');

	jQuery('.ewd-upcp-spectrum').on('change', function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_UPCP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
		else {
			jQuery(this).css('background', 'none');
		}
	});

	jQuery('.ewd-upcp-spectrum').each(function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_UPCP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
	});
});

function EWD_UPCP_hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}



//NEW DASHBOARD MOBILE MENU AND WIDGET TOGGLING
jQuery(document).ready(function($){
	$('#ewd-upcp-dash-mobile-menu-open').click(function(){
		$('.UPCPMenu .nav-tab:nth-of-type(1n+2)').toggle();
		$('#ewd-upcp-dash-mobile-menu-up-caret').toggle();
		$('#ewd-upcp-dash-mobile-menu-down-caret').toggle();
		return false;
	});
	$(function(){
		$(window).resize(function(){
			if($(window).width() > 785){
				$('.UPCPMenu .nav-tab:nth-of-type(1n+2)').show();
			}
			else{
				$('.UPCPMenu .nav-tab:nth-of-type(1n+2)').hide();
				$('#ewd-upcp-dash-mobile-menu-up-caret').hide();
				$('#ewd-upcp-dash-mobile-menu-down-caret').show();
			}
		}).resize();
	});	
	$('#ewd-upcp-dashboard-support-widget-box .ewd-upcp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-upcp-dashboard-support-widget-box .ewd-upcp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-upcp-dash-mobile-support-up-caret').toggle();
		$('#ewd-upcp-dash-mobile-support-down-caret').toggle();
	});
	$('#ewd-upcp-dashboard-optional-table .ewd-upcp-dashboard-new-widget-box-top').click(function(){
		$('#ewd-upcp-dashboard-optional-table .ewd-upcp-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-upcp-dash-optional-table-up-caret').toggle();
		$('#ewd-upcp-dash-optional-table-down-caret').toggle();
	});
});


//REVIEW ASK POP-UP
jQuery(document).ready(function() {
    jQuery('.ewd-upcp-hide-review-ask').on('click', function() {
        var Ask_Review_Date = jQuery(this).data('askreviewdelay');

        jQuery('.ewd-upcp-review-ask-popup, #ewd-upcp-review-ask-overlay').addClass('upcp-hidden');

        var data = 'Ask_Review_Date=' + Ask_Review_Date + '&action=ewd_upcp_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
    });
    jQuery('#ewd-upcp-review-ask-overlay').on('click', function() {
    	jQuery('.ewd-upcp-review-ask-popup, #ewd-upcp-review-ask-overlay').addClass('upcp-hidden');
    })
});


//OPTIONS HELP/DESCRIPTION TEXT
jQuery(document).ready(function($) {
	$('.upcp-option-set .form-table tr').each(function(){
		var thisOptionClick = $(this);
		thisOptionClick.find('th').click(function(){
			thisOptionClick.find('td p').toggle();
		});
	});
	$('.upcp-styling-set .form-table tr').each(function(){
		var thisStylingOptionClick = $(this);
		thisStylingOptionClick.find('th').click(function(){
			thisStylingOptionClick.find('td p').toggle();
		});
	});
	$('.ewdOptionHasInfo').each(function(){
		var thisNonTableOptionClick = $(this);
		thisNonTableOptionClick.find('.ewd-upcp-admin-styling-subsection-label').click(function(){
			thisNonTableOptionClick.find('fieldset p').toggle();
		});
	});
	$(function(){
		$(window).resize(function(){
			$('.upcp-option-set .form-table tr').each(function(){
				var thisOption = $(this);
				if( $(window).width() < 783 ){
					if( thisOption.find('.ewd-upcp-admin-hide-radios').length > 0 ) {
						thisOption.find('td p').show();			
						thisOption.find('th').css('background-image', 'none');			
						thisOption.find('th').css('cursor', 'default');			
					}
					else{
						thisOption.find('td p').hide();
						thisOption.find('th').css('background-image', 'url(../wp-content/plugins/ultimate-product-catalogue/images/options-asset-info.png)');			
						thisOption.find('th').css('background-position', '95% 20px');			
						thisOption.find('th').css('background-size', '18px 18px');			
						thisOption.find('th').css('background-repeat', 'no-repeat');			
						thisOption.find('th').css('cursor', 'pointer');								
					}		
				}
				else{
					thisOption.find('td p').hide();
					thisOption.find('th').css('background-image', 'url(../wp-content/plugins/ultimate-product-catalogue/images/options-asset-info.png)');			
					thisOption.find('th').css('background-position', 'calc(100% - 20px) 15px');			
					thisOption.find('th').css('background-size', '18px 18px');			
					thisOption.find('th').css('background-repeat', 'no-repeat');			
					thisOption.find('th').css('cursor', 'pointer');			
				}
			});
			$('.upcp-styling-set .form-table tr').each(function(){
				var thisStylingOption = $(this);
				if( $(window).width() < 783 ){
					if( thisStylingOption.find('.ewd-upcp-admin-hide-radios').length > 0 ) {
						thisStylingOption.find('td p').show();			
						thisStylingOption.find('th').css('background-image', 'none');			
						thisStylingOption.find('th').css('cursor', 'default');			
					}
					else{
						thisStylingOption.find('td p').hide();
						thisStylingOption.find('th').css('background-image', 'url(../wp-content/plugins/ultimate-product-catalogue/images/options-asset-info.png)');			
						thisStylingOption.find('th').css('background-position', '95% 20px');			
						thisStylingOption.find('th').css('background-size', '18px 18px');			
						thisStylingOption.find('th').css('background-repeat', 'no-repeat');			
						thisStylingOption.find('th').css('cursor', 'pointer');								
					}		
				}
				else{
					thisStylingOption.find('td p').hide();
					thisStylingOption.find('th').css('background-image', 'url(../wp-content/plugins/ultimate-product-catalogue/images/options-asset-info.png)');			
					thisStylingOption.find('th').css('background-position', 'calc(100% - 20px) 15px');			
					thisStylingOption.find('th').css('background-size', '18px 18px');			
					thisStylingOption.find('th').css('background-repeat', 'no-repeat');			
					thisStylingOption.find('th').css('cursor', 'pointer');			
				}
			});
			$('.ewdOptionHasInfo').each(function(){
				var thisNonTableOption = $(this);
				if( $(window).width() < 783 ){
					if( thisNonTableOption.find('.ewd-upcp-admin-hide-radios').length > 0 ) {
						thisNonTableOption.find('fieldset p').show();			
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-image', 'none');			
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('cursor', 'default');			
					}
					else{
						thisNonTableOption.find('fieldset p').hide();
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-image', 'url(../wp-content/plugins/ultimate-product-catalogue/images/options-asset-info.png)');			
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-position', 'calc(100% - 30px) 15px');			
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-size', '18px 18px');			
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-repeat', 'no-repeat');			
						thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('cursor', 'pointer');								
					}		
				}
				else{
					thisNonTableOption.find('fieldset p').hide();
					thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-image', 'url(../wp-content/plugins/ultimate-product-catalogue/images/options-asset-info.png)');			
					thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-position', 'calc(100% - 30px) 15px');			
					thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-size', '18px 18px');			
					thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('background-repeat', 'no-repeat');			
					thisNonTableOption.find('ewd-upcp-admin-styling-subsection-label').css('cursor', 'pointer');			
				}
			});
		}).resize();
	});	
});


//OPTIONS PAGE YES/NO TOGGLE SWITCHES
jQuery(document).ready(function($) {
	jQuery('.ewd-upcp-admin-option-toggle').on('change', function() {
		var Input_Name = jQuery(this).data('inputname'); console.log(Input_Name);
		if (jQuery(this).is(':checked')) {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', false);
			jQuery('input[name="' + Input_Name + '"][value="yes"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="no"]').prop('checked', false);
			jQuery('input[name="' + Input_Name + '"][value="Yoast"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="None"]').prop('checked', false);
			jQuery('input[name="' + Input_Name + '"][value="gradient"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="gradient-none"]').prop('checked', false);
			jQuery('input[name="' + Input_Name + '"][value="shadow"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="shadow-none"]').prop('checked', false);
		}
		else {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', true);
			jQuery('input[name="' + Input_Name + '"][value="yes"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="no"]').prop('checked', true);
			jQuery('input[name="' + Input_Name + '"][value="Yoast"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="None"]').prop('checked', true);
			jQuery('input[name="' + Input_Name + '"][value="gradient"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="gradient-none"]').prop('checked', true);
			jQuery('input[name="' + Input_Name + '"][value="shadow"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="shadow-none"]').prop('checked', true);
		}
	});
	$(function(){
		$(window).resize(function(){
			$('.upcp-styling-set .form-table tr').each(function(){
				var thisStylingTr = $(this);
				if( $(window).width() < 783 ){
					if( thisStylingTr.find('.ewd-upcp-admin-switch').length > 0 ) {
						thisStylingTr.find('th').css('width', 'calc(90% - 50px');			
						thisStylingTr.find('th').css('padding-right', 'calc(5% + 50px');			
					}
					else{
						thisStylingTr.find('th').css('width', '90%');			
						thisStylingTr.find('th').css('padding-right', '5%');			
					}		
				}
				else{
					thisStylingTr.find('th').css('width', '200px');			
					thisStylingTr.find('th').css('padding-right', '46px');			
				}
			});
			$('.upcp-option-set .form-table tr').each(function(){
				var thisOptionTr = $(this);
				if( $(window).width() < 783 ){
					if( thisOptionTr.find('.ewd-upcp-admin-switch').length > 0 ) {
						thisOptionTr.find('th').css('width', 'calc(90% - 50px');			
						thisOptionTr.find('th').css('padding-right', 'calc(5% + 50px');			
					}
					else{
						thisOptionTr.find('th').css('width', '90%');			
						thisOptionTr.find('th').css('padding-right', '5%');			
					}		
				}
				else{
					thisOptionTr.find('th').css('width', '200px');			
					thisOptionTr.find('th').css('padding-right', '46px');			
				}
			});
		}).resize();
	});	
});



/*************************************************************************
CONDITIONAL OPTIONS
**************************************************************************/
jQuery(document).ready(function($){
	$('input[name="details_icon_type"]').click(function(){
		if($(this).attr('value') == 'Custom'){
			$('#ewd-upcp-admin-custom-details-icon-upload').show();
		}
		else{
			$('#ewd-upcp-admin-custom-details-icon-upload').hide();
		}
	});
	$('input[data-inputname="seo_option"]').click(function(){
		if($(this).attr('checked') == 'checked'){
			$('#ewd-upcp-admin-yoast-description-handling').show();
		}
		else{
			$('#ewd-upcp-admin-yoast-description-handling').hide();
		}
	});
	$('input[data-inputname="woocommerce_sync"]').click(function(){
		if($(this).attr('checked') == 'checked'){
			$('.ewd-upcp-admin-conditional-wc-options').show();
		}
		else{
			$('.ewd-upcp-admin-conditional-wc-options').hide();
		}
	});
});


/*************************************************************************
NEW PRODUCTS TAB FORMATTING
**************************************************************************/
jQuery(document).ready(function($){
	$('#ewd-upcp-admin-add-by-spreadsheet-button').click(function(){
		$('.toplevel_page_UPCP-options #Products #col-right').removeClass('ewd-upcp-admin-products-table-full');
		$('.toplevel_page_UPCP-options #Products #col-left').removeClass('upcp-hidden');
		$('#ewd-upcp-admin-add-manually').addClass('upcp-hidden');
		$('#ewd-upcp-admin-add-from-spreadsheet').removeClass('upcp-hidden');
	});
});


/*************************************************************************
CONDITIONAL CUSTOM FIELD STUFF (e.g. CONTROL TYPE)
**************************************************************************/
jQuery(document).ready(function($){
	$('input[name="Field_Searchable"]').click(function(){
		if($(this).attr('value') == 'Yes'){
			$('#ewd-upcp-admin-cf-control-type').show();
		}
		else{
			$('#ewd-upcp-admin-cf-control-type').hide();
		}
	});
});


/*************************************************************************
CREATE/EDIT PRODUCT WIDGET TOGGLING
**************************************************************************/
jQuery(document).ready(function($){
	$('.ewd-upcp-admin-closeable-widget-box').each(function(){
		var thisClosableWidgetBox = $(this);
		thisClosableWidgetBox.find('.ewd-upcp-dashboard-new-widget-box-top').click(function(){
			thisClosableWidgetBox.find('.ewd-upcp-dashboard-new-widget-box-bottom').toggle();
			thisClosableWidgetBox.find('.ewd-upcp-admin-edit-product-down-caret').toggle();
			thisClosableWidgetBox.find('.ewd-upcp-admin-edit-product-up-caret').toggle();
		});
	});
});
