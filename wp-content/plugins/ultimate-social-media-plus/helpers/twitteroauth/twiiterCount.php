<?php 

require "autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

function sfsi_plus_twitter_followers(){

	$count = 0;

	$sfsi_plus_section4_options =  unserialize(get_option('sfsi_plus_section4_options',false));		

	if(isset($sfsi_plus_section4_options['sfsiplus_tw_consumer_key']) && isset($sfsi_plus_section4_options['sfsiplus_tw_consumer_secret']) 
			&& isset($sfsi_plus_section4_options['sfsiplus_tw_oauth_access_token']) && isset($sfsi_plus_section4_options['sfsiplus_tw_oauth_access_token_secret'])){

		$connection = new TwitterOAuth($sfsi_plus_section4_options['sfsiplus_tw_consumer_key'], $sfsi_plus_section4_options['sfsiplus_tw_consumer_secret'], $sfsi_plus_section4_options['sfsiplus_tw_oauth_access_token'], $sfsi_plus_section4_options['sfsiplus_tw_oauth_access_token_secret']);

		if(isset($connection) && !empty($connection)){
			$statuses = $connection->get('followers/ids');
			$count    = isset($statuses->ids) && is_array($statuses->ids) ? count($statuses->ids) :0;			
		}
		
	}

	return $count;
}

