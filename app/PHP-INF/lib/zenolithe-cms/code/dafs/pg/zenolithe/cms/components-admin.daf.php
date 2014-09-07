<?php
function select_component_by_type($siteId, $type) {
	$sql = 'SELECT *
    		FROM cms_components
    		WHERE cpt_site_id='.quote_smart($siteId).'
    		  AND cpt_type = '.quote_smart($type);
	$component = null;
	$result = null;

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		$component = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		pg_freeresult($result);
	}

	return $component;
}

function select_components_by_site_id_and_role($siteId, $role) {
	$sql = 'SELECT *
    		FROM cms_components
    		WHERE cpt_site_id='.quote_smart($siteId).'
    		  AND cpt_role = '.quote_smart($role).'
				ORDER BY cpt_name';
	$components = array();
	$result = null;

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
	    while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $components[] = $row;
        }
		pg_freeresult($result);
	}

	return $components;
}

function insert_component($cpt_site_id, $cpt_name, $cpt_type, $cpt_role, $cpt_class, $cpt_substitute_id, $cpt_supported_langs, $cpt_parameter) {
	$result = null;
	$id = 0;
	$sql = 'INSERT INTO cms_components
	        (cpt_site_id, cpt_name, cpt_type, cpt_role, cpt_class, cpt_substitute_id, cpt_supported_langs, cpt_parameter)
	        VALUES ('.quote_smart($cpt_site_id).', '.quote_smart($cpt_name).', '.quote_smart($cpt_type).', '.quote_smart($cpt_role)
	        . ', '.quote_smart($cpt_class).', '.quote_smart($cpt_substitute_id).', '.quote_smart($cpt_supported_langs)
	        . ', '.quote_smart($cpt_parameter).') RETURNING cpt_id';
	
	$pqConn = db_connect();
	
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		$tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$id = $tmp['cpt_id'];
		pg_freeresult($result);
	}

	return $id;
}

function update_component($id, $class, $name, $substituteId, $supportedLangs, $parameter) {
	$result = null;
	$sql = 'UPDATE cms_components '
	     . 'SET cpt_name = ' . quote_smart($name) . ', '
		 . '    cpt_class = '.quote_smart($class) . ', '
	     . '    cpt_substitute_id = '.quote_smart($substituteId) . ', '
	     . '    cpt_supported_langs = '.quote_smart($supportedLangs).', '
	     . '    cpt_parameter = '.quote_smart($parameter)
		 . 'WHERE cpt_id = '.quote_smart($id);
	$pqConn = db_connect();
	
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function update_component_parameter_and_langs($id, $parameter, $supportedLangs) {
	$sql = 'UPDATE cms_components '
	. 'SET cpt_parameter = '.quote_smart($parameter).', '
	. '   cpt_supported_langs = '.quote_smart($supportedLangs).' '
	. 'WHERE cpt_id = '.quote_smart($id);
	$result = null;
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function update_component_parameter($id, $parameter) {
	$sql = 'UPDATE cms_components '
	     . 'SET cpt_parameter = '.quote_smart($parameter).' '
	     . 'WHERE cpt_id = '.quote_smart($id);
	$result = null;
	$pqConn = db_connect();
	
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function delete_component($id) {
    $result = null;
    $sql = 'DELETE FROM cms_components
    		WHERE cpt_id = '. quote_smart($id);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}
?>
