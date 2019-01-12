<?php

function UPCP_Add_Modified_Styles() {

	$StylesString = "<style>";
	/* Thumbnail View Options */
	/*if (get_option("UPCP_Thumbnail_View_Image_Hover_Fade") != THUMBNAIL_VIEW_IMAGE_HOVER_FADE) {$StylesString .= get_option("UPCP_Thumbnail_View_Image_Hover_Fade");} */
	/*if (get_option("UPCP_Thumbnail_View_Mouseover_Zoom") != THUMBNAIL_VIEW_MOUSEOVER_ZOOM) {$StylesString .= get_option("UPCP_Thumbnail_View_Mouseover_Zoom");} */

	// Compare and Sale Buttons
	$StylesString .=".upcp-product-comparison-button { ";
		if (get_option("UPCP_Compare_Button_Background_Color") != "") {$StylesString .= "background:" . get_option("UPCP_Compare_Button_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-product-comparison-button span.compareSpan { ";
		if (get_option("UPCP_Compare_Button_Text_Color") != "") {$StylesString .= "color:" . get_option("UPCP_Compare_Button_Text_Color") . ";";}
		if (get_option("UPCP_Compare_Button_Font_Size") != "") {$StylesString .= "font-size:" . get_option("UPCP_Compare_Button_Font_Size") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-product-comparison-button.comparisonClicked { ";
			if (get_option("UPCP_Compare_Button_Clicked_Background_Color") != "") {$StylesString .= "background:" . get_option("UPCP_Compare_Button_Clicked_Background_Color") . ";";}
			$StylesString .="}\n";
	$StylesString .=".upcp-product-comparison-button.comparisonClicked span.compareSpan { ";
			if (get_option("UPCP_Compare_Button_Clicked_Text_Color") != "") {$StylesString .= "color:" . get_option("UPCP_Compare_Button_Clicked_Text_Color") . ";";}
			$StylesString .="}\n";
	$StylesString .=".upcp-sale-flag { ";
		if (get_option("UPCP_Sale_Button_Background_Color") != "") {$StylesString .= "background:" . get_option("UPCP_Sale_Button_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-sale-flag span.saleSpan { ";
		if (get_option("UPCP_Sale_Button_Text_Color") != "") {$StylesString .= "color:" . get_option("UPCP_Sale_Button_Text_Color") . ";";}
		if (get_option("UPCP_Sale_Button_Font_Size") != "") {$StylesString .= "font-size:" . get_option("UPCP_Sale_Button_Font_Size") . ";";}
		$StylesString .="}\n";

	//Icon Options
	if (get_option("UPCP_Details_Icon_Type") != "Font") {
		$StylesString .= ".upcp-details-icon {opacity: 0;}\n";
	}
	else {
		$StylesString .= ".prod-cat-details-link {background: none !important;}\n";
		if (get_option("UPCP_Details_Icon_Color") != "") {$StylesString .= ".upcp-details-icon {color: " . get_option("UPCP_Details_Icon_Color") . ";}\n";}
		if (get_option("UPCP_Details_Icon_Font_Size") != "") {$StylesString .= ".upcp-details-icon {font-size: " . get_option("UPCP_Details_Icon_Font_Size") . "px;}\n";}
	}

	$StylesString .="div.upcp-thumb-image-div img { ";
		if (get_option("UPCP_Thumbnail_View_Image_Height") != "")
				{$StylesString .= "max-height:" .  get_option("UPCP_Thumbnail_View_Image_Height") . "px ; ";}
		if (get_option("UPCP_Thumbnail_View_Image_Width") != "")
				{$StylesString .= "max-width:" . get_option("UPCP_Thumbnail_View_Image_Width") . "px ; ";}
		if (get_option("UPCP_Thumbnail_View_Image_Border") != "")
				{$StylesString .="border: " . get_option("UPCP_Thumbnail_View_Image_Border"). "; ";}
		if (get_option("Thumbnail_View_Image_Border_Color") != "")
				{$StylesString .="border-color:" . get_option("Thumbnail_View_Image_Border_Color") . ";";}
		$StylesString .="}\n";

	$StylesString .= ".upcp-thumb-image-div { ";
		if ( get_option("UPCP_Thumbnail_View_Image_Holder_Height") != "")
				{$StylesString .= "height:" . get_option("UPCP_Thumbnail_View_Image_Holder_Height") . "px ;";}
		if (get_option("UPCP_Thumbnail_View_Image_Holder_Width") != "")
				{$StylesString .= "width:" . get_option("UPCP_Thumbnail_View_Image_Holder_Width") . "px ";}
		$StylesString .="}\n";
	$StylesString .= ".upcp-thumb-image-div a { ";
		if (get_option("UPCP_Thumbnail_View_Image_Holder_Height") != "")
				{$StylesString .= "height:" . get_option("UPCP_Thumbnail_View_Image_Holder_Height") . "px !important;";}
		// if (get_option("UPCP_Thumbnail_View_Image_Holder_Width") != THUMBNAIL_VIEW_IMAGE_HOLDER_WIDTH &&  get_option("UPCP_Thumbnail_View_Image_Holder_Width") != "") {$StylesString .= "width:" . get_option("UPCP_Thumbnail_View_Image_Holder_Width") . ";";}
		$StylesString .="}\n";

	$StylesString .= ".upcp-thumb-item {";
		if (get_option("UPCP_Thumbnail_View_Box_Width") != "")
			 {$StylesString .= "width:" . get_option("UPCP_Thumbnail_View_Box_Width") . "px;";}
		if (get_option("UPCP_Thumbnail_View_Box_Min_Height") != "")
			{$StylesString .= "min-height:" . get_option("UPCP_Thumbnail_View_Box_Min_Height") . "px;";}
		if (get_option("UPCP_Thumbnail_View_Box_Max_Height") != "")
		 	{$StylesString .= "max-height:" . get_option("UPCP_Thumbnail_View_Box_Max_Height") . "px;";}
		if (get_option("UPCP_Thumbnail_View_Box_Padding") != "")
			{$StylesString .= "padding:" . str_replace(" ", "px ", get_option("UPCP_Thumbnail_View_Box_Padding")) . "px;";}
		if (get_option("UPCP_Thumbnail_View_Box_Margin") != "")
			 {$StylesString .= "margin:" . str_replace(" ", "px ", get_option("UPCP_Thumbnail_View_Box_Margin")) . "px;";}
		// if (get_option("UPCP_Thumbnail_View_Box_Border") != THUMBNAIL_VIEW_BOX_BORDER) {$StylesString .= get_option("UPCP_Thumbnail_View_Box_Border") . ";";}
		if (get_option("UPCP_Thumbnail_View_Box_Border") != "")
			 {$StylesString .= "border-color:" . get_option("UPCP_Thumbnail_View_Border_Color") . ";";}
		if (get_option("UPCP_Thumbnail_View_Border_Color") != "")
			 {$StylesString .= "background-color:" . get_option("UPCP_Thumbnail_View_Background_Color") . ";";}
		// if (get_option("UPCP_Thumbnail_View_Separator_Line") != THUMBNAIL_VIEW_SEPARATOR_LINE &&  get_option("UPCP_Thumbnail_View_Background_Color") != "") {$StylesString .= get_option("UPCP_Thumbnail_View_Separator_Line") . ";";}
		$StylesString .="}\n";
	$StylesString .= ".upcp-thumb-title a {";
		if (get_option("UPCP_Thumbnail_View_Title_Font_Size") != "")
			{$StylesString .="font-size:" . get_option("UPCP_Thumbnail_View_Title_Font_Size") . "px !important;";}
		if (get_option("UPCP_Thumbnail_View_Title_Font") != "")
			{$StylesString .="font-family:" . get_option("UPCP_Thumbnail_View_Title_Font") . " !important;";}
		if (get_option("UPCP_Thumbnail_View_Title_Color") != "")
			{$StylesString .= "color:" . get_option("UPCP_Thumbnail_View_Title_Color") . " !important;";}
		$StylesString .="}\n";
	$StylesString .= ".upcp-thumb-price {";
		if (get_option("UPCP_Thumbnail_View_Price_Font") != "")
			{$StylesString .="font-family:" .  get_option("UPCP_Thumbnail_View_Price_Font") . ";";}
		if (get_option("UPCP_Thumbnail_View_Price_Font_Size") != "")
			{$StylesString .="font-size:" . get_option("UPCP_Thumbnail_View_Price_Font_Size") . "px;";}
		if (get_option("UPCP_Thumbnail_View_Price_Color") != "")
			{$StylesString .= "color:" . get_option("UPCP_Thumbnail_View_Price_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .= ".upcp-thumb-details-link {";
		// if (get_option("UPCP_Thumbnail_View_Details_Arrow") != THUMBNAIL_VIEW_DETAILS_ARROW) {$StylesString .= get_option("UPCP_Thumbnail_View_Details_Arrow") . ";";}
		// if (get_option("UPCP_Thumbnail_View_Custom_Details_Arrow") != THUMBNAIL_VIEW_CUSTOM_DETAILS_ARROW) {$StylesString .= get_option("UPCP_Thumbnail_View_Custom_Details_Arrow") . ";";}
		$StylesString .="}\n";

	/* List View Options */
	$StylesString .=".upcp-list-image-div img { ";
		if (get_option("UPCP_List_View_Image_Height") != "") {$StylesString .="height:" . get_option("UPCP_List_View_Image_Height") . "px;";}
		if (get_option("UPCP_List_View_Image_Width") != "") {$StylesString .="width:" . get_option("UPCP_List_View_Image_Width") . "px;";}
		$StylesString .="}\n";
	$StylesString .=".upcp-list-image-div { ";
		if (get_option("UPCP_List_View_Image_Holder_Height") != "") {$StylesString .= "height:" . get_option("UPCP_List_View_Image_Holder_Height") . "px ;";}
		// if (get_option("UPCP_List_View_Image_Border") != LIST_VIEW_IMAGE_BORDER &&  get_option("UPCP_List_View_Image_Border") != "") {$StylesString .= get_option("UPCP_List_View_Image_Border") . ";";}
		if (get_option("UPCP_List_View_Image_Border_Color") != "") {$StylesString .= "border-color:" . get_option("UPCP_List_View_Image_Border_Color") . ";";}
		if (get_option("UPCP_List_View_Image_Background_Color") != "") {$StylesString .="background-color:" . get_option("UPCP_List_View_Image_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-list-item { ";
		if (get_option("UPCP_List_View_Item_Margin_Left") != "") {$StylesString .="margin-left:" . get_option("UPCP_List_View_Item_Margin_Left") . "px;";}
		if (get_option("UPCP_List_View_Item_Margin_Top") != "") {$StylesString .="margin-top:" . get_option("UPCP_List_View_Item_Margin_Top") . "px;";}
		if (get_option("UPCP_List_View_Item_Padding") != "") {
			$StylesString .="padding:" . str_replace(" ", "px ", get_option("UPCP_List_View_Item_Padding")) . "px;";}
		if (get_option("UPCP_List_View_Item_Color") != "") {
			$StylesString .="background-color:" . get_option("UPCP_List_View_Item_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-list-details {";
		if (get_option("UPCP_List_View_Item_Min_Height") != "") {
			$StylesString .="min-height:" . get_option("UPCP_List_View_Item_Min_Height") . "px;";}
		if (get_option("UPCP_List_View_Item_Max_Height") != "") {
			$StylesString .="max-height:" . get_option("UPCP_List_View_Item_Max_Height") . "px;";}
		$StylesString .="}\n";
	$StylesString .=".upcp-list-title {";
		if (get_option("UPCP_List_View_Title_Font_Size") != "") {
			$StylesString .="font-size:" . get_option("UPCP_List_View_Title_Font_Size") . "px;";}
		if (get_option("UPCP_List_View_Title_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_List_View_Title_Color") . ";";}
		if (get_option("UPCP_List_View_Title_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_List_View_Title_Font") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-list-price {";
		if (get_option("UPCP_List_View_Price_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_List_View_Price_Font_Size") . "px;";}
		if (get_option("UPCP_List_View_Price_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_List_View_Price_Color") . ";";}
		if (get_option("UPCP_List_View_Price_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_List_View_Price_Font") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-list-details-link {";
		// if (get_option("UPCP_List_View_Details_Arrow") != LIST_VIEW_DETAILS_ARROW &&  get_option("UPCP_List_View_Details_Arrow") != "") {$StylesString .= get_option("UPCP_List_View_Details_Arrow") . ";";}
		// if (get_option("UPCP_List_View_Custom_Details_Arrow") != LIST_VIEW_CUSTOM_DETAILS_ARROW &&  get_option("UPCP_List_View_Custom_Details_Arrow") != "") {$StylesString .= get_option("UPCP_List_View_Custom_Details_Arrow") . ";";}
		$StylesString .="}\n";
	// if (get_option("UPCP_List_View_Background_Color") != LIST_VIEW_BACKGROUND_COLOR &&  get_option("UPCP_List_View_Background_Color") != "") {$StylesString .= get_option("UPCP_List_View_Background_Color") . ";";}
	// if (get_option("UPCP_List_View_Image_Hover_Fade") != LIST_VIEW_IMAGE_HOVER_FADE &&  get_option("UPCP_List_View_Image_Hover_Fade") != "") {$StylesString .= get_option("UPCP_List_View_Image_Hover_Fade") . ";";}
	// if (get_option("UPCP_List_View_Mouseover_Zoom") != LIST_VIEW_MOUSEOVER_ZOOM &&  get_option("UPCP_List_View_Mouseover_Zoom") != "") {$StylesString .= get_option("UPCP_List_View_Mouseover_Zoom") . ";";}

	/* Detail View Options */
	$StylesString .="div.upcp-detail-image-div img { ";
		if (get_option("UPCP_Detail_View_Image_Height") != "") {
			$StylesString .="height:" . get_option("UPCP_Detail_View_Image_Height") . "px;";}
		if (get_option("UPCP_Detail_View_Image_Width") != "") {
			$StylesString .= "width:" . get_option("UPCP_Detail_View_Image_Width") . "px;";}
		$StylesString .="}\n";
	$StylesString .="div.upcp-detail-image-div { ";
		if (get_option("UPCP_Detail_View_Image_Holder_Height") != "") {
			$StylesString .= "height:" . get_option("UPCP_Detail_View_Image_Holder_Height") . "px;";}
		if (get_option("UPCP_Detail_View_Image_Holder_Width") != "") {
			$StylesString .= "width:" . get_option("UPCP_Detail_View_Image_Holder_Width") . "px ;";}
		// if (get_option("UPCP_Detail_View_Image_Border") != DETAIL_VIEW_IMAGE_BORDER &&  get_option("UPCP_Detail_View_Image_Border") != "") {$StylesString .= get_option("UPCP_Detail_View_Image_Border") . ";";}
		if (get_option("UPCP_Detail_View_Image_Border_Color") != "") {
			$StylesString .= "border-color:" . get_option("UPCP_Detail_View_Image_Border_Color") . ";";}
		if (get_option("UPCP_Detail_View_Image_Background_Color") != "") {
			$StylesString .= "background-color:" . get_option("UPCP_Detail_View_Image_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-detail-item { ";
		// if (get_option("UPCP_Detail_View_Box_Width") != DETAIL_VIEW_BOX_WIDTH &&  get_option("UPCP_Detail_View_Box_Width") != "") {$StylesString .= get_option("UPCP_Detail_View_Box_Width") . "px;";}
		if (get_option("UPCP_Detail_View_Box_Padding") != "") {
			$StylesString .= "padding:" . str_replace(" ", "px ", get_option("UPCP_Detail_View_Box_Padding")) . "px;";}
		if (get_option("UPCP_Detail_View_Box_Margin") != "") {
			$StylesString .= "margin:" . str_replace(" ", "px ", get_option("UPCP_Detail_View_Box_Margin")) . "px;";}
		// if (get_option("UPCP_Detail_View_Box_Border") != DETAIL_VIEW_BOX_BORDER &&  get_option("UPCP_Detail_View_Box_Border") != "") {$StylesString .= get_option("UPCP_Detail_View_Box_Border") . ";";}
		if (get_option("UPCP_Detail_View_Border_Color") != "") {
			$StylesString .= "border-color:" . get_option("UPCP_Detail_View_Border_Color") . ";";}
		if (get_option("UPCP_Detail_View_Background_Color") != "") {
			$StylesString .= "background-color:" . get_option("UPCP_Detail_View_Background_Color") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-detail-title { ";
		if (get_option("UPCP_Detail_View_Title_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Detail_View_Title_Font_Size") . "px;";}
		if (get_option("UPCP_Detail_View_Title_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Detail_View_Title_Color") . ";";}
		if (get_option("UPCP_Detail_View_Title_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_Detail_View_Title_Font") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-detail-price {";
		if (get_option("UPCP_Detail_View_Price_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Detail_View_Price_Font_Size") . "px;";}
		if (get_option("UPCP_Detail_View_Price_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Detail_View_Price_Color") . ";";}
		if (get_option("UPCP_Detail_View_Price_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_Detail_View_Price_Font") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-detail-details-link { ";
		// if (get_option("UPCP_Detail_View_Details_Arrow") != DETAIL_VIEW_DETAILS_ARROW &&  get_option("UPCP_Detail_View_Details_Arrow") != "") {$StylesString .= get_option("UPCP_Detail_View_Details_Arrow") . ";";}
		// if (get_option("UPCP_Detail_View_Custom_Details_Arrow") != DETAIL_VIEW_CUSTOM_DETAILS_ARROW &&  get_option("UPCP_Detail_View_Custom_Details_Arrow") != "") {$StylesString .= get_option("UPCP_Detail_View_Custom_Details_Arrow") . ";";}
		$StylesString .="}\n";
	$StylesString .=".upcp-mid-detail-div { ";
		// if (get_option("UPCP_Detail_View_Separator_Line") != DETAIL_VIEW_SEPARATOR_LINE &&  get_option("UPCP_Detail_View_Separator_Line") != "") {$StylesString .= get_option("UPCP_Detail_View_Separator_Line") . ";";}
		$StylesString .="}\n";
		// if (get_option("UPCP_Detail_View_Image_Hover_Fade") != DETAIL_VIEW_IMAGE_HOVER_FADE &&  get_option("UPCP_Detail_View_Image_Hover_Fade") != "") {$StylesString .= get_option("UPCP_Detail_View_Image_Hover_Fade") . ";";}
		// if (get_option("UPCP_Detail_View_Mouseover_Zoom") != DETAIL_VIEW_MOUSEOVER_ZOOM &&  get_option("UPCP_Detail_View_Mouseover_Zoom") != "") {$StylesString .= get_option("UPCP_Detail_View_Mouseover_Zoom") . ";";}
		// if (get_option("UPCP_Detail_View_Zoom_On_Image_Hover") != DETAIL_VIEW_ZOOM_ON_IMAGE_HOVER &&  get_option("UPCP_Detail_View_Zoom_On_Image_Hover") != "") {$StylesString .= get_option("UPCP_Detail_View_Zoom_On_Image_Hover") . ";";}

	/* Sidebar View Options */
	$StylesString .=".prod-cat-sidebar-cat-title h3 { ";
		if (get_option("UPCP_Sidebar_Header_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_Sidebar_Header_Font") . ";";}
		if (get_option("UPCP_Sidebar_Header_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Sidebar_Header_Font_Size") . "px;";}
		if (get_option("UPCP_Sidebar_Header_Font_Weight") != "") {
			$StylesString .= "font-weight:" . get_option("UPCP_Sidebar_Header_Font_Weight") . ";";}
		if (get_option("UPCP_Sidebar_Header_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Sidebar_Header_Color") . ";";}
$StylesString .="}\n";
	$StylesString .=".prod-cat-sort-by, .prod-cat-text-search, .prod-cat-sidebar-cat-title span { ";
		if (get_option("UPCP_Sidebar_Subheader_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_Sidebar_Subheader_Font") . ";";}
		if (get_option("UPCP_Sidebar_Subheader_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Sidebar_Subheader_Font_Size") . "px;";}
		if (get_option("UPCP_Sidebar_Subheader_Font_Weight") != "") {
			$StylesString .= "font-weight:" . get_option("UPCP_Sidebar_Subheader_Font_Weight") . ";";}
		if (get_option("UPCP_Sidebar_Subheader_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Sidebar_Subheader_Color") . ";";}
	$StylesString .="}\n";
	$StylesString .=".prod-cat-sidebar-content .upcp-label { ";
		if (get_option("UPCP_Sidebar_Checkbox_Font") != "") {
			$StylesString .= "font-family:" . get_option("UPCP_Sidebar_Checkbox_Font") . ";";}
		if (get_option("UPCP_Sidebar_Checkbox_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Sidebar_Checkbox_Font_Size") . "px;";}
		if (get_option("UPCP_Sidebar_Checkbox_Font_Weight") != "") {
			$StylesString .= "font-weight:" . get_option("UPCP_Sidebar_Checkbox_Font_Weight") . ";";}
		if (get_option("UPCP_Sidebar_Checkbox_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Sidebar_Checkbox_Color") . ";";}
	$StylesString .="}\n";

	/* Product Page */
	$StylesString .=".prod-cat-back-link a, .upcp-product-page-breadcrumbs a, .prod-cat-back-link, .upcp-product-page-breadcrumbs { ";
		if (get_option("UPCP_Breadcrumbs_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Breadcrumbs_Font_Size") . "px;";}
		if (get_option("UPCP_Breadcrumbs_Font_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Breadcrumbs_Font_Color") . ";";}
	$StylesString .="}\n";
	$StylesString .=".prod-cat-back-link a:hover, .upcp-product-page-breadcrumbs a:hover { ";
		if (get_option("UPCP_Breadcrumbs_Font_Hover_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Breadcrumbs_Font_Hover_Color") . ";";}
	$StylesString .="}\n";

	/* Product Comparison Page */
	$StylesString .=".upcp-product-comparison-title a { ";
		if (get_option("UPCP_Product_Comparison_Title_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Product_Comparison_Title_Font_Size") . "px;";}
		if (get_option("UPCP_Product_Comparison_Title_Font_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Product_Comparison_Title_Font_Color") . ";";}
	$StylesString .="}\n";
	$StylesString .=".upcp-product-comparison-price { ";
		if (get_option("UPCP_Product_Comparison_Price_Font_Size") != "") {
			$StylesString .= "font-size:" . get_option("UPCP_Product_Comparison_Price_Font_Size") . "px;";}
		if (get_option("UPCP_Product_Comparison_Price_Font_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Product_Comparison_Price_Font_Color") . ";";}
		if (get_option("UPCP_Product_Comparison_Price_Background_Color") != "") {
			$StylesString .= "background:" . get_option("UPCP_Product_Comparison_Price_Background_Color") . ";";}
	$StylesString .="}\n";

	/* Pagination */
	$StylesString .=".prod-cat .pagination-links a { ";
		if (get_option("UPCP_Pagination_Border_Enable") == "Yes") {
			$StylesString .= "border: 1px solid;";
		}
		else{
			$StylesString .= "border: none;";
		}
		if (get_option("UPCP_Pagination_Border_Color") != "") {
			$StylesString .= "border-color:" . get_option("UPCP_Pagination_Border_Color") . ";";}
		if (get_option("UPCP_Pagination_Background_Color") != "") {
			$StylesString .= "background-color:" . get_option("UPCP_Pagination_Background_Color") . ";";}
		if (get_option("UPCP_Pagination_Font_Color") != "") {
			$StylesString .= "color:" . get_option("UPCP_Pagination_Font_Color") . ";";}
	$StylesString .="}\n";
	$StylesString .=".prod-cat .pagination-links a:hover { ";
		if (get_option("UPCP_Pagination_Border_Color_Hover") != "") {
			$StylesString .= "border-color:" . get_option("UPCP_Pagination_Border_Color_Hover") . ";";}
		if (get_option("UPCP_Pagination_Background_Color_Hover") != "") {
			$StylesString .= "background-color:" . get_option("UPCP_Pagination_Background_Color_Hover") . ";";}
		if (get_option("UPCP_Pagination_Font_Color_Hover") != "") {
			$StylesString .= "color:" . get_option("UPCP_Pagination_Font_Color_Hover") . ";";}
	$StylesString .="}\n";

	$StylesString .= "</style>";

	return $StylesString;
}
