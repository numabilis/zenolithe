<?php
require 'code/org/zenolithe/cms/pages_definitions.php';

function select_breadcrumb($siteBase, $uri, $lang) {
// 	$key = $siteBase.'breadcrumb/'.$lang.'/'.$uri;
// 	if(!($pages = apc_fetch($key))) {
		$sql = 'WITH RECURSIVE breadcrumb(pge_group, pge_parent_group, pge_uri, pge_short_title) AS (
    					SELECT pge_group, pge_parent_group, pge_uri, pge_short_title
    						FROM cms_domains, cms_pages
    						WHERE pge_uri = '.quote_force($uri).'
    		  				AND pge_site_id = dom_site_id
    		  				AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
    		       		 	OR (pge_status = '.PAGE_STATUS_PLANNED.'
    		           	AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
    		  				AND dom_base = '.quote_smart($siteBase).'
									AND pge_lang = '.quote_smart($lang).'
  						UNION
    						SELECT p.pge_group, p.pge_parent_group, p.pge_uri, p.pge_short_title
    							FROM cms_domains, cms_pages p, breadcrumb
    							WHERE breadcrumb.pge_parent_group = p.pge_group
    			  				AND pge_site_id = dom_site_id
    			  				AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
    			       		 	OR (pge_status = '.PAGE_STATUS_PLANNED.'
    		  	         	AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
    		  					AND dom_base = '.quote_smart($siteBase).'
										AND pge_lang = '.quote_smart($lang).'
					  ) SELECT * FROM breadcrumb;';
		$pqConn = db_connect();
		$pages = array();
		$result = null;
		$result = pg_query($pqConn, $sql);

		if(!$result) {
			error("pg : ".$sql);
		} else {
			while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
				$pages[] = $row;
			}
			pg_freeresult($result);
		}

		// Mise en cache
// 		apc_store($key, $pages, 600);
// 	}

	return $pages;
}

function select_page_by_uri_and_lang ($siteBase, $uri, $lang) {
	// 	$key = $siteBase.$lang.'/'.$uri;
	// 	if(!($page = apc_fetch($key))) {
	$sql = 'SELECT *
    		FROM cms_domains, cms_pages
    		WHERE pge_uri = '.quote_force($uri).'
    		  AND pge_site_id = dom_site_id
    		  AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
    		       OR (pge_status = '.PAGE_STATUS_PLANNED.'
    		           AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
    		  AND dom_base = '.quote_smart($siteBase).'
    		  AND pge_lang = '.quote_smart($lang).'
    		ORDER BY pge_site_id DESC';
	// TODO : Uncomment for optimization !
	// 	    $sql = 'SELECT *
	// 	    				FROM cms_pages
	// 	    				INNER JOIN cms_domains ON (pge_site_id = dom_site_id) AND dom_base = '.quote_smart($siteBase).'
	// 	    				WHERE (pge_lang='.quote_smart($lang).')
	// 	    					AND (pge_status = 2 OR (pge_status = 3 AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
	// 	    					AND pge_uri = '.quote_force($uri).'
	// 	    				ORDER BY pge_site_id DESC';

	$pqConn = db_connect();
	$page = null;
	$result = null;

	$result = pg_query($pqConn, $sql);

	if(!$result) {
		error("pg : ".$sql);
	} else {
		$page = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		pg_freeresult($result);
	}
	// Mise en cache
	// 		apc_store($key, $page, 600);
	// 	}

	return $page;
}

function select_components_by_context_id($id) {
	$result = null;
	$components = array();

	if($id) {
// 		$key = 'select_components_by_context_id/'.$id;
// 		if(!($components = apc_fetch($key))) {
			$sql = 'SELECT * '
			. 'FROM cms_components, cms_contexts '
			. 'WHERE ctx_id = '.quote_smart($id)
			. ' AND ctx_component_id = cpt_id '
			. 'ORDER BY ctx_order';
			$pqConn = db_connect();
			$result = pg_query($pqConn, $sql);
			if (!$result) {
				error("pg : ".$sql.' in '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			} else {
				while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
					$components[] = $row;
				}
				pg_freeresult($result);
			}
// 			apc_store($key, $components, 600);
// 		}
	}

	return $components;
}

function select_interceptors_by_site_id($id) {
	$components = array();
	$result = null;

// 	$key = 'select_interceptors_by_site_id/'.$id;
// 	if(!($components = apc_fetch($key))) {
		$components = array();
		$sql = 'SELECT *
							FROM cms_components
						 WHERE cpt_site_id = '.quote_smart($id).'
							 AND cpt_role = \'interceptor\'
					ORDER BY cpt_id';
		$pqConn = db_connect();
		$result = pg_query($pqConn, $sql);
		if (!$result) {
			error("pg : ".$sql.' in '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		} else {
			while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
				$components[] = $row;
			}
			pg_freeresult($result);
		}
// 		apc_store($key, $components, 600);
// 	}

	return $components;
}

function select_component_by_id($id) {
// 	$key = 'select_component_by_id/'.$id;
// 	if(!($component = apc_fetch($key))) {
		$sql = 'SELECT * '
		. 'FROM cms_components '
		. 'WHERE cpt_id = '.quote_smart($id);
		$pqConn = db_connect();
		$component = null;
		$result = null;

		$result = pg_query($pqConn, $sql);
		if (!$result) {
			error("pg : ".$sql);
		} else {
			$component = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			pg_freeresult($result);
		}
// 		apc_store($key, $component, 600);
// 	}

	return $component;
}

function select_pages_by_group($siteId, $group) {
// 	$key = 'select_pages_by_group/'.$siteId.'/'.$group;
// 	if(!($pages = apc_fetch($key))) {
		$sql = 'SELECT *
	    		FROM cms_pages
	    		WHERE pge_site_id = '.quote_smart($siteId).'
	    		  AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
	    		  	   OR (pge_status = '.PAGE_STATUS_PLANNED.'
	    		  	       AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
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
			pg_freeresult($result);
		}
// 		apc_store($key, $pages, 600);
// 	}

	return $pages;
}

function select_page_by_group_and_lang($siteId, $group, $lang) {
// 	$key = 'select_page_by_group_and_lang/'.$siteId.'/'.$group.'/'.$lang;
// 	if(!($page = apc_fetch($key))) {
		$sql = 'SELECT *
	    		FROM cms_pages
	    		WHERE pge_site_id = '.quote_smart($siteId).'
	    		  AND pge_lang = '.quote_smart($lang).'
	    		  AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
	    		  	   OR (pge_status = '.PAGE_STATUS_PLANNED.'
	    		  	       AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
				  AND pge_group = '.quote_smart($group);
		$pqConn = db_connect();
		$page = null;
		$result = null;

		$result = pg_query($pqConn, $sql);
		if(!$result) {
			error("pg : ".$sql);
		} else {
			$page = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			pg_freeresult($result);
		}
// 		apc_store($key, $page, 600);
// 	}

	return $page;
}

function select_pages_by_lang($siteBase, $lang) {
// 	$key = 'select_pages_by_lang/'.$siteId.'/'.$lang;
// 	if(!($pages = apc_fetch($key))) {
		$sql = 'SELECT *
	    		FROM cms_pages, cms_domains
	    		WHERE dom_base = '.quote_smart($siteBase).'
	    		  AND pge_lang = '.quote_smart($lang).'
	    		  AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
	    		  	   OR (pge_status = '.PAGE_STATUS_PLANNED.'
	    		  	       AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
				ORDER BY pge_site_id DESC';
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
			pg_freeresult($result);
		}
// 		apc_store($key, $pages, 600);
// 	}

	return $pages;
}

// function select_menus_by_parent_and_lang_with_title($siteId, $parentGroup, $lang) {
// 	$sql = 'SELECT *
//             FROM menus
//             WHERE mnu_site_id = '.quote_smart($siteId) . '
// 	          AND mnu_parent_group = '.quote_smart($parentGroup).'
// 	          AND mnu_lang = '.quote_smart($lang).'
//             ORDER BY mnu_order';
// 	$pqConn = db_connect();
// 	$menus = array();
// 	$result = null;

// 	$result = pg_query($pqConn, $sql);
// 	if(!$result) {
// 		error("pg : ".$sql);
// 	} else {
// 		while($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
// 			$menus[] = $row;
// 		}
// 	}

// 	return $menus;
// }

function select_menu_pages_by_parent_and_lang($siteId, $parentGroup, $lang) {
// 	$key = 'select_menu_pages_by_parent_and_lang/'.$siteId.'/'.$parentGroup.'/'.$lang;
// 	if(!($pages = apc_fetch($key))) {
		$sql = 'SELECT *
	            FROM cms_pages
	            WHERE pge_site_id = '.quote_smart($siteId) . '
		          AND pge_parent_group = '.quote_smart($parentGroup).'
		          AND pge_lang = '.quote_smart($lang).'
		          AND pge_menu = true
	    		  AND (pge_status = '.PAGE_STATUS_PUBLISHED.'
	    		       OR (pge_status = '.PAGE_STATUS_PLANNED.'
	    		           AND pge_publish_date <= '.quote_smart(date('Y-m-d H:i:s', time())).' ))
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
// 		apc_store($key, $pages, 600);
// 	}

	return $pages;
}
?>
