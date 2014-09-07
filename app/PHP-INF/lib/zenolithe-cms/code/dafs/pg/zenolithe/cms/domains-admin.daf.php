<?php
function insert_domain($mnem, $base, $languages, $siteId=0) {
	$result = null;
	$id = 0;
	$sql = 'INSERT INTO cms_domains
	        (dom_mnem, dom_base, dom_languages, dom_site_id)
	        VALUES ('.quote_smart($mnem).', '.quote_smart($base).', '.quote_smart($languages).', '.quote_smart($siteId).')
					RETURNING dom_id';
	
	$pqConn = db_connect();
	
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		$tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$id = $tmp['dom_id'];
		pg_freeresult($result);
	}

	return $id;
}

function select_domain_by_id($id) {
    $domain = null;
    $result = null;
    $sql = 'SELECT *
    		FROM cms_domains
    		WHERE dom_id = '.quote_smart($id);
    
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        $domain = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        pg_freeresult($result);
    }

    return $domain;
}

function select_all_domains() {
    $domains = null;
    $result = null;
    $sql = 'SELECT * FROM cms_domains';
    
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $domains[] = $row;
        }
        pg_freeresult($result);
    }

    return $domains;
}
?>
