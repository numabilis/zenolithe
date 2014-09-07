<?php
function select_all_menus_by_parent($siteId, $parentGroup) {
	$sql = 'SELECT *
	            FROM menus
	            WHERE mnu_site_id = '.quote_smart($siteId).'
	              AND mnu_parent_group = '.quote_smart($parentGroup).'
	            ORDER BY mnu_order';
	$pqConn = db_connect();
	$menus = array();
	$result = null;

	$result = pg_query($pqConn, $sql);
	if(!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
			$menus[] = $row;
		}
	}

	return $menus;
}

function select_max_menu_order($siteId, $parentGroup) {
	$sql = 'SELECT MAX(mnu_order) as order
            FROM menus
            WHERE mnu_site_id = '.quote_smart($siteId).'
              AND mnu_parent_group = '.quote_smart($parentGroup);
	$pqConn = db_connect();
	$order = 0;
	$result = null;

	$result = pg_query($pqConn, $sql);
	if(!$result) {
		error("pg : ".$sql);
	} else {
		$tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$order = $tmp['order'];
	}

	return $order;
}
?>