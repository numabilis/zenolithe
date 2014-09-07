<?php
function select_contexts_by_site_id($id) {
	$sql = 'SELECT cms_contexts.*
						FROM cms_contexts, cms_layouts
						WHERE lay_site_id = '.$id.'
						  AND ctx_id = lay_id';
  $result = null;
  $pqConn = db_connect();
  $contexts = array();
  
  $result = pg_query($pqConn, $sql);
  if(!$result) {
  	error("pg : ".$sql);
  } else {
  	while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
  		$contexts[] = $row;
  	}
  	pg_freeresult($result);
  }
  
  return $contexts;
}

function insert_context($id, $componentId, $zone, $class, $order=-1) {
    $result = null;
    if($order == -1) {
    	$sql = 'INSERT INTO cms_contexts
    	    		(ctx_id, ctx_component_id, ctx_zone, ctx_order, ctx_class)
    	    		VALUES
    	    		(' . quote_smart($id) . ', ' . quote_smart($componentId) . ', ' . quote_smart($zone) . ',
    	    		 (SELECT COALESCE(MAX(ctx_order)+1, 0) FROM cms_contexts WHERE ctx_id = ' . quote_smart($id) . ' AND ctx_zone = ' . quote_smart($zone) . '),
    	    		  ' . quote_smart($class) .')';
    } else {
    	$sql = 'INSERT INTO cms_contexts
    	    		(ctx_id, ctx_component_id, ctx_zone, ctx_order, ctx_class)
    	    		VALUES
    	    		(' . quote_smart($id) . ', ' . quote_smart($componentId) . ', ' . quote_smart($zone) . ',
    	    		 ' . quote_smart($order) .', ' . quote_smart($class) .')';
    }
    
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function delete_context($id, $componentId, $zone, $order) {
    $result = null;
    $sql = 'DELETE FROM cms_contexts
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_component_id = '. quote_smart($componentId) . '
    		  AND ctx_zone = '. quote_smart($zone) . '
    		  AND ctx_order = '. quote_smart($order);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function select_max_context_order($id, $zone) {
    $sql = 'SELECT MAX(ctx_order) as order
            FROM cms_contexts
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_zone = '. quote_smart($zone);
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

function decrease_contexts_order($id, $zone, $order) {
    $result = null;
    $sql = 'UPDATE cms_contexts
    		SET ctx_order = ctx_order - 1
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_zone = '. quote_smart($zone) . '
    		  AND ctx_order > '. quote_smart($order);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function decrease_context_order($id, $zone, $order) {
    $result = null;
    $sql = 'UPDATE cms_contexts
    		SET ctx_order = ctx_order - 1
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_zone = '. quote_smart($zone) . '
    		  AND ctx_order = '. quote_smart($order);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function increase_context_order($id, $zone, $order) {
    $result = null;
    $sql = 'UPDATE cms_contexts
    		SET ctx_order = ctx_order + 1
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_zone = '. quote_smart($zone) . '
    		  AND ctx_order = '. quote_smart($order);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function increase_context_component_order($id, $componentId, $zone) {
    $result = null;
    $sql = 'UPDATE cms_contexts
    		SET ctx_order = ctx_order + 1
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_component_id = '. quote_smart($componentId). '
    		  AND ctx_zone = '. quote_smart($zone);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function decrease_context_component_order($id, $componentId, $zone) {
    $result = null;
    $sql = 'UPDATE cms_contexts
    		SET ctx_order = ctx_order -1
    		WHERE ctx_id = '. quote_smart($id) . '
    		  AND ctx_component_id = '. quote_smart($componentId). '
    		  AND ctx_zone = '. quote_smart($zone);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function update_class_context($id, $componentId, $zone, $order, $class) {
    $result = null;
    $sql = 'UPDATE cms_contexts
        		SET ctx_class = '. quote_smart($class) . '
        		WHERE ctx_id = '. quote_smart($id) . '
        		  AND ctx_component_id = '. quote_smart($componentId). '
        		  AND ctx_zone = '. quote_smart($zone) . '
    			  AND ctx_order = ' . quote_smart($order);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function update_component_context($id, $componentId, $zone, $order, $newComponentId) {
    $result = null;
    $sql = 'UPDATE cms_contexts
        		SET ctx_component_id = '. quote_smart($newComponentId) . '
        		WHERE ctx_id = '. quote_smart($id) . '
        		  AND ctx_component_id = '. quote_smart($componentId). '
        		  AND ctx_zone = '. quote_smart($zone) . '
    			  AND ctx_order = ' . quote_smart($order);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function select_contexts_by_id($id) {
    $sql = 'SELECT *
            FROM cms_contexts
    		WHERE ctx_id = '. quote_smart($id) . '
    		  ORDER BY ctx_zone, ctx_order';
    $pqConn = db_connect();
    $contexts = array();
    $result = null;
    
    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $contexts[] = $row;
        }
        pg_freeresult($result);
    }
    
    return $contexts;
}

/*
function get_next_context_id() {
    $result = null;
    $sql = 'SELECT nextval(\'ctx_id_seq\'); ';
    $pqConn = db_connect();
    $nextval = 0;

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        $tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        $nextval = $tmp['nextval'];
        pg_freeresult($result);
    }

    return $nextval;
}
*/
?>