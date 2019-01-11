/*global QUnit:false, module:false, test:false, asyncTest:false, expect:false*/
/*global start:false, stop:false ok:false, equal:false, notEqual:false, deepEqual:false*/
/*global notDeepEqual:false, strictEqual:false, notStrictEqual:false, raises:false*/
(function(jQuery) {

  /*
    ======== A Handy Little QUnit Reference ========
    http://docs.jquery.com/QUnit

    Test methods:
      expect(numAssertions)
      stop(increment)
      start(decrement)
    Test assertions:
      ok(value, [message])
      equal(actual, expected, [message])
      notEqual(actual, expected, [message])
      deepEqual(actual, expected, [message])
      notDeepEqual(actual, expected, [message])
      strictEqual(actual, expected, [message])
      notStrictEqual(actual, expected, [message])
      raises(block, [expected], [message])
  */

  /*module('jQuery#gridster', {
    setup: function() {

      this.el = jQuery('#qunit-fixture').find(".wrapper ul");

    }
  });*/

  // test('is chainable', 1, function() {
  //   // Not a bad test to run on collection methods.
  //   strictEqual(this.el, this.el.gridster(), 'should be chaninable');
  // });

}(jQuery));

var gridster;
var gridster_mobile;
jQuery(function(){ //DOM Ready
 		
		if (typeof grid_type === 'undefined' || grid_type === null) {grid_type = 'regular';}

		if (typeof pp_top_bottom_padding === 'undefined' || pp_top_bottom_padding === null) {pp_top_bottom_padding = 10;}
		if (typeof pp_left_right_padding === 'undefined' || pp_left_right_padding === null) {pp_left_right_padding = 10;}
		if (typeof pp_grid_width === 'undefined' || pp_grid_width === null) {pp_grid_width = 90;}
		if (typeof pp_grid_height === 'undefined' || pp_grid_height === null) {pp_grid_height = 35;}
		
    if (grid_type == "mobile") {
			  gridster_mobile = jQuery(".gridster ul").gridster({
        		widget_margins: [pp_top_bottom_padding, pp_left_right_padding],
        		widget_base_dimensions: [pp_grid_width, pp_grid_height],
						helper: 'clone',
						autogrow_cols: true,
        		resize: {
          			enabled: true
        		},
						serialize_params: function ($w, wgd) {
								return {
										element_type: $w.html(),
										element_class: $w.attr("data-elementclass"),
										element_id: $w.attr("data-elementid"),
										col: wgd.col,
              			row: wgd.row,
              			size_x: wgd.size_x,
              			size_y: wgd.size_y
								}
						}
   			}).data('gridster');
		
				jQuery('#gridster-button-mobile').on('click', function() {
						var serialized = gridster_mobile.serialize();
						console.dir(serialized);
						var data = 'serialized_product_page='+JSON.stringify(serialized)+'&action=save_serialized_product_page&type=mobile';
						jQuery.post(ajaxurl, data, function(response) {
								/*if (response) {alert("Worked");}
								else {alert("Failed");}*/
						});
				});
		} 
		else {
				gridster = jQuery(".gridster ul").gridster({
        		widget_margins: [pp_top_bottom_padding, pp_left_right_padding],
        		widget_base_dimensions: [pp_grid_width, pp_grid_height],
						helper: 'clone',
						autogrow_cols: true,
        		resize: {
          			enabled: true
        		},
						serialize_params: function ($w, wgd) {
								return {
										element_type: $w.html(),
										element_class: $w.attr("data-elementclass"),
										element_id: $w.attr("data-elementid"),
										col: wgd.col,
              			row: wgd.row,
              			size_x: wgd.size_x,
              			size_y: wgd.size_y
								}
						}
   			}).data('gridster');
		
				jQuery('#gridster-button').on('click', function() {
						var serialized = gridster.serialize();
						console.dir(serialized);
						var data = 'serialized_product_page='+JSON.stringify(serialized)+'&action=save_serialized_product_page&type=regular';
						jQuery.post(ajaxurl, data, function(response) {
								/*if (response) {alert(response);}
								else {alert("Response: "+response);}*/
						});
				});
		}
});

function UPCP_Page_Builder_UpdateID(textarea) {
		jQuery(textarea).parent().attr("data-elementid", jQuery(textarea).val());
		//jQuery('#gridster-button').click();
}

function add_element(element_name, element_class, element_id, x_size, y_size) {
		if (grid_type == "mobile") {
			  if (element_class == "text") {gridster_mobile.add_widget.apply(gridster_mobile, ["<li data-elementclass='"+element_class+"' data-elementid='"+element_id+"'>"+element_name+"<div class='gs-delete-handle' onclick='remove_element(this);'></div><textarea onkeyup='UPCP_Page_Builder_UpdateID(this);' class='upcp-pb-textarea'></textarea></li>", x_size, y_size]);}
				else {gridster_mobile.add_widget.apply(gridster_mobile, ["<li data-elementclass='"+element_class+"' data-elementid='"+element_id+"'>"+element_name+"<div class='gs-delete-handle' onclick='remove_element(this);'></div></li>", x_size, y_size]);}
		}
		else {
				if (element_class == "text") {gridster.add_widget.apply(gridster, ["<li data-elementclass='"+element_class+"' data-elementid='"+element_id+"'>"+element_name+"<div class='gs-delete-handle' onclick='remove_element(this);'></div><textarea onkeyup='UPCP_Page_Builder_UpdateID(this);' class='upcp-pb-textarea'></textarea></li>", x_size, y_size]);}
				else {gridster.add_widget.apply(gridster, ["<li data-elementclass='"+element_class+"' data-elementid='"+element_id+"'>"+element_name+"<div class='gs-delete-handle' onclick='remove_element(this);'></div></li>", x_size, y_size]);}
		}
		//jQuery('#gridster-button').click();
		return false;
}

function remove_element(element) {
		if (grid_type == "mobile") {
			  gridster_mobile.remove_widget(jQuery(element).parent());
		}
		else {
				gridster.remove_widget(jQuery(element).parent());
		}
		//jQuery('#gridster-button').click();
}