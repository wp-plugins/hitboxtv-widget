=== Hitbox.TV Widget ===
Contributors: MadMakz
Donate link: http://spiffytek.com/spenden/
Tags: hitbox, status, live, widget
Requires at least: 3.9.0
Tested up to: 3.9.2
Stable tag: 1.5.0
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
* `[hitbox][/hitbox]` Shortcode

== Installation ==

1. Upload everything into `hitboxtv-widget` directory to the `/wp-content/plugins/` directory. Keep the structure intact.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Activate/configure the widget in the 'Widget' menu in WordPress.

= Configuration =

* Multiple Channels:
	* To show multiple channels in one widget simply add a comma seperated list of channels into the widgets 'Channel' field.
* Teams:
	1. Simply add `team:` infront of the team-channel name
	1. Example: For team hitbox.tv/team/hitbox simply use `team:hitbox` as channel name
* Usage of the `[hitbox][/hitbox]` Shortcode:
	* Simply add the channel name between the tags eg.: `[hitbox]hitboxlive[/hitbox]`
	* Optional: There are some options to control the appearance:
		1. For the video:
			* `video` Enables or disables the video. Options: true|false. Default: true
			* `vwidth` Controls the width of the embedded video. Default: 640
			* `vheight` Controls the height of the embedded video. Default: 360
		1. For the chat:
			* `chat` Enables or disables the chat. Options: true|false. Default: true
			* `cwidth` Controls the width of the embedded chat. Default: 360
			* `cheight` Controls the height of the embedded chat. Default: 640
		* Example: `[hitbox vwidth=848 vheight=480 chat=false]hitboxlive[/hitbox]` will show the 'hitboxlive' channel video in 848x480 pixels in size and the chat won't be shown


== Frequently Asked Questions ==

= Is this an official plugin ceated by hitbox.tv? =
No.

= How do i manually purge the widgets cache? =
Cache is automaticaly purged whenever you klick the widgets 'Save' button.

== Screenshots ==

1. Frontpage
2. Widget settings
3. Plugin settings

== Changelog ==
[Full changelog](http://builds.spiffytek.net/changelogs/wp-hitbox-status-widget.txt)

= 1.5.0 =
* Added (simple) Team support. See Installation/readme.txt for usage (#76)
	* This will be extended in future
* Added options page for global settings like cache
* Added global option to hide "Unknown channel"
* New version scheme (major.minor.maintenance)

= 1.4 =
* Added option to disable channel message
* Added [hitbox][/hitbox] shortcode (See Installation/readme.txt notes for detailed info)

= 1.3 =
* Added option to hide offline streams
* Added configurable cache (#74)
* Fixed improper whitespace cleanup on 'Channel' field (#75)
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