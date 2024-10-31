=== Plugin Name ===
Contributors: pcormack
Donate link: none
Tags: pix.ie, rss, widget, feed, image, ireland, photography, pix
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 0.3

Integrates a users pix RSS feed into their blog.

== Description ==

* Early development stage.
* Uses SimpleXML to parse a selected users pix.ie recent uploads feed.
* Displays squared images in a unordered list so output can be styled using basic CSS.
* Links are opened in a new window/ tab.
* Defaults to 4 images from my pix account.

== Installation ==

1. Extract archive and upload the 'pixRSS' folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Navigate to 'Plugins' > 'Installed' in the WP admin dashboard. Locate pixRSS from the list and click activate.
1. Navigate to 'Appearance' > 'Widgets' in the WP admin dashboard. Expand widget to enter the title, pix username and number of bookmarks to display.

== Frequently Asked Questions ==

= Styling With CSS =

`ul.pixRSS{ margin:0; padding:0 0 0 20px; }
ul.pixRSS li{ list-style-type:none; display:inline; margin:0; padding:0 5px 5px 0; }`

== Screenshots ==

1. pixRSS widget area and widget area output

== Changelog ==

= 0.3 =
* Initial release.

== Upgrade Notice ==