<?php

/**
 * Loads Freemius SDK
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exits if accessed directly.
}

// Creates a helper function for easy Freemius SDK access.
function is_fs()
{
    global  $is_fs ;
    
    if ( !isset( $is_fs ) ) {
        // Include Freemius SDK.
        require_once dirname( __FILE__ ) . '/freemius/start.php';
        $is_fs = fs_dynamic_init( array(
            'id'              => '2086',
            'slug'            => 'add-search-to-menu',
            'type'            => 'plugin',
            'public_key'      => 'pk_e05b040b84ff5014d0f0955127743',
            'is_premium'      => false,
            'has_addons'      => false,
            'has_paid_plans'  => true,
            'has_affiliation' => 'selected',
            'menu'            => array(
            'slug'    => 'ivory-search',
            'support' => false,
        ),
            'is_live'         => true,
        ) );
    }
    
    return $is_fs;
}

// Init Freemius.
is_fs();
// Signal that SDK was initiated.
do_action( 'is_fs_loaded' );
global  $is_fs ;
function is_fs_connect_message_update(
    $message,
    $user_first_name,
    $plugin_title,
    $user_login,
    $site_link,
    $freemius_link
)
{
    return sprintf(
        __( 'Hey %1$s' ) . ',<br>' . __( 'Please help us improve %2$s by securely sharing some usage data with %5$s. If you skip this, that\'s okay! %2$s will still work just fine.', 'content-aware-sidebars' ),
        $user_first_name,
        '<b>' . $plugin_title . '</b>',
        '<b>' . $user_login . '</b>',
        $site_link,
        $freemius_link
    );
}

$is_fs->add_filter(
    'connect_message_on_update',
    'is_fs_connect_message_update',
    10,
    6
);
$is_fs->add_filter(
    'connect_message',
    'is_fs_connect_message_update',
    10,
    6
);