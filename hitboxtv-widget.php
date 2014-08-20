<?php
/*
Plugin Name: Hitbox.TV Widget
Plugin URI: http://wordpress.org/plugins/hitboxtv-widget/
Description: Hitbox.TV status widget.
Version: 1.5.0
Author: SpiffyTek
Author URI: http://spiffytek.com/
License: Copyright (C) 2014 SpiffyTek

http://spiffytek.com/

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
require_once(HITBOX_TV_WIDGET_PATH.'includes/functions.php');
require_once(HITBOX_TV_WIDGET_PATH.'includes/options.php');

class st_hitbox_widget extends WP_Widget{
	function st_hitbox_widget(){
		parent::WP_Widget(false, $name = __('Hitbox.TV Widget', 'st_hitbox_widget'));
	}
	
	function form($instance){
		if($instance){
			$title = esc_attr($instance['title']);
			$text = esc_attr($instance['text']);
			$hide_offline = esc_attr($instance['hide_offline']);
			$hide_message = esc_attr($instance['hide_message']);
		}else{
			$title = '';
			$text = '';
			$hide_offline = 0;
			$hide_message = 0;
		}
?>	
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'st_hitbox_widget'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Channel or multiple channels seperated by comma:', 'st_hitbox_widget'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('hide_offline'); ?>" name="<?php echo $this->get_field_name('hide_offline'); ?>" type="checkbox" value="1" <?php checked('1', $hide_offline); ?> />
			<label for="<?php echo $this->get_field_id('hide_offline'); ?>"><?php _e('Hide offline channels', 'st_hitbox_widget'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('hide_message'); ?>" name="<?php echo $this->get_field_name('hide_message'); ?>" type="checkbox" value="1" <?php checked('1', $hide_message); ?> />
			<label for="<?php echo $this->get_field_id('hide_message'); ?>"><?php _e('Hide channel message', 'st_hitbox_widget'); ?></label>
		</p>
<?php
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['hide_offline'] = strip_tags($new_instance['hide_offline']);
		$instance['hide_message'] = strip_tags($new_instance['hide_message']);
		if($this->id){
			delete_transient($this->id);
		}
		return $instance;
	}
	
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		$cache_key = $args['widget_id'];
		
		echo $before_widget;

		if ($title){
			echo $before_title.$title.$after_title;
		}

		if($text){
			
			$text = explode(',', preg_replace('/\s/', '', $text));
			
			echo '<div class="st-hitbox-widget-holder">
					<ul>';				
					
			if(!get_transient($cache_key) || get_option('sthw_cache_enable') != 1){
				
				for($i = 0; $i <= count($text) - 1; $i++){
					if(substr(strtolower($text[$i]), 0, 5) == 'team:'){
						$text[$i] = str_replace('team:', '', strtolower($text[$i]));
						$team = _hitbox_get_teammembers($text[$i]);
						$channel = array_merge($channel, $team);
					}else{
						$channel[] = $text[$i];
					}
				}
				
				for($i = 0; $i <= count($channel) - 1; $i++){
					$return[] = _hitbox_status($channel[$i], $instance);
				}
				
				set_transient($cache_key, $return, get_option('sthw_cache_lifetime'));
				
			}else{
				$return = get_transient($cache_key);
			}
			
			for($i = 0; $i <= count($return) - 1; $i++){
				echo $return[$i];
			}
			
			echo '</ul>
				</div>';
		}else{
			echo '<p class="st_hitbox_widget_text">No channel set!</p>';
		}

		echo $after_widget;
	}
}

add_action('init', '_sthw_translate');
add_action('widgets_init', create_function('', 'return register_widget("st_hitbox_widget");'));
add_action('wp_enqueue_scripts', '_sthw_add_stylesheet');
add_action('admin_menu', '_sthw_options_page');
add_shortcode('hitbox', '_sthw_shortcode');
register_activation_hook(HITBOX_TV_WIDGET_PATH_FULL, '_sthw_install');
register_deactivation_hook(HITBOX_TV_WIDGET_PATH.'/uninstall.php', '_sthw_uninstall');
register_uninstall_hook(HITBOX_TV_WIDGET_PATH.'/uninstall.php', '_sthw_uninstall');
?>