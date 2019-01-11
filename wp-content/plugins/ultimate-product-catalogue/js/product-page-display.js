var gridster;
jQuery(function(){ //DOM Ready
 
    if (typeof pp_top_bottom_padding === 'undefined' || pp_top_bottom_padding === null) {pp_top_bottom_padding = 10;}
		if (typeof pp_left_right_padding === 'undefined' || pp_left_right_padding === null) {pp_left_right_padding = 10;}
		if (typeof pp_grid_width === 'undefined' || pp_grid_width === null) {pp_grid_width = 90;}
		if (typeof pp_grid_height === 'undefined' || pp_grid_height === null) {pp_grid_height = 35;}
		
		gridster = jQuery(".gridster ul").gridster({
        widget_margins: [pp_top_bottom_padding, pp_left_right_padding],
        widget_base_dimensions: [pp_grid_width, pp_grid_height],
				helper: 'clone',
   	}).data('gridster');
		if (gridster) {gridster.disable();}
		
		gridster_mobile = jQuery(".gridster-mobile ul").gridster({
        widget_margins: [pp_top_bottom_padding, pp_left_right_padding],
        widget_base_dimensions: [pp_grid_width, pp_grid_height],
				helper: 'clone',
   	}).data('gridster');
		if (gridster_mobile) {gridster_mobile.disable();}

	jQuery('.upcp-gridster-loading').removeClass('upcp-Hide-Item');
});