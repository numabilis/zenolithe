<?php
function insert_gaw($pageId, $paramater) {
	$sql = 'INSERT INTO cms_google_adwords (gaw_page_id, gaw_parameter) ' . 'VALUES (' . quote_smart ( $pageId ) . ', ' . quote_smart ( $paramater ) . ')';
	$result = null;
	
	$pqConn = db_connect ();
	$result = pg_query ( $pqConn, $sql );
	if (! $result) {
		error ( "pg : " . $sql );
	} else {
		pg_freeresult ( $result );
	}
	
	return $result;
}
function update_gaw($id, $pageId, $paramater) {
	$sql = 'UPDATE cms_google_adwords
    					 SET gaw_page_id = ' . quote_smart ( $pageId ) . ',
    					     gaw_parameter = ' . quote_smart ( $paramater ) . '
    				 WHERE gaw_id = ' . quote_smart ( $id );
	$result = null;
	$pqConn = db_connect ();
	$result = pg_query ( $pqConn, $sql );
	if (! $result) {
		error ( "pg : " . $sql );
	} else {
		pg_freeresult ( $result );
	}
	
	return $result;
}
function delete_gaws($siteId) {
	$result = null;
	$sql = 'DELETE FROM cms_google_adwords
    		 	WHERE gaw_page_id IN (SELECT pge_id FROM cms_pages WHERE pge_site_id = '.quote_smart($siteId).')';
	$pqConn = db_connect ();
	
	$result = pg_query ( $pqConn, $sql );
	if (! $result) {
		error ( "pg : " . $sql );
	} else {
		pg_freeresult ( $result );
	}
}
?>