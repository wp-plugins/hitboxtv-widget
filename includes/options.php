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
 
function _sthw_install(){
	add_option('sthw_cache_enable', '0');
	add_option('sthw_cache_lifetime', '300');
	add_option('sthw_hide_unknown', '1');
}

function _sthw_options_page() {
	add_options_page('Hitbox.TV Widget Settings', 'Hitbox.TV Widget', 'manage_options', 'sthw-options', '_sthw_options_page_show' );
}

function _sthw_options_page_show(){
	if(!current_user_can('manage_options')){
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}

	if(sanitize_text_field($_POST['submitted']) == 'true'){
		$cache_enable = sanitize_text_field($_POST['sthw_cache_enable']);
		if($cache_enable == '1'){
			update_option('sthw_cache_enable', $cache_enable);
		}else{
			update_option('sthw_cache_enable', '0');
		}
		
		$cache_lifetime = intval($_POST['sthw_cache_lifetime']);
		if($_POST['sthw_cache_lifetime'] != get_option('sthw_cache_lifetime')){
			if($cache_lifetime != 0){
				update_option('sthw_cache_lifetime', $cache_lifetime);
			}
		}
		
		$hide_unknown = sanitize_text_field($_POST['sthw_hide_unknown']);
		if($hide_unknown == '1'){
			update_option('sthw_hide_unknown', $hide_unknown);
		}else{
			update_option('sthw_hide_unknown', '0');
		}
		
		$ids = array_keys(get_option('widget_st_hitbox_widget'));
		for($i = 0; $i <= count($ids) - 1; $i++){
			if(is_numeric($ids[$i])){
				delete_transient('st_hitbox_widget-'.$ids[$i]);
			}
		}
	}
	
	echo '<div class="wrap"><h2>Hitbox.TV Widget Settings</h2>';
?>
	<form method="post" action="">
		<input type="hidden" name="submitted" value="true">
		<h3>Cache</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Enable cache', 'st_hitbox_widget'); ?></th>
				<td><input type="checkbox" name="sthw_cache_enable" value="1" <?php checked('1', get_option('sthw_cache_enable')); ?>></input></td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Cache lifetime', 'st_hitbox_widget'); ?></th>
				<td><input type="text" name="sthw_cache_lifetime" value="<?php echo get_option('sthw_cache_lifetime'); ?>" /><?php _e('(seconds)', 'st_hitbox_widget'); ?></td>
			</tr>
		</table>
		<h3>Misc</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Hide unknown channels', 'st_hitbox_widget'); ?></th>
				<td><input type="checkbox" name="sthw_hide_unknown" value="1" <?php checked('1', get_option('sthw_hide_unknown')); ?>></input></td>
			</tr>
		</table>
	<?php submit_button(); ?>
	</form>
<?php
	echo '<p>v'._sthw_version().'</p>';
	echo '</div>';
}
?>