<?php
/*
Plugin Name: Hitbox.TV Widget
Plugin URI: http://wordpress.org/plugins/hitboxtv-widget/
Description: Hitbox.TV status widget.
Version: 1.3
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

class st_hitbox_widget extends WP_Widget{
	function st_hitbox_widget(){
		parent::WP_Widget(false, $name = __('Hitbox.TV Widget', 'wp_widget_plugin'));
	}
	
	function form($instance){
		if($instance){
			$title = esc_attr($instance['title']);
			$text = esc_attr($instance['text']);
			$hide_offline = esc_attr($instance['hide_offline']);
			$cache_enable = esc_attr($instance['cache_enable']);
			$cache_lifetime = esc_attr($instance['cache_lifetime']);
		}else{
			$title = '';
			$text = '';
			$hide_offline = '';
			$cache_enable = '';
			$cache_lifetime = 300;
		}
?>	
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Channel or multiple channels seperated by comma:', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('hide_offline'); ?>" name="<?php echo $this->get_field_name('hide_offline'); ?>" type="checkbox" value="1" <?php checked('1', $hide_offline); ?> />
			<label for="<?php echo $this->get_field_id('hide_offline'); ?>"><?php _e('Hide offline channels', 'wp_widget_plugin'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('cache_enable'); ?>" name="<?php echo $this->get_field_name('cache_enable'); ?>" type="checkbox" value="1" <?php checked('1', $cache_enable); ?> />
			<label for="<?php echo $this->get_field_id('cache_enable'); ?>"><?php _e('Enable cache', 'wp_widget_plugin'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cache_lifetime'); ?>"><?php _e('Cache lifetime:', 'wp_widget_plugin'); ?>
			<input style="width: 30%" class="widefat" id="<?php echo $this->get_field_id('cache_lifetime'); ?>" name="<?php echo $this->get_field_name('cache_lifetime'); ?>" type="text" value="<?php echo $cache_lifetime; ?>" /><?php _e('(seconds)', 'wp_widget_plugin'); ?></label>
		</p>
<?php
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['hide_offline'] = strip_tags($new_instance['hide_offline']);
		$instance['cache_enable'] = strip_tags($new_instance['cache_enable']);
		$instance['cache_lifetime'] = strip_tags($new_instance['cache_lifetime']);
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
			define('HITBOX_TV_WIDGET_PATH', plugin_dir_path( __FILE__ ));
			define('HITBOX_TV_WIDGET_URI', plugins_url('', __FILE__));
			require_once(HITBOX_TV_WIDGET_PATH.'includes/functions.php');
			
			$text = explode(',', preg_replace('/\s/', '', $text));
			
			echo '<div class="st-hitbox-widget-holder">
					<ul>';				
					
			if(!get_transient($cache_key) || $instance['cache_enable'] != 1){
					
				for($i = 0; $i <= count($text) - 1; $i++){
					$return[] = _hitbox_status($text[$i], $instance);
				}
				
				set_transient($cache_key, $return, $instance['cache_lifetime']);
				
			}else{
				$return = get_transient($cache_key);
			}
			
			for($i = 0; $i <= count($return) - 1; $i++){
				echo $return[$i];
			}
			
			echo '</ul>
				</div>';
		}else{
			echo '<p class="wp_widget_plugin_text">No channel set!</p>';
		}
		
		echo $after_widget;
	}
}

add_action('widgets_init', create_function('', 'return register_widget("st_hitbox_widget");'));
add_action('wp_enqueue_scripts', '_sthw_add_stylesheet');

function _sthw_add_stylesheet(){
	wp_enqueue_style('st-hitbox-widget', plugins_url('style.css', __FILE__));
}
?>