<?php
/*
Copyright (C) 2014 SpiffyTek

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

function _hitbox_status($channel = false, $instance = false){
	$name = $channel;

	$api = 'http://api.hitbox.tv/media/live/'.$name;
	$hitbox = wp_remote_get($api, array('user-agent' => 'WP Hitbox status widget/'._sthw_version()));
	
	if(wp_remote_retrieve_response_code($hitbox) == '404'){
		if(get_option('sthw_hide_unknown') != '1'){
			return '<li class="st-hitbox-widget-list-item"><span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$name.'</a></span><span class="st-hitbox-widget-indicator">'.__('Unknown channel', 'st_hitbox_widget').'</span></li>';
		}else{
			return false;
		}
	}elseif(wp_remote_retrieve_response_code($hitbox) != '200'){
		return '<li class="st-hitbox-widget-list-item"><span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$name.'</a></span><span class="st-hitbox-widget-indicator">'.__('Failed to connect to hitbox.tv api.', 'st_hitbox_widget').'</span></li>'; 
	}
	
	$stream = json_decode(wp_remote_retrieve_body($hitbox), true);
	
	if($stream['livestream'][0]['media_is_live'] != 0){
		$boxart = 'http://edge.sf.hitbox.tv'.$stream['livestream'][0]['media_thumbnail'];
		$txt = '<span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$stream['livestream'][0]['media_user_name'].'</a></span>';
		$txt .= '<span class="st-hitbox-widget-indicator">'.$stream['livestream'][0]['media_views'].'</span>';
		if($instance['hide_message'] == 0){
			$txt .= '<span class="st-hitbox-widget-status">'.$stream['livestream'][0]['media_status'].'</span>';
		}
		if(!empty($stream['livestream'][0]['category_name'])){
			$txt .= '<span class="st-hitbox-widget-category">'.$stream['livestream'][0]['category_name'].'</span>';
		}
		if($instance['hide_preview'] == 0){
			$txt .= '<span class="st-hitbox-widget-image"><a target="_blank" href="http://www.hitbox.tv/'.$name.'"><img src="'.$boxart.'" alt=""></a></span>';
		}
	}elseif($stream['livestream'][0]['media_is_live'] == 0 && $instance['hide_offline'] == 1){
		return '';
	}else{
		$txt = '<span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$stream['livestream'][0]['media_user_name'].'</a></span>';
		$txt .= '<span class="st-hitbox-widget-indicator">'.__('Offline', 'st_hitbox_widget').'</span>';
	}

	$return = '<li class="st-hitbox-widget-list-item">
						  '.$txt.'
				</li>';
		
	return $return;
}

function _hitbox_get_teammembers($team){
	$api = 'http://api.hitbox.tv/team/'.$team;
	$hitbox = wp_remote_get($api, array('user-agent' => 'WP Hitbox status widget/'._sthw_version()));
	
	if(wp_remote_retrieve_response_code($hitbox) != '200'){
		return false; 
	}
	
	$list = json_decode(wp_remote_retrieve_body($hitbox), true);
	
	for($i = 0; $i <= count($list['members']) - 1; $i++){
		if($list['members'][$i]['user_is_broadcaster'] == 'true'){
			$return[] = $list['members'][$i]['user_name'];
		}
	}
	
	return $return;
}

function _sthw_shortcode($atts, $content = ''){
	$content = preg_replace(array('/\s/', '/\xA0/', '/\xC2/'), '', $content);
	$args = shortcode_atts(array(
		'video' => 'true',
		'vwidth' => '640',
		'vheight' => '360',
		'chat' => 'true',
		'cwidth' => '360',
		'cheight' => '640'
	), $atts, 'hitbox');

	$return = '';

	if(!empty($content)){
		if($args['video'] != 'false'){
			$return .= '<iframe width="'.$args['vwidth'].'" height="'.$args['vheight'].'" src="http://www.hitbox.tv/#!/embed/'.$content.'?autoplay=true" frameborder="0" allowfullscreen></iframe>';
		}
		if($args['chat'] != 'false'){
			$return .= '<iframe width="'.$args['cwidth'].'" height="'.$args['cheight'].'" src="http://www.hitbox.tv/embedchat/'.$content.'" frameborder="0" allowfullscreen></iframe>';
		}
		
	}else{
		$return = 'NO HITBOX CHANNEL SET!';
	}

	return $return;
}

function _sthw_add_stylesheet(){
	wp_enqueue_style('st-hitbox-widget', HITBOX_TV_WIDGET_URI.'/style.css');
}

function _sthw_version() {
	if(!function_exists('get_plugins')){
		require_once(ABSPATH.'wp-admin/includes/plugin.php');
	}
	$plugin_folder = get_plugins('/'.plugin_basename(dirname(HITBOX_TV_WIDGET_PATH_FULL)));
	$plugin_file = basename((HITBOX_TV_WIDGET_PATH_FULL));
	return $plugin_folder[$plugin_file]['Version'];
}
?>