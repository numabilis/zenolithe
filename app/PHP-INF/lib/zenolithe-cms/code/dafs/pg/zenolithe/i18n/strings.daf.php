<?php
function select_strings($siteId, $lang) {
	$sql = 'SELECT str_name, str_value
						FROM cms_strings
					 WHERE str_lang = '.quote_smart($lang).'
						 AND str_site_id = '.quote_smart($siteId).' OR str_site_id = 1
				ORDER BY str_site_id DESC';
	$pqConn = db_connect();
	$strings = array();
	$result = null;

	$result = pg_query($pqConn, $sql);
	if(!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
			$strings[$row['str_name']] = $row['str_value'];
		}
		pg_freeresult($result);
	}

	return $strings;
}
?>
