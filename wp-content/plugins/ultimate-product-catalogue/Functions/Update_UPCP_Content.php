<?php
/* This file is the action handler. The appropriate function is then called based 
*  on the action that's been selected by the user. The functions themselves are all
* stored either in Prepare_Data_For_Insertion.php or Update_Admin_Databases.php */

function Update_UPCP_Content() {
	global $upcp_message;
	
	if (isset($_GET['Action'])) {
		switch ($_GET['Action']) {
			case "UPCP_EditProduct":
			case "UPCP_AddProduct":
				$upcp_message = Add_Edit_Product();
				break;
			case "UPCP_Duplicate_Product":
				$upcp_message = Duplicate_UPCP_Product($_GET['Item_ID']);
				break;
			case "UPCP_DeleteProduct":
					$upcp_message = Delete_UPCP_Product($_GET['Item_ID']);
					break;
			case "UPCP_MassDeleteProducts":
					$upcp_message = Mass_Delete_Products();
					break;
			case "UPCP_DeleteAllProducts":
					$upcp_message = Delete_All_Products();
					break;
			case "UPCP_AddProductSpreadsheet":
					$upcp_message = Add_Products_From_Spreadsheet();
					break;
			case "UPCP_ExportToExcel":
					$upcp_message = UPCP_Export_To_Excel();
					break;
			case "UPCP_AddProductVideos":
					$upcp_message = Prepare_Add_Product_Video();
					break;
			case "UPCP_DeleteProductVideo":
					$upcp_message = Delete_Product_Video($_GET['Item_Video_ID']);
					break;
			case "UPCP_AddOptionalImage":
			case "UPCP_EditOptionalImage":
					$upcp_message = Add_Edit_Optional_Images();
					break;
			case "UPCP_DeleteOptionalImage":
					$upcp_message = Delete_Optional_Image($_GET['Item_Optional_Image_ID']);
					break;
			case "UPCP_AddProductImage":
					$upcp_message = Prepare_Add_Product_Image();
					break;
			case "UPCP_DeleteProductImage":
					$upcp_message = Delete_Product_Image();
					break;
			case "UPCP_EditCategory":
			case "UPCP_AddCategory":
					$upcp_message = Add_Edit_Category();
					break;
			case "UPCP_DeleteCategory":
					$upcp_message = Delete_UPCP_Category($_GET['Category_ID']);
					break;
			case "UPCP_MassDeleteCategories":
					$upcp_message = Mass_Delete_Categories();
					break;
			case "UPCP_EditCatalogue":
			case "UPCP_AddCatalogue":
					$upcp_message = Add_Edit_Catalogue();
					break;
			case "UPCP_DeleteCatalogue":
					$upcp_message = Delete_UPCP_Catalogue($_GET['Catalogue_ID']);
					break;
			case "UPCP_MassDeleteCatalogues":
					$upcp_message = Mass_Delete_Catalogues();
					break;
			case "UPCP_MassDeleteCatalogueItems":
					$upcp_message = Mass_Delete_Catalogue_Items();
					break;
			case "UPCP_DeleteCatalogueItem":
					$upcp_message = Delete_Catalogue_Item($_GET['Catalogue_Item_ID']);
					break;
			case "UPCP_EditSubCategory":
			case "UPCP_AddSubCategory":
					$upcp_message = Add_Edit_SubCategory();
					break;
			case "UPCP_DeleteSubCategory":
					$upcp_message = Delete_UPCP_SubCategory($_GET['SubCategory_ID']);
					break;
			case "UPCP_MassDeleteSubCategories":
					$upcp_message = Mass_Delete_SubCategories();
					break;
			case "UPCP_EditTag":
			case "UPCP_AddTag":
					$upcp_message = Add_Edit_Tag();
					break;
			case "UPCP_DeleteTag":
					$upcp_message = Delete_UPCP_Tag($_GET['Tag_ID']);
					break;
			case "UPCP_MassDeleteTags":
					$upcp_message = Mass_Delete_UPCP_Tags();
					break;
			case "UPCP_DeleteTaggedItem":
					$upcp_message = Delete_Products_Tags();
					break;
			case "UPCP_AddTagGroup":
			case "UPCP_EditTagGroup":
					$upcp_message = Add_Edit_Tag_Group();
					break;
			case "UPCP_DeleteTagGroup":
					$upcp_message = Delete_UPCP_Tag_Group($_GET['Tag_Group_ID']);
					break;
			case "UPCP_EditCustomField":
			case "UPCP_AddCustomField":
					$upcp_message = Add_Edit_Custom_Field();
					break;
			case "UPCP_DeleteCustomField":
					$upcp_message = Delete_UPCP_Custom_Field($_GET['Field_ID']);
					break;
			case "UPCP_MassDeleteCustomFields":
					$upcp_message = Mass_Delete_UPCP_Custom_Fields();
					break;		
			case "UPCP_UpdateOptions":
					$upcp_message = Update_UPCP_Options();
					break;
			case "UPCP_AddNewCatalogueStyle":
					$upcp_message = UPCP_Add_New_Catalogue_Style();
					break;
			case "UPCP_RestoreDefaultPPLayout":
					$upcp_message = Restore_Default_PP_Layout();
					break;
			case "UPCP_RestoreDefaultPPLayoutMobile":
					$upcp_message = Restore_Default_PP_Layout_Mobile();
					break;
			case "UPCP_UpdateTabs":
					$upcp_message = UPCP_Save_Additional_Tabs();
					break;
			default:
					$upcp_message = __("The form has not worked correctly. Please contact the plugin developer.", 'ultimate-product-catalogue');
					break;
	 		}
		}
}

?>