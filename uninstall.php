<?php
/*
Copyright (C) 2014 SpiffyTek

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
 
function _sthw_uninstall(){
	delete_option('sthw_cache_enable');
	delete_option('sthw_cache_lifetime');
	delete_option('sthw_hide_unknown');
}
?>