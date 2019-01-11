/* This code is required to make changing the catalogue order a drag-and-drop affair */
jQuery(document).ready(function() {
	
	jQuery('.catalogue-list').sortable({
		items: '.list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=catalogue_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.videos-list').sortable({
		items: '.video-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=video_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.images-list').sortable({
		items: '.list-item-image',
		opacity: 0.6,
		cursor: 'move',
		axis: 'x,y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=image_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.tag-group-list').sortable({
		items: '.list-item-tag-group',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=tag_group_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.category-products-list').sortable({
		items: '.category-product-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=category_products_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.custom-fields-list').sortable({
		items: '.custom-field-list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=custom_fields_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.categories-list').sortable({
		items: '.category-list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=categories_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.subcategories-list').sortable({
		items: '.subcategory-list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=subcategories_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});
	jQuery('.tags-list').sortable({
		items: '.tag-list-item',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize') + '&action=tags_update_order';
			jQuery.post(ajaxurl, order, function(response) {});
		}
	});

	jQuery('.upcp-sidebar-items-order-container').sortable({
		items: '.upcp-sidebar-items-order-element',
		opacity: 0.6,
		cursor: 'move',
		axis: 'y',
		update: function() {
			jQuery('.upcp-sidebar-items-order-element span').each(function(index, el) {
				console.log(jQuery(this).parent().find('input'));
				jQuery(this).parent().find('input').val(index);
				var html = jQuery(this).html();
				var updated_html = (index + 1) + html.substr(1);
				jQuery(this).html(updated_html);
			});
		}
	});
});

function RecordView(Item_ID) {
		var data = 'Item_ID=' + Item_ID + '&action=record_view';
		jQuery.post(ajaxurl, data, function(response) {alert(response);});
		alert(data);
}