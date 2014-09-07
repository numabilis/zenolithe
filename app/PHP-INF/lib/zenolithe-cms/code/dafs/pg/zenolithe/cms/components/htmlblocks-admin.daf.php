<?php
function insert_htmlblock($cpt_id, $lang, $title, $content) {
	$sql = 'INSERT INTO cms_htmlblocks (hbk_cpt_id, hbk_lang, hbk_title, hbk_content) '
	     . 'VALUES ('.quote_smart($cpt_id).', '.quote_smart($lang).', '.quote_smart($title).', '.quote_smart($content).')';
	$result = null;
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function select_htmlblocks_by_site_id($siteId) {
	$sql = 'SELECT cms_htmlblocks.*
    				FROM cms_htmlblocks, cms_components
    			 WHERE cpt_site_id='.quote_smart($siteId).'
    		     AND hbk_cpt_id = cpt_id';
	$blocks = array();
	$result = null;

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if(!$result) {
		error("pg : ".$sql);
	} else {
		while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
			$blocks[] = $row;
		}
		pg_freeresult($result);
	}

	return $blocks;
}

function update_htmlblock($cpt_id, $lang, $title, $content) {
	$sql = 'UPDATE cms_htmlblocks '
		 . 'SET hbk_title = '.quote_smart($title).', '
	     . '    hbk_content = '.quote_smart($content).' '
	     . 'WHERE hbk_cpt_id = '.quote_smart($cpt_id)
		 . ' AND hbk_lang='.quote_smart($lang);
	$result = null;
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function delete_htmlblock($cpt_id, $lang) {
	$sql = 'DELETE FROM cms_htmlblocks
					WHERE hbk_cpt_id = '.quote_smart($cpt_id).'
					AND hbk_lang = '.quote_smart($lang);
	$result = null;
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function delete_all_htmlblock($id) {
	$result = null;
	$sql = 'DELETE FROM cms_htmlblocks
    		WHERE hbk_cpt_id = '. quote_smart($id);
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}
?>