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

if (!class_exists('Logo_Switcher')) {

  class Logo_Switcher {

    /**
    * Add Theme Customize Support
    * 
    * @param WP_Customize_Manager $manager
    */
    public static function addThemeCustomizeSupport(WP_Customize_Manager $manager) {
      // Add the image field
      $manager->add_setting('logo_switcher');
      $manager->add_control(
        new WP_Customize_Image_Control(
          $manager,
          'logo_switcher',
          array(
            'label'       => __('Choose your logo', 'logo-switcher'),
            'section'     => 'title_tagline',
            'description' => __('Note: The logo will replace the default WordPress logo on the login screen. This can be changed on the settings page of the plugin.', 'logo-switcher' )
          )
        )
      );
    }

    /**
    * Add the logo to the login page
    * 
    * Change the logo in the login page and also change the url href and title
    * 
    * @return boolean false if the option is disabled
    */
    public static function addLoginSupport() {
      $setting = self::get_options();
      if (!$setting['enable-on-login-page'])
        return false;
        add_filter('login_headerurl', function() {
          return get_bloginfo('url');
        }
      );
        
      add_filter('login_headertitle', function() {
        $description = get_bloginfo('description');
        if (!empty($description)) {
          return get_bloginfo('description');
        } else {
          return get_bloginfo('name');
        }
      });

    $url = static::get_logo_url();
    if (!empty($url)) {
      list($width, $height, $type, $attr) = getimagesize($url);
      if($height < 150) {
        $css_height = '20vh';
      } else {
        $css_height = '30vh';
      }
      print( "<style type='text/css'>.login h1 a {background-image: url('{$url}'); background-size: 100%; width:100%; height:{$css_height};}</style>" . PHP_EOL );
    } else {
        print( '<style type="text/css">.login h1 a {display:none}</style>' . PHP_EOL );
      }
    }

    /**
    * Get options
    *  
    * @return array
    */
    public static function get_options() {
      $options = get_option( 'logo_switcher_settings' );
      $option = $options['logo_switcher_state'];
      if ($option == 1) {
        $state = true;
      } elseif ($option == 2) {
        $state = false;
      } else {
        $state = true;
      }
        
      $default = array(
        // path for default logo image 
        'default' => '/logo.png',
        //the logo url (default to home page)
        'url' => esc_url( home_url( '/' ) ),
        // the logo desciption default to (get_bloginfo('name', 'display')) 
        'description' => get_bloginfo('name', 'display'),
        // enable logo display on the login page
        'enable-on-login-page' => $state,
      );
      return apply_filters('logo-switcher.options', $default);
    }

    /**
    * Get the logo url
    * 
    * @return string
    */
    public static function get_logo_url() {
      $setting = self::get_options();
      ($result = get_theme_mod('logo_switcher')) && !empty($result) ? $result : $setting['default'];
      return esc_url($result);
    }

    /**
    * Print logo url
    * 
    * @param string $path the url target
    * @param string $description the logo image description
    *
    */
    public static function print_link_tag($path = null, $description = null) {
      $setting = static::get_options();
      $path = !empty($path) ? $path : $setting['url'];
      $description = !empty($description) ? $description : $setting['description'];
      echo sprintf( '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"></a>', esc_url($path), esc_attr($description), esc_url(static::get_logo_url()) );
    }

    /**
    * Print logo url
    * 
    * @param string $path the url target
    * @param string $description the logo image description
    *
    */
    public static function print_image_tag($classes = array()) {
      $class = '';
      if(!empty($classes)) {
        $classes = implode(' ', $classes);
        $class = ' class="' . $classes . '" ';
      }

      $setting = static::get_options();
      $description = !empty($description) ? $description : $setting['description'];

      $logo = esc_url(static::get_logo_url());
      $description = esc_attr($description);
      $tag = '<img src="' . $logo . '"' . $class . 'alt="' . $description . '">';
      echo $tag;
    }
  }
}