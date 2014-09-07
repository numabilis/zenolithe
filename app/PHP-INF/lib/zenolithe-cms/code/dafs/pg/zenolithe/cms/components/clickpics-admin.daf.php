<?php
function insert_clickpic($cpt_id, $lang, $picUrl, $linkUrl) {
	$sql = 'INSERT INTO cms_clickpics (ckp_cpt_id, ckp_lang, ckp_picture_url, ckp_link_url) '
	     . 'VALUES ('.quote_smart($cpt_id).', '.quote_smart($lang).', '.quote_smart($picUrl).', '.quote_smart($linkUrl).')';
	$result = null;
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function select_clickpics_by_site_id($siteId) {
	$sql = 'SELECT cms_clickpics.*
	    				FROM cms_clickpics, cms_components
	    			 WHERE cpt_site_id='.quote_smart($siteId).'
	    		     AND ckp_cpt_id = cpt_id';
	$result = null;
	$clickpics = array();

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
			$clickpics[] = $row;
		}
		pg_freeresult($result);
	}

	return $clickpics;
}

function update_clickpic($cpt_id, $lang, $picUrl, $linkUrl) {
    $sql = 'UPDATE cms_clickpics '
         . 'SET ckp_picture_url = '.quote_smart($picUrl).', '
         . '    ckp_link_url = '.quote_smart($linkUrl).' '
         . 'WHERE ckp_cpt_id = '.quote_smart($cpt_id)
         . ' AND ckp_lang = '.quote_smart($lang);
    $result = null;
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function delete_clickpics($cpt_id) {
    $sql = 'DELETE from cms_clickpics WHERE ckp_cpt_id = '.quote_smart($cpt_id);
    $result = null;

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }

    return $result;
}
?>
