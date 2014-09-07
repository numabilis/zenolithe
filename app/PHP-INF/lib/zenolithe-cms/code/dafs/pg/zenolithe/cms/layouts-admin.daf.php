<?php
function select_all_layouts($siteId) {
	$sql = 'SELECT *
            FROM cms_layouts
            WHERE lay_site_id = '.quote_smart($siteId).'
            ORDER BY lay_name';
	$pqConn = db_connect();
    $layouts = array();
    $result = null;
    
    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $layouts[] = $row;
        }
    }

    return $layouts;
}

function select_layout_by_id($id) {
	$sql = 'SELECT *
            FROM cms_layouts
            WHERE lay_id = '.quote_smart($id);
	$pqConn = db_connect();
    $layout = null;
    $result = null;
    
    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        $layout = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    }

    return $layout;
}

function select_layouts_by_component_id($cptId) {
	$sql = 'SELECT cms_layouts.*
            FROM cms_layouts, cms_contexts
            WHERE lay_id = ctx_id
							AND ctx_component_id = '.quote_smart($cptId);
	$pqConn = db_connect();
  $layouts = null;
  $result = null;
  
  $result = pg_query($pqConn, $sql);
  if(!$result) {
    error("pg : ".$sql);
  } else {
    while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
    	$layouts[] = $row;
    }
  }

  return $layouts;
}

function insert_layout($name, $type, $siteId) {
    $result = null;
    $sql = 'INSERT INTO cms_layouts
    		(lay_site_id, lay_name, lay_type)
    		VALUES
    		(' . quote_smart($siteId) . ', ' . quote_smart($name) . ', ' . quote_smart($type) . ')
    		RETURNING lay_id';
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        $tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        $id = $tmp['lay_id'];
        pg_freeresult($result);
    }

    return $id;
}

function update_layout($id, $name) {
    $result = null;
    $sql = 'UPDATE cms_layouts
    		SET lay_name =  ' . quote_smart($name) . '
    		WHERE lay_id = '.quote_smart($id);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}
?>