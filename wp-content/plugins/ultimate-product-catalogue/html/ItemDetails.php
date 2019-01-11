
<!-- The details of a specific product for editing, based on the product ID -->
<?php if (!isset($selected)){ $selected = "";}
if (!isset($_GET['Selected'])) {$_GET['Selected'] = "";}?>
<?php if ($_GET['Selected'] == "Product" or (isset($_GET['Action']) and $_GET['Action'] == 'UPCP_AddProduct') or $selected == "Product") { ?>
	<?php include "ProductDetails.php"; ?>

<!-- The details of a specific category for editing, based on the product ID -->
<?php } elseif ($_GET['Selected'] == "Category" or $selected == "Category") { ?>
	<?php include "CategoryDetails.php"; ?>

<!-- Catalogues are complicated to edit, so we pass that off to a different page in the HTML folder -->
<?php } elseif ($_GET['Selected'] == "Catalogue" or $selected == "Catalogue") { ?>
	<?php include "CatalogueDetails.php"; ?>

<!-- The details of a specific sub-category for editing, based on the product ID -->
<?php } elseif ($_GET['Selected'] == "SubCategory" or $selected == "SubCategory") { ?>
	<?php include "SubCategoryDetails.php"; ?>

<!-- The details of a specific tag for editing, based on the product ID -->
<?php } elseif ($_GET['Selected'] == "Tag" or $selected == "Tag") { ?>
	<?php include "TagDetails.php"; ?>

<!-- The details for editing a specific tag group -->
<?php } elseif ($_GET['Selected'] == "Tag_Group" or $selected == "Tag_Group") { ?>
	<?php include "TagGroupDetails.php"; ?>

<?php } elseif ($_GET['Selected'] == "CustomField" or $selected == "CustomField") { ?>
	<?php include "CustomFieldDetails.php"; ?>

<?php } ?>
