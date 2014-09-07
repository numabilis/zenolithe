<?php
function select_article_by_page_id($pageId) {
    $sql = 'SELECT * FROM cms_articles WHERE art_page_id = '.quote_smart($pageId);
    $pqConn = db_connect();
    $article = null;
    $result = null;

    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        $article = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        pg_freeresult($result);
    }

    return $article;
}
?>
