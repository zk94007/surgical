=== Storefront Site Logo ===
Contributors: wooassist
Tags: logo, custom, customizer, branding, storefront
Requires at least: 3.0.1
Tested up to: 4.9.4.3
Stable tag: 4.9.4
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lets you add a logo to your site by adding a Branding tab to the customizer for the Storefront theme.

== Description ==

https://www.youtube.com/watch?v=OdTFR37fgJM

This plugin lets you easily add a custom logo for your website. You can also select if you want to display either *Title and Tagline* or *Logo image*.

This plugin is built to work only for the [Storefront theme](https://wordpress.org/themes/storefront).

**How to use:**

1. To upload your own image logo, login to your WordPress dashboard
2. Navigate to Customize page under Appearance
3. Find the branding Section. You can find this below the Background section and above the *Header* section.
4. Select *Logo image* as the *branding style*
5. Select your logo image file or upload a new one.
6. Once uploaded, the preview screen will automatically reload with your new logo.

**Note:**
The max width displayed for the logo is 213px only. If your image is bigger than this, it will automatically resize it.


== Installation ==

**Install via the WordPress Dashboard:**

1. Login to your WordPress Dashboard.
2. Navigate to Plugins, and select add new to go to the "Add Plugins" page.
3. In the right side, enter "Storefront Site Logo" in the search input bar, and hit your enter key.
4. Click install, and wait for the plugin to download. Once done, activate the plugin.

**Install via FTP:**

1. Extract the zip file, login using your ftp client, and upload the storefront-site-logo folder to your `/wp-content/plugins/` directory
2. Login to your WordPress Dashboard.
3. go to plugins and activate "Storefront Site Logo" plugin.


== Frequently Asked Questions ==

**Will this plugin work for themes other than Storefront?**
Unfortunately, No. This plugin was designed to work for the Storefront theme, utilizing Storefront's action hooks and filters. Activating the plugin while using a different theme will trigger a warning.

**I've activated the plugin, where can I access the settings?**
The settings for this plugin can be found in the Customizer page under Appearance. In that page, find the section named "Branding".

**I've already added a logo using Jetpack. Will my logo in Jetpack be removed?**
If you've added a logo using jetpack, your logo will still be displayed on the site. If you want to use this plugin instead of jetpack, just upload your logo and make sure to check Logo image as the branding style. The logo you've uploaded on Jetpack will then be ignored to avoid conflict.

**What is the maximum width and height for my logo?**
The maximum width displayed for the logo is 213 pixels. If your image is bigger than this, it will automatically resize. Just make sure that the width it is not less than 213 pixels to avoid stretching the image.


== Screenshots ==

1. Branding section added on the Customizer page under Appearance.


== Changelog ==

= 1.2.3 =
* fixed issue where site logo appears twice when used along with the storefront header picker plugin

= 1.2.2 =
* tested with WordPress 2.7.3 and Storefront 2.1.8 compatibility

= 1.2.1 =
* added alt and title attributes to custom logo
* remove inline style as it wasn't really needed

= 1.2.0 =
* added "Logo image and tagline" option as requested (here)[https://wordpress.org/support/topic/logo-tagline-1]

= 1.1.2 =
* fixed - logo source not using https when ssl is enabled

= 1.1.1 =
* fixed - logo not auto-linking to homepage

= 1.1.0 =
* added language support
* updated plugin to use storefront extension boilerplate
* changed logo wrapper class to match default css

= 1.0.0 =
* initial release
