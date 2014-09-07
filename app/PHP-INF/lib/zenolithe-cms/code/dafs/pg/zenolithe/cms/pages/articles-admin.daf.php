<?php
function insert_article($title, $content, $pageId, $type) {
    $result = null;
    $sql = 'INSERT INTO cms_articles
    		(art_title, art_content, art_page_id, art_type)
    		VALUES
    		(' . quote_smart($title) . ', ' . quote_smart($content) . ', ' . quote_smart($pageId) . ', ' . quote_smart($type) . ')
    		RETURNING art_id';
    $pqConn = db_connect();
    $id = 0;
    
    $result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		$tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$id = $tmp['art_id'];
		pg_freeresult($result);
	}

	return $id;
}

function update_article($id, $title, $content, $pageId, $type) {
    $result = null;
    $sql = 'UPDATE cms_articles
    		SET art_title =  ' . quote_smart($title) . ',
    		    art_content =  ' . quote_smart($content) . ',
    		    art_page_id = ' . quote_smart($pageId) . '
    		    art_type = ' . quote_smart($type) . '
    	WHERE art_id = '.quote_smart($id);
    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}
?>