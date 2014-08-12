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

function _hitbox_status($channel = false){
	$name = $channel;

	$api = 'http://api.hitbox.tv/media/live/'.$name;
	$hitbox = _file_get_contents_curl($api, 'WP Hitbox status widget');
	
	if($hitbox['header']['http_code'] == '404'){
		return '<li class="st-hitbox-widget-list-item"><span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$name.'</a></span><span class="st-hitbox-widget-indicator">Unknown channel</span></li>'; 
	}elseif($hitbox['header']['http_code'] != '200'){
		return '<li class="st-hitbox-widget-list-item"><span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$name.'</a></span><span class="st-hitbox-widget-indicator">Failed to connect to hitbox.tv api.</span></li>'; 
	}
	
	$stream = json_decode($hitbox['data'], true);
	
	if($stream['livestream'][0]['media_is_live'] != 0){
		$txt = '<span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$stream['livestream'][0]['media_user_name'].'</a></span>';
		$txt .= '<span class="st-hitbox-widget-indicator">'.$stream['livestream'][0]['media_views'].'</span>';
		$txt .= '<span class="st-hitbox-widget-status">'.$stream['livestream'][0]['media_status'].'</span>';
		if(!empty($stream['livestream'][0]['category_name'])){
			$txt .= '<span class="st-hitbox-widget-category">'.$stream['livestream'][0]['category_name'].'</span>';
			$boxart = 'http://edge.sf.hitbox.tv'.$stream['livestream'][0]['media_thumbnail'];
		}else{
			$boxart = HITBOX_TV_WIDGET_URI.'/assets/images/unknown.jpg';
		}
		$txt .= '<span class="st-hitbox-widget-image"><a target="_blank" href="http://www.hitbox.tv/'.$name.'"><img src="'.$boxart.'" alt=""></a></span>';
	}
	else{
		$txt = '<span class="st-hitbox-widget-title"><a target="_blank" href="http://www.hitbox.tv/'.$name.'">'.$stream['livestream'][0]['media_user_name'].'</a></span>';
		$txt .= '<span class="st-hitbox-widget-indicator">Offline</span>';
		$boxart = HITBOX_TV_WIDGET_URI.'/assets/images/offline.jpg';
		/* $txt .= '<span class="st-hitbox-widget-image"><a target="_blank" href="http://www.hitbox.tv/'.$name.'"><img src="'.$boxart.'" alt=""></a></span>'; */
	}

	$return = '<li class="st-hitbox-widget-list-item">
						  '.$txt.'
				</li>';
		
	return $return;
}



/* FUNCTIONS */
function _file_get_contents_curl($url, $agent = 'My Agent', $cookie = false, $post = false){
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_TIMEOUT, 2);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	if($cookie){
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	}
	curl_setopt($ch, CURLOPT_URL, $url);
	if($post){
	   curl_setopt($ch, CURLOPT_POST, true);
	   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	 
	$data = curl_exec($ch);
	$header = curl_getinfo($ch);
	curl_close($ch);
	 
	return array('data' => $data, 'header' => $header);
}	
?>