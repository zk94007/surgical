function UpdateSubCats() {
		var SubCatName = "";
		var CatID = jQuery('#Item_Category').val();
		jQuery('#Item_SubCategory option').remove();
		var order = 'CatID='+CatID+'&action=get_upcp_subcategories';
		jQuery.post(ajaxurl, order, function(response) {
				jQuery('#Item_SubCategory').append("<option value=''></option>");
				response = response.substring(0, response.length - 1);
				SubCats = response.split(",");
				if (SubCats.length >= 2) {
					  for (var i=0; i<SubCats.length; i=i+2) {
								jQuery('#Item_SubCategory').append("<option value='"+SubCats[i]+"'>"+SubCats[i+1]+"</option>");
						}
				}
		});
}