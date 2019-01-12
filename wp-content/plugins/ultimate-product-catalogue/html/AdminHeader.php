		<div class="wrap">
		<div class="Header"><h2><?php _e("Ultimate Product Catalog Settings", 'ultimate-product-catalogue') ?></h2></div>

		<?php if ($Full_Version != "Yes" or get_option("UPCP_Trial_Happening") == "Yes") { ?>
			<div class="ewd-upcp-dashboard-new-upgrade-banner">
				<div class="ewd-upcp-dashboard-banner-icon"></div>
				<div class="ewd-upcp-dashboard-banner-buttons">
					<a class="ewd-upcp-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/ultimate-product-catalog/#buy" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-upcp-dashboard-banner-text">
					<div class="ewd-upcp-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-upcp-dashboard-banner-brief">
						Display your products in a sleek, easy-to-customize catalog
					</div>
				</div>
			</div>
		<?php } ?>