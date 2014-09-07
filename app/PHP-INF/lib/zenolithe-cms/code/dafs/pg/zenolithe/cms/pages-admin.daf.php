<?php
function select_all_pages_by_parent($siteId, $parentGroup) {
    $sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_site_id = '.quote_smart($siteId).'
	              AND pge_parent_group = '.quote_smart($parentGroup).'
	            ORDER BY pge_order';
    $pqConn = db_connect();
    $pages = array();
    $result = null;
    
    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $pages[] = $row;
        }
    }

    return $pages;
}

function select_pages_by_uri($siteId, $uri) {
    $sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_site_id = '.quote_smart($siteId).'
	              AND pge_uri = '.quote_smart($uri).'
	            ORDER BY pge_order';
    $pqConn = db_connect();
    $pages = array();
    $result = null;
    
    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $pages[] = $row;
        }
    }

    return $pages;
}

function select_page_by_id($id) {
    $sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_id = '.quote_smart($id);
    $pqConn = db_connect();
    $page = null;
    $result = null;

    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        $page = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    }

    return $page;
}

function select_page_by_parent_group_and_lang($siteId, $group, $lang) {
    $sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_site_id = '.quote_smart($siteId).'
                  AND pge_group = '.quote_smart($group).'
                  AND pge_lang = '.quote_smart($lang);
    $pqConn = db_connect();
    $page = null;
    $result = null;

    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        $page = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    }

    return $page;
}

function select_all_pages_by_group($siteId, $group) {
    $sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_site_id = '.quote_smart($siteId).'
                  AND pge_group = '.quote_smart($group);
    $pqConn = db_connect();
    $pages = array();
    $result = null;

    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $pages[] = $row;
        }
    }

    return $pages;
}

function select_pages_by_site_id($siteId) {
	$sql = 'SELECT cms_pages.*
	    				FROM cms_pages
	    			 WHERE pge_site_id='.quote_smart($siteId).'
						 ORDER BY pge_group';
	$result = null;
	$pages = array();

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
			$pages[] = $row;
		}
		pg_freeresult($result);
	}

	return $pages;
}

function update_page($id, $uri, $uriPart, $properties, $title, $shortTitle, $menu, $status, $publishDate, $description, $keywords, $metaTitle, $robots) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_uri =  ' . quote_smart($uri) . ',
    			pge_uri_part =  ' . quote_smart($uriPart) . ',
    			pge_ctrl_properties = ' . quote_smart($properties) . ',
    			pge_title = ' . quote_smart($title) . ',
    			pge_short_title = ' . quote_smart($shortTitle) . ',
    			pge_menu = ' . quote_smart($menu) . ',
    			pge_status = ' . quote_smart($status) . ',
    			pge_publish_date = ' . quote_smart($publishDate) . ',
    			pge_description = ' . quote_smart($description) . ',
    			pge_keywords = ' . quote_smart($keywords) . ',
    			pge_meta_title = ' . quote_smart($metaTitle) . ',
    			pge_robots = ' . quote_smart($robots) . '
    		WHERE pge_id = '.quote_smart($id);
    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function select_max_page_order($siteId, $parentGroup) {
    $sql = 'SELECT MAX(pge_order) as order
            FROM cms_pages
            WHERE pge_site_id = '.quote_smart($siteId).'
              AND pge_parent_group = '.quote_smart($parentGroup);
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

function get_next_group() {
    $result = null;
    $sql = 'SELECT nextval(\'cms_pge_group_seq\'); ';
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

function insert_page($siteId, $lang, $uri, $uriPart, $contextId, $group, $parentGroup, $title, $shortTitle, $menu, $order, $status, $publishDate, $description, $keywords, $metaTitle, $robots, $controller, $type, $parameter='') {
    $result = null;
    $sql = 'INSERT INTO cms_pages
    		(pge_site_id, pge_lang, pge_uri, pge_uri_part, pge_ctrl_properties, pge_context_id, pge_group, pge_parent_group,
    		 pge_title, pge_short_title, pge_menu, pge_order, pge_status, pge_publish_date, pge_description, pge_keywords, pge_meta_title, pge_robots, pge_controller, pge_type)
    		VALUES
    		(' . quote_smart($siteId) . ', ' . quote_smart($lang) . ', ' . quote_smart($uri) . ', ' . quote_smart($uriPart).', ';
    if($parameter) {
    	$sql .= quote_smart($parameter) . ', ';
    } else {
    	$sql .= '(SELECT pge_ctrl_properties FROM cms_pages WHERE pge_group = ' . quote_smart($group) . ' LIMIT 1), ';
    }
    $sql .= quote_smart($contextId) . ', ' . quote_smart($group) . ', ' . quote_smart($parentGroup) . ', ' . quote_smart($title) . ', ' . quote_smart($shortTitle) . ', ' . quote_smart($menu) . ',
    		 ' . quote_smart($order) . ', ' . quote_smart($status) . ', ' . quote_smart($publishDate) . ', ' . quote_smart($description) . ',
    		 ' . quote_smart($keywords) . ', ' . quote_smart($metaTitle) . ', ' . quote_smart($robots) . ', ' . quote_smart($controller) . ', ' . quote_smart($type) . ')
    		RETURNING pge_id';
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        $tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        $id = $tmp['pge_id'];
        pg_freeresult($result);
    }

    return $id;
}

function increase_children_order($siteId, $parentGroup, $order) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_order = pge_order + 1
    		WHERE pge_site_id = '.quote_smart($siteId).'
    		  AND pge_parent_group = '.quote_smart($parentGroup).'
    		  AND pge_order = '.quote_smart($order);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function decrease_order($siteId, $group) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_order = pge_order - 1
    		WHERE pge_site_id = '.quote_smart($siteId).'
    		  AND pge_group = '.quote_smart($group);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function decrease_children_order($siteId, $parentGroup, $order) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_order = pge_order - 1
    		WHERE pge_site_id = '.quote_smart($siteId).'
    		  AND pge_parent_group = '.quote_smart($parentGroup).'
    		  AND pge_order = '.quote_smart($order);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function increase_order($siteId, $group) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_order = pge_order + 1
    		WHERE pge_site_id = '.quote_smart($siteId).'
    		  AND pge_group = '.quote_smart($group);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function update_pages_context($group, $contextId) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_context_id =  ' . quote_smart($contextId) . '
    		WHERE pge_group = '.quote_smart($group);
    $pqConn = db_connect();

    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function update_pages_parameters($group, $parameters) {
	$result = null;
	$sql = 'UPDATE cms_pages
    		SET pge_ctrl_properties =  ' . quote_smart($parameters) . '
    		WHERE pge_group = '.quote_smart($group);
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}

function update_pages($group, $parameters, $contextId) {
    $result = null;
    $sql = 'UPDATE cms_pages
    		SET pge_context_id =  ' . quote_smart($contextId) . ',
    		    pge_ctrl_properties =  ' . quote_smart($parameters) . '
    		WHERE pge_group = '.quote_smart($group);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function update_pages_states($siteId, $state) {
	$result = null;
	$sql = 'UPDATE cms_pages
	    		SET pge_status =  ' . quote_smart($state) . '
	    		WHERE pge_site_id = '.quote_smart($siteId);
	$pqConn = db_connect();
	
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}


function select_pages_by_site_id_and_page_types($siteId, $pageTypes, $inlude=true) {
	$sql = 'SELECT cms_pages.*
	    				FROM cms_pages
	    			 WHERE pge_site_id='.quote_smart($siteId).'
	    			 AND pge_status = 2';
	if ($inlude){
		$sql .= ' AND pge_type in (';
	}else{
		$sql .= ' AND not pge_type in (';
	}
	
	$separator = '';
	foreach ($pageTypes as $type){
		$sql .= $separator.quote_smart($type);
		if (empty($separator)){
			$separator = ',';
		}
	}
	$sql .= ') ORDER BY pge_group';
	
	$result = null;
	$pages = array();

	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
			$pages[] = $row;
		}
		pg_freeresult($result);
	}

	return $pages;
}

function select_pages_by_site_id_and_lang($siteId, $lang) {
	$sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_site_id = '.quote_smart($siteId).'
                AND pge_lang = '.quote_smart($lang).'
				AND pge_status = 2
	            ORDER BY pge_order';
	
	$pages = array();
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
			$pages[] = $row;
		}
		pg_freeresult($result);
	}

	return $pages;
}

?>
