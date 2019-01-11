=== Logo Switcher ===
Contributors: leanderiversen
Tags: logo, custom logo, logo controller, logo switcher, login logo
Requires at least: 4.0
Tested up to: 5.0
Stable tag: 2.0
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Logo Switcher allows you to easily implement your own logo in your Wordpress theme.

== Description ==
Logo Switcher is a super lightweight plugin that easily allow the implementation of a chosen logo in your theme. By default, the plugin automatically includes the chosen logo on the login screen, but the plugin behavior can be controlled by a simple filter. To get started, simply download and activate the plugin, then hover over **Appearance** and click on **Customize**.

= How to use =

`
<?php 

// https://www.example.com/wp-content/uploads/YYYY/MM/logo.png
   echo logo_switcher_url();

// <a href="https://www.example.com/" title="Your Website Name" rel="home"><img src="https://www.example.com/wp-content/uploads/YYYY/MM/logo.png" alt="Your Website Name"></a>		
   logo_switcher_link_tag();

// <img src="https://www.example.com/wp-content/uploads/YYYY/MM/logo.png" class="example-class" alt="Your Website Name">
   logo_switcher_image_tag($classes = array());
`

= Like the plugin? =
If you like the plugin, please review it. Every review is highly appreciated, but if you have a suggestion on how to make the plugin better, please send an email to info@carpe-noctem.no.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to **Appearance**, then click on **Customize** to upload your logo. Note that this will only add the logo to the login page of your website. To include the logo on your actual website, use one of the functions provided under "How to use".

== Changelog ==
= 2.0 =
* Introduces logo_switcher_image_tag(), which produces the img-tag, with the option to add classes.
* Introduces logo_switcher_link_tag(), which is an alias of logo_switcher_print().
* Introduces a cleaner uninstalling process.
* Compatibility with WordPress 5.0.

= 1.2.3 =
* Optimisation of the CSS on the "Log In" page.
* Updated minimum version of WordPress to 4.0 to ensure future compatibility for the plugin.

= 1.2.2 =
* Streamlined the process of uploading a logo
* Updated translations

= 1.2.1 =
* Added functionality to see the uploaded logo directly from the plugin's settings page
* Updated translations
* Other minor improvements

= 1.2 =
* New options page located under the "General" settings, which allows you to easily switch on or off the logo on the login screen
* Updated translations with better explanations
* Various minor improvements

= 1.1.4 =
* Updated the readme and made it more understandable
* The plugin is now compatible with version 4.7 of WordPress

= 1.1.3 =
* Various bugfixes
* Updated translations
* Compatible up to version 4.7-alpha-38618 of Wordpress

= 1.1.2 =
* Various bugfixes

= 1.1.1 =
* Updated translations
* Updated readme

= 1.1 =
* Added options to include the logo in your theme
* Added filters
* Bugfixes

= 1.0 =
* Initial release

== Screenshots ==

1. This is where you upload the logo you want to use
2. This is where you change the settings of the plugin to suite your needs