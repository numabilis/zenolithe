<?php
function insert_gaq($cpt_id, $lang, $category, $action, $label, $value) {
	$sql = 'INSERT INTO cms_googleanalytics (gaq_cpt_id, gaq_lang, gaq_category, gaq_action, gaq_label, gaq_value) '
	     . 'VALUES ('.quote_smart($cpt_id).', '.quote_smart($lang).', '.quote_smart($category).', '.quote_smart($action)
	     . ', '.quote_smart($label).', '.quote_smart($value).')';
	$result = null;
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function update_gaq($cpt_id, $lang, $category, $action, $label, $value) {
    $sql = 'UPDATE cms_googleanalytics '
         . 'SET gaq_category = '.quote_smart($category).', '
         . '    gaq_action = '.quote_smart($action).' '
         . '    gaq_label = '.quote_smart($label).' '
         . '    gaq_value = '.quote_smart($value).' '
         . 'WHERE gaq_cpt_id = '.quote_smart($cpt_id)
         . ' AND gaq_lang = '.quote_smart($lang);
    $result = null;
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function select_gaq_by_site_id($siteId) {
	$sql = 'SELECT cms_googleanalytics.*
	    				FROM cms_googleanalytics, cms_components
	    			 WHERE cpt_site_id='.quote_smart($siteId).'
	    		     AND gaq_cpt_id = cpt_id';
	$result = null;
	$gaqs = array();

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
			$gaqs[] = $row;
		}
		pg_freeresult($result);
	}

	return $gaqs;
}

function delete_all_gaq($id) {
    $result = null;
    $sql = 'DELETE FROM cms_googleanalytics
    		WHERE gaq_cpt_id = '. quote_smart($id);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}
?>
