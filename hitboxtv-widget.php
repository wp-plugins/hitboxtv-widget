<?php
/*
Plugin Name: Hitbox.TV Widget
Plugin URI: http://wordpress.org/plugins/hitboxtv-widget/
Description: Hitbox.TV status widget.
Version: 1.2
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

class st_hitbox_widget extends WP_Widget {
	function st_hitbox_widget() {
        parent::WP_Widget(false, $name = __('Hitbox.TV Widget', 'wp_widget_plugin') );
    }
	
	function form($instance) {
		if( $instance) {
			$title = esc_attr($instance['title']);
			$text = esc_attr($instance['text']);
		} else {
			$title = '';
			$text = '';
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
<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		return $instance;
	}
	
	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if( $text ) {
			require_once(plugin_dir_path(__FILE__) . 'includes/functions.php');
			define('HITBOX_TV_WIDGET_PATH', plugin_dir_path( __FILE__ ));
			define('HITBOX_TV_WIDGET_URI', plugins_url('', __FILE__));
			
			$text = explode( ',', trim($text) );
			
			echo '<div class=\"st-hitbox-widget-holder\">
					<ul>';
					
			for( $i = 0; $i <= count($text) - 1; $i++ ){
				echo _hitbox_status($text[$i]);
			}
			
			echo '</ul>
				</div>';
		} else {
			echo '<p class="wp_widget_plugin_text">No channel set!</p>';
		}
		
		echo $after_widget;
	}
}

add_action('widgets_init', create_function('', 'return register_widget("st_hitbox_widget");'));
add_action('wp_enqueue_scripts', '_sthw_add_stylesheet');

function _sthw_add_stylesheet() {
	wp_enqueue_style('st-hitbox-widget', plugins_url('style.css', __FILE__));
}
?>