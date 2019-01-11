<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
				<div id='postbox-container-2' class='postbox-container'>
						<div id="advanced-sortables" class="meta-box-sortables">
										<div id="gamify_wp_dash_badges" class="postbox " >
												<div class="handlediv" title="Click to toggle"><br /></div><h3 class='hndle'><span>User Statistics</span></h3>
								 				<div class="inside">
								 						<ul>
		    				 								<?php
													 					$myrows = $wpdb->get_results( "SELECT COUNT(User_ID) FROM $user_table_name ORDER BY Date_Created LIMIT 5" );
													 					if ($myrows) { 
	  							  			 		 					foreach ($myrows as $Users) {
													 		 							echo "<li>" . $Users['COUNT(User_ID)'] . "</li>";
													 		 					}
													 					}
													 					else {
													 							echo "<li>There aren't any users yet, go out and get some!</li>";
													 					}
																?>
								 		 				</ul>
												</div>
										</div>
						</div>
				</div>
		</div>
</div>