<?php

/**
 * Logo Switcher
 *
 * @author Iversen - Carpe Noctem
 * @link https://wordpress.org/plugins/logo-switcher/
 *
 */

// Block direct access
if(!defined('ABSPATH'))exit;

add_action( 'admin_menu', 'logo_switcher_add_admin_menu' );
add_action( 'admin_init', 'logo_switcher_settings_init' );

function logo_switcher_add_admin_menu() {
	add_options_page( 'Logo Switcher', 'Logo Switcher', 'manage_options', 'logo_switcher', 'logo_switcher_options_page' );
}

function logo_switcher_settings_init() { 

	register_setting( 'pluginPage', 'logo_switcher_settings' );

	add_settings_section(
		'logo_switcher_pluginPage_section', 
		__( 'Settings', 'logo-switcher' ), 
		'logo_switcher_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'logo_switcher_state', 
		__( 'Show logo on the login screen?', 'logo-switcher' ), 
		'logo_switcher_state_render', 
		'pluginPage', 
		'logo_switcher_pluginPage_section' 
	);
}


function logo_switcher_state_render() { 
  // Get options
	$options = get_option( 'logo_switcher_settings' );
	if(!isset($options['logo_switcher_state']) && empty($options['logo_switcher_state']) ){
		// Set the default state to 1
    $options['logo_switcher_state'] = 1;
  }?>
	<select name='logo_switcher_settings[logo_switcher_state]'>
		<option value='1' <?php selected( $options['logo_switcher_state'], 1 ); ?>><?php echo __( 'Yes', 'logo-switcher' );?></option>
		<option value='2' <?php selected( $options['logo_switcher_state'], 2 ); ?>><?php echo __( 'No', 'logo-switcher' );?></option>
	</select>

<?php }

function logo_switcher_settings_section_callback() { 
	echo __( 'With this settings page, you have full control over your logo on the login screen. The default option is that your logo is shown, and by turning it off, the default WordPress logo will appear.', 'logo-switcher' );
}

function logo_switcher_show_current_logo() {
	// Get the logo
	$logo = Logo_Switcher::get_logo_url();
	// Get the home URL
	$home_url = get_home_url();
	// Set the path to the 'Customize' page
	$settings_path = '/wp-admin/customize.php';
	// Set the full path to the 'Customize' page 
	$url = $home_url . $settings_path;
	$link = sprintf( wp_kses( $text, array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) );

	// Check if a logo is uploaded
	if ($logo) {
    $text = __( 'Do you want to upload a different logo? Click <a href="%s">here</a> to do so.', 'logo-switcher' );
		echo '<h2>' . __( 'Currently uploaded logo:', 'logo-switcher' ) . '</h2>' . PHP_EOL;
    echo '<img src="' . logo_switcher_url() . '" alt="' . get_bloginfo('name') . '">' . PHP_EOL;
    echo '<p>' . $link . '</p>' . PHP_EOL;
	}
	else {
		$text = __( 'You haven\'t uploaded a logo yet. Click <a href="%s">here</a> to upload your logo.', 'logo-switcher' );
    echo '<p>' . $link . '</p>' . PHP_EOL;
	}
}

function logo_switcher_options_page() { ?>
	<div class="wrap">
 		<h1><?php _e( 'Logo Switcher', 'logo-switcher' );?></h1>
 	  <form action='options.php' method='post'>
 		  <?php
 		  settings_fields( 'pluginPage' );
 		  do_settings_sections( 'pluginPage' );
 		  submit_button();
 		  logo_switcher_show_current_logo();
 		  ?>
 	  </form>
  </div>
<?php }?>