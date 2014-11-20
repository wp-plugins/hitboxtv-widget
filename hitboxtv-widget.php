<?php
/*
Plugin Name: Hitbox.TV Widget
Plugin URI: http://wordpress.org/plugins/hitboxtv-widget/
Description: Hitbox.TV status widget.
Version: 1.5.4
Author: SpiffyTek
Author URI: http://spiffytek.de/
License: Copyright (C) 2014 SpiffyTek

http://spiffytek.de/

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License version 3 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

define('HITBOX_TV_WIDGET_PATH_FULL', __FILE__);
define('HITBOX_TV_WIDGET_PATH', plugin_dir_path(HITBOX_TV_WIDGET_PATH_FULL));
define('HITBOX_TV_WIDGET_URI', plugins_url('', HITBOX_TV_WIDGET_PATH_FULL));
define('STHW_CHANNEL_LIMIT', 30);
require_once(HITBOX_TV_WIDGET_PATH.'includes/functions.php');
require_once(HITBOX_TV_WIDGET_PATH.'includes/options.php');

require_once(HITBOX_TV_WIDGET_PATH.'includes/widget.php');

add_action('widgets_init', create_function('', 'return register_widget("st_hitbox_widget");'));
add_action('wp_enqueue_scripts', '_sthw_add_stylesheet');
add_action('admin_menu', '_sthw_options_page');
add_shortcode('hitbox', '_sthw_shortcode');
load_plugin_textdomain('st_hitbox_widget', false, dirname(plugin_basename(HITBOX_TV_WIDGET_PATH_FULL)).'/languages/');
register_activation_hook(HITBOX_TV_WIDGET_PATH_FULL, '_sthw_install');
register_deactivation_hook(HITBOX_TV_WIDGET_PATH.'uninstall.php', '_sthw_uninstall');
register_uninstall_hook(HITBOX_TV_WIDGET_PATH.'uninstall.php', '_sthw_uninstall');
?>