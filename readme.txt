=== Hitbox.TV Widget ===
Contributors: MadMakz
Donate link: http://spiffytek.com/spenden/
Tags: hitbox, status, live, widget
Requires at least: 3.9.0
Tested up to: 3.9.2
Stable tag: 1.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Wordpress widget to show the status of one or multiple Hitbox.tv streams.

== Description ==

Wordpress widget to show the status of one or multiple Hitbox.tv streams.

Features:

* Can display multiple channels in one widget
* Preview image on online channels
* Channel name and preview image linked to hitbox.tv
* Displays viewer count
* Displays title message
* Displays wich game is played
* Has its own cache feature

== Installation ==

1. Upload everything into `hitboxtv-widget` directory to the `/wp-content/plugins/` directory. Keep the structure intact.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Activate/configure the widget in the 'Widget' menu in WordPress.

To show multiple channels in one widget simply add a comma seperated list of channels into the widgets 'Channel' field.

== Frequently Asked Questions ==

= Is this an official plugin ceated by hitbox.tv? =
No.

= How do i manually purge the widgets cache? =
Cache is automaticaly purged whenever you klick the widgets 'Save' button.

== Screenshots ==

1. Frontpage
2. Widget settings

== Changelog ==

= 1.3 =
* Added option to hide offline streams
* Added configurable cache (#74)
* Fixed improper whitespace cleanup on 'Channel' field
* Various code cleanups

= 1.2 =
* Fixes for WP.org

= 1.1 =
* Single widget can now show multiple channels for better styleing. You can enter a comma (,) seperated list of channels
* No more mixed code style
* Replaced category image with stream preview image
* CSS changes
* Added screenshot and readme.txt

= 1.0 =
* First working version

== Upgrade Notice ==
Just overwrite existing files.

== Notes ==

I'm only hosting the stable code at WordPress!
For actual development versions please visit http://code.spiffytek.com/wp-hitbox-status-widget