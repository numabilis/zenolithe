<?php
function insert_multiclickpic($cpt_id, $lang, $picUrl, $linkUrl) {
	$sql = 'INSERT INTO cms_multiclickpics (mcp_cpt_id, mcp_lang, mcp_picture_url, mcp_link_url) '
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

function select_multiclickpics_by_site_id($siteId) {
	$sql = 'SELECT cms_multiclickpics.*
	    				FROM cms_multiclickpics, cms_components
	    			 WHERE cpt_site_id='.quote_smart($siteId).'
	    		     AND mcp_cpt_id = cpt_id';
	$result = null;
	$multiclickpics = array();

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
			$multiclickpics[] = $row;
		}
		pg_freeresult($result);
	}

	return $multiclickpics;
}

function update_multiclickpic($mcp_id, $picUrl, $linkUrl) {
    $sql = 'UPDATE cms_multiclickpics '
         . 'SET mcp_picture_url = '.quote_smart($picUrl).', '
         . '    mcp_link_url = '.quote_smart($linkUrl).' '
         . 'WHERE mcp_id = '.quote_smart($mcp_id);
    $result = null;
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function delete_multiclickpic($mcp_id) {
    $sql = 'DELETE FROM cms_multiclickpics WHERE mcp_id = '.quote_smart($mcp_id);
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

function delete_all_multiclickpics($id) {
    $result = null;
    $sql = 'DELETE FROM cms_multiclickpics
    		WHERE mcp_cpt_id = '. quote_smart($id);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}
?>